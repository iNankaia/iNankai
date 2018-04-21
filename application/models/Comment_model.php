<?php

/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2018/4/7
 * Time: 18:00
 */

class Comment_model extends CI_Model
{

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function index() {

    }



    /**
     * @param $courseid
     * @param $currentPage
     * @param $pageSize
     * @param $sortmethod
     * @return array
     */
    public function getCommentListByCourseId($courseid=0,$currentPage=1,$pageSize=10,$sortmethod=0){
        $sql='select * from comment where courseid='.$this->db->escape($courseid);;
        $result=$this->db->query($sql);

        if($result->num_rows()>0){

            $res=$result->result_array();
            Sort($res,$sortmethod);
            $respage=array_slice($res,intval( ($currentPage-1)*$pageSize),intval($pageSize),false);
            $totalcount=$result->num_rows();
            $totalPage = $totalcount % $pageSize ==0?intval($totalcount/$pageSize):intval($totalcount/$pageSize+1);
            $res=array(
                'pageSize'=>$pageSize,
                'currentPage'=>$currentPage,
                 'totalCount'=>$totalcount,
                 'totalPage'=>$totalPage,
                 'page'=>$respage
        );
     }
        return $res;
    }

    /**
     * @param $commentid
     * @return array
     */
    public function findCommentByCommentID($commentid){
        $sql='select  from comment where commentid='.$this->db->escape($commentid);
        $result=$this->db->query($sql);

        if($result->num_rows()>0){
            return $result->result_array();
        }
        $res=array(
            'flag'=>0
        );
        return $res;
    }

    /**
     * @param int $commentId
     */
    public function deleteCommentByCommentID($commentId=0){
        $sql='delete * from comment where commentid='.$this->db->escape($commentId);
        $result=$this->db->query($sql);
        return ;
    }

    /**
     * @param int $userid
     * @param int $currentPage
     * @param int $pageSize
     * @param int $sortmethod
     * @return array
     */
    public function findCommentByUserID( $userid=0,$currentPage=1,$pageSize=10,$sortmethod=0){
        $sql='select * from comment where userid='.$this->db->escape($userid);
        $result=$this->db->query($sql);


        if($result->num_rows()>0){

            $res=$result->result_array();
            Sort($res,$sortmethod);
            $respage=array_slice($res,intval(($currentPage-1)*$pageSize),intval($pageSize),false);
            $totalcount=$result->num_rows();
            $totalPage = $totalcount % $pageSize ==0?intval($totalcount/$pageSize):intval($totalcount/$pageSize+1);
            $res=array(
                'pageSize'=>$pageSize,
                'currentPage'=>$currentPage,
                'totalCount'=>$totalcount,
                'totalPage'=>$totalPage,
                'page'=>$respage
            );
        }
        return $res;
    }
    /**
     * @param int $teacherId
     * @param int $currentPage
     * @param int $pageSize
     * @param int $sortBy
     * @return array
     */
    public function findCommentByTeacherID($teacherId=0,$currentPage=1,$pageSize=10,$sortBy=0){
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
            $respage=array_slice($resdata,intval(($currentPage-1)*$pageSize),intval($pageSize),false);
            $totalCount=$res->num_rows();
            $totalPage = $totalCount % $pageSize ==0?intval($totalCount/$pageSize):intval($totalCount/$pageSize+1);
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
        if($sortBy==0){
            array_multisort($unsorted['likeCount'],SORT_DESC,$unsorted);
        }
    }

    /**
     * @return mixed
     */
    public  function  getTotalCount(){
        $sql='select count(*) from comment ';
        $result=$this->db->query($sql);

        return  $result;
    }

    public function getCommentList($commentPage){
        
    }

    /**
     * @param $commentId
     * @return int
     */
    public function addLikeCount($commentId){
        $sql='select likeCount from comment where commentId='.$this->db->escape($commentId);
        $result=$this->db->query($sql);

        foreach($result->result() as $row){
            $likeCount=$row->likeCount;
        }

//        $res=$result->return_array();
//        $likeCount=$res['likeCount'];
        $likeCount+=1;
        $sql2='update comment set likeCount='.$likeCount.' where commentId='.$commentId;
        $resu=$this->db->query($sql2);
            return $likeCount;
    }

    /**
     * @param array $comment
     */
    public function addComment($comment=array()){
        $sql='insert into comment values('.
            $this->db->escape($comment['commentid']).
            $this->db->escape($comment['courseid']).
            $this->db->escape($comment['teacherid']).
            $this->db->escape($comment['userid']).
            $this->db->escape($comment['rating_usefulness']).
            $this->db->escape($comment['rating_vividness']).
            $this->db->escape($comment['rating_spareTimeOccupation']).
            $this->db->escape($comment['rating_scoring']).
            $this->db->escape($comment['rating_rollCall']).
            $this->db->escape($comment['recommandScore']).
            $this->db->escape($comment['critics']).
            $this->db->escape($comment['likeCount'])
            . ')';
        $result=$this->db->query($sql);

        return ;
    }

}


?>




