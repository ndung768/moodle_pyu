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
 * @package    theme_phuyen
 * @copyright  2025 Phu Yen University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Get main SCSS content.
 *
 * @param theme_config $theme Theme config object.
 * @return string
 */
function theme_phuyen_get_main_scss_content($theme) {
    global $CFG;
    $path = $CFG->dirroot . '/theme/phuyen/scss/phuyen.scss';
    if (!file_exists($path)) {
        $path = $CFG->dirroot . '/public/theme/phuyen/scss/phuyen.scss';
    }
    return file_exists($path) ? file_get_contents($path) : '';
}

/**
 * Get pre SCSS.
 *
 * @param theme_config $theme Theme config object.
 * @return string
 */
function theme_phuyen_get_pre_scss($theme) {
    $scss = '';
    $scss .= '$phuyen-primary-blue: #3F4594 !default;' . "\n";
    $scss .= '$phuyen-primary-red: #EF2B2D !default;' . "\n";
    $scss .= '$phuyen-bg-light: #F3F5FF !default;' . "\n";
    $scss .= '$phuyen-text-dark: #1E2238 !default;' . "\n";
    $scss .= '$phuyen-success: #16A34A !default;' . "\n";
    $scss .= '$phuyen-warning: #F59E0B !default;' . "\n";
    $scss .= '$primary: $phuyen-primary-blue !default;' . "\n";
    $scss .= '$danger: $phuyen-primary-red !default;' . "\n";
    $scss .= '$success: $phuyen-success !default;' . "\n";
    $scss .= '$warning: $phuyen-warning !default;' . "\n";
    if (defined('BEHAT_SITE_RUNNING')) {
        $scss .= "\$behatsite: true;\n";
    }
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }
    return $scss;
}

/**
 * Get extra SCSS.
 *
 * @param theme_config $theme Theme config object.
 * @return string
 */
function theme_phuyen_get_extra_scss($theme) {
    return !empty($theme->settings->scss) ? $theme->settings->scss : '';
}

/**
 * Get precompiled CSS.
 *
 * @return string
 */
function theme_phuyen_get_precompiled_css() {
    global $CFG;
    $path = $CFG->dirroot . '/theme/phuyen/style/moodle.css';
    if (!file_exists($path)) {
        $path = $CFG->dirroot . '/public/theme/phuyen/style/moodle.css';
    }
    if (file_exists($path)) {
        return file_get_contents($path);
    }
    return theme_boost_get_precompiled_css();
}
