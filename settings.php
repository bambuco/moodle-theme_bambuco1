<?php
// This file is part of Ranking block for Moodle - http://moodle.org/
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
 * Theme BambuCo 1 block settings file
 *
 * @package    theme_bambuco1
 * @copyright  2020 David Herney - https://bambuco.co
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

$settings = null;

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if (is_siteadmin()) {

    $orderoptions = array();
    for ($i = 0; $i <= 10; $i++) {
        $orderoptions[$i] = $i;
    }

    $ADMIN->add('themes', new admin_category('theme_bambuco1', 'BambuCo 1'));

    /*
    * ----------------------
    * General settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_bambuco1_general', get_string('generalsettings', 'theme_bambuco1'));

    // Logo file setting.
    $name = 'theme_bambuco1/logo';
    $title = get_string('logo', 'theme_bambuco1');
    $description = get_string('logodesc', 'theme_bambuco1');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Favicon setting.
    $name = 'theme_bambuco1/favicon';
    $title = get_string('favicon', 'theme_bambuco1');
    $description = get_string('favicondesc', 'theme_bambuco1');
    $opts = array('accepted_types' => array('.ico'), 'maxfiles' => 1);
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset.
    $name = 'theme_bambuco1/preset';
    $title = get_string('preset', 'theme_bambuco1');
    $description = get_string('preset_desc', 'theme_bambuco1');
    $default = 'default.scss';

    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_bambuco1', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_bambuco1/presetfiles';
    $title = get_string('presetfiles', 'theme_bambuco1');
    $description = get_string('presetfiles_desc', 'theme_bambuco1');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

    // Login page background image.
    $name = 'theme_bambuco1/loginbgimg';
    $title = get_string('loginbgimg', 'theme_bambuco1');
    $description = get_string('loginbgimg_desc', 'theme_bambuco1');
    $opts = array('accepted_types' => array('.png', '.jpg', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbgimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $brand-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_bambuco1/brandcolor';
    $title = get_string('brandcolor', 'theme_bambuco1');
    $description = get_string('brandcolor_desc', 'theme_bambuco1');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $navbar-header-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_bambuco1/navbarheadercolor';
    $title = get_string('navbarheadercolor', 'theme_bambuco1');
    $description = get_string('navbarheadercolor_desc', 'theme_bambuco1');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $navbar-bg.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_bambuco1/navbarbg';
    $title = get_string('navbarbg', 'theme_bambuco1');
    $description = get_string('navbarbg_desc', 'theme_bambuco1');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $navbar-bg-hover.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_bambuco1/navbarbghover';
    $title = get_string('navbarbghover', 'theme_bambuco1');
    $description = get_string('navbarbghover_desc', 'theme_bambuco1');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Course format option.
    $name = 'theme_bambuco1/coursepresentation';
    $title = get_string('coursepresentation', 'theme_bambuco1');
    $description = get_string('coursepresentationdesc', 'theme_bambuco1');
    $options = [];
    $options[1] = get_string('coursedefault', 'theme_bambuco1');
    $options[2] = get_string('coursecover', 'theme_bambuco1');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_bambuco1/courselistview';
    $title = get_string('courselistview', 'theme_bambuco1');
    $description = get_string('courselistviewdesc', 'theme_bambuco1');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $page->add($setting);

    // Google font family.
    $name = 'theme_bambuco1/googlefont';
    $title = get_string('googlefont', 'theme_bambuco1');
    $description = get_string('googlefont_desc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Secondary general menu.
    $name = 'theme_bambuco1/secondarymenu';
    $title = get_string('secondarymenu', 'theme_bambuco1');
    $description = get_string('secondarymenu_desc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $ADMIN->add('theme_bambuco1', $page);

    /*
    * ----------------------
    * Advanced settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_bambuco1_advanced', get_string('advancedsettings', 'theme_bambuco1'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_bambuco1/scsspre',
        get_string('rawscsspre', 'theme_bambuco1'), get_string('rawscsspre_desc', 'theme_bambuco1'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_bambuco1/scss', get_string('rawscss', 'theme_bambuco1'),
        get_string('rawscss_desc', 'theme_bambuco1'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Google analytics block.
    $name = 'theme_bambuco1/googleanalytics';
    $title = get_string('googleanalytics', 'theme_bambuco1');
    $description = get_string('googleanalyticsdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $ADMIN->add('theme_bambuco1', $page);

    /*
    * -----------------------
    * Frontpage settings tab
    * -----------------------
    */
    $page = new admin_settingpage('theme_bambuco1_frontpage', get_string('frontpagesettings', 'theme_bambuco1'));

    // Disable bottom footer.
    $name = 'theme_bambuco1/disablefrontpageloginbox';
    $title = get_string('disablefrontpageloginbox', 'theme_bambuco1');
    $description = get_string('disablefrontpageloginboxdesc', 'theme_bambuco1');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $page->add($setting);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Disable teachers from cards.
    $name = 'theme_bambuco1/disableteacherspic';
    $title = get_string('disableteacherspic', 'theme_bambuco1');
    $description = get_string('disableteacherspicdesc', 'theme_bambuco1');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $page->add($setting);

    // Headerimg file setting.
    $name = 'theme_bambuco1/headerimg';
    $title = get_string('headerimg', 'theme_bambuco1');
    $description = get_string('headerimgdesc', 'theme_bambuco1');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Bannerheading.
    $name = 'theme_bambuco1/bannerheading';
    $title = get_string('bannerheading', 'theme_bambuco1');
    $description = get_string('bannerheadingdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Bannercontent.
    $name = 'theme_bambuco1/bannercontent';
    $title = get_string('bannercontent', 'theme_bambuco1');
    $description = get_string('bannercontentdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_bambuco1/displaymarketingbox';
    $title = get_string('displaymarketingbox', 'theme_bambuco1');
    $description = get_string('displaymarketingboxdesc', 'theme_bambuco1');
    $default = 1;
    $choices = array(0 => 'No', 1 => 'Yes');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Marketing1icon.
    $name = 'theme_bambuco1/marketing1icon';
    $title = get_string('marketing1icon', 'theme_bambuco1');
    $description = get_string('marketing1icondesc', 'theme_bambuco1');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing1icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1heading.
    $name = 'theme_bambuco1/marketing1heading';
    $title = get_string('marketing1heading', 'theme_bambuco1');
    $description = get_string('marketing1headingdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1subheading.
    $name = 'theme_bambuco1/marketing1subheading';
    $title = get_string('marketing1subheading', 'theme_bambuco1');
    $description = get_string('marketing1subheadingdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1content.
    $name = 'theme_bambuco1/marketing1content';
    $title = get_string('marketing1content', 'theme_bambuco1');
    $description = get_string('marketing1contentdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1url.
    $name = 'theme_bambuco1/marketing1url';
    $title = get_string('marketing1url', 'theme_bambuco1');
    $description = get_string('marketing1urldesc', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2icon.
    $name = 'theme_bambuco1/marketing2icon';
    $title = get_string('marketing2icon', 'theme_bambuco1');
    $description = get_string('marketing2icondesc', 'theme_bambuco1');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing2icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2heading.
    $name = 'theme_bambuco1/marketing2heading';
    $title = get_string('marketing2heading', 'theme_bambuco1');
    $description = get_string('marketing2headingdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2subheading.
    $name = 'theme_bambuco1/marketing2subheading';
    $title = get_string('marketing2subheading', 'theme_bambuco1');
    $description = get_string('marketing2subheadingdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2content.
    $name = 'theme_bambuco1/marketing2content';
    $title = get_string('marketing2content', 'theme_bambuco1');
    $description = get_string('marketing2contentdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2url.
    $name = 'theme_bambuco1/marketing2url';
    $title = get_string('marketing2url', 'theme_bambuco1');
    $description = get_string('marketing2urldesc', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3icon.
    $name = 'theme_bambuco1/marketing3icon';
    $title = get_string('marketing3icon', 'theme_bambuco1');
    $description = get_string('marketing3icondesc', 'theme_bambuco1');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing3icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3heading.
    $name = 'theme_bambuco1/marketing3heading';
    $title = get_string('marketing3heading', 'theme_bambuco1');
    $description = get_string('marketing3headingdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3subheading.
    $name = 'theme_bambuco1/marketing3subheading';
    $title = get_string('marketing3subheading', 'theme_bambuco1');
    $description = get_string('marketing3subheadingdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3content.
    $name = 'theme_bambuco1/marketing3content';
    $title = get_string('marketing3content', 'theme_bambuco1');
    $description = get_string('marketing3contentdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3url.
    $name = 'theme_bambuco1/marketing3url';
    $title = get_string('marketing3url', 'theme_bambuco1');
    $description = get_string('marketing3urldesc', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4icon.
    $name = 'theme_bambuco1/marketing4icon';
    $title = get_string('marketing4icon', 'theme_bambuco1');
    $description = get_string('marketing4icondesc', 'theme_bambuco1');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing4icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4heading.
    $name = 'theme_bambuco1/marketing4heading';
    $title = get_string('marketing4heading', 'theme_bambuco1');
    $description = get_string('marketing4headingdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4subheading.
    $name = 'theme_bambuco1/marketing4subheading';
    $title = get_string('marketing4subheading', 'theme_bambuco1');
    $description = get_string('marketing4subheadingdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4content.
    $name = 'theme_bambuco1/marketing4content';
    $title = get_string('marketing4content', 'theme_bambuco1');
    $description = get_string('marketing4contentdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4url.
    $name = 'theme_bambuco1/marketing4url';
    $title = get_string('marketing4url', 'theme_bambuco1');
    $description = get_string('marketing4urldesc', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Enable or disable Slideshow settings.
    $name = 'theme_bambuco1/sliderenabled';
    $title = get_string('sliderenabled', 'theme_bambuco1');
    $description = get_string('sliderenableddesc', 'theme_bambuco1');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $page->add($setting);

    // Enable slideshow on frontpage guest page.
    $name = 'theme_bambuco1/sliderfrontpage';
    $title = get_string('sliderfrontpage', 'theme_bambuco1');
    $description = get_string('sliderfrontpagedesc', 'theme_bambuco1');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);

    $name = 'theme_bambuco1/slidercount';
    $title = get_string('slidercount', 'theme_bambuco1');
    $description = get_string('slidercountdesc', 'theme_bambuco1');
    $default = 1;
    $options = array();
    for ($i = 0; $i < 13; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // If we don't have an slide yet, default to the preset.
    $slidercount = get_config('theme_bambuco1', 'slidercount');

    if (!$slidercount) {
        $slidercount = 1;
    }

    for ($sliderindex = 1; $sliderindex <= $slidercount; $sliderindex++) {
        $fileid = 'sliderimage' . $sliderindex;
        $name = 'theme_bambuco1/sliderimage' . $sliderindex;
        $title = get_string('sliderimage', 'theme_bambuco1');
        $description = get_string('sliderimagedesc', 'theme_bambuco1');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_bambuco1/slidertitle' . $sliderindex;
        $title = get_string('slidertitle', 'theme_bambuco1');
        $description = get_string('slidertitledesc', 'theme_bambuco1');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
        $page->add($setting);

        $name = 'theme_bambuco1/sliderlink' . $sliderindex;
        $title = get_string('sliderlink', 'theme_bambuco1');
        $description = get_string('sliderlinkdesc', 'theme_bambuco1');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
        $page->add($setting);

        $name = 'theme_bambuco1/slidercap' . $sliderindex;
        $title = get_string('slidercaption', 'theme_bambuco1');
        $description = get_string('slidercaptiondesc', 'theme_bambuco1');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $page->add($setting);
    }

    // Enable or disable Slideshow settings.
    $name = 'theme_bambuco1/numbersfrontpage';
    $title = get_string('numbersfrontpage', 'theme_bambuco1');
    $description = get_string('numbersfrontpagedesc', 'theme_bambuco1');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);

    // Enable sponsors on frontpage guest page.
    $name = 'theme_bambuco1/sponsorsfrontpage';
    $title = get_string('sponsorsfrontpage', 'theme_bambuco1');
    $description = get_string('sponsorsfrontpagedesc', 'theme_bambuco1');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);

    $name = 'theme_bambuco1/sponsorstitle';
    $title = get_string('sponsorstitle', 'theme_bambuco1');
    $description = get_string('sponsorstitledesc', 'theme_bambuco1');
    $default = get_string('sponsorstitledefault', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_bambuco1/sponsorssubtitle';
    $title = get_string('sponsorssubtitle', 'theme_bambuco1');
    $description = get_string('sponsorssubtitledesc', 'theme_bambuco1');
    $default = get_string('sponsorssubtitledefault', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_bambuco1/sponsorscount';
    $title = get_string('sponsorscount', 'theme_bambuco1');
    $description = get_string('sponsorscountdesc', 'theme_bambuco1');
    $default = 1;
    $options = array();
    for ($i = 0; $i < 5; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // If we don't have an slide yet, default to the preset.
    $sponsorscount = get_config('theme_bambuco1', 'sponsorscount');

    if (!$sponsorscount) {
        $sponsorscount = 1;
    }

    for ($sponsorsindex = 1; $sponsorsindex <= $sponsorscount; $sponsorsindex++) {
        $fileid = 'sponsorsimage' . $sponsorsindex;
        $name = 'theme_bambuco1/sponsorsimage' . $sponsorsindex;
        $title = get_string('sponsorsimage', 'theme_bambuco1');
        $description = get_string('sponsorsimagedesc', 'theme_bambuco1');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_bambuco1/sponsorsurl' . $sponsorsindex;
        $title = get_string('sponsorsurl', 'theme_bambuco1');
        $description = get_string('sponsorsurldesc', 'theme_bambuco1');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
        $page->add($setting);
    }

    // Enable clients on frontpage guest page.
    $name = 'theme_bambuco1/clientsfrontpage';
    $title = get_string('clientsfrontpage', 'theme_bambuco1');
    $description = get_string('clientsfrontpagedesc', 'theme_bambuco1');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);

    $name = 'theme_bambuco1/clientstitle';
    $title = get_string('clientstitle', 'theme_bambuco1');
    $description = get_string('clientstitledesc', 'theme_bambuco1');
    $default = get_string('clientstitledefault', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_bambuco1/clientssubtitle';
    $title = get_string('clientssubtitle', 'theme_bambuco1');
    $description = get_string('clientssubtitledesc', 'theme_bambuco1');
    $default = get_string('clientssubtitledefault', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_bambuco1/clientscount';
    $title = get_string('clientscount', 'theme_bambuco1');
    $description = get_string('clientscountdesc', 'theme_bambuco1');
    $default = 1;
    $options = array();
    for ($i = 0; $i < 5; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // If we don't have an slide yet, default to the preset.
    $clientscount = get_config('theme_bambuco1', 'clientscount');

    if (!$clientscount) {
        $clientscount = 1;
    }

    for ($clientsindex = 1; $clientsindex <= $clientscount; $clientsindex++) {
        $fileid = 'clientsimage' . $clientsindex;
        $name = 'theme_bambuco1/clientsimage' . $clientsindex;
        $title = get_string('clientsimage', 'theme_bambuco1');
        $description = get_string('clientsimagedesc', 'theme_bambuco1');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_bambuco1/clientsurl' . $clientsindex;
        $title = get_string('clientsurl', 'theme_bambuco1');
        $description = get_string('clientsurldesc', 'theme_bambuco1');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
        $page->add($setting);
    }

    $ADMIN->add('theme_bambuco1', $page);

    /*
    * -----------------------
    * News settings tab
    * -----------------------
    */
    $page = new admin_settingpage('theme_bambuco1_news', get_string('newssettings', 'theme_bambuco1'));

    for ($newsindex = 1; $newsindex <= 10; $newsindex++) {
        $name = 'theme_bambuco1/newsorder' . $newsindex;
        $title = get_string('newsorder', 'theme_bambuco1');
        $description = get_string('newsorderdesc', 'theme_bambuco1');
        $default = 0;
        $setting = new admin_setting_configselect($name, $title, $description, $default, $orderoptions);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $fileid = 'newsimage' . $newsindex;
        $name = 'theme_bambuco1/newsimage' . $newsindex;
        $title = get_string('newsimage', 'theme_bambuco1');
        $description = get_string('newsimagedesc', 'theme_bambuco1');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_bambuco1/newslink' . $newsindex;
        $title = get_string('newslink', 'theme_bambuco1');
        $description = get_string('newslinkdesc', 'theme_bambuco1');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $page->add($setting);

        $name = 'theme_bambuco1/newstext' . $newsindex;
        $title = get_string('newstext', 'theme_bambuco1');
        $description = get_string('newstextdesc', 'theme_bambuco1');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);
    }

    $ADMIN->add('theme_bambuco1', $page);

    /*
    * -----------------------
    * Event settings tab
    * -----------------------
    */
    $page = new admin_settingpage('theme_bambuco1_events', get_string('eventssettings', 'theme_bambuco1'));

    for ($eventindex = 1; $eventindex <= 10; $eventindex++) {
        $name = 'theme_bambuco1/eventorder' . $eventindex;
        $title = get_string('eventorder', 'theme_bambuco1');
        $description = get_string('eventorderdesc', 'theme_bambuco1');
        $default = 0;
        $setting = new admin_setting_configselect($name, $title, $description, $default, $orderoptions);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $fileid = 'eventicon' . $eventindex;
        $name = 'theme_bambuco1/eventicon' . $eventindex;
        $title = get_string('eventicon', 'theme_bambuco1');
        $description = get_string('eventicondesc', 'theme_bambuco1');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $fileid = 'eventimage' . $eventindex;
        $name = 'theme_bambuco1/eventimage' . $eventindex;
        $title = get_string('eventimage', 'theme_bambuco1');
        $description = get_string('eventimagedesc', 'theme_bambuco1');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_bambuco1/eventlink' . $eventindex;
        $title = get_string('eventlink', 'theme_bambuco1');
        $description = get_string('eventlinkdesc', 'theme_bambuco1');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $page->add($setting);

        $name = 'theme_bambuco1/eventtext' . $eventindex;
        $title = get_string('eventtext', 'theme_bambuco1');
        $description = get_string('eventtextdesc', 'theme_bambuco1');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

        $name = 'theme_bambuco1/eventcolor' . $eventindex;
        $title = get_string('eventcolor', 'theme_bambuco1');
        $description = get_string('eventcolordesc', 'theme_bambuco1');
        $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
    }

    $ADMIN->add('theme_bambuco1', $page);

    /*
    * -----------------------
    * Documents settings tab
    * -----------------------
    */
    $page = new admin_settingpage('theme_bambuco1_document', get_string('documentssettings', 'theme_bambuco1'));

    for ($documentindex = 1; $documentindex <= 10; $documentindex++) {
        $name = 'theme_bambuco1/documentorder' . $documentindex;
        $title = get_string('documentorder', 'theme_bambuco1');
        $description = get_string('documentorderdesc', 'theme_bambuco1');
        $default = 0;
        $setting = new admin_setting_configselect($name, $title, $description, $default, $orderoptions);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $fileid = 'documenticon' . $documentindex;
        $name = 'theme_bambuco1/documenticon' . $documentindex;
        $title = get_string('documenticon', 'theme_bambuco1');
        $description = get_string('documenticondesc', 'theme_bambuco1');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_bambuco1/documenticontext' . $documentindex;
        $title = get_string('documenticontext', 'theme_bambuco1');
        $description = get_string('documenticontextdesc', 'theme_bambuco1');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

        $name = 'theme_bambuco1/documentlink' . $documentindex;
        $title = get_string('documentlink', 'theme_bambuco1');
        $description = get_string('documentlinkdesc', 'theme_bambuco1');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $page->add($setting);

        $name = 'theme_bambuco1/documentname' . $documentindex;
        $title = get_string('documentname', 'theme_bambuco1');
        $description = get_string('documentnamedesc', 'theme_bambuco1');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

        $name = 'theme_bambuco1/documenttext' . $documentindex;
        $title = get_string('documenttext', 'theme_bambuco1');
        $description = get_string('documenttextdesc', 'theme_bambuco1');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);

        $name = 'theme_bambuco1/documenttype' . $documentindex;
        $title = get_string('documenttype', 'theme_bambuco1');
        $description = get_string('documenttypedesc', 'theme_bambuco1');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);
    }

    $ADMIN->add('theme_bambuco1', $page);

    /*
    * --------------------
    * Footer settings tab
    * --------------------
    */
    $page = new admin_settingpage('theme_bambuco1_footer', get_string('footersettings', 'theme_bambuco1'));

    $name = 'theme_bambuco1/getintouchcontent';
    $title = get_string('getintouchcontent', 'theme_bambuco1');
    $description = get_string('getintouchcontentdesc', 'theme_bambuco1');
    $default = 'bambuco.co';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Map info.
    $name = 'theme_bambuco1/mapurl';
    $title = get_string('mapurl', 'theme_bambuco1');
    $description = get_string('mapurldesc', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $page->add($setting);

    // URL contact form.
    $name = 'theme_bambuco1/urlcontactform';
    $title = get_string('urlcontactform', 'theme_bambuco1');
    $description = get_string('urlcontactformdesc', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $page->add($setting);

    // Contact form captcha.
    $name = 'theme_bambuco1/captchacontactform';
    $title = get_string('captchacontactform', 'theme_bambuco1');
    $description = get_string('captchacontactformdesc', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Build address.
    $name = 'theme_bambuco1/address';
    $title = get_string('address', 'theme_bambuco1');
    $description = get_string('addressdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Website.
    $name = 'theme_bambuco1/website';
    $title = get_string('website', 'theme_bambuco1');
    $description = get_string('websitedesc', 'theme_bambuco1');
    $default = 'https://bambuco.co';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Mobile.
    $name = 'theme_bambuco1/mobile';
    $title = get_string('mobile', 'theme_bambuco1');
    $description = get_string('mobiledesc', 'theme_bambuco1');
    $default = 'Mobile : +54 (07) 00123-45678';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Mail.
    $name = 'theme_bambuco1/mail';
    $title = get_string('mail', 'theme_bambuco1');
    $description = get_string('maildesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Facebook url setting.
    $name = 'theme_bambuco1/facebook';
    $title = get_string('facebook', 'theme_bambuco1');
    $description = get_string('facebookdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Twitter url setting.
    $name = 'theme_bambuco1/twitter';
    $title = get_string('twitter', 'theme_bambuco1');
    $description = get_string('twitterdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Linkdin url setting.
    $name = 'theme_bambuco1/linkedin';
    $title = get_string('linkedin', 'theme_bambuco1');
    $description = get_string('linkedindesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Youtube url setting.
    $name = 'theme_bambuco1/youtube';
    $title = get_string('youtube', 'theme_bambuco1');
    $description = get_string('youtubedesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Instagram url setting.
    $name = 'theme_bambuco1/instagram';
    $title = get_string('instagram', 'theme_bambuco1');
    $description = get_string('instagramdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Whatsapp url setting.
    $name = 'theme_bambuco1/whatsapp';
    $title = get_string('whatsapp', 'theme_bambuco1');
    $description = get_string('whatsappdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // App store.
    $name = 'theme_bambuco1/appstore';
    $title = get_string('appstore', 'theme_bambuco1');
    $description = get_string('appstoredesc', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $page->add($setting);

    // Google play.
    $name = 'theme_bambuco1/googleplay';
    $title = get_string('googleplay', 'theme_bambuco1');
    $description = get_string('googleplaydesc', 'theme_bambuco1');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $page->add($setting);

    // Top footer image.
    $name = 'theme_bambuco1/topfooterimg';
    $title = get_string('topfooterimg', 'theme_bambuco1');
    $description = get_string('topfooterimgdesc', 'theme_bambuco1');
    $opts = array('accepted_types' => array('.png', '.jpg', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'topfooterimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Recommendation.
    $name = 'theme_bambuco1/recommendations';
    $title = get_string('recommendations', 'theme_bambuco1');
    $description = get_string('recommendationsdesc', 'theme_bambuco1');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $page->add($setting);

    $ADMIN->add('theme_bambuco1', $page);

    // Forum page.
    $page = new admin_settingpage('theme_bambuco1_forum', get_string('forumsettings', 'theme_bambuco1'));

    $page->add(new admin_setting_heading('theme_bambuco1_forumheading', null,
            format_text(get_string('forumsettingsdesc', 'theme_bambuco1'), FORMAT_MARKDOWN)));

    // Enable custom template.
    $name = 'theme_bambuco1/forumcustomtemplate';
    $title = get_string('forumcustomtemplate', 'theme_bambuco1');
    $description = get_string('forumcustomtemplatedesc', 'theme_bambuco1');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);

    // Header setting.
    $name = 'theme_bambuco1/forumhtmlemailheader';
    $title = get_string('forumhtmlemailheader', 'theme_bambuco1');
    $description = get_string('forumhtmlemailheaderdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $page->add($setting);

    // Footer setting.
    $name = 'theme_bambuco1/forumhtmlemailfooter';
    $title = get_string('forumhtmlemailfooter', 'theme_bambuco1');
    $description = get_string('forumhtmlemailfooterdesc', 'theme_bambuco1');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $page->add($setting);

    $ADMIN->add('theme_bambuco1', $page);
}
