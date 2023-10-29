<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mailer_model extends CI_Model
{
	public function mail_ptask_delete($ptask_id = '')
	{
		$result = $this->db->select('*')->from('pendingpayments')->where('pid', $ptask_id)->get()->row_array();
		$payment_type = $result['payment_type'];
		$brand_name = $result['agentname'];
		$reason = $result['paymentdescription'];
		$bookingid = $result['bookingid'] . " - " . $result['agentcode'];
		$user_mail = agentbookingemail($result['bookingid']);
		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];
		$to = $user_mail;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand_mail .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand_mail;
		}
		$subject = $bookingid . ' – ' . $payment_type . ' Request Deleted';
		$msg = '
		<html>
			<body>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td style="font-size:14px">Dear ' . $brand_name . ',</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Your <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $payment_type . '</span> request for file no.<span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span> has been deleted. Due to the Following Reason: <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Regards,</td>
					</tr>
					<tr>
						<td style="font-size:14px">'. $this->mainbrand .'</td>
					</tr>
				</table>
			</body>
		</html>';
		$notify_mail = array(
			'from' => $this->mail_notification,
			'from_title' => $this->mail_notification_title,
			'to' => $to,
			'to_title' => '',
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => $cc,
			'cc_title' => '',
			'bcc' => '',
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $msg,
			'attach' => '',
		);
		master_mail($notify_mail);
	}
	public function mail_ptask_confirm($ptask_id = '')
	{
		$result = $this->db->select('*')->from('pendingpayments')->where('pid', $ptask_id)->get()->row_array();
		$bookingid = $result['bookingid'] . " - " . $result['agentcode'];
		$brand_name = $result['agentname'];
		$reason = $result['paymentdescription'];
		$bank_name = $result['bank_name'];
		$amount = $result['pamount'];
		$payment_type = $result['payment_type'];
		$user_id = $this->session->userdata('user_id');

		//$user = $this->db->select('user_work_email')->from('user_profile')->where('user_id',$user_id)->get()->row_array();
		$user_mail = agentbookingemail($result['bookingid']);

		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];

		$to = $user_mail;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand_mail .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand_mail;
		}
		if ($payment_type == 'Card Payment') {
			$subject = $bookingid . ' Card Charged Confirmation of GBP ' . $amount;
			$msg = '
			<html>
				<body>
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td style="font-size:14px">Dear ' . $brand_name . ',</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">
							Card has been processed for GBP <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $amount . '</span> for the File no. <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span>, Ref <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span>.
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">Regards,</td>
						</tr>
						<tr>
							<td style="font-size:14px">'. $this->mainbrand .'</td>
						</tr>
					</table>
				</body>
			</html>';
		} else if ($payment_type == 'Bank Payment') {
			$subject = $bookingid . ' Bank Payment Confirmation of GBP ' . $amount;
			$msg = '
			<html>
				<body>
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td style="font-size:14px">Dear ' . $brand_name . ',</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">
							Bank payment of GBP <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $amount . '</span> received in <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bank_name . '</span> for the File no. <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span> with Ref <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span>.
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">Regards,</td>
						</tr>
						<tr>
							<td style="font-size:14px">'. $this->mainbrand .'</td>
						</tr>
					</table>
				</body>
			</html>';
		} else if ($payment_type == 'Other') {
			$subject = $bookingid . ' Other Request Confirmation';
			$msg = '
			<html>
				<body>
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td style="font-size:14px">Dear ' . $brand_name . ',</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">
							Your Request has been processed for File no. <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span>.
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">Regards,</td>
						</tr>
						<tr>
							<td style="font-size:14px">'. $this->mainbrand .'</td>
						</tr>
					</table>
				</body>
			</html>';
		}
		$notify_mail = array(
			'from' => $this->mail_notification,
			'from_title' => $this->mail_notification_title,
			'to' => $to,
			'to_title' => '',
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => $cc,
			'cc_title' => '',
			'bcc' => '',
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $msg,
			'attach' => '',
		);
		master_mail($notify_mail);
	}
	public function mail_ptask_decline($ptask_id = '')
	{
		$result = $this->db->select('*')->from('pendingpayments')->where('pid', $ptask_id)->get()->row_array();
		$bookingid = $result['bookingid'] . " - " . $result['agentcode'];
		$brand_name = $result['agentname'];
		$reason = $result['paymentdescription'];
		$bank_name = $result['bank_name'];
		$amount = $result['pamount'];
		$payment_type = $result['payment_type'];
		$user_id = $this->session->userdata('user_id');

		// $user = $this->db->select('user_work_email')->from('user_profile')->where('user_id',$user_id)->get()->row_array();
		// $user_mail = $user['user_work_email'];		
		$user_mail = agentbookingemail($result['bookingid']);
		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];

		$to = $user_mail;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand_mail .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand_mail;
		}
		if ($payment_type == 'Card Payment' || $payment_type == '3D Card Payment Link') {
			$subject = $bookingid . '  Card Declined ';
			$msg = '
			<html>
				<body>
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td style="font-size:14px">Dear ' . $brand_name . ',</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">
							Your card has been declined for the File no. <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span>, Ref / Reason <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span>.
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">Regards,</td>
						</tr>
						<tr>
							<td style="font-size:14px">'. $this->mainbrand .'</td>
						</tr>
					</table>
				</body>
			</html>';
		} else if ($payment_type == 'Bank Payment') {
			$subject = $bookingid . ' Bank Payment Error';
			$msg = '
			<html>
				<body>
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td style="font-size:14px">Dear ' . $brand_name . ',</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">
							Your <span style=" color:#1B77C7; font-size:16px; font-weight:bold;"> ' . $bank_name . ' </span> Bank Payment for the File no. <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span> is not confirming, Reason <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span>.
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">Regards,</td>
						</tr>
						<tr>
							<td style="font-size:14px">'. $this->mainbrand .'</td>
						</tr>
					</table>
				</body>
			</html>';
		} else if ($payment_type == 'Other') {
			$subject = $bookingid . ' Other Request Declined';
			$msg = '
			<html>
				<body>
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td style="font-size:14px">Dear ' . $brand_name . ',</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">
							Your Request has been deleted for File no. <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . ' </span>with Ref / Reason <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span>.
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">Regards,</td>
						</tr>
						<tr>
							<td style="font-size:14px">'. $this->mainbrand .'</td>
						</tr>
					</table>
				</body>
			</html>';
		}
		$notify_mail = array(
			'from' => $this->mail_notification,
			'from_title' => $this->mail_notification_title,
			'to' => $to,
			'to_title' => '',
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => $cc,
			'cc_title' => '',
			'bcc' => '',
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $msg,
			'attach' => '',
		);
		master_mail($notify_mail);
	}
	public function mail_ttask_delete($ttask_id = '')
	{
		$result = $this->db->select('*')->from('pendingtickets')->where('tid', $ttask_id)->get()->row_array();
		$bookingid = $result['bookingid'] . " - " . $result['agentcode'];
		$brand_name = $result['agentname'];
		$reason = $result['message'];
		$supplier = $result['supplier'];
		$supplier_ref = $result['supplier_ref'];
		$gds = $result['gds'];
		$pnr = $result['pnr'];
		$ticket_cost = $result['ticket_cost'];
		$user_id = $this->session->userdata('user_id');

		// $user = $this->db->select('user_work_email')->from('user_profile')->where('user_id', $user_id)->get()->row_array();
		// $user_mail = $user['user_work_email'];
		$user_mail = agentbookingemail($result['bookingid']);

		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];

		$to = $user_mail;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand;
		}

		$subject = $bookingid . ' – Ticket Order Deleted';
		$msg = '
		<html>
			<body>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td style="font-size:14px">Dear ' . $brand_name . ',</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">
							Your Ticket Order for file no.<span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span> has been deleted for the following reason : <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span>.
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Regards,</td>
					</tr>
					<tr>
						<td style="font-size:14px">'. $this->mainbrand .'</td>
					</tr>
				</table>
			</body>
		</html>';
		$notify_mail = array(
			'from' => $this->mail_notification,
			'from_title' => $this->mail_notification_title,
			'to' => $to,
			'to_title' => '',
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => $cc,
			'cc_title' => '',
			'bcc' => '',
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $msg,
			'attach' => '',
		);
		master_mail($notify_mail);
	}
	public function mail_ttask_decline($ttask_id = '')
	{
		$result = $this->db->select('*')->from('pendingtickets')->where('tid', $ttask_id)->get()->row_array();
		$bookingid = $result['bookingid'] . " - " . $result['agentcode'];
		$brand_name = $result['agentname'];
		$reason = $result['message'];
		$supplier = $result['supplier'];
		$supplier_ref = $result['supplier_ref'];
		$gds = $result['gds'];
		$pnr = $result['pnr'];
		$ticket_cost = $result['ticket_cost'];
		$user_id = $this->session->userdata('user_id');

		// $user = $this->db->select('user_work_email')->from('user_profile')->where('user_id', $user_id)->get()->row_array();
		// $user_mail = $user['user_work_email'];
		$user_mail = agentbookingemail($result['bookingid']);

		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];

		$to = $user_mail;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand_mail .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand_mail;
		}

		$subject = $bookingid . ' – Ticket Order Declined';
		$msg = '
		<html>
			<body>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td style="font-size:14px">Dear ' . $brand_name . ',</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">
							Your Ticket Order for file no.<span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span> has been declined for the following reason : <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span>.
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Regards,</td>
					</tr>
					<tr>
						<td style="font-size:14px">'. $this->mainbrand .'</td>
					</tr>
				</table>
			</body>
		</html>';
		$notify_mail = array(
			'from' => $this->mail_notification,
			'from_title' => $this->mail_notification_title,
			'to' => $to,
			'to_title' => '',
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => $cc,
			'cc_title' => '',
			'bcc' => '',
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $msg,
			'attach' => '',
		);
		master_mail($notify_mail);
	}
	public function mail_ttask_confirm($ttask_id = '')
	{
		$result = $this->db->select('*')->from('pendingtickets')->where('tid', $ttask_id)->get()->row_array();
		$bookingid = $result['bookingid'] . " - " . $result['agentcode'];
		$brand_name = $result['agentname'];
		$type = $result['type'];
		$user_mail = agentbookingemail($result['bookingid']);
		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];

		$to = $user_mail;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand_mail .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand_mail;
		}

		$subject = $bookingid . ' – ' . $type . ' Issuance Request Confirmation';
		$msg = '
		<html>
			<body>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td style="font-size:14px">Dear ' . $brand_name . ',</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">
							Your ' . $type . ' issuance request for file no. <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span> has been confirmed. For further details, Pls check Panel. Thanks.
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Regards,</td>
					</tr>
					<tr>
						<td style="font-size:14px">'. $this->mainbrand .'</td>
					</tr>
				</table>
			</body>
		</html>';
		$notify_mail = array(
			'from' => $this->mail_notification,
			'from_title' => $this->mail_notification_title,
			'to' => $to,
			'to_title' => '',
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => $cc,
			'cc_title' => '',
			'bcc' => '',
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $msg,
			'attach' => '',
		);
		master_mail($notify_mail);
	}
	public function mail_ptask_add($form = '')
	{
		$bookingid = $form['bookingid'] . " - " . $form['agentcode'];
		$brand_name = $form['agentname'];
		$reason = $form['req_note'];
		$bank_name = $form['req_payment_bank'];
		$amount = $form['req_amount'];
		$payment_type = $form['req_payment_type'];
		$user_id = $this->session->userdata('user_id');	
		$user_mail = agentbookingemail($form['bookingid']);
		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];
		$to = $user_mail;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand_mail .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand_mail;
		}
		if ($payment_type == 'Card Payment' || $payment_type == '3D Card Payment Link') {
			$subject = $bookingid . '  Card Charge Request Sent for GBP ' . $amount;
			$msg = '
			<html>
				<body>
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td style="font-size:14px">Dear ' . $brand_name . ',</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">
							Your card charge request has been sent for <span style=" color:#1B77C7; font-size:16px; font-weight:bold;"> GBP ' . $amount . '</span> for the File no. <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span>, Ref <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span>.
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">Regards,</td>
						</tr>
						<tr>
							<td style="font-size:14px">'. $this->mainbrand .'</td>
						</tr>
					</table>
				</body>
			</html>';
		} else if ($payment_type == 'Bank Payment') {
			$subject = $bookingid . ' Bank Payment Request Sent for GBP ' . $amount;
			$msg = '
			<html>
				<body>
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td style="font-size:14px">Dear ' . $brand_name . ',</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">
							Your <span style=" color:#1B77C7; font-size:16px; font-weight:bold;"> ' . $bank_name . ' </span> Bank payment request has been sent for <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">GBP ' . $amount . '</span> for the File no. <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span>, Ref <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span>.
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">Regards,</td>
						</tr>
						<tr>
							<td style="font-size:14px">'. $this->mainbrand .'</td>
						</tr>
					</table>
				</body>
			</html>';
		} else if ($payment_type == 'Other') {
			$subject = $bookingid . ' Other Request Sent.';
			$msg = '
			<html>
				<body>
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td style="font-size:14px">Dear ' . $brand_name . ',</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">
							Your request has been sent for <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">GBP ' . $amount . '</span> for the File no. <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $bookingid . '</span>, Ref <span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $reason . '</span>.
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:14px">Regards,</td>
						</tr>
						<tr>
							<td style="font-size:14px">'. $this->mainbrand .'</td>
						</tr>
					</table>
				</body>
			</html>';
		}
		$notify_mail = array(
			'from' => $this->mail_notification,
			'from_title' => $this->mail_notification_title,
			'to' => $to,
			'to_title' => '',
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => $cc,
			'cc_title' => '',
			'bcc' => '',
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $msg,
			'attach' => '',
		);
		master_mail($notify_mail);
	}
	public function mail_ttask_add($form = '')
	{
		$priority = $form['priority'];
		$bookingid = $form['bookingid'] . " " . $form['agentcode'];
		$brand_name = $form['agentname'];
		$reason = $form['issuance_note'];
		$supplier = $form['supplier'];
		$supplier_ref = $form['sup_ref'];
		if (isset($form['flt_gds'])) {
			$gds = $form['flt_gds'];
		} else {
			$gds = false;
		}
		if (isset($form['flt_pnr'])) {
			$pnr = $form['flt_pnr'];
		} else {
			$pnr = false;
		}
		$instructions = $form['issuance_note'] ;
		$ticket_cost = $form['cost'];
		$user_mail = agentbookingemail($form['bookingid']);
		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];
		$to = $user_mail;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand_mail .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand_mail;
		}
		$subject = $bookingid . ' - Ticket Order Sent ' . $supplier_ref;
		$msg = '
		<html>
			<body>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td style="font-size:14px">Hi,</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">
							<table cellpadding="0" cellspacing="0" width="70%" border="0">
								<tr>
									<td colspan="3">Please issue the below.</td>
								</tr>
								<tr>
									<td width="25%">Supplier</td>
									<td width="05%" align="center">:</td>
									<td width="70%" align="left">
										<span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $supplier . '</span>
									</td>
								</tr>
								<tr>
									<td width="25%">Supplier Ref#</td>
									<td width="05%" align="center">:</td>
									<td width="70%" align="left">
										<span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $supplier_ref . '</span>
									</td>
								</tr>';
		if ($gds != false && $pnr != false) {
			$msg .= '				
								<tr>
									<td width="25%">Booking GDS</td>
									<td width="05%" align="center">:</td>
									<td width="70%" align="left">
										<span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $gds . '</span>
									</td>
								</tr>
								<tr>
									<td width="25%">Flight PNR</td>
									<td width="05%" align="center">:</td>
									<td width="70%" align="left">
										<span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $pnr . '</span>
									</td>
								</tr>';
		}
		$msg .= '				
								<tr>
									<td width="25%">Issuance Cost</td>
									<td width="05%" align="center">:</td>
									<td width="70%" align="left">
										<span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $ticket_cost . '</span>
									</td>
								</tr>
								<tr>
									<td width="25%">Instruction</td>
									<td width="05%" align="center">:</td>
									<td width="70%" align="left">
										<span style=" color:#1B77C7; font-size:16px; font-weight:bold;">' . $instructions . '</span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Regards,</td>
					</tr>
					<tr>
						<td style="font-size:14px">'. $this->mainbrand .'</td>
					</tr>
				</table>
			</body>
		</html>';
		if ($form['supplier_mail'] != '') {
			$to .= ',' . $form['supplier_mail'];
			$notify_mail_tktorder = array(
				'from' => $this->mail_accounts,
				'from_title' => $this->mail_accounts_title,
				'to' => $to,
				'to_title' => '',
				'reply_to' => $this->mail_accounts,
				'reply_to_title' => $this->mail_accounts_title,
				'cc' => $cc,
				'cc_title' => '',
				'bcc' => '',
				'bcc_title' => '',
				'subject' => $subject,
				'message' => $msg,
				'attach' => '',
			);
			master_mail($notify_mail_tktorder);
		} else {
			$notify_mail = array(
				'from' => $this->mail_notification,
				'from_title' => $this->mail_notification_title,
				'to' => $to,
				'to_title' => '',
				'reply_to' => $this->mail_accounts,
				'reply_to_title' => $this->mail_accounts_title,
				'cc' => $cc,
				'cc_title' => '',
				'bcc' => '',
				'bcc_title' => '',
				'subject' => $subject,
				'message' => $msg,
				'attach' => '',
			);
			master_mail($notify_mail);
		}
	}
	public function mail_send_payemtlink($data = '')
	{
		$brand_name = $data['brand'];
		$bkg_id = $data['bkg_id'];
		$bkg_id_en = $data['bkgRef'];
		$amount = $data['amount'];
		$amount_en = $data['amt'];
		$cust_name = $data['cust_name'];
		$cust_email = $data['cust_email'];
		$msg = $data['msg'];
		$link = $data['pmtURL'];
		$pnr = $data['pnr'];

		$user_id = $this->session->userdata('user_id');

		// $user = $this->db->select('user_work_email')->from('user_profile')->where('user_id', $user_id)->get()->row_array();
		// $user_mail = $user['user_work_email'];

		$user_mail = agentbookingemail($data['bkg_id']);

		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];

		$subject = "$cust_name, Make Payment For Your Invoice # $bkg_id";
		$mail_msg = '
		<html>
			<body>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td style="font-size:14px">Dear ' . $cust_name . ',</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">
							<p style="font-family: arial;">
								' . $brand_name . ' has sent a payment request for the below booking you have made.<br><br>
								Message : ' . $msg . '<br>
								Booking Confirmation : ' . $pnr . '<br> 
								Total Payable amount:  &pound;' . $amount . '<br><br>
								Please could you check the above details and click to <b><a href="' . $link . '">Pay Now</a></b>. 
								This link will take you through Our Secure Payment Gateway.
							</p>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Regards,</td>
					</tr>
					<tr>
						<td style="font-size:14px">'. $this->mainbrand .'</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>
						<p style="color: #b9b3b3;">
						This message is intended only for the person or entity to which it is addressed and may contain confidential and/or privileged information. If you have received this message in error, please notify the sender immediately and delete this message from your system. Reasonable precautions have been taken to ensure that this message is virus-free. However, we do not accept any responsibility for any loss or damage arising from the use of this message or attachments.</p>
						</td>
					</tr>
				</table>
			</body>
		</html>';
		$to = $cust_email;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand_mail . ',' . $user_mail .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand_mail . ',' . $user_mail;
		}
		$link_mail = array(
			'from' => $this->mail_payments,
			'from_title' => $this->mail_payments_title,
			'to' => $to,
			'to_title' => '',
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => $cc,
			'cc_title' => '',
			'bcc' => '',
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $mail_msg,
			'attach' => '',
		);
		master_mail($link_mail);
		return 'true';
	}
	public function mail_send_reminder($data = '')
	{
		$brand_name = $data['brand'];
		$bkg_id = $data['bkg_id'];
		$cust_email = $data['email'];
		$due_date = $data['due_date'];
		$pending_amt = $data['pending_amt'];
		$cust_name = $data['cust_name'];

		$user_id = $this->session->userdata('user_id');
		// $user = $this->db->select('user_work_email')->from('user_profile')->where('user_id', $user_id)->get()->row_array();
		// $user_mail = $user['user_work_email'];
		$user_mail = agentbookingemail($data['bkg_id']);

		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];

		$subject = "$cust_name, Payment Reminder For Your Invoice # $bkg_id";
		$mail_msg = '
		<html>
			<body>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td style="font-size:14px">Dear ' . $cust_name . ',</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">
							<p style="font-family: arial;">
								This is to remind you that your balance payment of £' . $pending_amt . ' is due on ' . $due_date . ' against your invoice no. ' . $bkg_id . '. Kindly make the payment ASAP to avoid any disappointment.<br><br>
								Need further help? Pls call to your relevant sale person.
							</p>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Regards,</td>
					</tr>
					<tr>
						<td style="font-size:14px">'. $this->mainbrand .'</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>
						<p style="color: #b9b3b3;">
						This message is intended only for the person or entity to which it is addressed and may contain confidential and/or privileged information. If you have received this message in error, please notify the sender immediately and delete this message from your system. Reasonable precautions have been taken to ensure that this message is virus-free. However, we do not accept any responsibility for any loss or damage arising from the use of this message or attachments.</p>
						</td>
					</tr>
				</table>
			</body>
		</html>';
		$to = $cust_email;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand_mail . ',' . $user_mail .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand_mail . ',' . $user_mail;
		}
		$link_mail = array(
			'from' => $this->mail_payments,
			'from_title' => $this->mail_payments_title,
			'to' => $to,
			'to_title' => '',
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => $cc,
			'cc_title' => '',
			'bcc' => '',
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $mail_msg,
			'attach' => '',
		);
		master_mail($link_mail);
		return 'true';
	}
	public function mail_send_payment_notification($data = '')
	{
		$brand_name = $data['brand'];
		$bkg_id = $data['bkg_id'];
		$cust_email = $data['email'];
		$trans_id = $data['trans_id'];
		$trans_cnt = $data['trans_cnt'];
		$trans_by_to = $data['trans_by_to'];
		$trans_type = $data['trans_type'];
		$trans_date = $data['trans_date'];
		$amt = $data['amt'];
		$cust_name = $data['cust_name'];

		// get head mode  
		$this->db->select('trans_head_mode');
		$this->db->from('transaction_heads');
		$this->db->where('trans_head', $trans_by_to);
		$rowpmtmode = $this->db->get()->row_array();

		$sbjct = "";
		$msg = "";
		// checking head mode and transaction type and creating subject
		// and message for notification email accordingly
		if ($rowpmtmode['trans_head_mode'] == 'bank' && $trans_type == 'Cr') {
			$sbjct = "Bank Payment Notification - $trans_id / $bkg_id";
			$msg = "This is just to notify you that we have received &pound;$amt in our bank account on $trans_date for your invoice no. $bkg_id<br>Need further help, Pls call to your relevant sale person. Thanks.";
		} elseif ($rowpmtmode['trans_head_mode'] == 'card' && $trans_type == 'Cr') {
			$sbjct = "Card Payment Notification - $trans_id / $bkg_id";
			$msg = "This is just to notify you that we have charged your card for &pound;$amt on $trans_date for your invoice no. $bkg_id<br>Need further help, Pls call to your relevant sale person. Thanks.";
		} elseif ($rowpmtmode['trans_head_mode'] == 'bank' && $trans_type == 'Dr') {
			$sbjct = "Bank Refund Notification - $trans_id / $bkg_id";
			$msg = "This is just to notify you that we have refunded &pound;$amt into your bank on $trans_date against your invoice no. $bkg_id<br>Need further help, Pls call to your relevant sale person. Thanks.";
		} elseif ($rowpmtmode['trans_head_mode'] == 'card' && $trans_type == 'Dr') {
			$sbjct = "Card Refund Notification - $trans_id / $bkg_id";
			$msg = "This is just to notify you that we have refunded &pound;$amt into your card on $trans_date against your invoice no. $bkg_id<br>Need further help, Pls call to your relevant sale person. Thanks.";
		}

		$user_id = $this->session->userdata('user_id');
		// $user = $this->db->select('user_work_email')->from('user_profile')->where('user_id', $user_id)->get()->row_array();
		// $user_mail = $user['user_work_email'];

		$user_mail = agentbookingemail($data['bkg_id']);

		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];

		$subject = $sbjct;
		$mail_msg = '
		<html>
			<body>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td style="font-size:14px">Dear ' . $cust_name . ',</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">
							<p style="font-family: arial;">
								' . $msg . '
							</p>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Regards,</td>
					</tr>
					<tr>
						<td style="font-size:14px">'. $this->mainbrand .'</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>
						<p style="color: #b9b3b3;">
						This message is intended only for the person or entity to which it is addressed and may contain confidential and/or privileged information. If you have received this message in error, please notify the sender immediately and delete this message from your system. Reasonable precautions have been taken to ensure that this message is virus-free. However, we do not accept any responsibility for any loss or damage arising from the use of this message or attachments.</p>
						</td>
					</tr>
				</table>
			</body>
		</html>';
		$to = $cust_email;
		if ($brand_mail != $this->mail_accounts) {
			$cc = $brand_mail . ',' . $user_mail .  ',' . $this->mail_accounts;
		} else {
			$cc = $brand_mail . ',' . $user_mail;
		}
		$link_mail = array(
			'from' => $this->mail_payments,
			'from_title' => $this->mail_payments_title,
			'to' => $to,
			'to_title' => '',
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => $cc,
			'cc_title' => '',
			'bcc' => '',
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $mail_msg,
			'attach' => '',
		);
		master_mail($link_mail);
		$this->db->set('notification', 1);
		$this->db->where('trans_cnt', $trans_cnt);
		$this->db->update('transactions');
		return 'true';
	}
	public function mail_send_etkt($data = '')
	{
		$bkg_id = $data['bkg_id'];
		$brand = $data['brand'];
		$from_email = $data['from_email'];
		$from_name = $data['from_name'];
		$to_email = $data['to_email'];
		$to_name = $data['to_name'];
		$email_subject = $data['email_subject'];
		$msg = $data['msg'];
		$files = $_FILES['email_att'];
		$user_id = $this->session->userdata('user_id');

		$config = array();
		$config['upload_path'] = "./uploads/file_data"; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|csv|txt|doc|docx|rar|zip|svg|xml|GIF|JPG|PNG|JPEG|PDF|DOC|XML|DOCX|xls|xlsx|CSV|TXT|SVG';
		$config['max_size'] = 10000;
		$config['file_ext_tolower'] = true;
		$this->load->library('upload', $config);
		$files_array = array();
		$att_files = array();
		if (!empty($files['name'])) {
			foreach ($files['name'] as $key => $file) {
				$_FILES['files_array[]']['name'] = $files['name'][$key];
				$_FILES['files_array[]']['type'] = $files['type'][$key];
				$_FILES['files_array[]']['tmp_name'] = $files['tmp_name'][$key];
				$_FILES['files_array[]']['error'] = $files['error'][$key];
				$_FILES['files_array[]']['size'] = $files['size'][$key];
				if ($key == 0) {
					$fileName = "E-Ticket_Ref_" . $bkg_id . "-" . date("d_M_Y-h_i_A");
				} else {
					$fileName = "E-Ticket_Ref_" . $bkg_id . "_" . $key . "-" . date("d_M_Y-h_i_A");
				}
				$files_array[] = $fileName;
				$config['file_name'] = $fileName;
				$this->upload->initialize($config);
				if ($this->upload->do_upload('files_array[]')) {
					$dat = $this->upload->data();
					$cmt = 'E-Ticket has been sent to: <strong class="text-dark">' . $to_email . '</strong> with ' . count($dat['file_name']) . ' Files';
					addlog($bkg_id, $cmt);
					$this->db->set('booking_id', $bkg_id)->set('file_name', $dat['file_name'])->insert('booking_file');
					$att_files[] = $dat['file_name'];
				} else {
					return false;
				}
			}
		}
		$mail_msg = '
		<html>
			<body style="font-family: arial">
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td style="font-size:14px;">Dear ' . $to_name . ',</td>
					</tr>
					<tr>
						<td style="font-size:14px;">&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">
							<p>
								' . nl2br($msg) . '
							</p>
						</td>
					</tr>
					<tr>
						<td><i>You may like our page on facebook page https://www.facebook.com</i></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Regards,</td>
					</tr>
					<tr>
						<td style="font-size:14px">
							<strong>' . $from_name . ',</strong><br>
							'.$this->mainbrand.'
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>
							<p style="color: #b9b3b3;">This message is intended only for the person or entity to which it is addressed and may contain confidential and/or privileged information. If you have received this message in error, please notify the sender immediately and delete this message from your system. Reasonable precautions have been taken to ensure that this message is virus-free. However, we do not accept any responsibility for any loss or damage arising from the use of this message or attachments.</p>
						</td>
					</tr>
				</table>
			</body>
		</html>';
		$etkt_mail = array(
			'from' => $from_email,
			'from_title' => $from_name,
			'to' => $to_email,
			'to_title' => $to_name,
			'reply_to' => $from_email,
			'reply_to_title' => $from_name,
			'cc' => '',
			'cc_title' => '',
			'bcc' => $from_email,
			'bcc_title' => $from_name,
			'subject' => $email_subject,
			'message' => $mail_msg,
			'attach' => $att_files,
		);
		return etkt_mail($etkt_mail);
	}
	public function mail_send_review_invitation($data = '')
	{
		$bkg_no = $data['bkg_no'];
		$bkg_brandname = $data['bkg_brandname'];
		$agent_name = $data['agent_name'];
		$agent_email = $data['agent_email'];
		$cust_name = $data['cust_name'];
		$cust_email = $data['cust_email'];
		$subject = $data['cust_name'] . ", Rate us about your recent interaction - " . $bkg_no;
		$mail_msg = '
		<html>
			<body>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td style="font-size:14px">Dear ' . $cust_name . ',</td>
					</tr>
					<tr>
						<td style="font-size:14px">&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Thanks for your recent interaction with “'. $this->mainbrand .'”.<br><br>We would love to know about your experience. So, our Review Company' . "'s" . ' System has sent you another separate email. Please check it and post your review as your review is important to us. Thanks for your time.
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="font-size:14px">Best Regards,</td>
					</tr>
					<tr>
						<td style="font-size:14px">
							<strong>' . $agent_name . ',</strong><br>
							'. $this->mainbrand .'
						</td>
					</tr>
				</table>
			</body>
		</html>';
		$reviewsend_mail = array(
			'from' => $this->mail_accounts,
			'from_title' => $this->mail_accounts_title,
			'to' => $cust_email,
			'to_title' => $cust_name,
			'reply_to' => $this->mail_accounts,
			'reply_to_title' => $this->mail_accounts_title,
			'cc' => '',
			'cc_title' => '',
			'bcc' => $this->link_review_trustpilot,
			'bcc_title' => '',
			'subject' => $subject,
			'message' => $mail_msg,
			'attach' => '',
		);
		return master_mail($reviewsend_mail);
	}
}
/* End of file Mailer_model.php */
/* Location: ./application/models/Mailer_model.php */
