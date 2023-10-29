<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url().'?err=no_login');
		}
		$this->load->model('reports_model');
	}
	public function exportexcel(){
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
        $data['user_role'] = $user_role = $this->session->userdata('user_role');
        $data['user_name'] = $user_name = $this->session->userdata('user_name');
        $data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
    	if(!checkAccess($user_role,'all_agents_reports')){
            $data['agent'] = $user_name;
        }
        if(!isset($data['brand']) && $user_brand != 'All'){
            $data['brand'] = $user_brand;
        }
		if($data['report_name'] == 'gross_profit_earned'){
			$data['report_details'] = $this->reports_model->report_gross_profit_earned($data);
			$this->load->view('reports/excel/report_gross_profit_earned',$data);
		}elseif($data['report_name'] == 'net_profit_earned'){
			$data['report_details'] = $this->reports_model->report_gross_profit_earned($data);
			$data['brand_com_rate'] = 0;
			if($data['brand'] != 'All'){
				$data['brand_com_rate'] = $this->reports_model->getcommisionrate($data['brand']);
			}
			$data['expenses'] = $this->reports_model->getexpenses($data);
			if($data['brand'] == $this->mainbrand ){
				$data['other_income'] = $this->reports_model->getotherincome($data);
				$data['sub_agent'] = $this->reports_model->getsubcommision($data);
			}
			$this->load->view('reports/excel/report_net_profit_earned',$data);
		}else if($data['report_name'] == 'client_data'){
			$data['report_details'] = $this->reports_model->report_client_data($data);
			$this->load->view('reports/excel/report_client_data',$data);
		}else if($data['report_name'] == 'customer_due_balance'){
			$data['report_details'] = $this->reports_model->report_customer_due_balance($data);
			$this->load->view('reports/excel/report_customer_due_balance',$data);
		}else if($data['report_name'] == 'supplier_due_balance'){
			$data['report_details'] = $this->reports_model->report_supplier_due_balance($data);
			$this->load->view('reports/excel/report_supplier_due_balance',$data);
		}else if($data['report_name'] == 'supplier_variance_p_t'){
			$data['report_details'] = $this->reports_model->report_supplier_variance_p_t($data);
			$this->load->view('reports/excel/report_supplier_variance_p_t',$data);
		}else if($data['report_name'] == 'cust_direct_payment_supplier'){
			$data['report_details'] = $this->reports_model->report_cust_direct_payment_supplier($data);
			$this->load->view('reports/excel/report_cust_direct_payment_supplier',$data);
		}else if($data['report_name'] == 'card_charge_report'){
			$data['report_details'] = $this->reports_model->report_card_charge_report($data);
			$this->load->view('reports/excel/report_card_charge_report',$data);
		}else if($data['report_name'] == 'gds_report'){
			$data['report_details'] = $this->reports_model->report_gds_report($data);
			$this->load->view('reports/excel/report_gds_report',$data);
		}else if($data['report_name'] == 's_p_report'){
			$data['report_details'] = $this->reports_model->report_s_p_report($data);
			$this->load->view('reports/excel/report_s_p_report',$data);
		}
	}
}

/* End of file Export.php */
/* Location: ./application/controllers/Export.php */