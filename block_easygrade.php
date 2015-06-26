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
 * easygrade block caps.
 *
 * @package    block_easygrade
 * @copyright  Takayuki Fuwa <fuwa@atware.co.jp>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_easygrade extends block_base
{

    function init()
    {
        $this->title = get_string('pluginname', 'block_easygrade');
    }

    function get_content()
    {
        global $CFG;

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        $courseid = $this->page->course->id;
        $context = context_course::instance($courseid);

        if (has_capability("mod/assign:grade", $context)) {
            $html = html_writer::link(
                new moodle_url($CFG->wwwroot . "/blocks/easygrade/index.php",
                    ["courseid" => $courseid]),
                "かんたん評点を起動する",
                ["class" => "btn btn-success", 'target' => '_blank']);
        } else {
            $html = "";
        }

        return $this->content = (object)['text' => $html];
    }

    public function applicable_formats()
    {
        return [
            'all' => false,
            'site' => false,
            'site-index' => false,
            'course-view' => true,
            'course-view-social' => false,
            'mod' => false
        ];
    }

    public function instance_allow_multiple()
    {
        return false;
    }

    function has_config()
    {
        return false;
    }

    public function cron()
    {
        return true;
    }
}
