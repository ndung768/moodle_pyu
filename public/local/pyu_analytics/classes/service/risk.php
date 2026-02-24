<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace local_pyu_analytics\service;

defined('MOODLE_INTERNAL') || die();

/**
 * Risk detection service.
 *
 * @package    local_pyu_analytics
 * @copyright  2025 Phu Yen University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class risk {

    /**
     * Rebuild student risk scores.
     */
    public function rebuild_risks(): void {
        global $DB;

        $tablename = 'local_pyu_analytics_risk';
        $coursetable = 'local_pyu_analytics_course_unit';

        if (!$DB->get_manager()->table_exists($coursetable) || !$DB->get_manager()->table_exists('logstore_standard_log')) {
            return;
        }

        $studentroleid = $DB->get_field('role', 'id', ['shortname' => 'student']);
        if (!$studentroleid) {
            return;
        }

        $now = time();
        $cutoff = $now - (14 * DAYSECS);

        $contextcourse = CONTEXT_COURSE;
        $courses = $DB->get_records($coursetable);
        foreach ($courses as $cu) {
            $context = $DB->get_record('context', ['contextlevel' => $contextcourse, 'instanceid' => $cu->courseid]);
            if (!$context) {
                continue;
            }
            $userids = $DB->get_fieldset_sql(
                "SELECT DISTINCT userid FROM {role_assignments} WHERE roleid = ? AND contextid = ?",
                [$studentroleid, $context->id]
            );
            foreach ($userids as $userid) {
                $lastlog = $DB->get_field_sql(
                    "SELECT MAX(timecreated) FROM {logstore_standard_log} WHERE userid = ? AND courseid = ?",
                    [$userid, $cu->courseid]
                );
                $dayssince = $lastlog ? (int) (($now - $lastlog) / DAYSECS) : 999;
                $rlogin = $dayssince >= 14 ? 40 : ($dayssince >= 7 ? 20 : 0);
                $score = min(100, $rlogin + 0);
                $level = $score >= 60 ? 'high' : ($score >= 30 ? 'medium' : 'low');
                $reason = json_encode(['days_since_login' => $dayssince]);
                $record = (object) [
                    'userid' => $userid,
                    'courseid' => $cu->courseid,
                    'unitid' => $cu->unitid,
                    'snapshottime' => $now,
                    'riskscore' => $score,
                    'risklevel' => $level,
                    'reasonjson' => $reason,
                    'timemodified' => $now,
                ];
                $existing = $DB->get_record($tablename, ['userid' => $userid, 'courseid' => $cu->courseid]);
                if ($existing) {
                    $record->id = $existing->id;
                    $DB->update_record($tablename, $record);
                } else {
                    $record->timecreated = $now;
                    $DB->insert_record($tablename, $record);
                }
            }
        }
    }
}
