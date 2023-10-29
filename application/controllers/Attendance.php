<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends PL_Controller {
	public function __construct(){
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url('login?err=no_login'));
		}
		$this->headdata = array(
            'head' => array(
                'page_title' => 'Accounts',
                'css' => array(
                    // 'assets/css/accounts.css',
                ),
            ),
            'scripts' => array(
                'js' => array(
                    // 'assets/libs/datatables/jquery.dataTables.min.js',
                ),
            ),
        );
		$this->load->model('attendance_model');
	}
	public function index(){
		$data = $this->headdata ;
		$data['d_page_title'] = "Attendance";
		$data['head']['page_title'] = $data['d_page_title'] ;
        $data['session_role'] = $this->session->userdata('user_role');
        $user_id = $this->session->userdata('user_id');
        $user_name = $this->session->userdata('user_name');
        $user_brand = $this->session->userdata('user_brand');
        $this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_name !=', 'IT Manager');
    	if(checkAccess($data['session_role'],'attendance_own')){
    		$this->db->where('user_id', $user_id);
    	}	
    	if($user_brand != 'All'){
			$this->db->where('user_brand', $user_brand);
		}
    	$data['agents'] = $this->db->get()->result_array();	
		$selectedMonth = date('m');
		$selectedYear = date('Y');
		if ($this->input->get('attendance_month')) {
			$date = explode('-',$this->input->get('attendance_month'));
			$selectedMonth = date('m', strtotime($date[0]));
			$selectedYear = date('Y', strtotime($date[1]));
		}
		$data['calendar'] = $this->attendance_model->GetCalendar($selectedMonth, $selectedYear);
		$data['selectedMonth'] = $selectedMonth;
		$data['selectedYear'] = $selectedYear;
		$data['totalDays'] = $data['calendar']['totalDays'];
		unset($data['calendar']['totalDays']);
		$this->load->view('attendance/index', $data);
	}

	public function mark_attendance(){
		$data = $this->input->post();
		$return = $this->db->select('*')->from('attendance')->where('user_id', $data['user_id'])->where('att_date', date('Y-m-d', strtotime($data['attendance_date'])))->get()->row_array();
		if (!empty($return)) {
			$this->db->set('user_id', $data['user_id'])->set('att_date', date('Y-m-d', strtotime($data['attendance_date'])))->set('status', $data['attendance_status'])->set('timestamp', date('Y-m-d H:i', strtotime($data['attendance_date'])))->where('att_id', $return['att_id'])->update('attendance');
			$response = array(
				'status' => 'success',
				'response' => 'Attendance has been marked successfully'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			redirect(base_url('attendance'));
		}else{
			$this->db->set('user_id', $data['user_id'])->set('att_date', date('Y-m-d', strtotime($data['attendance_date'])))->set('status', $data['attendance_status'])->set('timestamp', date('Y-m-d H:i', strtotime($data['attendance_date'])))->insert('attendance');
			$response = array(
				'status' => 'success',
				'response' => 'Attendance has been marked successfully'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			redirect(base_url('attendance'));
		}
	}
}
/* End of file Attendance.php */
/* Location: ./application/modules/attendance/controllers/Attendance.php */