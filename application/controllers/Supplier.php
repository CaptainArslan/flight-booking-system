<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Supplier extends PL_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url('?err=no_login'));
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
		$this->load->model('supplier_model');
	}
	public function index()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata ;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = 'Suppliers';
		$data['head']['page_title'] = $data['d_page_title'] ;
		if (checkAccess($user_role, 'supplier_list')) {
			$data['suppliers'] = $this->supplier_model->getsupplier();
			$this->load->view('supplier/list', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function add()
	{
		$data = $this->input->post();
		$result = $this->supplier_model->addsup($data);
		if ($result == 'added') {
			$response = array(
				'status' => 'success',
				'response' => 'Supplier Added Successfully...!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		} else if ($result == 'exist') {
			$response = array(
				'status' => 'error',
				'response' => 'Supplier Already Exist...!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'There was some error please try again later...!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		}
		redirect('supplier', 'refresh');
	}
	public function viewajax()
	{
		$id = $this->input->post('id');
		$data['sup_details'] = $this->supplier_model->getsupplier($id);
		$html = $this->load->view('supplier/ajax/view', $data, TRUE);
		echo json_encode($html);
	}
	public function editajax()
	{
		$id = $this->input->post('id');
		$data['sup_details'] = $this->supplier_model->getsupplier($id);
		$html = $this->load->view('supplier/ajax/edit', $data, TRUE);
		echo json_encode($html);
	}
	public function update()
	{
		$data = $this->input->post();
		$result = $this->supplier_model->updatesup($data);
		if ($result == 'updated') {
			$response = array(
				'status' => 'success',
				'response' => 'Supplier Updated Successfully...!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		} else if ($result == 'exist') {
			$response = array(
				'status' => 'error',
				'response' => 'Supplier Name Already Exist...!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'There was some error please try again later...!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		}
		redirect('supplier', 'refresh');
	}
	public function delete()
	{
		$id = $this->input->post('id');
		$this->db->where('supplier_id', $id);
		$this->db->delete('suppliers');
		$response = array(
			'status' => 'success',
			'response' => 'Supplier Deleted Successfully...!!!'
		);
		$this->session->set_flashdata('notify', json_encode($response));
		echo json_encode(TRUE);
	}
}
/* End of file Supplier.php */
