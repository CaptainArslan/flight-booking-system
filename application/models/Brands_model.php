<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brands_model extends CI_Model
{
	public function GetBrands()
	{
		$this->db->select('*');
		$this->db->from('brand');
		$this->db->order_by('brand_id', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function ajaxBrand_view($brand_id = '')
	{
		$this->db->select('*');
		$this->db->from('brand');
		$this->db->where('brand_id', $brand_id);
		$query = $this->db->get();
		return $query->row_array();
	}
	public function deletebrand($brand_id)
	{
		$this->db->where('brand_id', $brand_id);
		$this->db->delete('brand');
	}
	public function addbrand($data)
	{
		$this->db->set('brand_name', $data['brand_name']);
		$this->db->set('brand_pre_post_fix', $data['brand_pre_post_fix']);
		$this->db->set('brand_phone', $data['brand_phone']);
		$this->db->set('brand_fax', $data['brand_fax']);
		$this->db->set('brand_email', $data['brand_email']);
		$this->db->set('brand_address', $data['brand_address']);
		$this->db->set('brand_website', $data['brand_website']);
		if (isset($data['image'])) {
			$this->db->set('brand_logo', $data['image']);
		}
		if (isset($data['link_access'])) {
			$this->db->set('authorise_paymentlink', $data['link_access']);
		}
		if (isset($data['inv_access'])) {
			$this->db->set('send_invoice', $data['inv_access']);
		}
		if (isset($data['reminder_access'])) {
			$this->db->set('send_reminder_notify', $data['reminder_access']);
		}
		if (isset($data['review_access'])) {
			$this->db->set('review', $data['review_access']);
		}
		if (isset($data['direct_link_access'])) {
			$this->db->set('direct_link', $data['direct_link_access']);
		}
		if (isset($data['direct_tktorder'])) {
			$this->db->set('direct_tktorder', $data['direct_tktorder']);
		}
		$this->db->set('brand_tc_url', $data['brand_tc_url']);
		$this->db->set('brand_commission', $data['brand_commision']);
		$this->db->set('brand_status', $data['brand_status']);
		$this->db->insert('brand');
		$id = $this->db->insert_id();
		return true;
	}
	public function editbrand($data = '')
	{
		$this->db->set('brand_name', $data['brand_name']);
		$this->db->set('brand_pre_post_fix', $data['brand_pre_post_fix']);
		$this->db->set('brand_phone', $data['brand_phone']);
		$this->db->set('brand_fax', $data['brand_fax']);
		$this->db->set('brand_email', $data['brand_email']);
		$this->db->set('brand_address', $data['brand_address']);
		$this->db->set('brand_website', $data['brand_website']);
		if (isset($data['image'])) {
			$this->db->set('brand_logo', $data['image']);
		}
		if (isset($data['link_access'])) {
			$this->db->set('authorise_paymentlink', $data['link_access']);
		} else {
			$this->db->set('authorise_paymentlink', '0');
		}
		if (isset($data['inv_access'])) {
			$this->db->set('send_invoice', $data['inv_access']);
		} else {
			$this->db->set('send_invoice', '0');
		}
		if (isset($data['reminder_access'])) {
			$this->db->set('send_reminder_notify', $data['reminder_access']);
		} else {
			$this->db->set('send_reminder_notify', '0');
		}
		if (isset($data['review_access'])) {
			$this->db->set('review', $data['review_access']);
		} else {
			$this->db->set('review', '0');
		}
		if (isset($data['direct_link_access'])) {
			$this->db->set('direct_link', $data['direct_link_access']);
		} else {
			$this->db->set('direct_link', '0');
		}
		if (isset($data['direct_tktorder'])) {
			$this->db->set('direct_tktorder', $data['direct_tktorder']);
		} else {
			$this->db->set('direct_tktorder', '0');
		}
		$this->db->set('brand_tc_url', $data['brand_tc_url']);
		$this->db->set('brand_commission', $data['brand_commision']);
		$this->db->set('brand_status', $data['brand_status']);
		$this->db->where('brand_id', $data['brand_id']);
		$this->db->update('brand');
		return true;
	}
}
/* End of file Brands_Model.php */
/* Location: ./application/models/Brands_Model.php */
