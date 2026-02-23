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
 * @package   theme_phuyen
 * @copyright 2025 Phu Yen University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingphuyen', get_string('configtitle', 'theme_phuyen'));
    $page = new admin_settingpage('theme_phuyen_general', get_string('generalsettings', 'theme_boost'));

    $name = 'theme_phuyen/heroheading';
    $title = get_string('heroheading', 'theme_phuyen');
    $description = get_string('heroheadingdesc', 'theme_phuyen');
    $default = 'Đại học Phú Yên';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_phuyen/herosubheading';
    $title = get_string('herosubheading', 'theme_phuyen');
    $description = get_string('herosubheadingdesc', 'theme_phuyen');
    $default = 'Phu Yen University - Excellence in Education';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_phuyen/ctaprimary';
    $title = get_string('ctaprimary', 'theme_phuyen');
    $description = get_string('ctaprimarydesc', 'theme_phuyen');
    $default = get_string('ctaprimarydefault', 'theme_phuyen');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_phuyen/ctasecondary';
    $title = get_string('ctasecondary', 'theme_phuyen');
    $description = get_string('ctasecondarydesc', 'theme_phuyen');
    $default = get_string('ctasecondarydefault', 'theme_phuyen');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $setting = new admin_setting_scsscode('theme_phuyen/scsspre',
        get_string('rawscsspre', 'theme_boost'), get_string('rawscsspre_desc', 'theme_boost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $setting = new admin_setting_scsscode('theme_phuyen/scss',
        get_string('rawscss', 'theme_boost'), get_string('rawscss_desc', 'theme_boost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
