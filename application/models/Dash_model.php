<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dash_model extends CI_Model
{

	public function gettotalbookings($brand = '', $agent = '')
	{
		$this->db->select('count(bkg_no) as total_booking');
		$this->db->from('bookings');
		$this->db->where('bkg_status', 'pending');
		if ($brand != '' && $brand != 'All') {
			$this->db->where('bkg_brandname', "$brand");
		}
		if ($agent != '' && $agent != 'All') {
			$this->db->where('bkg_agent', "$agent");
		}
		$row = $this->db->get()->row_array();
		return $row['total_booking'];
	}
	public function getmonthbookings($brand = '', $agent = '')
	{
		$this->db->select('count(bkg_no) as total_booking');
		$this->db->from('bookings');
		$this->db->where('bkg_status !=', 'Deleted');
		$this->db->where('MONTH(bkg_date)', date('m'));
		$this->db->where('YEAR(bkg_date)', date('Y'));
		if ($brand != '' && $brand != 'All') {
			$this->db->where('bkg_brandname', "$brand");
		}
		if ($agent != '' && $agent != 'All') {
			$this->db->where('bkg_agent', "$agent");
		}
		$row = $this->db->get()->row_array();
		return $row['total_booking'];
	}
	public function getdept_due($brand = '', $agent = '')
	{
		$this->db->select('count(bkg_no) as dept_due');
		$this->db->from('bookings');
		$this->db->where('bkg_status', 'Issued');
		$this->db->where('flt_departuredate', date("Y-m-d"));
		if ($brand != '' && $brand != 'All') {
			$this->db->where('bkg_brandname', "$brand");
		}
		if ($agent != '' && $agent != 'All') {
			$this->db->where('bkg_agent', "$agent");
		}
		$row = $this->db->get()->row_array();
		return $row['dept_due'];
	}
	public function get_ttl_dept_due($brand = '', $agent = '')
	{
		$this->db->select('count(bkg_no) as ttldeptdue');
		$this->db->from('bookings');
		$this->db->where('bkg_status', 'Issued');
		$this->db->where('flt_departuredate >=', date("Y-m-d"));
		if ($brand != '' && $brand != 'All') {
			$this->db->where('bkg_brandname', "$brand");
		}
		if ($agent != '' && $agent != 'All') {
			$this->db->where('bkg_agent', "$agent");
		}
		$row = $this->db->get()->row_array();
		return $row['ttldeptdue'];
	}
	public function getreturned($brand = '', $agent = '')
	{
		$this->db->select('count(bkg_no) as returned');
		$this->db->from('bookings');
		$this->db->where('bkg_status', 'Issued');
		$this->db->where('flt_returningdate = DATE(DATE_ADD(NOW(), INTERVAL - 1 DAY))');
		if ($brand != '' && $brand != 'All') {
			$this->db->where('bkg_brandname', "$brand");
		}
		if ($agent != '' && $agent != 'All') {
			$this->db->where('bkg_agent', "$agent");
		}
		$row = $this->db->get()->row_array();
		return $row['returned'];
	}
	public function getb_days($brand = '', $agent = '')
	{
		$this->db->select('count(`p`.`bkg_no`) as b_days');
		$this->db->from('bookings bkg');
		$this->db->join('passengers p', 'p.bkg_no = bkg.bkg_no', 'left');
		$this->db->where('bkg.bkg_status !=', 'Deleted');
		$this->db->where('MONTH(`p`.`p_age`)', date('m'));
		$this->db->where('day(`p`.`p_age`)', date('d'));
		if ($brand != '' && $brand != 'All') {
			$this->db->where('bkg.bkg_brandname', "$brand");
		}
		if ($agent != '' && $agent != 'All') {
			$this->db->where('bkg.bkg_agent', "$agent");
		}
		$row = $this->db->get()->row_array();
		return $row['b_days'];
	}
	public function getmonthmargin($brand = '', $agent = '')
	{
		$sdate = date('Y-m-01');
		$edate = date('Y-m-t');
		$status = array('Issued', 'Cleared');
		$this->db->select('(bkg.cost_basic+bkg.cost_tax+bkg.cost_apc+bkg.cost_safi+bkg.cost_misc+bkg.cost_postage+bkg.cost_cardverfication+bkg.cost_cardcharges+bkg.cost_bank_charges_internal+IFNULL(htl.cost,0)+IFNULL(cab.cost,0))as cost,(select SUM(`p`.`p_basic` + `p`.`p_tax` + `p`.`p_bookingfee` + `p`.`p_cardcharges` + `p`.`p_others`+ `p`.`p_hotel`+ `p`.`p_cab`) from passengers p where p.bkg_no = bkg.bkg_no) as sale');
		$this->db->from('bookings bkg');
		$this->db->join('bookings_hotel htl', 'htl.bkg_no = bkg.bkg_no', 'left');
		$this->db->join('bookings_cab cab', 'cab.bkg_no = bkg.bkg_no', 'left');
		$this->db->where('bkg.clr_date >=', $sdate);
		$this->db->where('bkg.clr_date <=', $edate);
		$this->db->where_in('bkg.bkg_status', $status);
		if ($brand != '' && $brand != 'All') {
			$this->db->where('bkg.bkg_brandname', "$brand");
		}
		if ($agent != '' && $agent != 'All') {
			$this->db->where('bkg.bkg_agent', "$agent");
		}
		$this->db->group_by('bkg.bkg_no');
		$this->db->order_by('bkg.clr_date');
		$result = $this->db->get()->result_array();
		$issuance = 0;
		if (count($result) > 0) {
			foreach ($result as $key => $row) {
				$issuance += round($row['sale'] - $row['cost'], 2);
			}
		}
		////////////Cancelled Profit//////////////
		$this->db->select('bkg.bkg_no,(bkg.cost_basic + bkg.cost_tax + bkg.cost_apc + bkg.cost_safi + bkg.cost_misc + bkg.cost_postage + bkg.cost_cardverfication + bkg.cost_cardcharges + bkg.cost_bank_charges_internal+IFNULL(htl.cost,0)+IFNULL(cab.cost,0)) as cost');
		$this->db->from('bookings bkg');
		$this->db->join('bookings_hotel htl', 'htl.bkg_no = bkg.bkg_no', 'left');
		$this->db->join('bookings_cab cab', 'cab.bkg_no = bkg.bkg_no', 'left');
		$this->db->where('bkg.cnl_date >=', $sdate);
		$this->db->where('bkg.cnl_date <=', $edate);
		$this->db->where('bkg.bkg_status', 'Cancelled');
		if ($brand != '' && $brand != 'All') {
			$this->db->where('bkg.bkg_brandname', $brand);
		}
		if ($agent != '' && $agent != 'All') {
			$this->db->where('bkg.bkg_agent', $agent);
		}
		$this->db->group_by('bkg.bkg_no');
		$this->db->order_by('bkg.cnl_date', 'ASC');
		$result = $this->db->get()->result_array();
		$cancellation = 0;
		if (count($result) > 0) {
			foreach ($result as $key => $row) {
				$id = $row['bkg_no'];
				$pay = Getrcepaid($id);
				$cancellation += round($pay['amt_received'] - ($pay['amt_refund'] + $row['cost']), 2);
			}
		}
		$total_profit = $issuance + $cancellation;
		return $total_profit;
	}
	public function getpendinginq($brand = '', $agent = '')
	{
		$this->db->select('count(enq_id) as total_inq');
		$this->db->from('customer_enq');
		$this->db->where('enq_status', 'Open');
		if ($brand != '' && $brand != 'All') {
			$this->db->where('enq_brand', "$brand");
		}
		if ($agent != '' && $agent != 'All') {
			$this->db->where('picked_by', "$agent");
		}
		$row = $this->db->get()->row_array();
		return $row['total_inq'];
	}
	public function getnoticount()
	{
		$count = $this->db->select('*')
			->from('notification')
			->where('added_for', $this->session->userdata('user_name'))
			->where('status', 'unread')
			->get()->num_rows();
		return $count;
	}
	public function getnoti()
	{
		$res = $this->db->select('*')
			->from('notification')
			->where('added_for', $this->session->userdata('user_name'))
			->where('status', 'unread')
			->get()->result_array();
		return $res;
	}
	public function removetoaster($id = '')
	{
		$this->db->set('toaster', '0')->where('id', $id)->update('notification');
		return true;
	}
	public function getreminders()
	{
		$this->db->select('ea.id,ea.enq_id,ea.alert_msg,ea.alert_datetime');
		$this->db->from('cust_enq_alert ea');
		$this->db->join('customer_enq ce', 'ce.enq_id = ea.enq_id', 'left');
		$this->db->where('ce.picked_by', $this->session->userdata('user_name'));
		$this->db->where('ea.alert_datetime', date('Y-m-d H:i'));
		$this->db->where('ea.alert_notification', '1');
		$result['all_alert'] =  $this->db->get()->result_array();
		$data = array();
		if (count($result['all_alert']) > 0) {
			foreach ($result['all_alert'] as $key => $value) {
				$data['all_alert'][$key]['id'] = $value['id'];
				$data['all_alert'][$key]['enq_id'] = $value['enq_id'];
				$data['all_alert'][$key]['msg'] = $value['alert_msg'];
				$data['all_alert'][$key]['datetime'] = date('d-M-Y h:i A', strtotime($value['alert_datetime']));
				$data['all_alert'][$key]['url'] = "inquiry/view/" . hashing($value['enq_id']);
			}
			$data['status'] = true;
		} else {
			$data['status'] = false;
		}
		return $data;
	}
	public function removereminderpopup($id = '')
	{
		$this->db->set('alert_notification', '0')->where('id', $id)->update('cust_enq_alert');
		return true;
	}
}

/* End of file Dash_Model.php */
/* Location: ./application/models/Dash_Model.php */
