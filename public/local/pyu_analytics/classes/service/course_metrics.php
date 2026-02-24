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
 * Course metrics service.
 *
 * @package    local_pyu_analytics
 * @copyright  2025 Phu Yen University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_metrics {

    /**
     * Rebuild course-level aggregated metrics.
     */
    public function rebuild_course_metrics(): void {
        global $DB;

        $now = time();
        $periodstart = $now - (30 * DAYSECS);
        $tablename = 'local_pyu_analytics_course';
        $coursetable = 'local_pyu_analytics_course_unit';

        if (!$DB->get_manager()->table_exists($coursetable)) {
            return;
        }

        $mappings = $DB->get_records($coursetable);
        foreach ($mappings as $m) {
            $enrolled = $DB->count_records_sql(
                "SELECT COUNT(DISTINCT e.userid) FROM {enrol} en
                 JOIN {user_enrolments} e ON e.enrolid = en.id
                 WHERE en.courseid = :cid AND en.status = 0",
                ['cid' => $m->courseid]
            );
            $engagementrate = $enrolled > 0 ? 0 : 0;
            $activestudents = 0;
            if ($DB->get_manager()->table_exists('logstore_standard_log')) {
                $activestudents = $DB->count_records_sql(
                    "SELECT COUNT(DISTINCT userid) FROM {logstore_standard_log}
                     WHERE courseid = :cid AND timecreated >= :since AND userid > 0",
                    ['cid' => $m->courseid, 'since' => $periodstart]
                );
                $engagementrate = $enrolled > 0 ? round(100 * $activestudents / $enrolled, 2) : 0;
            }
            $assigncount = $DB->count_records('assign', ['course' => $m->courseid]);
            $quizcount = $DB->count_records('quiz', ['course' => $m->courseid]);

            $record = (object) [
                'courseid' => $m->courseid,
                'unitid' => $m->unitid,
                'periodstart' => $periodstart,
                'periodend' => $now,
                'enrolstudents' => $enrolled,
                'activestudents' => $activestudents,
                'engagementrate' => $engagementrate,
                'avgweeklylogins' => 0,
                'assignmentcount' => $assigncount,
                'quizcount' => $quizcount,
                'timemodified' => $now,
            ];
            $existing = $DB->get_record($tablename, [
                'courseid' => $m->courseid,
                'unitid' => $m->unitid,
                'periodstart' => $periodstart,
                'periodend' => $now,
            ]);
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
