<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	
	public function checkLogin($data){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_name', $data['username']);
		$this->db->where('user_password', hashing($data['password']));
		$query = $this->db->get();
		return $query->row_array();
	}	
	public function insertAttendance($data){
		$this->db->select('*');
		$this->db->from('attendance');
		$this->db->where('user_id', $data['user_id']);
		$this->db->where('att_date', date('Y-m-d'));
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			$this->db->set('user_id', $data['user_id']);
			$this->db->set('att_date', date('Y-m-d'));
			$this->db->set('timestamp', date('Y-m-d H:i:s'));
			$this->db->set('status', 1);
			$this->db->insert('attendance');
		}
	}
	public function GetUsers(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->order_by('user_id','asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function GetRoles(){
		$this->db->select('*');
		$this->db->from('role');
		$this->db->where('role_status', 'active');
		$this->db->order_by('created_at','asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function GetBrands(){
		$this->db->select('*');
		$this->db->from('brand');
		$this->db->where('brand_status', 'active');
		$this->db->order_by('brand_id','asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function addnewuser($data){
		$this->db->set('user_name', $data['user_name']);
		$this->db->set('user_password', hashing($data['user_password']));
		$this->db->set('user_role', $data['user_role']);
		$this->db->set('user_brand', $data['user_brand']);
		$this->db->set('user_status', $data['user_status']);
		$this->db->insert('users');
		$id = $this->db->insert_id();
		$this->db->set('user_id', $id);
		$this->db->insert('user_profile');
		
	}
	public function edituser($data){
		$this->db->set('user_name', $data['user_name']);
		$this->db->set('user_password', hashing($data['user_password']));
		$this->db->set('user_role', $data['user_role']);
		$this->db->set('user_brand', $data['user_brand']);
		$this->db->set('user_status', $data['user_status']);
		$this->db->where('user_id', $data['user_id']);
		$this->db->update('users');
	}
	public function deleteuser($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('users');
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_profile');
	}
	public function edituserdetails($user_id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		return $query->row_array();
	}
	public function Getuserprofile($user_id){
		$this->db->select('*');
		$this->db->from('user_profile up');
		$this->db->join('users u', 'up.user_id = u.user_id', 'left');
		$this->db->where('up.user_id', $user_id);
		$query = $this->db->get();
		return $query->row_array();	
	}
	public function updateProfile($form_data){	
		$this->db->set('user_full_name', $form_data['user_full_name']);
		$this->db->set('user_post', $form_data['user_post']);
		$this->db->set('user_personal_email', $form_data['user_personal_email']);
		$this->db->set('user_personal_num', $form_data['user_personal_num']);
		$this->db->set('user_personal_address', $form_data['user_personal_address']);
		$this->db->set('user_work_email', $form_data['user_work_email']);
		$this->db->set('user_work_number', $form_data['user_work_number']);
		$this->db->set('user_blood_group', $form_data['user_blood_group']);
		if(isset($form_data['image'])){
			$this->db->set('user_picture_id', $form_data['image']);
		}
		$this->db->set('user_description', $form_data['user_description']);
		$this->db->where('profile_id', $form_data['profile_id']);
		$this->db->update('user_profile');
		$afftectedRows = $this->db->affected_rows();
		return $afftectedRows;
	}
}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */