<?php

class User extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }
    public function index()
    {
       echo 'api/User';
    }
    /**
     * use to make a info
     *
     * @param int $Flag - the flag
     * @param string $Content -the content
     * @param string $Extra -the extra info
     * @return array
     */
    private function getInfo($flag = 100, $content = '', $extra = ''){
      $info = array('flag' => $flag, 'content' => $content, 'extra' => $extra);
      return $info;
    }
    private function myecho($flag=100, $content='', $extra='') {
      return urldecode(json_encode($this->getInfo($flag, $content, $extra)));
    }
    /**
     * 注册
     */
    public function signup() {
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $email = $this->input->post('email');
      // 检查是否缺少参数
      if (!isset($username) || !isset($password) || !isset($email)) {
        echo $this->myecho(-1, '缺少参数', '');
        return;
      }
      //
      $res = $this->user->signup($username, $password, $email);
      if ($res['flag'] === -1) {
        echo $this->myecho(-2, '帐号已存在', '');
      } else if ($res['flag'] === -2) {
        echo $this->myecho(-3, '注册失败', '');
      } else {
        echo $this->myecho(100, '注册成功', '');
      }
    }
    /**
     * 登录
     */
    public function signin() {
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      // 检查是否缺少参数
      if (!isset($email) || !isset($password)) {
        echo $this->myecho(-1, '缺少参数', '');
        return;
      }
      $res = $this->user->signin($email, $password);
      if ($res['flag'] === -1) {
        echo $this->myecho(-4, '帐号不存在', '');
      } else if ($res['flag'] === -2) {
        echo $this->myecho(-5, '密码错误', '');
      } else {
        echo $this->myecho(100, '登录成功', '');
      }
    }
    /**
     * 登出
     */
    public function signout() {
      // 可能还需要设置用户状态
      $res = $this->user->signout();
      if ($res['flag'] === -1) {
        echo $this->myecho(-6, '用户未登录', '');
      } else {
        echo $this->myecho(100, '登出成功', '');
      }
    }
    /**
     * 获取用户信息
     */
    public function userinfo() {
      $res = $this->user->userinfo();
      if ($res['flag'] === -1) {
        echo $this->myecho(-6, '尚未登录', '');
      } else if ($res['flag'] === -2) {
        echo $this->myecho(-7, '信息获取失败', '');
      } else if ($res['flag'] === 1) {
        echo $this->myecho(100, '信息获取成功', $res['data']);
      }
    }
    /**
     * 修改用户信息
     */
    public function modifyinfo() {
      $new_name = $this->input->post('new_name');
      $new_portrait = $this->input->post('new_portrait');
      if (!isset($new_name) || !isset($new_portrait)) {
        echo $this->myecho(-1, '缺少参数', '');
        return;
      }
      $res = $this->user->modifyinfo($new_name, $new_portrait);
      
    }
  }

?>