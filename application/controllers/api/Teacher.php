<?php

/**
 * Created by PhpStorm.
 * User: Limbo
 * Date: 2018/4/7
 * Time: 16:48
 */
class Teacher extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('Teacher_model', 'teacher');
        $this->load->model('Comment_model','comment');
        $this->load->model('Course_model','course');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }
    public function index()
    {
        echo 'api/Teacher';
    }
    /**
     * use to make a info
     *
     * @param int $flag - the flag
     * @param string $content -the content
     * @param string $extra -the extra info
     * @return array
     */
    private function getInfo($flag=100, $content='', $extra=''){
        $info = array('flag' => $flag, 'content' => $content, 'extra' => $extra);
        return $info;
    }
    private function myecho($flag=100, $content='', $extra='') {
        return urldecode(json_encode($this->getInfo($flag, $content, $extra)));
    }

    /**
     * 根据教师ID搜索评论和课程列表
     */
    public function getCommentAndCourseByTeacherId(){
        $teacherId=$this->input->post('teacherId');
        $currentPage=$this->input->post('currentPage');

        /**
         * pageSize 参数代表每页信息数量，默认值为10
         */
        $pageSize = 10;
        /**
         * sortBy 参数代表排序规则，目前默认为按照点赞数排序
         * 0 - 按照点赞数排序
         * 1 - 按照时间排序
         */
        $sortBy = 0;
//        $a='bylikeCount';

        if(!isset($teacherId)){
            echo $this->myecho(-2,"缺少参数","");
            return;
        }
        if(!isset($currentPage)){
            $currentPage=1;
        }

//        $res=$this->teacher->getCommentAndCourseByTeacherId($teacherId,$currentPage);

        $res1=$this->comment->findCommentByTeacherID($teacherId,$currentPage,$pageSize,$sortBy);
        $res2=$this->teacher->findTeacherByTeacherId($teacherId);
        $res3=$this->course->findCourseByTeacherId($teacherId);

        if($res1['flag']==-1){
            echo $this->myecho(-1,"查询评论失败","");
        }else if($res2['flag']==-1){
            echo $this->myecho(-2,"查询教师失败","");
        }else if($res3['flag']==-1){
            echo $this->myecho(-3,"查询课程失败","");
        }else {
            $res = array(
                'teacherId' => $teacherId,
                'teacherName' => $res2['data'],
                'sortBy' => $sortBy,
                'currentPage' => $currentPage,
                'pageSize' => $pageSize,
                'totalPage' => $res1['data']['totalPage'],
                'commentList' => $res1['data']['page'],
                'courseList' => $res3['data']
            );
        };
        echo $this->myecho(100,"查询成功",$res);
    }
}