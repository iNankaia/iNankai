<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2018/4/7
 * Time: 16:49
 */
class Comment extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Comment_model', 'comment');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }
    public function index()
    {
        echo 'api/Comment';
    }

    private function getInfo($flag=100, $content='', $extra=''){
        $info = array('flag' => $flag, 'content' => $content, 'extra' => $extra);
        return $info;
    }
    private function myecho($flag=100, $content='', $extra='') {
        return urldecode(json_encode($this->getInfo($flag, $content, $extra)));
    }

    /**
     *通过课程号来查找评论
     */
    public function getCommentListByCourseId(){
        $courseId = $this->input->post('courseId');
        $currentPage = $this->input->post('currentPage');
        $pageSize=10;
        if(!isset($courseId)){
            echo $this->myecho(-1, '查询失败');
            return ;
        }
        if(!isset($currentPage)){
          $currentPage=1;
        }
        $result = $this->comment->getCommentListByCourseId();
        $res=array(
            'pageSize'=>$pageSize,
            'currentPage'=>$currentPage,
            'totalCount'=>$result['data']['totalCount'],
            'totalPage'=>$result['data']['totalPage'],
            'page'=>$result['data']['page']
        );
        echo $this->myecho(100, '查询成功', $res);
    }
    /**
     * 通过用户id来查询评论
     *
     */
    public function getCommentListByUserId(){
        $currentPage=$this->input->post('currentPage');
        $userId = $this->input->post('userId');
        $pageSize=10;
        $
        if(!isset($userId)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
        if(!isset($currentPage)){
            $currentPage=1;
        }
        $result=$this->comment->findCommentByUserID($userId,$currentPage,$pageSize,);



    }
}
?>