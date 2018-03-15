<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class League_model extends CI_Model {
    public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->library('session');
    }
    public function index() {
       
    }
    /**
     * 检查username是否已被使用
     * @param username　社团名
     * @return -1: 已被使用; 1: 未被使用
     */
    public function checkname($username='') {
      $sql = 'select * from club_user_info where club_user_name = '.$this->db->escape($username);
      $res = $this->db->query($sql);
      if ($res->num_rows() > 0) {
        return array('flag' => -1);
      } else {
        return array('flag' => 1);
      }
    }
    /**
     * 社团注册
     * @param username 社团名
     * @param password 社团密码
     * @param email 社团邮箱
     * @param invite_code 社团激活码
     * @param introduction 社团介绍
     * @param contact 社团联系方式
     * @return -1: 帐号已存在；-2: 插入数据库失败；-3: 用户名已存在；-4: 激活码已经失效； 1: 插入数据库成功
     */
    public function signup($username='', $password='', $email='', $invite_code='', $introduction='', $contact='') {
      // 先检查是否已经存在该帐号
      $res = $this->checkname($username);
      if ($res['flag'] === -1) {
        return array('flag' => -3);
      }
      $sql = 'select * from login_info where user_email = '.$this->db->escape($email);
      $res = $this->db->query($sql);
      if ($res->num_rows() > 0) {
        // 已经存在该帐号
        return array('flag' => -1);
      }
      // 检查激活码是否已经失效
      $sql = 'select * from Invitation where invitation_code = '.$this->db->escape($invite_code).' and used_by_id = '.$this->db->escape('');
      $res = $this->db->query($sql);
      if ($res->num_rows() === 0) {
        // 激活码已经失效
        return array('flag' => -4);
      }
      // 为用户生成id
      $uid = md5($email);
      // 随机生成长度为4的盐，并将密码进行sha256哈希
      $salt = strval(rand(pow(10, 3), pow(10, 4) - 1));
      $password = hash('sha256', $password.$salt);
      // 将数据存入数据存入数据库中
      $sql = 'insert into login_info values('.$this->db->escape($uid).','.$this->db->escape($username).','
        .$this->db->escape($password).','.$this->db->escape(date('Y-m-d H:i:s', time()))
        .','.$this->db->escape($salt).','.$this->db->escape($email).','.$this->db->escape(1).','.$this->db->escape(0).')';
      $res = $this->db->query($sql);
      $headicon = '/hehe.jpg';
      $sql = 'insert into club_user_info values('.$this->db->escape($uid).','.$this->db->escape($introduction).','
      .$this->db->escape($email).','.$this->db->escape($contact).','.$this->db->escape(0).','.$this->db->escape($headicon).','
      .$this->db->escape(date('Y-m-d H:i:s', time())).','.$this->db->escape($username).')';
      $res = $this->db->query($sql);
      // 使邀请码失效
      $sql = 'update Invitation set used_by_id = '.$this->db->escape($uid).' where 	Invitation_code = '.$this->db->escape($invite_code);
      $res = $this->db->query($sql);
      if ($this->db->affected_rows() > 0) {
        // 插入成功
        return array('flag' => 1);
      } else {
        // 插入失败
        return array('flag' => -2);
      }
    }
    /**
     * 返回社团信息
     * @return -1: 社团未登录; -2: 获取信息失败; 1: 获取信息成功
     */
    public function leagueinfo() {
      if (!$this->session->has_userdata('club_user_id')) {
        return array('flag' => -1);
      }
      $club_user_id = $this->session->club_user_id;
      $sql = 'select * from club_user_info where club_user_id = '.$this->db->escape($club_user_id);
      $res = $this->db->query($sql);
      if ($res->num_rows() === 0) {
        return array('flag' => -2);
      }
      foreach ($res->result() as $row) {
        $data = array(
          'club_email' => $row->club_email,
          'club_contact' => $row->club_contact,
          'club_sub' => $row->club_sub_count,
          'club_portrait' => $row->club_portrait,
          'club_signup_time' => $row->club_signup_time,
          'introduction' => $row->club_introduction
        );
      }
      return array('flag' => 1, 'data' => $data);
    }
    /**
     * 社团修改信息
     * @param introduction 社团介绍
     * @param contact 社团联系方式
     * @param portrait 社团头像
     * @return -1: 帐号未登录; -2: 修改失败; 1: 修改成功
     */
    public function modifyinfo($introduction='', $contact='', $portrait='') {
      if (!$this->session->has_userdata('club_user_id')) {
        return array('flag' => -1);
      }
      $club_user_id = $this->session->club_user_id;
      $sql = 'update club_user_info set club_introduction = '.$this->db->escape($introduction).',club_contact = '.$this->db->escape($contact)
      .',club_portrait = '.$this->db->escape($portrait);
      $res = $this->db->query($sql);
      if ($this->db->affected_rows() === 0) {
        return array('flag' => -2);
      } else {
        return array('flag' => 1);
      }
    }
    /**
     * 社团获取关注数和点赞数
     * @return -1: 账号未登录 1: 返回成功
     */
    public function getfocusnum() {
      if (!$this->session->has_userdata('club_user_id')) {
        return array('flag' => -1);
      }
      $club_user_id = $this->session->club_user_id;
      $sql = 'select club_sub_count from club_user_info where club_user_id = '.$this->db->escape($club_user_id);
      $res = $this->db->query($sql);
      $focus_num = 0;
      foreach ($res->result() as $row) {
        $focus_num = $row->club_sub_count;
      }
      return array('flag' => 1, 'data' => array('cnt' => $focus_num));
    }
  }
?>