<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking_model extends CI_Model
{
	public function Getagents($agent = '', $brand = '')
	{
		$this->db->select('user_name');
		$this->db->from('users');
		$this->db->where('user_name !=', 'IT Manager');
		if ($agent != '') {
			$this->db->where('user_name', $agent);
		}
		if ($brand != '') {
			$this->db->where('user_brand', $brand);
		}
		$this->db->order_by('user_id', 'asc');
		$result = $this->db->get()->result_array();
		return $result;
	}
	public function Getbrands($brand = '')
	{
		$this->db->select('brand_name');
		$this->db->from('brand');
		if ($brand != '') {
			$this->db->where('brand_name', $brand);
		}
		$this->db->where('brand_status', 'active');
		$this->db->order_by('brand_id', 'asc');
		$result = $this->db->get()->result_array();
		return $result;
	}
	public function GetBookingbrand($brandName = '')
	{
		$this->db->select('*');
		$this->db->from('brand');
		if ($brandName != '') {
			$this->db->where('brand_name', $brandName);
		}
		$this->db->order_by('brand_id', 'asc');
		$result = $this->db->get()->row_array();
		return $result;
	}
	public function Getsuppliers()
	{
		$this->db->select('supplier_name');
		$this->db->from('suppliers');
		$this->db->where('supplier_status', 'active');
		$this->db->order_by('supplier_id', 'asc');
		$result = $this->db->get()->result_array();
		return $result;
	}
	public function GetTransHead($value = '')
	{
		$this->db->select('trans_head,trans_head_mode');
		$this->db->from('transaction_heads');
		$this->db->where('trans_head_status', 1);
		$this->db->order_by('trans_head', 'asc');
		$result = $this->db->get()->result_array();
		return $result;
	}
	public function GetAirports($airport = '')
	{
		if (strlen($airport) == 3) {
			$this->db->select('airport_code,airport_name');
			$this->db->from('airports');
			$this->db->where('airport_code', $airport);
			$result = $this->db->get();
			if ($result->num_rows() == 0) {
				$this->db->select('airport_code,airport_name');
				$this->db->from('airports');
				$this->db->like('airport_code', $airport);
				$this->db->or_like('airport_name', $airport);
				$result = $this->db->get();
			}
		} else {
			$this->db->select('airport_code,airport_name');
			$this->db->from('airports');
			$this->db->like('airport_code', $airport);
			$this->db->or_like('airport_name', $airport);
			$result = $this->db->get();
		}
		$result = $result->result_array();
		return $result;
	}
	public function GetAirline($airline = '')
	{
		if (strlen($airline) == 2) {
			$this->db->select('airline_code,airline_name');
			$this->db->from('airlines');
			$this->db->where('airline_code', $airline);
			$result = $this->db->get();
			if ($result->num_rows() == 0) {
				$this->db->select('airline_code,airline_name');
				$this->db->from('airlines');
				$this->db->like('airline_code', $airline);
				$this->db->or_like('airline_name', $airline);
				$result = $this->db->get();
			}
		} else {
			$this->db->select('airline_code,airline_name');
			$this->db->from('airlines');
			$this->db->like('airline_code', $airline);
			$this->db->or_like('airline_name', $airline);
			$result = $this->db->get();
		}
		$result = $result->result_array();
		return $result;
	}
	public function new_booking($formData)
	{
		$payment_modes = array("Credit Card", "Debit Card", "American Express");
		$this->db->set('bkg_status', 'Pending');
		$this->db->set('bkg_date', date('Y-m-d', strtotime($formData['booking_date'])));
		$this->db->set('bkg_agent', $formData['booking_agent']);
		$this->db->set('bkg_brandname', $formData['booking_brand']);
		$this->db->set('cst_name', $formData['cust_full_name']);
		$this->db->set('cst_email', $formData['cust_email']);
		$this->db->set('cst_address', $formData['cust_post_addess']);
		$this->db->set('cst_city', $formData['cust_post_city']);
		$this->db->set('cst_postcode', $formData['cust_post_code']);
		$this->db->set('cst_mobile', $formData['cust_mobile']);
		$this->db->set('cst_phone', $formData['cust_phone']);
		$this->db->set('cst_source', $formData['booking_source']);
		$this->db->set('pmt_payingby', $formData['payment_paid_by']);
		$this->db->set('pmt_mode', $formData['payment_receipt_mode']);
		$this->db->set('recpt_due_date', date('Y-m-d', strtotime($formData['payment_due_date'])));
		if (in_array($formData['payment_receipt_mode'], $payment_modes)) {
			$formData['card_exp_date'] = $formData['card_exp_month'] . " - " . $formData['card_exp_year'];
			$this->db->set('tpp_cardholdername', $formData['card_holder_name']);
			$this->db->set('tpp_cardno', hashing($formData['card_number']));
			$this->db->set('tpp_cardexpirydate', $formData['card_exp_date']);
			$this->db->set('tpp_securitycode', $formData['card_cvc']);
		}
		$this->db->set('flt_bookingnote', $formData['booking_note']);
		$this->db->set('cost_basic', $formData['fare_basic']);
		$this->db->set('cost_tax', $formData['fare_tax']);
		$this->db->set('cost_apc', $formData['fare_apc']);
		$this->db->set('cost_safi', $formData['fare_safi']);
		$this->db->set('cost_bank_charges_internal', $formData['charges_bank']);
		$this->db->set('cost_cardcharges', $formData['charges_card']);
		$this->db->set('cost_postage', $formData['apc_payable']);
		$this->db->set('cost_cardverfication', $formData['charges_misc']);
		if (isset($formData['flightcheck']) && $formData['flightcheck']) {
			$this->db->set('flight', '1');
		} else {
			$this->db->set('flight', '0');
		}
		if (isset($formData['hotelcheck']) && $formData['hotelcheck']) {
			$this->db->set('hotel', '1');
		} else {
			$this->db->set('hotel', '0');
		}
		if (isset($formData['cabcheck']) && $formData['cabcheck']) {
			$this->db->set('cab', '1');
		} else {
			$this->db->set('cab', '0');
		}
		$this->db->insert('bookings');
		$bkg_id = $this->db->insert_id();
		addlog($bkg_id, 'New Booking Created by ' . $formData['booking_agent']);
		if (@$formData['pax']) {
			$total_apc = 0;
			$totalPax = count($formData['pax']['pax_title']);
			for ($i = 0; $i < $totalPax; $i++) {
				$this->db->set('bkg_no', $bkg_id);
				$this->db->set('p_title', $formData['pax']['pax_title'][$i]);
				$this->db->set('p_firstname', $formData['pax']['pax_first_name'][$i]);
				$this->db->set('p_middlename', $formData['pax']['pax_mid_name'][$i]);
				$this->db->set('p_lastname', $formData['pax']['pax_sur_name'][$i]);
				$this->db->set('p_age', $formData['pax']['pax_age'][$i]);
				$this->db->set('p_catagory', $formData['pax']['pax_type'][$i]);
				$this->db->set('p_basic', $formData['pax']['pax_sale'][$i]);
				$this->db->set('p_bookingfee', $formData['pax']['pax_fee'][$i]);
				$this->db->set('p_tax', '0');
				$this->db->set('p_cardcharges', '0');
				$this->db->set('p_others', '0');
				$this->db->set('p_hotel', $formData['pax']['pax_hotel'][$i]);
				$this->db->set('p_cab', $formData['pax']['pax_cab'][$i]);
				$this->db->set('p_eticket_no', $formData['pax']['pax_eticket_no'][$i]);
				$this->db->insert('passengers');
				if ($formData['pax']['pax_type'][$i] != 'Infant') {
					$total_apc += 2.5;
				}
			}
			// $this->db->set('cost_postage', $total_apc)->where('bkg_no', $bkg_id)->update('bookings');
		}
		return $bkg_id;
	}
	public function add_flight($formData, $bkgid)
	{

		$tktdetails = $formData['tkt_details'];
		$this->db->set('sup_name', $formData['booking_supplier']);
		$this->db->set('bkg_sup_agent', $formData['supplier_agent']);
		$this->db->set('bkg_supplier_reference', $formData['supplier_reference']);
		$this->db->set('flt_departureairport', $formData['departure_airport']);
		$this->db->set('flt_destinationairport', $formData['destination_airport']);
		$this->db->set('flt_via', $formData['via_airport']);
		$this->db->set('flt_flighttype', $formData['flight_type']);
		$this->db->set('flt_departuredate', date('Y-m-d', strtotime($formData['departure_date'])));
		$this->db->set('flt_returningdate', date('Y-m-d', strtotime(@$formData['return_date'])));
		$this->db->set('flt_class', $formData['flight_class']);
		$this->db->set('flt_airline', $formData['airline']);
		$this->db->set('flt_legs', $formData['flight_segments']);
		$this->db->set('flt_pnr', $formData['pnr']);
		$this->db->set('flt_gds', $formData['flight_gds']);
		$this->db->set('flt_pnr_expiry', date('Y-m-d H:i:s', strtotime($formData['pnr_expire_date'])));
		$this->db->set('flt_fare_expiry', date('Y-m-d H:i:s', strtotime($formData['fare_expire_date'])));
		$this->db->set('flt_ticketdetail', "$tktdetails");
		$this->db->where('bkg_no', $bkgid);
		$this->db->update('bookings');
		if (isset($formData['leg'])) {
			$totalrows = count($formData['leg']['flight_no']);
			for ($i = 0; $i < $totalrows; $i++) {
				$this->db->set('leg_bkg_id', $bkgid);
				$this->db->set('leg_flight_no', $formData['leg']['flight_no'][$i]);
				$this->db->set('leg_dept_fr', $formData['leg']['departure_from'][$i]);
				$this->db->set('leg_dept_dt', date('Y-m-d H:i:s', strtotime($formData['leg']['departure_datetime'][$i])));
				$this->db->set('leg_arv_at', $formData['leg']['arrive_at'][$i]);
				$this->db->set('leg_arv_dt', date('Y-m-d H:i:s', strtotime($formData['leg']['arrival_datetime'][$i])));
				$this->db->set('leg_air', $formData['leg']['airline'][$i]);
				$this->db->insert('bkg_flight_legs');
			}
		}
	}
	public function add_hotel($formData, $bkgid)
	{
		$formData['bkg_no'] = $bkgid;
		$this->db->insert('bookings_hotel', $formData);
	}
	public function add_cab($formData, $bkgid)
	{
		$formData['bkg_no'] = $bkgid;
		$this->db->insert('bookings_cab', $formData);
	}
	public function add_visa($formData, $bkgid)
	{
		$formData['bkg_no'] = $bkgid;
		$this->db->insert('booking_visa', $formData);
	}
	public function GetPendingBookings($agents = '', $brands = '')
	{
		$this->db->select('bk.bkg_date, bk.flt_pnr_expiry,bk.flt_fare_expiry,bk.flt_departuredate, bk.bkg_no, bk.bkg_supplier_reference, bk.cst_name, bk.bkg_brandname, bk.bkg_agent,br.brand_pre_post_fix');
		$this->db->from('bookings bk');
		$this->db->join('brand br', 'br.brand_name = bk.bkg_brandname', 'left');
		if ($agents != '') {
			$this->db->where('bk.bkg_agent', $agents);
		}
		if ($brands != '') {
			$this->db->where('bk.bkg_brandname', $brands);
		}
		$this->db->where('bk.bkg_status', 'Pending');
		$this->db->order_by('bk.bkg_date', 'asc');
		return $this->db->get()->result_array();
	}
	public function GetCancelledPendingBookings($agents = '', $brands = '')
	{
		$this->db->select('bk.bkg_date, bk.flt_pnr_expiry,bk.flt_fare_expiry,bk.flt_departuredate, bk.bkg_no, bk.bkg_supplier_reference, bk.cst_name, bk.bkg_brandname, bk.bkg_agent,br.brand_pre_post_fix');
		$this->db->from('bookings bk');
		$this->db->join('brand br', 'br.brand_name = bk.bkg_brandname', 'left');
		$this->db->where('bk.bkg_status', 'Cancelled Pending');
		if ($agents != '') {
			$this->db->where('bk.bkg_agent', $agents);
		}
		if ($brands != '') {
			$this->db->where('bk.bkg_brandname', $brands);
		}
		$this->db->where('bk.bkg_status', 'Cancelled Pending');
		$this->db->order_by('bk.bkg_date', 'asc');
		return $this->db->get()->result_array();
	}
	public function GetIssuedBookings($agents = '', $brands = '')
	{
		$this->db->select('bk.bkg_date, bk.flt_pnr_expiry,bk.flt_fare_expiry,bk.flt_departuredate, bk.bkg_no, bk.bkg_supplier_reference, bk.cst_name, bk.bkg_brandname, bk.bkg_agent,br.brand_pre_post_fix');
		$this->db->from('bookings bk');
		$this->db->join('brand br', 'br.brand_name = bk.bkg_brandname', 'left');
		$this->db->where('bk.bkg_status', 'Issued');
		if ($agents != '') {
			$this->db->where('bk.bkg_agent', $agents);
		}
		if ($brands != '') {
			$this->db->where('bk.bkg_brandname', $brands);
		}
		$this->db->order_by('bk.bkg_date', 'asc');
		return $this->db->get()->result_array();
	}
	public function GetCancelledBookings($agents = '', $brands = '')
	{
		$this->db->select('bk.bkg_date, bk.flt_pnr_expiry,bk.flt_fare_expiry,bk.flt_departuredate, bk.bkg_no, bk.bkg_supplier_reference, bk.cst_name, bk.bkg_brandname, bk.bkg_agent,br.brand_pre_post_fix');
		$this->db->from('bookings bk');
		$this->db->join('brand br', 'br.brand_name = bk.bkg_brandname', 'left');
		$this->db->where('bk.bkg_status', 'Cancelled');
		if ($agents != '') {
			$this->db->where('bk.bkg_agent', $agents);
		}
		if ($brands != '') {
			$this->db->where('bk.bkg_brandname', $brands);
		}
		$this->db->order_by('bk.bkg_date', 'asc');
		return $this->db->get()->result_array();
	}
	public function GetAmountRcv($bkg_id = '')
	{
		$hostname = $this->db->hostname;
		$username = $this->db->username;
		$database = $this->db->database;
		$password = $this->db->password;
		$data["bank"] = 0.00;
		$data["card"] = 0.00;
		$data["cash"] = 0.00;
		$data["others"] = 0.00;
		$totalSale = 0;
		$totalSale = $this->GetpaxTotal($bkg_id);
		$con = mysqli_connect($hostname, $username, $password, $database);
		$query = "SELECT SUM(`t`.`trans_amount`) as amnt,`th`.`trans_head_mode`  FROM `transactions` `t` LEFT JOIN `transaction_heads` `th` ON `th`.`trans_head` = `t`.`trans_by_to` WHERE `t`.`trans_ref`='$bkg_id' AND `t`.`trans_head`='Customer' AND `t`.`trans_description` <> 'Tickets Supplied To Customer' AND `t`.`trans_type` = 'Cr' GROUP BY `th`.`trans_head_mode` ORDER BY `trans_date`";
		$result = mysqli_query($con, $query);
		if (mysqli_num_rows($result) > 0) {
			while ($rowpmt2 = mysqli_fetch_array($result)) {
				$amntrecvdhead = $rowpmt2['trans_head_mode'];
				$data["$amntrecvdhead"] = $rowpmt2['amnt'];
				$amntrecd = $rowpmt2['amnt'];
			}
		}
		$data["due"] = $totalSale - ($data["bank"] + $data["card"] + $data["cash"] + $data["others"]);
		return $data;
	}
	public function GetBookingDetails($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('bookings');
		$this->db->where('bkg_no', $bkg_id);
		return $this->db->get()->row_array();
	}
	public function GetBookingflight($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('bkg_flight_legs');
		$this->db->where('leg_bkg_id', $bkg_id);
		return $this->db->get()->result_array();
	}
	public function GetBookinghotel($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('bookings_hotel');
		$this->db->where('bkg_no', $bkg_id);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->row_array();
		} else {
			return false;
		}
	}
	public function GetMultipleBookinghotel($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('bookings_hotel');
		$this->db->where('bkg_no', $bkg_id);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array(); // Return an array of results
		} else {
			return false;
		}
	}
	public function GetBookingVisa($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('bookings_visa');
		$this->db->where('bkg_no', $bkg_id);
		return $this->db->get()->row_array();
	}

	public function GetBookingcab($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('bookings_cab');
		$this->db->where('bkg_no', $bkg_id);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->row_array();
		} else {
			return false;
		}
	}
	public function GetpaxTotal($bkg_id = '')
	{
		$hostname = $this->db->hostname;
		$username = $this->db->username;
		$database = $this->db->database;
		$password = $this->db->password;
		$total_sale = 0;
		$con = mysqli_connect($hostname, $username, $password, $database);
		$query = "SELECT SUM(p_basic+ p_tax+ p_bookingfee+ p_cardcharges+ p_others) as total_sale  FROM `passengers` WHERE `bkg_no` = '$bkg_id';";
		$result = mysqli_query($con, $query);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_array($result)) {
				$total_sale = $row['total_sale'];
			}
		}

		// $this->db->select('SUM(p_basic+ p_tax+ p_bookingfee+ p_cardcharges+ p_others) as total_sale');
		// $this->db->from('passengers');
		// $this->db->where('bkg_no', $bkg_id);
		// $result = $this->db->get()->row_array();	
		return $total_sale;
	}
	public function GetBookingpax($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('passengers');
		$this->db->where('bkg_no', $bkg_id);
		$this->db->order_by('p_id', 'asc');
		return $this->db->get()->result_array();
	}
	public function GetBookingTrans($bkg_id = '', $transFor = '')
	{
		if ($transFor != '' && $transFor == 'customer') {
			$this->db->select('*');
			$this->db->from('transactions');
			if ($bkg_id != '') {
				$this->db->where('trans_ref', $bkg_id);
			}
			$this->db->where('trans_head', 'Customer');
			$this->db->where('trans_description <>', 'Tickets Supplied To Customer');
			$this->db->where('trans_description <>', 'Hotel Supplied To Customer');
			$this->db->where('trans_description <>', 'Cab Supplied To Customer');
			$this->db->order_by('trans_date', 'asc');
		} elseif ($transFor != '' && $transFor == 'supplier') {
			$this->db->select('*');
			$this->db->from('transactions tr');
			$this->db->join('transaction_heads th', 'tr.trans_head = th.trans_head', 'left');
			if ($bkg_id != '') {
				$this->db->where('tr.trans_ref', $bkg_id);
			}
			$this->db->where('th.type', '2');
			$this->db->where_in('tr.trans_head NOT', array('Customer', 'Drawings', 'P&L Account'));
			$this->db->where('tr.trans_description <>', 'Tickets Purchased From Supplier');
			$this->db->where('tr.trans_description <>', 'Hotel Purchased From Supplier');
			$this->db->where('tr.trans_description <>', 'Cab Purchased From Supplier');
			$this->db->order_by('tr.trans_date', 'asc');
		}
		return $this->db->get()->result_array();
	}
	public function inlineUpdate($formData, $table)
	{
		if (status_check($formData['bkg_no'], 'Pending') || status_check($formData['bkg_no'], 'Cancelled Pending')) {
			$value_up = '';
			$field_up = '';
			foreach ($formData as $key => $value) {
				if ($key == 'bkg_no') {
					continue;
				} elseif ($key == 'bkg_date' || $key == 'flt_departuredate' || $key == 'flt_returningdate' || $key == 'checkin' || $key == 'checkout' || $key == 'from_date' || $key == 'to_date') {
					$this->db->set("$key", date('Y-m-d', strtotime("$value")));
				} elseif ($key == 'recpt_due_date' || $key == 'flt_pnr_expiry' || $key == 'flt_fare_expiry') {
					$this->db->set("$key", date('Y-m-d H:i:s', strtotime("$value")));
				} elseif ($key == 'tpp_cardno') {
					$this->db->set("$key", hashing($value));
				} else {
					if ($key == 'bkg_agent') {
						$getagent = $this->db->select('bkg_agent')->where('bkg_no', $formData['bkg_no'])->get('bookings')->row_array();
						$getagent = $getagent['bkg_agent'];
						$log_msg = 'Booking assigned from: <strong class="text-dark">' . $getagent . '</strong> To: <strong class="text-dark">' . $value . '</strong>';
						addlog($formData['bkg_no'], $log_msg);
					}
					$this->db->set("$key", $value);
				}
				if ($key != 'bkg_no') {
					$value_up = $value;
					$field_up = $key;
					if ($key == 'tpp_cardno') {
						$value_up = ccMasking($value_up);
					} elseif ($key == 'tpp_cardexpirydate') {
						$value_up = "XX - XXXX";
					} elseif ($key == 'tpp_securitycode') {
						$value_up = "XXX";
					} else {
						$value_up = $value_up;
					}
				}
			}
			$this->db->where('bkg_no', $formData['bkg_no']);
			$this->db->update($table);
			$rowEff = $this->db->affected_rows();
			if ($rowEff > 0) {
				$updated_record['value'] = $value_up;
				$updated_record['field'] = $field_up;
				$updated_record['status'] = 'true';
			} else {
				if ($table == 'bookings_hotel' || $table == 'bookings_cab') {
					$value_up = '';
					$field_up = '';
					foreach ($formData as $key => $value) {
						if ($key == 'bkg_no') {
							continue;
						} elseif ($key == 'bkg_date' || $key == 'flt_departuredate' || $key == 'flt_returningdate' || $key == 'checkin' || $key == 'checkout' || $key == 'from_date' || $key == 'to_date') {
							$this->db->set("$key", date('Y-m-d', strtotime("$value")));
						} elseif ($key == 'recpt_due_date' || $key == 'flt_pnr_expiry' || $key == 'flt_fare_expiry') {
							$this->db->set("$key", date('Y-m-d H:i:s', strtotime("$value")));
						} elseif ($key == 'tpp_cardno') {
							$this->db->set("$key", hashing($value));
						} else {
							$this->db->set("$key", $value);
						}
						if ($key != 'bkg_no') {
							$value_up = $value;
							$field_up = $key;
							if ($key == 'tpp_cardno') {
								$value_up = ccMasking($value_up);
							} elseif ($key == 'tpp_cardexpirydate') {
								$value_up = "XX - XXXX";
							} elseif ($key == 'tpp_securitycode') {
								$value_up = "XXX";
							} else {
								$value_up = $value_up;
							}
						}
					}
					$this->db->set('bkg_no', $formData['bkg_no']);
					$this->db->insert($table);
					$updated_record['value'] = $value_up;
					$updated_record['field'] = $field_up;
					$updated_record['status'] = 'true';
				} else {
					$updated_record['status'] = 'false';
				}
			}
		} else {
			$updated_record['status'] = 'false';
		}
		return $updated_record;
	}
	public function updateFlights($formData = '')
	{
		if (status_check($formData['bkg_id'], 'Pending') || status_check($formData['bkg_id'], 'Cancelled Pending')) {
			$this->db->where('leg_bkg_id', $formData['bkg_id']);
			$this->db->delete('bkg_flight_legs');
			$totalPax = count($formData['leg']['flight_no']);
			for ($i = 0; $i < $totalPax; $i++) {
				$this->db->set('leg_bkg_id', $formData['bkg_id']);
				$this->db->set('leg_flight_no', $formData['leg']['flight_no'][$i]);
				$this->db->set('leg_dept_fr', $formData['leg']['departure_from'][$i]);
				$this->db->set('leg_dept_dt', date('Y-m-d H:i:s', strtotime($formData['leg']['departure_datetime'][$i])));
				$this->db->set('leg_arv_at', $formData['leg']['arrive_at'][$i]);
				$this->db->set('leg_arv_dt', date('Y-m-d H:i:s', strtotime($formData['leg']['arrival_datetime'][$i])));
				$this->db->set('leg_air', $formData['leg']['airline'][$i]);
				$this->db->insert('bkg_flight_legs');
				$rowEff = $this->db->affected_rows();
			}
			$this->db->set('flt_legs', $totalPax);
			$this->db->where('bkg_no', $formData['bkg_id']);
			$this->db->update("bookings");
			if ($rowEff > 0) {
				return 'True';
			} else {
				return 'False';
			}
		} else {
			return 'False';
		}
	}
	public function updatePax($formData = '')
	{
		if (status_check($formData['bkg_id'], 'Pending') || status_check($formData['bkg_id'], 'Cancelled Pending')) {
			$this->db->where('bkg_no', $formData['bkg_id']);
			$this->db->delete('passengers');
			$totalPax = count(@$formData['pax']['pax_title']);
			if ($totalPax > 0) {
				$total_apc = 0;
				for ($i = 0; $i < $totalPax; $i++) {
					$this->db->set('bkg_no', $formData['bkg_id']);
					$this->db->set('p_title', $formData['pax']['pax_title'][$i]);
					$this->db->set('p_firstname', $formData['pax']['pax_first_name'][$i]);
					$this->db->set('p_middlename', $formData['pax']['pax_mid_name'][$i]);
					$this->db->set('p_lastname', $formData['pax']['pax_sur_name'][$i]);
					$this->db->set('p_age', $formData['pax']['pax_age'][$i]);
					$this->db->set('p_catagory', $formData['pax']['pax_type'][$i]);
					$this->db->set('p_basic', $formData['pax']['pax_sale'][$i]);
					$this->db->set('p_bookingfee', $formData['pax']['pax_fee'][$i]);
					$this->db->set('p_hotel', $formData['pax']['pax_hotel'][$i]);
					$this->db->set('p_cab', $formData['pax']['pax_cab'][$i]);
					$this->db->set('p_tax', '0');
					$this->db->set('p_cardcharges', '0');
					$this->db->set('p_others', '0');
					$this->db->set('p_eticket_no', $formData['pax']['pax_eticket_no'][$i]);
					$this->db->insert('passengers');
					if ($formData['pax']['pax_type'][$i] != 'Infant') {
						$total_apc += 2.5;
					}
					$rowEff = $this->db->affected_rows();
				}
				// $this->db->set('cost_postage', $total_apc)->where('bkg_no', $formData['bkg_id'])->update('bookings');
				if ($rowEff > 0) {
					return 'True';
				} else {
					return 'False';
				}
			} else {
				return 'True';
			}
		} else {
			return 'False';
		}
	}
	public function GetHeadsBymode($mode = '')
	{
		$this->db->select('*');
		$this->db->from('transaction_heads');
		$this->db->where('trans_head_mode', $mode);
		$this->db->where('trans_head_status', '1');
		return $this->db->get()->result_array();
	}
	public function addPaymentReq($pForm = '')
	{
		$this->db->set('pdate', date('Y-m-d', strtotime($pForm['req_payment_date'])));
		$this->db->set('bookingid', $pForm['bookingid']);
		$this->db->set('agentname', $pForm['agentname']);
		$this->db->set('agentcode', $pForm['agentcode']);
		$this->db->set('paymentdescription', $pForm['req_note']);
		$this->db->set('bank_name', $pForm['req_payment_bank']);
		$this->db->set('pamount', $pForm['req_amount']);
		$this->db->set('pstatus', 0);
		$this->db->set('payment_type', $pForm['req_payment_type']);
		$this->db->insert('pendingpayments');
		$num = $this->db->affected_rows();
		if ($num > 0) {
			if ($pForm['req_payment_type'] == "Bank Payment") {
				addlog($pForm["bookingid"], $pForm["req_payment_type"] . " Request Amounting <strong class='text-dark'>&pound; " . $pForm["req_amount"] . "</strong> Bank: <strong class='text-dark'>" . $pForm["req_payment_bank"] . "</strong> Ref: <strong class='text-dark'>" . $pForm["req_note"] . "</strong>");
			} elseif ($pForm["req_payment_type"] == "Card Payment") {
				addlog($pForm["bookingid"], $pForm["req_payment_type"] . " Request Amounting <strong class='text-dark'>&pound; " . $pForm["req_amount"] . "</strong> Remarks: <strong class='text-dark'>" . $pForm["req_note"] . "</strong>");
			} elseif ($pForm["req_payment_type"] == "Other") {
				addlog($pForm["bookingid"], "Other Request Amounting <strong class='text-dark'>&pound; " . $pForm["req_amount"] . "</strong> Remarks: <strong class='text-dark'>" . $pForm["req_note"] . "</strong>");
			}
			$this->load->model('mailer_model');
			$this->mailer_model->mail_ptask_add($pForm);
			return true;
		} else {
			return false;
		}
	}
	public function addPaymentReqauto($pForm = '')
	{
		$this->db->set('pdate', date('Y-m-d', strtotime($pForm['req_payment_date'])));
		$this->db->set('bookingid', $pForm['bookingid']);
		$this->db->set('agentname', $pForm['agentname']);
		$this->db->set('agentcode', $pForm['agentcode']);
		$this->db->set('paymentdescription', $pForm['req_note']);
		$this->db->set('bank_name', $pForm['req_payment_bank']);
		$this->db->set('pamount', $pForm['req_amount']);
		$this->db->set('pstatus', 0);
		$this->db->set('payment_type', $pForm['req_payment_type']);
		$this->db->insert('pendingpayments');
		$insert_id = $this->db->insert_id();
		$num = $this->db->affected_rows();
		if ($num > 0) {
			$this->load->model('mailer_model');
			$this->mailer_model->mail_ptask_add($pForm);
			return $insert_id;
		} else {
			return false;
		}
	}
	public function addTktReq($tForm = '')
	{
		if (isset($tForm['flt_tkt_order']) && $tForm['flt_tkt_order']) {
			$flight = $tForm['flt_ordr'];
			$this->db->set('priority', $tForm['priority']);
			$this->db->set('bookingid', $tForm['bookingid']);
			$this->db->set('agentname', $tForm['agentname']);
			$this->db->set('agentcode', $tForm['agentcode']);
			$this->db->set('message', $tForm['issuance_note']);
			$this->db->set('type', 'flight');
			$this->db->set('supplier', $flight['supplier']);
			$this->db->set('supplier_ref', $flight['sup_ref']);
			$this->db->set('gds', $flight['flt_gds']);
			$this->db->set('pnr', $flight['flt_pnr']);
			$this->db->set('ticket_cost', $flight['cost']);
			$this->db->set('ticket_status', 0);
			$this->db->set('direct_send', 0);
			$this->db->insert('pendingtickets');
			$ftid =  $this->db->insert_id();
			$num = $this->db->affected_rows();
			$log_msg = '';
			if ($num > 0) {
				$this->load->model('mailer_model');
				if ($tForm['bkgcheckfortktorder'] == 1 && checkBrandaccess($tForm['agentname'], 'direct_tktorder')) {
					$supplier_mail = $this->suppliermail($flight['supplier']);
					$fform = array(
						'supplier_mail' => $supplier_mail,
						'priority' => $tForm['priority'],
						'bookingid' => $tForm['bookingid'],
						'agentcode' => $tForm['agentcode'],
						'agentname' => $tForm['agentname'],
						'issuance_note' => $tForm['issuance_note'],
						'supplier' => $flight['supplier'],
						'sup_ref' => $flight['sup_ref'],
						'flt_gds' => $flight['flt_gds'],
						'flt_pnr' => $flight['flt_pnr'],
						'cost' => $flight['cost'],
					);
					$this->db->set('message', $tForm['issuance_note'] . '<strong class="text-success"> (Sent Directly)</strong>');
					$this->db->set('direct_send', '1');
					$this->db->where('tid', $ftid);
					$this->db->update('pendingtickets');
					$log_msg = "<strong class='text-dark'>Flight</strong> Issuance Requested <strong class='text-success'>(Sent Directly)</strong> Costing : <strong class='text-dark'> &pound;" . $flight['cost'] . "</strong> Priority: <strong class='text-dark'>" . $tForm['priority'] . "</strong> Supplier: <strong class='text-dark'>" . $fform['supplier'] . "</strong>";
				} else {
					$fform = array(
						'supplier_mail' => '',
						'priority' => $tForm['priority'],
						'bookingid' => $tForm['bookingid'],
						'agentcode' => $tForm['agentcode'],
						'agentname' => $tForm['agentname'],
						'issuance_note' => $tForm['issuance_note'],
						'supplier' => $flight['supplier'],
						'sup_ref' => $flight['sup_ref'],
						'flt_gds' => $flight['flt_gds'],
						'flt_pnr' => $flight['flt_pnr'],
						'cost' => $flight['cost'],
					);
					$log_msg = "<strong class='text-dark'>Flight</strong> Issuance Requested Costing : <strong class='text-dark'> &pound;" . $flight['cost'] . "</strong> Priority: <strong class='text-dark'>" . $tForm['priority'] . "</strong> Supplier: <strong class='text-dark'>" . $fform['supplier'] . "</strong>";
				}
				addlog($tForm['bookingid'], $log_msg);
				$this->mailer_model->mail_ttask_add($fform);
			}
		}
		if (isset($tForm['htl_tkt_order']) && $tForm['htl_tkt_order']) {
			$hotel = $tForm['htl_ordr'];
			$this->db->set('priority', $tForm['priority']);
			$this->db->set('bookingid', $tForm['bookingid']);
			$this->db->set('agentname', $tForm['agentname']);
			$this->db->set('agentcode', $tForm['agentcode']);
			$this->db->set('message', $tForm['issuance_note']);
			$this->db->set('type', 'hotel');
			$this->db->set('supplier', $hotel['supplier']);
			$this->db->set('supplier_ref', $hotel['sup_ref']);
			$this->db->set('gds', '-');
			$this->db->set('pnr', '-');
			$this->db->set('ticket_cost', $hotel['cost']);
			$this->db->set('ticket_status', 0);
			$this->db->set('direct_send', 0);
			$this->db->insert('pendingtickets');
			$htid =  $this->db->insert_id();
			$num = $this->db->affected_rows();
			$log_msg = '';
			if ($num > 0) {
				$this->load->model('mailer_model');
				$fform = array(
					'supplier_mail' => '',
					'priority' => $tForm['priority'],
					'bookingid' => $tForm['bookingid'],
					'agentcode' => $tForm['agentcode'],
					'agentname' => $tForm['agentname'],
					'issuance_note' => $tForm['issuance_note'],
					'supplier' => $hotel['supplier'],
					'sup_ref' => $hotel['sup_ref'],
					'cost' => $hotel['cost'],
				);
				$log_msg = "<strong class='text-dark'>Hotel</strong> Issuance Requested Costing : <strong class='text-dark'> &pound;" . $hotel['cost'] . "</strong> Priority: <strong class='text-dark'>" . $tForm['priority'] . "</strong> Supplier: <strong class='text-dark'>" . $fform['supplier'] . "</strong>";
				addlog($tForm['bookingid'], $log_msg);
				$this->mailer_model->mail_ttask_add($fform);
			}
		}
		if (isset($tForm['cab_tkt_order']) && $tForm['cab_tkt_order']) {
			$cab = $tForm['cab_ordr'];
			$this->db->set('priority', $tForm['priority']);
			$this->db->set('bookingid', $tForm['bookingid']);
			$this->db->set('agentname', $tForm['agentname']);
			$this->db->set('agentcode', $tForm['agentcode']);
			$this->db->set('message', $tForm['issuance_note']);
			$this->db->set('type', 'cab');
			$this->db->set('supplier', $cab['supplier']);
			$this->db->set('supplier_ref', $cab['sup_ref']);
			$this->db->set('gds', '-');
			$this->db->set('pnr', '-');
			$this->db->set('ticket_cost', $cab['cost']);
			$this->db->set('ticket_status', 0);
			$this->db->set('direct_send', 0);
			$this->db->insert('pendingtickets');
			$ctid =  $this->db->insert_id();
			$num = $this->db->affected_rows();
			$log_msg = '';
			if ($num > 0) {
				$this->load->model('mailer_model');
				$fform = array(
					'supplier_mail' => '',
					'priority' => $tForm['priority'],
					'bookingid' => $tForm['bookingid'],
					'agentcode' => $tForm['agentcode'],
					'agentname' => $tForm['agentname'],
					'issuance_note' => $tForm['issuance_note'],
					'supplier' => $cab['supplier'],
					'sup_ref' => $cab['sup_ref'],
					'cost' => $cab['cost'],
				);
				$log_msg = "<strong class='text-dark'>Cab</strong> Issuance Requested Costing : <strong class='text-dark'> &pound;" . $cab['cost'] . "</strong> Priority: <strong class='text-dark'>" . $tForm['priority'] . "</strong> Supplier: <strong class='text-dark'>" . $fform['supplier'] . "</strong>";
				addlog($tForm['bookingid'], $log_msg);
				$this->mailer_model->mail_ttask_add($fform);
			}
		}
		return TRUE;
	}
	public function suppliermail($sup_name)
	{
		$this->db->select('tkt_order_mail');
		$this->db->where('supplier_name', $sup_name);
		$row = $this->db->get('suppliers')->row_array();
		return $row['tkt_order_mail'];
	}
	public function GetpaymentRequest($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('pendingpayments');
		if ($bkg_id != '') {
			$this->db->where('bookingid', $bkg_id);
		}
		$this->db->where('pstatus', 0);
		return $this->db->get()->result_array();
	}
	public function GettktRequest($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('pendingtickets');
		if ($bkg_id != '') {
			$this->db->where('bookingid', $bkg_id);
		}
		$this->db->where('ticket_status', 0);
		return $this->db->get()->result_array();
	}
	public function cancelPending($bkgId = '')
	{
		$this->db->set('bkg_status', 'Cancelled Pending');
		$this->db->where('bkg_no', $bkgId);
		$this->db->update('bookings');
		$num = $this->db->affected_rows();
		if ($num > 0) {
			addlog($bkgId, 'Booking has been moved to cancelled pending');
			return true;
		} else {
			return false;
		}
	}
	public function createDup($bkgId = '')
	{
		$this->db->select('MAX(`bkg_no`) as max_id');
		$this->db->from('bookings');
		$max_id = $this->db->get()->row_array();
		$nextbkgno = $max_id['max_id'] + 1;
		$query = "INSERT INTO bookings(bkg_no, bkg_date, bkg_agent, bkg_status, cst_name, cst_address, cst_city, cst_postcode, cst_email, cst_phone, cst_mobile, pmt_mode, pmt_payingby, tpp_cardholdername, tpp_cardno, tpp_cardexpirydate, tpp_cardvalidfrom, tpp_securitycode, sup_name, flt_destinationairport, flt_departureairport, flt_via, flt_departuredate, flt_returningdate, flt_airline, flt_flighttype, flt_flightno, flt_pnr, flt_ticketdetail, flt_bookingnote, bkg_customercontactlog, cst_source, flt_class, flt_gds, flt_pnr_expiry, flt_fare_expiry, bkg_supplier_reference, bkg_brandname, recpt_due_date, bkg_sup_agent, flt_legs, flight, hotel, cab)  SELECT " . $nextbkgno . ",bkg_date, bkg_agent, 'Pending', cst_name, cst_address, cst_city, cst_postcode, cst_email, cst_phone, cst_mobile, pmt_mode, pmt_payingby, tpp_cardholdername, tpp_cardno, tpp_cardexpirydate, tpp_cardvalidfrom, tpp_securitycode, sup_name, flt_destinationairport, flt_departureairport, flt_via, flt_departuredate, flt_returningdate, flt_airline, flt_flighttype, flt_flightno, flt_pnr, flt_ticketdetail, flt_bookingnote, bkg_customercontactlog, cst_source, flt_class, flt_gds, flt_pnr_expiry, flt_fare_expiry, bkg_supplier_reference, bkg_brandname, recpt_due_date, bkg_sup_agent, flt_legs, flight, hotel, cab FROM bookings WHERE bkg_no = " . $bkgId;
		$this->db->query($query);
		$this->db->select('p_title, p_firstname, p_middlename, p_lastname, p_age, p_catagory, p_basic, p_tax, p_bookingfee, p_cardcharges, p_others,p_hotel,p_cab, p_eticket_no');
		$this->db->from('passengers');
		$this->db->where('bkg_no', $bkgId);
		$passengers = $this->db->get()->result_array();
		foreach ($passengers as $key => $pax) {
			$this->db->set('bkg_no', $nextbkgno);
			$this->db->set('p_title', $pax['p_title']);
			$this->db->set('p_firstname', $pax['p_firstname']);
			$this->db->set('p_middlename', $pax['p_middlename']);
			$this->db->set('p_lastname', $pax['p_lastname']);
			$this->db->set('p_age', $pax['p_age']);
			$this->db->set('p_catagory', $pax['p_catagory']);
			$this->db->set('p_basic', '0.00');
			$this->db->set('p_tax', '0.00');
			$this->db->set('p_bookingfee', '0.00');
			$this->db->set('p_cardcharges', '0.00');
			$this->db->set('p_others', '0.00');
			$this->db->set('p_hotel', '0.00');
			$this->db->set('p_cab', '0.00');
			$this->db->set('p_eticket_no', '');
			$this->db->insert('passengers');
		}
		$this->db->select('*');
		$this->db->from('bkg_flight_legs');
		$this->db->where('leg_bkg_id', $bkgId);
		$flight_legs = $this->db->get()->result_array();
		foreach ($flight_legs as $key => $flight_leg) {
			$this->db->set('leg_bkg_id', $nextbkgno);
			$this->db->set('leg_flight_no', $flight_leg['leg_flight_no']);
			$this->db->set('leg_dept_fr', $flight_leg['leg_dept_fr']);
			$this->db->set('leg_dept_dt', $flight_leg['leg_dept_dt']);
			$this->db->set('leg_arv_at', $flight_leg['leg_arv_at']);
			$this->db->set('leg_arv_dt', $flight_leg['leg_arv_dt']);
			$this->db->set('leg_air', $flight_leg['leg_air']);
			$this->db->insert('bkg_flight_legs');
		}
		$this->db->select('*');
		$this->db->from('bookings_hotel');
		$this->db->where('bkg_no', $bkgId);
		$hotels = $this->db->get()->result_array();
		foreach ($hotels as $key => $htl) {
			unset($htl['id']);
			$htl['bkg_no'] = $nextbkgno;
			$htl['cost'] = 0.00;
			$this->db->insert('bookings_hotel', $htl);
		}
		$this->db->select('*');
		$this->db->from('bookings_cab');
		$this->db->where('bkg_no', $bkgId);
		$cabs = $this->db->get()->result_array();
		foreach ($cabs as $key => $cab) {
			unset($cab['id']);
			$cab['bkg_no'] = $nextbkgno;
			$cab['cost'] = 0.00;
			$this->db->insert('bookings_cab', $cab);
		}
		$data = array();
		$data['status'] = 'true';
		$data['booking_id'] = hashing($nextbkgno, 'e');
		$pre_bkg = $this->db->select('bkg_status,bkg_agent')->from('bookings')->where('bkg_no', $bkgId)->get()->row_array();
		$bkg_status = '';
		if ($pre_bkg['bkg_status'] == 'Pending' || $pre_bkg['bkg_status'] == 'Cancelled Pending') {
			$bkg_status = 'pending';
		} else {
			$bkg_status = $pre_bkg['bkg_status'];
		}
		$log_msg = "Duplicate Booking Created From Booking # <a target='_blank' href='" . base_url('booking/' . $bkg_status . '/' . hashing($bkgId)) . "'>" . $bkgId . "</a> of <strong class='text-dark'>" . $pre_bkg['bkg_agent'] . "</strong>";
		addlog($nextbkgno, $log_msg);
		return $data;
	}
	public function GetCardDetails($bkgId = '')
	{
		$this->db->select('tpp_cardholdername,tpp_cardno,tpp_cardexpirydate,tpp_securitycode,cst_address,cst_city,cst_postcode,pmt_mode,cst_email,	cst_phone,cst_mobile,pmt_payingby');
		$this->db->from('bookings');
		$this->db->where('bkg_no', $bkgId);
		return $this->db->get()->row_array();
	}
	public function GetissuanceDetails($bkgId = '')
	{
		$this->db->select('bkg_no, sup_name, bkg_supplier_reference, flt_gds, flt_pnr, flt_legs, flt_ticketdetail, flt_bookingnote, cost_basic, cost_tax, cost_apc, cost_safi, cost_bank_charges_internal, cost_cardcharges, cost_postage, cost_cardverfication, cost_misc, cost_safi, flight, hotel, cab');
		$this->db->from('bookings');
		$this->db->where('bkg_no', $bkgId);
		return $this->db->get()->row_array();
	}
	public function updateBookingissuance($Form = '')
	{
		if ($Form['flt_bookingnote'] != '') {
			$this->db->set('bkg_id', $Form['bkg_no']);
			$this->db->set('bkg_cmnt', $Form['flt_bookingnote']);
			$this->db->set('bkg_cmnt_by', $this->session->userdata('user_name'));
			$this->db->insert('booking_comments');
		}
		addlog($Form['bkg_no'], 'Booking Issued');
		if ($Form['hotel']) {
			$this->db->set('name', $Form['htl_name']);
			$this->db->set('supplier', $Form['htl_sup']);
			$this->db->set('sup_ref', $Form['htl_sup_ref']);
			$this->db->set('cost', $Form['htl_cost']);
			$this->db->where('bkg_no',  $Form['bkg_no']);
			$this->db->update('bookings_hotel');
		}
		if ($Form['cab']) {
			$this->db->set('name', $Form['cab_name']);
			$this->db->set('supplier', $Form['cab_sup']);
			$this->db->set('sup_ref', $Form['cab_sup_ref']);
			$this->db->set('cost', $Form['cab_cost']);
			$this->db->where('bkg_no',  $Form['bkg_no']);
			$this->db->update('bookings_cab');
		}
		if ($Form['flight']) {
			$this->db->set('sup_name', $Form['supplier_name']);
			$this->db->set('bkg_supplier_reference', $Form['bkg_supplier_reference']);
			$this->db->set('flt_gds', $Form['flt_gds']);
			$this->db->set('flt_pnr', $Form['flt_pnr']);

			$this->db->set('cost_basic', $Form['cost_basic']);
			$this->db->set('cost_tax', $Form['cost_tax']);
			$this->db->set('cost_apc', $Form['cost_apc']);
			$this->db->set('cost_misc', $Form['cost_misc']);
		}
		$this->db->set('clr_date', date('Y-m-d', strtotime($Form['issue_date'])));
		$this->db->set('cost_bank_charges_internal', $Form['cost_bank_charges_internal']);
		$this->db->set('cost_cardcharges', $Form['cost_cardcharges']);
		$this->db->set('cost_postage', $Form['cost_postage']);
		$this->db->set('cost_cardverfication', $Form['cost_cardverfication']);
		$this->db->set('bkg_status', 'Issued');
		$this->db->where('bkg_no',  $Form['bkg_no']);
		$this->db->update('bookings');
		$num = $this->db->affected_rows();
		if ($num > 0) {
			foreach ($Form['eticket'] as $key => $tkt) {
				$this->db->set('p_eticket_no', $tkt);
				$this->db->where('p_id', $key);
				$this->db->where('bkg_no', $Form['bkg_no']);
				$this->db->update('passengers');
			}
			return true;
		}
	}
	public function issueontrans($data = '')
	{
		$this->db->set('bkg_status', 'Issued');
		$this->db->set('clr_date', date('Y-m-d', strtotime($data['clr_date'])));
		$this->db->where('bkg_no',  $data['bkg_no']);
		$this->db->update('bookings');
		$num = $this->db->affected_rows();
		if ($num > 0) {
			$this->db->select('
				bkg.sup_name,
				bkg.clr_date,
				bkg.flight,
				bkg.hotel,
				bkg.cab,
				bkg.cost_basic,
				bkg.cost_tax,
				bkg.cost_apc,
				bkg.cost_misc,
				bkg.cost_bank_charges_internal,
				bkg.cost_cardcharges,
				bkg.cost_postage,
				bkg.cost_cardverfication,
				sum(p.p_basic+p.p_tax+p.p_bookingfee+p.p_cardcharges+p.p_others) as totalsale,
				sum(p.p_hotel) as totalhotel,
				sum(p.p_cab) as totalcab,
				');
			$this->db->from('bookings bkg');
			$this->db->join('passengers p', 'p.bkg_no = bkg.bkg_no', 'left');
			$this->db->where('bkg.bkg_no',  $data['bkg_no']);
			$bkging = $this->db->get()->row_array();
			$issuanceData = array();
			$issuanceData['admin_cost'] = (float)$bkging["cost_bank_charges_internal"] + (float)$bkging["cost_cardcharges"] + (float)$bkging["cost_postage"] + (float)$bkging["cost_cardverfication"];
			$issuanceData['total_sale'] = (float)$bkging["totalsale"];
			$issuanceData['profit'] = (float)$issuanceData['total_sale'] -  (float)$issuanceData['admin_cost'];
			$issuanceData['flight'] = $bkging['flight'];
			if ($bkging['flight']) {
				$issuanceData['flt_sup'] = $bkging["sup_name"];
				$issuanceData['flt_price'] = $bkging["totalsale"];
				$issuanceData['flt_cost'] = (float)$bkging["cost_basic"] + (float)$bkging["cost_tax"] + (float)$bkging["cost_apc"] + (float)$bkging["cost_misc"];
				$issuanceData['profit'] -= $issuanceData['flt_cost'];
			}
			$issuanceData['hotel'] = $bkging['hotel'];
			if ($bkging['hotel']) {
				$this->db->select('*');
				$this->db->where('bkg_no',  $data['bkg_no']);
				$hotel = $this->db->get('bookings_hotel')->row_array();
				$issuanceData['htl_sup'] = $hotel['supplier'];
				$issuanceData['htl_price'] = $bkging['totalhotel'];
				$issuanceData['htl_cost'] = $hotel['cost'];
				$issuanceData['profit'] -= $issuanceData['htl_cost'];
			}
			$issuanceData['cab'] = $bkging['cab'];
			if ($bkging['cab']) {
				$this->db->select('*');
				$this->db->where('bkg_no',  $data['bkg_no']);
				$cab = $this->db->get('bookings_cab')->row_array();
				$issuanceData['cab_sup'] = $cab['supplier'];
				$issuanceData['cab_price'] = $bkging['totalcab'];
				$issuanceData['cab_cost'] = $cab['cost'];
				$issuanceData['profit'] -= $issuanceData['cab_cost'];
			}
			$issuanceData['apc_payable'] = (float)$bkging["cost_postage"];
			$issuanceData['bkg_no'] = $data["bkg_no"];
			$issuanceData['issue_date'] = $data['clr_date'];
			$salepurchase = $this->insertSalePurchase($issuanceData);
		}
	}
	public function cancelontrans($data = '')
	{
		$this->db->select('(`cost_basic`+`cost_tax`+`cost_apc`+`cost_safi`+`cost_misc`+`cost_postage`+`cost_cardverfication`+`cost_cardcharges`+`cost_bank_charges_internal`) as exp');
		$this->db->from('bookings');
		$this->db->where('bkg_no',  $data['bkg_no']);
		$bkg = $this->db->get()->row_array();
		$exp = $bkg['exp'];
		$amt = Getrcepaid($data['bkg_no']);
		$amt_rec = $amt['amt_received'];
		$amt_rfnd = $amt['amt_refund'];
		$data['profit'] = round($amt_rec - ($amt_rfnd + $exp), 2);
		//$data['msg'] = '<br>Transaction added After File was Cancelled';
		$data['cancel_date'] = $data['cnl_date'];
		$this->cancelBooking($data);
	}
	public function insertSalePurchase($details)
	{

		$this->db->select('MAX(`trans_id`) as t_id');
		$this->db->from('transactions');
		$rowtransid = $this->db->get()->row_array();
		$nexttransid = $rowtransid['t_id'] + 1;
		$nexttransid2 = $rowtransid['t_id'] + 2;
		// Flight Sale Entry //
		if ($details['flight']) {
			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', 'Customer');
			$this->db->set('trans_by_to', 'Air Ticket Sales');
			$this->db->set('trans_description', 'Tickets Supplied To Customer');
			$this->db->set('trans_amount', $details['flt_price']);
			$this->db->set('trans_type', 'Dr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');

			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', 'Air Ticket Sales');
			$this->db->set('trans_by_to', 'Customer');
			$this->db->set('trans_description', 'Tickets Supplied To Customer');
			$this->db->set('trans_amount', $details['flt_price']);
			$this->db->set('trans_type', 'Cr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');
			// Purchase Entry //
			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', 'Air Ticket Purchases');
			$this->db->set('trans_by_to', $details['flt_sup']);
			$this->db->set('trans_description', 'Tickets Purchased From Supplier');
			$this->db->set('trans_amount', $details['flt_cost']);
			$this->db->set('trans_type', 'Dr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');

			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', $details['flt_sup']);
			$this->db->set('trans_by_to', 'Air Ticket Purchases');
			$this->db->set('trans_description', 'Tickets Purchased From Supplier');
			$this->db->set('trans_amount', $details['flt_cost']);
			$this->db->set('trans_type', 'Cr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');

			// APC Payable Entry //
			if ($details['apc_payable'] > 0) {
				$this->db->set('trans_id', $nexttransid2);
				$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
				$this->db->set('trans_ref', $details['bkg_no']);
				$this->db->set('trans_head', 'APC Charges');
				$this->db->set('trans_by_to', 'APC Payable');
				$this->db->set('trans_description', 'ATOL charges payable');
				$this->db->set('trans_amount', $details['apc_payable']);
				$this->db->set('trans_type', 'Dr');
				$this->db->set('trans_created_by', 'System');
				$this->db->insert('transactions');

				$this->db->set('trans_id', $nexttransid2);
				$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
				$this->db->set('trans_ref', $details['bkg_no']);
				$this->db->set('trans_head', 'APC Payable');
				$this->db->set('trans_by_to', 'APC Charges');
				$this->db->set('trans_description', 'ATOL charges payable');
				$this->db->set('trans_amount', $details['apc_payable']);
				$this->db->set('trans_type', 'Cr');
				$this->db->set('trans_created_by', 'System');
				$this->db->insert('transactions');
			}
		}
		// Hotel Sale Entry //
		if ($details['hotel']) {
			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', 'Customer');
			$this->db->set('trans_by_to', 'Hotel Sales');
			$this->db->set('trans_description', 'Hotel Supplied To Customer');
			$this->db->set('trans_amount', $details['htl_price']);
			$this->db->set('trans_type', 'Dr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');

			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', 'Hotel Sales');
			$this->db->set('trans_by_to', 'Customer');
			$this->db->set('trans_description', 'Hotel Supplied To Customer');
			$this->db->set('trans_amount', $details['htl_price']);
			$this->db->set('trans_type', 'Cr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');
			// Purchase Entry //
			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', 'Hotel Purchases');
			$this->db->set('trans_by_to', $details['htl_sup']);
			$this->db->set('trans_description', 'Hotel Purchased From Supplier');
			$this->db->set('trans_amount', $details['htl_cost']);
			$this->db->set('trans_type', 'Dr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');

			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', $details['htl_sup']);
			$this->db->set('trans_by_to', 'Hotel Purchases');
			$this->db->set('trans_description', 'Hotel Purchased From Supplier');
			$this->db->set('trans_amount', $details['htl_cost']);
			$this->db->set('trans_type', 'Cr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');
		}
		// Cab Sale Entry //
		if ($details['cab']) {
			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', 'Customer');
			$this->db->set('trans_by_to', 'Cab Sales');
			$this->db->set('trans_description', 'Cab Supplied To Customer');
			$this->db->set('trans_amount', $details['cab_price']);
			$this->db->set('trans_type', 'Dr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');

			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', 'Cab Sales');
			$this->db->set('trans_by_to', 'Customer');
			$this->db->set('trans_description', 'Cab Supplied To Customer');
			$this->db->set('trans_amount', $details['cab_price']);
			$this->db->set('trans_type', 'Cr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');
			// Purchase Entry //
			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', 'Cab Purchases');
			$this->db->set('trans_by_to', $details['cab_sup']);
			$this->db->set('trans_description', 'Cab Purchased From Supplier');
			$this->db->set('trans_amount', $details['cab_cost']);
			$this->db->set('trans_type', 'Dr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');

			$this->db->set('trans_id', $nexttransid);
			$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
			$this->db->set('trans_ref', $details['bkg_no']);
			$this->db->set('trans_head', $details['cab_sup']);
			$this->db->set('trans_by_to', 'Cab Purchases');
			$this->db->set('trans_description', 'Cab Purchased From Supplier');
			$this->db->set('trans_amount', $details['cab_cost']);
			$this->db->set('trans_type', 'Cr');
			$this->db->set('trans_created_by', 'System');
			$this->db->insert('transactions');
		}
		// Profit & Loss Entry //
		$this->db->set('trans_id', $nexttransid);
		$this->db->set('trans_date',  date('Y-m-d', strtotime($details['issue_date'])));
		$this->db->set('trans_ref', $details['bkg_no']);
		$this->db->set('trans_head', 'P&L Account');
		$this->db->set('trans_by_to', '');
		$this->db->set('trans_description', 'Profit on tickets issuance');
		$this->db->set('trans_amount', $details['profit']);
		$this->db->set('trans_type', 'Cr');
		$this->db->set('trans_created_by', 'System');
		$this->db->insert('transactions');
		$data['status'] = 'true';
		$data['booking_id'] = hashing($details['bkg_no'], 'e');
		return $data;
	}
	public function cancelBooking($form = '')
	{
		if ($form['msg'] != '') {
			$this->db->set('bkg_id', $form['bkg_no']);
			$this->db->set('bkg_cmnt', $form['msg']);
			$this->db->set('bkg_cmnt_by', $this->session->userdata('user_name'));
			$this->db->insert('booking_comments');
		}
		addlog($form['bkg_no'], 'Booking Cancelled');

		$pax = $this->GetBookingpax($form['bkg_no']);
		$pax_count = count($pax);
		if ($pax_count > 0) {
			$this->db->set('p_basic', '0.00');
			$this->db->set('p_tax', '0.00');
			$this->db->set('p_bookingfee', '0.00');
			$this->db->set('p_cardcharges', '0.00');
			$this->db->set('p_others', '0.00');
			$this->db->set('p_eticket_no', '');
			$this->db->where('bkg_no', $form['bkg_no']);
			$this->db->update('passengers');
		}
		$this->db->set('cost_tax', '0.00');
		$this->db->set('cost_apc', '0.00');
		$this->db->set('cost_misc', '0.00');
		$this->db->set('cnl_date', date('Y-m-d', strtotime($form['cancel_date'])));
		$this->db->set('bkg_status', 'Cancelled');
		$this->db->set('clr_date', '');
		$this->db->where('bkg_no', $form['bkg_no']);
		$this->db->update('bookings');

		$this->db->select('MAX(`trans_id`) as t_id');
		$this->db->from('transactions');
		$rowtransid = $this->db->get()->row_array();
		$nexttransid = $rowtransid['t_id'] + 1;
		$nexttransid2 = $rowtransid['t_id'] + 2;

		$this->db->set('trans_id', $nexttransid);
		$this->db->set('trans_date', date('Y-m-d', strtotime($form['cancel_date'])));
		$this->db->set('trans_ref', $form['bkg_no']);
		$this->db->set('trans_head', 'P&L Account');
		$this->db->set('trans_by_to', '');
		$this->db->set('trans_description', 'Profit on cancelled file');
		$this->db->set('trans_amount', $form['profit']);
		$this->db->set('trans_type', 'Cr');
		$this->db->set('trans_created_by', 'System');
		$this->db->insert('transactions');
		$num = $this->db->affected_rows();
		if ($num > 0) {
			$data = array();
			$data['status'] = 'true';
			$data['booking_id'] = hashing($form['bkg_no'], 'e');
			return $data;
		} else {
			$data = array();
			$data['status'] = 'false';
			$data['booking_id'] = hashing($form['bkg_no'], 'e');
			return $data;
		}
	}
	public function DeleteBkg($bkgId = '')
	{
		$trans_check = is_trans($bkgId);
		if ($trans_check == false) {
			addlog($bkgId, 'Booking Deleted');
			$this->db->set('bkg_status', 'Deleted');
			$this->db->where('bkg_no', $bkgId);
			$this->db->update('bookings');
			$num = $this->db->affected_rows();
			if ($num > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function searchdatebkg($keyword = '')
	{
		$this->db->select('*');
		$this->db->from('bookings');
		$this->db->where('bkg_status !=', "Deleted");
		$this->db->group_start();
		$this->db->where('bkg_date', date('Y-m-d', strtotime($keyword)));
		$this->db->or_where('cnl_date', date('Y-m-d', strtotime($keyword)));
		$this->db->or_where('clr_date', date('Y-m-d', strtotime($keyword)));
		$this->db->or_where('recpt_due_date', date('Y-m-d', strtotime($keyword)));
		$this->db->group_end();
		$query = $this->db->get()->result_array();
		return $query;
	}
	public function searchrefbkg($keyword = '')
	{
		$this->db->select('*');
		$this->db->from('bookings');
		$this->db->where('bkg_no', $keyword);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			$query = $query->row_array();
			return $query;
		} else {
			return 'false';
		}
	}
	public function searchallbkg($keyword = '')
	{
		$this->db->select('*');
		$this->db->from('bookings');
		$this->db->where('bkg_status !=', "Deleted");
		$this->db->group_start();
		$this->db->like('bkg_agent', $keyword, 'both');
		$this->db->or_like('cst_name', $keyword, 'both');
		$this->db->or_like('cst_address', $keyword, 'both');
		$this->db->or_like('cst_email', $keyword, 'both');
		$this->db->or_like('cst_phone', $keyword, 'both');
		$this->db->or_like('cst_mobile', $keyword, 'both');
		$this->db->or_like('pmt_mode', $keyword, 'both');
		$this->db->or_like('pmt_payingby', $keyword, 'both');
		$this->db->or_like('tpp_cardholdername', $keyword, 'both');
		$this->db->or_like('sup_name', $keyword, 'both');
		$this->db->or_like('flt_destinationairport', $keyword, 'both');
		$this->db->or_like('flt_departureairport', $keyword, 'both');
		$this->db->or_like('flt_via', $keyword, 'both');
		$this->db->or_like('flt_departuredate', $keyword, 'both');
		$this->db->or_like('flt_returningdate', $keyword, 'both');
		$this->db->or_like('flt_airline', $keyword, 'both');
		$this->db->or_like('flt_flighttype', $keyword, 'both');
		$this->db->or_like('flt_flightno', $keyword, 'both');
		$this->db->or_like('flt_pnr', $keyword, 'both');
		$this->db->or_like('cst_source', $keyword, 'both');
		$this->db->or_like('flt_class', $keyword, 'both');
		$this->db->or_like('flt_gds', $keyword, 'both');
		$this->db->or_like('flt_pnr_expiry', $keyword, 'both');
		$this->db->or_like('flt_fare_expiry', $keyword, 'both');
		$this->db->or_like('bkg_supplier_reference', $keyword, 'both');
		$this->db->or_like('bkg_brandname', $keyword, 'both');
		$this->db->or_like('bkg_sup_agent', $keyword, 'both');
		$this->db->group_end();
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			$query = $query->result_array();
			return $query;
		} else {
			return 'false';
		}
	}
	public function searchallpax($keyword = '')
	{
		$this->db->select('b.*');
		$this->db->from('bookings b');
		$this->db->join('passengers p', 'b.bkg_no = p.bkg_no', 'left');
		$this->db->like('b.cst_name', $keyword, 'both');
		$this->db->or_like('p.p_firstname', $keyword, 'both');
		$this->db->or_like('p.p_middlename', $keyword, 'both');
		$this->db->or_like('p.p_lastname', $keyword, 'both');
		$this->db->or_like('p.p_eticket_no', $keyword, 'both');
		$query = $this->db->get()->result_array();
		return $query;
	}
	public function pendingBkg($bkg_id = '', $status_change_msg = '')
	{
		$this->db->set('bkg_id', $bkg_id);
		if ($status_change_msg != '') {
			$this->db->set('bkg_cmnt', $status_change_msg);
		} else {
			$this->db->set('bkg_cmnt', 'Booking Pending');
		}
		$this->db->set('bkg_cmnt_by', $this->session->userdata('user_name'));
		$this->db->insert('booking_cmnt');

		$this->db->set('bkg_status', 'Pending');
		$this->db->set('clr_date', '');
		$this->db->set('cnl_date', '');
		$this->db->where('bkg_no', $bkg_id);
		$this->db->update('bookings');
		//Delete Purchase Entry
		$this->db->where('trans_ref', $bkg_id);
		$this->db->where('trans_description', 'Tickets Purchased From Supplier');
		$this->db->delete('transactions');
		//Delete Purchase Entry
		$this->db->where('trans_ref', $bkg_id);
		$this->db->where('trans_description', 'Hotel Purchased From Supplier');
		$this->db->delete('transactions');
		//Delete Purchase Entry
		$this->db->where('trans_ref', $bkg_id);
		$this->db->where('trans_description', 'Cab Purchased From Supplier');
		$this->db->delete('transactions');
		//Delete Sale Entry
		$this->db->where('trans_ref', $bkg_id);
		$this->db->where('trans_description', 'Tickets Supplied To Customer');
		$this->db->delete('transactions');
		//Delete Sale Entry
		$this->db->where('trans_ref', $bkg_id);
		$this->db->where('trans_description', 'Hotel Supplied To Customer');
		$this->db->delete('transactions');
		//Delete Sale Entry
		$this->db->where('trans_ref', $bkg_id);
		$this->db->where('trans_description', 'Cab Supplied To Customer');
		$this->db->delete('transactions');

		//Delete Atol Payable Entry
		$this->db->where('trans_ref', $bkg_id);
		$this->db->where('trans_description', 'ATOL charges payable');
		$this->db->delete('transactions');
		//Delete Profit On Issuance Entry
		$this->db->where('trans_ref', $bkg_id);
		$this->db->where('trans_description', 'Profit on tickets issuance');
		$this->db->delete('transactions');
		//Delete Profit On Cancellation Entry
		$this->db->where('trans_ref', $bkg_id);
		$this->db->where('trans_description', 'Profit on cancelled file');
		$this->db->delete('transactions');
		//Hashing ID
		$data['id'] = hashing($bkg_id);
		$data['status'] = 'true';
		return $data;
	}
	public function getBookingBands()
	{
		$this->db->select('bkg_brandname');
		$this->db->from('bookings');
		$this->db->where('bkg_status', 'Pending');
		$this->db->group_by('bkg_brandname');
		return $this->db->get()->result_array();
	}
	public function addbookingnote($data = '')
	{
		$this->db->set('bkg_id', $data['bkg_no']);
		$this->db->set('bkg_cmnt', $data['flt_bookingnote']);
		$this->db->set('bkg_cmnt_by', $this->session->userdata('user_name'));
		$this->db->insert('booking_comments');
		$updated_record['value'] = $data['flt_bookingnote'];
		$updated_record['field'] = 'flt_bookingnote';
		$updated_record['status'] = 'true';
		return $updated_record;
	}
	public function GetBookingcmnt($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('booking_comments');
		$this->db->where('bkg_id', $bkg_id);
		$this->db->order_by('bkg_cmnt_datetime', 'asc');
		return $this->db->get()->result_array();
	}
	public function GetBookingnotes($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('booking_cmnt');
		$this->db->where('bkg_id', $bkg_id);
		$this->db->order_by('bkg_cmnt_datetime', 'asc');
		return $this->db->get()->result_array();
	}
	public function sbbdate($data)
	{
		$user_brand = $this->session->userdata('user_brand');
		$sdate = date('Y-m-d', strtotime($data['startdate']));
		$edate = date('Y-m-d', strtotime($data['enddate']));
		$search_by = $data['searchby'];
		$this->db->select('*');
		$this->db->from('bookings');
		if ($user_brand != 'All') {
			$this->db->where('bkg_brandname', $user_brand);
		}
		$this->db->where("$search_by >=", $sdate);
		$this->db->where("$search_by <=", $edate);
		$this->db->order_by("$search_by", 'asc');
		return $this->db->get()->result_array();
	}
	public function sbbvalue($data)
	{
		$user_brand = $this->session->userdata('user_brand');
		$searchvalue = $data['searchvalue'];
		$search_by = $data['searchby'];
		$search_array = array('p_lastname', 'p_firstname', 'p_eticket_no');
		$this->db->select('bkgs.*');
		$this->db->from('bookings bkgs');
		if ($user_brand != 'All') {
			$this->db->where('bkgs.bkg_brandname', $user_brand);
		}
		$this->db->group_start();
		if (in_array($search_by, $search_array)) {
			$this->db->join('passengers p', 'p.bkg_no = bkgs.bkg_no', 'left');
			$this->db->like("p.$search_by", $searchvalue, 'BOTH');
			$this->db->or_where("p.$search_by", $searchvalue);
		} else {
			$this->db->like("bkgs.$search_by", $searchvalue, 'BOTH');
			$this->db->or_where("bkgs.$search_by", $searchvalue);
		}
		$this->db->group_end();
		return $this->db->get()->result_array();
	}
	public function getdept_due($brand = '', $agent = '', $type = '')
	{
		if ($type == 'departure_date') {
			$this->db->select('bkg.bkg_date,bkg.flt_departuredate as travel_date,bkg.bkg_no,bkg.bkg_supplier_reference,bkg.flt_pnr,bkg.cst_name,bkg.cst_mobile,bkg.bkg_agent,bkg.bkg_status,brnd.brand_pre_post_fix,bkg.bkg_brandname,bkg.flt_airline,bkg.flt_destinationairport');
			$this->db->from('bookings bkg');
			$this->db->join('brand brnd', 'brnd.brand_name = bkg.bkg_brandname', 'left');
			$this->db->where('bkg.bkg_status', 'Issued');
			$this->db->where('bkg.flt_departuredate >=', date("Y-m-d"));
			$this->db->order_by('bkg.flt_departuredate', 'asc');
			if ($brand != '' && $brand != 'All') {
				$this->db->where('bkg.bkg_brandname', "$brand");
			}
			if ($agent != '' && $agent != 'All') {
				$this->db->where('bkg.bkg_agent', "$agent");
			}
			return $this->db->get()->result_array();
		} elseif ($type == 'retrun_date') {
			$this->db->select('bkg.bkg_date,bkg.flt_returningdate as travel_date,bkg.bkg_no,bkg.bkg_supplier_reference,bkg.flt_pnr,bkg.cst_name,bkg.cst_mobile,bkg.bkg_agent,bkg.bkg_status,brnd.brand_pre_post_fix,bkg.bkg_brandname,bkg.flt_airline,bkg.flt_destinationairport');
			$this->db->from('bookings bkg');
			$this->db->join('brand brnd', 'brnd.brand_name = bkg.bkg_brandname', 'left');
			$this->db->where('bkg.bkg_status', 'Issued');
			$this->db->where('bkg.flt_returningdate = DATE(DATE_ADD(NOW(), INTERVAL - 1 DAY))');
			if ($brand != '' && $brand != 'All') {
				$this->db->where('bkg.bkg_brandname', "$brand");
			}
			if ($agent != '' && $agent != 'All') {
				$this->db->where('bkg.bkg_agent', "$agent");
			}
			return $this->db->get()->result_array();
		} elseif ($type == 'birthday') {
			$this->db->select('bkg.bkg_date,bkg.flt_departuredate as travel_date, bkg.bkg_no, bkg.bkg_supplier_reference, bkg.flt_pnr,CONCAT(p.p_title,p.p_firstname,p.p_middlename,p.p_lastname) as cst_name,bkg.cst_mobile,bkg.bkg_agent,bkg.bkg_status,brnd.brand_pre_post_fix,bkg.bkg_brandname,bkg.flt_airline,bkg.flt_destinationairport');
			$this->db->from('bookings bkg');
			$this->db->join('passengers p', 'p.bkg_no = bkg.bkg_no', 'left');
			$this->db->join('brand brnd', 'brnd.brand_name = bkg.bkg_brandname', 'left');
			$this->db->where('bkg.bkg_status !=', 'Deleted');
			$this->db->where('MONTH(`p`.`p_age`)', date('m'));
			$this->db->where('day(`p`.`p_age`)', date('d'));
			if ($brand != '' && $brand != 'All') {
				$this->db->where('bkg.bkg_brandname', "$brand");
			}
			if ($agent != '' && $agent != 'All') {
				$this->db->where('bkg.bkg_agent', "$agent");
			}
			return $this->db->get()->result_array();
		}
	}
	public function getBookingFiles($bkg_id = '')
	{
		$this->db->select('*');
		$this->db->from('booking_file');
		$this->db->where('booking_id', $bkg_id);
		return $this->db->get()->result_array();
	}
	public function uploadFile($formData = '')
	{
		$this->db->set('booking_id', $formData['bkg_id']);
		$this->db->set('file_name', $formData['fileName']);
		$this->db->insert('booking_file');
		$numRows = $this->db->affected_rows();
		return $numRows;
	}
	public function getinvdata($bkg)
	{
		$this->db->select('*');
		$this->db->where('bkgno', $bkg);
		$this->db->from('sign_inv');
		return $this->db->get()->result_array();
	}
	public function updateServices($data)
	{
		if ($data['service'] == 'flight') {
			$this->db->where('leg_bkg_id', $data['bkg_no']);
			$this->db->delete('bkg_flight_legs');
			$this->db->set('sup_name', '');
			$this->db->set('bkg_sup_agent', '');
			$this->db->set('bkg_supplier_reference', '');
			$this->db->set('flt_departureairport', '');
			$this->db->set('flt_destinationairport', '');
			$this->db->set('flt_via', '');
			$this->db->set('flt_flighttype', '');
			$this->db->set('flt_departuredate', '');
			$this->db->set('flt_returningdate', '');
			$this->db->set('flt_class', '');
			$this->db->set('flt_airline', '');
			$this->db->set('flt_legs', '');
			$this->db->set('flt_pnr', '');
			$this->db->set('flt_gds', '');
			$this->db->set('flt_pnr_expiry', '');
			$this->db->set('flt_fare_expiry', '');
			$this->db->set('flt_ticketdetail', '');
			$this->db->where('bkg_no', $data['bkg_no']);
			$this->db->update('bookings');
		} else if ($data['service'] == 'hotel') {
			$this->db->where('bkg_no', $data['bkg_no']);
			$this->db->delete('bookings_hotel');
		} else if ($data['service'] == 'cab') {
			$this->db->where('bkg_no', $data['bkg_no']);
			$this->db->delete('bookings_cab');
		}
		$this->db->set($data['service'], $data['value']);
		$this->db->where('bkg_no', $data['bkg_no']);
		$this->db->update('bookings');
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}
/* End of file Add_booking_model.php */
/* Location: ./application/models/Add_booking_model.php */
