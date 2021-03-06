<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
    public function index(){

    }
    /**
     * 查询全部post
     * flag = -1    :搜索失败
     * flag = 1     :搜索成功
     */
    public function findPost($findby, $orderby, $search_str){
        $sql = 'select * from post';

        switch ($findby)
        {
            case 'club_user_name':
                $sql = 'select * from post,club_user_info where post_user_id=club_user_id and club_user_name='.$this->db->escape($search_str);
                break;
            case 'tag_name':
                $sql = 'select DISTINCT * from post,tagged,tag where post.post_id=tagged.post_id and tagged.tag_id=tag.tag_id and tag_name='.$this->db->escape($search_str);
                break;
            case 'favoriter_user_id':
                if ($this->session->has_userdata('uid')) {
                    $uid = $this->session->uid;
                }
                else if($this->session->has_userdata('club_user_id')){
                    $uid = $this->session->club_user_id;
                }
                $sql = 'select * from post,favorite where post.post_id=favorite.post_id and favoriter_user_id='.$this->db->escape($uid);
                break;
            default:
                break;
        }

        $sql = $sql.' order by '.$orderby.' DESC';
        $res = $this->db->query($sql);
        if($res->num_rows()===0){
            return array('flag'=>-1);
        }
        $counter = 0;
        foreach ($res->result() as $row){
            $result[$counter] = array
            (
                'post_id'               => $row->post_id,
                'post_user_id'          => $row->post_user_id,
                'post_title'            => $row->post_title,
                'post_content'          => $row->post_content,
                'post_like_count'        => $row->post_like_count,
                'post_timestamp'        => $row->post_timestamp,
                'post_detail_ref'       => $row->post_detail_ref,
                'post_favorite_count'   => $row->post_favorite_count,
                'post_activity_location'=> $row->post_activity_location,
                'post_activity_time'    => $row->post_activity_time,
                'post_state'            => $row->post_state,
                'post_recommendation'  => $row->post_recommendation,
                'post_image_quickview'  => $row->post_image_quickview
            );
            $counter++;
        }
        $data = array('result'=>$result, 'counter'=>$counter);
        return array('flag'=>1,'data'=>$data);
    }

    /**
     * 发布post
     * @param $data 包含发布的post的信息
     * @return array flag = 1 成功；-1 未登录；-2 发布失败；
     */
    public function publishPost($data){
        if($this->session->has_userdata('club_user_id')){
            $post_user_id = $this->session->club_user_id;
            $timestamp = date('Y-m-d H:i:s',time());
            //生成post_id
            $post_id = 0;

            $sql = 'insert into post values ('
                .$this->db->escape($post_id).','
                .$this->db->escape($post_user_id).','
                .$this->db->escape($data['post_title']).','
                .$this->db->escape($data['post_content']).','
                .$this->db->escape(0).',' //like_count
                .$this->db->escape($timestamp).','
                .$this->db->escape($data['post_detail_ref']).','
                .$this->db->escape(0).',' //favorite_count
                .$this->db->escape($data['post_activity_location']).','
                .$this->db->escape($data['post_activity_time']).','
                .$this->db->escape(0).','//post_state
                .$this->db->escape(0).','//post_recommendation
                .$this->db->escape($data['post_image_quickview'])
                .')';
            $res = $this->db->query($sql);
            if($this->db->affected_rows() > 0){
                //图片记录
/*                foreach ($data['image_refs'] as $image_ref){
                    //生成image_id
                    $image_id = md5($image_ref.$timestamp);
                    $sql = 'insert into image values ('
                        .$this->db->escape($image_ref).','
                        .$this->db->escape($image_id).','
                        .$this->db->escape($post_id)
                        .')';
                    $res = $this->db->query($sql);
                }*/

                //tag记录
                if($data['tag_ids'] != NULL){
                    $tag_ids = explode(',', $data['tag_ids']);
                    $post_id = $this->db->insert_id();
                    foreach ($tag_ids as $tag_id){
                        $sql = 'insert into tagged values ('
                            .$this->db->escape($tag_id).','
                            .$this->db->escape($post_id)
                            .')';
                        $res = $this->db->query($sql);
                    }
                }

                return array('flag'=>1);
            }
            else{
                return array('flag'=> -2);
            }
        }
        else{
            return array('flag'=>-1);
        }
    }

    /**
     * @param string $post_id 需要删除的post_id
     * @return array 1 成功 ； -1 删除失败 ； -2 该用户无权删除本post ； -3 未登陆 ；-4 无该post
     */
    public function deletePost($post_id='')
    {
        //检查是否存在该post
        $sql = 'select * from post where post_id=' . $this->db->escape($post_id);
        $res = $this->db->query($sql);
        if ($res->num_rows() === 0) {
            return array('flag' => -4);
        }
        foreach ($res->result() as $row) {
            $post_user_id = $row->post_user_id;
        }
        if ($this->session->has_userdata('club_user_id')) {
            if($this->session->uid === $post_user_id){
                $sql = 'delete from post where post_id='.$this->db->escape($post_id);
                    $res = $this->db->query($sql);
                    if($res === 0){
                        return array('flag'=>-1);
                    }
                    else {
                        return array('flag' => 1);
                    }
            }
            else {
                $sql = 'select * from login_info where user_id='.$this->db->escape($this->session->uid);
                $res = $this->db->query($sql);
                foreach ($res->result() as $row){
                    $user_authority = $row->user_authority;
                }
                if($user_authority>=2){
                    $sql = 'delete from post where post_id='.$this->db->escape($post_id);
                    $res = $this->db->query($sql);
                    if($res->num_rows()===0){
                        return array('flag'=>-1);
                    }
                    else {
                        return array('flag' => 1);
                    }
                }
                else{
                    return array('flag'=> -2);
                }
            }
        }
        else{
            return array('flag'=>-3);
        }
    }

    /**
     * @param string $post_id
     * @param $data
     * @return array -4:post不存在；-3：未登录；-2：用户无权修改；-1：修改失败；1：成功
     */
    public function modifyPost($post_id='',$data)
    {

        //检查是否存在该post
        $sql = 'select * from post where post_id=' . $this->db->escape($post_id);
        $res = $this->db->query($sql);
        if ($res->num_rows() === 0) {
            return array('flag' => -4);
        }
        foreach ($res->result() as $row) {
            $post_user_id = $row->post_user_id;
        }
        if ($this->session->has_userdata('club_user_id')) {
            if ($this->session->uid === $post_user_id) {
                $sql = 'update post set 
                    post_title=' . $this->db->escape($data['post_title'])
                    . ',post_content=' . $this->db->escape($data['post_content'])
                    . ',post_detail_ref=' . $this->db->escape($data['post_detail_ref'])
                    . ',post_activity_location=' . $this->db->escape($data['post_activity_location'])
                    . ',post_activity_time=' . $this->db->escape($data['post_activity_time'])
                    . ',post_image_quickview=' . $this->db->escape($data['post_image_quickview'])
                    . 'where post_id='.$this->db->escape($post_id);
                $res = $this->db->query($sql);
                if ($res === 0) {
                    return array('flag' => -1);
                } else {
                    return array('flag' => 1);
                }
            } else {
                $sql = 'select * from login_info where user_id=' . $this->db->escape($this->session->uid);
                $res = $this->db->query($sql);
                foreach ($res->result() as $row) {
                    $user_authority = $row->user_authority;
                }
                if ($user_authority >= 2) {
                    $sql = 'update post set 
                    post_title=' . $this->db->escape($data['post_title'])
                        . ',post_content=' . $this->db->escape($data['post_content'])
                        . ',post_detail_ref=' . $this->db->escape($data['post_detail_ref'])
                        . ',post_activity_location=' . $this->db->escape($data['post_activity_location'])
                        . ',post_activity_time=' . $this->db->escape($data['post_activity_time'])
                        . ',post_image_quickview=' . $this->db->escape($data['post_image_quickview'])
                        . 'where post_id='.$this->db->escape($post_id);
                    $res = $this->db->query($sql);
                    if ($res === 0) {
                        return array('flag' => -1);
                    } else {
                        return array('flag' => 1);
                    }
                } else {
                    return array('flag' => -2);
                }
            }
        } else {
            return array('flag' => -3);
        }
    }

    /**
     * @param $post_id
     * @return array -4:post不存在; -3:该用户已点过赞；-2:点赞失败；-6:未登录； 1：成功
     */
    public function likePost($post_id){

        if ($this->session->has_userdata('uid')) {
            $uid = $this->session->uid;
        }
        else if($this->session->has_userdata('club_user_id')){
            $uid = $this->session->club_user_id;
        }
        else
        {
            return array('flag' => -6);
        }

        //检查是否存在该post
        $sql = 'select * from post where post_id=' . $this->db->escape($post_id);
        $res = $this->db->query($sql);
        if ($res->num_rows() === 0) {
            return array('flag' => -4);
        }
        $sql = 'select * from liked where user_id='.$uid.' and post_id='.$this->db->escape($post_id);
        $res = $this->db->query($sql);
        if($res->num_rows() != 0){
            return array('flag' => -3);
        }
        $this->db->trans_start();
        $this->db->query('insert into liked values('
            . $uid .','
            .$this->db->escape($post_id).')');
        $this->db->query('update post p set p.post_like_count = p.post_like_count + 1 where p.post_id ='.$this->db->escape($post_id));
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE){
            return array('flag'=>-2);
        }
        return array('flag'=>1);
    }
    public function favoritePost($post_id){
        if ($this->session->has_userdata('uid')) {
            $uid = $this->session->uid;
        }
        else if($this->session->has_userdata('club_user_id')){
            $uid = $this->session->club_user_id;
        }
        else
        {
            return array('flag' => -6);
        }
        //检查是否存在该post
        $sql = 'select * from post where post_id=' . $this->db->escape($post_id);
        $res = $this->db->query($sql);
        if ($res->num_rows() === 0) {
            return array('flag' => -4);
        }
        $sql = 'select * from favorite where favoriter_user_id='.$uid.' and post_id='.$this->db->escape($post_id);
        $res = $this->db->query($sql);
        if($res->num_rows() != 0){
            return array('flag' => -3);
        }
        $this->db->trans_start();
        $this->db->query('insert into favorite values('
            .$uid.','
            .$this->db->escape($post_id).')');
        $this->db->query('update post p set p.post_favorite_count = p.post_favorite_count + 1 where p.post_id ='.$this->db->escape($post_id));
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE){
            return array('flag'=>-2);
        }
        return array('flag'=>1);
    }
}

?>
