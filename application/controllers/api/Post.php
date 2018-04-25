<?php

class Post extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Post_model', 'post');
        $this->load->helper('url_helper');
        $this->load->library('session');

    }
    private function getInfo($flag=100, $content='', $extra=''){
        $info = array('flag' => $flag, 'content' => $content, 'extra' => $extra);
        return $info;
    }

    private function myecho($flag=100, $content='', $extra='') {
        return urldecode(json_encode($this->getInfo($flag, $content, $extra)));
    }

    public function findPost(){
        $findby = $this->input->post('findby');
        $orderby = $this->input->post('orderby');
        $search_str = $this->input->post('search_str');
        $res= $this->post->findPost($findby, $orderby, $search_str);
        if($res['flag'] === -1){
            echo $this->myecho(-29,'搜索失败','');
        }
        else{
            echo $this->myecho(100,'搜索成功',$res['data']);
        }
    }

    public function publishPost(){
        $data['post_title'] = $this->input->post('post_title');
        $data['post_content'] = $this->input->post('post_content');
        $data['post_detail_ref'] = $this->input->post('post_detail_ref');
        $data['post_activity_location'] = $this->input->post('post_activity_location');
        $data['post_activity_time'] = $this->input->post('post_activity_time');
        $data['post_image_quickview'] = $this->input->post('post_image_quickview');
        $data['tag_ids'] = $this->input->post('tag_ids');
        $res = $this->post->publishPost($data);
        if($res['flag'] === -1){
            echo $this->myecho(-6,'未登录','');
        }
        else if($res['flag']===-2){
            echo $this->myecho(-21,'发布失败','');
        }
        else{
            echo $this->myecho(100,'发布成功','');
        }

    }

    public function deletePost(){
        $post_id = $this->input->post('post_id');
        $res = $this->post->deletePost($post_id);
        if($res['flag']===-1){
            echo $this->myecho(-22,'删除失败','');
        }
        else if($res['flag']===-2){
            echo $this->myecho(-23,'用户无权删除','');
        }
        else if($res['flag']===-3){
            echo $this->myecho(-6,'未登录','');
        }
        else if($res['flag']===-4){
            echo $this->myecho(-24,'该post不存在','');
        }
        else if($res['flag']===1){
            echo $this->myecho(100,'删除成功','');
        }
    }

    public function  modifyPost(){
        $post_id = $this->input->post('post_id');
        $data['post_title'] = $this->input->post('post_title');
        $data['post_content'] = $this->input->post('post_content');
        $data['post_detail_ref'] = $this->input->post('post_detail_ref');
        $data['post_activity_location'] = $this->input->post('post_activity_location');
        $data['post_activity_time'] = $this->input->post('post_activity_time');
        $data['post_image_quickview'] = $this->input->post('post_image_quickview');
        $res = $this->post->modifyPost($post_id,$data);
        if($res['flag']===-4){
            echo $this->myecho(-24,'该post不存在','');
        }
        else if($res['flag']===-3){
            echo $this->myecho(-6,'未登录','');
        }
        else if($res['flag']===-2){
            echo $this->myecho(-25,'用户无权修改','');
        }
        else if($res['flag']===-1){
            echo $this->myecho(-26,'修改失败','');
        }
        else if($res['flag']===1) {
            echo $this->myecho(100, '修改成功', '');
        }
    }

    public  function likePost(){
        $post_id = $this->input->post('post_id');
        $res = $this->post->likePost($post_id);
        if($res['flag']===-4){
            echo $this->myecho(-24,'该post不存在','');
        }
        else if($res['flag']===-3){
            echo $this->myecho(-27,'重复点赞','');
        }
        else if($res['flag']===-2){
            echo $this->myecho(-28,'点赞失败','');
        }
        else if($res['flag']===1){
            echo $this->myecho(100,'点赞成功','');
        }
        else if($res['flag']===-6){
            echo $this->myecho(-6,'未登录','');
        }
    }
    public  function favoritePost(){
        $post_id = $this->input->post('post_id');
        $res = $this->post->favoritePost($post_id);
        if($res['flag']===-4){
            echo $this->myecho(-24,'该post不存在','');
        }
        else if($res['flag']===-3){
            echo $this->myecho(-27,'重复收藏','');
        }
        else if($res['flag']===-2){
            echo $this->myecho(-28,'收藏失败','');
        }
        else if($res['flag']===1){
            echo $this->myecho(100,'收藏成功','');
        }
        else if($res['flag']===-6){
            echo $this->myecho(-6,'未登录','');
        }
    }
}
?>