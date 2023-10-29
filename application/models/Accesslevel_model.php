<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accesslevel_model extends CI_Model {

	public function getroles(){
		$query = "SELECT * FROM `role`";
		$result = $this->db->query($query)->result_array();
		return $result;
	}
	public function addnewrole($data){
		$this->db->set('role_name', $data['role_name']);
		$this->db->set('created_at', date("Y-m-d H:i:s"));
		$this->db->set('updated_at', date("Y-m-d H:i:s"));
		$this->db->set('role_status', 'active');
		$this->db->insert('role');
		$id = $this->db->insert_id();
			foreach ($data['access_name'] as $value) {
				$this->db->set('role_id',$id);
				$this->db->set('access_id',$value);
				$this->db->insert('role_has_access');
			}
	}
	public function getAccessDetails($role_id){
		$query = "SELECT `a`.`access_name`,`a`.`access_page` from `role_has_access` `ra` left join `access` `a` on `a`.`access_id` = `ra`.`access_id` where `role_id` = '$role_id';";
		$data['access_name'] = $this->db->query($query)->result_array();
		$query = "SELECT DISTINCT `a`.`access_page` from `role_has_access` `ra` left join `access` `a` on `a`.`access_id` = `ra`.`access_id` where `role_id` = '$role_id' ORDER BY `a`.`access_page` ASC;";
		$data['access_page'] = $this->db->query($query)->result_array();
		return $data;
	}
	public function editAccessDetails($role_id){
		$query = "SELECT distinct `access_page` from `access` ORDER BY `access_page` ASC";
		$result['all_pages'] = $this->db->query($query)->result_array();
		$query = "SELECT * from `access`";
		$result['all_access'] = $this->db->query($query)->result_array();
		$query = "SELECT `a`.`access_name` from `role_has_access` `ra` left join `access` `a` on `a`.`access_id` = `ra`.`access_id` where `role_id` = '$role_id';";
		$result['role_access'] = $this->db->query($query)->result_array();
		return $result;
	}
	public function editrole($data){
		$this->db->set('role_name', $data['role_name']);
		$this->db->set('updated_at', date("Y-m-d H:i:s"));
		$this->db->where('role_id', $data['role_id']);
		$this->db->update('role');
		$this->db->query("DELETE FROM `role_has_access` Where `role_id`= '".$data['role_id']."';");
		foreach ($data['access_name'] as $value) {
			$this->db->set('role_id',$data['role_id']);
			$this->db->set('access_id',$value);
			$this->db->insert('role_has_access');
		}
		if($data['old_role_name'] == $this->session->userdata('user_role')){
			$this->session->set_userdata('user_role', $data['role_name']);
		}
	}
	public function deleterole($data){
		$query = "DELETE FROM `role` WHERE `role_id`='".$data['role_id']."' ";
		$this->db->query($query);
		$afftectedRows = $this->db->affected_rows();
		return $afftectedRows;
	}
}
/* End of file Accesslevel_Model.php */
/* Location: ./application/models/Accesslevel_Model.php */