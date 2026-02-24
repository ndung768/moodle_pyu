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

namespace local_pyu_analytics\task;

defined('MOODLE_INTERNAL') || die();

/**
 * Scheduled task to rebuild PYU Analytics metrics.
 *
 * @package    local_pyu_analytics
 * @copyright  2025 Phu Yen University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class rebuild_metrics extends \core\task\scheduled_task {

    public function get_name() {
        return get_string('task_rebuild_metrics', 'local_pyu_analytics');
    }

    public function execute() {
        if (!get_config('local_pyu_analytics', 'version')) {
            return;
        }

        $engagement = new \local_pyu_analytics\service\engagement();
        $engagement->rebuild_daily_metrics();

        $course = new \local_pyu_analytics\service\course_metrics();
        $course->rebuild_course_metrics();

        $risk = new \local_pyu_analytics\service\risk();
        $risk->rebuild_risks();

        $dti = new \local_pyu_analytics\service\dti();
        $dti->rebuild_dti();
    }
}
