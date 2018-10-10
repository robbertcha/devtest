<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library("pagination");
    }

	public function index(){
		$this->load->view('home');
    }
    
    public function ajaxRequest(){
        $config = array();
        $response=array();
        $param_arr=array();
        $params='';


        $config['use_page_numbers'] = TRUE;
        $current_page=$this->input->post('page');

        if ( $this->input->post('firstname') != null && $this->input->post('firstname') != '' ) {
            $params .= '&firstname=' . $this->input->post('firstname');
            $param_arr['firstname'] = $this->input->post('firstname');
        }

        if ( $this->input->post('surname') != null && $this->input->post('surname') != '' ) {
            $params .= $params == null || $params == '' ? '?surname=' . $this->input->post('surname') : '&surname=' . $this->input->post('surname');
            $param_arr['surname'] = $this->input->post('surname');
        }

        if ( $this->input->post('email') != null && $this->input->post('email') != '' ) {
            $params .= $params == null || $params == '' ? '?email=' . $this->input->post('email') : '&email=' . $this->input->post('email');
            $param_arr['email'] = $this->input->post('email');
        }


        // pagination
        $config["base_url"] = base_url().$params;
        $config["per_page"] = 12;
        $config["cur_page"] = $current_page;
        $config["uri_segment"] = $this->uri->total_segments();
        $config['prefix']           = '?page=';
        $config["total_rows"] = $this->user_model->count_users($param_arr);

        $this->pagination->initialize($config);

        $response['count']=$config["total_rows"];

        // chart
        $response['chart']=$this->user_model->chart_stats();
        // get user records
        $response['users']=$this->user_model->fetch_users($current_page, 12, $param_arr);

        // pagination output
        $response["links"] = $this->pagination->create_links();

        echo json_encode($response,TRUE);

    }
    
    public function ajaxCanvasRequest(){
        $response=array();

        $response['mon_chart']=$this->user_model->chart_stats_mon($this->input->post('year'));
        echo json_encode($response,TRUE);
    }
}
