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
 * Engagement metrics service.
 *
 * @package    local_pyu_analytics
 * @copyright  2025 Phu Yen University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class engagement {

    /**
     * Rebuild daily activity metrics.
     */
    public function rebuild_daily_metrics(): void {
        global $DB;

        $now = time();
        $from = $now - (7 * DAYSECS);
        $tablename = 'local_pyu_analytics_daily';
        $unittable = 'local_pyu_analytics_unit';
        $coursetable = 'local_pyu_analytics_course_unit';

        if (!$DB->get_manager()->table_exists('logstore_standard_log')) {
            return;
        }
        if (!$DB->get_manager()->table_exists($coursetable)) {
            return;
        }

        $studentroleid = $DB->get_field('role', 'id', ['shortname' => 'student']);
        if (!$studentroleid) {
            return;
        }

        $day = (int) date('Ymd', $from);
        $endday = (int) date('Ymd', $now);

        while ($day <= $endday) {
            $daystart = strtotime((string) $day . ' 00:00:00');
            $dayend = $daystart + DAYSECS - 1;

            $sql = "SELECT l.courseid, cu.unitid,
                           COUNT(DISTINCT l.userid) AS activeusers,
                           SUM(CASE WHEN l.target = 'user' AND l.action = 'loggedin' THEN 1 ELSE 0 END) AS logins,
                           SUM(CASE WHEN l.action = 'viewed' THEN 1 ELSE 0 END) AS views,
                           SUM(CASE WHEN l.action LIKE '%submitted%' OR l.action = 'submitted' THEN 1 ELSE 0 END) AS submissions
                    FROM {logstore_standard_log} l
                    JOIN {local_pyu_analytics_course_unit} cu ON cu.courseid = l.courseid
                    JOIN {role_assignments} ra ON ra.userid = l.userid AND ra.contextid IN (
                        SELECT id FROM {context} WHERE contextlevel = 50 AND instanceid = l.courseid
                    )
                    WHERE l.timecreated BETWEEN :start AND :end
                      AND l.userid > 0
                      AND l.courseid > 1
                      AND ra.roleid = :roleid
                    GROUP BY l.courseid, cu.unitid";
            $params = ['start' => $daystart, 'end' => $dayend, 'roleid' => $studentroleid];

            $rows = $DB->get_records_sql($sql, $params);

            foreach ($rows as $row) {
                $existing = $DB->get_record($tablename, [
                    'daydate' => $day,
                    'courseid' => $row->courseid,
                    'unitid' => $row->unitid,
                    'roletype' => 'student',
                ]);
                $record = (object) [
                    'daydate' => $day,
                    'courseid' => $row->courseid,
                    'unitid' => $row->unitid,
                    'roletype' => 'student',
                    'activeusers' => (int) $row->activeusers,
                    'logins' => (int) $row->logins,
                    'views' => (int) $row->views,
                    'submissions' => (int) $row->submissions,
                    'timemodified' => $now,
                ];
                if ($existing) {
                    $record->id = $existing->id;
                    $DB->update_record($tablename, $record);
                } else {
                    $record->timecreated = $now;
                    $DB->insert_record($tablename, $record);
                }
            }
            $day = (int) date('Ymd', strtotime('+1 day', $daystart));
        }
    }
}
