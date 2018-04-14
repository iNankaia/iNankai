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
        $sortBy=0;
        if(!isset($courseId)){
            echo $this->myecho(-1, '查询失败');
            return ;
        }
        if(!isset($currentPage)){
          $currentPage=1;
        }
        $result = $this->comment->getCommentListByCourseId($courseId,$currentPage,$pageSize,$sortBy);
        $res=array(
            'pageSize'=>$pageSize,
            'currentPage'=>$currentPage,
            'totalCount'=>$result['totalCount'],
            'totalPage'=>$result['totalPage'],
            'page'=>$result['page']
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
        $sortBy=0;
        if(!isset($userId)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
        if(!isset($currentPage)){
            $currentPage=1;
        }
        $result=$this->comment->findCommentByUserID($userId,$currentPage,$pageSize,$sortBy);
        $res=array(
            'pageSize'=>$pageSize,
            'currentPage'=>$currentPage,
            'totalCount'=>$result['totalCount'],
            'totalPage'=>$result['totalPage'],
            'page'=>$result['page']
        );
        echo $this->myecho(100, '查询成功', $res);
    }

    public function addLikeCount(){
        $commentId=$this->input->post('commentId');
        if(!isset($commentId)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
        $result=$this->comment->addLikeCount($commentId);
        $res=array(
            'likeCount'=>$result
        );
        echo $this->myecho(100,'查询成功',$res);
    }
    public function deleteComment(){
        $commentId=$this->input->post('commentId');
        if(!isset($commentID)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
        $result=$this->comment->findCommentByCommentID($commentId);
        if($result->num_rows()>0){
            $res=$this->comment->deleteCommentByCommentID($commentId);
            echo $this->myecho(100,'查询成功');
        }
        return ;
    }

    public function addComment(){
      //  $commentid = $this->input->post('commentid');
        //  $courseid = $this->input->post('courseid');
      //  $teacherid = $this->input->post('teacherid');
      //  $userid = $this->input->post('userid');
        $rating_usefulness = $this->input->post('rating_usefulness');
        $rating_vividness = $this->input->post('rating_vividness');
        $rating_spareTimeOccupation = $this->input->post('rating_spareTimeOccupation');
        $rating_scoring = $this->input->post('rating_scoring');
        $rating_rollCall = $this->input->post('rating_rollCall');
        $recommandScore = $this->input->post('recommandScore');
        $critics= $this->input->post('critics');
        $likeCount = 0;
        if(!isset($rating_usefulness)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
        if(!isset( $rating_vividness)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
        if(!isset($rating_spareTimeOccupation)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
        if(!isset( $rating_scoring)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
        if(!isset($rating_rollCall)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
        if(!isset( $recommandScore)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
        if(!isset( $critics)){
            echo $this->myecho(-1,'查询失败');
            return ;
        }
      //  $result=$this->comment->addComment($);



    }




}
?>