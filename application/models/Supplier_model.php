<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Supplier_model extends CI_Model
{
	public function getsupplier($id = false)
	{
		$this->db->select('*');
		if ($id) {
			$this->db->where('supplier_id', $id);
			return $this->db->get('suppliers')->row_array();
		} else {
			return $this->db->order_by('supplier_name', 'asc')->get('suppliers')->result_array();
		}
	}
	public function addsup($form)
	{
		$row = $this->db->select('supplier_name')->where('supplier_name', $form['supplier_name'])->get('suppliers');
		if($row->num_rows() != 0){
			$row = $row->row_array();
			if ($row['supplier_name'] == $form['supplier_name']) {
				return 'exist';
			}
		}
		$form['supplier_status'] = 'active';
		$this->db->insert('suppliers', $form);
		if ($this->db->affected_rows() == 1) {
			return 'added';
		}
		return false;
	}
	public function updatesup($form)
	{
		if ($form['supplier_name'] != $form['supplier_pre']) {
			$row = $this->db->select('supplier_name')->where('supplier_name !=', $form['supplier_pre'])->where('supplier_name', $form['supplier_name'])->get('suppliers')->row_array();
			if ($row['supplier_name'] == $form['supplier_name']) {
				return 'exist';
			}
		}
		$id = $form['supplier_id'];
		unset($form['supplier_id']);
		unset($form['supplier_pre']);
		$this->db->where('supplier_id', $id);
		$this->db->update('suppliers', $form);
		if ($this->db->affected_rows() == 1) {
			return 'updated';
		}
		return false;
	}
}
/* End of file Supplier_model.php */
