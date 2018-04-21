<?php

/**
 * Created by PhpStorm.
 * User: a
 * Date: 2018/4/12
 * Time: 10:00
 */
class Teacher_model extends CI_Model
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
     */
    public function findTeacherByTeacherId($teacherId=0){
        $sql='select teachername from teacher where teacherId='.$this->db->escape($teacherId);
        $res=$this->db->query($sql);

//        $data=$res->result()[0]['teachername'];
        foreach($res->result() as $row){
            $data=$row->teachername;
        }

        if($res->num_rows()>0){
            $rtn=array(
                'flag'=>0,
                'data'=>$data
            );
            return $rtn;
        }else{
            $rtn=array('flag'=>-1);
            return $rtn;
        }
    }
}