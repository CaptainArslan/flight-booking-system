<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends PL_Controller {
	public function __construct(){
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url().'?err=no_login');
		}
		$this->headdata = array(
            'head' => array(
                'page_title' => '',
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
		$this->load->model('brands_model');
	}
	public function index(){
		$data = $this->headdata ;
		$data['d_page_title'] = 'Brands';
		$data['head']['page_title'] = $data['d_page_title'] ;
        $data["brands"] = $this->brands_model->GetBrands();
        $data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'manage_brands_view')){
        	$this->load->view('brands/list', $data);	
        }else{
        	$this->load->view('access_denied', $data);
        }
	}
	public function add_brand(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'brand_add')){
			$data = $this->input->post();
			$config['upload_path'] = './assets/images/brand_logo'; //path folder
	        $config['allowed_types'] = 'jpg|png|jpeg|bmp'; //Allowing types
	        $config['encrypt_name'] = TRUE; //encrypt file name 
	 		
	 		$this->load->library('upload', $config);
	 		if(!empty($_FILES['brand_logo']['name'])){
	 			$this->upload->do_upload('brand_logo');
	 			$upload_name   = $this->upload->data();
                $data['image']  = $upload_name['file_name']; //get file name
	 		}
			$id = $this->brands_model->addbrand($data);
			if($id){
				$response = array(
					'status' => 'success',
					'response' => 'Brand has been added'
				);
				$this->session->set_flashdata('notify', json_encode($response));
				redirect(base_url().'brands');
			}else{
				$response = array(
					'status' => 'error',
					'response' => 'There was a issue while adding brand'
				);
				$this->session->set_flashdata('notify', json_encode($response));
				redirect(base_url().'brands');
			}
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'You are not allowed to add brands'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			redirect(base_url().'brands');
		}
	}
	public function edit_brand($value=''){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'brand_edit')){
			$data = $this->input->post();
			$config['upload_path'] = './assets/images/brand_logo'; //path folder
	        $config['allowed_types'] = 'jpg|png|jpeg|bmp'; //Allowing types
	        $config['encrypt_name'] = TRUE; //encrypt file name 
	 		
	 		$this->load->library('upload', $config);
	 		if(!empty($_FILES['brand_logo']['name'])){
	 			$this->upload->do_upload('brand_logo');
	 			$upload_name   = $this->upload->data();
                $data['image']  = $upload_name['file_name']; //get file name
	 		}
			$id = $this->brands_model->editbrand($data);
			if($id){
				$response = array(
					'status' => 'success',
					'response' => 'Brand has been Edit'
				);
				$this->session->set_flashdata('notify', json_encode($response));
				redirect(base_url().'brands');
			}else{
				$response = array(
					'status' => 'error',
					'response' => 'There was a issue while adding brand'
				);
				$this->session->set_flashdata('notify', json_encode($response));
				redirect(base_url().'brands');
			}
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'You are not allowed to edit brands'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			redirect(base_url().'brands');
		}
	}
	public function view_brandajax(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'brand_view')){
			$data = $this->input->post();
	        $data["brand_details"] = $this->brands_model->ajaxBrand_view($data['brand_id']);
			$html = $this->load->view('brands/ajax/view', $data, true);
			echo json_encode($html);
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'You are not allowed to view brands'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			$html = "false";
			echo json_encode($html);
		}
	}
	public function edit_brandajax(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'brand_edit')){
			$data = $this->input->post();
	        $data["brand_details"] = $this->brands_model->ajaxBrand_view($data['brand_id']);
			$html = $this->load->view('brands/ajax/edit', $data, true);
			echo json_encode($html);
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'You are not allowed to edit brands'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			$html = "false";
			echo json_encode($html);
		}
	}
	public function delete_brand(){
		$data['session_role'] = $this->session->userdata('user_role');
        if(checkAccess($data['session_role'],'brand_delete')){
			$data = $this->input->post();
			$result = $this->brands_model->deletebrand($data['brand_id']);
			$response = array(
				'status' => 'success',
				'response' => 'Brand has been Deleted'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo "true";
		}else{
			$response = array(
				'status' => 'error',
				'response' => 'You are not allowed to delete brands'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo "false";
		}
	}
}
/* End of file Brands.php */
/* Location: ./application/controllers/Brands.php */