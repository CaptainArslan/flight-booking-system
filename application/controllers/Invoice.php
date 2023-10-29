<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends PL_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url() . '?err=no_login');
		}
		$this->footer_data = array();
		$this->sidebar_data = array();
		$this->load->model('booking_model');
		$this->load->model('mailer_model');
		// $this->load->library('dpdf');
	}
	public function sendinv($id)
	{
		$bkg_id = $id;
		$token = generateRandomString(20);
		$inv['booking'] = $this->booking_model->GetBookingDetails($bkg_id);
		$brand = $this->booking_model->GetBookingbrand($inv['booking']['bkg_brandname']);
		$access = checkBrandaccess($inv['booking']['bkg_brandname'], 'invoice');
		if ($access) {
			$inv['token'] = _crypt($token);
			$inv['from'] = $from = agentbookingemail($bkg_id);
			$inv['from_name'] = $from_name = $inv['booking']['bkg_agent'];
			$inv['to'] = $to = $inv['booking']['cst_email'];
			$inv['to_name'] = $to_name = $inv['booking']['cst_name'];
			$message = $this->load->view('booking/ajax/inv_mail', $inv, TRUE);
			$inv['token'] = $token;
			$message2 = $this->load->view('booking/ajax/inv_mail', $inv, TRUE);
			$subject = $to_name . ', Booking Invoice and Terms & Conditions - ' . $bkg_id . '-' . $brand['brand_pre_post_fix'];
			$send_invoice = array(
				'from' => $this->mail_accounts,
				'from_title' => $this->mail_accounts_title,
				'to' => $to,
				'to_title' => $to_name,
				'reply_to' => $this->mail_accounts,
				'reply_to_title' => $this->mail_accounts_title,
				'cc' => '',
				'cc_title' => '',
				'bcc' => '',
				'bcc_title' => '',
				'subject' => $subject,
				'message' => $message,
				'attach' => '',
			);
			$result = master_mail($send_invoice);
			addlog($bkg_id, 'New invoice sent to : <strong class="text-dark">' . $to . '</strong>');
			if ($result) {
				$this->db->set('status', 'declined');
				$this->db->set('decline_datetime', date('Y-m-d H:i:s'));
				$this->db->where('bkgno', $bkg_id);
				$this->db->where_in('status', array('Open', 'Sent'));
				$this->db->update('sign_inv');
				$ins_data = array(
					'id' => '',
					'bkgno' => $bkg_id,
					'access_token' => $token,
					'status' => 'sent',
					'email' => $to,
					'sent_datetime' => date('Y-m-d H:i:s'),
					'open_datetime' => date(''),
					'sign_datetime' => date(''),
					'decline_datetime' => date(''),
					'loc_ip' => '',
				);
				$res = $this->db->insert('sign_inv', $ins_data);
				$response = array(
					'status' => 'success',
					'response' => 'Invoice Has been Sent Successfully..!!!'
				);
				$this->session->set_flashdata('notify', json_encode($response));
			} else {
				$response = array(
					'status' => 'error',
					'response' => 'There was some error please try again..!!!'
				);
				$this->session->set_flashdata('notify', json_encode($response));
			}
		} else {
			$response = array(
				'status' => 'error',
				'response' => "Access denied please contact your Manager..!!!"
			);
			$this->session->set_flashdata('notify', json_encode($response));
		}
		redirect(base_url('booking/invoice/' . hashing($bkg_id, 'e')), 'refresh');
	}
}