<?php
namespace block_easygrade;

require_once "../../mod/assign/locallib.php";

defined('MOODLE_INTERNAL') || die();

class assign extends \assign
{
    private $course;

    /**
     * コース内に登録されているユーザーを取得する。
     *
     * @return array
     */
    public function users()
    {
        return get_enrolled_users(self::get_context());
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