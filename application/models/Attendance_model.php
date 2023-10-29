<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {

	public function GetCalendar($selectedMonth, $selectedYear){
		$data['session_role'] = $this->session->userdata('user_role');
        $user_id = $this->session->userdata('user_id');
        $user_name = $this->session->userdata('user_name');
        $user_brand = $this->session->userdata('user_brand');
        $this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_status', 1);
    	if(checkAccess($data['session_role'],'attendance_own')){
    		$this->db->where('user_id', $user_id);
    	}	
    	if($user_brand != 'All'){
			$this->db->where('user_brand', $user_brand);
		}
    	$agents = $this->db->get()->result_array();
		$calendar = array();
		$totalDays = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
		foreach ($agents as $key => $agent) {
			$totalPresent = 0;
			$totalLeave = 0;
			$totalShortLeave = 0;
			$totalAbsent = 0;
			for ($i = 1; $i <= $totalDays ; $i++) { 
				$ret = $this->CheckAttendance($agent['user_id'], $selectedYear."-".$selectedMonth."-".$i);
				$dates[$selectedYear."-".$selectedMonth."-".$i] = $ret;
				$totalPresent += (@$ret['present'])?1:0;
				$totalLeave += (@$ret['leave'])?1:0;
				$totalShortLeave += (@$ret['shortleave'])?1:0;
				$totalAbsent += (@$ret['absent'])?1:0;
			}
			$calendar[$agent['user_id']] = $dates;
			$calendar[$agent['user_id']]['presents'] = $totalPresent;
			$calendar[$agent['user_id']]['leaves'] = $totalLeave;
			$calendar[$agent['user_id']]['shortleaves'] = $totalShortLeave;
			$calendar[$agent['user_id']]['absents'] = $totalAbsent;
			$calendar[$agent['user_id']]['user_name'] = $agent['user_name'];
		}
		$calendar['totalDays'] = $totalDays;
		return $calendar;
	}
	public function CheckAttendance($agent, $date){
		$this->db->select('*');
		$this->db->from('attendance');
		$this->db->where('user_id', $agent);
		$this->db->where('att_date', $date);
		$att = $this->db->get()->row_array();
		$day = date('D', strtotime($date));
		$record = array();
		if (!empty($att)) {
			if ($att['status'] == 1) {
				$record['type'] = date('h:i',strtotime($att['timestamp']));
				$startTime = strtotime($date."09:30");
				$joinTime = strtotime($att['timestamp']);
				// echo "<pre>"; print_r($startTime ." - ". $joinTime);exit;

				if ($joinTime <= $startTime) {
					$record['color'] = "#03CE24";
				}else{
					$record['color'] = "#FF7C7C";
				}
				$record['present'] = true;
			}else if($att['status'] == 2){
				$record['type'] = "L";
				$record['color'] = "#FF7C7C";
				$record['leave'] = true;
			}else if($att['status'] == 3){
				$record['type'] = "SL";
				$record['color'] = "#FF7C7C";
				$record['shortleave'] = true;
			}else if($att['status'] == 4){
				$record['type'] = "A";
				$record['color'] = "#FF7C7C";
				$record['absent'] = true;
			}
		}else if($day == "Sun"){
			$record['type'] = " - ";
			$record['color'] = "#F4F4F4";
		}else{
			$record['type'] = " - ";
			$record['color'] = "";
		}
		return $record;
	}
}
/* End of file Attendance_model.php */
/* Location: ./application/modules/attendance/models/Attendance_model.php */