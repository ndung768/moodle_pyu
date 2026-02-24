<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT WARRANTY of any kind.
//
// Minimal maintenance layout - avoids theme_boost/loader and footer-popover JS
// which can cause "addEventListener of null" on upgradesettings.php.
//
// @package   theme_pyu
// @copyright 2025 Phu Yen University
// @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

defined('MOODLE_INTERNAL') || die();

echo $OUTPUT->doctype();
echo '<html ' . $OUTPUT->htmlattributes() . '>';
echo '<head>';
echo '<title>' . $OUTPUT->page_title() . '</title>';
echo '<link rel="shortcut icon" href="' . $OUTPUT->favicon() . '">';
echo $OUTPUT->standard_head_html();
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '</head>';
echo '<body ' . $OUTPUT->body_attributes() . '>';
echo $OUTPUT->standard_top_of_body_html();
echo '<div id="page-wrapper"><div id="page" class="container pb-3">';
echo '<div class="row"><div class="col-12 py-3 page-header-headings">';
echo $OUTPUT->page_heading();
echo '</div></div>';
echo '<div id="page-content" class="row"><div id="region-main" class="col-12">';
echo $OUTPUT->main_content();
echo '</div></div>';
echo '</div></div>';
echo $OUTPUT->standard_end_of_body_html();
echo '</body></html>';
