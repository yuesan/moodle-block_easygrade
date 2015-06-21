<?php
namespace block_easygrade;

require_once "../../mod/assign/locallib.php";

defined('MOODLE_INTERNAL') || die();

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

    /**
     * コース内に登録されているユーザーを取得する。
     *
     * @return array
     */
    public function users()
    {
        $users = get_enrolled_users(self::get_context());
        return $users;
    }

    /**
     * オンラインテキストで提出された提出物を取得する。
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