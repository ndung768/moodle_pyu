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
 * PYU Theme - Enterprise Design System
 * Moodle 5.x functions
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
    $path = (isset($theme->dir) ? $theme->dir : '') . '/scss/preset/default.scss';
    $scss = @file_get_contents($path);
    return ($scss !== false && $scss !== '') ? $scss : "/* theme_pyu: preset file not found */\n";
}

/**
 * Get SCSS to prepend (variables from settings).
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_pyu_get_pre_scss($theme) {
    $scss = '';

    if (!empty($theme->settings->primarycolour)) {
        $scss .= '$primary: ' . $theme->settings->primarycolour . ";\n";
    }

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
 * Get precompiled CSS.
 *
 * @return string
 */
function theme_pyu_get_precompiled_css() {
    global $CFG;
    $path = $CFG->dirroot . '/theme/pyu/style/moodle.css';
    if (file_exists($path)) {
        return file_get_contents($path);
    }
    return theme_boost_get_precompiled_css();
}

/**
 * Serves theme files.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_pyu_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel == CONTEXT_SYSTEM &&
            ($filearea === 'logo' || $filearea === 'favicon' || $filearea === 'backgroundimage')) {
        $theme = theme_config::load('pyu');
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }
    return false;
}
