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
 * Phu Yen University theme settings.
 *
 * @package   theme_pyu
 * @copyright 2025 Phu Yen University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingpyu', get_string('configtitle', 'theme_pyu'));
    $page = new admin_settingpage('theme_pyu_general', get_string('generalsettings', 'theme_boost'));

    // Hero section heading.
    $name = 'theme_pyu/heroheading';
    $title = get_string('heroheading', 'theme_pyu');
    $description = get_string('heroheadingdesc', 'theme_pyu');
    $default = 'Trường Đại học Phú Yên';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    // Hero section subheading.
    $name = 'theme_pyu/herosubheading';
    $title = get_string('herosubheading', 'theme_pyu');
    $description = get_string('herosubheadingdesc', 'theme_pyu');
    $default = 'Phu Yen University - Excellence in Education';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_pyu/scsspre',
        get_string('rawscsspre', 'theme_boost'), get_string('rawscsspre_desc', 'theme_boost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_pyu/scss',
        get_string('rawscss', 'theme_boost'), get_string('rawscss_desc', 'theme_boost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
