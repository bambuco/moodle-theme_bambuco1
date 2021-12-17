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
 * Theme functions.
 *
 * @package    theme_bambuco1
 * @copyright 2020 David Herney - https://bambuco.co
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_bambuco1_get_extra_scss($theme) {
    $scss = $theme->settings->scss;

    $scss .= theme_bambuco1_set_headerimg($theme);

    $scss .= theme_bambuco1_set_topfooterimg($theme);

    $scss .= theme_bambuco1_set_loginbgimg($theme);

    return $scss;
}

/**
 * Adds the cover to CSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_bambuco1_set_headerimg($theme) {
    global $OUTPUT;

    $headerimg = $theme->setting_file_url('headerimg', 'headerimg');

    if (is_null($headerimg)) {
        $headerimg = $OUTPUT->image_url('headerimg', 'theme');
    }

    $headercss = "#page-site-index #page-header {background-image: url('$headerimg');}";

    return $headercss;
}

/**
 * Adds the footer image to CSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_bambuco1_set_topfooterimg($theme) {
    global $OUTPUT;

    $topfooterimg = $theme->setting_file_url('topfooterimg', 'topfooterimg');

    if (is_null($topfooterimg)) {
        $topfooterimg = $OUTPUT->image_url('footer-bg', 'theme');
    }

    $headercss = "#top-footer {background-image: url('$topfooterimg');}";

    return $headercss;
}

/**
 * Adds the login page background image to CSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_bambuco1_set_loginbgimg($theme) {
    global $OUTPUT;

    $loginbgimg = $theme->setting_file_url('loginbgimg', 'loginbgimg');

    if (is_null($loginbgimg)) {
        $loginbgimg = $OUTPUT->image_url('login_bg', 'theme');
    }

    $headercss = "#page-login-index.bambuco1-login #page-wrapper #page {background-image: url('$loginbgimg');}";

    return $headercss;
}

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The parent theme config object.
 * @return string
 */
