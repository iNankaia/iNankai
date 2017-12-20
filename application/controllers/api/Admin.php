<?php

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model', 'admin');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }

    public function index()
    {
        echo 'api/Admin';
    }

    /**
     * use to make a info
     *
     * @param int $flag - the flag
     * @param string $content -the content
     * @param string $extra -the extra info
     * @return array
     */
    private function getInfo($flag = 100, $content = '', $extra = '')
    {
        $info = array('flag' => $flag, 'content' => $content, 'extra' => $extra);
        return $info;
    }

    private function myecho($flag = 100, $content = '', $extra = '')
    {
        return urldecode(json_encode($this->getInfo($flag, $content, $extra)));
    }

    /**
     * 获取待审核文章
     *
     * @param int $num - 本次审核操作需获取的文章数（默认为10）
     */
    public function getPending()
    {
        $num=$this->input->post('PendNum');
        $res = $this->admin->getPending($num);
        if ($res['flag'] === -1) {
            echo $this->myecho(-1, "无待审核文章", "");
        } else if ($res['flag'] === -10) {
            echo $this->myecho(-2, "获取待审核文章失败", "");
        } else {
            echo $this->myecho(100, "获取待审核文章成功", $res['data']);
            //返回的data为待审核文章的post_id
        }

    }

    /**
     * 获取文章审核结果并进行审核操作
     */
    public function Pending()
    {
        $post_id = $this->input->post('post_id');
        $result = $this->input->post('result');
        $pass = $this->input->post('IsPassed');
        if (!isset($post_id) || !isset($result)) {
            echo $this->myecho(-1, "缺少参数", "");
            return;
        }
        $res = $this->admin->Pending($post_id, $pass, $result);
        if ($res['flag'] === -1) {
            echo $this->myecho(-2, "不存在此文章", "");
        } else if ($res['flag'] === -2) {
            echo $this->myecho(-3, "审核操作失败", "");
        } else {
            echo $this->myecho(100, "审核操作成功", "");
        }
    }

    /**
     * 获取今日新增文章数
     */
    public function getTodayPosts()
    {
        $res = $this->admin->getPostNumber(0);
        if ($res['flag'] = -1) {
            echo $this->myecho(-1, "获取文章数失败", "");
            return;
        } else {
            echo $this->myecho(100, "获取文章数成功", $res['data']);
        }
    }

    /**
     * 获取本周新增文章数
     */
    public function getThisWeekPosts()
    {
        $res = $this->admin->getPostNumber(1);
        if ($res['flag'] = -1) {
            echo $this->myecho(-1, "获取文章数失败", "");
            return;
        } else {
            echo $this->myecho(100, "获取文章数成功", $res['data']);
        }
    }

    /**
     * 获取本月新增文章数
     */
    public function getThisMonthPosts()
    {
        $res = $this->admin->getPostNumber(2);
        if ($res['flag'] = -1) {
            echo $this->myecho(-1, "获取用户数失败", "");
            return;
        } else {
            echo $this->myecho(100, "获取用户数成功", $res['data']);
        }
    }

    /**
     * 获取本年新增文章数
     */
    public function getThisYearPosts()
    {
        $res = $this->admin->getPostNumber(3);
        if ($res['flag'] = -1) {
            echo $this->myecho(-1, "获取文章数失败", "");
            return;
        } else {
            echo $this->myecho(100, "获取文章数成功", $res['data']);
        }
    }

    /**
     * 获取总文章数
     */
    public function getTotalPosts()
    {
        $res = $this->admin->getPostNumber(4);
        if ($res['flag'] = -1) {
            echo $this->myecho(-1, "获取文章数失败", "");
            return;
        } else {
            echo $this->myecho(100, "获取文章数成功", $res['data']);
        }
    }
    /**
     * 获取今日登录用户数
     */
    public function getTodaySignup()
    {
        $res = $this->admin->getLoginNumber(0);
        if ($res['flag'] = -1) {
            echo $this->myecho(-1, "获取用户数失败", "");
            return;
        } else {
            echo $this->myecho(100, "获取用户数成功", $res['data']);
        }
    }

    /**
     * 获取本周登录用户数
     */
    public function getThisWeekSignup()
    {
        $res = $this->admin->getLoginNumber(1);
        if ($res['flag'] = -1) {
            echo $this->myecho(-1, "获取用户数失败", "");
            return;
        } else {
            echo $this->myecho(100, "获取用户数成功", $res['data']);
        }
    }

    /**
     * 获取本月登录用户数
     */
    public function getThisMonthSignup()
    {
        $res = $this->admin->getLoginNumber(2);
        if ($res['flag'] = -1) {
            echo $this->myecho(-1, "获取用户数失败", "");
            return;
        } else {
            echo $this->myecho(100, "获取用户数成功", $res['data']);
        }
    }

    /**
     * 获取本年登录用户数
     */
    public function getThisYearSignup()
    {
        $res = $this->admin->getLoginNumber(3);
        if ($res['flag'] = -1) {
            echo $this->myecho(-1, "获取用户数失败", "");
            return;
        } else {
            echo $this->myecho(100, "获取用户数成功", $res['data']);
        }
    }

    /**
     * 获取总用户数
     */
    public function getTotalSignup()
    {
        $res = $this->admin->getLoginNumber(4);
        if ($res['flag'] = -1) {
            echo $this->myecho(-1, "获取用户数失败", "");
            return;
        } else {
            echo $this->myecho(100, "获取用户数成功", $res['data']);
        }
    }
}
?>