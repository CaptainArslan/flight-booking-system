<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pending_task extends PL_Controller
{

	public $headdata = array();
	public function __construct()
	{
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url('login?err=no_login'));
		}
		$this->headdata = array(
            'head' => array(
                'page_title' => 'Pending Task',
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
		$this->load->model('accounts_model');
		$this->load->model('pending_task_model');
		$this->load->model('mailer_model');
		$this->load->model('booking_model');
	}
	public function index()
	{
		$data = $this->headdata ;
		$user_name = $this->session->userdata('user_name');
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$user_brand = $this->session->userdata('user_brand');
		$agent = $brand = '';
		if (!checkAccess($user_role, 'all_agents_pending_task')) {
			$agent = $user_name;
		}
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		$data['pay_tasks'] = $this->pending_task_model->getPaytasks('', $agent, $brand);
		$data['tkt_tasks'] = $this->pending_task_model->getTkttasks('', $agent, $brand);
		if (checkAccess($user_role, 'pending_task_view')) {
			$this->load->view('pending_task/index', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function deletePtask()
	{
		$data = $this->input->post();
		$data['task_method'] = 'deleted';
		$data['status'] = $this->pending_task_model->deletePaytask($data);
		if ($data['status'] == 'true') {
			$this->mailer_model->mail_ptask_delete($data['pid']);
		}
		echo json_encode($data);
	}
	public function deleteTktTask()
	{
		$data = $this->input->post();
		$data['task_method'] = 'deleted';
		$data['status'] = $this->pending_task_model->deletettask($data);
		if ($data['status'] == 'true') {
			$this->mailer_model->mail_ttask_delete($data['tid']);
		}
		echo json_encode($data);
	}
	public function declineTkttask()
	{
		$data = $this->input->post();
		$data['task_method'] = 'declined';
		$data['status'] = $this->pending_task_model->deletettask($data);
		if ($data['status'] == 'true') {
			$this->mailer_model->mail_ttask_decline($data['tid']);
		}
		echo json_encode($data);
	}
	public function declinePtask()
	{
		$data = $this->input->post();
		$data['task_method'] = 'declined';
		$data['status'] = $this->pending_task_model->deletePaytask($data);
		if ($data['status'] == 'true') {
			$this->mailer_model->mail_ptask_decline($data['pid']);
		}
		echo json_encode($data);
	}
	public function confirmOtask()
	{
		$data = $this->input->post();
		$data['status'] = $this->pending_task_model->confirmOtherTask($data);
		if ($data['status'] == 'true') {
			$this->mailer_model->mail_ptask_confirm($data['pid']);
		}
		echo json_encode($data);
	}
	public function addtransajax()
	{
		$data['p_id'] = $this->input->post('pid');
		$data['trans_head'] = $this->accounts_model->GetTransHead();
		$data['trans_details'] = $this->pending_task_model->getPaytasks($data['p_id']);
		$html = $this->load->view('pending_task/ajax/addtranspendingtask', $data, true);
		echo json_encode($html);
	}
	public function paddTrans()
	{
		$data = array();
		$trans_data = $this->input->post();
		$transadd = $this->accounts_model->AddTransaction($trans_data);
		if ($transadd) {
			$data = $this->pending_task_model->confirmPaytask($this->input->post('p_id'), $this->input->post('trans_desc'));
			if ($data['status'] == true) {
				$this->mailer_model->mail_ptask_confirm($this->input->post('p_id'));
			}
		}
		echo json_encode($data);
	}
	public function pendingtaskajax($value = '')
	{
		$data['pay_tasks'] = $this->pending_task_model->getPaytasks();
		$data['tkt_tasks'] = $this->pending_task_model->getTkttasks();
		$html = $this->load->view('ajax/pendingtask', $data, true);
		echo json_encode($html);
	}
	public function issuetkt()
	{
		$data = $this->input->post();
		$updateBooking = $this->booking_model->updateBookingissuance($data);
		if ($updateBooking ==  true) {
			$issuanceData = array();
			$issuanceData['admin_cost'] = (float)$data["cost_bank_charges_internal"] + (float)$data["cost_cardcharges"] + (float)$data["cost_postage"] + (float)$data["cost_cardverfication"];
			$issuanceData['total_sale'] = (float)$data["totalsale"];
			$issuanceData['profit'] = (float)$issuanceData['total_sale'] -  (float)$issuanceData['admin_cost'];
			$issuanceData['flight'] = $data['flight'];
			if ($data['flight']) {
				$issuanceData['flt_sup'] = $data["supplier_name"];
				$issuanceData['flt_price'] = $data["totalflight"];
				$issuanceData['flt_cost'] = (float)$data["cost_basic"] + (float)$data["cost_tax"] + (float)$data["cost_apc"] + (float)$data["cost_misc"];
				$issuanceData['profit'] -= $issuanceData['flt_cost'];
			}
			$issuanceData['hotel'] = $data['hotel'];
			if ($data['hotel']) {
				$issuanceData['htl_sup'] = $data['htl_sup'];
				$issuanceData['htl_price'] = $data["totalhotel"];
				$issuanceData['htl_cost'] = $data['htl_cost'];
				$issuanceData['profit'] -= $issuanceData['htl_cost'];
			}
			$issuanceData['cab'] = $data['cab'];
			if ($data['cab']) {
				$issuanceData['cab_sup'] = $data['cab_sup'];
				$issuanceData['cab_price'] = $data["totalcab"];
				$issuanceData['cab_cost'] = $data['cab_cost'];
				$issuanceData['profit'] -= $issuanceData['cab_cost'];
			}
			$issuanceData['apc_payable'] = (float)$data["cost_postage"];
			$issuanceData['bkg_no'] = $data["bkg_no"];
			$issuanceData['issue_date'] = $data["issue_date"];
			$salepurchase = $this->booking_model->insertSalePurchase($issuanceData);
			$taskdone = $this->pending_task_model->confirmtkttask($data['pid']);
			if ($taskdone['status'] == 'true') {
				$this->mailer_model->mail_ttask_confirm($data['pid']);
			}
			echo json_encode($taskdone);
		}
	}
	public function confirmTkttask()
	{
		$data = $this->input->post();
		$data['status'] = $this->pending_task_model->confirmtkttask($data['tid']);
		if ($data['status'] == 'true') {
			$this->mailer_model->mail_ttask_confirm($data['tid']);
		}
		echo json_encode($data);
	}
}
/* End of file Pending_task.php */
/* Location: ./application/controllers/Pending_task.php */
