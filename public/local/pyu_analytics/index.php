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

require_once('../../config.php');
require_once($CFG->libdir . '/adminlib.php');

require_login(null, false);
require_capability('local/pyu_analytics:view', context_system::instance());

admin_externalpage_setup('local_pyu_analytics', '', null, '/local/pyu_analytics/index.php');

$PAGE->set_title(get_string('analyticsdashboard', 'local_pyu_analytics'));
$PAGE->set_heading(get_string('analyticsdashboard', 'local_pyu_analytics'));

$kpis = [];
$engagementdata = [];
$risksummary = [];
$facultyrows = [];
$heatmapdata = [];

global $DB;
if ($DB->get_manager()->table_exists('local_pyu_analytics_unit')) {
    $active = 0;
    $total = 0;
    $atrisk = 0;
    $courses = 0;
    $now = time();
    $weekago = $now - (7 * DAYSECS);

    if ($DB->get_manager()->table_exists('logstore_standard_log')) {
        $active = $DB->count_records_sql(
            "SELECT COUNT(DISTINCT userid) FROM {logstore_standard_log}
             WHERE timecreated >= ? AND courseid > 1 AND userid > 0",
            [$weekago]
        );
    }
    $courses = $DB->count_records_select('course', 'id > ?', [1]);

    if ($DB->get_manager()->table_exists('local_pyu_analytics_risk')) {
        $atrisk = $DB->count_records('local_pyu_analytics_risk', ['risklevel' => 'high']);
        $medium = $DB->count_records('local_pyu_analytics_risk', ['risklevel' => 'medium']);
        $low = $DB->count_records('local_pyu_analytics_risk', ['risklevel' => 'low']);
        $risksummary = [
            ['label' => get_string('atriskstudents', 'local_pyu_analytics'), 'count' => $atrisk, 'level' => 'danger'],
            ['label' => get_string('mediumrisk', 'local_pyu_analytics'), 'count' => $medium, 'level' => 'warning'],
            ['label' => get_string('lowrisk', 'local_pyu_analytics'), 'count' => $low, 'level' => 'info'],
        ];
    }

    if ($DB->get_manager()->table_exists('local_pyu_analytics_daily')) {
        $last7 = $DB->get_records('local_pyu_analytics_daily', null, 'day DESC', '*', 0, 7);
        $engagementdata = ['labels' => [], 'values' => []];
        foreach (array_reverse($last7) as $row) {
            $engagementdata['labels'][] = userdate($row->day, get_string('strftimedateshort'));
            $engagementdata['values'][] = (int) $row->activeusers;
        }
    }

    if ($DB->get_manager()->table_exists('local_pyu_analytics_course')) {
        $topcourses = $DB->get_records('local_pyu_analytics_course', null, 'engagementrate DESC', '*', 0, 20);
        $heatmapdata = ['labels' => [], 'values' => []];
        foreach ($topcourses as $c) {
            $course = $DB->get_record('course', ['id' => $c->courseid], 'shortname', IGNORE_MISSING);
            $heatmapdata['labels'][] = $course ? format_string($course->shortname) : (string) $c->courseid;
            $heatmapdata['values'][] = (float) $c->engagementrate;
        }
    }

    $kpis = [
        ['id' => 'activestudents', 'label' => get_string('activestudents', 'local_pyu_analytics'), 'value' => $active, 'delta_percent' => null, 'delta_class' => '', 'delta_icon' => ''],
        ['id' => 'courses', 'label' => get_string('coursesrunning', 'local_pyu_analytics'), 'value' => $courses, 'delta_percent' => null, 'delta_class' => '', 'delta_icon' => ''],
        ['id' => 'atrisk', 'label' => get_string('atriskstudents', 'local_pyu_analytics'), 'value' => $atrisk, 'delta_percent' => null, 'delta_class' => 'text-danger', 'delta_icon' => ''],
    ];

    $units = $DB->get_records('local_pyu_analytics_unit', ['unittype' => 'faculty']);
    foreach ($units as $u) {
        $dti = $DB->get_record('local_pyu_analytics_dti', ['unitid' => $u->id], '*', IGNORE_MULTIPLE);
        $cnt = $DB->count_records('local_pyu_analytics_course_unit', ['unitid' => $u->id]);
        $eng = $dti ? $dti->engagementscore : 0;
        $facultyrows[] = [
            'fullname' => $u->fullname,
            'dtiscore' => $dti ? round($dti->dtiscore, 1) : '-',
            'engagementrate' => $eng,
            'coursecount' => $cnt,
        ];
    }
}

$dashboard = new \local_pyu_analytics\output\dashboard(
    $kpis,
    $engagementdata,
    $risksummary,
    $facultyrows,
    $heatmapdata
);

$output = $PAGE->get_renderer('local_pyu_analytics');
echo $output->header();
echo $output->render($dashboard);
echo $output->footer();
