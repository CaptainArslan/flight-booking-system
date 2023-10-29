<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends PL_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->headdata = array(
            'head' => array(
                'page_title' => 'Users',
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
	}
	public function login(){
		if(checkLogin()) {
			redirect(base_url("dashboard"));
		}
		$this->load->view('user/login');
	}
	public function users(){
		if (!checkLogin()) {
			redirect(base_url('login?err=no_login'));
		}
		$data = $this->headdata;  
		$data['d_page_title'] = "Users";
		$data['head']['page_title'] = $data['d_page_title'] ;
        $data["users"] = $this->user_model->GetUsers();
        $data["roles"] = $this->user_model->GetRoles();
        $data["brands"] = $this->user_model->GetBrands();
        $data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'users_view')){
        	$this->load->view('user/list', $data);	
        }else{
        	$this->load->view('access_denied', $data);
        }
	}
	public function validate_login(){		
		$data = xss_clean($this->input->post());
		$record = $this->user_model->checkLogin($data);
		if(empty($record)) {
			redirect(base_url('?err=no_record&user_name='.$data['username']));
		}
		if($record['user_status'] == 'inactive') {
			redirect(base_url('?err=acc_inactive&user_name='.$data['username']));
		}
		$this->session->set_userdata('user_status', 'loged_in');
		$this->session->set_userdata('user_id', $record['user_id']);
		$this->session->set_userdata('user_name', $record['user_name']);
		$this->session->set_userdata('user_role', $record['user_role']);
		$this->session->set_userdata('user_brand', $record['user_brand']);
		$this->session->set_userdata('sessionkey', generateRandomString(100));
		if(checkAccess($record['user_role'],'attendance_mark')){
			$this->user_model->insertAttendance($record);
		}
		if (checkAccess($record['user_role'], 'dashboard_view')) {		
			redirect(base_url('dashboard'));
		}else{
			redirect(base_url('pending_task'));
		}
	}
	public function logout(){
		$this->session->unset_userdata('user_status');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_name');
		$this->session->unset_userdata('user_role');
		$this->session->unset_userdata('user_brand');
		$this->session->unset_userdata('sessionkey');
		redirect('login?err=logout');
	}
	public function profile($user_id=''){
		if (!checkLogin()) {
			redirect(base_url('login?err=no_login'));
		}
		$user_id = hashing($user_id,'d');
		if($user_id != ''){
			$data = array(
				'head' => array(
					'page_title' => 'User Profile',
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
			$data["profile"] = $this->user_model->Getuserprofile($user_id);
	        $data['role_has_access'] = $this->session->userdata('user_role');
	        if(checkAccess($data['role_has_access'],'profile_all_users') || ($this->session->userdata('user_id') == $user_id)){
	        	$this->load->view('user/profile', $data);	
	        }else{
				$data = array(
					'head' => array(
						'page_title' => 'Access Denied',
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
	        	$this->load->view('access_denied', $data);
	        }
	    }else{
			$data = array(
				'head' => array(
					'page_title' => 'Access Denied',
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
	    	$this->load->view('access_denied', $data);
	    }
	}
	public function add_user(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'user_add')){
			$data = $this->input->post();
			$this->user_model->addnewuser($data);
			$response = array(
				'status' => 'success',
				'response' => 'User has been added'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo "true";
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'Your are not allowed to add user'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo "true";
		}
	}
	public function edit_user(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'user_edit')){
			$data = $this->input->post();
			$this->user_model->edituser($data);
			$response = array(
				'status' => 'success',
				'response' => 'User has been Updated'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo "true";
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'Your are not allowed to edit user'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo "true";
		}
	}
	public function delete_user(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'user_delete')){
			$data = $this->input->post();
			$result = $this->user_model->deleteuser($data['user_id']);
			echo "true";
			$response = array(
				'status' => 'success',
				'response' => 'User has been Deleted'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'Your are not allowed to delete user'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo "true";
		}
	}
	public function edit_userajax(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'user_edit')){
			$data = $this->input->post();
	        $data["roles"] = $this->user_model->GetRoles();
	        $data["brands"] = $this->user_model->GetBrands();
			$data['user_detail'] = $this->user_model->edituserdetails($data['user_id']);
			$html = $this->load->view('user/ajax/edituser', $data, true);
			echo json_encode($html);
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'Your are not allowed to edit user'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			$html = "false";
			echo json_encode($html);
		}
	}
	public function do_upload(){
		$config['upload_path'] = './assets/images/users'; //path folder
        $config['allowed_types'] = 'JPG|jpg|png|jpeg|bmp'; //Allowing types
        $config['encrypt_name'] = TRUE; //encrypt file name 
 		
 		$this->load->library('upload', $config);
 		$data = $this->input->post();
 		if(!empty($_FILES['filefoto']['name'])){ 
 			//$error = array('error' => $this->upload->display_errors());
            if ($this->upload->do_upload('filefoto')){ 
                $upload_name   = $this->upload->data();
                $data['image']  = $upload_name['file_name']; //get file name
                $result = $this->user_model->updateProfile($data);
                if($result > 0){
                	$response = array(
						'status' => 'success',
						'response' => 'Profile has been updated'
					);
					$this->session->set_flashdata('notify', json_encode($response));
					redirect(base_url().'user/profile/'.hashing($data['user_id']),'refresh');
                }else{
                	$response = array(
						'status' => 'error',
						'response' => 'There was a problem updating the profile.'
					);
					$this->session->set_flashdata('notify', json_encode($response));
					redirect(base_url().'user/profile/'.hashing($data['user_id']),'refresh');
                }                
            }else{
            	$response = array(
					'status' => 'error',
					'response' => 'Upload failed. Image file must be gif|jpg|png|jpeg|bmp'
				);
				$this->session->set_flashdata('notify', json_encode($response));
				redirect(base_url().'user/profile/'.hashing($data['user_id']),'refresh');
            }                      
        }else{
            $result = $this->user_model->updateProfile($data);
            if($result > 0){
            	$response = array(
					'status' => 'success',
					'response' => 'Profile has been updated'
				);
				$this->session->set_flashdata('notify', json_encode($response));
				redirect(base_url().'user/profile/'.hashing($data['user_id']),'refresh');
            }else{
            	$response = array(
					'status' => 'error',
					'response' => 'There was a problem updating the profile.'
				);
				$this->session->set_flashdata('notify', json_encode($response));
				redirect(base_url().'user/profile/'.hashing($data['user_id']),'refresh');
            }            
        }
	}
}
