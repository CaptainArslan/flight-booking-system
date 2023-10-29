<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry_model extends CI_Model {

	public function getinq_new($limit='', $start='', $col='', $dir='', $count='', $search='',$brand='')
	{
		$this->db->select('enq_receive_time,enq_brand,enq_id,enq_dept_date,enq_dest,enq_cust_name,enq_cust_phone,enq_cust_email,enq_page,enq_device,enq_type,picked_by');
		if($brand != ''){
			$this->db->where('enq_brand', $brand);
		}
		$this->db->where('enq_status', 'Open');
		$this->db->where('picked_by','');
		if ($search != '') {
			$this->db->like('enq_id', $search);
			$this->db->or_like('picked_by', $search);
			$this->db->or_like('enq_brand', $search);
			$this->db->or_like('enq_dest', $search);
			$this->db->or_like('enq_dept_date', $search);
			$this->db->or_like('enq_cust_name', $search);
			$this->db->or_like('enq_cust_phone', $search);
			$this->db->or_like('enq_cust_email', $search);
		}
		
		if ($limit != '' && $start != '') {
			$this->db->limit($limit, $start);
		}
		if ($col != '' && $dir != '') {
			$this->db->order_by($col, $dir);
		}
		$query = $this->db->get('customer_enq');
		if ($count != '') {
			return $query->num_rows();
		} else {
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return null;
			}
		}
	}
	public function getinq_tdp($limit='', $start='', $col='', $dir='', $count='', $search='',$brand='',$agent='',$page = ""){
        $user_role = $this->session->userdata('user_role');
		$this->db->select('ce.enq_receive_time,ce.enq_id,ce.picked_by,ce.enq_brand,ce.enq_dest,ce.enq_dept_date,ce.enq_cust_name,ce.enq_cust_phone,ce.enq_cust_email,ce.enq_page,ce.enq_device,ce.enq_type,cec.enq_cmnt as new_last_cmnt,cea.id as alert_id,cea.alert_msg,cea.alert_datetime');
		$this->db->from('customer_enq ce');
		$this->db->join('(select max(id) max_id, enq_id from cust_enq_cmnt group by enq_id) as cec1', 'cec1.enq_id = ce.enq_id', 'left');
		$this->db->join('cust_enq_cmnt cec', 'cec.id = cec1.max_id', 'left');
		$this->db->join('cust_enq_alert cea', 'cea.enq_id = ce.enq_id', 'left');
		if($brand != ''){
			$this->db->where('ce.enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('ce.picked_by', $agent);
		}
		if($page == "unpicked" && !checkAccess($user_role,'admin_view_new_inq')){
			$this->db->where('ce.enq_date >=now()-interval 1 WEEK');
		}
		$this->db->where('ce.enq_dept_date <', date('Y-m-d'));
		$this->db->where('ce.enq_status', 'Open');
		$this->db->where('picked_by !=','');
		$this->db->group_by('ce.enq_id');
		if ($search != '') {
			$this->db->like('ce.enq_id', $search);
			$this->db->or_like('ce.picked_by', $search);
			$this->db->or_like('ce.enq_brand', $search);
			$this->db->or_like('ce.enq_dest', $search);
			$this->db->or_like('ce.enq_dept_date', $search);
			$this->db->or_like('ce.enq_cust_name', $search);
			$this->db->or_like('ce.enq_cust_phone', $search);
			$this->db->or_like('ce.enq_cust_email', $search);
		}
		
		if ($limit != '' && $start != '') {
			$this->db->limit($limit, $start);
		}
		if ($col != '' && $dir != '') {
			$this->db->order_by($col, $dir);
		}
		$query = $this->db->get();
		if ($count != '') {
			return $query->num_rows();
		} else {
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return null;
			}
		}	
	}
	public function getinq_rem($limit='', $start='', $col='', $dir='', $count='', $search='',$brand='',$agent='',$page=""){
        $user_role = $this->session->userdata('user_role');
		$this->db->select('ce.enq_receive_time,ce.enq_id,ce.picked_by,ce.enq_brand,ce.enq_dest,ce.enq_dept_date,ce.enq_cust_name,ce.enq_cust_phone,ce.enq_cust_email,ce.enq_page,ce.enq_device,ce.enq_type,cec.enq_cmnt as new_last_cmnt,cea.id as alert_id,cea.alert_msg,cea.alert_datetime');
		$this->db->from('customer_enq ce');
		$this->db->join('(select max(id) max_id, enq_id from cust_enq_cmnt group by enq_id) as cec1', 'cec1.enq_id = ce.enq_id', 'left');
		$this->db->join('cust_enq_cmnt cec', 'cec.id = cec1.max_id', 'left');
		$this->db->join('cust_enq_alert cea', 'cea.enq_id = ce.enq_id', 'left');
		if($brand != ''){
			$this->db->where('ce.enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('ce.picked_by', $agent);
		}
		if($page == "unpicked" && !checkAccess($user_role,'admin_view_new_inq')){
			$this->db->where('ce.enq_date >=now()-interval 1 WEEK');
		}
		$this->db->where('ce.enq_dept_date >=', date('Y-m-d'));
		$this->db->where('picked_by !=','');
		$this->db->where('ce.enq_status', 'Open');
		$this->db->where('cea.alert_datetime', NULL);
		$this->db->group_by('ce.enq_id');
		if ($search != '') {
			$this->db->like('ce.enq_id', $search);
			$this->db->or_like('ce.picked_by', $search);
			$this->db->or_like('ce.enq_brand', $search);
			$this->db->or_like('ce.enq_dest', $search);
			$this->db->or_like('ce.enq_dept_date', $search);
			$this->db->or_like('ce.enq_cust_name', $search);
			$this->db->or_like('ce.enq_cust_phone', $search);
			$this->db->or_like('ce.enq_cust_email', $search);
		}
		
		if ($limit != '' && $start != '') {
			$this->db->limit($limit, $start);
		}
		if ($col != '' && $dir != '') {
			$this->db->order_by($col, $dir);
		}
		$query = $this->db->get();
		if ($count != '') {
			return $query->num_rows();
		} else {
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return null;
			}
		}	
	}
	public function getNewInq($brand='',$agent=''){
		$this->db->select('enq_receive_time,enq_id,picked_by,enq_brand,enq_dest,enq_dept_date,enq_cust_name,enq_cust_phone,enq_cust_email,enq_page,enq_device,enq_type');
		$this->db->from('customer_enq');
		if($brand != ''){
			$this->db->where('enq_brand', $brand);
		}
		$this->db->where('enq_status', 'Open');
		$this->db->where('picked_by','');
		$this->db->order_by('enq_id', 'desc');
		return $this->db->get()->result_array();	
	}
	public function getAllInq($brand='',$agent='',$page=''){
		$user_role = $this->session->userdata('user_role');
		$this->db->select('ce.enq_receive_time,ce.enq_id,ce.picked_by,ce.enq_brand,ce.enq_dest,ce.enq_dept_date,ce.enq_cust_name,ce.enq_cust_phone,ce.enq_cust_email,ce.enq_page,ce.enq_device,ce.enq_type,cec.enq_cmnt as new_last_cmnt,cea.id as alert_id,cea.alert_msg,cea.alert_datetime');
		$this->db->from('customer_enq ce');
		$this->db->join('(select max(id) max_id, enq_id from cust_enq_cmnt group by enq_id) as cec1', 'cec1.enq_id = ce.enq_id', 'left');
		$this->db->join('cust_enq_cmnt cec', 'cec.id = cec1.max_id', 'left');
		$this->db->join('cust_enq_alert cea', 'cea.enq_id = ce.enq_id', 'left');
		if($brand != ''){
			$this->db->where('ce.enq_brand', $brand);
		}
		if($page == "unpicked" && !checkAccess($user_role,'admin_view_new_inq')){
			$this->db->where('ce.enq_date >=now()-interval 4 MONTH');
		}
		//$this->db->where('ce.enq_dept_date >=', date('Y-m-d'));
		$this->db->where('ce.enq_status', 'Open');
		$this->db->where('cea.alert_datetime', NULL);
		$this->db->order_by('ce.enq_id', 'desc');
		$this->db->group_by('ce.enq_id');
		return $this->db->get()->result_array();

	}
	public function getdeptdatepassedinq($brand='',$agent='',$page = ""){
        $user_role = $this->session->userdata('user_role');
		$this->db->select('ce.enq_receive_time,ce.enq_id,ce.picked_by,ce.enq_brand,ce.enq_dest,ce.enq_dept_date,ce.enq_cust_name,ce.enq_cust_phone,ce.enq_cust_email,ce.enq_page,ce.enq_device,ce.enq_type,cec.enq_cmnt as new_last_cmnt,cea.id as alert_id,cea.alert_msg,cea.alert_datetime');
		$this->db->from('customer_enq ce');
		$this->db->join('(select max(id) max_id, enq_id from cust_enq_cmnt group by enq_id) as cec1', 'cec1.enq_id = ce.enq_id', 'left');
		$this->db->join('cust_enq_cmnt cec', 'cec.id = cec1.max_id', 'left');
		$this->db->join('cust_enq_alert cea', 'cea.enq_id = ce.enq_id', 'left');
		if($brand != ''){
			$this->db->where('ce.enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('ce.picked_by', $agent);
		}
		if($page == "unpicked" && !checkAccess($user_role,'admin_view_new_inq')){
			$this->db->where('ce.enq_date >=now()-interval 1 WEEK');
		}
		$this->db->where('ce.enq_dept_date <', date('Y-m-d'));
		$this->db->where('ce.enq_status', 'Open');
		$this->db->where('picked_by !=','');
		$this->db->order_by('ce.enq_dept_date', 'desc');
		$this->db->group_by('ce.enq_id');
		return $this->db->get()->result_array();	
	}
	public function getalertedinq($brand='',$agent='',$page=''){
        $user_role = $this->session->userdata('user_role');
		$this->db->select('ce.enq_receive_time,ce.enq_id,ce.picked_by,ce.enq_brand,ce.enq_dest,ce.enq_dept_date,ce.enq_cust_name,ce.enq_cust_phone,ce.enq_cust_email,ce.enq_page,ce.enq_device,ce.enq_type,cec.enq_cmnt as new_last_cmnt,cea.id as alert_id,cea.alert_msg,cea.alert_datetime');
		$this->db->from('customer_enq ce');
		$this->db->join('(select max(id) max_id, enq_id from cust_enq_cmnt group by enq_id) as cec1', 'cec1.enq_id = ce.enq_id', 'left');
		$this->db->join('cust_enq_cmnt cec', 'cec.id = cec1.max_id', 'left');
		$this->db->join('cust_enq_alert cea', 'cea.enq_id = ce.enq_id', 'left');
		if($brand != ''){
			$this->db->where('ce.enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('ce.picked_by', $agent);
		}
		if($page == "unpicked" && !checkAccess($user_role,'admin_view_new_inq')){
			$this->db->where('ce.enq_date >=now()-interval 1 WEEK');
		}
		$this->db->where('ce.enq_dept_date >=', date('Y-m-d'));
		$this->db->where('picked_by !=','');
		$this->db->where('ce.enq_status', 'Open');
		$this->db->where('cea.alert_datetime !=', NULL);
		$this->db->order_by('cea.alert_datetime', 'asc');
		$this->db->group_by('ce.enq_id');
		return $this->db->get()->result_array();	
	}
	public function getremaininginq($brand='',$agent='',$page=""){
        $user_role = $this->session->userdata('user_role');
		$this->db->select('ce.enq_receive_time,ce.enq_id,ce.picked_by,ce.enq_brand,ce.enq_dest,ce.enq_dept_date,ce.enq_cust_name,ce.enq_cust_phone,ce.enq_cust_email,ce.enq_page,ce.enq_device,ce.enq_type,cec.enq_cmnt as new_last_cmnt,cea.id as alert_id,cea.alert_msg,cea.alert_datetime');
		$this->db->from('customer_enq ce');
		$this->db->join('(select max(id) max_id, enq_id from cust_enq_cmnt group by enq_id) as cec1', 'cec1.enq_id = ce.enq_id', 'left');
		$this->db->join('cust_enq_cmnt cec', 'cec.id = cec1.max_id', 'left');
		$this->db->join('cust_enq_alert cea', 'cea.enq_id = ce.enq_id', 'left');
		if($brand != ''){
			$this->db->where('ce.enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('ce.picked_by', $agent);
		}
		if($page == "unpicked" && !checkAccess($user_role,'admin_view_new_inq')){
			$this->db->where('ce.enq_date >=now()-interval 1 WEEK');
		}
		$this->db->where('ce.enq_dept_date >=', date('Y-m-d'));
		$this->db->where('picked_by !=','');
		$this->db->where('ce.enq_status', 'Open');
		$this->db->where('cea.alert_datetime', NULL);
		$this->db->order_by('ce.enq_id', 'desc');
		$this->db->group_by('ce.enq_id');
		return $this->db->get()->result_array();	
	}
	public function getactioninq($brand='',$agent='',$page=""){
		$status_array = array("Open","Closed","Mature","Unmature");
		$user_role = $this->session->userdata('user_role');
		$this->db->select('ce.enq_receive_time,ce.enq_id,ce.picked_by,ce.enq_status,ce.enq_brand,ce.enq_dest,ce.enq_dept_date,ce.enq_cust_name,ce.enq_cust_phone,ce.enq_cust_email,ce.enq_page,ce.enq_device,ce.enq_type,cec.enq_cmnt as new_last_cmnt');
		$this->db->from('customer_enq ce');
		$this->db->join('(select max(id) max_id, enq_id from cust_enq_cmnt group by enq_id) as cec1', 'cec1.enq_id = ce.enq_id', 'left');
		$this->db->join('cust_enq_cmnt cec', 'cec.id = cec1.max_id', 'left');
		$this->db->where_in('ce.enq_status NOT', $status_array);
		if($brand != ''){
			$this->db->where('ce.enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('ce.picked_by', $agent);
		}
		$this->db->order_by('ce.enq_id', 'desc');
		$this->db->group_by('ce.enq_id');
		return $this->db->get()->result_array();
	}
	public function pickInq(){
		$data = $this->input->post();
		$this->db->set('picked_by', $this->session->userdata('user_name'));
		$this->db->set('enq_pick_time', date('Y-m-d H:i:s'));
		$this->db->where('enq_id', $data['enq_id']);
		$this->db->where('picked_by', '');
		$this->db->update('customer_enq');
		$data['enq_id'] = hashing($data['enq_id']);
		$data['status'] = 'true';
		return $data;
	}
	public function getPickedInq($agent='',$brand=''){
		$this->db->select('ce.enq_receive_time,ce.enq_id,ce.picked_by,ce.enq_brand,ce.last_cmnt,ce.enq_heading,ce.enq_description,ced.id,ced.enq_dest,ced.enq_dept_date,ced.enq_cust_name,ced.enq_cust_phone,ced.enq_cust_email,cec.enq_cmnt as new_last_cmnt,cea.id as alert_id,cea.alert_msg,cea.alert_datetime');
		$this->db->from('customer_enquiry ce');
		$this->db->join('cust_enq_details ced', 'ced.enq_id = ce.enq_id', 'left');
		$this->db->join('(select max(id) max_id, enq_id from cust_enq_cmnt group by enq_id) as cec1', 'cec1.enq_id = ce.enq_id', 'left');
		$this->db->join('cust_enq_cmnt cec', 'cec.id = cec1.max_id', 'left');
		$this->db->join('cust_enq_alert cea', 'cea.enq_id = ce.enq_id', 'left');
		if($brand != ''){
			$this->db->where('ce.enq_brand', $brand);
		}
		$this->db->where('ce.enq_status', 'o');
		$this->db->where('ce.picked_by', $agent);
		$this->db->where('ce.enq_receive_time >=now()-interval 3 month');
		$this->db->order_by('ce.enq_id', 'desc');
		$this->db->group_by('ce.enq_id');
		return $this->db->get()->result_array();
	}
	public function getClosedInq($agent='',$brand=''){
		$status_array = array("Closed","Mature","Unmature");
		$user_role = $this->session->userdata('user_role');
		$this->db->select('ce.enq_receive_time,ce.enq_id,ce.picked_by,ce.enq_brand,ce.enq_dest,ce.enq_dept_date,ce.enq_cust_name,ce.enq_cust_phone,ce.enq_cust_email,ce.enq_page,ce.enq_device,ce.enq_type,ce.enq_status,cec.enq_cmnt as new_last_cmnt,cea.id as alert_id,cea.alert_msg,cea.alert_datetime');
		$this->db->from('customer_enq ce');
		$this->db->join('(select max(id) max_id, enq_id from cust_enq_cmnt group by enq_id) as cec1', 'cec1.enq_id = ce.enq_id', 'left');
		$this->db->join('cust_enq_cmnt cec', 'cec.id = cec1.max_id', 'left');
		$this->db->join('cust_enq_alert cea', 'cea.enq_id = ce.enq_id', 'left');
		if($brand != ''){
			$this->db->where('ce.enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('ce.picked_by', $agent);
		}
		$this->db->where('ce.enq_date >=now()-interval 1 WEEK');
		$this->db->where_in('ce.enq_status', $status_array);
		$this->db->where('cea.alert_datetime', NULL);
		$this->db->order_by('ce.enq_id', 'desc');
		$this->db->group_by('ce.enq_id');
		return $this->db->get()->result_array();
	}
	public function inqDetails($enqId=''){
		$this->db->select('*');
		$this->db->from('customer_enq');
		$this->db->where('enq_id', $enqId);
		$result = $this->db->get();
		$result = $result->row_array();
		return $result;
	}
	public function inqCmnt($enqId=''){
		$this->db->select('*');
		$this->db->from('cust_enq_cmnt');
		$this->db->where('enq_id', $enqId);
		$this->db->order_by('cmnt_datetime', 'desc');
		$result = $this->db->get();
		$result = $result->result_array();
		return $result;
	}
	public function inqAlrt($enqId=''){
		$this->db->select('*');
		$this->db->from('cust_enq_alert');
		$this->db->where('enq_id', $enqId);
		$result = $this->db->get();
		$result = $result->row_array();
		return $result;
	}
	public function addinqFeed(){
		$data = $this->input->post();
		$this->db->set('enq_id', $data['enq_id']);
		$this->db->set('enq_cmnt', $data['feedback']);
		$this->db->set('cmnt_by', $this->session->userdata('user_name'));
		$this->db->insert('cust_enq_cmnt');
	}
	public function asinq($data=''){
		$this->db->set('picked_by', $data['assign_name']);
		$this->db->where('enq_id', $data['inq_id']);
		$this->db->update('customer_enq');
		$num = $this->db->affected_rows();
		if($num > 0){
			$this->db->set('enq_cmnt', 'Enquiry assigned from '.$data['pre_name'].' to '.$data['assign_name']);
			$this->db->set('cmnt_by', $this->session->userdata('user_name'));
			$this->db->set('enq_id', $data['inq_id']);
			$this->db->insert('cust_enq_cmnt');
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function inqactn($data='',$add_feed=''){
		$this->db->set('enq_status', $data['status']);
		if(@$data['page'] == 'bulk'){
			$this->db->where_in('enq_id', $data['inq_id']);
		}else{
			$this->db->where('enq_id', $data['inq_id']);
		}
		$this->db->update('customer_enq');
		$num = $this->db->affected_rows();
		if($num > 0 && $add_feed){
			if(@$data['page'] == 'bulk'){
				foreach ($data['inq_id'] as $key => $value) {
					$this->db->set('enq_cmnt', $data['status']);
					$this->db->set('cmnt_by', $this->session->userdata('user_name'));
					$this->db->set('enq_id', $value);
					$this->db->insert('cust_enq_cmnt');
				}
			}else{
				$this->db->set('enq_cmnt', $data['status']);
				$this->db->set('cmnt_by', $this->session->userdata('user_name'));
				$this->db->set('enq_id', $data['inq_id']);
				$this->db->insert('cust_enq_cmnt');
			}
			return TRUE;
		}elseif($num > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function dltinq($data=''){
		if(@$data['page'] == 'bulk'){		
			$this->db->where_in('enq_id', $data['enq_id']);
		}else{
			$this->db->where('enq_id', $data['enq_id']);
		}
		$this->db->delete('customer_enq');

		if(@$data['page'] == 'bulk'){		
			$this->db->where_in('enq_id', $data['enq_id']);
		}else{
			$this->db->where('enq_id', $data['enq_id']);
		}
		$this->db->delete('cust_enq_cmnt');	

		if(@$data['page'] == 'bulk'){		
			$this->db->where_in('enq_id', $data['enq_id']);
		}else{
			$this->db->where('enq_id', $data['enq_id']);
		}
		$this->db->delete('cust_enq_alert');	

		return 'true';		
	}
	public function addalert($data){
		$insert_check = $this->db->select('id')->where('enq_id',$data['enq_id'])->get('cust_enq_alert')->num_rows();
		if($insert_check >0){
			$insert['status'] = false;
			$insert['heading'] = 'Reminderd Added Already';
		}else{
			$alertdatetime = date("Y-m-d H:i:00",strtotime($data['alertdatetime']));		
			$insert['status'] = $this->db->set('enq_id',$data['enq_id'])->set('alert_msg',$data['alertmsg'])->set('alert_set_by',$data['alertby'])->set('alert_datetime',$alertdatetime)->insert('cust_enq_alert');
			$cmnt = "Reminder due at: ".date("d-M-Y h:i A",strtotime($alertdatetime))." for: ".$data['alertmsg']." <i class='fa fa-bell text-warning faa-ring animated'></i>";
			$this->db->set('enq_id',$data['enq_id'])->set('enq_cmnt',$cmnt)->set('cmnt_by',$data['alertby'])->insert('cust_enq_cmnt');
			$insert['heading'] = 'Reminderd Has Been Set For:-<br>Timer: '.date("d-M-Y h:i A",strtotime($alertdatetime));
		}			
		return $insert;
	}
	public function editalert($data=''){
		$alertdatetime = date("Y-m-d H:i:00",strtotime($data['alertdatetime']));		
		$insert['status'] = $this->db->set('enq_id',$data['enq_id'])->set('alert_msg',$data['alertmsg'])->set('alert_set_by',$data['alertedit_by'])->set('alert_datetime',$alertdatetime)->where('id',$data['alert_id'])->where('enq_id',$data['enq_id'])->update('cust_enq_alert');
		$cmnt = "Reminder Edited and due at: ".date("d-M-Y h:i A",strtotime($alertdatetime))." for: ".$data['alertmsg']." <i class='fa fa-bell text-warning faa-ring animated'></i>";
		$this->db->set('enq_id',$data['enq_id'])->set('enq_cmnt',$cmnt)->set('cmnt_by',$data['alertedit_by'])->insert('cust_enq_cmnt');
		$insert['heading'] = 'Reminderd Has Been Edited For:-<br>Timer: '.date("d-M-Y h:i A",strtotime($alertdatetime));
		return $insert;
	}
	public function compalert($data=''){
		$inq_data['status'] = $data['inq_status'];
		$inq_data['inq_id'] = $data['enq_id'];
		$cmnt = "Reminder Completed: ".$data['alertmsg']." <i class='fa fa-bell text-warning faa-ring animated'></i>";
		$res = $this->db->where('id', $data['alert_id'])->delete('cust_enq_alert');
		if($res){
			$this->db->set('enq_id',$data['enq_id'])->set('enq_cmnt',$cmnt)->set('cmnt_by',$data['alertedit_by'])->insert('cust_enq_cmnt');
			$insert['status'] = $this->inqactn($inq_data);
		}
		$insert['heading'] = 'Reminderd Has Been Completed';
		return $insert;
	}
	public function rmvalert($data=''){
		$this->db->where('id', $data['alert_id']);
		$this->db->delete('cust_enq_alert');
		$num = $this->db->affected_rows();
		if($num > 0){
			$this->db->set('enq_cmnt', 'Reminder Removed');
			$this->db->set('cmnt_by', $this->session->userdata('user_name'));
			$this->db->set('enq_id', $data['enq_id']);
			$this->db->insert('cust_enq_cmnt');
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function inq_headerdata($brand='',$agent=''){
		$header = array();
		$this->db->select('(COUNT(CASE WHEN (`enq_type` = "Mail" AND `enq_status` = "Open") THEN `enq_id` END)) as `mail_enq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type` = "Call" AND `enq_status` = "Open") THEN `enq_id` END)) as `call_enq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type` = "Chat" AND `enq_status` = "Open") THEN `enq_id` END)) as `chat_enq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type` = "Whatsapp" AND `enq_status` = "Open") THEN `enq_id` END)) as `whatsapp_enq`');
		if($brand != ''){
			$this->db->where('enq_brand', $brand);
			//$this->db->where('picked_by', $this->session->userdata('user_name'));
		}
		if($agent != ''){
			$this->db->where('picked_by', $agent);
		}
		$mail_res = $this->db->from('customer_enq')->get()->row_array();
		$header['mail_inq'] = $mail_res['mail_enq'];
		$header['call_enq'] = $mail_res['call_enq'];
		$header['chat_enq'] = $mail_res['chat_enq'];
		$header['whatsapp_enq'] = $mail_res['whatsapp_enq'];

		//////// picked ////////
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Mail" AND `enq_status`="Open") THEN `enq_id` END))as`picked_mail_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Call" AND `enq_status`="Open") THEN `enq_id` END))as`picked_call_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Chat" AND `enq_status`="Open") THEN `enq_id` END))as`picked_chat_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Whatsapp" AND `enq_status`="Open") THEN `enq_id` END))as`picked_whatsapp_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Mail" AND `enq_status`="Mature") THEN `enq_id` END))as`mature_mail_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Call" AND `enq_status`="Mature") THEN `enq_id` END))as`mature_call_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Chat" AND `enq_status`="Mature") THEN `enq_id` END))as`mature_chat_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Whatsapp" AND `enq_status`="Mature") THEN `enq_id` END))as`mature_whatsapp_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Mail" AND `enq_status`="Closed") THEN `enq_id` END))as`closed_mail_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Call" AND `enq_status`="Closed") THEN `enq_id` END))as`closed_call_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Chat" AND `enq_status`="Closed") THEN `enq_id` END))as`closed_chat_inq`');
		$this->db->select('(COUNT(CASE WHEN (`enq_type`="Whatsapp" AND `enq_status`="Closed") THEN `enq_id` END))as`closed_whatsapp_inq`');
		if($brand != ''){
			$this->db->where('enq_brand', $brand);
			//$this->db->where('picked_by', $this->session->userdata('user_name'));
		}
		if($agent != ''){
			$this->db->where('picked_by', $agent);
		}else{
			$this->db->where('picked_by !=', "");			
		}
		$this->db->where('enq_date', date("Y-m-d"));
		$mail_res = $this->db->from('customer_enq')->get()->row_array();
		$header['picked_mail_inq'] = $mail_res['picked_mail_inq'];
		$header['picked_call_inq'] = $mail_res['picked_call_inq'];
		$header['picked_chat_inq'] = $mail_res['picked_chat_inq'];
		$header['picked_whatsapp_inq'] = $mail_res['picked_whatsapp_inq'];
		$header['mature_mail_inq'] = $mail_res['mature_mail_inq'];
		$header['mature_call_inq'] = $mail_res['mature_call_inq'];
		$header['mature_chat_inq'] = $mail_res['mature_chat_inq'];
		$header['mature_whatsapp_inq'] = $mail_res['mature_whatsapp_inq'];
		$header['closed_mail_inq'] = $mail_res['closed_mail_inq'];
		$header['closed_call_inq'] = $mail_res['closed_call_inq'];
		$header['closed_chat_inq'] = $mail_res['closed_chat_inq'];
		$header['closed_whatsapp_inq'] = $mail_res['closed_whatsapp_inq'];
		
		$this->db->select('(COUNT(CASE WHEN (`cea`.`alert_datetime` > NOW() AND date(`cea`.`alert_datetime`) > CURDATE()) THEN `cea`.`enq_id` END)) as `remain_active`');
		$this->db->select('(COUNT(CASE WHEN (`cea`.`alert_datetime` > NOW() AND date(`cea`.`alert_datetime`) = CURDATE()) THEN `cea`.`enq_id` END)) as `todays_active`');
		$this->db->select('(COUNT(CASE WHEN (`cea`.`alert_datetime` < NOW() AND date(`cea`.`alert_datetime`) <= CURDATE()) THEN `cea`.`enq_id` END)) as `total_passed`');
		$this->db->from('cust_enq_alert as cea');
		$this->db->join('customer_enq ce', 'ce.enq_id = cea.enq_id', 'left');
		if($brand != ''){
			$this->db->where('ce.enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('ce.picked_by', $agent);
		}else{
			$this->db->where('ce.picked_by !=', "");			
		}
		$res = $this->db->get()->row_array();
		$header['todays_active'] = $res['todays_active'];
		$header['remain_active'] = $res['remain_active'];
		$header['total_passed'] = $res['total_passed'];

		return $header ;
	}
	public function getinqAgents($brand=''){
		$this->db->select('picked_by as user_name');
		$this->db->from('customer_enq');
		$this->db->where('enq_status', 'Open');
		if($brand != ''){
			$this->db->where('enq_brand', $brand);
		}
		$this->db->group_by('picked_by');
		return $this->db->get()->result_array();
	}
	public function getinqBrands(){
		$this->db->select('enq_brand as brandname');
		$this->db->from('customer_enq');
		$this->db->where('enq_status', 'Open');
		$this->db->group_by('enq_brand');
		return $this->db->get()->result_array();
	}
	public function addinq($data=''){
		$data['enq_dept_date'] = date('Y-m-d',strtotime($data['enq_dept_date']));
		$data['enq_rtrn_date'] = date('Y-m-d',strtotime($data['enq_rtrn_date']));
		return $this->db->insert('customer_enq', $data);
	}
	public function getalertDetails($data){
		$this->db->select('*');
		$this->db->from('cust_enq_alert');
		$this->db->where('id', $data['alert_id']);
		$this->db->where('enq_id', $data['enq_id']);
		return $this->db->get()->row_array();
	}
	public function headerdatarpt($brand='',$agent='',$month=''){
		$cur_month = date('m',strtotime($month));
		$cur_year = date('Y',strtotime($month));
		$this->db->select('(COUNT(CASE WHEN (MONTH(`enq_date`) = "'.$cur_month.'" AND YEAR(`enq_date`) = "'.$cur_year.'") THEN `enq_id` END))as `cur_mth_inq`');
		if($brand != ''){
			$this->db->where('enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('picked_by', $agent);	
		}
		$this->db->where('enq_status !=', 'Closed');
		$mth_inq = $this->db->get('customer_enq')->row_array();
		
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Open") THEN `enq_id` END))as `ttl_opn_inq`');
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Mature") THEN `enq_id` END))as `ttl_mat_inq`');
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Unmature") THEN `enq_id` END))as `ttl_unmat_inq`');
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Closed") THEN `enq_id` END))as `ttl_cls_inq`');
		if($brand != ''){
			$this->db->where('enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('picked_by', $agent);	
		}
		$this->db->where('MONTH(`enq_date`)', $cur_month);
		$this->db->where('YEAR(`enq_date`)', $cur_year);
		$cur_mth = $this->db->get('customer_enq')->row_array();

		$this->db->select('(COUNT(CASE WHEN (enq_status = "Open") THEN `enq_id` END))as `tdy_opn_inq`');
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Mature") THEN `enq_id` END))as `tdy_mat_inq`');
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Unmature") THEN `enq_id` END))as `tdy_unmat_inq`');
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Closed") THEN `enq_id` END))as `tdy_cls_inq`');
		if($brand != ''){
			$this->db->where('enq_brand', $brand);
		}
		if($agent != ''){
			$this->db->where('picked_by', $agent);	
		}
		$this->db->where('enq_date', date("Y-m-d"));
		$tdy_all = $this->db->get('customer_enq')->row_array();
		
		$data['cur_mth_inq'] = $mth_inq['cur_mth_inq'] ;
		$data['cur_mth_opn_inq'] = $cur_mth['ttl_opn_inq'] ;
		$data['cur_mth_mat_inq'] = $cur_mth['ttl_mat_inq'] ;
		$data['cur_mth_unmat_inq'] = $cur_mth['ttl_unmat_inq'] ;
		$data['cur_mth_cls_inq'] = $cur_mth['ttl_cls_inq'] ;
		$data['tdy_opn_inq'] = $tdy_all['tdy_opn_inq'];
		$data['tdy_mat_inq'] = $tdy_all['tdy_mat_inq'];
		$data['tdy_unmat_inq'] = $tdy_all['tdy_unmat_inq'];
		$data['tdy_cls_inq'] = $tdy_all['tdy_cls_inq'];

		return $data ;		
	}
	public function get_fir_graph_data($data='',$status){
		$agent = $data['agent'];
		$brand = $data['brand'];
		$cur_month = date('m',strtotime($data['month']));
		$cur_year = date('Y',strtotime($data['month']));
		$this->db->select('(COUNT(CASE WHEN (enq_status = "'.$status.'") THEN `enq_id` END))as `total_inq`');
		$this->db->select('DAY(`enq_date`) as day');
		$this->db->from('customer_enq');
		$this->db->where('MONTH(`enq_date`)', $cur_month);
		$this->db->where('YEAR(`enq_date`)', $cur_year);
		if($agent != ''){
			$this->db->where('picked_by', $agent);
		}
		if($brand != ''){
			$this->db->where('enq_brand', $brand);
		}
		$this->db->group_by('DAY(`enq_date`)');
		$ress = $this->db->get()->result_array();
		$result = array();
		foreach ($ress as $key => $res) {
			$result[]=$res['total_inq'];
		}
		return $result;
	}
	public function get_bar_graph_data($data=''){
		$agent = $data['agent'];
		$cur_month = date('m',strtotime($data['month']));
		$cur_year = date('Y',strtotime($data['month']));
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Mature") THEN `enq_id`  END))as `mature`');
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Unmature") THEN `enq_id` END))as `unmature`');
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Open") THEN `enq_id`  END))as `open`');
		$this->db->select('(COUNT(CASE WHEN (enq_status = "Closed") THEN `enq_id` END))as `closed`');
		if($agent != ''){
			$this->db->select('DATE_FORMAT(`enq_date`,"%b-%y") as name');			
			$this->db->where('picked_by', $agent);
			$this->db->where('enq_date >=now()-interval 12 MONTH');
			$this->db->group_by('MONTH(`enq_date`)');
			$this->db->order_by('enq_date', 'asc');
		}else{
			$this->db->select('picked_by as name');
			$this->db->where('MONTH(`enq_date`)', $cur_month);
			$this->db->where('YEAR(`enq_date`)', $cur_year);
			$this->db->group_by('picked_by');
			$this->db->order_by('mature', 'desc');
		}
		$this->db->from('customer_enq');
		$this->db->where('picked_by !=', '');
		if($data['brand'] != ''){
			$this->db->where('enq_brand', $data['brand']);
		}
		$ress = $this->db->get()->result_array();
		return $ress;
	}
}

/* End of file inquiry_model.php */
/* Location: ./application/models/inquiry_model.php */