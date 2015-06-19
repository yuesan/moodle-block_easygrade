<?php

namespace block_easygrade;

require_once __DIR__ . '/../../config.php';
require_once "../../mod/assign/locallib.php";

require_login();

/* @var $USER object */
/* @var $CFG object */
/* @var $PAGE object */
/* @var $OUTPUT object */
global $USER, $CFG, $PAGE, $OUTPUT;

$courseid = required_param('courseid', PARAM_INT);
$assignid = required_param("assignid", PARAM_INT);
$cmid = required_param("cmid", PARAM_INT);

$cm = get_coursemodule_from_id("assign", $cmid);
$context = \context_course::instance($courseid);
$cmcontext = \context_module::instance($cmid);

require_capability('moodle/grade:viewall', $context, $USER->id);

$course = get_course($courseid);
$assignObj = new assign($cmcontext, $cm, $course);

$PAGE->set_context($context);
echo \html_writer::start_tag('html');
echo \html_writer::start_tag('head');
echo \html_writer::empty_tag('meta', ['charset' => 'UTF-8']);
echo \html_writer::empty_tag('meta', ['http-equiv' => 'content-language']);
echo \html_writer::empty_tag('meta', ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
echo \html_writer::tag('title', get_string('pluginname', 'block_easygrade'), ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
echo \html_writer::empty_tag('link', ['href' => new \moodle_url('css/bootstrap.min.css'), 'rel' => 'stylesheet']);

echo \html_writer::start_tag('body');

echo \html_writer::start_div("navbar navbar-default", ["role" => "navigation"]);
echo \html_writer::start_div("navbar-header");
echo \html_writer::link(new \moodle_url('index.php'),
    get_string('pluginname', 'block_easygrade'),
    ["class" => "navbar-brand"]);
echo \html_writer::end_div();
echo \html_writer::start_tag('div', ['class' => 'collapse navbar-collapse', 'id' => 'bs-example-navbar-collapse-1']);
echo \html_writer::start_tag('ul', ['class' => 'nav navbar-nav navbar-right']);
echo \html_writer::end_tag('ul');
echo \html_writer::end_div();
echo \html_writer::end_tag('nav');

echo \html_writer::start_div("container");

echo \html_writer::tag("h1", "コース(" . s($course->fullname) . ")内の課題一覧");

echo \html_writer::start_tag("ol", ["class" => "breadcrumb"]);
echo \html_writer::start_tag("li");
echo \html_writer::link(new \moodle_url("index.php", ["courseid" => $course->id]), "トップ(" . s($course->fullname) . ")");
echo \html_writer::end_tag("li");
echo \html_writer::start_tag("li");
echo \html_writer::link("#", $cm->name, ["class" => "active"]);
echo \html_writer::end_tag("li");
echo \html_writer::end_tag("ol");

echo \html_writer::start_tag("table", ["class" => "table"]);
echo \html_writer::start_tag("tr");
echo \html_writer::tag("th", "");
echo \html_writer::tag("th", "氏名");
echo \html_writer::tag("th", "メールアドレス");
echo \html_writer::tag("th", "オンラインテキスト");
echo \html_writer::tag("th", "評点");
echo \html_writer::end_tag("tr");
$users = $assignObj->users();
foreach($users as $user){
    $user_submission = $assignObj->get_user_submission($user->id, false);
    $onlinetext = $assignObj->get_onlinetext_submission($user_submission->id);
    echo \html_writer::start_tag("tr");
    echo \html_writer::tag("td",
        \html_writer::div($OUTPUT->user_picture($user,
            ['size'=>80, 'class' => 'img-circle', "link" => false, "alttext" => false]),
            "profile-userpic")
    );
    echo \html_writer::tag("td", fullname($user));
    echo \html_writer::tag("td", $user->email);
    echo \html_writer::tag("td", \html_writer::div($onlinetext->onlinetext, "well"));
    echo \html_writer::tag("td", "");
    echo \html_writer::end_tag("tr");
}
echo \html_writer::end_tag("table");

echo \html_writer::end_div();

echo \html_writer::end_tag("body");

//Script
echo \html_writer::script(null, new \moodle_url($CFG->wwwroot . '/blocks/easygrade/js/jquery.min.js'));
echo \html_writer::script(null, new \moodle_url($CFG->wwwroot . '/blocks/easygrade/js/bootstrap.min.js'));
echo \html_writer::end_tag('body');
echo \html_writer::end_tag('html');