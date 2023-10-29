<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pending_task_model extends CI_Model
{

	public function getPaytasks($p_id = '', $agent = false, $brand = false)
	{
		$this->db->select('pp.*');
		$this->db->from('pendingpayments pp');
		$this->db->where('pp.pstatus', 0);
		if ($brand != false && $brand != '') {
			$this->db->where('pp.agentname', $brand);
		}
		if ($agent != false && $agent != '') {
			$this->db->join('bookings bkg', 'bkg.bkg_no = pp.bookingid', 'left');
			$this->db->where('bkg.bkg_agent', $agent);
		}
		if ($p_id != '') {
			$this->db->where('pp.pid', $p_id);
			return $this->db->get()->row_array();
		} else {
			$this->db->order_by('pp.timestamp', 'asc');
			return $this->db->get()->result_array();
		}
	}
	public function getTkttasks($t_id = '', $agent = false, $brand = false)
	{
		$this->db->select('pt.*');
		$this->db->from('pendingtickets pt');
		$this->db->where('pt.ticket_status', 0);
		if ($brand != false && $brand != '') {
			$this->db->where('pt.agentname', $brand);
		}
		if ($agent != false && $agent != '') {
			$this->db->join('bookings bkg', 'bkg.bkg_no = pt.bookingid', 'left');
			$this->db->where('bkg.bkg_agent', $agent);
		}
		if ($t_id != '') {
			$this->db->where('pt.tid', $t_id);
			return $this->db->get()->row_array();
		} else {
			$this->db->order_by('pt.priority', 'asc');
			$this->db->order_by('pt.timestamp', 'asc');
			return $this->db->get()->result_array();
		}
	}
	public function deletePaytask($data)
	{
		$this->db->select('*');
		$this->db->from('pendingpayments');
		$this->db->where('pid', $data['pid']);
		$result = $this->db->get();
		$rows = $result->num_rows();
		if ($rows > 0) {
			$result = $result->row_array();
			if ($result['payment_type'] != 'Other') {
				if ($data['task_method'] == 'declined' && $result['payment_type'] == '3D Card Payment Link') {
					$msg = $result['payment_type'] . ' Request amounting <strong class="text-dark">&pound; ' . $result['pamount'] . '</strong> has been cancelled. Remark: <strong class="text-dark">' . $data['reason'] . '</strong>';
				} else {
					$msg = $result['payment_type'] . ' Request amounting <strong class="text-dark">&pound; ' . $result['pamount'] . '</strong> has been ' . $data['task_method'] . '. Remark: <strong class="text-dark">' . $data['reason'] . '</strong>';
				}
			} elseif ($result['payment_type'] == 'Other') {
				$msg = 'Other Request amounting <strong class="text-dark">&pound; ' . $result['pamount'] . '</strong>, Ref: <strong class="text-dark">' . $result['paymentdescription'] . '</strong>, has been ' . $data['task_method'] . '. Remark: <strong class="text-dark">' . $data['reason'] . '</strong>';
			}
			addlog($result['bookingid'], $msg);

			$this->db->set('paymentdescription', $data['reason']);
			$this->db->set('pstatus', '1');
			$this->db->where('pid', $data['pid']);
			$this->db->update('pendingpayments');
			$num = $this->db->affected_rows();
			if ($num > 0) {
				return 'true';
			} else {
				return 'false';
			}
		}
	}
	public function confirmOtherTask($data)
	{
		$this->db->select('*');
		$this->db->from('pendingpayments');
		$this->db->where('pid', $data['pid']);
		$result = $this->db->get();
		$rows = $result->num_rows();
		if ($rows > 0) {
			$result = $result->row_array();
			$msg = 'Other Request amounting <strong class"text-dark">&pound; ' . $result['pamount'] . '</strong>, Ref: <strong class"text-dark">' . $result['paymentdescription'] . '</strong>, has been processed. Remark: <strong class="text-dark">' . $data['reason'] . '</strong>';
			//$msg= 'Your other request has been processed, Remarks: <span class="text-success">'.$data['reason'].'</span>';
			addlog($result['bookingid'], $msg);

			$this->db->set('paymentdescription', $data['reason']);
			$this->db->set('pstatus', '1');
			$this->db->where('pid', $data['pid']);
			$this->db->update('pendingpayments');
			$num = $this->db->affected_rows();
			if ($num > 0) {
				return 'true';
			} else {
				return 'false';
			}
		}
	}
	public function deletettask($data)
	{
		$this->db->select('*');
		$this->db->from('pendingtickets');
		$this->db->where('tid', $data['tid']);
		$result = $this->db->get();
		$rows = $result->num_rows();
		if ($rows > 0) {
			$result = $result->row_array();
			$msg = 'Issuance Request has been ' . $data['task_method'] . '. Remark: <strong class="text-dark">' . $data['reason'] . '</strong>';
			addlog($result['bookingid'], $msg);

			$this->db->set('message', $data['reason']);
			$this->db->set('ticket_status', '1');
			$this->db->where('tid', $data['tid']);
			$this->db->update('pendingtickets');
			$num = $this->db->affected_rows();
			if ($num > 0) {
				return 'true';
			} else {
				return 'false';
			}
		}
	}
	public function confirmPaytask($pid = '', $reason = '')
	{
		$this->db->set('paymentdescription', $reason);
		$this->db->set('pstatus', '1');
		$this->db->where('pid', $pid);
		$this->db->update('pendingpayments');
		$num = $this->db->affected_rows();
		if ($num > 0) {
			$this->db->select('*');
			$this->db->where('pid', $pid);
			$this->db->from('pendingpayments');
			$id = $this->db->get()->row_array();
			$data['status'] = true;
			$data['bkg_id'] = hashing($id['bookingid']);
			$logmsg = $id['payment_type'] . " Request Confirmation amounting <strong class='text-dark'>&pound; " . $id['pamount'] . "</strong>";
			addlog($id['bookingid'], $logmsg);
		} else {
			$data['status'] = false;
		}
		return $data;
	}
	public function confirmtkttask($pid = '')
	{
		$this->db->set('ticket_status', '1');
		$this->db->where('tid', $pid);
		$this->db->update('pendingtickets');
		$num = $this->db->affected_rows();
		if ($num > 0) {
			$this->db->select('*');
			$this->db->where('tid', $pid);
			$this->db->from('pendingtickets');
			$id = $this->db->get()->row_array();
			$data['status'] = 'true';
			$data['bkg_id'] = hashing($id['bookingid']);
			if ($id['type'] == 'flight') {
				$logmsg = '<strong class="text-dark">Flight</strong> Issuance Request Confirmation.';
			} else if ($id['type'] == 'hotel') {
				$logmsg = '<strong class="text-dark">Hotel</strong> Issuance Request Confirmation.';
			} else if ($id['type'] == 'cab') {
				$logmsg = '<strong class="text-dark">Cab</strong> Issuance Request Confirmation.';
			}
			addlog($id['bookingid'], $logmsg);
		} else {
			$data['status'] = 'false';
		}
		return $data;
	}
}

/* End of file pending_task_model.php */
/* Location: ./application/models/pending_task_model.php */
