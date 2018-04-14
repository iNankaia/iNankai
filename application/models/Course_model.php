<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  db
 */
class Course_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
    public function index() {

    }

    /**
     * 获得全部课程列表
     * @param int $currentPage 查询页码
     * @param int $pageSize 每页显示的课程数量
     * @return array flag: 1 查询成功； -1 数据库为空
     */
    public function getcourselist($currentPage = 1, $pageSize = 20){
        $sql = 'select * from Course c, Coursemark m where c.courseid=m.courseid';
        $res = $this->db->query($sql);
//        if(count())
        if($res->num_rows() > 0){
            $courseList = $res->result_array();
            if($courseList)
            return array('flag' => 1, 'data' => $res->result_array());
        }else{
            return array('flag' => -1);
        }
    }
    public function findCourseByTeacherId($teacherId=0){
        $sql='SELECT
	course.coursename,
coursemark.*
FROM
	course
LEFT JOIN
	coursemark ON coursemark.courseid = course.courseid
WHERE
	course.courseid in (
		SELECT
			courseid
		FROM
			teaching
		WHERE
			teacherid = '
            .$this->db->escape($teacherId).
            ')';
        $res=$this->db->query($sql);



        if($res->num_rows()>0){
            $rtn=array('flag'=>0,'data'=>$res->result());
            return $rtn;
        }else{
            $rtn=array('flag'=>-1);
            return $rtn;
        }
    }
}
?>