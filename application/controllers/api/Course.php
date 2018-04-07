<?php
/**
 * Created by PhpStorm.
 * User: kongxiao0532
 * Date: 18-4-7
 * Time: 下午3:03
 */


class Course extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Course_model', 'course');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }
    public function index()
    {
        echo 'api/Course';
    }
    /**
     * use to make a info
     *
     * @param int $flag - the flag
     * @param string $content -the content
     * @param string $extra -the extra info
     * @return array
     */
    private function getInfo($flag=100, $content='', $extra=''){
        $info = array('flag' => $flag, 'content' => $content, 'extra' => $extra);
        return $info;
    }
    private function myecho($flag=100, $content='', $extra='') {
        return urldecode(json_encode($this->getInfo($flag, $content, $extra)));
    }

    /**
     * 课程搜索
     */
    public function getcourselist(){
        $searchType = $this->input->post('searchType');
        $searchText = $this->input->post('searchText');
        $sortBy = $this->input->post('sortBy');
        $currentPage = $this->input->post('currentPage');

        if(!isset($searchText)){
            $result = $this->course->getcourselist();
        }
        echo $this->myecho(100, '查询成功', $result['data']);
    }
}