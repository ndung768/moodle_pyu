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
 * Columns2 layout - Sidebar left + Main content.
 *
 * @package   theme_phuyen
 * @copyright 2025 Phu Yen University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes([]);
$blockspre = $OUTPUT->blocks('side-pre');
$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);

$renderer = $PAGE->get_renderer('core');
$header = $PAGE->activityheader;
$headercontent = $header->export_for_template($renderer);

$showhero = in_array($PAGE->pagelayout, ['mydashboard', 'frontpage', 'mycourses'], true);
$heroheading = $showhero ? get_config('theme_phuyen', 'heroheading') : '';
$herosubheading = $showhero ? get_config('theme_phuyen', 'herosubheading') : '';
$ctaprimary = $showhero ? get_config('theme_phuyen', 'ctaprimary') : '';
$ctasecondary = $showhero ? get_config('theme_phuyen', 'ctasecondary') : '';
if (empty($heroheading)) {
    $heroheading = get_string('sitename', 'theme_phuyen');
}
if (empty($herosubheading)) {
    $herosubheading = 'Phu Yen University - Excellence in Education';
}
if (empty($ctaprimary)) {
    $ctaprimary = get_string('ctaprimarydefault', 'theme_phuyen');
}
if (empty($ctasecondary)) {
    $ctasecondary = get_string('ctasecondarydefault', 'theme_phuyen');
}

$primary = new core\navigation\output\primary($PAGE);
$primarymenu = $primary->export_for_template($renderer);

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), 'escape' => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockspre,
    'haspreblocks' => $hassidepre,
    'bodyattributes' => $bodyattributes,
    'headercontent' => $headercontent,
    'showhero' => $showhero,
    'heroheading' => $heroheading,
    'herosubheading' => $herosubheading,
    'ctaprimary' => $ctaprimary,
    'ctasecondary' => $ctasecondary,
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'config' => [
        'wwwroot' => $CFG->wwwroot,
        'homeurl' => $CFG->wwwroot . '/my/',
    ],
];

echo $OUTPUT->render_from_template('theme_phuyen/columns2', $templatecontext);
