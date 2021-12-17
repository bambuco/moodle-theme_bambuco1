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
 * Mustache helper to load a theme configuration.
 *
 * @package    theme_bambuco1
 * @copyright  2020 David Herney - https://bambuco.co
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_bambuco1\util;

use theme_config;
use stdClass;

defined('MOODLE_INTERNAL') || die();

/**
 * Helper to load a theme configuration.
 *
 * @package    theme_bambuco1
 * @copyright  2020 David Herney - https://bambuco.co
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_settings {

    /**
     * Get config theme footer itens
     *
     * @return array
     */
    public function footer_items() {
        $theme = theme_config::load('bambuco1');

        $templatecontext = [];

        $footersettings = [
            'facebook', 'twitter', 'whatsapp', 'linkedin', 'youtube', 'instagram', 'getintouchcontent',
            'website', 'mobile', 'mail', 'address', 'mapurl', 'appstore', 'googleplay', 'recommendations'
        ];

        foreach ($footersettings as $setting) {
            if (!empty($theme->settings->$setting)) {
                $templatecontext[$setting] = $theme->settings->$setting;
            }
        }

        $templatecontext['disablebottomfooter'] = false;
        if (!empty($theme->settings->disablebottomfooter)) {
            $templatecontext['disablebottomfooter'] = true;
        }

        return $templatecontext;
    }

    /**
     * Get config theme slideshow
     *
     * @return array
     */
    public function slideshow() {
        global $OUTPUT;

        $theme = theme_config::load('bambuco1');

        $templatecontext['sliderenabled'] = $theme->settings->sliderenabled;

        if (empty($templatecontext['sliderenabled'])) {
            return $templatecontext;
        }

        $slidercount = $theme->settings->slidercount;

        for ($i = 1, $j = 0; $i <= $slidercount; $i++, $j++) {
            $sliderimage = "sliderimage{$i}";
            $slidertitle = "slidertitle{$i}";
            $slidercap = "slidercap{$i}";
            $sliderlink = "sliderlink{$i}";

            $templatecontext['slides'][$j]['key'] = $j;
            $templatecontext['slides'][$j]['active'] = false;

            $image = $theme->setting_file_url($sliderimage, $sliderimage);
            if (empty($image)) {
                $image = $OUTPUT->image_url('slide_default', 'theme');
            }
            $templatecontext['slides'][$j]['image'] = $image;
            $templatecontext['slides'][$j]['title'] = $theme->settings->$slidertitle;
            $templatecontext['slides'][$j]['caption'] = $theme->settings->$slidercap;
            $templatecontext['slides'][$j]['link'] = $theme->settings->$sliderlink;

            if ($i === 1) {
                $templatecontext['slides'][$j]['active'] = true;
            }
        }

        return $templatecontext;
    }

    /**
     * Get config theme marketing itens
     *
     * @return array
     */
    public function marketing_items() {
        global $OUTPUT;

        $theme = theme_config::load('bambuco1');

        $templatecontext = [];

        for ($i = 1; $i < 5; $i++) {
            $marketingicon = 'marketing' . $i . 'icon';
            $marketingheading = 'marketing' . $i . 'heading';
            $marketingsubheading = 'marketing' . $i . 'subheading';
            $marketingcontent = 'marketing' . $i . 'content';
            $marketingurl = 'marketing' . $i . 'url';

            $templatecontext[$marketingicon] = $OUTPUT->image_url('icon_default', 'theme');
            if (!empty($theme->settings->$marketingicon)) {
                $templatecontext[$marketingicon] = $theme->setting_file_url($marketingicon, $marketingicon);
            }

            $templatecontext[$marketingheading] = '';
            if (!empty($theme->settings->$marketingheading)) {
                $templatecontext[$marketingheading] = theme_bambuco1_get_setting($marketingheading, true);
            }

            $templatecontext[$marketingsubheading] = '';
            if (!empty($theme->settings->$marketingsubheading)) {
                $templatecontext[$marketingsubheading] = theme_bambuco1_get_setting($marketingsubheading, true);
            }

            $templatecontext[$marketingcontent] = '';
            if (!empty($theme->settings->$marketingcontent)) {
                $templatecontext[$marketingcontent] = theme_bambuco1_get_setting($marketingcontent, true);
            }

            $templatecontext[$marketingurl] = '';
            if (!empty($theme->settings->$marketingurl)) {
                $templatecontext[$marketingurl] = $theme->settings->$marketingurl;
            }
        }

        return $templatecontext;
    }

    /**
     * Get the frontpage numbers
     *
     * @return array
     */
    public function numbers() {
        global $DB;

        $templatecontext['numberusers'] = $DB->count_records('user', array('deleted' => 0, 'suspended' => 0)) - 1;
        $templatecontext['numbercourses'] = $DB->count_records('course', array('visible' => 1)) - 1;
        $templatecontext['numberactivities'] = $DB->count_records('course_modules');

        return $templatecontext;
    }

    /**
     * Get config theme sponsors logos and urls
     *
     * @return array
     */
    public function sponsors() {
        $theme = theme_config::load('bambuco1');

        $templatecontext['sponsorstitle'] = $theme->settings->sponsorstitle;
        $templatecontext['sponsorssubtitle'] = $theme->settings->sponsorssubtitle;

        $sponsorscount = $theme->settings->sponsorscount;

        for ($i = 1, $j = 0; $i <= $sponsorscount; $i++, $j++) {
            $sponsorsimage = "sponsorsimage{$i}";
            $sponsorsurl = "sponsorsurl{$i}";

            $image = $theme->setting_file_url($sponsorsimage, $sponsorsimage);
            if (empty($image)) {
                continue;
            }

            $templatecontext['sponsors'][$j]['image'] = $image;
            $templatecontext['sponsors'][$j]['url'] = $theme->settings->$sponsorsurl;

        }

        return $templatecontext;
    }

    /**
     * Get config theme clients logos and urls
     *
     * @return array
     */
    public function clients() {
        $theme = theme_config::load('bambuco1');

        $templatecontext['clientstitle'] = $theme->settings->clientstitle;
        $templatecontext['clientssubtitle'] = $theme->settings->clientssubtitle;

        $clientscount = $theme->settings->clientscount;

        for ($i = 1, $j = 0; $i <= $clientscount; $i++, $j++) {
            $clientsimage = "clientsimage{$i}";
            $clientsurl = "clientsurl{$i}";

            $image = $theme->setting_file_url($clientsimage, $clientsimage);
            if (empty($image)) {
                continue;
            }

            $templatecontext['clients'][$j]['image'] = $image;
            $templatecontext['clients'][$j]['url'] = $theme->settings->$clientsurl;

        }

        return $templatecontext;
    }

    /**
     * Get config theme secondary menu items
     *
     * @return array
     */
    public function secondarymenu() {
        global $OUTPUT;

        $theme = theme_config::load('bambuco1');

        $templatecontext = [];
        $templatecontext['secondarymenu'] = array();

        if (!empty($theme->settings->secondarymenu)) {
            $links = explode("\n", $theme->settings->secondarymenu);

            foreach($links as $link) {
                $link = trim($link);
                if (empty($link)) {
                    continue;
                }

                $slides = explode('|', $link);
                $uri = $slides[0];
                $title = count($slides) > 1 ? $slides[1] : $uri;
                $target = count($slides) > 2 ? $slides[2] : '_blank';
                $templatecontext['secondarymenu'][] = sprintf('<a href="%s" target="%s" title="%s">%s</a>',
                                                            $uri, $target, $title, $title);
            }
        }

        return $templatecontext;
    }

    /**
     * Get config theme news items
     *
     * @return array
     */
    public function news_items() {
        global $OUTPUT;

        $theme = theme_config::load('bambuco1');

        $templatecontext = [];
        $templatecontext['news'] = array();

        $newscount = 10;
        $j = 0;
        for ($i = 1; $i <= $newscount; $i++) {
            $newsimage = 'newsimage' . $i;
            $newstext = 'newstext' . $i;
            $newsurl = 'newslink' . $i;
            $newsorder = 'newsorder' . $i;

            if ((empty($theme->settings->$newsimage) && empty($theme->settings->$newstext)) ||
                    empty($theme->settings->$newsorder) || $theme->settings->$newsorder == '0') {
                continue;
            }

            $order = (int)theme_bambuco1_get_setting($newsorder, false);
            $order--;
            $templatecontext['news'][$order] = array();

            if (!empty($theme->settings->$newsimage)) {
                $templatecontext['news'][$order]['image'] = $theme->setting_file_url($newsimage, $newsimage);
            }

            $templatecontext['news'][$order]['text'] = '';
            if (!empty($theme->settings->$newstext)) {
                $templatecontext['news'][$order]['text'] = theme_bambuco1_get_setting($newstext, 'format_html');
            }

            if (!empty($theme->settings->$newsurl)) {
                $templatecontext['news'][$order]['url'] = $theme->settings->$newsurl;
            }

            $j++;
        }

        if ($j > 0) {
             ksort($templatecontext['news']);
             $templatecontext['news'] = array_values($templatecontext['news']);
        }

        $templatecontext['hasnews'] = $j;

        return $templatecontext;
    }

    /**
     * Get config theme event items
     *
     * @return array
     */
    public function event_items() {
        global $OUTPUT;

        $theme = theme_config::load('bambuco1');

        $templatecontext = [];
        $templatecontext['event'] = array();

        $eventcount = 10;
        $j = 0;
        for ($i = 1; $i <= $eventcount; $i++) {
            $eventicon = 'eventicon' . $i;
            $eventimage = 'eventimage' . $i;
            $eventtext = 'eventtext' . $i;
            $eventurl = 'eventlink' . $i;
            $eventcolor = 'eventcolor' . $i;
            $eventorder = 'eventorder' . $i;

            if ((empty($theme->settings->$eventimage) && empty($theme->settings->$eventtext)) ||
                    empty($theme->settings->$eventorder) || $theme->settings->$eventorder == '0') {
                continue;
            }

            $order = (int)theme_bambuco1_get_setting($eventorder, false);
            $order--;
            $templatecontext['event'][$order] = array();

            if (!empty($theme->settings->$eventicon)) {
                $templatecontext['event'][$order]['icon'] = $theme->setting_file_url($eventicon, $eventicon);
            }

            if (!empty($theme->settings->$eventimage)) {
                $templatecontext['event'][$order]['image'] = $theme->setting_file_url($eventimage, $eventimage);
            }

            $templatecontext['event'][$order]['text'] = '';
            if (!empty($theme->settings->$eventtext)) {
                $templatecontext['event'][$order]['text'] = $theme->settings->$eventtext;
            }

            if (!empty($theme->settings->$eventcolor)) {
                $templatecontext['event'][$order]['color'] = $theme->settings->$eventcolor;
            }

            if (!empty($theme->settings->$eventurl)) {
                $templatecontext['event'][$order]['url'] = $theme->settings->$eventurl;
            }

            $j++;
        }

        if ($j > 0) {
             ksort($templatecontext['event']);
             $templatecontext['event'] = array_values($templatecontext['event']);
        }

        $templatecontext['hasevents'] = $j;

        return $templatecontext;
    }

    /**
     * Get config theme document items
     *
     * @return array
     */
    public function document_items() {
        global $OUTPUT;

        $theme = theme_config::load('bambuco1');

        $templatecontext = [];
        $templatecontext['document'] = array();

        $documentcount = 10;
        $j = 0;
        for ($i = 1; $i <= $documentcount; $i++) {
            $documenticon = 'documenticon' . $i;
            $documenticontext = 'documenticontext' . $i;
            $documenturl = 'documentlink' . $i;
            $documentname = 'documentname' . $i;
            $documenttext = 'documenttext' . $i;
            $documenttype = 'documenttype' . $i;
            $documentorder = 'documentorder' . $i;

            if (empty($theme->settings->$documentorder) || $theme->settings->$documentorder == '0') {
                continue;
            }

            $order = (int)theme_bambuco1_get_setting($documentorder, false);
            $order--;
            $templatecontext['document'][$order] = array();

            if (!empty($theme->settings->$documenticon)) {
                $templatecontext['document'][$order]['icon'] = $theme->setting_file_url($documenticon, $documenticon);
            }

            $templatecontext['document'][$order]['icontext'] = '';
            if (!empty($theme->settings->$documenttext)) {
                $templatecontext['document'][$order]['icontext'] = $theme->settings->$documenticontext;
            }

            if (!empty($theme->settings->$documenturl)) {
                $templatecontext['document'][$order]['url'] = $theme->settings->$documenturl;
            }

            $templatecontext['document'][$order]['name'] = '';
            if (!empty($theme->settings->$documentname)) {
                $templatecontext['document'][$order]['name'] = $theme->settings->$documentname;
            }

            $templatecontext['document'][$order]['text'] = '';
            if (!empty($theme->settings->$documenttext)) {
                $templatecontext['document'][$order]['text'] = $theme->settings->$documenttext;
            }

            $templatecontext['document'][$order]['type'] = '';
            if (!empty($theme->settings->$documenttext)) {
                $templatecontext['document'][$order]['type'] = $theme->settings->$documenttype;
            }

            $j++;
        }

        if ($j > 0) {
             ksort($templatecontext['document']);
             $templatecontext['document'] = array_values($templatecontext['document']);
        }

        $templatecontext['hasdocuments'] = $j;

        return $templatecontext;
    }

    /**
     * Get config theme general vars
     *
     * @return array
     */
    public function generalvars() {
        global $CFG, $OUTPUT, $SITE;

        $theme = theme_config::load('bambuco1');

        $logo = $OUTPUT->get_logo_url(0, 0);

        $templatecontext = [];
        $templatecontext['wwwroot'] = $CFG->wwwroot;
        $templatecontext['wwwcurrenttheme'] = $CFG->wwwroot . '/theme/bambuco1';
        $templatecontext['googlefont'] = $theme->settings->googlefont;
        $templatecontext['logourl'] = $logo;
        $templatecontext['sitename'] = $SITE->fullname;
        $templatecontext['sitesummary'] = $SITE->summary;

        $templatecontext = array_merge($templatecontext, $this->secondarymenu());

        return $templatecontext;
    }
}
