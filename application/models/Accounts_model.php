<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class Accounts_model extends CI_Model
{
	public function GetTransHead($head = '')
	{
		$this->db->select('*');
		$this->db->from('transaction_heads');
		$this->db->where('trans_head_status', 1);
		$this->db->order_by('trans_head', 'asc');
		if ($head != '') {
			$this->db->where('trans_head', $head);
			return $this->db->get()->row_array();
		} else {
			return $this->db->get()->result_array();
		}
	}
	public function Getheadowners($head_mode = false, $head_type = false)
	{
		$this->db->select('owner as head,trans_head_mode,type');
		$this->db->from('transaction_heads');
		if ($head_mode) {
			$this->db->where_in('trans_head_mode', $head_mode);
		}
		if ($head_type) {
			$this->db->where_in('type', $head_type);
		}
		$this->db->group_by('owner');
		$this->db->order_by('owner', 'asc');
		$this->db->where('trans_head_status', '1');
		return $this->db->get()->result_array();
	}
	public function Getheads($head_mode = false, $head_type = false)
	{
		$this->db->select('trans_head as head,trans_head_mode,type');
		$this->db->from('transaction_heads');
		if ($head_mode) {
			$this->db->where_in('trans_head_mode', $head_mode);
		}
		if ($head_type) {
			$this->db->where_in('type', $head_type);
		}
		$this->db->where('trans_head_status', '1');
		$this->db->order_by('trans_head', 'asc');
		return $this->db->get()->result_array();
	}
	public function GetHeadCharges($head = '', $brand = '', $agent = '')
	{
		$this->db->select('cr_charges,dr_charges,charges_type');
		$this->db->from('trans_head_charges');
		$this->db->where('trans_head', $head);
		$this->db->where('brand_name', $brand);
		$this->db->where('agent_name', $agent);
		$result = $this->db->get();
		$rows = $result->num_rows();
		if ($rows > 0) {
			return $result->result_array();
		} else {
			$this->db->select('cr_charges,dr_charges,charges_type');
			$this->db->from('trans_head_charges');
			$this->db->where('trans_head', $head);
			$this->db->where('brand_name', $brand);
			$this->db->where('agent_name', null);
			$result = $this->db->get();
			$rows = $result->num_rows();
			if ($rows > 0) {
				return $result->result_array();
			} else {
				$this->db->select('cr_charges,dr_charges,charges_type');
				$this->db->from('trans_head_charges');
				$this->db->where('trans_head', $head);
				$this->db->where('brand_name', null);
				$this->db->where('agent_name', null);
				$result = $this->db->get();
				$rows = $result->num_rows();
				if ($rows > 0) {
					return $result->result_array();
				} else {
					return "no charges";
				}
			}
		}
	}
	public function GetBkg($bkg_id = '')
	{
		$this->db->select('bkg_brandname,bkg_agent');
		$this->db->from('bookings');
		if ($bkg_id != '') {
			$this->db->where('bkg_no', $bkg_id);
		}
		return $this->db->get()->row_array();
	}
	public function AddTransaction($data_rec = false)
	{
		if ($data_rec) {
			$data = $data_rec;
		} else {
			$data = $this->input->post();
		}
		$query_trans_id = $this->db->select('max(trans_id) as max_id')->from('transactions')->get()->row_array();
		$nexttransid = $query_trans_id['max_id'] + 1;
		$nexttransidx = $query_trans_id['max_id'] + 2;
		$drcounter = count($data["dr"]['trans_bkg_ref']);
		$crcounter = count($data["cr"]['trans_bkg_ref']);
		for ($i = 0; $i < $drcounter; $i++) {
			if ($data['cr']['trans_by'][0] == "Customer") {
				$head_dtl = $this->GetTransHead($data['dr']['trans_to'][$i]);
				$bkg_dtl = $this->GetBkg($data['dr']['trans_bkg_ref'][$i]);
				$head_chrgs = $this->GetHeadCharges($head_dtl['trans_head'], @$bkg_dtl['bkg_brandname'], @$bkg_dtl['bkg_agent']);
				if ($head_chrgs != 'no charges') {
					if ($head_dtl['type'] == '1') {
						if ($head_dtl["trans_head_mode"] == 'bank' || $head_dtl["trans_head_mode"] == 'cash') {
							$charges = 0;
							foreach ($head_chrgs as $key => $head_chrg) {
								if ($head_chrg['charges_type'] == 'percentage') {
									$p_chrg = (float)$data['dr']['amount'][$i] * (float)((float)$head_chrg['dr_charges'] / 100);
									$charges += $p_chrg;
								} elseif ($head_chrg['charges_type'] == 'fixed') {
									$charges += $head_chrg['dr_charges'];
								}
							}
							$this->db->set('trans_id', $nexttransidx)
								->set('trans_date', date('Y-m-d', strtotime($data['trans_date'])))
								->set('trans_ref',  $data['dr']['trans_bkg_ref'][$i])
								->set('trans_head', 'Bank Charges Payable')
								->set('trans_by_to', 'Bank Charges')
								->set('trans_description', 'Automated bank charges')
								->set('trans_amount', $charges)
								->set('trans_type', 'Cr')
								->set('trans_created_date', date('Y-m-d H:i:s'))
								->set('trans_created_by', 'System')
								->insert('transactions');
							$this->db->set('trans_id', $nexttransidx)
								->set('trans_date', date('Y-m-d', strtotime($data['trans_date'])))
								->set('trans_ref',  $data['dr']['trans_bkg_ref'][$i])
								->set('trans_head', 'Bank Charges')
								->set('trans_by_to', 'Bank Charges Payable')
								->set('trans_description', 'Automated bank charges')
								->set('trans_amount', $charges)
								->set('trans_type', 'Dr')
								->set('trans_created_date', date('Y-m-d H:i:s'))
								->set('trans_created_by', 'System')
								->insert('transactions');
							$nexttransidx = (int)$nexttransidx + 1;
							//updating bank charges box
							for ($a = 0; $a <= $crcounter; $a++) {
								if (@$data['cr']['trans_by'][$a] == "Customer") {
									$bkg_dtl_cr = $this->GetBkg($data['cr']['trans_bkg_ref'][$a]);
									$head_chrgs_cr = $this->GetHeadCharges($head_dtl['trans_head'], @$bkg_dtl_cr['bkg_brandname'], @$bkg_dtl_cr['bkg_agent']);
									$bank_charges_cr = 0;
									if ($head_chrgs_cr != 'no charges') {
										foreach ($head_chrgs_cr as $key => $head_chrg_cr) {
											if ($head_chrg_cr['charges_type'] == 'percentage') {
												$p_chrg = (float)$data['cr']['amount'][$a] * (float)((float)$head_chrg_cr['dr_charges'] / 100);
												$bank_charges_cr += $p_chrg;
											} elseif ($head_chrg_cr['charges_type'] == 'fixed') {
												$bank_charges_cr += $head_chrg_cr['dr_charges'];
											}
										}
									}
									$this->db->set('cost_bank_charges_internal', "cost_bank_charges_internal+$bank_charges_cr", false);
									$this->db->where('bkg_no', $data['cr']['trans_bkg_ref'][$a]);
									$this->db->update('bookings');
								}
							}
						}
						if ($head_dtl["trans_head_mode"] == 'card') {
							$charges = 0;
							foreach ($head_chrgs as $key => $head_chrg) {
								if ($head_chrg['charges_type'] == 'percentage') {
									$p_chrg = (float)$data['dr']['amount'][$i] * (float)((float)$head_chrg['dr_charges'] / 100);
									$charges += $p_chrg;
								} elseif ($head_chrg['charges_type'] == 'fixed') {
									$charges += $head_chrg['dr_charges'];
								}
							}
							$this->db->set('trans_id', $nexttransidx)
								->set('trans_date', date('Y-m-d', strtotime($data['trans_date'])))
								->set('trans_ref',  $data['dr']['trans_bkg_ref'][$i])
								->set('trans_head', 'Card Charges Payable')
								->set('trans_by_to', 'Card Charges')
								->set('trans_description', 'Automated card charges')
								->set('trans_amount', $charges)
								->set('trans_type', 'Cr')
								->set('trans_created_date', date('Y-m-d H:i:s'))
								->set('trans_created_by', 'System')
								->insert('transactions');
							$this->db->set('trans_id', $nexttransidx)
								->set('trans_date', date('Y-m-d', strtotime($data['trans_date'])))
								->set('trans_ref',  $data['dr']['trans_bkg_ref'][$i])
								->set('trans_head', 'Card Charges')
								->set('trans_by_to', 'Card Charges Payable')
								->set('trans_description', 'Automated card charges')
								->set('trans_amount', $charges)
								->set('trans_type', 'Dr')
								->set('trans_created_date', date('Y-m-d H:i:s'))
								->set('trans_created_by', 'System')
								->insert('transactions');
							$nexttransidx = (int)$nexttransidx + 1;
							for ($a = 0; $a <= $crcounter; $a++) {
								if (@$data['cr']['trans_by'][$a] == "Customer") {
									$bkg_dtl_cr = $this->GetBkg($data['cr']['trans_bkg_ref'][$a]);
									$head_chrgs_cr = $this->GetHeadCharges($head_dtl['trans_head'], $bkg_dtl_cr['bkg_brandname'], $bkg_dtl_cr['bkg_agent']);
									$card_charges_cr = 0;
									if ($head_chrgs_cr != 'no charges') {
										foreach ($head_chrgs_cr as $key => $head_chrg_cr) {
											if ($head_chrg_cr['charges_type'] == 'percentage') {
												$p_chrg = (float)$data['cr']['amount'][$a] * (float)((float)$head_chrg_cr['dr_charges'] / 100);
												$card_charges_cr += $p_chrg;
											} elseif ($head_chrg_cr['charges_type'] == 'fixed') {
												$card_charges_cr += $head_chrg_cr['dr_charges'];
											}
										}
									}
									$this->db->set('cost_cardcharges', "cost_cardcharges+$card_charges_cr", false);
									$this->db->where('bkg_no', $data['cr']['trans_bkg_ref'][$a]);
									$this->db->update('bookings');
								}
							}
						}
					}
					if ($head_dtl['type'] == '2') {
						for ($a = 0; $a <= $crcounter; $a++) {
							if (@$data['cr']['trans_by'][$a] == "Customer") {
								$bkg_dtl_cr = $this->GetBkg($data['cr']['trans_bkg_ref'][$a]);
								$head_chrgs_cr = $this->GetHeadCharges($head_dtl['trans_head'], $bkg_dtl_cr['bkg_brandname'], $bkg_dtl_cr['bkg_agent']);
								$charges_cr = 0;
								if ($head_chrgs_cr != 'no charges') {
									foreach ($head_chrgs_cr as $key => $head_chrg_cr) {
										if ($head_chrg_cr['charges_type'] == 'percentage') {
											$p_chrg = (float)$data['cr']['amount'][$a] * (float)((float)$head_chrg_cr['dr_charges'] / 100);
											$charges_cr += $p_chrg;
										} elseif ($head_chrg_cr['charges_type'] == 'fixed') {
											$charges_cr += $head_chrg_cr['dr_charges'];
										}
									}
								}
								$this->db->set('cost_cardcharges', "cost_cardcharges+$charges_cr", false);
								$this->db->where('bkg_no', $data['cr']['trans_bkg_ref'][$a]);
								$this->db->update('bookings');
							}
						}
					}
				}
			}
			$this->db->set('trans_id', $nexttransid)
				->set('trans_date', date('Y-m-d', strtotime($data['trans_date'])))
				->set('trans_ref',  $data['dr']['trans_bkg_ref'][$i])
				->set('trans_head', $data['dr']['trans_to'][$i])
				->set('trans_by_to', $data['cr']['trans_by'][0])
				->set('trans_description', $data['trans_desc'])
				->set('trans_amount', $data['dr']['amount'][$i])
				->set('trans_type', 'Dr')
				->set('t_card', $data['auth_code'])
				->set('trans_created_date', date('Y-m-d H:i:s'))
				->set('trans_created_by', $this->session->userdata('user_name'))
				->insert('transactions');
		}
		for ($j = 0; $j < $crcounter; $j++) {
			if ($data['dr']['trans_to'][0] == "Customer") {
				$head_dtl = $this->GetTransHead($data['cr']['trans_by'][$j]);
				$bkg_dtl = $this->GetBkg($data['cr']['trans_bkg_ref'][$j]);
				$head_chrgs = $this->GetHeadCharges($data['cr']['trans_by'][$j], @$bkg_dtl['bkg_brandname'], @$bkg_dtl['bkg_agent']);
				if ($head_chrgs != 'no charges') {
					if ($head_dtl['type'] == '1') {
						if ($head_dtl["trans_head_mode"] == 'bank' || $head_dtl["trans_head_mode"] == 'cash') {
							$charges = 0;
							foreach ($head_chrgs as $key => $head_chrg) {
								if ($head_chrg['charges_type'] == 'percentage') {
									$p_chrg = (float)$data['cr']['amount'][$j] * (float)((float)$head_chrg['cr_charges'] / 100);
									$charges += $p_chrg;
								} elseif ($head_chrg['charges_type'] == 'fixed') {
									$charges += $head_chrg['cr_charges'];
								}
							}
							$this->db->set('trans_id', $nexttransidx)
								->set('trans_date', date('Y-m-d', strtotime($data['trans_date'])))
								->set('trans_ref',  $data['dr']['trans_bkg_ref'][$j])
								->set('trans_head', 'Bank Charges Payable')
								->set('trans_by_to', 'Bank Charges')
								->set('trans_description', 'Automated bank charges')
								->set('trans_amount', $charges)
								->set('trans_type', 'Cr')
								->set('trans_created_date', date('Y-m-d H:i:s'))
								->set('trans_created_by', 'System')
								->insert('transactions');
							$this->db->set('trans_id', $nexttransidx)
								->set('trans_date', date('Y-m-d', strtotime($data['trans_date'])))
								->set('trans_ref',  $data['dr']['trans_bkg_ref'][$j])
								->set('trans_head', 'Bank Charges')
								->set('trans_by_to', 'Bank Charges Payable')
								->set('trans_description', 'Automated bank charges')
								->set('trans_amount', $charges)
								->set('trans_type', 'Dr')
								->set('trans_created_date', date('Y-m-d H:i:s'))
								->set('trans_created_by', 'System')
								->insert('transactions');
							$nexttransidx = (int)$nexttransidx + 1;
							for ($a = 0; $a <= $drcounter; $a++) {
								if (@$data['dr']['trans_to'][$a] == "Customer") {
									$bkg_dtl_dr = $this->GetBkg($data['dr']['trans_bkg_ref'][$a]);
									$head_chrgs_dr = $this->GetHeadCharges($head_dtl['trans_head'], $bkg_dtl_dr['bkg_brandname'], $bkg_dtl_dr['bkg_agent']);
									$bank_charges_dr = 0;
									if ($head_chrgs_dr != 'no charges') {
										foreach ($head_chrgs_dr as $key => $head_chrg_dr) {
											if ($head_chrg_dr['charges_type'] == 'percentage') {
												$p_chrg = (float)$data['dr']['amount'][$a] * (float)((float)$head_chrg_dr['dr_charges'] / 100);
												$bank_charges_dr += $p_chrg;
											} elseif ($head_chrg_dr['charges_type'] == 'fixed') {
												$bank_charges_dr += $head_chrg_dr['dr_charges'];
											}
										}
									}
									$this->db->set('cost_bank_charges_internal', "cost_bank_charges_internal+$bank_charges_dr", false);
									$this->db->where('bkg_no', $data['dr']['trans_bkg_ref'][$a]);
									$this->db->update('bookings');
								}
							}
						}
						if ($head_dtl["trans_head_mode"] == 'card') {
							$charges = 0;
							foreach ($head_chrgs as $key => $head_chrg) {
								if ($head_chrg['charges_type'] == 'percentage') {
									$p_chrg = (float)$data['cr']['amount'][$j] * (float)((float)$head_chrg['cr_charges'] / 100);
									$charges += $p_chrg;
								} elseif ($head_chrg['charges_type'] == 'fixed') {
									$charges += $head_chrg['cr_charges'];
								}
							}
							$this->db->set('trans_id', $nexttransidx)
								->set('trans_date', date('Y-m-d', strtotime($data['trans_date'])))
								->set('trans_ref',  $data['dr']['trans_bkg_ref'][$j])
								->set('trans_head', 'Card Charges Payable')
								->set('trans_by_to', 'Card Charges')
								->set('trans_description', 'Automated card charges')
								->set('trans_amount', $charges)
								->set('trans_type', 'Cr')
								->set('trans_created_date', date('Y-m-d H:i:s'))
								->set('trans_created_by', 'System')
								->insert('transactions');
							$this->db->set('trans_id', $nexttransidx)
								->set('trans_date', date('Y-m-d', strtotime($data['trans_date'])))
								->set('trans_ref',  $data['dr']['trans_bkg_ref'][$j])
								->set('trans_head', 'Card Charges')
								->set('trans_by_to', 'Card Charges Payable')
								->set('trans_description', 'Automated card charges')
								->set('trans_amount', $charges)
								->set('trans_type', 'Dr')
								->set('trans_created_date', date('Y-m-d H:i:s'))
								->set('trans_created_by', 'System')
								->insert('transactions');
							$nexttransidx = (int)$nexttransidx + 1;
							for ($a = 0; $a <= $drcounter; $a++) {
								if (@$data['dr']['trans_to'][$a] == "Customer") {
									$bkg_dtl_dr = $this->GetBkg($data['dr']['trans_bkg_ref'][$a]);
									$head_chrgs_dr = $this->GetHeadCharges($head_dtl['trans_head'], $bkg_dtl_dr['bkg_brandname'], $bkg_dtl_dr['bkg_agent']);
									$card_charges_dr = 0;
									if ($head_chrgs_dr != 'no charges') {
										foreach ($head_chrgs_dr as $key => $head_chrg_dr) {
											if ($head_chrg_dr['charges_type'] == 'percentage') {
												$p_chrg = (float)$data['dr']['amount'][$a] * (float)((float)$head_chrg_dr['dr_charges'] / 100);
												$card_charges_dr += $p_chrg;
											} elseif ($head_chrg_dr['charges_type'] == 'fixed') {
												$card_charges_dr += $head_chrg_dr['dr_charges'];
											}
										}
									}
									$this->db->set('cost_cardcharges', "cost_cardcharges+$card_charges_dr", false);
									$this->db->where('bkg_no', $data['dr']['trans_bkg_ref'][$a]);
									$this->db->update('bookings');
								}
							}
						}
					}
					if ($head_dtl['type'] == '2') {
						for ($a = 0; $a <= $drcounter; $a++) {
							if (@$data['dr']['trans_to'][$a] == "Customer") {
								$bkg_dtl_dr = $this->GetBkg($data['dr']['trans_bkg_ref'][$a]);
								$head_chrgs_dr = $this->GetHeadCharges($head_dtl['trans_head'], $bkg_dtl_dr['bkg_brandname'], $bkg_dtl_dr['bkg_agent']);
								$card_charges_dr = 0;
								if ($head_chrgs_dr != 'no charges') {
									foreach ($head_chrgs_dr as $key => $head_chrg_dr) {
										if ($head_chrg_dr['charges_type'] == 'percentage') {
											$p_chrg = (float)$data['dr']['amount'][$a] * (float)((float)$head_chrg_dr['dr_charges'] / 100);
											$card_charges_dr += $p_chrg;
										} elseif ($head_chrg_dr['charges_type'] == 'fixed') {
											$card_charges_dr += $head_chrg_dr['dr_charges'];
										}
									}
								}
								$this->db->set('cost_cardcharges', "cost_cardcharges+$card_charges_dr", false);
								$this->db->where('bkg_no', $data['dr']['trans_bkg_ref'][$a]);
								$this->db->update('bookings');
							}
						}
					}
				}
			}
			$this->db->set('trans_id', $nexttransid)
				->set('trans_date', date('Y-m-d', strtotime($data['trans_date'])))
				->set('trans_ref', $data['cr']['trans_bkg_ref'][$j])
				->set('trans_head', $data['cr']['trans_by'][$j])
				->set('trans_by_to', $data['dr']['trans_to'][0])
				->set('trans_description', $data['trans_desc'])
				->set('trans_amount', $data['cr']['amount'][$j])
				->set('trans_type', 'Cr')
				->set('t_card', $data['auth_code'])
				->set('trans_created_date', date('Y-m-d H:i:s'))
				->set('trans_created_by', $this->session->userdata('user_name'))
				->insert('transactions');
		}
		if ($data['dr']['trans_bkg_ref'][0] != 0) {
			$result['bkgid'] = hashing($data['dr']['trans_bkg_ref'][0]);
		} else {
			$result['bkgid'] = $data['dr']['trans_bkg_ref'][0];
		}
		$result['status'] = true;
		return $result;
	}
	public function editTransaction()
	{
		$this->deleteTransaction($this->input->post('trans_id'));
		$this->AddTransaction();
	}
	public function deleteTransaction($transID = '')
	{
		$transdel = (int)$transID + 1;
		$transdel2 = (int)$transID + 2;

		$this->db->select('*');
		$this->db->from('transactions');
		$this->db->where('trans_id', $transdel);
		$query = $this->db->get();
		$result = $query->result_array();
		$numrows = $query->num_rows();
		if ($numrows > 0) {
			foreach ($result as $key => $trans) {
				if ($trans['trans_by_to'] == 'Bank Charges' && $trans['trans_description'] == 'Automated bank charges') {
					$charges_bank = $trans['trans_amount'];
					$bkg_ref = $trans['trans_ref'];
					$this->db->set('cost_bank_charges_internal', "cost_bank_charges_internal-$charges_bank", false);
					$this->db->where('bkg_no', $bkg_ref);
					$this->db->update('bookings');
				}
				if ($trans['trans_by_to'] == 'Card Charges' && $trans['trans_description'] == 'Automated card charges') {
					$charges_card = $trans['trans_amount'];
					$bkg_ref = $trans['trans_ref'];
					$this->db->set('cost_cardcharges', "cost_cardcharges-$charges_card", false);
					$this->db->where('bkg_no', $bkg_ref);
					$this->db->update('bookings');
				}
			}
		}
		$this->db->select('*');
		$this->db->from('transactions');
		$this->db->where('trans_id', $transdel2);
		$query = $this->db->get();
		$result = $query->result_array();
		$numrows = $query->num_rows();
		if ($numrows > 0) {
			foreach ($result as $key => $trans) {
				if ($trans['trans_by_to'] == 'Bank Charges' && $trans['trans_description'] == 'Automated bank charges') {
					$charges_bank = $trans['trans_amount'];
					$bkg_ref = $trans['trans_ref'];
					$this->db->set('cost_bank_charges_internal', "cost_bank_charges_internal-$charges_bank", false);
					$this->db->where('bkg_no', $bkg_ref);
					$this->db->update('bookings');
				}
				if ($trans['trans_by_to'] == 'Card Charges' && $trans['trans_description'] == 'Automated card charges') {
					$charges_card = $trans['trans_amount'];
					$bkg_ref = $trans['trans_ref'];
					$this->db->set('cost_cardcharges', "cost_cardcharges-$charges_card", false);
					$this->db->where('bkg_no', $bkg_ref);
					$this->db->update('bookings');
				}
			}
		}
		$this->db->select('tr.trans_head,tr.trans_amount,tr.trans_type,tr.trans_ref');
		$this->db->from('transactions tr');
		$this->db->join('transaction_heads th', 'tr.trans_head = th.trans_head', 'left');
		$this->db->where('th.type', 2);
		$this->db->where('tr.trans_id', $transID);
		$query = $this->db->get();
		$result = $query->result_array();
		$numrows = $query->num_rows();
		if ($numrows > 0) {
			foreach ($result as $key => $trans) {
				if ($trans['trans_type'] == 'Dr') {
					$bkg_dtl = $this->GetBkg($trans['trans_ref']);
					$head_chrgs_dr = $this->GetHeadCharges($trans['trans_head'], $bkg_dtl['bkg_brandname'], $bkg_dtl['bkg_agent']);
					$charges = 0;
					if ($head_chrgs_dr != 'no charges') {
						foreach ($head_chrgs_dr as $key => $head_chrg) {
							if ($head_chrg['charges_type'] == 'percentage') {
								$p_chrg = (float)$trans['trans_amount'] * (float)((float)$head_chrg['dr_charges'] / 100);
								$charges += $p_chrg;
							} elseif ($head_chrg['charges_type'] == 'fixed') {
								$charges += $head_chrg['dr_charges'];
							}
						}
						$this->db->set('cost_cardcharges', "cost_cardcharges-$charges", false);
						$this->db->where('bkg_no', $trans['trans_ref']);
						$this->db->update('bookings');
					}
				}
				if ($trans['trans_type'] == 'Cr') {
					$bkg_dtl = $this->GetBkg($trans['trans_ref']);
					$head_chrgs_cr = $this->GetHeadCharges($trans['trans_head'], $bkg_dtl['bkg_brandname'], $bkg_dtl['bkg_agent']);
					$charges = 0;
					if ($head_chrgs_cr != 'no charges') {
						foreach ($head_chrgs_cr as $key => $head_chrg) {
							if ($head_chrg['charges_type'] == 'percentage') {
								$p_chrg = (float)$trans['trans_amount'] * (float)((float)$head_chrg['cr_charges'] / 100);
								$charges += $p_chrg;
							} elseif ($head_chrg['charges_type'] == 'fixed') {
								$charges += $head_chrg['cr_charges'];
							}
						}
						$this->db->set('cost_cardcharges', "cost_cardcharges-$charges", false);
						$this->db->where('bkg_no', $trans['trans_ref']);
						$this->db->update('bookings');
					}
				}
			}
		}

		$this->db->where('trans_id', $transID);
		$this->db->delete('transactions');

		$this->db->where('trans_id', $transdel);
		$this->db->where('trans_description', 'Automated bank charges');
		$this->db->delete('transactions');

		$this->db->where('trans_id', $transdel);
		$this->db->where('trans_description', 'Automated card charges');
		$this->db->delete('transactions');

		$this->db->where('trans_id', $transdel2);
		$this->db->where('trans_description', 'Automated bank charges');
		$this->db->delete('transactions');

		$this->db->where('trans_id', $transdel2);
		$this->db->where('trans_description', 'Automated card charges');
		$this->db->delete('transactions');
	}
	public function GetTrans($transId = '')
	{
		$this->db->select('*');
		$this->db->from('transactions');
		if ($transId != '') {
			$this->db->where('trans_id', $transId);
		}
		return $this->db->get()->result_array();
	}
	public function Getbalance($start_date = '', $owner = '')
	{
		$dr_amt = 0;
		$cr_amt = 0;
		$this->db->select('SUM(`trans_amount`) as Debit_Bal');
		$this->db->from('transactions t');
		$this->db->join('transaction_heads th', 'th.trans_head = t.trans_head', 'left');
		$this->db->where('t.trans_date <', date('Y-m-d', strtotime($start_date)));
		$this->db->where('t.trans_type', 'Dr');
		$this->db->where('th.owner', $owner);
		$this->db->order_by('t.trans_date', 'desc');
		$result = $this->db->get()->row_array();
		$dr_amt = $result['Debit_Bal'];

		$this->db->select('SUM(`trans_amount`) as Credit_Bal');
		$this->db->from('transactions t');
		$this->db->join('transaction_heads th', 'th.trans_head = t.trans_head', 'left');
		$this->db->where('t.trans_date <', date('Y-m-d', strtotime($start_date)));
		$this->db->where('t.trans_type', 'Cr');
		$this->db->where('th.owner', $owner);
		$this->db->order_by('t.trans_date', 'desc');
		$result = $this->db->get()->row_array();
		$cr_amt = $result['Credit_Bal'];
		$balance = round($dr_amt, 2) - round($cr_amt, 2);
		return round($balance, 2);
	}
	public function GetLedger($data = '')
	{
		$owner = $data['trans_head'];
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$this->db->select('t.*,bkg.bkg_supplier_reference,br.brand_pre_post_fix');
		$this->db->from('transactions t');
		$this->db->join('transaction_heads th', 'th.trans_head = t.trans_head', 'left');
		$this->db->join('bookings bkg', 'bkg.bkg_no = t.trans_ref', 'left');
		$this->db->join('brand br', 'br.brand_name = bkg.bkg_brandname', 'left');
		$this->db->where('t.trans_date >=', $sdate);
		$this->db->where('t.trans_date <=', $edate);
		$this->db->where('th.owner', $owner);
		$this->db->order_by('t.trans_date', 'asc');
		return $this->db->get()->result_array();
	}
	public function GetcardCharge($data = '')
	{
		$heads = "";
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$heads = $data['trans_head'] ; 
		$this->db->select('t.*,br.brand_pre_post_fix');
		$this->db->from('transactions t');
		$this->db->join('transaction_heads th', 'th.trans_head = t.trans_head', 'left');
		$this->db->join('bookings bkg', 'bkg.bkg_no = t.trans_ref', 'left');
		$this->db->join('brand br', 'br.brand_name = bkg.bkg_brandname', 'left');
		$this->db->where('t.trans_date >=', $sdate);
		$this->db->where('t.trans_date <=', $edate);
		$this->db->where('th.trans_head_mode', 'card');
		$this->db->where_in('th.trans_head', $heads);
		$this->db->order_by('t.trans_date', 'asc');
		return $this->db->get()->result_array();
	}
	public function GetccBalance($data = '')
	{
		$heads = "";
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$heads = $data['trans_head'] ; 
		$dr_amt = 0;
		$cr_amt = 0;
		$this->db->select('SUM(`trans_amount`) as Debit_Bal');
		$this->db->from('transactions t');
		$this->db->join('transaction_heads th', 'th.trans_head = t.trans_head', 'left');
		$this->db->where('t.trans_date <', date('Y-m-d', strtotime($sdate)));
		$this->db->where('t.trans_type', 'Dr');
		$this->db->where('th.trans_head_mode', 'card');
		$this->db->where_in('th.trans_head', $heads);
		$this->db->order_by('t.trans_date', 'desc');
		$result = $this->db->get()->row_array();
		$dr_amt = $result['Debit_Bal'];

		$this->db->select('SUM(`trans_amount`) as Credit_Bal');
		$this->db->from('transactions t');
		$this->db->join('transaction_heads th', 'th.trans_head = t.trans_head', 'left');
		$this->db->where('t.trans_date <', date('Y-m-d', strtotime($sdate)));
		$this->db->where('t.trans_type', 'Cr');
		$this->db->where('th.trans_head_mode', 'card');
		$this->db->where_in('th.trans_head', $heads);
		$this->db->order_by('t.trans_date', 'desc');
		$result = $this->db->get()->row_array();
		$cr_amt = $result['Credit_Bal'];
		$balance = round($dr_amt, 2) - round($cr_amt, 2);
		return round($balance, 2);
	}
	public function GetHeadBalance($data = '')
	{
		$head = $data["trans_head"];
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$dr_amt = 0;
		$cr_amt = 0;
		$this->db->select('SUM(`trans_amount`) as Debit_Bal');
		$this->db->from('transactions t');
		$this->db->join('transaction_heads th', 'th.trans_head = t.trans_head', 'left');
		$this->db->where('t.trans_date <', date('Y-m-d', strtotime($sdate)));
		$this->db->where('t.trans_type', 'Dr');
		$this->db->where('th.trans_head', $head);
		$this->db->order_by('t.trans_date', 'desc');
		$result = $this->db->get()->row_array();
		$dr_amt = $result['Debit_Bal'];

		$this->db->select('SUM(`trans_amount`) as Credit_Bal');
		$this->db->from('transactions t');
		$this->db->join('transaction_heads th', 'th.trans_head = t.trans_head', 'left');
		$this->db->where('t.trans_date <', date('Y-m-d', strtotime($sdate)));
		$this->db->where('t.trans_type', 'Cr');
		$this->db->where('th.trans_head', $head);
		$this->db->order_by('t.trans_date', 'desc');
		$result = $this->db->get()->row_array();
		$cr_amt = $result['Credit_Bal'];
		$balance = round($dr_amt, 2) - round($cr_amt, 2);
		return round($balance, 2);
	}
	public function GetbankBook($data = '')
	{
		$head = $data["trans_head"];
		$sdate = date('Y-m-d', strtotime($data['start_date']));
		$edate = date('Y-m-d', strtotime($data['end_date']));
		$this->db->select('t.*,br.brand_pre_post_fix');
		$this->db->from('transactions t');
		$this->db->join('transaction_heads th', 'th.trans_head = t.trans_head', 'left');
		$this->db->join('bookings bkg', 'bkg.bkg_no = t.trans_ref', 'left');
		$this->db->join('brand br', 'br.brand_name = bkg.bkg_brandname', 'left');
		$this->db->where('t.trans_date >=', $sdate);
		$this->db->where('t.trans_date <=', $edate);
		$this->db->where('th.trans_head', $head);
		$this->db->order_by('t.trans_date', 'asc');
		return $this->db->get()->result_array();
	}
	public function Getsuspense()
	{
		$this->db->select('*');
		$this->db->from('transactions');
		$this->db->where('trans_head', "Suspense Account");
		$this->db->order_by('trans_date', 'asc');
		return $this->db->get()->result_array();
	}
	public function GettrialBalance($sdate = '', $edate = '')
	{
		if ($sdate != '') {
			$sdate = date('Y-m-d', strtotime($sdate));
		}
		if ($edate != '') {
			$edate = date('Y-m-d', strtotime($edate));
		}
		$thbal = array();
		$thobal = array();
		$hostname = $this->db->hostname;
		$username = $this->db->username;
		$database = $this->db->database;
		$password = $this->db->password;
		$con = mysqli_connect($hostname, $username, $password, $database);


		if ($sdate != '' && $edate != '') {
			$queryb = "SELECT `trans_head`, `trans_amount`, `trans_type`  FROM `transactions` WHERE `trans_head` <> 'P&L Account' AND `trans_date` BETWEEN '$sdate' AND '$edate'  ORDER BY `trans_date`";
		} elseif ($sdate == '') {
			$queryb = "SELECT `trans_head`, `trans_amount`, `trans_type`  FROM `transactions` WHERE `trans_head` <> 'P&L Account' AND `trans_date` <= '$edate'  ORDER BY `trans_date`";
		}
		$resultb = mysqli_query($con, $queryb);
		while ($rowb = mysqli_fetch_array($resultb)) {
			if ($rowb["trans_type"] == "Dr") {
				$th = $rowb["trans_head"];
				@$thbal["$th"] = (float)$thbal["$th"] + (float)$rowb["trans_amount"];
			} elseif ($rowb["trans_type"] == "Cr") {
				$th = $rowb["trans_head"];
				@$thbal["$th"] = (float)$thbal["$th"] - (float)$rowb["trans_amount"];
			}
		}
		mysqli_free_result($resultb);



		foreach ($thbal as $k => $v) {

			$querythobal = "SELECT CONCAT(`type`,`trial_balance_head`) as tho FROM `transaction_heads` WHERE `trans_head` = '" . $k . "'";
			$resulthobal = mysqli_query($con, $querythobal);

			if (mysqli_num_rows($resulthobal) > 0) {
				$rowthobal = mysqli_fetch_array($resulthobal);
				$thowner = $rowthobal["tho"];
				@$thobal["$thowner"] = (float)$thobal["$thowner"] + (float)$v;
			} else {
				@$thobal["5$k"] = (float)$thobal["5$k"] + (float)$v;
			}
		}
		ksort($thobal);
		return $thobal;
	}
	public function conCattho($head)
	{
		$this->db->select('CONCAT(`type`,`trial_balance_head`) as tho');
		$this->db->from('transaction_heads');
		$this->db->where('trans_head', $head);
		return $this->db->get()->row_array();
	}
	public function GetprofitLoss($edate = '')
	{
		$edate = date('Y-m-d', strtotime($edate));
		$thbal = array();
		$thobal = array();
		$query = "SELECT `trans_head`, `trans_amount`, `trans_type`  FROM `transactions` WHERE `trans_head` IN('Air Ticket Sales', 'Air Ticket Purchases','Hotel Sales','Hotel Purchases','Cab Sales','Cab Purchases') AND `trans_date` <= '$edate'";
		$result = $this->db->query($query)->result_array();
		foreach ($result as $key => $rowb) {
			if ($rowb["trans_type"] == "Dr") {
				$th = $rowb["trans_head"];
				@$thbal["$th"] = (float)$thbal["$th"] + (float)$rowb["trans_amount"];
			} elseif ($rowb["trans_type"] == "Cr") {
				$th = $rowb["trans_head"];
				@$thbal["$th"] = (float)$thbal["$th"] - (float)$rowb["trans_amount"];
			}
		}
		foreach ($thbal as $k => $v) {
			$querythobal = "SELECT CONCAT(`type`,`owner`) as tho FROM `transaction_heads` WHERE `trans_head` = '" . $k . "'";
			$rowthobal = $this->db->query($querythobal)->row_array();
			$totalrowthobal = count($rowthobal);
			if ($totalrowthobal > 0) {
				$thowner = $rowthobal["tho"];
				@$thobal["$thowner"] = (float)$thobal["$thowner"] + (float)$v;
			} else {
				@$thobal["9$k"] = (float)$thobal["9$k"] + (float)$v;
			}
		}
		$data['sale_purchase'] = $thobal;

		$thbal2 = array();
		$thobal2 = array();
		$queryb = "SELECT t.`trans_head`, t.`trans_amount`, t.`trans_type`  FROM `transactions` t, `transaction_heads` th WHERE t.`trans_head` = th.`trans_head` AND th.`type` in(3) AND t.`trans_head` NOT IN('Air Ticket Sales', 'Air Ticket Purchases','Hotel Sales','Hotel Purchases','Cab Sales','Cab Purchases') AND t.`trans_date` <= '$edate'";
		$resultb = $this->db->query($queryb)->result_array();
		foreach ($resultb as $key => $rowb) {
			if ($rowb["trans_type"] == "Dr") {
				$th = $rowb["trans_head"];
				@$thbal2["$th"] = (float)$thbal2["$th"] + (float)$rowb["trans_amount"];
			} elseif ($rowb["trans_type"] == "Cr") {
				$th = $rowb["trans_head"];
				@$thbal2["$th"] = (float)$thbal2["$th"] - (float)$rowb["trans_amount"];
			}
		}
		foreach ($thbal2 as $k => $v) {
			$querythobal = "SELECT CONCAT(`type`,`owner`) as tho FROM `transaction_heads` WHERE `trans_head` = '" . $k . "'";
			$rowthobal = $this->db->query($querythobal)->row_array();
			$totalrowthobal = count($rowthobal);
			if ($totalrowthobal > 0) {
				$thowner = $rowthobal["tho"];
				@$thobal2["$thowner"] = (float)$thobal2["$thowner"] + (float)$v;
			} else {
				@$thobal2["9$k"] = (float)$thobal2["9$k"] + (float)$v;
			}
		}
		$data['adminexp'] = $thobal2;

		$thbal9 = array();
		$thobal9 = array();
		$queryb = "SELECT t.`trans_head`, t.`trans_amount`, t.`trans_type`  FROM `transactions` t, `transaction_heads` th WHERE t.`trans_head` = th.`trans_head` AND th.`type` in(4) AND t.`trans_date` <= '$edate'";
		$resultb = $this->db->query($queryb)->result_array();
		foreach ($resultb as $key => $rowb) {
			if ($rowb["trans_type"] == "Dr") {
				$th = $rowb["trans_head"];
				@$thbal9["$th"] = (float)$thbal9["$th"] - (float)$rowb["trans_amount"];
			} elseif ($rowb["trans_type"] == "Cr") {
				$th = $rowb["trans_head"];
				@$thbal9["$th"] = (float)$thbal9["$th"] + (float)$rowb["trans_amount"];
			}
		}
		foreach ($thbal9 as $k => $v) {
			$querythobal = "SELECT CONCAT(`type`,`owner`) as tho FROM `transaction_heads` WHERE `trans_head` = '" . $k . "'";
			$rowthobal = $this->db->query($querythobal)->row_array();
			$totalrowthobal = count($rowthobal);
			if ($totalrowthobal > 0) {
				$thowner = $rowthobal["tho"];
				@$thobal9["$thowner"] = (float)$thobal9["$thowner"] + (float)$v;
			} else {
				@$thobal9["9$k"] = (float)$thobal9["9$k"] + (float)$v;
			}
		}
		$data['miscincome'] = $thobal9;

		$thbal4 = array();
		$thobal4 = array();
		$queryb = "SELECT t.`trans_head`, t.`trans_amount`, t.`trans_type`  FROM `transactions` t, `transaction_heads` th WHERE t.`trans_head` = th.`trans_head` AND th.`type` IN(2,1,5,6) AND t.`trans_head` NOT IN('P&L Account') AND t.`trans_date` <= '$edate'";
		$resultb = $this->db->query($queryb)->result_array();
		foreach ($resultb as $key => $rowb) {
			if ($rowb["trans_type"] == "Dr") {
				$th = $rowb["trans_head"];
				@$thbal4["$th"] = (float)$thbal4["$th"] + (float)$rowb["trans_amount"];
			} elseif ($rowb["trans_type"] == "Cr") {
				$th = $rowb["trans_head"];
				@$thbal4["$th"] = (float)$thbal4["$th"] - (float)$rowb["trans_amount"];
			}
		}
		foreach ($thbal4 as $k => $v) {
			$querythobal = "SELECT CONCAT(`type`,`owner`) as tho FROM `transaction_heads` WHERE `trans_head` = '" . $k . "'";
			$rowthobal = $this->db->query($querythobal)->row_array();
			$totalrowthobal = count($rowthobal);
			if ($totalrowthobal > 0) {
				$thowner = $rowthobal["tho"];
				@$thobal4["$thowner"] = (float)$thobal4["$thowner"] + (float)$v;
			} else {
				@$thobal4["9$k"] = (float)$thobal4["9$k"] + (float)$v;
			}
		}
		$data['balsheet'] = $thobal4;

		return $data;
	}
	// public function GettrialBalance($sdate='',$edate=''){
	// 	if($sdate != ''){
	// 		$sdate = date('Y-m-d',strtotime($sdate));
	// 	}
	// 	if($edate != ''){
	// 		$edate = date('Y-m-d',strtotime($edate));
	// 	}
	// 	$heads = $this->GetTransHead();
	// 	$tb_heads =array();
	// 	foreach ($heads as $key => $head) {
	// 		$headbal = 0;
	// 		$headdrbal = 0;
	// 		$headcrbal = 0;
	// 		$q_head = $head['trans_head'] ;

	// 		$query = "SELECT SUM(CASE WHEN `trans_type` = 'Dr' THEN `trans_amount` else - `trans_amount` END) as head_bal FROM `transactions` WHERE `trans_head` = '$q_head' AND `trans_date` <= '$edate' ;";

	// 		$headcrbal = $this->db->query($query)->row_array();
	// 		$headbal = $headcrbal['head_bal'];
	// 		if($headbal != 0){
	// 			$tb_heads[$key]['trans_head'] = $head['trans_head'] ;
	// 			$tb_heads[$key]['head_type'] = $head['type'] ;
	// 			if($headbal > 0){
	// 				$tb_heads[$key]['balance_type'] = 'Dr';
	// 			}elseif($headbal < 0){
	// 				$tb_heads[$key]['balance_type'] = 'Cr';
	// 			}
	// 			$tb_heads[$key]['head_balance'] = round(abs($headbal),2);
	// 		}
	// 	}
	// 	return $tb_heads ;
	// }
	public function get_heads($sort_by = '')
	{
		$this->db->select('th.trans_head,th.trans_head_mode,th.owner,th.type,th.trans_head_status,thc.id,thc.brand_name,thc.agent_name,thc.dr_charges,thc.cr_charges,thc.charges_type');
		$this->db->from('transaction_heads th');
		$this->db->join('trans_head_charges thc', 'thc.trans_head = th.trans_head', 'left');
		if ($sort_by != '') {
			$this->db->order_by("th." . $sort_by . " DESC,th.trans_head_status DESC");
		} else {
			$this->db->order_by("th.trans_head_status DESC ,th.trans_head asc");
		}
		return $this->db->get()->result_array();
	}
	public function checkexisthead($head)
	{
		$this->db->select('trans_head');
		$this->db->from('transaction_heads');
		$this->db->where('trans_head', $head);
		$result = $this->db->get();
		$total_row = $result->num_rows();
		if ($total_row > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function brandagents($brand)
	{
		$this->db->select('user_name');
		if ($brand != '' && $brand != 'All') {
			$this->db->where('user_brand', $brand);
		}
		$this->db->from('users');
		$this->db->order_by('user_name', 'asc');
		$res = $this->db->get()->result_array();
		return $res;
	}
	public function addtranshead($data)
	{
		$rows_head = $rows_charges = 0;
		$this->db->set('trans_head', $data['trans_head']);
		$this->db->set('trans_head_mode', $data['head_mode']);
		$this->db->set('owner', $data['trans_head_owner']);
		$this->db->set('type', $data['head_type']);
		$this->db->set('trial_balance_head', $data['trans_head_tb']);
		$this->db->set('trans_head_status', $data['head_status']);
		$result = $this->db->insert('transaction_heads');
		$rows_head = $this->db->affected_rows();
		if (@$data['charges']) {
			$totalChrgs = count($data['charges']['brand_name']);
			for ($i = 0; $i < $totalChrgs; $i++) {
				$this->db->set('trans_head', $data['trans_head']);
				if ($data['charges']['brand_name'][$i] != '' && ($data['charges']['brand_name'][$i] != 'all' && $data['charges']['brand_name'][$i] != 'All')) {
					$this->db->set('brand_name', $data['charges']['brand_name'][$i]);
				}
				if ($data['charges']['agent_name'][$i] != '' && ($data['charges']['agent_name'][$i] != 'all' && $data['charges']['agent_name'][$i] != 'All')) {
					$this->db->set('agent_name', $data['charges']['agent_name'][$i]);
				}
				$this->db->set('dr_charges', $data['charges']['dr_charges'][$i]);
				$this->db->set('cr_charges', $data['charges']['cr_charges'][$i]);
				$this->db->set('charges_type', $data['charges']['charges_type'][$i]);
				$this->db->insert('trans_head_charges');
				$rows_charges = $this->db->affected_rows();
			}
		}
		if ($rows_charges > 0 || $rows_head > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function gethead($transhead = '')
	{
		$this->db->select('*');
		$this->db->from('transaction_heads');
		$this->db->where('trans_head', $transhead);
		return $this->db->get()->row_array();
	}
	public function getheadallcharges($transhead = '')
	{
		$this->db->select('*');
		$this->db->from('trans_head_charges');
		$this->db->where('trans_head', $transhead);
		return $this->db->get()->result_array();
	}
	public function delTrans_head($head_name = '')
	{
		$this->db->where('trans_head', $head_name);
		$this->db->delete('transaction_heads');
	}
}
/* End of file Accounts_model.php */
/* Location: ./application/models/Accounts_model.php */
