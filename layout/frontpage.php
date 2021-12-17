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
 * Frontpage layout for the BambuCo 1 theme.
 *
 * @package   theme_bambuco1
 * @copyright 2020 David Herney - https://bambuco.co
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
user_preference_allow_ajax_update('sidepre-open', PARAM_ALPHA);

require_once($CFG->libdir . '/behat/lib.php');

$extraclasses = [];

$themesettings = new \theme_bambuco1\util\theme_settings();

$imgappstore = $OUTPUT->image_url('app_store', 'theme');
$imggoogleplay = $OUTPUT->image_url('google_play', 'theme');
$hascontact = !empty(theme_bambuco1_get_setting('mapurl', '')) || !empty(theme_bambuco1_get_setting('getintouchcontent', ''));
$urlcontactform = theme_bambuco1_get_setting('urlcontactform', '');
$captchacontactform = theme_bambuco1_get_setting('captchacontactform', '');


$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$postblockshtml = $OUTPUT->blocks('side-post');
$topblockshtml = $OUTPUT->blocks('top');

$shoulddisplaymarketing = false;
if (theme_bambuco1_get_setting('displaymarketingbox', true) == true) {
    $shoulddisplaymarketing = true;
}

$enablemobile = $CFG->enablemobilewebservice || false;


$sliderfrontpage = false;
if ((theme_bambuco1_get_setting('sliderenabled', true) == true) && (theme_bambuco1_get_setting('sliderfrontpage', true) == true)) {
    $sliderfrontpage = true;
    $extraclasses[] = 'slideshow';
}

$numbersfrontpage = false;
if (theme_bambuco1_get_setting('numbersfrontpage', true) == true) {
    $numbersfrontpage = true;
}

$sponsorsfrontpage = false;
if (theme_bambuco1_get_setting('sponsorsfrontpage', true) == true) {
    $sponsorsfrontpage = true;
}

$clientsfrontpage = false;
if (theme_bambuco1_get_setting('clientsfrontpage', true) == true) {
    $clientsfrontpage = true;
}

$bannerheading = '';
if (!empty($PAGE->theme->settings->bannerheading)) {
    $bannerheading = theme_bambuco1_get_setting('bannerheading', true);
}

$bannercontent = '';
if (!empty($PAGE->theme->settings->bannercontent)) {
    $bannercontent = theme_bambuco1_get_setting('bannercontent', true);
}

$disablefrontpageloginbox = false;
if (theme_bambuco1_get_setting('disablefrontpageloginbox', true) == true) {
    $disablefrontpageloginbox = true;
    $extraclasses[] = 'disablefrontpageloginbox';
}

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'bodyattributes' => $bodyattributes,
    'hasdrawertoggle' => false,
    'sidepostblocks' => $postblockshtml,
    'topblocks' => $topblockshtml,
    'canloginasguest' => $CFG->guestloginbutton and !isguestuser(),
    'cansignup' => $CFG->registerauth == 'email' || !empty($CFG->registerauth),
    'bannerheading' => $bannerheading,
    'bannercontent' => $bannercontent,
    'shoulddisplaymarketing' => $shoulddisplaymarketing,
    'sliderfrontpage' => $sliderfrontpage,
    'numbersfrontpage' => $numbersfrontpage,
    'sponsorsfrontpage' => $sponsorsfrontpage,
    'clientsfrontpage' => $clientsfrontpage,
    'disablefrontpageloginbox' => $disablefrontpageloginbox,
    'logintoken' => \core\session\manager::get_login_token(),
    'imgappstore' => $imgappstore,
    'imggoogleplay' => $imggoogleplay,
    'imgiconlogin' => $OUTPUT->image_url('icon_login', 'theme'),
    'hascontact' => $hascontact,
    'urlcontactform' => $urlcontactform,
    'captchacontactform' => $captchacontactform,
    'enablemobile' => $enablemobile,
    'isloggedin' => isloggedin() && !isguestuser()
];

$templatecontext = array_merge($templatecontext, $themesettings->footer_items(),
                                $themesettings->marketing_items(), $themesettings->news_items(),
                                $themesettings->event_items(), $themesettings->document_items(),
                                $themesettings->generalvars());

if ($sliderfrontpage) {
    $templatecontext = array_merge($templatecontext, $themesettings->slideshow());
}

if ($numbersfrontpage) {
    $templatecontext = array_merge($templatecontext, $themesettings->numbers());
}

if ($sponsorsfrontpage) {
    $templatecontext = array_merge($templatecontext, $themesettings->sponsors());
}

if ($clientsfrontpage) {
    $templatecontext = array_merge($templatecontext, $themesettings->clients());
}

echo $OUTPUT->render_from_template('theme_bambuco1/frontpage_guest', $templatecontext);
