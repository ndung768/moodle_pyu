<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * PYU Theme - Enterprise settings
 *
 * @package   theme_pyu
 * @copyright 2025 Phu Yen University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingpyu', get_string('configtitle', 'theme_pyu'));

    // General.
    $page = new admin_settingpage('theme_pyu_general', get_string('generalsettings', 'theme_boost'));

    // Logo.
    $name = 'theme_pyu/logo';
    $title = get_string('logo', 'theme_pyu');
    $description = get_string('logodesc', 'theme_pyu');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Primary colour.
    $name = 'theme_pyu/primarycolour';
    $title = get_string('primarycolour', 'theme_pyu');
    $description = get_string('primarycolourdesc', 'theme_pyu');
    $default = '#3F4594';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, null);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Hero section.
    $name = 'theme_pyu/heroheading';
    $title = get_string('heroheading', 'theme_pyu');
    $description = get_string('heroheadingdesc', 'theme_pyu');
    $default = 'Trường Đại học Phú Yên';
    $page->add(new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT));

    $name = 'theme_pyu/herosubheading';
    $title = get_string('herosubheading', 'theme_pyu');
    $description = get_string('herosubheadingdesc', 'theme_pyu');
    $default = 'Phu Yen University - Excellence in Education';
    $page->add(new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT));

    // Sidebar.
    $name = 'theme_pyu/sidebarcollapsedefault';
    $title = get_string('sidebarcollapsedefault', 'theme_pyu');
    $description = get_string('sidebarcollapsedefaultdesc', 'theme_pyu');
    $default = false;
    $page->add(new admin_setting_configcheckbox($name, $title, $description, $default));

    // Dark mode toggle.
    $name = 'theme_pyu/enabledarkmode';
    $title = get_string('enabledarkmode', 'theme_pyu');
    $description = get_string('enabledarkmodedesc', 'theme_pyu');
    $default = false;
    $page->add(new admin_setting_configcheckbox($name, $title, $description, $default));

    // Dashboard layout.
    $name = 'theme_pyu/dashboardlayout';
    $title = get_string('dashboardlayout', 'theme_pyu');
    $description = get_string('dashboardlayoutdesc', 'theme_pyu');
    $choices = [
        'cards' => get_string('dashboardlayoutcards', 'theme_pyu'),
        'list' => get_string('dashboardlayoutlist', 'theme_pyu'),
    ];
    $page->add(new admin_setting_configselect($name, $title, $description, 'cards', $choices));

    // Raw SCSS.
    $setting = new admin_setting_scsscode('theme_pyu/scsspre',
        get_string('rawscsspre', 'theme_boost'), get_string('rawscsspre_desc', 'theme_boost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $setting = new admin_setting_scsscode('theme_pyu/scss',
        get_string('rawscss', 'theme_boost'), get_string('rawscss_desc', 'theme_boost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
