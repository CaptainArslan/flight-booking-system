<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends CI_Model
{

	public function getbrands($brand = '')
	{
		$this->db->select('brand_name');
		$this->db->from('brand');
		$this->db->where('brand_status', 'active');
		if ($brand != '') {
			$this->db->where_in('brand_name', $brand);
		}
		return $this->db->get()->result_array();
	}
	public function getsuppliers($sup = '')
	{
		$this->db->select('supplier_name');
		$this->db->from('suppliers');
		if ($sup != '') {
			$this->db->where_in('supplier_name', $sup);
		}
		return $this->db->get()->result_array();
	}
	public function getagents($agent = '', $brand = '')
	{
		$this->db->select('user_name');
		$this->db->from('users');
		$this->db->where('user_name !=', 'IT Manager');
		if ($agent != '') {
			$this->db->where_in('user_name', $agent);
		}
		if ($brand != '') {
			$this->db->where_in('user_brand', $brand);
		}
		return $this->db->get()->result_array();
	}
	public function getcards($card = '')
	{
		$this->db->select('trans_head as card_name');
		$this->db->from('transaction_heads');
		if ($card != '') {
			$this->db->where_in('trans_head', $card);
		}
		$this->db->where_in('trans_head_mode', 'card');
		return $this->db->get()->result_array();
	}
	public function getreport($user_role = '')
	{
		$query_role_reports = "SELECT `a`.`access_name` as report_id FROM `role_has_access` `rha` LEFT JOIN `role` `r` on `r`.`role_id` = `rha`.`role_id` LEFT JOIN `access` `a` on `a`.`access_id` = `rha`.`access_id` WHERE `a`.`access_page` = 'report_name' AND `r`.`role_name` = '$user_role'";
		$result = $this->db->query($query_role_reports)->result_array();
		return $result;
	}
	public function report_gross_profit_earned($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$agent = $data['agent'];
		$brand = $data['brand'];
		$supplier = $data['supplier'];
		$status = array('Issued', 'Cleared');
		$this->db->select('bkg.clr_date,bkg.bkg_agent,bkg.bkg_no,bkg.bkg_supplier_reference,bkg.cst_name,bkg.flt_destinationairport,bkg.flt_airline,(IFNULL(`cab`.`cost`,0)+IFNULL(`htl`.`cost`,0)+`bkg`.`cost_basic`+`bkg`.`cost_tax`+`bkg`.`cost_apc`+`bkg`.`cost_safi`+`bkg`.`cost_misc`) as bkg_cost, (`bkg`.`cost_postage`+`bkg`.`cost_cardverfication`+`bkg`.`cost_cardcharges`+`bkg`.`cost_bank_charges_internal`) as admin_exp, (select SUM(`p`.`p_basic` + `p`.`p_tax` + `p`.`p_bookingfee` + `p`.`p_cardcharges` + `p`.`p_others`+ `p`.`p_hotel`+ `p`.`p_cab`) from passengers p where p.bkg_no = bkg.bkg_no) as saleprice');
		$this->db->from('bookings bkg');
		$this->db->join('bookings_hotel htl', 'htl.bkg_no = bkg.bkg_no', 'left');
		$this->db->join('bookings_cab cab', 'cab.bkg_no = bkg.bkg_no', 'left');
		$this->db->where('bkg.clr_date >=', $sdate);
		$this->db->where('bkg.clr_date <=', $edate);
		$this->db->where_in('bkg.bkg_status', $status);
		if ($brand != 'All' && $brand != '') {
			$this->db->where('bkg.bkg_brandname', $brand);
		}
		if ($agent != 'All' && $agent != '') {
			$this->db->where('bkg.bkg_agent', $agent);
		}
		if ($supplier != 'All' && $supplier != '') {
			$this->db->where('bkg.sup_name', $supplier);
		}
		$this->db->group_by('bkg.bkg_no');
		$this->db->order_by('bkg.clr_date');
		$result = $this->db->get();
		$data['issued_booking'] = $result->result_array();

		////////////Cancelled Profit//////////////
		$this->db->select('cnl_date,bkg_agent,bkg.bkg_no,bkg_supplier_reference,cst_name,flt_destinationairport,(IFNULL(htl.cost,0)+IFNULL(cab.cost,0)+cost_basic+cost_tax+cost_apc+cost_safi+cost_misc) as bkg_cost, (cost_postage+cost_cardverfication+cost_cardcharges+cost_bank_charges_internal) as admin_exp');
		$this->db->from('bookings bkg');
		$this->db->join('bookings_hotel htl', 'htl.bkg_no = bkg.bkg_no', 'left');
		$this->db->join('bookings_cab cab', 'cab.bkg_no = bkg.bkg_no', 'left');
		$this->db->where('cnl_date >=', $sdate);
		$this->db->where('cnl_date <=', $edate);
		$this->db->where('bkg_status', 'Cancelled');
		if ($brand != 'All' && $brand != '') {
			$this->db->where('bkg_brandname', $brand);
		}
		if ($agent != 'All' && $agent != '') {
			$this->db->where('bkg_agent', $agent);
		}
		if ($supplier != 'All' && $supplier != '') {
			$this->db->where('sup_name', $supplier);
		}
		$this->db->group_by('bkg.bkg_no');
		$this->db->order_by('cnl_date', 'ASC');
		$result = $this->db->get();
		$data['cancelled'] = $result->result_array();
		return $data;
	}
	public function getcommisionrate($brand = '')
	{
		$this->db->select('brand_commission');
		$this->db->from('brand');
		$this->db->where('brand_name', $brand);
		$result = $this->db->get()->row_array();
		return $result['brand_commission'];
	}
	public function getexpenses($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$agent = $data['agent'];
		$brand = $data['brand'];
		$supplier = $data['supplier'];
		if ($brand == $this->mainbrand ) {
			$brandnameexp = "AND th.`owner` IN( '$brand','UK Office')";
		} elseif ($brand != 'All') {
			$brandnameexp = "AND th.`owner` = '$brand'";
		} else {
			$brandnameexp = '';
		}
		$queryexphead = "SELECT  t.`trans_head` FROM `transactions` t, `transaction_heads` th WHERE t.`trans_head` = th.`trans_head` AND th.`type` = 3 AND t.`trans_date` BETWEEN '$sdate' AND '$edate' $brandnameexp GROUP BY t.`trans_head`";
		$rslt = $this->db->query($queryexphead)->result_array();
		$data = array();
		foreach ($rslt as $key => $head) {
			$hd = $head['trans_head'];
			$data[$key]['head'] = $hd;
			$queryexp = "SELECT sum( CASE WHEN `t`.`trans_type` = 'Dr' THEN `trans_amount` ELSE -`trans_amount` END) AS exp FROM `transactions` t, `transaction_heads` th WHERE t.`trans_head` = th.`trans_head` AND th.`type` = 3 AND t.`trans_head` = '$hd'  AND t.`trans_date` BETWEEN '$sdate' AND '$edate' GROUP BY t.`trans_head`";
			$rsltexp = $this->db->query($queryexp)->row_array();
			$data[$key]['exp_amt'] = $rsltexp['exp'];
		}
		return $data;
	}
	public function getotherincome($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$agent = $data['agent'];
		$brand = $data['brand'];
		$supplier = $data['supplier'];
		$data = array();
		$queryincomehead = "SELECT  t.`trans_head` FROM `transactions` t, `transaction_heads` th WHERE t.`trans_head` = th.`trans_head` AND th.`type` = 4 AND t.`trans_date` BETWEEN '$sdate' AND '$edate' GROUP BY t.`trans_head`";
		$rsltincomheads = $this->db->query($queryincomehead)->result_array();
		if (count($rsltincomheads) > 0) {
			foreach ($rsltincomheads as $key => $head) {
				$data[$key]['incm_amt'] = 0;
				$hd = $head['trans_head'];
				$data[$key]['head'] = $hd;
				$queryincome = "SELECT sum( CASE WHEN `t`.`trans_type` = 'Dr' THEN `trans_amount` ELSE -`trans_amount` END) AS income FROM `transactions` t, `transaction_heads` th WHERE t.`trans_head` = th.`trans_head` AND th.`type` = 4 AND t.`trans_head` = '$hd' AND t.`trans_date` BETWEEN '$sdate' AND '$edate' GROUP BY t.`trans_head`";
				$rsltincm = $this->db->query($queryincome)->row_array();
				$data[$key]['incm_amt'] = @$rsltincm['income'];
			}
		}
		return $data;
	}
	public function getsubcommision($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$agent = $data['agent'];
		$brand = $data['brand'];
		$supplier = $data['supplier'];
		$data = array();
		$brand_comm = 0;
		$query_brand = "SELECT `brand_commission`,`brand_name` FROM `brand` WHERE `brand_name` != '".$this->mainbrand."' ORDER BY `brand_name`";
		$result_brand = $this->db->query($query_brand)->result_array();
		foreach ($result_brand as $key => $rowbrand) {
			$key_main =  $key;
			$brand_comm = $rowbrand['brand_commission'];
			$subagent_brand = $rowbrand['brand_name'];
			$data[$key_main]['head'] = $subagent_brand;
			$net_cancellation_profit = 0;
			$net_sale_profit = 0;
			$status = array('Issued', 'Cleared');
			$this->db->select('(IFNULL(`cab`.`cost`,0)+IFNULL(`htl`.`cost`,0)+`bkg`.`cost_basic`+`bkg`.`cost_tax`+`bkg`.`cost_apc`+`bkg`.`cost_safi`+`bkg`.`cost_misc`) as bkg_cost, (`bkg`.`cost_postage`+`bkg`.`cost_cardverfication`+`bkg`.`cost_cardcharges`+`bkg`.`cost_bank_charges_internal`) as admin_exp, (select SUM(`p`.`p_basic` + `p`.`p_tax` + `p`.`p_bookingfee` + `p`.`p_cardcharges` + `p`.`p_others`+ `p`.`p_hotel`+ `p`.`p_cab`) from passengers p where p.bkg_no = bkg.bkg_no) as saleprice');
			$this->db->from('bookings bkg');
			$this->db->join('bookings_hotel htl', 'htl.bkg_no = bkg.bkg_no', 'left');
			$this->db->join('bookings_cab cab', 'cab.bkg_no = bkg.bkg_no', 'left');
			$this->db->where('bkg.clr_date >=', $sdate);
			$this->db->where('bkg.clr_date <=', $edate);
			$this->db->where_in('bkg.bkg_status', $status);
			$this->db->where('bkg.bkg_brandname', $subagent_brand);
			$this->db->group_by('bkg.bkg_no');
			$this->db->order_by('bkg.clr_date');
			$brand_sheets = $result = $this->db->get()->result_array();
			if (count($brand_sheets) > 0) {
				foreach ($brand_sheets as $key => $brand_sheet) {
					$profit = 0;
					$profit = round(($brand_sheet['saleprice'] - ($brand_sheet['bkg_cost'] + $brand_sheet['admin_exp'])), 2);
					if ($profit > 0) {
						$net_sale_profit += $profit;
					}
				}
				$net_sale_profit;
			}
			$this->db->select('bkg.bkg_no,(IFNULL(cab.cost,0)+IFNULL(htl.cost,0)+cost_basic+cost_tax+cost_apc+cost_safi+cost_misc) as bkg_cost, (cost_postage+cost_cardverfication+cost_cardcharges+cost_bank_charges_internal) as admin_exp');
			$this->db->from('bookings bkg');
			$this->db->join('bookings_hotel htl', 'htl.bkg_no = bkg.bkg_no', 'left');
			$this->db->join('bookings_cab cab', 'cab.bkg_no = bkg.bkg_no', 'left');
			$this->db->where('cnl_date >=', $sdate);
			$this->db->where('cnl_date <=', $edate);
			$this->db->where('bkg_status', 'Cancelled');
			$this->db->where('bkg_brandname', $subagent_brand);
			$this->db->group_by('bkg.bkg_no');
			$this->db->order_by('cnl_date', 'ASC');
			$brand_sheets = $result = $this->db->get()->result_array();
			if (count($brand_sheets) > 0) {
				foreach ($brand_sheets as $key => $brand_sheet) {
					$profit = 0;
					$bkgid = $brand_sheet['bkg_no'];
					$paid_received = Getrcepaid($bkgid);
					$profit = round(($paid_received['amt_received'] - ($paid_received['amt_refund'] + $brand_sheet['bkg_cost'] + $brand_sheet['admin_exp'])), 2);
					if ($profit > 0) {
						$net_cancellation_profit += $profit;
					}
				}
			}
			$total_profit = 0;
			$total_profit = $net_sale_profit + $net_cancellation_profit;
			$comm = 0;
			$comm = round($total_profit * $brand_comm, 2) / 100;
			$data[$key_main]['head_amt'] = $comm;
		}
		return $data;
	}
	public function report_client_data($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$agent = $data['agent'];
		$brand = $data['brand'];
		$supplier = $data['supplier'];
		$status = array('Issued', 'Cleared');
		$this->db->select('bkg.clr_date,bkg.bkg_agent,bkg.bkg_no,bkg.bkg_supplier_reference,bkg.cst_name,bkg.flt_destinationairport,bkg.flt_airline,bkg.cst_email,bkg.cst_mobile,(IFNULL(cab.cost,0)+IFNULL(htl.cost,0)+bkg.cost_basic+bkg.cost_tax+bkg.cost_apc+bkg.cost_safi+bkg.cost_misc+bkg.cost_postage+bkg.cost_cardverfication+bkg.cost_cardcharges+bkg.cost_bank_charges_internal) as bkg_cost, (select SUM(`p`.`p_basic` + `p`.`p_tax` + `p`.`p_bookingfee` + `p`.`p_cardcharges` + `p`.`p_others`+ `p`.`p_hotel`+ `p`.`p_cab`) from passengers p where p.bkg_no = bkg.bkg_no) as saleprice');
		$this->db->from('bookings bkg');
		$this->db->join('bookings_hotel htl', 'htl.bkg_no = bkg.bkg_no', 'left');
		$this->db->join('bookings_cab cab', 'cab.bkg_no = bkg.bkg_no', 'left');
		$this->db->where('bkg.clr_date >=', $sdate);
		$this->db->where('bkg.clr_date <=', $edate);
		$this->db->where_in('bkg.bkg_status', $status);
		if ($brand != 'All' && $brand != '') {
			$this->db->where('bkg.bkg_brandname', $brand);
		}
		if ($agent != 'All' && $agent != '') {
			$this->db->where('bkg.bkg_agent', $agent);
		}
		if ($supplier != 'All' && $supplier != '') {
			$this->db->where('bkg.sup_name', $supplier);
		}
		$this->db->group_by('bkg.bkg_no');
		$this->db->order_by('bkg.clr_date');
		$result = $this->db->get();
		$data['issued_booking'] = $result->result_array();

		////////////Cancelled Profit//////////////
		$this->db->select('cnl_date,bkg_agent,bkg.bkg_no,bkg_supplier_reference,cst_name,flt_destinationairport,flt_airline,cst_email,cst_mobile,(IFNULL(htl.cost,0)+IFNULL(cab.cost,0)+cost_basic+cost_tax+cost_apc+cost_safi+cost_misc+cost_postage+cost_cardverfication+cost_cardcharges+cost_bank_charges_internal) as bkg_cost');
		$this->db->from('bookings bkg');
		$this->db->join('bookings_hotel htl', 'htl.bkg_no = bkg.bkg_no', 'left');
		$this->db->join('bookings_cab cab', 'cab.bkg_no = bkg.bkg_no', 'left');
		$this->db->where('cnl_date >=', $sdate);
		$this->db->where('cnl_date <=', $edate);
		$this->db->where('bkg_status', 'Cancelled');
		if ($brand != 'All' && $brand != '') {
			$this->db->where('bkg_brandname', $brand);
		}
		if ($agent != 'All' && $agent != '') {
			$this->db->where('bkg_agent', $agent);
		}
		if ($supplier != 'All' && $supplier != '') {
			$this->db->where('sup_name', $supplier);
		}
		$this->db->group_by('bkg.bkg_no');
		$this->db->order_by('cnl_date', 'ASC');
		$result = $this->db->get();
		$data['cancelled'] = $result->result_array();
		return $data;
	}
	public function report_customer_due_balance($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$agent = $data['agent'];
		$brand = $data['brand'];
		$supplier = $data['supplier'];
		$status = array('Issued', 'Cleared');
		$this->db->select('bkg.clr_date,bkg.bkg_agent,bkg.bkg_brandname,bkg.bkg_no,bkg.bkg_supplier_reference,bkg.cst_name,bkg.flt_pnr,(IFNULL(htl.cost,0)+IFNULL(cab.cost,0)+bkg.cost_basic+bkg.cost_tax+bkg.cost_apc+bkg.cost_safi+bkg.cost_misc) as bkg_cost, (bkg.cost_postage+bkg.cost_cardverfication+bkg.cost_cardcharges+bkg.cost_bank_charges_internal) as admin_exp, (select SUM(`p`.`p_basic` + `p`.`p_tax` + `p`.`p_bookingfee` + `p`.`p_cardcharges` + `p`.`p_others`+ `p`.`p_hotel`+ `p`.`p_cab`) from passengers p where p.bkg_no = bkg.bkg_no) as saleprice');
		$this->db->from('bookings bkg');
		$this->db->join('bookings_hotel htl', 'htl.bkg_no = bkg.bkg_no', 'left');
		$this->db->join('bookings_cab cab', 'cab.bkg_no = bkg.bkg_no', 'left');
		$this->db->where('bkg.clr_date >=', $sdate);
		$this->db->where('bkg.clr_date <=', $edate);
		$this->db->where_in('bkg.bkg_status', $status);
		if ($brand != 'All' && $brand != '') {
			$this->db->where('bkg.bkg_brandname', $brand);
		}
		if ($agent != 'All' && $agent != '') {
			$this->db->where('bkg.bkg_agent', $agent);
		}
		if ($supplier != 'All' && $supplier != '') {
			$this->db->where('bkg.sup_name', $supplier);
		}
		$this->db->group_by('bkg.bkg_no');
		$this->db->order_by('bkg.clr_date');
		$result = $this->db->get();
		$data['issued_booking'] = $result->result_array();
		return $data;
	}

	public function report_supplier_due_balance($data = '')
	{
		if ($data['start_date'] != '') {
			$sdate = date('Y-m-d', strtotime($data['start_date']));
		}
		if ($data['end_date'] != '') {
			$edate = date('Y-m-d', strtotime($data['end_date']));
		}
		$agent = $data['agent'];
		$brand = $data['brand'];
		$supplier = $data['supplier'];
		$brandname = $bkg_agent = $sup_name = '';

		if ($brand == 'All') {
			$brandname = '';
		} else {
			$brandname = " AND `bkg.bkg_brandname` = '" . $brand . "' ";
		}

		if ($agent == 'All') {
			$bkg_agent = '';
		} else {
			$bkg_agent = " AND `bkg.bkg_agent` = '" . $agent . "' ";
		}

		if ($supplier == 'All') {
			$sup_name = '';
		} else {
			$sup_name = " AND (`bkg`.`sup_name` = '" . $supplier . "'  OR `htl`.`supplier` = '" . $supplier . "' OR `cab`.`supplier` = '" . $supplier . "')";
		}
		if ($data['start_date'] != '' && $data['end_date'] != '') {
			$sql = "SELECT bkg.bkg_supplier_reference as flt_sup_ref,htl.sup_ref as htl_sup_ref,cab.sup_ref as cab_sup_ref,bkg.bkg_no as trans_ref,bkg.bkg_status,bkg.clr_date as issued_date,bkg.bkg_agent,bkg.bkg_brandname,bkg.sup_name as flt_sup,htl.supplier as htl_sup,cab.supplier as cab_sup,IFNULL(htl.cost,0) as htl_due,IFNULL(cab.cost,0) as cab_due,(bkg.cost_basic+bkg.cost_tax+bkg.cost_apc+bkg.cost_safi+bkg.cost_misc) as flt_due FROM bookings bkg LEFT JOIN bookings_hotel htl ON bkg.bkg_no = htl.bkg_no LEFT JOIN bookings_cab cab ON bkg.bkg_no = cab.bkg_no WHERE bkg_status in('Cleared','Issued','Cancelled') $bkg_agent $brandname  $sup_name and (clr_date between '$sdate' and '$edate' or  cnl_date between '$sdate' and '$edate') GROUP BY bkg.bkg_no order by clr_date";
		} else {
			$sql = "SELECT bkg.bkg_supplier_reference as flt_sup_ref,htl.sup_ref as htl_sup_ref,cab.sup_ref as cab_sup_ref,bkg.bkg_no as trans_ref,bkg.bkg_status,bkg.clr_date as issued_date,bkg.bkg_agent,bkg.bkg_brandname,bkg.sup_name as flt_sup,htl.supplier as htl_sup,cab.supplier as cab_sup,IFNULL(htl.cost,0) as htl_due,IFNULL(cab.cost,0) as cab_due,(bkg.cost_basic+bkg.cost_tax+bkg.cost_apc+bkg.cost_safi+bkg.cost_misc) as flt_due FROM bookings bkg LEFT JOIN bookings_hotel htl ON bkg.bkg_no = htl.bkg_no LEFT JOIN bookings_cab cab ON bkg.bkg_no = cab.bkg_no WHERE bkg_status in('Cleared','Issued','Cancelled') $bkg_agent $brandname  $sup_name GROUP BY bkg.bkg_no order by clr_date";
		}
		$results = $this->db->query($sql)->result_array();
		$due_array = array();
		$counter = 0;
		foreach ($results as $key => $row) {
			if ($row['flt_sup'] != NULL && ($row['flt_sup'] == $supplier || $supplier == 'All')) {
				$sql = "SELECT sum( CASE WHEN trans_type = 'Dr' THEN trans_amount ELSE -trans_amount END) as trans_amount FROM transactions WHERE trans_ref = '" . $row['trans_ref'] . "' AND trans_description <> 'Tickets Purchased From Supplier' AND trans_description <> 'Hotel Purchased From Supplier' AND trans_description <> 'Cab Purchased From Supplier' AND trans_head = '" . $row['flt_sup'] . "'";
				$trans = $this->db->query($sql)->row_array();
				$amt_due = 0;
				if($row['flt_sup'] == $row['htl_sup']){
					$amt_due = $row['flt_due'] + $row['htl_due'] - $trans['trans_amount'] ;
				}else if($row['flt_sup'] == $row['cab_sup']){
					$amt_due = $row['flt_due'] + $row['cab_due'] - $trans['trans_amount'] ;
				}else{
					$amt_due = $row['flt_due'] - $trans['trans_amount'];
				}
				if ($amt_due != 0) {
					$due_array[$counter]['sup_ref'] = $row['flt_sup_ref'];
					$due_array[$counter]['trans_ref'] = $row['trans_ref'];
					$due_array[$counter]['bkg_status'] = $row['bkg_status'];
					$due_array[$counter]['issued_date'] = $row['issued_date'];
					$due_array[$counter]['bkg_agent'] = $row['bkg_agent'];
					$due_array[$counter]['bkg_brandname'] = $row['bkg_brandname'];
					$due_array[$counter]['supplier'] = $row['flt_sup'];
					$due_array[$counter]['amt_due'] = $amt_due;
					$counter++;
				}
			}
			if ($row['htl_sup'] != NULL && ($row['htl_sup'] == $supplier || $supplier == 'All')) {
				$sql = "SELECT sum( CASE WHEN trans_type = 'Dr' THEN trans_amount ELSE -trans_amount END) as trans_amount FROM transactions WHERE trans_ref = '" . $row['trans_ref'] . "' AND trans_description <> 'Tickets Purchased From Supplier' AND trans_description <> 'Hotel Purchased From Supplier' AND trans_description <> 'Cab Purchased From Supplier' AND trans_head = '" . $row['htl_sup'] . "'";
				$trans = $this->db->query($sql)->row_array();
				$amt_due = 0;
				if($row['htl_sup'] == $row['flt_sup']){
					$amt_due = $row['htl_due'] + $row['flt_due'] - $trans['trans_amount'] ;
				}else if($row['htl_sup'] == $row['cab_sup']){
					$amt_due = $row['htl_due'] + $row['cab_due'] - $trans['trans_amount'] ;
				}else{
					$amt_due = $row['htl_due'] - $trans['trans_amount'];
				}
				if ($amt_due != 0) {
					$due_array[$counter]['sup_ref'] = $row['htl_sup_ref'];
					$due_array[$counter]['trans_ref'] = $row['trans_ref'];
					$due_array[$counter]['bkg_status'] = $row['bkg_status'];
					$due_array[$counter]['issued_date'] = $row['issued_date'];
					$due_array[$counter]['bkg_agent'] = $row['bkg_agent'];
					$due_array[$counter]['bkg_brandname'] = $row['bkg_brandname'];
					$due_array[$counter]['supplier'] = $row['htl_sup'];
					$due_array[$counter]['amt_due'] = $amt_due;
					$counter++;
				}
			}
			if ($row['cab_sup'] != NULL && ($row['cab_sup'] == $supplier || $supplier == 'All')) {
				$sql = "SELECT sum( CASE WHEN trans_type = 'Dr' THEN trans_amount ELSE -trans_amount END) as trans_amount FROM transactions WHERE trans_ref = '" . $row['trans_ref'] . "' AND trans_description <> 'Tickets Purchased From Supplier' AND trans_description <> 'Hotel Purchased From Supplier' AND trans_description <> 'Cab Purchased From Supplier' AND trans_head = '" . $row['cab_sup'] . "'";
				$trans = $this->db->query($sql)->row_array();
				$amt_due = 0;
				if($row['cab_sup'] == $row['flt_sup']){
					$amt_due = $row['cab_due'] + $row['flt_due'] - $trans['trans_amount'] ;
				}else if($row['cab_sup'] == $row['htl_sup']){
					$amt_due = $row['cab_due'] + $row['htl_due'] - $trans['trans_amount'] ;
				}else{
					$amt_due = $row['cab_due'] - $trans['trans_amount'];
				}
				if ($amt_due != 0) {
					$due_array[$counter]['sup_ref'] = $row['cab_sup_ref'];
					$due_array[$counter]['trans_ref'] = $row['trans_ref'];
					$due_array[$counter]['bkg_status'] = $row['bkg_status'];
					$due_array[$counter]['issued_date'] = $row['issued_date'];
					$due_array[$counter]['bkg_agent'] = $row['bkg_agent'];
					$due_array[$counter]['bkg_brandname'] = $row['bkg_brandname'];
					$due_array[$counter]['supplier'] = $row['cab_sup'];
					$due_array[$counter]['amt_due'] = $amt_due;
					$counter++;
				}
			}
		}
		return $due_array;
	}
	public function report_supplier_variance_p_t($data = '')
	{
		// $sdate = date('Y-m-d', strtotime($data['start_date']));
		// $edate = date('Y-m-d', strtotime($data['end_date']));
		$agent = $data['agent'];
		$brand = $data['brand'];
		$supplier = $data['supplier'];
		$brandname = $bkg_agent = $sup_name = '';
		if ($brand != 'All') {
			$brandname = " AND `bkg_brandname` = '" . $brand . "' ";
		}
		if ($agent != 'All') {
			$bkg_agent = " AND `bkg_agent` = '" . $agent . "' ";
		}
		if ($supplier != 'All') {
			$sup_name = " AND h.trial_balance_head =  '".$supplier."'";
		}
		// $sql = "SELECT b.bkg_status,b.bkg_supplier_reference as flt_sup_ref,h.sup_ref as htl_sup_ref,c.sup_ref as cab_sup_ref,b.cnl_date,b.clr_date as issued_date,b.bkg_agent,b.bkg_brandname,b.sup_name as flt_sup,c.supplier as cab_sup,h.supplier as htl_sup,(IFNULL(h.cost,0)+IFNULL(c.cost,0)+b.cost_basic+b.cost_tax+b.cost_apc+b.cost_safi+b.cost_misc)as ticket_cost,t.trans_ref,t.trans_head,t.trans_type,t.trans_amount FROM `transactions` t INNER JOIN bookings b ON t.trans_ref=b.bkg_no LEFT JOIN bookings_hotel h on h.bkg_no = b.bkg_no LEFT JOIN bookings_cab c on c.bkg_no = b.bkg_no where t.trans_head in(SELECT trans_head from transaction_heads where trans_head NOT IN('Customer','Drawings','Account Receivable','Adjustment Balance','Shakeel Malik','P&L Account','Noreen Shakeel','GDS & IATA Fee') AND `type` = '2') and bkg_status in('Cleared','Issued','Cancelled') AND t.`trans_description` <> 'Tickets Purchased From Supplier' AND t.`trans_description` <> 'Hotel Purchased From Supplier' AND t.`trans_description` <> 'Cab Purchased From Supplier' and t.trans_ref<>0 $brandname $bkg_agent $sup_name order by b.bkg_status,t.trans_ref";
		// $transactions = $this->db->query($sql)->result_array();			
		// $np = $diff = 0;
		// $t_trans = count($transactions);
		// $results = array();
		// foreach ($transactions as $index => $transaction) {
		// 	if ($transaction["trans_type"] == "Dr") {
		// 		$np += $transaction["trans_amount"];
		// 	} else {
		// 		$np -= $transaction["trans_amount"];
		// 	}
		// 	if ($t_trans == $index + 1) {
		// 		$cost = $transaction["ticket_cost"];
		// 		$diff = round($cost, 2) - round($np, 2);
		// 		if ($diff != 0) {
		// 			$transaction["diff"] = $diff;
		// 			$results[] = $transaction;
		// 		}
		// 		$np = 0;
		// 	} elseif ($transactions[$index + 1]["trans_ref"] != $transaction["trans_ref"]) {
		// 		$cost = $transaction["ticket_cost"];
		// 		$diff = round($cost, 2) - round($np, 2);
		// 		if ($diff != 0) {
		// 			$transaction["diff"] = $diff;
		// 			$results[] = $transaction;
		// 		}
		// 		$np = 0;
		// 	}
		// }
		$sql = "SELECT t.trans_ref,h.trial_balance_head as trans_head,b.bkg_agent,b.bkg_brandname,b.bkg_status,b.cnl_date,b.clr_date as issued_date,SUM(CASE WHEN trans_type = 'Dr' THEN trans_amount ELSE -trans_amount END) as amount_paid FROM transactions t LEFT JOIN transaction_heads h on t.trans_head = h.trans_head LEFT JOIN bookings b ON t.trans_ref = b.bkg_no WHERE b.bkg_status != 'Pending' AND h.type = '2' AND t.trans_head NOT IN('Customer','Drawings','Account Receivable','Adjustment Balance','Shakeel Malik','P&L Account','Noreen Shakeel','GDS & IATA Fee') AND t.trans_description != 'Tickets Purchased From Supplier' AND t.trans_description != 'Hotel Purchased From Supplier' AND t.trans_description != 'Cab Purchased From Supplier' AND t.trans_ref != '0' $sup_name GROUP BY t.trans_ref,h.trial_balance_head";
		$transactions = $this->db->query($sql)->result_array();
		foreach ($transactions as $index => $trans) {
			$bkg_no = $trans['trans_ref'];
			$q = "SELECT bkg.bkg_no,(CASE WHEN bkg.sup_name != NULL OR bkg.sup_name != '' THEN bkg.sup_name ELSE '-' END ) as flt_sup,(CASE WHEN bkg.bkg_supplier_reference != NULL OR bkg.bkg_supplier_reference != '' THEN bkg.bkg_supplier_reference ELSE '-' END ) as flt_sup_ref,(CASE WHEN htl.supplier != NULL OR htl.supplier != '' THEN htl.supplier ELSE '-' END ) as htl_sup,(CASE WHEN htl.sup_ref != NULL OR htl.sup_ref != '' THEN htl.sup_ref ELSE '-' END ) as htl_sup_ref,(CASE WHEN cab.supplier != NULL OR cab.supplier != '' THEN cab.supplier ELSE '-' END ) as cab_sup,(CASE WHEN cab.sup_ref != NULL OR cab.sup_ref != '' THEN cab.sup_ref ELSE '-' END ) as cab_sup_ref,(bkg.cost_basic+bkg.cost_tax+bkg.cost_apc+bkg.cost_safi+bkg.cost_misc) as flt_cost,IFNULL(htl.cost,0.00) as htl_cost,IFNULL(cab.cost,0.00) as cab_cost FROM bookings bkg LEFT JOIN bookings_hotel htl on bkg.bkg_no = htl.bkg_no LEFT JOIN bookings_cab cab on bkg.bkg_no = cab.bkg_no WHERE bkg.bkg_status in('Cleared','Issued','Cancelled') AND bkg.bkg_no = '$bkg_no' GROUP BY bkg.bkg_no";
			$bkg = $this->db->query($q)->row_array();
			if(($bkg['flt_sup'] == $trans['trans_head']) && ($bkg['htl_sup'] == $trans['trans_head']) && ($bkg['cab_sup'] == $trans['trans_head'])){
				$t_cost = $bkg['flt_cost'] + $bkg['htl_cost'] + $bkg['cab_cost'];
				$diff = $t_cost - $trans['amount_paid'];
				if($diff == 0){
					unset($transactions[$index]);
				}else{
					$transactions[$index]['diff'] = $diff;
					$transactions[$index]['flt_sup_ref'] = $bkg['flt_sup_ref'];
					$transactions[$index]['htl_sup_ref'] = $bkg['htl_sup_ref'];
					$transactions[$index]['cab_sup_ref'] = $bkg['cab_sup_ref'];
				}
			}else if(($bkg['flt_sup'] == $trans['trans_head']) && ($bkg['htl_sup'] == $trans['trans_head']) && ($bkg['cab_sup'] != $trans['trans_head'])){
				$t_cost = $bkg['flt_cost'] + $bkg['htl_cost'];
				$diff = $t_cost - $trans['amount_paid'];
				if($diff == 0){
					unset($transactions[$index]);
				}else{
					$transactions[$index]['diff'] = $diff;
					$transactions[$index]['flt_sup_ref'] = $bkg['flt_sup_ref'];
					$transactions[$index]['htl_sup_ref'] = $bkg['htl_sup_ref'];
					$transactions[$index]['cab_sup_ref'] = '-';
				}
			}else if(($bkg['flt_sup'] != $trans['trans_head']) && ($bkg['htl_sup'] == $trans['trans_head']) && ($bkg['cab_sup'] == $trans['trans_head'])){
				$t_cost =  $bkg['htl_cost']+ $bkg['cab_cost'];
				$diff = $t_cost - $trans['amount_paid'];
				if($diff == 0){
					unset($transactions[$index]);
				}else{
					$transactions[$index]['diff'] = $diff;
					$transactions[$index]['flt_sup_ref'] = '-';
					$transactions[$index]['htl_sup_ref'] = $bkg['htl_sup_ref'];
					$transactions[$index]['cab_sup_ref'] = $bkg['cab_sup_ref'];
				}
			}else if(($bkg['flt_sup'] == $trans['trans_head']) && ($bkg['htl_sup'] != $trans['trans_head']) && ($bkg['cab_sup'] == $trans['trans_head'])){
				$t_cost =  $bkg['flt_cost']+ $bkg['cab_cost'];
				$diff = $t_cost - $trans['amount_paid'];
				if($diff == 0){
					unset($transactions[$index]);
				}else{
					$transactions[$index]['diff'] = $diff;
					$transactions[$index]['flt_sup_ref'] = $bkg['flt_sup_ref'];
					$transactions[$index]['htl_sup_ref'] = '-';
					$transactions[$index]['cab_sup_ref'] = $bkg['cab_sup_ref'];
				}
			}else if(($bkg['flt_sup'] == $trans['trans_head']) && ($bkg['htl_sup'] != $trans['trans_head']) && ($bkg['cab_sup'] != $trans['trans_head'])){
				$t_cost = $bkg['flt_cost'];
				$diff = $t_cost - $trans['amount_paid'];
				if($diff == 0){
					unset($transactions[$index]);
				}else{
					$transactions[$index]['diff'] = $diff;
					$transactions[$index]['flt_sup_ref'] = $bkg['flt_sup_ref'];
					$transactions[$index]['htl_sup_ref'] = '-';
					$transactions[$index]['cab_sup_ref'] = '-';
				}
			}else if(($bkg['flt_sup'] != $trans['trans_head']) && ($bkg['htl_sup'] == $trans['trans_head']) && ($bkg['cab_sup'] != $trans['trans_head'])){
				$t_cost = $bkg['htl_cost'];
				$diff = $t_cost - $trans['amount_paid'];
				if($diff == 0){
					unset($transactions[$index]);
				}else{
					$transactions[$index]['diff'] = $diff;
					$transactions[$index]['flt_sup_ref'] = '-';
					$transactions[$index]['htl_sup_ref'] = $bkg['htl_sup_ref'];
					$transactions[$index]['cab_sup_ref'] = '-';
				}
			}else if(($bkg['flt_sup'] != $trans['trans_head']) && ($bkg['htl_sup'] != $trans['trans_head']) && ($bkg['cab_sup'] == $trans['trans_head'])){
				$t_cost = $bkg['cab_cost'];
				$diff = $t_cost - $trans['amount_paid'];
				if($diff == 0){
					unset($transactions[$index]);
				}else{
					$transactions[$index]['diff'] = $diff;
					$transactions[$index]['flt_sup_ref'] = '-';
					$transactions[$index]['htl_sup_ref'] = '-';
					$transactions[$index]['cab_sup_ref'] = $bkg['cab_sup_ref'];
				}
			}else if(($bkg['flt_sup'] != $trans['trans_head']) && ($bkg['htl_sup'] != $trans['trans_head']) && ($bkg['cab_sup'] != $trans['trans_head'])){
				$t_cost = 0;
				$diff = $t_cost - $trans['amount_paid'];
				if($diff == 0){
					unset($transactions[$index]);
				}else{
					$transactions[$index]['diff'] = $diff;
					$transactions[$index]['flt_sup_ref'] = '-';
					$transactions[$index]['htl_sup_ref'] = '-';
					$transactions[$index]['cab_sup_ref'] = '-';
				}
			}
		}
		return $transactions;
	}
	public function report_cust_direct_payment_supplier($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$agent = $data['agent'];
		$brand = $data['brand'];
		$supplier = $data['supplier'];
		$brandname = $bkg_agent = $sup_name = '';
		if ($brand == 'All') {
			$brandname = '';
		} else {
			$brandname = " AND bkg.bkg_brandname = '$brand' ";
		}

		if ($agent == 'All') {
			$bkg_agent = '';
		} else {
			$bkg_agent = " AND bkg.bkg_agent = '$agent'";
		}

		if ($supplier == 'All') {
			$sup_name = '';
		} else {
			$sup_name = "AND th.`owner` = '$supplier'";
		}
		$query = "SELECT bkg.bkg_date,bkg.flt_departuredate,bkg.sup_name as sup_name,bkg.bkg_no,bkg.bkg_supplier_reference as bkg_supplier_reference,htl.supplier as sup_name,htl.sup_ref as bkg_supplier_reference,cab.supplier as sup_name,cab.sup_ref as bkg_supplier_reference,bkg.cst_name,bkg.bkg_brandname,bkg.bkg_agent,sum( CASE WHEN trans_type = 'Dr' THEN trans_amount ELSE - trans_amount END) AS total_received FROM bookings bkg left join bookings_hotel htl on bkg.bkg_no = htl.bkg_no left join bookings_cab cab on bkg.bkg_no = cab.bkg_no left join transactions t on bkg.bkg_no = t.trans_ref left join transaction_heads th on t.trans_head = th.trans_head where bkg.bkg_status IN('Pending') $brandname $bkg_agent AND th.type = '2' and bkg.bkg_date between '$sdate' and '$edate' AND t.trans_head <> 'Customer' $sup_name GROUP BY bkg.bkg_no,bkg.sup_name,htl.supplier,cab.supplier ";
		return $this->db->query($query)->result_array();
	}
	public function report_card_charge_report($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$agent = $data['agent'];
		$brand = $data['brand'];
		$card = $data['card'];
		$supplier = $data['supplier'];
		$brandname = $bkg_agent = $cardchargename = $sup_name = $bkg_sup = '';
		if ($brand == 'All') {
			$brandname = '';
		} else {
			$brandname = " AND bkg_brandname = '$brand' ";
		}
		if ($agent == 'All') {
			$bkg_agent = '';
		} else {
			$bkg_agent = " AND bkg_agent = '$agent'";
		}
		if ($card == 'All') {
			$cardchargename = '';
		} else {
			$cardchargename = " AND th.trans_head = '$card' ";
		}
		if ($supplier == '') {
			$sup_name = " AND th.`owner` = $this->mainbrand ";
		} else if ($supplier == 'All') {
			$sup_name = "";
		} else {
			$bkg_sup = " AND sup_name = '$supplier'";
			$sup_name = "AND th.`owner` = '$supplier'";
		}
		$bkgref = "";
		$querybkgno = "SELECT t.trans_ref FROM transactions t, transaction_heads th WHERE t.trans_head = th.trans_head $sup_name $cardchargename AND t.trans_type= 'Dr' AND t.trans_by_to = 'Customer' AND th.trans_head_mode= 'card' AND t.trans_date BETWEEN '$sdate' AND '$edate';";
		$resultbkgno = $this->db->query($querybkgno)->result_array();
		foreach ($resultbkgno as $key => $rowbkgno) {
			$bkgref = $bkgref . $rowbkgno['trans_ref'] . ", ";
		}
		$querybkgno = "SELECT t.trans_ref FROM transactions t, transaction_heads th WHERE t.trans_by_to = th.trans_head $sup_name $cardchargename AND t.trans_type= 'Dr' AND t.trans_head = 'Customer' AND th.trans_head_mode= 'card' AND t.trans_date BETWEEN '$sdate' AND '$edate';";
		$resultbkgno = $this->db->query($querybkgno)->result_array();
		foreach ($resultbkgno as $key => $rowbkgno) {
			$bkgref = $bkgref . $rowbkgno['trans_ref'] . ", ";
		}
		$bkgref = substr($bkgref, 0, -2);
		$query = "SELECT bkg_no,cst_name,bkg_status FROM `bookings` Where `bkg_no` IN(" . $bkgref . ") $brandname $bkg_agent $bkg_sup ORDER BY `bkg_date`";
		$result = $this->db->query($query)->result_array();
		$card_charged = array();
		foreach ($result as $keymain => $row) {
			$amnt_recvd = 0;
			$amnt_paid = 0;
			$trancnt = 0;
			$authcode = '';
			$query_rec = "SELECT SUM(t.trans_amount) as amtrec, t.trans_date as tdate, t.t_card as authcode FROM transactions t, transaction_heads th WHERE t.trans_head = th.trans_head AND t.trans_type= 'Dr' AND th.trans_head_mode= 'card' AND t.trans_ref = " . $row['bkg_no'] . " $sup_name $cardchargename AND t.trans_by_to = 'Customer' AND t.trans_date BETWEEN '$sdate' AND '$edate' ;";
			$rowrec = $this->db->query($query_rec)->row_array();
			if (count($rowrec) > 0) {
				if ($rowrec['amtrec'] != '') {
					$amnt_recvd = $rowrec['amtrec'];
				}
				if ($trancnt == 0) {
					$trandate = $rowrec['tdate'];
					$trancnt = 1;
				}
				$authcode = $rowrec['authcode'];
			}
			$query_paid = "SELECT SUM(t.trans_amount) as amtpaid, t.trans_date as tdate, t.t_card as authcode FROM transactions t, transaction_heads th WHERE t.trans_by_to = th.trans_head AND t.trans_type= 'Dr' AND th.trans_head_mode= 'card' AND t.trans_ref = " . $row['bkg_no'] . " AND t.trans_head = 'Customer' $sup_name $cardchargename  AND t.trans_date BETWEEN '$sdate' AND '$edate' ;";
			$rowpaid = $this->db->query($query_paid)->row_array();
			if (count($rowpaid) > 0) {
				if ($rowpaid['amtpaid'] != '') {
					$amnt_paid = $rowpaid['amtpaid'];
				}
				if ($trandate == "") {
					$trandate = $rowpaid['tdate'];
				}
			}
			$card_charged[$keymain]['trans_date'] = $trandate;
			$card_charged[$keymain]['authcode'] = $authcode;
			$card_charged[$keymain]['amnt_recvd'] = $amnt_recvd;
			$card_charged[$keymain]['amnt_paid'] = $amnt_paid;
			$card_charged[$keymain]['bkg_no'] = $row['bkg_no'];
			$card_charged[$keymain]['cst_name'] = $row['cst_name'];
			$card_charged[$keymain]['bkg_status'] = $row['bkg_status'];
		}
		return $card_charged;
	}
	public function report_activity_summary($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$activity_summary = array();
		$activity_summary["finances"][0]['head'] = 'Bank';
		$query = "SELECT sum( CASE WHEN trans_type = 'Dr' THEN trans_amount END) AS bankin, sum( CASE WHEN trans_type = 'Cr' THEN trans_amount END) AS bankout FROM `transactions` t, `transaction_heads` th  WHERE t.`trans_head` = th.`trans_head` AND th.`type` = 1 AND th.`trans_head_mode` = 'bank' AND `trans_date` BETWEEN '$sdate' AND '$edate';";
		$row = $this->db->query($query)->row_array();
		if ($row['bankin'] > 0) {
			$activity_summary["finances"][0]['amt_in'] = $row['bankin'];
		} else {
			$activity_summary["finances"][0]['amt_in'] = 0;
		}
		if ($row['bankout'] > 0) {
			$activity_summary["finances"][0]['amt_out'] = $row['bankout'];
		} else {
			$activity_summary["finances"][0]['amt_out'] = 0;
		}

		$activity_summary["finances"][1]['head'] = 'Cash';
		$query = "SELECT sum( CASE WHEN trans_type = 'Dr' THEN trans_amount END) AS cashin, sum( CASE WHEN trans_type = 'Cr' THEN trans_amount END) AS cashout FROM `transactions` t, `transaction_heads` th  WHERE t.`trans_head` = th.`trans_head` AND th.`type` = 1 AND th.`trans_head_mode` = 'cash' AND `trans_date` BETWEEN '$sdate' AND '$edate';";
		$row = $this->db->query($query)->row_array();
		if ($row['cashin'] > 0) {
			$activity_summary["finances"][1]['amt_in'] = $row['cashin'];
		} else {
			$activity_summary["finances"][1]['amt_in'] = 0;
		}
		if ($row['cashout'] > 0) {
			$activity_summary["finances"][1]['amt_out'] = $row['cashout'];
		} else {
			$activity_summary["finances"][1]['amt_out'] = 0;
		}

		$activity_summary["finances"][2]['head'] = 'Card';
		$query = "SELECT sum( CASE WHEN trans_type = 'Dr' THEN trans_amount END) AS cardin, sum( CASE WHEN trans_type = 'Cr' THEN trans_amount END) AS cardout FROM `transactions` t, `transaction_heads` th  WHERE t.`trans_head` = th.`trans_head` AND th.`trans_head_mode` = 'card' AND t.`trans_by_to` = 'Customer'  AND `trans_date` BETWEEN '$sdate' AND '$edate';";
		$row = $this->db->query($query)->row_array();
		if ($row['cardin'] > 0) {
			$activity_summary["finances"][2]['amt_in'] = $row['cardin'];
		} else {
			$activity_summary["finances"][2]['amt_in'] = 0;
		}
		if ($row['cardout'] > 0) {
			$activity_summary["finances"][2]['amt_out'] = $row['cardout'];
		} else {
			$activity_summary["finances"][2]['amt_out'] = 0;
		}

		$activity_summary["finances"][3]['head'] = 'Others';
		$query = "SELECT sum( CASE WHEN trans_type = 'Dr' THEN trans_amount END) AS otherin, sum( CASE WHEN trans_type = 'Cr' THEN trans_amount END) AS otherout FROM `transactions` t, `transaction_heads` th  WHERE t.`trans_head` = th.`trans_head` AND th.`trans_head_mode` = 'others' AND t.`trans_by_to` = 'Customer'  AND `trans_date` BETWEEN '$sdate' AND '$edate';";
		$row = $this->db->query($query)->row_array();
		if ($row['otherin'] > 0) {
			$activity_summary["finances"][3]['amt_in'] = $row['otherin'];
		} else {
			$activity_summary["finances"][3]['amt_in'] = 0;
		}
		if ($row['otherout'] > 0) {
			$activity_summary["finances"][3]['amt_out'] = $row['otherout'];
		} else {
			$activity_summary["finances"][3]['amt_out'] = 0;
		}

		$activity_summary['brands_activity'] = array();
		$nettotalbookings = 0;
		$nettotalissuedbookings = 0;
		$nettotalcancelledbookings = 0;
		$netprofit = 0;
		$cancellationprofit = 0;
		$querybrands = "SELECT DISTINCT `bkg_brandname` FROM `bookings` ORDER BY `bkg_brandname`";
		$resultbrands = $this->db->query($querybrands)->result_array();
		if (count($resultbrands) > 0) {
			foreach ($resultbrands as $keymain => $rowbrands) {
				$brand = $rowbrands['bkg_brandname'];
				$activity_summary['brands_activity'][$keymain]['brand_name'] = $brand;
				$query_bkgs = "SELECT COUNT(`bkg_no`) AS total_bkg FROM `bookings` WHERE `bkg_date` BETWEEN '$sdate' AND '$edate' AND `bkg_brandname` = '$brand'";
				$total_bkgs = $this->db->query($query_bkgs)->row_array();
				$total_bkg = $total_bkgs['total_bkg'];
				$query_bkgs = "SELECT COUNT(`bkg_no`) AS total_issued_bkg FROM `bookings` WHERE `clr_date` BETWEEN '$sdate' AND '$edate' AND `bkg_brandname` = '$brand'";
				$total_issued_bkgs = $this->db->query($query_bkgs)->row_array();
				$total_issued_bkg = $total_issued_bkgs['total_issued_bkg'];
				$query_bkgs = "SELECT COUNT(`bkg_no`) AS total_cancel_bkg FROM `bookings` WHERE `cnl_date` BETWEEN '$sdate' AND '$edate' AND `bkg_brandname` = '$brand'";
				$total_cancel_bkgs = $this->db->query($query_bkgs)->row_array();
				$total_cancel_bkg = $total_cancel_bkgs['total_cancel_bkg'];
				$activity_summary['brands_activity'][$keymain]['total_bkg'] = $total_bkg;
				$activity_summary['brands_activity'][$keymain]['total_issued_bkg'] = $total_issued_bkg;
				$activity_summary['brands_activity'][$keymain]['total_cancel_bkg'] = $total_cancel_bkg;
				$activity_summary['brands_activity'][$keymain]['total_issued_profit'] = 0;
				$activity_summary['brands_activity'][$keymain]['total_cancelled_profit'] = 0;
				if ($total_bkg != 0 || $total_issued_bkg != 0 || $total_cancel_bkg != 0) {
					$total_profit_issuance = 0;
					$status = array('Issued', 'Cleared');
					$this->db->select('bkg.bkg_no,(IFNULL(c.cost,0)+IFNULL(h.cost,0)+bkg.cost_basic+bkg.cost_tax+bkg.cost_apc+bkg.cost_safi+bkg.cost_misc) as bkg_cost, (bkg.cost_postage+bkg.cost_cardverfication+bkg.cost_cardcharges+bkg.cost_bank_charges_internal) as admin_exp, (select SUM(`p`.`p_basic` + `p`.`p_tax` + `p`.`p_bookingfee` + `p`.`p_cardcharges` + `p`.`p_others`+ `p`.`p_hotel`+ `p`.`p_cab`) from passengers p where p.bkg_no = bkg.bkg_no) as saleprice');
					$this->db->from('bookings bkg');
					$this->db->join('bookings_hotel h', 'h.bkg_no = bkg.bkg_no', 'left');
					$this->db->join('bookings_cab c', 'c.bkg_no = bkg.bkg_no', 'left');
					$this->db->where('bkg.clr_date >=', $sdate);
					$this->db->where('bkg.clr_date <=', $edate);
					$this->db->where_in('bkg.bkg_status', $status);
					$this->db->where('bkg.bkg_brandname', $brand);
					$this->db->group_by('bkg.bkg_no');
					$this->db->order_by('bkg.clr_date');
					$result_issues = $this->db->get()->result_array();
					if (count($result_issues) > 0) {
						foreach ($result_issues as $key => $issuance) {
							$profit = 0;
							$profit = round($issuance['saleprice'], 2) - (round($issuance['bkg_cost'], 2) + round($issuance['admin_exp'], 2));
							$total_profit_issuance += $profit;
						}
					}
					$activity_summary['brands_activity'][$keymain]['total_issued_profit'] = $total_profit_issuance;
					$net_cancellation_profit = 0;
					$this->db->select('b.bkg_no,(IFNULL(h.cost,0)+IFNULL(c.cost,0)+b.cost_basic+b.cost_tax+b.cost_apc+b.cost_safi+b.cost_misc) as bkg_cost, (cost_postage+b.cost_cardverfication+b.cost_cardcharges+b.cost_bank_charges_internal) as admin_exp');
					$this->db->from('bookings b');
					$this->db->join('bookings_hotel h', 'h.bkg_no = b.bkg_no', 'left');
					$this->db->join('bookings_cab c', 'c.bkg_no = b.bkg_no', 'left');
					$this->db->where('cnl_date >=', $sdate);
					$this->db->where('cnl_date <=', $edate);
					$this->db->where('bkg_status', 'Cancelled');
					$this->db->where('bkg_brandname', $brand);
					$this->db->group_by('bkg_no');
					$this->db->order_by('cnl_date', 'ASC');
					$result_cancellations = $this->db->get()->result_array();
					if (count($result_cancellations) > 0) {
						foreach ($result_cancellations as $key => $cancel) {
							$bkgid = $cancel['bkg_no'];
							$paid_received = Getrcepaid($bkgid);
							$net_cancellation_profit += round(($paid_received['amt_received'] - ($paid_received['amt_refund'] + $cancel['bkg_cost'] + $cancel['admin_exp'])), 2);
						}
					}
					$activity_summary['brands_activity'][$keymain]['total_cancelled_profit'] = $net_cancellation_profit;
				}
			}
		}
		$activity_summary['tickets'] = array();
		$netpassengers = 0;
		$netsaleprice = 0;
		$querysup = "SELECT DISTINCT `sup_name` FROM `bookings` ORDER BY `sup_name`";
		$resultsup = $this->db->query($querysup)->result_array();
		if (count($resultsup) > 0) {
			foreach ($resultsup as $keymain => $rowsup) {
				$supplier = $rowsup['sup_name'];
				$total_saleprice = 0;
				$total_passengers = 0;
				//calculating the total sale price and no. of pax	
				$querybkg = "SELECT * FROM `bookings` Where `bkg_status` IN('Issued','Cleared') AND `clr_date` BETWEEN '$sdate' AND '$edate' AND `sup_name` = '$supplier'";
				$resultbkg = $this->db->query($querybkg)->result_array();
				if (count($resultbkg) > 0) {
					foreach ($resultbkg as $key => $rowbkg) {
						$query_saleprice = "SELECT (`p_basic` + `p_tax` + `p_bookingfee` + `p_cardcharges` + `p_others`) as saleprice FROM `passengers` WHERE `bkg_no` = '" . $rowbkg['bkg_no'] . "'";
						$result_saleprice = $this->db->query($query_saleprice)->result_array();
						foreach ($result_saleprice as $key => $row_saleprice) {
							$total_saleprice = (float)$total_saleprice + (float)$row_saleprice['saleprice'];
							$total_passengers++;
						}
					}
				}
				///////////////////////////////////////////////////	
				if ((int)$total_passengers != 0 || (int)$total_saleprice != 0) {
					$activity_summary['tickets'][$keymain]['supplier'] = $supplier;
					$activity_summary['tickets'][$keymain]['total_saleprice'] = $total_saleprice;
					$activity_summary['tickets'][$keymain]['total_passengers'] = $total_passengers;
				}
			}
		}
		return $activity_summary;
	}
	public function report_gds_report($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$brand = $data['brand'];
		$gds = $data['gds'];
		if ($brand == 'All') {
			$brandname = '';
		} else {
			$brandname = " AND `bkg_brandname` = '$brand' ";
			$brandnameexp = "AND th.`owner` = '$brand'";
		}
		if ($gds == 'All') {
			$flt_gds = '';
		} else {
			$flt_gds = " AND `flt_gds` = '$gds' ";
		}
		$query = "SELECT `bkg_brandname`,`bkg_no`,`clr_date`,`cst_name`,`flt_gds`,`flt_destinationairport`,`flt_airline`,`flt_pnr`,`flt_legs`,(`cost_basic`+`cost_tax`+`cost_apc`+`cost_safi`+`cost_misc`) as bkg_cost FROM `bookings` Where `bkg_status` IN('Issued','Cleared') AND `clr_date` BETWEEN '$sdate' AND '$edate' $brandname $flt_gds ORDER BY `clr_date`";
		$result = $this->db->query($query)->result_array();
		if (count($result) > 0) {
			$totalsegemnts = 0;
			$totallegs = 0;
			$gds = array();
			foreach ($result as $keymain => $row) {
				//calculating the total sale price and no. of pax	  
				$query_psgr = "SELECT p_eticket_no FROM `passengers` WHERE `bkg_no` = '" . $row['bkg_no'] . "' ;";
				$result_psgr = $this->db->query($query_psgr)->result_array();
				$total_passengers = 0;
				$eticketnos = "";
				foreach ($result_psgr as $key => $row_psgr) {
					if ($total_passengers == 0) {
						$eticketnos = $row_psgr["p_eticket_no"];
					} else {
						$eticketnos = $eticketnos . ", " . $row_psgr["p_eticket_no"];
					}
					$total_passengers++;
				}
				$gds[$keymain]['date'] = $row['clr_date'];
				$gds[$keymain]['brand'] = $row['bkg_brandname'];
				$gds[$keymain]['bkg_no'] = $row['bkg_no'];
				$gds[$keymain]['cust_name'] = $row['cst_name'];
				$gds[$keymain]['gds'] = $row['flt_gds'];
				$gds[$keymain]['dest'] = $row['flt_destinationairport'];
				$gds[$keymain]['airline'] = $row['flt_airline'];
				$gds[$keymain]['pnr'] = $row['flt_pnr'];
				$gds[$keymain]['legs'] = $row['flt_legs'];
				$gds[$keymain]['cost'] = $row['bkg_cost'];
				$gds[$keymain]['pax'] = $total_passengers;
				$gds[$keymain]['tkt_no'] = $eticketnos;
			}
		}
		return $gds;
	}
	public function report_s_p_report($data = '')
	{
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$agent = $data['agent'];
		$brand = $data['brand'];
		$supplier = $data['supplier'];
		$status = array('Issued', 'Cleared');
		$this->db->select('bkg.clr_date,bkg.bkg_agent,bkg.bkg_no,bkg.bkg_supplier_reference,bkg.cst_name,(IFNULL(h.cost,0)+IFNULL(c.cost,0)+bkg.cost_basic+bkg.cost_tax+bkg.cost_apc+bkg.cost_safi+bkg.cost_misc) as bkg_cost, (bkg.cost_postage+bkg.cost_cardverfication+bkg.cost_cardcharges+bkg.cost_bank_charges_internal) as admin_exp, (select SUM(`p`.`p_basic` + `p`.`p_tax` + `p`.`p_bookingfee` + `p`.`p_cardcharges` + `p`.`p_others`+ `p`.`p_hotel`+ `p`.`p_cab`) from passengers p where p.bkg_no = bkg.bkg_no) as saleprice');
		$this->db->from('bookings bkg');
		$this->db->join('bookings_hotel h', 'h.bkg_no = bkg.bkg_no', 'left');
		$this->db->join('bookings_cab c', 'c.bkg_no = bkg.bkg_no', 'left');
		$this->db->where('bkg.clr_date >=', $sdate);
		$this->db->where('bkg.clr_date <=', $edate);
		$this->db->where_in('bkg.bkg_status', $status);
		if ($brand != 'All' && $brand != '') {
			$this->db->where('bkg.bkg_brandname', $brand);
		}
		if ($agent != 'All' && $agent != '') {
			$this->db->where('bkg.bkg_agent', $agent);
		}
		if ($supplier != 'All' && $supplier != '') {
			$this->db->where('bkg.sup_name', $supplier);
		}
		$this->db->group_by('bkg.bkg_no');
		$this->db->order_by('bkg.clr_date');
		$result = $this->db->get();
		$data['issued_booking'] = $result->result_array();
		return $data;
	}
}
/* End of file Reports_model.php */
/* Location: ./application/models/Reports_model.php */
