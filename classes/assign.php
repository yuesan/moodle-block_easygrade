<?php
namespace block_easygrade;

require_once "../../mod/assign/locallib.php";

class assign extends \assign
{
    private $course;

    /**
     * コース内の課題オブジェクトを全て取得する
     *
     * @return array
     * @throws \coding_exception
     */
    public function assigns()
    {
        return get_all_instances_in_course("assign", $this->course);
    }

    public function users()
    {
        return get_enrolled_users(self::get_context());
    }

    /**
     *
     *
     * @param $submissionid
     *
     * @return mixed
     */
    public function get_onlinetext_submission($submissionid) {
        global $DB;

        return $DB->get_record('assignsubmission_onlinetext', array('submission'=>$submissionid));
    }
}