<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Progress_model extends CI_Model
{

	public function progress_sheet($brand = '', $agent = '', $sdate = '', $edate = '')
	{
		$profit_issuance_unsgn = 0;
		$profit_cancellation_unsgn = 0;
		if ($sdate != '' && $edate != '') {
			$curdate = $edate;
			$today = date("Y-m-d");
			$fmdate = $sdate;
		} else {
			$curdate = date("Y-m-t");
			$today = date("Y-m-d");
			$fmdate = date("Y-m-01");
		}
		if ($brand != '' && $brand != 'All') {
			$brandname_u = " AND `user_brand` ='$brand' ";
			$brandname_b = " AND `bkg_brandname` ='$brand' ";
		} else {
			$brandname_u = '';
			$brandname_b = '';
		}
		//fetching active agnets list into an array
		$query_U = "SELECT * FROM `users` WHERE `user_status` = 'active' $brandname_u";
		$result_U = $this->db->query($query_U)->result_array();
		if (count($result_U) > 0) {
			foreach ($result_U as $key => $rowU) {
				$username = $rowU["user_name"];
				$agents["$username"] =  array(
					"pendingbookings" => 0,
					"currentdaybookings" => 0,
					"currentmonthbookings" => 0,
					"currentmonthissuedbookings" => 0,
					"currentmonthcancelledbookings" => 0,
					"currentmonthissuanceprofit" => 0,
					"currentmonthcancellationprofit" => 0,
					"currentmonthtotalprofit" => 0,
				);
			}
			//---> calculating pending bookings
			$querypb = "SELECT COUNT(`bkg_no`) as no_of_pb,`bkg_agent` FROM `bookings` WHERE `bkg_status` = 'Pending' $brandname_b GROUP BY `bkg_agent`";
			$resultpb = $this->db->query($querypb)->result_array();
			foreach ($resultpb as $key => $rowpb) {
				$agentnam = $rowpb["bkg_agent"];
				$agents["$agentnam"]["pendingbookings"] = $rowpb["no_of_pb"];
			}
			//---> Calculating current day bookings
			$querycdb = "SELECT COUNT(`bkg_no`) as no_of_cdb, `bkg_agent` FROM `bookings` WHERE `bkg_date` = '$today' AND `bkg_status` != 'Deleted' $brandname_b GROUP BY `bkg_agent`";
			$resultcdb = $this->db->query($querycdb)->result_array();
			foreach ($resultcdb as $key => $rowcdb) {
				$agentnam = $rowcdb["bkg_agent"];
				$agents["$agentnam"]["currentdaybookings"] = $rowcdb["no_of_cdb"];
			}
			//---> Calculating current month bookings
			$querycmb = "SELECT COUNT(`bkg_no`) as no_of_cmb, `bkg_agent` FROM `bookings` WHERE `bkg_date` BETWEEN '$fmdate' AND '$curdate' AND `bkg_status` != 'Deleted' $brandname_b GROUP BY `bkg_agent`";
			$resultcmb = $this->db->query($querycmb)->result_array();
			foreach ($resultcmb as $key => $rowcmb) {
				$agentnam = $rowcmb["bkg_agent"];
				$agents["$agentnam"]["currentmonthbookings"] = $rowcmb["no_of_cmb"];
			}
			//---> Calculating current months issued bookings
			$querycmib = "SELECT COUNT(`bkg_no`) as no_of_cmib, `bkg_agent` FROM `bookings` WHERE `clr_date` BETWEEN '$fmdate' AND '$curdate' AND `bkg_status` = 'Issued' $brandname_b GROUP BY `bkg_agent`";
			$resultcmib = $this->db->query($querycmib)->result_array();
			foreach ($resultcmib as $key => $rowcmib) {
				$agentnam = $rowcmib["bkg_agent"];
				$agents["$agentnam"]["currentmonthissuedbookings"] = $rowcmib["no_of_cmib"];
			}
			//----> Calculating current months cancelled bookings
			$querycmcb = "SELECT COUNT(`bkg_no`) as no_of_cmcb, `bkg_agent` FROM `bookings` WHERE `cnl_date` BETWEEN '$fmdate' AND '$curdate'  AND `bkg_status` = 'Cancelled' $brandname_b GROUP BY `bkg_agent`";
			$resultcmcb = $this->db->query($querycmcb)->result_array();
			foreach ($resultcmcb as $key => $rowcmcb) {
				$agentnam = $rowcmcb["bkg_agent"];
				$agents["$agentnam"]["currentmonthcancelledbookings"] = $rowcmcb["no_of_cmcb"];
			}
			//---- >calculating issuance profit 
			$query = "SELECT bkg.*,IFNULL(htl.cost,0) as htl_cost , IFNULL(cab.cost,0) as cab_cost FROM bookings bkg LEFT JOIN bookings_hotel htl ON htl.bkg_no = bkg.bkg_no LEFT JOIN bookings_cab cab ON cab.bkg_no = bkg.bkg_no Where bkg.bkg_status IN('Issued','Cleared') AND bkg.clr_date BETWEEN '$fmdate' AND '$curdate' $brandname_b GROUP BY bkg.bkg_no";
			$result = $this->db->query($query)->result_array();
			if (count($result) > 0) {
				foreach ($result as $key => $row) {
					//calculating the total sale price and no. of pax	  
					$query_saleprice = "SELECT (`p_basic` + `p_tax` + `p_bookingfee` + `p_cardcharges` + `p_others` + IFNULL(`p_hotel`,0)+IFNULL(`p_cab`,0)) as saleprice FROM `passengers` WHERE `bkg_no` = '" . $row['bkg_no'] . "'";
					$result_saleprice = $this->db->query($query_saleprice)->result_array();
					$total_saleprice = 0;
					$total_passengers = 0;
					foreach ($result_saleprice as $key => $row_saleprice) {
						$total_saleprice = (float)$total_saleprice + (float)$row_saleprice['saleprice'];
						$total_passengers++;
					}
					///////////////////////////////////////////////////
					$agentnam = $row["bkg_agent"];
					$agents["$agentnam"]["currentmonthissuanceprofit"] = (float)@$agents["$agentnam"]["currentmonthissuanceprofit"] + round((float)$total_saleprice - ((float)$row['cab_cost'] + (float)$row['htl_cost'] + (float)$row['cost_basic'] + (float)$row['cost_tax'] + (float)$row['cost_apc'] + (float)$row['cost_safi'] + (float)$row['cost_misc'] + (float)$row['cost_postage'] + (float)$row['cost_cardverfication'] + (float)$row['cost_cardcharges'] + (float)$row['cost_bank_charges_internal']), 2);
					if ((round((float)$total_saleprice - ((float)$row['cab_cost'] + (float)$row['htl_cost'] + (float)$row['cost_basic'] + (float)$row['cost_tax'] + (float)$row['cost_apc'] + (float)$row['cost_safi'] + (float)$row['cost_misc'] + (float)$row['cost_postage'] + (float)$row['cost_cardverfication'] + (float)$row['cost_cardcharges'] + (float)$row['cost_bank_charges_internal']), 2)) > 0) {
						$profit_issuance_unsgn = (float)$profit_issuance_unsgn + (round((float)$total_saleprice - ((float)$row['cab_cost'] + (float)$row['htl_cost'] + (float)$row['cost_basic'] + (float)$row['cost_tax'] + (float)$row['cost_apc'] + (float)$row['cost_safi'] + (float)$row['cost_misc'] + (float)$row['cost_postage'] + (float)$row['cost_cardverfication'] + (float)$row['cost_cardcharges'] + (float)$row['cost_bank_charges_internal']), 2));
					}
				}
			}
			//---> Calculating cancelation profit
			$query = "SELECT bkg.*,IFNULL(htl.cost,0) as htl_cost,IFNULL(cab.cost,0) as cab_cost FROM bookings bkg LEFT JOIN bookings_hotel htl ON htl.bkg_no = bkg.bkg_no LEFT JOIN bookings_cab cab ON cab.bkg_no = bkg.bkg_no Where bkg.bkg_status = 'Cancelled' AND bkg.cnl_date BETWEEN '$fmdate' AND '$curdate' $brandname_b  GROUP BY bkg.bkg_no ";
			$result = $this->db->query($query)->result_array();
			if (count($result) > 0) {
				foreach ($result as $key => $row) {
					$query_pmt = "SELECT * FROM `transactions` WHERE `trans_ref` = '" . $row['bkg_no'] . "' AND `trans_head` = 'Customer' AND `trans_description` <> 'Tickets Issued' AND `trans_description` <> 'Profit on cancelled file' ORDER BY `trans_date`;";
					$result_pmt = $this->db->query($query_pmt)->result_array();
					$amt_rec = 0;
					$amt_ref = 0;
					if (count($result_pmt) > 0) {
						foreach ($result_pmt as $key => $rowpmt) {
							if ($rowpmt["trans_type"] == 'Dr') {
								$amt_ref = (float)$amt_ref + (float)$rowpmt["trans_amount"];
							} else {
								$amt_rec = (float)$amt_rec + (float)$rowpmt["trans_amount"];
							}
						}
					}
					$agentnam = $row["bkg_agent"];
					@$agents["$agentnam"]["currentmonthcancellationprofit"] = @(float)$agents["$agentnam"]["currentmonthcancellationprofit"] + (float)$amt_rec - (float)((float)$row['htl_cost'] + (float)$row['cab_cost'] + (float)$row['cost_postage'] + (float)$row['cost_cardverfication'] + (float)$row['cost_cardcharges'] + (float)$row['cost_bank_charges_internal'] + (float)$row['cost_misc']) - (float)$amt_ref;
					if (((float)$amt_rec - (float)((float)$row['htl_cost'] + (float)$row['cab_cost'] + (float)$row['cost_postage'] + (float)$row['cost_cardverfication'] + (float)$row['cost_cardcharges'] + (float)$row['cost_bank_charges_internal'] + (float)$row['cost_misc']) - (float)$amt_ref) > 0) {
						$profit_cancellation_unsgn = (float)$profit_cancellation_unsgn + 	((float)$amt_rec - (float)((float)$row['htl_cost'] + (float)$row['cab_cost'] + (float)$row['cost_postage'] + (float)$row['cost_cardverfication'] + (float)$row['cost_cardcharges'] + (float)$row['cost_bank_charges_internal'] + (float)$row['cost_misc']) - (float)$amt_ref);
					}
				}
			}
			foreach ($agents as $agentname => $data) {
				$agents["$agentname"]["currentmonthtotalprofit"] = @$agents["$agentname"]["currentmonthissuanceprofit"] + @$agents["$agentname"]["currentmonthcancellationprofit"];
				if (!isset($agents["$agentname"]["currentdaybookings"])) {
					$agents["$agentname"]["currentdaybookings"]  = 0;
				}
				if (!isset($agents["$agentname"]["currentmonthbookings"])) {
					$agents["$agentname"]["currentmonthbookings"] = 0;
				}
				if (!isset($agents["$agentname"]["currentmonthissuedbookings"])) {
					$agents["$agentname"]["currentmonthissuedbookings"] = 0;
				}
				if (!isset($agents["$agentname"]["currentmonthcancelledbookings"])) {
					$agents["$agentname"]["currentmonthcancelledbookings"] = 0;
				}
				if (!isset($agents["$agentname"]["currentmonthissuanceprofit"])) {
					$agents["$agentname"]["currentmonthissuanceprofit"] = 0;
				}
				if (!isset($agents["$agentname"]["currentmonthcancellationprofit"])) {
					$agents["$agentname"]["currentmonthcancellationprofit"] = 0;
				}
				if (!isset($agents["$agentname"]["pendingbookings"])) {
					$agents["$agentname"]["pendingbookings"] = 0;
				}
			}
			return $agents;
		} else {
			return 'false';
		}
	}
}
/* End of file Progress_model.php */
/* Location: ./application/models/Progress_model.php */
