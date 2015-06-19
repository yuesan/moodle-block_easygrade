<?php

namespace block_easygrade;

require_once __DIR__ . '/../../config.php';

require_login();

/* @var $USER object */
/* @var $CFG object */
/* @var $PAGE object */
global $USER, $CFG, $PAGE;

$courseid = required_param('courseid', PARAM_INT);
$context = \context_course::instance($courseid);

require_capability('moodle/grade:viewall', $context, $USER->id);

$course = get_course($courseid);

$PAGE->set_context($context);
echo \html_writer::start_tag('html');
echo \html_writer::start_tag('head');
echo \html_writer::empty_tag('meta', ['charset' => 'UTF-8']);
echo \html_writer::empty_tag('meta', ['http-equiv' => 'content-language']);
echo \html_writer::empty_tag('meta', ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
echo \html_writer::tag('title', get_string('pluginname', 'block_easygrade'), ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
echo \html_writer::empty_tag('link', ['href' => new \moodle_url('css/bootstrap.min.css'), 'rel' => 'stylesheet']);

echo \html_writer::start_tag('body');
echo \html_writer::start_div("container");

echo \html_writer::tag("h1", "コース(" . s($course->fullname) . ")内の課題一覧");

echo \html_writer::start_tag("form", ["method" => "post", "action" => "do_submit.php"]);

echo \html_writer::start_tag("table", ["class" => "table"]);
echo \html_writer::start_tag("tr");
echo \html_writer::tag("th", "小テスト名");
echo \html_writer::tag("th", "-");
echo \html_writer::end_tag("tr");
$assigns = get_all_instances_in_course("assign", $course);
foreach ($assigns as $assign) {
    echo \html_writer::start_tag("tr");
    echo \html_writer::tag("td", $assign->name);
    echo \html_writer::tag("td",
        \html_writer::link(new \moodle_url("grade.php", ["courseid" => $course->id, "assignid" => $assign->id, "cmid" => $assign->coursemodule]), "採点する", ["class" => "btn btn-success"])
    );
    echo \html_writer::end_tag("tr");
}
echo \html_writer::end_tag("table");
echo \html_writer::end_tag("form");

echo \html_writer::end_div();

echo \html_writer::end_tag("body");

//Script
echo \html_writer::script(null, new \moodle_url($CFG->wwwroot . '/blocks/easygrade/js/jquery.min.js'));
echo \html_writer::script(null, new \moodle_url($CFG->wwwroot . '/blocks/easygrade/js/bootstrap.min.js'));
echo \html_writer::end_tag('body');
echo \html_writer::end_tag('html');