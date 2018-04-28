<?php
class Comment extends CI_Controller{
    public  function __construct()
    {
        parent::__construct();
        $this->load->model('Comment_model','comment');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }
    public function index(){
        echo 'api/Comment';
    }
    private function getInfo($flag=100, $content='', $extra=''){
        $info = array('flag' => $flag, 'content' => $content, 'extra' => $extra);
        return $info;
    }
    private function myecho($flag=100, $content='', $extra='') {
        return urldecode(json_encode($this->getInfo($flag, $content, $extra)));
    }

    public function findComment(){
        $findby = $this->input->post('findby');
        $orderby = $this->input->post('orderby');
        $search_str = $this->input->post('search_str');
        $res= $this->comment->findComment($findby,$orderby,$search_str);
        if($res['flag'] === -1){
            echo $this->myecho(-29,'搜索失败','');
        }
        else{
            echo $this->myecho(100,'搜索成功',$res['data']);
        }
    }

    public function publishComment(){
        $data['comment_commenting_post_id'] = $this->input->post('comment_commenting_post_id');
        $data['comment_content'] = $this->input->post('comment_content');
        $res = $this->comment->publishComment($data);
        if($res['flag']===-1){
            echo $this->myecho(-6,'未登录','');
        }
        if($res['flag']===-2){
            echo $this->myecho(31,'评论发布失败','');
        }
        if($res['flag']===1){
            echo $this->myecho(100,'评论发布成功','');
        }
    }

    public function deleteComment(){
        $comment_id = $this->input->post('comment_id');
        $res = $this ->comment->deleteComment($comment_id);
        if($res['flag']===-1){
            echo $this->myecho(-6,'未登录','');
        }
        else if($res['flag']===-2){
            echo $this->myecho(-32,'评论不存在','');
        }
        else if($res['flag']===-3){
            echo $this->myecho(-23,'用户无权删除','');
        }
        else if($res['flag']===-4){
            echo $this->myecho(-33,'删除失败','');
        }
        else if($res['flag']===1){
            echo $this->myecho(100,'删除成功','');
        }
    }

    public function publishReply(){
        $data['comment_commenting_post_id'] = $this->input->post('comment_commenting_post_id');
        $data['comment_content'] = $this->input->post('comment_content');
        $data['comment_replying_comment_id'] = $this->input->post('comment_replying_comment_id');
        $res = $this->comment->publishReply($data);
        if($res['flag']===-1){
            echo $this->myecho(-6,'未登录','');
        }
        if($res['flag']===-2){
            echo $this->myecho(-6,'回复失败','');
        }
        if($res['flag']===1){
            echo $this->myecho(100,'回复成功','');
        }
    }

}
?>