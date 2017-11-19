<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Controller {
    public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->library('session');
    }
    public function index() {
       
    }
    
    /**
     * 用户注册
     * @param username 用户昵称
     * @param password 用户密码
     * @param email 用户注册用邮箱
     * @return -1: 帐号已存在；-2: 插入数据库失败； 1: 插入数据库成功
     */
    public function signup($username='', $password='', $email='') {
      // 先检查是否已经存在该帐号
      $sql = 'select * from login_info where user_email = '.$this->db->escape($email);
      $res = $this->db->query($sql);
      if ($res->num_rows() > 0) {
        // 已经存在该帐号
        return array('flag' => -1);
      }
      // 随机生成长度为4的盐，并将密码进行sha256哈希
      $salt = strval(rand(pow(10, 3), pow(10, 4) - 1));
      $password = hash('sha256', $password.$salt);
      // 将数据存入数据存入数据库中
      $id = rand(pow(10, 3), pow(10, 4) - 1);
      $sql = 'insert into login_info values('.$this->db->escape($id).','.$this->db->escape($username).','
        .$this->db->escape($password).','.$this->db->escape(date('Y-m-d H:i:s', time()))
        .','.$this->db->escape($salt).','.$this->db->escape($email).')';
      $res = $this->db->query($sql);
      $headicon = '/hehe.jpg';
      $sql = 'insert into user_info values('.$this->db->escape($id).','.$this->db->escape($username).','
      .$this->db->escape($username).','.$this->db->escape(1)
      .','.$this->db->escape($headicon).','.$this->db->escape(date('Y-m-d H:i:s', time())).')';
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
     * 用户登录
     * @param email 用户登录邮箱
     * @param password 用户登录密码
     * @return -1: 帐号不存在; -2: 密码错误; 1: 登录成功
     */
    public function signin($email='', $password='') {
      // 先检查是否存在该用户
      $sql = 'select * from login_info where user_email = '.$this->db->escape($email);
      $res = $this->db->query($sql);
      if ($res->num_rows() == 0) {
        // 不存在该帐号
        return array('flag' => -1);
      }
      // 获取用户账号信息，并检查密码是否正确
      foreach ($res->result() as $row) {
        $correct_password = $row->user_password;
        $salt = $row->user_salt;
        $uid = $row->user_id;
      }
      $temp_password = hash('sha256', $password.$salt);
      if (substr($temp_password, 0, 20) !== $correct_password) {
        // 密码错误
        return array('flag' => -2);
      }
      // 设置session
      $this->session->set_userdata('uid', $uid);
      return array('flag' => 1);
    }
    /**
     * 用户登出
     * @return -1: 用户未登录; 1: 登出成功
     */
    public function signout() {
      //  目前比较粗糙，可能需要修改数据库中的用户状态信息
      if ($this->session->has_userdata('uid')) {
        $this->session->unset_userdata('uid');
        return array('flag' => 1);
      } else {
        return array('flag' => -1);
      }
    }
    /**
     * 获取用户信息
     * @return -1: 尚未登录；-2: 信息获取失败； 1：信息获取成功
     */
    public function userinfo() {
      if ($this->session->has_userdata('uid')) {
        $uid = $this->session->uid;
        $sql = 'select * from user_info where user_id = '.$this->db->escape(intval($uid));
        $res = $this->db->query($sql);
        if ($res->num_rows() === 0) {
          return array('flag' => -2);
        }
        foreach ($res->result() as $row) {
          $data = array(
            'portrait' => $row->user_portrait,
            'name' => $row->user_name,
            'signup_time' =>$row->user_signup_time
          );
        }
        return array('flag' => 1, 'data' => $data);
      } else {
        return array('flag' => -1);
      }
    }
    /**
     * 修改用户信息
     * @param new_name 用户新名称
     * @param new_potrait 用户新头像
     * @return -1: 未登录
     */
    public function modifyinfo($new_name='', $new_potrait='') {
      if ($this->session->has_userdata('uid')) {
        return array('flag' => -1);
      }
      $uid = $this->session->uid;
      // $sql = 'update '
    }
  }
?>