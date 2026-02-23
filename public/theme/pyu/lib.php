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
 * Phu Yen University theme functions.
 *
 * @package    theme_pyu
 * @copyright  2025 Phu Yen University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Get the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_pyu_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $scss .= file_get_contents($CFG->dirroot . '/theme/pyu/scss/preset/default.scss');

    return $scss;
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_pyu_get_pre_scss($theme) {
    $scss = '';

    // PYU brand variables (override Bootstrap).
    $scss .= '$pyu-primary-blue: #3F4594 !default;' . "\n";
    $scss .= '$pyu-primary-red: #EF2B2D !default;' . "\n";
    $scss .= '$primary: $pyu-primary-blue !default;' . "\n";
    $scss .= '$danger: $pyu-primary-red !default;' . "\n";

    if (defined('BEHAT_SITE_RUNNING')) {
        $scss .= "\$behatsite: true;\n";
    }

    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    return $scss;
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_pyu_get_extra_scss($theme) {
    $content = '';

    if (!empty($theme->settings->scss)) {
        $content .= $theme->settings->scss;
    }

    return $content;
}

/**
 * Get compiled css.
 *
 * @return string compiled css
 */
function theme_pyu_get_precompiled_css() {
    global $CFG;
    $path = $CFG->dirroot . '/theme/pyu/style/moodle.css';
    if (file_exists($path)) {
        return file_get_contents($path);
    }
    return theme_boost_get_precompiled_css();
}
