<?php

/**
 * Created by PhpStorm.
 * User: a
 * Date: 2018/4/10
 * Time: 12:04
 */
class Comment_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
    public function index(){

    }

    /**
     * @param int $teacherId
     * @param int $currentPage
     * @param int $pageSize
     * @param int $sortBy
     */
    public function findCommentByTeacherID($teacherId=0,$currentPage=0,$pageSize=0,$sortBy=0){
        $sql='SELECT comment.*,course.coursename FROM comment left join  course on COMMENT.courseid=course.courseid where teacherid='.$this->db->escape($teacherId);
        $res=$this->db->query($sql);
        if($res->num_rows()>0){
            $resdata=$res->result_array();

//            return array('flag'=>0,'data'=>$resdata);
//            foreach($res->result_array() as $row){
//                $data['commentid']=$row->commentid;
//                $data['courseid']=$row->courseid;
//                $data['teacherid']=$row->teacherid;
//                $data['userid']=$row->userid;
//                $data['rating_usefulness']=$row->rating_usefulness;
//                $data['rating_vividness']=$row->rating_vividness;
//                $data['rating_spareTimeOccupation']=$row->commentid;
//                $data['rating_scoring']=$row->commentid;
//                $data['rating_rollCall']=$row->commentid;
//                $data['recommandScore']=$row->commentid;
//                $data['critics']=$row->commentid;
//                $data['likeCount']=$row->commentid;
//                $data['timestamp']=$row->commentid;
//
//            }

            Sort($resdata,intval($sortBy));
            $respage=array_slice($resdata,intval(($currentPage-1)*$pageSize),intval($pageSize),true);
            $totalCount=$res->num_rows();
            $totalPage=$totalCount%$pageSize==0?intval($totalCount/$pageSize):intval($totalCount/$pageSize+1);
            $rtn=array(
                'flag'=>0,
                'data'=>array(
                'page'=>$respage,
                'totalCount'=>$totalCount,
                'totalPage'=>$totalPage,
                'currentPage'=>$currentPage
                )
            );
            return $rtn;
        }else{
            $rtn=array('flag'=>-1);
            return $rtn;
        }
    }

    /**
     * @param array $unsorted - $resPage in upper function
     * @param int $sortBy
     * 0 - Sort by likeCount
     * 1 - Sort by time
     */
    public function Sort($unsorted=array(),$sortBy=0){
//        if($sortBy===0){
//            array_multisort($unsorted['likeCount'],SORT_DESC,$unsorted);
//        }
    }
}