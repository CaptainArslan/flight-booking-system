<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_level extends PL_Controller {

	public function __construct(){
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url('login?err=no_login'));
		}
		$this->headdata = array(
            'head' => array(
                'page_title' => 'Booking',
                'css' => array(
                    //'assets/css/style0.css',
                ),
            ),
            'scripts' => array(
                'js' => array(
                    //'assets/js/js0.js',
                ),
            ),
        );
		$this->load->model('accesslevel_model');
	}
	public function index(){
		$data = $this->headdata ;
		$data['d_page_title'] = 'Access Level Settings';
		$data['head']['page_title'] = $data['d_page_title'] ;
        $data["roles"] = $this->accesslevel_model->getroles();
        $data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'access_level_view')){
        	$this->load->view('access/levels', $data);	
        }else{
        	$this->load->view('access_denied', $data);
        }	
	}
	public function add_role(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'role_add')){
			if ($this->input->post()) {
				$data = $this->input->post();
				$this->accesslevel_model->addnewrole($data);
				$response = array(
					'status' => 'success',
					'response' => 'Access level has been added'
				);
				$this->session->set_flashdata('notify', json_encode($response));
				echo "true";
			}
		}else{
			$response = array(
					'status' => 'error',
					'response' => 'You are not allowed to add access level'
				);
				$this->session->set_flashdata('notify', json_encode($response));
				echo "true";
		}
	}
	public function viewAlAjax(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'role_view')){
			$data = $this->input->post();
			$data['role_access'] = $this->accesslevel_model->getAccessDetails($data['role_id']);
			$html = $this->load->view('access/ajax/view', $data, true);
			echo json_encode($html);
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'You are not allowed to View access level'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			$html = "false";
			echo json_encode($html);
		}
	}
	public function editAlAjax(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'role_edit')){
			$data = $this->input->post();
			$data['details'] = $this->accesslevel_model->editAccessDetails($data['role_id']);
			$data['role_access'] = array_column($data['details']['role_access'], 'access_name');
			$html = $this->load->view('access/ajax/edit', $data, true);
			echo json_encode($html);
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'You are not allowed to Edit access level'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			$html = "false";
			echo json_encode($html);
		}
	}
	public function edit_role(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'role_edit')){
			$data = $this->input->post();
			$this->accesslevel_model->editrole($data);
			$response = array(
				'status' => 'success',
				'response' => 'Access level has been edit'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo "true";
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'You are not allowed to Edit access level'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo "true";
		}
	}
	public function delete_role(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'role_delete')){
			$data = $this->input->post();
			$result = $this->accesslevel_model->deleterole($data);
			if($result>0){
				echo "true";
				$response = array(
					'status' => 'success',
					'response' => 'Access level has been Deleted'
				);
				$this->session->set_flashdata('notify', json_encode($response));
			}else{
				$response = array(
					'status' => 'error',
					'response' => 'Access level has not been Deleted'
				);
				$this->session->set_flashdata('notify', json_encode($response));
				echo "false";
			}
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'You are not allowed to delete access level'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo "true";
		}
	}
}
/* End of file Access-level.php */
/* Location: ./application/controllers/Access-level.php */