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
 * A two column layout for the BambuCo 1 theme.
 *
 * @package   theme_bambuco1
 * @copyright 2020 David Herney - https://bambuco.co
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
user_preference_allow_ajax_update('sidepre-open', PARAM_ALPHA);

require_once($CFG->libdir . '/behat/lib.php');

if (isloggedin()) {
    $navdraweropen = (get_user_preferences('drawer-open-nav', 'true') == 'true');
    $draweropenright = (get_user_preferences('sidepre-open', 'true') == 'true');
} else {
    $navdraweropen = false;
    $draweropenright = false;
}

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;

$postblockshtml = $OUTPUT->blocks('side-post');
$topblockshtml = $OUTPUT->blocks('top');
$contentblockshtml = $OUTPUT->blocks('side-cont');
$hascontentblocks = strpos($contentblockshtml, 'data-block=') !== false;

$extraclasses = [];
if ($navdraweropen) {
    $extraclasses[] = 'drawer-open-left';
}

if ($draweropenright && $hasblocks) {
    $extraclasses[] = 'drawer-open-right';
}

$coursepresentation = theme_bambuco1_get_setting('coursepresentation');
if ($coursepresentation == 2) {
    $extraclasses[] = 'coursepresentation-cover';
}

$coursealerts = array();

if ($PAGE->course->visible == 0 && has_capability('moodle/course:update', context_course::instance($PAGE->course->id))) {
    $alert = new stdClass();
    $url = new moodle_url('/course/edit.php', array('id' => $PAGE->course->id));
    $alert->text = get_string('coursehidden', 'theme_bambuco1', (string)$url);
    $alert->icon = 'exclamation-triangle';
    $coursealerts[] = $alert;
}

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'sidepostblocks' => $postblockshtml,
    'topblocks' => $topblockshtml,
    'contentblocks' => $contentblockshtml,
    'hasblocks' => $hasblocks,
    'hascontentblocks' => $hascontentblocks,
    'bodyattributes' => $bodyattributes,
    'hasdrawertoggle' => true,
    'navdraweropen' => $navdraweropen,
    'draweropenright' => $draweropenright,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'editbutton' => theme_bambuco1_edit_button(),
    'coursealerts' => $coursealerts,
    'hascoursealerts' => count($coursealerts) > 0
];

// Improve boost navigation.
theme_bambuco1_extend_flat_navigation($PAGE->flatnav);

$templatecontext['flatnavigation'] = $PAGE->flatnav;

$themesettings = new \theme_bambuco1\util\theme_settings();

$templatecontext = array_merge($templatecontext, $themesettings->footer_items(), $themesettings->generalvars());

if (!$coursepresentation || $coursepresentation == 1) {
    echo $OUTPUT->render_from_template('theme_bambuco1/course', $templatecontext);
} else if ($coursepresentation == 2) {
    echo $OUTPUT->render_from_template('theme_bambuco1/course_cover', $templatecontext);
}
