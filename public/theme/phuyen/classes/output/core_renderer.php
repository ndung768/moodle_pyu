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

/**
 * Phu Yen University core renderer.
 *
 * @package    theme_phuyen
 * @copyright  2025 Phu Yen University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_phuyen\output;

defined('MOODLE_INTERNAL') || die();

class core_renderer extends \theme_boost\output\core_renderer {

    /**
     * Renders the dashboard template with optional context.
     *
     * @param array $context Template context.
     * @return string HTML.
     */
    public function render_dashboard(array $context = []): string {
        return $this->render_from_template('theme_phuyen/dashboard', $context);
    }

    /**
     * Renders a course card.
     *
     * @param array $course Course data (name, url, progress).
     * @return string HTML.
     */
    public function render_coursecard(array $course): string {
        return $this->render_from_template('theme_phuyen/coursecard', $course);
    }
}
