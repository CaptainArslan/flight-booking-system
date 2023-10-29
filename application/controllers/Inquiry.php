<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inquiry extends PL_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url('?err=no_login'));
		}
		$this->headdata = array(
            'head' => array(
                'page_title' => 'Inquiries',
                'css' => array(
                    'assets/libs/datatables/jquery.dataTables.min.css',
                ),
            ),
            'scripts' => array(
                'js' => array(
                    'assets/libs/datatables/jquery.dataTables.min.js',
                    'assets/libs/datatables/dataTables.buttons.min.js',
                    'assets/libs/datatables/dataTables.select.min.js',
                    'assets/js/inq_reports.js',
                    'assets/js/inquiry.js',
                ),
            ),
        );
		$this->load->model('inquiry_model');
	}
	public function unpicked()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata ;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = 'New Inquiries';
		$data['head']['page_title'] = $data['d_page_title'] ;
		if (!empty($_REQUEST) && checkAccess($user_role, 'admin_view_new_inq')) {
			if (!empty($_REQUEST['agent'])) {
				$data['agent'] = $agent = $_REQUEST['agent'];
			} else {
				$agent = '';
			}
			if (!empty($_REQUEST['brandname'])) {
				$data['brandname'] = $brand = $_REQUEST['brandname'];
			}
		}
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}else if(isset($_POST['brand'])){
			$brand = $this->input->post('brand');
		}
		$page = "unpicked";
		$data['agents'] = $this->inquiry_model->getinqAgents($brand);
		$data['brands'] = $this->inquiry_model->getinqBrands();
		$data['header'] = $this->inquiry_model->inq_headerdata($brand, $agent);
		$data['new'] = $this->inquiry_model->getinq_new('', '', '', '', TRUE, '',$brand);
		$data['tdp'] = $this->inquiry_model->getinq_tdp('', '', '', '', TRUE, '',$brand,$agent,$page);
		$data['rem'] = $this->inquiry_model->getinq_rem('', '', '', '', TRUE, '',$brand,$agent,$page);
		if (checkAccess($user_role, 'new_inq_view')) {
			$this->load->view('inquiry/new', $data);
		} else {
			$this->load->view('access_denied', $data);
		}		
	}
	public function getinquiries()
    {
		$user_role = $agent = $brand = '';
		$data = $this->headdata ;
		$user = $this->input->post('user');
		$type = $this->input->post('type');
		$page = "unpicked";
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (!empty($_REQUEST) && checkAccess($user_role, 'admin_view_new_inq')) {
			if (!empty($_REQUEST['agent'])) {
				$data['agent'] = $agent = $_REQUEST['agent'];
			} else {
				$agent = '';
			}
			if (!empty($_REQUEST['brandname'])) {
				$data['brandname'] = $brand = $_REQUEST['brandname'];
			}
		}
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}else if(isset($_POST['brand'])){
			$brand = $this->input->post('brand');
		}
		$columns = array(
			0 => 'enq_id',
			1 => 'enq_brand',
			2 => 'enq_receive_time',
			3 => 'enq_dept_date',
			4 => 'enq_dest',
			5 => 'enq_cust_name',
			6 => 'enq_cust_phone',
			7 => 'enq_cust_email',
			8 => 'enq_page',
			9 => 'enq_device',
			10 => 'enq_type',
			11 => 'picked_by',
		);
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		if($type=='new'){
			$totalData = $this->inquiry_model->getinq_new('', '', '', '', TRUE, '',$brand);
		}else if($type=='tdp'){
			$totalData = $this->inquiry_model->getinq_tdp('', '', '', '', TRUE, '',$brand,$agent,$page);
		}else if($type=='rem'){
			$totalData = $this->inquiry_model->getinq_rem('', '', '', '', TRUE, '',$brand,$agent,$page);	
		}
		$totalFiltered = $totalData;
		if (empty($this->input->post('search')['value'])) {
			if($type=='new'){
				$posts = $this->inquiry_model->getinq_new($limit, $start, $order, $dir, '', '',$brand);
			}else if($type=='tdp'){
				$posts = $this->inquiry_model->getinq_tdp($limit, $start, $order, $dir, '', '',$brand,$agent,$page);
			}else if($type=='rem'){
				$posts = $this->inquiry_model->getinq_rem($limit, $start, $order, $dir, '', '',$brand,$agent,$page);
			}
		} else {
			$search = $this->input->post('search')['value'];
			if($type=='new'){
				$posts = $this->inquiry_model->getinq_new($limit, $start, $order, $dir, '', $search,$brand);
				$totalFiltered = $this->inquiry_model->getinq_new('', '', '', '', TRUE, $search,$brand);
			}else if($type=='tdp'){
				$posts = $this->inquiry_model->getinq_tdp($limit, $start, $order, $dir, '', $search,$brand,$agent,$page);
				$totalFiltered = $this->inquiry_model->getinq_tdp('', '', '', '', TRUE, $search,$brand,$agent,$page);
			}else if($type=='rem'){
				$posts = $this->inquiry_model->getinq_rem($limit, $start, $order, $dir, '', $search,$brand,$agent,$page);
				$totalFiltered = $this->inquiry_model->getinq_rem('', '', '', '', TRUE, $search,$brand,$agent,$page);
			}
		}
		$data = array();
		if (!empty($posts)) {
			$sr = 1+$start;
			foreach ($posts as $post) {
				$nestedData['sr'] = $sr++;
				$nestedData['inq_date'] = date('d-M', strtotime($post->enq_receive_time)) . '<br>' . date('h:i A', strtotime($post->enq_receive_time));
				// if($user == 'admin'){
				// 	if($post->enq_brand == $this->mainbrand ){
				// 		$nestedData['brand'] = 'RT';
				// 	}else{
				// 		$nestedData['brand'] = 'KT';
				// 	}
				// }
				$words = explode(" ", $post->enq_brand);
				$acronym = "";
				foreach ($words as $w) {
					$acronym .= $w[0];
				}
				$nestedData['brand'] = $acronym ;
				if (checkAccess($user_role, 'admin_view_new_inq') || $this->session->userdata('user_name') == $post->picked_by) {
					$nestedData['inq_id']="<a target='_blank' href='".base_url('inquiry/view/'.hashing($post->enq_id))."' class='text-blue font-weight-600'>".$post->enq_id."</a>";
				}else{
					$nestedData['inq_id'] = $post->enq_id ;
				}
				$nestedData['dept_date'] = date("d-M-y", strtotime($post->enq_dept_date)) ;
				$details = '';
				if ($post->enq_type == "Mail") { 
					$details .='<i class="glyphicon glyphicon-envelope" title="Web Inquiry"></i>&nbsp;';
				} elseif ($post->enq_type == "Call") {  
					$details .='<i class="glyphicon glyphicon-phone" title="Call Received"></i>&nbsp;';
				} elseif ($post->enq_type == "Chat") {  
					$details .='<i class="glyphicon glyphicon-comment" title="Chat"></i>&nbsp;';
				} elseif ($post->enq_type == "Whatsapp") {  
					$details .='<i class="glyphicon glyphicon-info-sign" title="Whatsapp"></i>&nbsp;';
				}
				if (isset($post->alert_datetime) != null && $type != 'new') {
					$details .='<i class="glyphicon glyphicon-bell text-dark font-weight-600" data-toggle="tooltip" data-placement="left" data-original-title="Reminder: '. date("d-M-y h:i a", strtotime($post->alert_datetime)).'"></i>&nbsp;';
				}
				$details .= str_replace("Flight ", "", $post->enq_page) . " - " . bfr_dash($post->enq_dest) . " - " . $post->enq_device;
				$nestedData['details'] = $details ;
				if($user == 'admin'){
					$nestedData['feedback'] = '-';
				}
				if(isset($post->new_last_cmnt) && $post->new_last_cmnt != ''){
					$nestedData['feedback'] = custom_str($post->new_last_cmnt,10);
				}
				if($post->picked_by != ''){
					$nestedData['pick_by'] = remove_space_r($post->picked_by) ;
				}else{
					$nestedData['pick_by'] = '-';
				}
				$nestedData['action'] = '<div class="btn-group">';
				if($post->picked_by == '' ){
					$nestedData['action'] .= '<button class="pickInq btn btn-sm p-1 btn-warning" data-enq-id="'.$post->enq_id.'"><i class="icon glyphicon m-0 glyphicon-thumbs-up"></i></button> ';
				}	
				if (checkAccess($user_role, 'admin_view_new_inq')) {
					$nestedData['action'] .= '<button class="deleteInq btn btn-sm p-1 btn-danger" data-enq-id="'.$post->enq_id.'"><i class="icon glyphicon m-0 glyphicon-trash"></i></button>';
				}	
				$nestedData['action'] .= '</div>';
				$data[] = $nestedData;
			}
		}
		$json_data = array(
			"draw"            => intval($this->input->post('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);
		echo json_encode($json_data);
	}
	public function inq_reports()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata ;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = 'Inquiry Reports';
		$data['head']['page_title'] = $data['d_page_title'] ;
		if (!empty($_REQUEST) && checkAccess($user_role, 'admin_view_new_inq')) {
			if ($_REQUEST['agent'] != '') {
				$data['agent'] = $agent = $_REQUEST['agent'];
			} else {
				$data['agent'] = $agent = '';
			}
			if ($_REQUEST['month'] != '') {
				$data['month'] = $month = date("Y-m", strtotime($_REQUEST['month']));
			} else {
				$data['month'] = $month = date("Y-m");
			}
		} else {
			$data['agent'] = $agent = '';
			$data['month'] = $month = date("Y-m");
		}
		if ($user_brand != 'All') {
			if (checkAccess($user_role, 'inq_reports_view')) {
			} else {
				$data['brand'] = $brand = $user_brand;
				$data['agent'] = $agent = $user_name;
				if (!empty($_REQUEST) && $_REQUEST['month'] != '') {
					$data['month'] = $month = date("Y-m", strtotime($_REQUEST['month']));
				} else {
					$data['month'] = $month = date("Y-m");
				}
			}
		}
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		$data['agents'] = $this->inquiry_model->getinqAgents($brand);
		$data['header_data_report'] = $this->inquiry_model->headerdatarpt($brand, $agent, $month);
		if (checkAccess($user_role, 'inq_reports_view')) {
			$this->load->view('inquiry/reports', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function pickinq()
	{
		$result = $this->inquiry_model->pickInq();
		echo json_encode($result);
	}
	public function picked()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata ;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = 'Picked Inquiries';
		$data['head']['page_title'] = $data['d_page_title'] ;
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		$agent = $this->session->userdata('user_name');
		$page = "picked";
		$data['agents'] = $this->inquiry_model->getinqAgents();
		$data['dept_date_passed'] = $this->inquiry_model->getdeptdatepassedinq($brand, $agent, $page);
		$data['alerted_inq'] = $this->inquiry_model->getalertedinq($brand, $agent, $page);
		$data['remaining_inq'] = $this->inquiry_model->getremaininginq($brand, $agent, $page);
		$data['header'] = $this->inquiry_model->inq_headerdata($brand, $agent);
		if (checkAccess($user_role, 'picked_inq_view')) {
			$this->load->view('inquiry/picked', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function closed()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata ;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = 'Closed Inquiries';
		$data['head']['page_title'] = $data['d_page_title'] ;
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		if (!checkAccess($user_role, 'admin_view_new_inq')) {
			$agent = $user_name;
		}
		$data['closed_inq'] = $this->inquiry_model->getClosedInq($agent, $brand);
		if (checkAccess($user_role, 'closed_inq_view')) {
			$this->load->view('inquiry/closed', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function enq_actions()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata ;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = 'Inquiry Actions';
		$data['head']['page_title'] = $data['d_page_title'] ;
		if ($user_brand != 'All') {
			$brand = $user_brand;
			$agent = $this->session->userdata('user_name');
		}
		$data['agents'] = $this->inquiry_model->getinqAgents();
		$data['inquiries'] = $this->inquiry_model->getactioninq($brand, $agent);
		if (checkAccess($user_role, 'inq_actions_view')) {
			$this->load->view('inquiry/actions', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function view($enq_id = '')
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata ;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$enq_id = hashing($enq_id, 'd');
		$data['d_page_title'] = "Inquiry #" . $enq_id;
		$data['head']['page_title'] = $data['d_page_title'] ;
		$data['enq_details'] = $this->inquiry_model->inqDetails($enq_id);
		if (checkAccess($user_role, 'admin_view_new_inq') || $data['enq_details']['picked_by'] == $user_name) {
			$data['enq_feedback'] = $this->inquiry_model->inqCmnt($enq_id);
			$data['enq_alert'] = $this->inquiry_model->inqAlrt($enq_id);
			$this->load->view('inquiry/view', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function addfeedback()
	{
		$enq_id = $this->input->post('enq_id');
		$this->inquiry_model->addinqFeed();
		$data['enq_details'] = $this->inquiry_model->inqDetails($enq_id);
		$data['enq_feedback'] = $this->inquiry_model->inqCmnt($enq_id);
		$html = $this->load->view('inquiry/ajax/feedback', $data, true);
		echo json_encode($html);
	}
	public function assignInq()
	{
		$data = $this->input->post();
		$data['result'] = $this->inquiry_model->asinq($data);
		if ($data['result']) {
			$response = array(
				'status' => 'success',
				'response' => 'Inquiry has been assigned to ' . $data['assign_name']
			);
			$this->session->set_flashdata('notify', json_encode($response));
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'There was some error while assigning Inquiry'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		}
		echo true;
	}
	public function inqAction()
	{
		$data = $this->input->post();
		$user_role = $this->session->userdata('user_role');
		if (isset($data['page']) && $data['page'] == 'bulk' && checkAccess($user_role, 'admin_view_new_inq')) {
			$data['status'] = $data['action'];
			$data['inq_id'] = $data['inq_ids'];
			$data['status'] = $this->inquiry_model->inqactn($data, TRUE);
			echo json_encode($data);
		} else {
			$data['status'] = $this->inquiry_model->inqactn($data, TRUE);
			$data['inq_id'] = hashing($data['inq_id']);
			echo json_encode($data);
		}
	}
	public function deleteinq()
	{
		$data = $this->input->post();
		if (@$data['page'] == 'bulk') {
			$data['enq_id'] = $data['inq_ids'];
		}
		$data['status'] = $this->inquiry_model->dltinq($data);
		echo json_encode($data);
	}
	public function editalertmodal()
	{
		$data = $this->input->post();
		$data['alert_details'] = $this->inquiry_model->getalertDetails($data);
		$html = $this->load->view('inquiry/ajax/editalert', $data, true);
		echo json_encode($html);
	}
	public function addinqalert()
	{
		$data = $this->input->post();
		$status = $this->inquiry_model->addalert($data);
		echo json_encode($status);
	}
	public function editinqalert()
	{
		$data = $this->input->post();
		$status = $this->inquiry_model->editalert($data);
		echo json_encode($status);
	}
	public function compinqalert()
	{
		$data = $this->input->post();
		$status = $this->inquiry_model->compalert($data);
		echo json_encode($status);
	}
	public function removealert()
	{
		$data = $this->input->post();
		$data['status'] = $this->inquiry_model->rmvalert($data);
		$data['inq_id'] = hashing($data['enq_id']);
		echo json_encode($data);
	}
	public function addInquiy()
	{
		$data = $this->input->post();
		$result = $this->inquiry_model->addinq($data);
		echo json_encode($result);
	}
	public function inq_report_graph()
	{
		$data = $this->input->post();
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if ($user_brand != 'All') {
			$data['brand'] = $user_brand;
		} else {
			$data['brand'] = '';
		}
		$res['open'] = $this->inquiry_model->get_fir_graph_data($data, 'Open');
		$res['mature'] = $this->inquiry_model->get_fir_graph_data($data, 'Mature');
		$res['un_mature'] = $this->inquiry_model->get_fir_graph_data($data, 'Unmature');
		$res['closed'] = $this->inquiry_model->get_fir_graph_data($data, 'Closed');
		echo json_encode($res);
	}
	public function inq_bar_graph()
	{
		$data = $this->input->post();
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if ($user_brand != 'All') {
			$data['brand'] = $user_brand;
		} else {
			$data['brand'] = '';
		}
		$res['results'] = $this->inquiry_model->get_bar_graph_data($data);
		echo json_encode($res);
	}
}

/* End of file Inquiry.php */
/* Location: ./application/controllers/Inquiry.php */
