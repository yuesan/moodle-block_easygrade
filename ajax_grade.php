<?php

namespace block_easygrade;

require_once __DIR__ . '/../../config.php';

require_login();

/* @var $USER object */
/* @var $PAGE object */
global $USER, $PAGE;

$cmid = required_param("cmid", PARAM_INT);
$courseid = required_param("courseid", PARAM_INT);
$userid = required_param("userid", PARAM_INT);
$grade = required_param("grade", PARAM_INT);
$mode = required_param("mode", PARAM_ALPHA);

$cm = get_coursemodule_from_id("assign", $cmid);
$context = \context_course::instance($courseid);
$cmcontext = \context_module::instance($cmid);

require_capability('mod/assign:grade', $context, $USER->id);

$course = get_course($courseid);
$assignObj = new assign($cmcontext, $cm, $course);

$PAGE->set_context($context);

switch ($mode) {
    case "updategrade" :
        $grade_data = $assignObj->get_user_grade($userid, false);
        $grade_data->grade = $grade;
        if ($assignObj->update_grade($grade_data)) {
            $return_r = [
                "result" => "success"
            ];
            echo json_encode($return_r);
        } else {
            $return_r = [
                "result" => "error",
                "reason" => "failed to update"
            ];
            echo json_encode($return_r);
        }
        break;

    default :
        $return_r = [
            "result" => "error",
            "reason" => "no method"
        ];
        echo json_encode($return_r);
        break;
}