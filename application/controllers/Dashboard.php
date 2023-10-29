<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends PL_Controller {
    var $headdata ;
    public function __construct()
    {
        parent::__construct();
        if(!checkLogin()) {
			redirect(base_url("login?err=no_login"));
		}
        $this->headdata = array(
            'head' => array(
                'page_title' => 'Dashboard',
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
        $this->load->model('dash_model');
        $this->load->model('progress_model');
        $this->load->model('reports_model');
        
    }
    public function index()
    {
        $data = $this->headdata ;
        $data["role"] = $this->session->userdata('user_role');
		$brand = $this->session->userdata('user_brand');
		if (checkAccess($data["role"], 'all_agent')) {
			$agent = 'All';
		} else {
			$agent = $this->session->userdata('user_name');
		}
		$data["total_bookings"] = $this->dash_model->gettotalbookings($brand, $agent);
		$data["month_bookings"] = $this->dash_model->getmonthbookings($brand, $agent);
		$data["month_margin"] = $this->dash_model->getmonthmargin($brand, $agent);
		$data["ttldeptdue"] = $this->dash_model->get_ttl_dept_due($brand, $agent);
		$data["returned"] = $this->dash_model->getreturned($brand, $agent);
		$data["b_days"] = $this->dash_model->getb_days($brand, $agent);
		$data["total_pending_inq"] = $this->dash_model->getpendinginq($brand, $agent);
		$data["progressheet"] = $this->progress_model->progress_sheet($brand, $agent);
		$data['sdate'] = $sdate = date('Y-m-01');
		$data['edate'] = $edate = date('Y-m-t');
		$data['brand'] = $brand;
		$data['start_date'] = $sdate;
		$data['end_date'] = $edate;
		$data['agent'] = $agent;
		$data['supplier'] = '';
		$data['brand_com_rate'] = $this->reports_model->getcommisionrate($data['brand']);
		$data['expenses'] = $this->reports_model->getexpenses($data);
		$data['other_income'] = $this->reports_model->getotherincome($data);
		$data['sub_agent'] = $this->reports_model->getsubcommision($data);
		if (checkAccess($data["role"], 'dashboard_view')) {
			$this->load->view('dashboard/index', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
        
    }
	public function progform()
	{
		$data = $this->input->post();
		$date = $data['report_month'];
		$data['sdate'] = $sdate = date('Y-m-01', strtotime($date));
		$data['edate'] = $edate = date('Y-m-t', strtotime($date));
		$data["role"] = $this->session->userdata('user_role');
		if (isset($data['report_brand'])) {
			$brand = $data['report_brand'];
		} else {
			$brand = $this->session->userdata('user_brand');
		}
		if (checkAccess($data["role"], 'all_agent')) {
			$agent = 'All';
		} else {
			$agent = $this->session->userdata('user_name');
		}
		$data['brand'] = $brand;
		$data['start_date'] = $sdate;
		$data['end_date'] = $edate;
		$data['agent'] = $agent;
		$data['supplier'] = '';
		$data["progressheet"] = $this->progress_model->progress_sheet($brand, $agent, $sdate, $edate);
		$data['brand_com_rate'] = $this->reports_model->getcommisionrate($data['brand']);
		$data['expenses'] = $this->reports_model->getexpenses($data);
		$data['other_income'] = $this->reports_model->getotherincome($data);
		$data['sub_agent'] = $this->reports_model->getsubcommision($data);
		if ($data["progressheet"] != 'false') {
			$html = $this->load->view('dashboard/ajax/progresssheetajax', $data, true);
			echo json_encode($html);
		} else {
			echo json_encode('error');
		}
	}
	public function checknotification()
	{
		$notify['count'] = $this->dash_model->getnoticount();
		$notify['notifications'] = $this->dash_model->getnoti();
		$notify['html'] = $this->load->view('ajax/notify_menu', $notify, true);
		$notify['reminder'] = $this->dash_model->getreminders();
		echo json_encode($notify);
	}
	public function updatenotitoaster()
	{
		$id = $this->input->post('id');
		$status = $this->dash_model->removetoaster($id);
		echo $status;
	}
	public function updatenqremindernotify()
	{
		$id = $this->input->post('id');
		$status = $this->dash_model->removereminderpopup($id);
		echo $status;
	}

}

/* End of file Dashboard.php */
