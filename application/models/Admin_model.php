<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_model extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
    public function index(){

    }


    /**
     * @param int $num 获取文章数目
     * @return array 'flag':-1:无待审核文章  -2：获取失败  100：获取成功
     *
     * 从数据库中获取若干条待审核文章
     */
    public function getPending($num=20)
    {
        $sql='select post_id from post where post_pended = 0';
        //表中post_pended键值应为int型（或short型）
        //取值为4种：
        //0 - 待审核
        //1 - 审核通过
        //-1 - 审核未通过
        //2 - 正在审核
        $res=$this->db->query($sql);
        if($res->num_rows()===0)
        {
            return array('flag'=>-1);
        }
        else
        {
            $rtn=array('flag'=>100,'data'=>array());
            $cnt=0;
            foreach($res->result() as $row)
            {
                $rtn['data'][$cnt]=$row->post_id;
                $cnt++;
                if($cnt>=$num)
                {
                    break;
                }
            }
            return $rtn;
        }
    }

    /**
     * @param int $post_id - 审核的文章pid
     * @param bool $pass - 文章是否通过
     * @param string $result - 审核意见
     *
     * @return int -1:非法操作，未被获取的待审核文章  -2：文章不存在于数据库  -3：此文章已被审核  -4：审核操作失败  100：审核操作成功
     *
     * 审核文章并附处理意见
     */
    public function Pending($post_id=100,$pass=false,$result="")
    {

        $uid = $this->session->uid;
        if ($pass) {
            $pended = 1;
        } else {
            $pended = -1;
        }
        $sql='select * from post where post_id = '.$post_id;
        $res=$this->db->query($sql);
        if ($res->num_rows() === 0)
        {
            $rtn=array('flag'=>-2);
            return $rtn;
        }
        else if($res->result()->post_pended!=2)
        {
            if($res->result()->post_pended===1||$res->result()->post_pended===-1)
            {
                $rtn=array('flag'=>-3);
                return $rtn;
            }
            else if($res->result()->post_pended===0)
            {
                $rtn=array('flag'=>-1);
                return $rtn;
            }
        }
        $sql = 'update post set post_pended =' . $pended . ', post_pended_message =' . $this->db->escape($result) . ', post_pender_id =' . $uid . ' where post_id=' . $post_id;
        $res = $this->db->query($sql);
        if($res->affected_rows()>0)
        {
            return array('flag'=>100);
        }
        else
        {
            return array('flag'=>-4);
        }
    }
    /**
     * @param int $time - 获取指定时间的文章数
     * 0 - 今日  1 - 本周  2 - 本月  3 - 本年  4 - 总共
     *
     * @return array flag: -1:失败  100:成功
     *
     * 获取指定时间内发出的文章数
     */
    public function getPostNumber($time=0)
    {
        if($time==0)
        {
            $ts=mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        }
        else if($time==1)
        {
            $ts = strtotime(date('Y-m-d', strtotime("this week Monday", time())));
        }
        else if($time==2)
        {
            $ts=mktime(0, 0, 0, date('m'), 1, date('Y'));
        }
        else if($time==3)
        {
            $ts=mktime(0, 0, 0, 1, 1, date('Y'));
        }
        else if($time==4)
        {
            $sql='select post_id from post';
            $res=$this->db->query($sql);
            if($res->num_rows()>0)
            {
                return array('flag'=>100,'data'=>$res->num_rows());
            }
            else
            {
             return array('flag'=>-1);
            }
        }
        $sql='select post_id from post where post_timestamp >'.$this->db->escape($ts);
        $res=$this->db->query($sql);
        if($res->num_rows()>0)
        {
            return array('flag'=>100,'data'=>$res->num_rows());
        }
        else
        {
            return array('flag'=>-1);
        }

    }
    /**
     * @param int $time - 获取指定时间的登录用户数
     * 0 - 今日  1 - 本周  2 - 本月  3 - 本年  4 - 总共
     *
     * @return array flag: -1:失败  100:成功
     *
     * 获取指定时间内登录用户数
     */
    public function getLoginNumber($time=0)
    {
        if($time==0)
        {
            $ts=mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        }
        else if($time==1)
        {
            $ts = strtotime(date('Y-m-d', strtotime("this week Monday", time())));
        }
        else if($time==2)
        {
            $ts=mktime(0, 0, 0, date('m'), 1, date('Y'));
        }
        else if($time==3)
        {
            $ts=mktime(0, 0, 0, 1, 1, date('Y'));
        }
        else if($time==4)
        {
            $sql='select user_id from user';
            $res=$this->db->query($sql);
            if($res->num_rows()>0)
            {
                return array('flag'=>100,'data'=>$res->num_rows());
            }
            else
            {
                return array('flag'=>-1);
            }
        }
        $sql='select user_id from login_info where login_timestamp >'.$this->db->escape($ts);
        $res=$this->db->query($sql);
        if($res->num_rows()>0)
        {
            return array('flag'=>100,'data'=>$res->num_rows());
        }
        else
        {
            return array('flag'=>-1);
        }
    }
}