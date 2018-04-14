<?php
<<<<<<< HEAD
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2018/4/7
 * Time: 18:00
 */
class Course_model extends CI_Model {
=======

/**
 * Created by PhpStorm.
 * User: a
 * Date: 2018/4/10
 * Time: 12:04
 */
class Comment_model extends CI_Model
{
>>>>>>> 2070bbc59f496003952d596076bbc6e9c3fe9ab1
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
<<<<<<< HEAD
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
=======
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
>>>>>>> 2070bbc59f496003952d596076bbc6e9c3fe9ab1
