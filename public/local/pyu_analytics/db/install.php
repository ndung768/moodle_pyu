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

defined('MOODLE_INTERNAL') || die();

function xmldb_local_pyu_analytics_install() {
    global $DB;

    $now = time();
    $default = (object) [
        'shortname' => 'default',
        'fullname' => 'Default Faculty',
        'unittype' => 'faculty',
        'parentid' => null,
        'timecreated' => $now,
        'timemodified' => $now,
    ];
    $DB->insert_record('local_pyu_analytics_unit', $default);

    $defaultunit = $DB->get_record('local_pyu_analytics_unit', ['shortname' => 'default']);
    foreach ($DB->get_records('course') as $course) {
        if ($course->id <= 1) {
            continue;
        }
        if (!$DB->record_exists('local_pyu_analytics_course_unit', ['courseid' => $course->id])) {
            $DB->insert_record('local_pyu_analytics_course_unit', (object) [
                'courseid' => $course->id,
                'unitid' => $defaultunit->id,
            ]);
        }
    }
}
