<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2018/4/7
 * Time: 18:00
 */
class Course_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
    public function index() {

    }
    public function getCommentListByCourseId($courseid,$currentPage,$pageSize,$sortmethod){
        $sql='select * from comment where courseid='.$this->db->escape($courseid);;
        $result=$this->db->query($sql);

     if($result->num_rows()>0){

         $res=$this->result_array();
         $respage=array_slice($res,intval( $currentPage*$pageSize),intval($pageSize),true);
         $totalcount=$result->num_rows();
         $totalPage = $totalcount % $pageSize ==0?$totalcount/$pageSize:$totalcount/$pageSize+1;
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
    public function findCommentByCommentID($commentid){
        $sql='select * from comment where commentid='.$this->db->escape($commentid);
        $result=$this->db->query($sql);

        if($result->num_rows()>0){
            return $result->result_array();
        }
        $res=array(
            'flag'=>0
        );
        return $res;
    }

    public function findCommentByUserID( $userid,$currentPage,$pageSize,$sortmethod){
        $sql='select * from comment where courseid='.$this->db->escape($userid);
        $result=$this->db->query($sql);


        if($result->num_rows()>0){

            $res=$this->result_array();
            $respage=array_slice($res,intval( $currentPage*$pageSize),intval($pageSize),true);
            $totalcount=$result->num_rows();
            $totalPage = $totalcount % $pageSize ==0?$totalcount/$pageSize:$totalcount/$pageSize+1;
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


}
?>