<?php
function getips()
{
	return $_SERVER['REMOTE_ADDR'];
}
function ifempty($value = '')
{
	if ($value == '' || $value == '<p><br></p>') {
		echo " - ";
	} else {
		echo $value;
	}
}
function custom_echo($x, $length)
{
	if (strlen($x) <= $length) {
		echo $x;
	} else {
		$y = substr($x, 0, $length) . '...';
		echo $y;
	}
}
function custom_str($x, $length)
{
	if (strlen($x) <= $length) {
		return $x;
	} else {
		$y = substr($x, 0, $length) . '...';
		return $y;
	}
}
function remove_space_r($str)
{
	$str = explode(' ', $str);
	$result = $str[0];
	return $result;
}
function remove_space($str)
{
	$str = explode(' ', $str);
	$result = $str[0];
	echo $result;
}
function bfr_space($str)
{
	$str = explode(' ', $str);
	$result = $str[0];
	return $result;
}
function bfr_dash($str)
{
	$str = explode('-', $str);
	$result = $str[0];
	return $result;
}
function checkLogin()
{
	$CI = &get_instance();
	if ($CI->session->userdata('user_status') == 'loged_in') {
		return true;
	}
	return false;
}
function profileDetails()
{
	$CI = &get_instance();
	$user_id = $CI->session->userdata('user_id');
	$query = "SELECT * from `user_profile` where `user_id`= '$user_id';";
	$result = $CI->db->query($query)->row_array();
	return $result;
}
function hashing($string, $action = 'e')
{
	$output = false;
	$encrypt_method = "AES-256-CBC";
	$secret_key = 'AiTgVvfYrBwlHGsM29OGOIaYkZfbN4cz';
	$secret_iv = 'IHVtH4%o>B$~Dhf^L.}[&i02YU;P0y';
	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	if ($action == 'e') {
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	} elseif ($action == 'd') {
		if (IsBase64($string)) {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		} else {
			$output = $string;
		}
	}
	return $output;
}
function IsBase64($s)
{
	// Check if there are valid base64 characters
	if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;
	// Decode the string in strict mode and check the results
	$decoded = base64_decode($s, true);
	if (false === $decoded) return false;
	// if string returned contains not printable chars
	if (0 < preg_match('/((?![[:graph:]])(?!\s)(?!\p{L}))./', $decoded, $matched)) return false;
	// Encode the string again
	if (base64_encode($decoded) != $s) return false;
	return true;
}
function generateRandomString($length)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
function checkAccess($role = '', $access = '')
{
	$CI = &get_instance();
	$query_access = "SELECT `access_id` from `access` where `access_name`= '$access';";
	$result = $CI->db->query($query_access);
	if ($result->num_rows() > 0) {
		$access_id = $CI->db->query($query_access)->row_array();
		$access_id = $access_id['access_id'];
	} else {
		$access_id = '';
	}
	$query_role = "SELECT `role_id` from `role` where `role_name`= '$role';";
	$result = $CI->db->query($query_role);
	if ($result->num_rows() > 0) {
		$role_id = $CI->db->query($query_role)->row_array();
		$role_id = $role_id['role_id'];
	} else {
		$role_id = '';
	}
	$query_role_access = "SELECT * from `role_has_access` where `role_id`= '$role_id' AND `access_id`= '$access_id';";
	$num = $CI->db->query($query_role_access)->num_rows();
	if ($num == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}
function is_trans($bkgId = '')
{
	$CI = &get_instance();
	$CI->db->select('trans_id');
	$CI->db->from('transactions');
	$CI->db->where('trans_ref', $bkgId);
	$CI->db->get();
	$num = $CI->db->affected_rows();
	if ($num > 0) {
		return true;
	} else {
		return false;
	}
}
function is_transhead($head = '')
{
	$CI = &get_instance();
	$CI->db->select('trans_id');
	$CI->db->from('transactions');
	$CI->db->where('trans_head', $head);
	$CI->db->get();
	$num = $CI->db->affected_rows();
	if ($num > 0) {
		return true;
	} else {
		return false;
	}
}
function status_check($bkgId = '', $status = '')
{
	$CI = &get_instance();
	$CI->db->select('bkg_status');
	$CI->db->from('bookings');
	$CI->db->where('bkg_no', $bkgId);
	$result = $CI->db->get();
	$num = $result->num_rows();
	if ($num > 0) {
		$result = $result->row_array();
		if ($result['bkg_status'] == $status) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
function getclr_cancel_date($bkgno = '', $status = '')
{
	$CI = &get_instance();
	$CI->db->select('clr_date,cnl_date,bkg_status');
	$CI->db->from('bookings');
	$CI->db->where('bkg_no', $bkgno);
	$CI->db->where('bkg_status', $status);
	$result = $CI->db->get();
	$num = $result->num_rows();
	if ($num > 0) {
		$result = $result->row_array();
		if ($result['bkg_status'] == 'Issued') {
			return $result['clr_date'];
		} else if ($result['bkg_status'] == 'Cancelled') {
			return $result['cnl_date'];
		}
	} else {
		return false;
	}
}

function getfieldName($data = '')
{
	$field_name = array(
		"bkg_date" => 'Booking Date',
		"bkg_agent" => 'Booking Agent',
		"bkg_status" => 'Booking Status',
		"cst_name" => 'Pax Name',
		"cst_address" => 'Pax Address',
		"cst_email" => 'Pax Email',
		"cst_phone" => 'Pax Phone',
		"cst_mobile" => 'Pax Mobile',
		"pmt_mode" => 'Payment Mode',
		"tpp_cardholdername" => 'Pay By',
		"sup_name" => 'Sup Name',
		"flt_destinationairport" => 'Dest Arpt',
		"flt_departureairport" => 'Dept Arpt',
		"flt_via" => 'Stopover',
		"flt_departuredate" => 'Dept Date',
		"flt_returningdate" => 'Rtrn Date',
		"flt_airline" => 'Airline',
		"flt_flighttype" => 'Flt Type',
		"flt_flightno" => 'Flt No.',
		"flt_pnr" => 'PNR',
		"flt_ticketdetail" => 'Ticket Details',
		"cnl_date" => 'Cancel Date',
		"clr_date" => 'Issue Date',
		"cst_source" => 'Bkg Source',
		"flt_class" => 'Class',
		"flt_gds" => 'GDS',
		"bkg_supplier_reference" => 'Sup Ref',
		"bkg_brandname" => 'Bkg Brand',
		"recpt_due_date" => 'Payment Due Date',
		"bkg_sup_agent" => 'Sup Agent',
		"flt_legs" => 'Seg',
		"p_lastname" => "Passenger SurName",
		"p_middlename" => "Passenger First Name",
		"p_eticket_no" => "eTicket No",
		"clr_date" => "Ticket Issuance Date",
		"cnl_date" => "Cancellation Date ",
		"bkg_no" => "Booking Ref No",
	);
	foreach ($field_name as $key => $value) {
		if ($key == $data) {
			return $value;
		}
	}
}
function getfieldNamepax($data = '')
{
	$field_name = array(
		"p_firstname" => 'Pax First Name',
		"p_middlename" => 'Pax Mid Name',
		"p_lastname" => 'Pax Sur Name',
		"p_eticket_no" => 'Pax E-Ticket'
	);
	foreach ($field_name as $key => $value) {
		if ($key == $data) {
			return $value;
		}
	}
}

function searchedValue($bkgId = '', $keyword = '')
{
	$CI = &get_instance();
	$notlookin = array('bkg_no', 'tpp_cardno', 'tpp_cardexpirydate', 'tpp_cardvalidfrom', 'tpp_securitycode', 'flt_ticketdetail', 'flt_bookingnote', 'cost_basic', 'cost_basic', 'cost_tax', 'cost_apc', 'cost_safi', 'cost_postage', 'cost_cardverfication', 'cost_cardcharges', 'cost_bank_charges_internal', 'cost_misc', 'bkg_customercontactlog', 'cnl_ticket_issued', 'cnl_supplier_refund_received', 'cnl_supplier_refund_date', 'cnl_request_date', 'flt_fare_expiry', 'flt_pnr_expiry', 'cnl_amountrefunded', 'cst_postcode', 'pmt_payingby');
	$data = $CI->db->list_fields('bookings');
	foreach ($data as $key => $field) {
		if (in_array($field, $notlookin)) {
			continue;
		}
		$CI->db->select("$field");
		$CI->db->where('bkg_no', "$bkgId");
		$CI->db->like("$field", "$keyword", 'both');
		$res = $CI->db->get('bookings');
		$num_rows = $res->num_rows();
		if ($num_rows > 0) {
			$res = $res->row_array();
			$result[$key]['value'] = $res[$field];
			$result[$key]['field'] = getfieldName($field);
		}
	}
	return $result;
}
function searchedValuepax($bkgId = '', $keyword = '')
{
	$CI = &get_instance();
	$lookin = array('p_firstname', 'p_middlename', 'p_lastname', 'p_eticket_no');
	$data = $CI->db->list_fields('passengers');
	foreach ($data as $key => $field) {
		if (!in_array($field, $lookin)) {
			continue;
		}
		$CI->db->select("$field");
		$CI->db->where('bkg_no', "$bkgId");
		$CI->db->like("$field", "$keyword", 'both');
		$res = $CI->db->get('passengers');
		$num_rows = $res->num_rows();
		if ($num_rows > 0) {
			$res = $res->row_array();
			$result[$key]['value'] = $res[$field];
			$result[$key]['field'] = getfieldNamepax($field);
		}
	}
	return $result;
}
function ccdate()
{
	return "XX / XXXX";
}
function ccMasking($number, $maskingCharacter = 'X')
{
	return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
}
function ifcardempty($value = '', $maskingCharacter = 'X')
{
	if ($value == '' || $value == '-') {
		echo " - ";
	} else {
		echo substr($value, 0, 4) . str_repeat($maskingCharacter, strlen($value) - 8) . substr($value, -4);
	}
}
function totalPtasks()
{
	$rows = 0;
	$CI = &get_instance();
	$user_role = $agent = $brand = '';
	$user_role = $CI->session->userdata('user_role');
	$user_name = $CI->session->userdata('user_name');
	$user_brand = $CI->session->userdata('user_brand');
	if (!checkAccess($user_role, 'all_agents_pending_task')) {
		$agent = $user_name;
	}
	if ($user_brand != 'All') {
		$brand = $user_brand;
	}

	$CI->db->select('pp.pid');
	$CI->db->from('pendingpayments pp');
	$CI->db->where('pp.pstatus', 0);
	if ($brand != false && $brand != '') {
		$CI->db->where('pp.agentname', $brand);
	}
	if ($agent != false && $agent != '') {
		$CI->db->join('bookings bkg', 'bkg.bkg_no = pp.bookingid', 'left');
		$CI->db->where('bkg.bkg_agent', $agent);
	}
	$result = $CI->db->get();
	$rows += $result->num_rows();
	$CI->db->select('pt.tid');
	$CI->db->from('pendingtickets pt');
	$CI->db->where('pt.ticket_status', 0);
	if ($brand != false && $brand != '') {
		$CI->db->where('pt.agentname', $brand);
	}
	if ($agent != false && $agent != '') {
		$CI->db->join('bookings bkg', 'bkg.bkg_no = pt.bookingid', 'left');
		$CI->db->where('bkg.bkg_agent', $agent);
	}
	$result = $CI->db->get();
	$rows += $result->num_rows();
	return $rows;
}
function getLastcmnt($value = '')
{
	$CI = &get_instance();
	$CI->db->select('*');
	$CI->db->from('cust_enq_cmnt');
	$CI->db->where('enq_id', $value);
	$CI->db->order_by('cmnt_datetime', 'desc');
	$CI->db->limit(1);
	$cmnt = $CI->db->get()->row_array();
	if (count($cmnt) > 0) {
		$cmnt = $cmnt['cmnt_by'] . " (" . date('d-M H:i', strtotime($cmnt['cmnt_datetime'])) . "): " . $cmnt['enq_cmnt'];
	} else {
		$cmnt = false;
	}
	return $cmnt;
}
function getUser($user = false, $brand = false)
{
	$CI = &get_instance();
	$CI->db->select('*');
	$CI->db->from('users');
	$CI->db->where('user_status', 'active');
	if ($user) {
		$CI->db->where('user_name', $user);
	}
	if ($brand) {
		$CI->db->where('user_brand', $brand);
	}
	return $CI->db->get()->result_array();
}
function getrptname($rpt = '')
{
	$report = array(
		"gross_profit_earned" => "Gross Profit Earned",
		"net_profit_earned" => "Net Profit Earned",
		"client_data" => "Client Data",
		"customer_due_balance" => "Customer Due Balance",
		"supplier_due_balance" => "Supplier Due Balance",
		"supplier_variance_p_t" => "Supplier Variance - Post Transaction",
		"cust_direct_payment_supplier" => "Customer's Direct Payment To Supplier",
		"card_charge_report" => "Card Charge Report",
		"supplier_card_charge_report" => "Supplier Card Charge Report",
		"activity_summary" => "Activity Summary",
		"bt_panel_card_charge" => "Brightsun Panel Card Charge",
		"gds_report" => "GDS Report",
		"s_p_report" => "Sales &amp; Purchase Report",
		"sale_variance_file_t_report" => "Sales Variance in File and Transactions Report",
	);
	foreach ($report as $key => $value) {
		if ($key == $rpt) {
			return $value;
		}
	}
}
function Getpax($bkgId = '')
{
	$CI = &get_instance();
	$CI->db->select('p_id');
	$CI->db->from('passengers');
	$CI->db->where('bkg_no', $bkgId);
	$result = $CI->db->get()->result_array();
	return count($result);
}
function Getrcepaid($bkgid = '')
{
	$data['amt_refund'] = 0;
	$data['amt_received'] = 0;
	$num = 0;
	$CI = &get_instance();
	$CI->db->select('sum( CASE WHEN trans_type = "Dr" THEN trans_amount END) AS amt_refund, sum( CASE WHEN trans_type = "Cr" THEN trans_amount END) AS amt_received');
	$CI->db->from('transactions');
	$CI->db->where('trans_ref', $bkgid);
	$CI->db->where('trans_head', 'Customer');
	$CI->db->where('trans_description <>', 'Tickets Issued');
	$CI->db->where('trans_description <>', 'Profit on cancelled file');
	$result = $CI->db->get();
	$num = $result->num_rows();
	if ($num > 0) {
		$result = $result->row_array();
		$data['amt_refund'] = $result['amt_refund'];
		$data['amt_received'] = $result['amt_received'];
	}
	return $data;
}
function Getcustreceived($bkgid = '')
{
	$num = 0;
	$CI = &get_instance();
	$CI->db->select('sum( CASE WHEN trans_type = "Cr" THEN trans_amount ELSE - trans_amount END) AS total_received');
	$CI->db->from('transactions');
	$CI->db->where('trans_ref', $bkgid);
	$CI->db->where('trans_head', 'Customer');
	$CI->db->where('trans_description <>', 'Tickets Supplied To Customer');
	$CI->db->where('trans_description <>', 'Hotel Supplied To Customer');
	$CI->db->where('trans_description <>', 'Cab Supplied To Customer');
	$result = $CI->db->get();
	$num = $result->num_rows();
	if ($num > 0) {
		$result = $result->row_array();
		$total_received = $result['total_received'];
	}
	return $total_received;
}
function GetTransSale($bkgid = '')
{
	$CI = &get_instance();
	$trans_sale = 0;
	$queryts = "SELECT sum(trans_amount) as trans_amount FROM `transactions` WHERE `trans_head` IN('Air Ticket Sales','Hotel Sales','Cab Sales') AND `trans_ref` = '$bkgid' ;";
	$row = $CI->db->query($queryts)->row_array();
	$trans_sale = $row['trans_amount'];
	return $trans_sale;
}
function GetTransCost($bkgid = '')
{
	$CI = &get_instance();
	$trans_cost = 0;
	$queryts = "SELECT sum(trans_amount) as trans_amount FROM `transactions` WHERE `trans_head` IN('Air Ticket Purchases','Hotel Purchases','Cab Purchases') AND `trans_ref` = '$bkgid' ;";
	$row = $CI->db->query($queryts)->row_array();
	$trans_cost = $row['trans_amount'];
	return $trans_cost;
}
function GetBrands()
{
	$CI = &get_instance();
	$CI->db->select('brand_name');
	$CI->db->from('brand');
	$CI->db->where('brand_status', 'active');
	$CI->db->order_by('brand_id', 'asc');
	return $CI->db->get()->result_array();
}
function addlog($id, $cmnt)
{
	$CI = &get_instance();
	$CI->db->set('bkg_id', $id)->set('bkg_cmnt', $cmnt)->set('bkg_cmnt_by', $CI->session->userdata('user_name'))->insert('booking_cmnt');
	return $CI->db->insert_id();
}
function checkagntbkg($bkgno)
{
	$CI = &get_instance();
	$CI->db->select('bkg_agent');
	$CI->db->from('bookings');
	$CI->db->where('bkg_no', $bkgno);
	$bkg = $CI->db->get()->row_array();
	if ($bkg['bkg_agent'] == $CI->session->userdata('user_name')) {
		return true;
	} else {
		return false;
	}
}
function getbkgagnt($bkgno)
{
	$CI = &get_instance();
	$CI->db->select('bkg_agent');
	$CI->db->from('bookings');
	$CI->db->where('bkg_no', $bkgno);
	$bkg = $CI->db->get()->row_array();
	return $bkg['bkg_agent'];
}
function getbkgsupref($bkgno)
{
	$CI = &get_instance();
	$CI->db->select('bkg_supplier_reference');
	$CI->db->from('bookings');
	$CI->db->where('bkg_no', $bkgno);
	$bkg = $CI->db->get()->row_array();
	return $bkg['bkg_supplier_reference'];
}
function checkbrndbkg($bkgno)
{
	$CI = &get_instance();
	$CI->db->select('bkg_brandname');
	$CI->db->from('bookings');
	$CI->db->where('bkg_no', $bkgno);
	$bkg = $CI->db->get()->row_array();
	if ($bkg['bkg_brandname'] == $CI->session->userdata('user_brand')) {
		return true;
	} else {
		return false;
	}
}
function getbkgbrnddetails($bkgno)
{
	$CI = &get_instance();
	$CI->db->select('br.*');
	$CI->db->from('brand br');
	$CI->db->join('bookings bk', 'br.brand_name = bk.bkg_brandname', 'left');
	$CI->db->where('bk.bkg_no', $bkgno);
	return $CI->db->get()->row_array();
}
function pickedinqcount()
{
	$CI = &get_instance();
	$CI->db->select('enq_id');
	$CI->db->from('customer_enq');
	$CI->db->where('picked_by', $CI->session->userdata('user_name'));
	$CI->db->where('enq_status', 'Open');
	if ($CI->session->userdata('user_brand') != 'All') {
		$CI->db->where('enq_brand', $CI->session->userdata('user_brand'));
	}
	$result = $CI->db->get()->result_array();
	return count($result);
}
function newinqcount()
{
	$CI = &get_instance();
	$CI->db->select('enq_id');
	$CI->db->from('customer_enq');
	$CI->db->where('picked_by', '');
	$CI->db->where('enq_status', 'Open');
	if ($CI->session->userdata('user_brand') != 'All') {
		$CI->db->where('enq_brand', $CI->session->userdata('user_brand'));
	}
	$result = $CI->db->get()->result_array();
	return count($result);
}
function master_mail($mail)
{
	$CI = &get_instance();
	$CI->load->library('email');
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'mail.supremecluster.com';
	$config['smtp_user'] = 'panel@rrtravels.co.uk';
	$config['smtp_pass'] = 'G54s3WHis(';
	$config['smtp_port'] = 465;
	$config['smtp_crypto'] = 'ssl';
	$config['mailtype'] = 'html';
	$CI->email->initialize($config);
	$CI->email->from($mail['from'], @$mail['from_title']);
	$CI->email->to($mail['to'], @$mail['to_title']);
	if (isset($mail['reply_to']) && $mail['reply_to'] != '') {
		$CI->email->reply_to($mail['reply_to'], @$mail['reply_to_title']);
	}
	if (isset($mail['cc']) && $mail['cc'] != '') {
		$CI->email->cc($mail['cc'], @$mail['cc_title']);
	} else {
		$CI->email->cc('');
	}
	if (isset($mail['bcc']) && $mail['bcc'] != '') {
		$CI->email->bcc($mail['bcc'], @$mail['bcc_title']);
	}
	$CI->email->subject($mail['subject']);
	$CI->email->message($mail['message']);
	if (isset($mail['attach']) && $mail['attach'] != '') {
		$CI->email->attach($mail['attach']);
	}
	return $CI->email->send();
}
function etkt_mail($mail)
{
	$CI = &get_instance();
	$CI->load->library('email');
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'mail.supremecluster.com';
	$config['smtp_user'] = 'panel@rrtravels.co.uk';
	$config['smtp_pass'] = 'G54s3WHis(';
	$config['smtp_port'] = 465;
	$config['smtp_crypto'] = 'ssl';
	$config['mailtype'] = 'html';
	$CI->email->initialize($config);
	$CI->email->from($mail['from'], @$mail['from_title']);
	$CI->email->to($mail['to'], @$mail['to_title']);
	if (isset($mail['reply_to']) && $mail['reply_to'] != '') {
		$CI->email->reply_to($mail['reply_to'], @$mail['reply_to_title']);
	}
	if (isset($mail['cc']) && $mail['cc'] != '') {
		$CI->email->cc($mail['cc'], @$mail['cc_title']);
	} else {
		$CI->email->cc('');
	}
	if (isset($mail['bcc']) && $mail['bcc'] != '') {
		$CI->email->bcc($mail['bcc'], @$mail['bcc_title']);
	}
	$CI->email->subject($mail['subject']);
	$CI->email->message($mail['message']);
	if (isset($mail['attach']) && $mail['attach'] != '') {
		$attach = $mail['attach'];
		if (count($attach) >= 0) {
			foreach ($attach as $key => $att) {
				$CI->email->attach(base_url('uploads/file_data/' . $att));
			}
		}
	}
	return $CI->email->send();
}
function checkBrandaccess($brand, $access)
{
	$CI = &get_instance();
	if ($access == 'link') {
		$CI->db->select('authorise_paymentlink');
		$CI->db->from('brand');
		$CI->db->where('brand_name', $brand);
		$result = $CI->db->get()->row_array();
		if ($result['authorise_paymentlink'] == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	} else if ($access == 'invoice') {
		$CI->db->select('send_invoice');
		$CI->db->from('brand');
		$CI->db->where('brand_name', $brand);
		$result = $CI->db->get()->row_array();
		if ($result['send_invoice'] == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	} else if ($access == 'reminder') {
		$CI->db->select('send_reminder_notify');
		$CI->db->from('brand');
		$CI->db->where('brand_name', $brand);
		$result = $CI->db->get()->row_array();
		if ($result['send_reminder_notify'] == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	} else if ($access == 'review') {
		$CI->db->select('review');
		$CI->db->from('brand');
		$CI->db->where('brand_name', $brand);
		$result = $CI->db->get()->row_array();
		if ($result['review'] == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	} elseif ($access == 'direct_link') {
		$CI->db->select('direct_link');
		$CI->db->from('brand');
		$CI->db->where('brand_name', $brand);
		$result = $CI->db->get()->row_array();
		if ($result['direct_link'] == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	} elseif ($access == 'direct_tktorder') {
		$CI->db->select('direct_tktorder');
		$CI->db->from('brand');
		$CI->db->where('brand_name', $brand);
		$result = $CI->db->get()->row_array();
		if ($result['direct_tktorder'] == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
function _crypt($string, $action = 'e')
{
	// you may change these values to your own
	$secret_key = 'kingkong';
	$secret_iv = '@2018';

	$output = false;
	$encrypt_method = "AES-256-CBC";
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	// encrypt the given string
	if ($action == 'e') {
		$output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
	} //decrypt the given string
	else if ($action == 'd') {
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}

	return $output;
}
function geruserbrand($user)
{
	$CI = &get_instance();
	$CI->db->select('user_brand');
	$CI->db->from('users');
	$CI->db->where('user_name', $user);
	$row = $CI->db->get()->row_array();
	return $row['user_brand'];
}
function getbrandmail($brand)
{
	$CI = &get_instance();
	$CI->db->select('brand_email');
	$CI->db->from('brand');
	$CI->db->where('brand_name', $brand);
	$row = $CI->db->get()->row_array();
	return $row['brand_email'];
}
function variance()
{
	$CI = &get_instance();
	$var = 0;
	$dramount = $CI->db->query("SELECT SUM(`trans_amount`) as totaldr FROM `transactions` WHERE `trans_description` != 'Cab Purchased From Supplier' AND `trans_description` != 'Cab Supplied To Customer' AND`trans_description` != 'Hotel Purchased From Supplier' AND `trans_description` != 'Hotel Supplied To Customer' AND `trans_description` != 'Tickets Purchased From Supplier' AND `trans_description` != 'Tickets Supplied To Customer' AND `trans_description` != 'ATOL charges payable' AND `trans_description` != 'Profit on tickets issuance' AND `trans_description` != 'Profit on cancelled file' AND `trans_type` = 'Dr'")->row_array();
	$cramount = $CI->db->query("SELECT SUM(`trans_amount`) as totalcr FROM `transactions` WHERE `trans_description` != 'Cab Purchased From Supplier' AND `trans_description` != 'Cab Supplied To Customer' AND`trans_description` != 'Hotel Purchased From Supplier' AND `trans_description` != 'Hotel Supplied To Customer' AND`trans_description` != 'Tickets Purchased From Supplier' AND `trans_description` != 'Tickets Supplied To Customer' AND `trans_description` != 'ATOL charges payable' AND `trans_description` != 'Profit on tickets issuance' AND `trans_description` != 'Profit on cancelled file' AND `trans_type` = 'Cr'")->row_array();
	$dramount = $dramount['totaldr'];
	$cramount = $cramount['totalcr'];
	$var = round($dramount - $cramount);
	return $var;
}
function closedupeinq($inq_id)
{
	$CI = &get_instance();
	$query_inq = "UPDATE `customer_enquiry` SET `enq_status`= 'c' WHERE `enq_id` = '$inq_id' ;";
	$CI->db->query($query_inq);
	$query_inq_dup = "INSERT INTO `cust_enq_cmnt`(`id`, `enq_id`, `enq_cmnt`, `cmnt_by`) VALUES ('','$inq_id','Dupe Inquiry','System') ;";
	$CI->db->query($query_inq_dup);
}
function get_head_charges($head)
{
	$CI = &get_instance();
	$CI->db->select('*');
	$CI->db->where('trans_head', $head);
	$CI->db->from('trans_head_charges');
	return $CI->db->get()->result_array();
}
function agentbookingemail($bkg_id = '')
{
	$CI = &get_instance();
	$CI->db->select('up.user_work_email');
	$CI->db->from('user_profile up');
	$CI->db->join('users u', 'up.user_id = u.user_id', 'left');
	$CI->db->join('bookings bkg', 'bkg.bkg_agent = u.user_name', 'left');
	$CI->db->where('bkg.bkg_no', $bkg_id);
	$result = $CI->db->get()->row_array();
	return $result['user_work_email'];
}
function getinitials($string = '')
{
	$str = $string;
	$words = explode(' ', $str);
	$result = @$words[0][0] . @$words[1][0];
	return $result;
}
function loginuserlog()
{
	$datetime = date('Y-m-d H:i:s');
	$CI = &get_instance();
	$CI->db->set('user_session_id', $CI->session->session_id);
	$CI->db->set('user_name', $CI->session->userdata('user_name'));
	$CI->db->set('user_timestamp', '');
	$CI->db->set('user_status', 'logged_in');
	$CI->db->set('user_login_timestamp', $datetime);
	$CI->db->insert('user_log');
}
function logoutuserlog()
{
	$datetime = date('Y-m-d H:i:s');
	$CI = &get_instance();
	$CI->db->set('user_logout_timestamp', $datetime);
	$CI->db->set('user_status', 'logged_out');
	$CI->db->where('user_session_id', $CI->session->session_id);
	$CI->db->update('user_log');
}
function check_dupelogin($username)
{
	$CI = &get_instance();
	$CI->db->select('user_name');
	$CI->db->where('user_name', $username);
	$CI->db->where('user_status', 'logged_in');
	$CI->db->from('user_log');
	$query = $CI->db->get();
	$num = $query->num_rows();
	if ($num > 0) {
		$CI->db->set('login_attempt', 1);
		$CI->db->where('user_name', $username);
		$CI->db->where('user_status', 'logged_in');
		$CI->db->update('user_log');
		return true;
	} else {
		return false;
	}
}
function checktransfornotify($trans_by_to, $trans_head)
{
	if ($trans_by_to == 'Customer') {
		$CI = &get_instance();
		$CI->db->select('trans_head_mode');
		$CI->db->from('transaction_heads');
		$CI->db->where('trans_head', $trans_head);
		$row = $CI->db->get()->row_array();
		if ($row['trans_head_mode'] == 'bank' || $row['trans_head_mode'] == 'cash' || $row['trans_head_mode'] == 'card') {
			return true;
		} else {
			return false;
		}
	} else {
		$CI = &get_instance();
		$CI->db->select('trans_head_mode');
		$CI->db->from('transaction_heads');
		$CI->db->where('trans_head', $trans_by_to);
		$row = $CI->db->get()->row_array();
		if ($row['trans_head_mode'] == 'bank' || $row['trans_head_mode'] == 'cash' || $row['trans_head_mode'] == 'card') {
			return true;
		} else {
			return false;
		}
	}
}
function inqcolor($dpt_date, $alert_date)
{
	date_default_timezone_set('Europe/London');
	$t_date = date('Y-m-d');
	$t_datetime = date('Y-m-d h:i');
	$a_date = date('Y-m-d', strtotime($alert_date));
	$a_datetime = date('Y-m-d h:i', strtotime($alert_date));
	$final_color = "#ffffff";
	if ($alert_date != null) {
		if ((strtotime($a_date) == strtotime($t_date)) && (strtotime($a_datetime) > strtotime($t_datetime))) {
			$final_color = "#9cff89";
		} else if ((strtotime($a_date) <= strtotime($t_date)) && (strtotime($a_datetime) <= strtotime($t_datetime))) {

			$final_color = "#fddbb2";
		} else if ((strtotime($a_date) > strtotime($t_date)) && (strtotime($a_datetime) > strtotime($t_datetime))) {
			$final_color = "#bfffb3";
		}
	}
	if (date(strtotime($t_date)) > date(strtotime($dpt_date))) {
		$final_color = "#ff8484";
	}
	return $final_color;
}
function invoicechecker($bkgid)
{
	$CI = &get_instance();
	$CI->db->select('status');
	$CI->db->where('bkgno', $bkgid);
	$CI->db->order_by('sent_datetime', 'DESC');
	$CI->db->limit(1);
	$data = $CI->db->get('sign_inv');
	if ($data->num_rows() > 0) {
		$row = $data->row_array();
		if ($row['status'] != 'Signed') {
			return FALSE;
		} else {
			return TRUE;
		}
	} else {
		return FALSE;
	}
}
function echoconfirmclass($id)
{
	$CI = &get_instance();
	$CI->db->select('b.sup_name as flt_sup,h.supplier as htl_sup,c.supplier as cab_sup');
	$CI->db->from('bookings b');
	$CI->db->join('bookings_hotel h', 'h.bkg_no = b.bkg_no', 'left');
	$CI->db->join('bookings_cab c', 'c.bkg_no = b.bkg_no', 'left');
	$CI->db->where('b.bkg_no', $id);
	$row = $CI->db->get()->row_array();
	$sup_count = 0;
	if ($row['flt_sup'] != '') {
		$sup_count++;
	}
	if ($row['htl_sup'] != NULL) {
		$sup_count++;
	}
	if ($row['cab_sup'] != NULL) {
		$sup_count++;
	}
	if ($sup_count == 1) {
		echo 'issuetkttask';
	} else {
		echo 'confirmtkttask';
	}
}

function print_data($array)
{
	echo "<div align='left'><pre>";
	if (is_array($array))
		print_r($array);
	else
		echo $array;
	echo "</pre></div>";
}