function theme_bambuco1_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = context_system::instance();
    if ($filename == 'default.scss') {
        // We still load the default preset files directly from the boost theme. No sense in duplicating them.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    } else if ($filename == 'plain.scss') {
        // We still load the default preset files directly from the boost theme. No sense in duplicating them.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');
    } else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_bambuco1', 'preset', 0, '/', $filename))) {
        // This preset file was fetched from the file area for theme_bambuco1 and not theme_boost (see the line above).
        $scss .= $presetfile->get_content();
    } else {
        // Safety fallback - maybe new installs etc.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }

    // BambuCo 1 scss.
    $bambuco1variables = file_get_contents($CFG->dirroot . '/theme/bambuco1/scss/bambuco1/_variables.scss');
    $bambuco1 = file_get_contents($CFG->dirroot . '/theme/bambuco1/scss/bambuco1.scss');

    $currenttheme = theme_config::load('bambuco1');
    $font = trim($currenttheme->settings->googlefont);

    $defaultfont = "sans-serif";
    if (!empty($font)) {
        $parts = explode(':', $font);
        $defaultfont = "'" . $parts[0] . "', " . $defaultfont;
    }

    $bambuco1variables = '$font-family-sans-serif: ' . $defaultfont . ";\n" . $bambuco1variables;

    // Combine them together.
    return $bambuco1variables . "\n" . $scss . "\n" . $bambuco1;
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_bambuco1_get_pre_scss($theme) {
    $scss = '';
    $configurable = [
        // Config key => [variableName, ...].
        'brandcolor' => ['brand-primary'],
        'navbarheadercolor' => 'navbar-header-color',
        'navbarbg' => 'navbar-bg',
        'navbarbghover' => 'navbar-bg-hover'
    ];

    // Prepend variables first.
    foreach ($configurable as $configkey => $targets) {
        $value = isset($theme->settings->{$configkey}) ? $theme->settings->{$configkey} : null;
        if (empty($value)) {
            continue;
        }
        array_map(function($target) use (&$scss, $value) {
            $scss .= '$' . $target . ': ' . $value . ";\n";
        }, (array) $targets);
    }

    // Prepend pre-scss.
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    return $scss;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return mixed
 */
function theme_bambuco1_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    $theme = theme_config::load('bambuco1');

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'logo') {
        return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'headerimg') {
        return $theme->setting_file_serve('headerimg', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'marketing1icon') {
        return $theme->setting_file_serve('marketing1icon', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'marketing2icon') {
        return $theme->setting_file_serve('marketing2icon', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'marketing3icon') {
        return $theme->setting_file_serve('marketing3icon', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'marketing4icon') {
        return $theme->setting_file_serve('marketing4icon', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'topfooterimg') {
        return $theme->setting_file_serve('topfooterimg', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'loginbgimg') {
        return $theme->setting_file_serve('loginbgimg', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'favicon') {
        return $theme->setting_file_serve('favicon', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and preg_match("/^sliderimage[1-9][0-9]?$/", $filearea) !== false) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and preg_match("/^sponsorsimage[1-9][0-9]?$/", $filearea) !== false) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and preg_match("/^clientsimage[1-9][0-9]?$/", $filearea) !== false) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    send_file_not_found();
}

/**
 * Get theme setting
 *
 * @param string $setting
 * @param bool $format
 * @return string
 */
function theme_bambuco1_get_setting($setting, $format = false) {
    $theme = theme_config::load('bambuco1');

    if (empty($theme->settings->$setting)) {
        return false;
    }

    if (!$format) {
        return $theme->settings->$setting;
    }

    if ($format === 'format_text') {
        return format_text($theme->settings->$setting, FORMAT_PLAIN);
    }

    if ($format === 'format_html') {
        return format_text($theme->settings->$setting, FORMAT_HTML, array('trusted' => true, 'noclean' => true));
    }

    return format_string($theme->settings->$setting);
}


/**
 * Extend the BambuCo 1 navigation
 *
 * @param flat_navigation $flatnav
 */
function theme_bambuco1_extend_flat_navigation(\flat_navigation $flatnav) {
    theme_bambuco1_add_certificatesmenuitem($flatnav);

    theme_bambuco1_delete_menuitems($flatnav);

    theme_bambuco1_add_coursesections_to_navigation($flatnav);
}

/**
 * Add items to flat navigation menu
 *
 * @param flat_navigation $flatnav
 *
 */
function theme_bambuco1_add_certificatesmenuitem(\flat_navigation $flatnav) {
    global $COURSE;

    try {
        if (!theme_bambuco1_has_certificates_plugin()) {
            return;
        }

        $actionurl = new \moodle_url('/theme/bambuco1/certificates.php');

        // Course page.
        if ($COURSE->id > 1) {
            $parentitem = $flatnav->find('competencies', \navigation_node::TYPE_SETTING);

            $actionurl = new \moodle_url('/theme/bambuco1/certificates.php', ['id' => $COURSE->id]);
        }

        if ($COURSE->id == 1 && !$parentitem = $flatnav->find('privatefiles', \navigation_node::TYPE_SETTING)) {
            return;
        }

        if (!is_null($parentitem->parent)) {
            $certificatesitemoptions = [
                'action' => $actionurl,
                'text' => get_string('certificates', 'theme_bambuco1'),
                'shorttext' => get_string('certificates', 'theme_bambuco1'),
                'icon' => new pix_icon('i/export', ''),
                'type' => \navigation_node::TYPE_SETTING,
                'key' => 'certificates',
                'parent' => $parentitem->parent
            ];

            $certificatesitem = new \flat_navigation_node($certificatesitemoptions, 0);

            $flatnav->add($certificatesitem, $parentitem->key);
        }
    } catch (\coding_exception $e) {
        debugging($e->getMessage(), DEBUG_DEVELOPER, $e->getTrace());
    } catch (\moodle_exception $e) {
        debugging($e->getMessage(), DEBUG_NORMAL, $e->getTrace());
    }
}

/**
 * Remove items from navigation
 *
 * @param flat_navigation $flatnav
 */
function theme_bambuco1_delete_menuitems(\flat_navigation $flatnav) {

    $itemstodelete = [
        'coursehome'
    ];

    foreach ($flatnav as $item) {
        if (in_array($item->key, $itemstodelete)) {
            $flatnav->remove($item->key);

            continue;
        }

        if (isset($item->parent->key) && $item->parent->key == 'mycourses' &&
            isset($item->type) && $item->type == \navigation_node::TYPE_COURSE) {

            $flatnav->remove($item->key, \navigation_node::TYPE_COURSE);
        }
    }
}

/**
 * Improve flat navigation menu
 *
 * @param flat_navigation $flatnav
 */
function theme_bambuco1_add_coursesections_to_navigation(\flat_navigation $flatnav) {
    global $PAGE;

    $participantsitem = $flatnav->find('participants', \navigation_node::TYPE_CONTAINER);

    if (!$participantsitem) {
        return;
    }

    if ($PAGE->course->format != 'singleactivity') {
        $coursesectionsoptions = [
            'text' => get_string('coursesections', 'theme_bambuco1'),
            'shorttext' => get_string('coursesections', 'theme_bambuco1'),
            'icon' => new pix_icon('t/viewdetails', ''),
            'type' => \navigation_node::COURSE_CURRENT,
            'key' => 'course-sections',
            'parent' => $participantsitem->parent
        ];

        $coursesections = new \flat_navigation_node($coursesectionsoptions, 0);

        foreach ($flatnav as $item) {
            if ($item->type == \navigation_node::TYPE_SECTION) {
                $coursesections->add_node(new \navigation_node([
                    'text' => $item->text,
                    'shorttext' => $item->shorttext,
                    'icon' => $item->icon,
                    'type' => $item->type,
                    'key' => $item->key,
                    'parent' => $coursesections,
                    'action' => $item->action
                ]));
            }
        }

        $flatnav->add($coursesections, $participantsitem->key);
    }

    $mycourses = $flatnav->find('mycourses', \navigation_node::NODETYPE_LEAF);

    if ($mycourses) {
        $flatnav->remove($mycourses->key);

        $flatnav->add($mycourses, 'privatefiles');
    }
}

/**
 * Check if a certificate plugin is installed.
 *
 * @return bool
 */
function theme_bambuco1_has_certificates_plugin() {
    $simplecertificate = \core_plugin_manager::instance()->get_plugin_info('mod_simplecertificate');

    $customcert = \core_plugin_manager::instance()->get_plugin_info('mod_customcert');

    if ($simplecertificate || $customcert) {
        return true;
    }

    return false;
}

/**
 * Returns HTML to display a "Turn editing on/off" button in a form.
 *
 * @param moodle_url $url The URL + params to send through when clicking the button
 * @return string HTML the button
 * Written by G J Barnard
 */
function theme_bambuco1_edit_button() {
    global $PAGE;
    $url = $PAGE->url;
    $url->param('sesskey', sesskey());
    if ($PAGE->user_is_editing()) {
        $url->param('edit', 'off');
        $btn = 'btn-default';
        $title = get_string('turneditingoff');
        $icon = 'fa-power-off';
    } else {
        $url->param('edit', 'on');
        $btn = 'btn-default';
        $title = get_string('turneditingon');
        $icon = 'fa-edit';
    }

    return html_writer::tag('a', html_writer::tag('i', '', array('class' => $icon.' fa fa-fw')).
        $title, array('href' => $url, 'class' => 'btn '.$btn, 'title' => $title));
}
