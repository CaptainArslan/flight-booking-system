<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends PL_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url('?err=no_login'));
		}
		$this->headdata = array(
            'head' => array(
                'page_title' => 'Reports',
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
		$this->load->model('reports_model');
	}
	public function index()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata ;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (!checkAccess($user_role, 'all_agents_reports')) {
			$agent = $user_name;
		}
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		$data['d_page_title'] = "Booking Reports";
		$data['head']['page_title'] = $data['d_page_title'] ;
		if (checkAccess($user_role, 'reports_view')) {
			$sup = $card =  '';
			$data['brands'] = $this->reports_model->getbrands($brand);
			$data['agents'] = $this->reports_model->getagents($agent, $brand);
			$data['suppliers'] = $this->reports_model->getsuppliers($sup);
			$data['cards'] = $this->reports_model->getcards($card);
			$data['reports'] = $this->reports_model->getreport($user_role);
			$this->load->view('reports/index', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function gross_profit_earned()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'gross_profit_earned')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_gross_profit_earned($data);
			$result['html'] = $this->load->view('reports/ajax/report_gross_profit_earned', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function net_profit_earned()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'net_profit_earned')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_gross_profit_earned($data);
			$data['brand_com_rate'] = 0;
			if ($data['brand'] != 'All') {
				$data['brand_com_rate'] = $this->reports_model->getcommisionrate($data['brand']);
			}
			$data['expenses'] = $this->reports_model->getexpenses($data);
			if ($data['brand'] == $this->mainbrand ) {
				$data['other_income'] = $this->reports_model->getotherincome($data);
				$data['sub_agent'] = $this->reports_model->getsubcommision($data);
			}
			$result['html'] = $this->load->view('reports/ajax/report_net_profit_earned', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function client_data()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'client_data')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_client_data($data);
			$result['html'] = $this->load->view('reports/ajax/report_client_data', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function customer_due_balance()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'customer_due_balance')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_customer_due_balance($data);
			$result['html'] = $this->load->view('reports/ajax/report_customer_due_balance', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function supplier_due_balance()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'supplier_due_balance')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_supplier_due_balance($data);
			$result['html'] = $this->load->view('reports/ajax/report_supplier_due_balance', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function supplier_variance_p_t()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'supplier_variance_p_t')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_supplier_variance_p_t($data);
			$result['html'] = $this->load->view('reports/ajax/report_supplier_variance_p_t', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function cust_direct_payment_supplier()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'cust_direct_payment_supplier')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_cust_direct_payment_supplier($data);
			$result['html'] = $this->load->view('reports/ajax/report_cust_direct_payment_supplier', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function card_charge_report()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'cust_direct_payment_supplier')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_card_charge_report($data);

			$result['html'] = $this->load->view('reports/ajax/report_card_charge_report', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function activity_summary()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'cust_direct_payment_supplier')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_activity_summary($data);
			$result['html'] = $this->load->view('reports/ajax/report_activity_summary', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function gds_report()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'cust_direct_payment_supplier')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_gds_report($data);
			$result['html'] = $this->load->view('reports/ajax/report_gds_report', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function s_p_report()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'cust_direct_payment_supplier')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_s_p_report($data);
			$result['html'] = $this->load->view('reports/ajax/report_s_p_report', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function sale_variance_file_t_report($value = '')
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'cust_direct_payment_supplier')) {
			if (!checkAccess($user_role, 'all_agents_reports')) {
				$data['agent'] = $user_name;
			}
			if (!isset($data['brand']) && $user_brand != 'All') {
				$data['brand'] = $user_brand;
			}
			$data['report_details'] = $this->reports_model->report_s_p_report($data);
			$result['html'] = $this->load->view('reports/ajax/report_sale_variance_file_t_report', $data, true);
			$result['status'] = 'true';
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
}

/* End of file Reports.php */
/* Location: ./application/controllers/Reports.php */
