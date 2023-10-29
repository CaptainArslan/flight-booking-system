<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends PL_Controller
{

	public $headdata;
	public function __construct()
	{
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url('login?err=no_login'));
		}
		$this->headdata = array(
			'head' => array(
				'page_title' => 'Booking',
				'css' => array(
					//'assets/css/style0.css',
				),
			),
			'scripts' => array(
				'js' => array(
					//'assets/js/js0.js',
				),
			),
		);
		$this->load->model('booking_model');
		$this->load->model('mailer_model');
		// $this->load->library('pdf');
	}
	public function add()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (!checkAccess($user_role, 'all_agents_add_booking')) {
			$agent = $user_name;
		}
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		$data['d_page_title'] = 'Add Booking';
		$data['head']['page_title'] = $data['d_page_title'];
		$data['booking_agents'] = $this->booking_model->Getagents($agent, $brand);
		$data['booking_brands'] = $this->booking_model->Getbrands($brand);
		$data['booking_suppliers'] = $this->booking_model->Getsuppliers();
		if (checkAccess($user_role, 'add_booking_view')) {
			$this->load->view('booking/add', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function addflight()
	{
		$data = $this->input->post();
		unset($data['files']);
		$bkgid = $data['bkg_no'];
		$flt_details = $data['flight'];
		$flt_details['leg'] = @$data['leg'];
		$this->db->set('flight', '1');
		$this->db->where('bkg_no', $bkgid);
		$this->db->update('bookings');
		$this->booking_model->add_flight($flt_details, $bkgid);
		$response = array(
			'status' => 'success',
			'response' => 'Flight Added Successfully..!!!'
		);
		$this->session->set_flashdata('notify', json_encode($response));
		$url = $_SERVER['HTTP_REFERER'];
		redirect($url, 'refresh');
	}
	public function addhotel()
	{
		$data = $this->input->post();
		$this->db->set('hotel', '1');
		$this->db->where('bkg_no', $data['hotel']['bkg_no']);
		$this->db->update('bookings');
		$hotel = $data['hotel'];
		$hotel['checkin'] = date('Y-m-d', strtotime($hotel['checkin']));
		$hotel['checkout'] = date('Y-m-d', strtotime($hotel['checkout']));
		$this->db->insert('bookings_hotel', $hotel);
		$response = array(
			'status' => 'success',
			'response' => 'Hotel Added Successfully..!!!'
		);
		$this->session->set_flashdata('notify', json_encode($response));
		$url = $_SERVER['HTTP_REFERER'];
		redirect($url, 'refresh');
	}
	public function addcab()
	{
		$data = $this->input->post();
		$this->db->set('cab', '1');
		$this->db->where('bkg_no', $data['cab']['bkg_no']);
		$this->db->update('bookings');
		$cab = $data['cab'];
		$cab['from_date'] = date('Y-m-d', strtotime($cab['from_date']));
		$cab['to_date'] = date('Y-m-d', strtotime($cab['to_date']));
		$this->db->insert('bookings_cab', $cab);
		$response = array(
			'status' => 'success',
			'response' => 'Cab Added Successfully..!!!'
		);
		$this->session->set_flashdata('notify', json_encode($response));
		$url = $_SERVER['HTTP_REFERER'];
		redirect($url, 'refresh');
	}
	public function pending($bkg_id = '')
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (empty($bkg_id)) {
			if (empty($_REQUEST) && checkAccess($user_role, 'all_agents_pending_booking')) {
				if (!empty($_REQUEST['agent'])) {
					$agent = $_REQUEST['agent'];
				} else {
					$agent = '';
				}
				if (!empty($_REQUEST['brand']) && $_REQUEST['brand'] != 'All') {
					$brand = $_REQUEST['brand'];
				} else {
					$brand = '';
				}
			} else {
				if (!checkAccess($user_role, 'all_agents_pending_booking')) {
					$agent = $user_name;
				}
				if ($user_brand != 'All') {
					$brand = $user_brand;
				}
			}
			$data['d_page_title'] = 'Pending Bookings';
			$data['head']['page_title'] = $data['d_page_title'];
			if (checkAccess($user_role, 'pending_booking_view')) {
				$data['booking_brands'] = $this->booking_model->getBookingBands();
				$data['pending_bookings'] = $this->booking_model->GetPendingBookings($agent, $brand);
				$this->load->view('booking/list', $data);
			} else {
				$this->load->view('access_denied', $data);
			}
		} else {
			$bkg_id = hashing($bkg_id, 'd');
			$data["css_includes"][] = "assets/node_modules/summernote/dist/summernote.css";
			$data["js_includes"][] = "assets/node_modules/summernote/dist/summernote.min.js?v1.3";
			$data["js_includes"][] = "assets/node_modules/datatables/jquery.dataTables.min.js?v1.3";
			$data["js_includes"][] = "dist/js/typeahead.js?v1.3";
			$data["js_includes"][] = "dist/js/pendingbooking.js?v1.9";
			if (checkAccess($user_role, 'add_transaction') || checkAccess($user_role, 'edit_transaction') || checkAccess($user_role, 'delete_transaction')) {
				$data["js_includes"][] = "dist/js/transaction.js?v1.3";
			}
			$data['booking'] = $this->booking_model->GetBookingDetails($bkg_id);
			if (checkAccess($user_role, 'view_booking_page') && ($user_brand == 'All' || $user_brand == $data['booking']['bkg_brandname'])) {

				// echo $data['booking']['bkg_status'];
				// exit;

				if ($data['booking']['bkg_status'] == 'Pending' || $data['booking']['bkg_status'] == 'Cancelled Pending') {
					$data['flight_leg'] = $this->booking_model->GetBookingflight($bkg_id);
					// getting hotels from here
					$data['hotels'] = $this->booking_model->GetMultipleBookinghotel($bkg_id);
					$data['visa'] = $this->booking_model->GetBookingVisa($bkg_id);
					$data['booking_suppliers'] = $this->booking_model->Getsuppliers();
					$data['cab'] = $this->booking_model->GetBookingcab($bkg_id);
					$data['brand'] = $this->booking_model->GetBookingbrand($data['booking']['bkg_brandname']);
					$data['pax'] = $this->booking_model->GetBookingpax($bkg_id);
					$data['bkg_note'] = $this->booking_model->GetBookingnotes($bkg_id);
					$data['bkg_cmnt'] = $this->booking_model->GetBookingcmnt($bkg_id);
					$data['cust_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "customer");
					if (checkAccess($user_role, 'admin_view_booking_page')) {
						$data['supp_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "supplier");
					}
					if (checkAccess($user_role, 'add_transaction') || checkAccess($user_role, 'edit_transaction') || checkAccess($user_role, 'delete_transaction')) {
						$data['trans_head'] = $this->booking_model->GetTransHead();
					}
					$data['bank_head'] = $this->booking_model->GetHeadsBymode('bank');
					$data['payment_requests'] = $this->booking_model->GetpaymentRequest($bkg_id);
					$data['sendpayment_auth'] = '1';
					foreach ($data['payment_requests'] as $key => $req) {
						if ($req['payment_type'] == '3D Card Payment Link') {
							$data['sendpayment_auth'] = '0';
						}
					}
					$data['tkt_requests'] = $this->booking_model->GettktRequest($bkg_id);
					$data['files'] = $this->booking_model->getBookingFiles($bkg_id);
					$data['inv'] = $this->booking_model->getinvdata($bkg_id);
					$data['head']['page_title'] = $bkg_id . " " . $data['booking']['bkg_status'];
					$this->load->view('booking/view', $data);
				} else {
					$status = $data['booking']['bkg_status'];
					header("Location:" . base_url("booking/" . $status . "/" . hashing($bkg_id)));
				}
			} else {
				$this->load->view('access_denied', $data);
			}
		}
	}
	public function cancelled_panding()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (!checkAccess($user_role, 'all_agents_pending_booking')) {
			$agent = $user_name;
		}
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		$data['d_page_title'] = 'Hold Bookings';
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'cancelled_pending_booking_view')) {
			$data['pending_bookings'] = $this->booking_model->GetCancelledPendingBookings($agent, $brand);
			$this->load->view('booking/list', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function issued($bkg_id = '')
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (!checkAccess($user_role, 'all_agents_pending_booking')) {
			$agent = $user_name;
		}
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		if (empty($bkg_id)) {
			$data['d_page_title'] = 'Issued Bookings';
			$data['head']['page_title'] = $data['d_page_title'];
			if (checkAccess($user_role, 'pending_booking_view')) {
				$data['pending_bookings'] = $this->booking_model->GetIssuedBookings($agent, $brand);
				$this->load->view('booking/list', $data);
			} else {
				$this->load->view('access_denied', $data);
			}
		} else {
			$bkg_id = hashing($bkg_id, 'd');
			$data["css_includes"][] = "assets/node_modules/summernote/dist/summernote.css";
			$data["js_includes"][] = "assets/node_modules/summernote/dist/summernote.min.js?v1.3";
			$data["js_includes"][] = "assets/node_modules/tinymce/tinymce.min.js?v1.3";
			$data["js_includes"][] = "assets/node_modules/datatables/jquery.dataTables.min.js?v1.3";
			$data["js_includes"][] = "dist/js/typeahead.js?v1.3";
			$data["js_includes"][] = "dist/js/pendingbooking.js?v1.9";
			$data["js_includes"][] = "dist/js/issued-cancelled.js?v1.3";
			$data["js_includes"][] = "dist/js/transaction.js?v1.3";
			$data['booking'] = $this->booking_model->GetBookingDetails($bkg_id);
			if (checkAccess($user_role, 'view_booking_page') && ($user_brand == 'All' || $user_brand == $data['booking']['bkg_brandname'])) {
				if ($data['booking']['bkg_status'] == 'Issued' || $data['booking']['bkg_status'] == 'Cleared') {
					$data['flight_leg'] = $this->booking_model->GetBookingflight($bkg_id);
					$data['hotel'] = $this->booking_model->GetBookinghotel($bkg_id);
					$data['booking_suppliers'] = $this->booking_model->Getsuppliers();
					$data['cab'] = $this->booking_model->GetBookingcab($bkg_id);
					$data['brand'] = $this->booking_model->GetBookingbrand($data['booking']['bkg_brandname']);
					$data['pax'] = $this->booking_model->GetBookingpax($bkg_id);
					$data['bkg_note'] = $this->booking_model->GetBookingnotes($bkg_id);
					$data['bkg_cmnt'] = $this->booking_model->GetBookingcmnt($bkg_id);
					$data['cust_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "customer");
					if (checkAccess($user_role, 'admin_view_booking_page')) {
						$data['supp_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "supplier");
					}
					if (checkAccess($user_role, 'add_transaction') || checkAccess($user_role, 'edit_transaction') || checkAccess($user_role, 'delete_transaction')) {
						$data['trans_head'] = $this->booking_model->GetTransHead();
					}
					$data['bank_head'] = $this->booking_model->GetHeadsBymode('bank');
					$data['payment_requests'] = $this->booking_model->GetpaymentRequest($bkg_id);
					$data['sendpayment_auth'] = '1';
					foreach ($data['payment_requests'] as $key => $req) {
						if ($req['payment_type'] == '3D Card Payment Link') {
							$data['sendpayment_auth'] = '0';
						}
					}
					$data['tkt_requests'] = $this->booking_model->GettktRequest($bkg_id);
					$data['files'] = $this->booking_model->getBookingFiles($bkg_id);
					$data['inv'] = $this->booking_model->getinvdata($bkg_id);
					$data['head']['page_title'] = $bkg_id . " " . $data['booking']['bkg_status'];
					$this->load->view('booking/view', $data);
				} else {
					if ($data['booking']['bkg_status'] == 'Cancelled Pending') {
						$status = 'Pending';
					} else {
						$status = $data['booking']['bkg_status'];
					}
					header("Location:" . base_url("booking/" . $status . "/" . hashing($bkg_id)));
				}
			} else {
				$this->load->view('access_denied', $data);
			}
		}
	}
	public function cancelled($bkg_id = '')
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (!checkAccess($user_role, 'all_agents_pending_booking')) {
			$agent = $user_name;
		}
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		if (empty($bkg_id)) {
			$data['d_page_title'] = 'Cancelled Bookings';
			$data['head']['page_title'] = $data['d_page_title'];
			if (checkAccess($user_role, 'pending_booking_view')) {
				$data['pending_bookings'] = $this->booking_model->GetCancelledBookings($agent, $brand);
				$this->load->view('booking/list', $data);
			} else {
				$this->load->view('access_denied', $data);
			}
		} else {
			$bkg_id = hashing($bkg_id, 'd');
			$data["css_includes"][] = "assets/node_modules/summernote/dist/summernote.css";
			$data["js_includes"][] = "assets/node_modules/summernote/dist/summernote.min.js?v1.3";
			$data["js_includes"][] = "assets/node_modules/tinymce/tinymce.min.js?v1.3";
			$data["js_includes"][] = "assets/node_modules/datatables/jquery.dataTables.min.js?v1.3";
			$data["js_includes"][] = "dist/js/typeahead.js?v1.3";
			$data["js_includes"][] = "dist/js/pendingbooking.js?v1.9";
			$data["js_includes"][] = "dist/js/transaction.js?v1.3";
			$data["js_includes"][] = "dist/js/issued-cancelled.js?v1.3";
			$data['booking'] = $this->booking_model->GetBookingDetails($bkg_id);
			if (checkAccess($user_role, 'view_booking_page') && ($user_brand == 'All' || $user_brand == $data['booking']['bkg_brandname'])) {
				if ($data['booking']['bkg_status'] == 'Cancelled') {
					$data['flight_leg'] = $this->booking_model->GetBookingflight($bkg_id);
					$data['hotel'] = $this->booking_model->GetBookinghotel($bkg_id);
					$data['booking_suppliers'] = $this->booking_model->Getsuppliers();
					$data['cab'] = $this->booking_model->GetBookingcab($bkg_id);
					$data['brand'] = $this->booking_model->GetBookingbrand($data['booking']['bkg_brandname']);
					$data['pax'] = $this->booking_model->GetBookingpax($bkg_id);
					$data['bkg_note'] = $this->booking_model->GetBookingnotes($bkg_id);
					$data['bkg_cmnt'] = $this->booking_model->GetBookingcmnt($bkg_id);
					$data['cust_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "customer");
					if (checkAccess($user_role, 'admin_view_booking_page')) {
						$data['supp_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "supplier");
					}
					if (checkAccess($user_role, 'add_transaction') || checkAccess($user_role, 'edit_transaction') || checkAccess($user_role, 'delete_transaction')) {
						$data['trans_head'] = $this->booking_model->GetTransHead();
					}
					$data['bank_head'] = $this->booking_model->GetHeadsBymode('bank');
					$data['payment_requests'] = $this->booking_model->GetpaymentRequest($bkg_id);
					$data['sendpayment_auth'] = '1';
					foreach ($data['payment_requests'] as $key => $req) {
						if ($req['payment_type'] == '3D Card Payment Link') {
							$data['sendpayment_auth'] = '0';
						}
					}
					$data['tkt_requests'] = $this->booking_model->GettktRequest($bkg_id);
					$data['files'] = $this->booking_model->getBookingFiles($bkg_id);
					$data['inv'] = $this->booking_model->getinvdata($bkg_id);
					$data['head']['page_title'] = $bkg_id . " " . $data['booking']['bkg_status'];
					$this->load->view('booking/view', $data);
				} else {
					if ($data['booking']['bkg_status'] == 'Cancelled Pending') {
						$status = 'Pending';
					} else {
						$status = $data['booking']['bkg_status'];
					}
					header("Location:" . base_url("booking/" . $status . "/" . hashing($bkg_id)));
				}
			} else {
				$this->load->view('access_denied', $data);
			}
		}
	}
	public function deleted($bkg_id = '')
	{
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$bkg_id = hashing($bkg_id, 'd');
		$data["css_includes"][] = "assets/node_modules/sweetalert/sweetalert2.min.css";
		$data["css_includes"][] = "assets/node_modules/summernote/dist/summernote.css";
		$data["js_includes"][] = "assets/node_modules/summernote/dist/summernote.min.js?v1.3";
		$data["js_includes"][] = "assets/node_modules/sweetalert/sweetalert2.min.js?v1.3";
		$data["js_includes"][] = "assets/node_modules/datatables/jquery.dataTables.min.js?v1.3";
		$data["js_includes"][] = "dist/js/typeahead.js?v1.3";
		$data["js_includes"][] = "dist/js/pendingbooking.js?v1.9";
		$data['booking'] = $this->booking_model->GetBookingDetails($bkg_id);
		if (checkAccess($user_role, 'view_booking_page') && ($user_brand == 'All' || $user_brand == $data['booking']['bkg_brandname'])) {
			if ($data['booking']['bkg_status'] == 'Deleted') {
				$data['flight_leg'] = $this->booking_model->GetBookingflight($bkg_id);
				$data['hotel'] = $this->booking_model->GetBookinghotel($bkg_id);
				$data['booking_suppliers'] = $this->booking_model->Getsuppliers();
				$data['cab'] = $this->booking_model->GetBookingcab($bkg_id);
				$data['brand'] = $this->booking_model->GetBookingbrand($data['booking']['bkg_brandname']);
				$data['pax'] = $this->booking_model->GetBookingpax($bkg_id);
				$data['bkg_note'] = $this->booking_model->GetBookingnotes($bkg_id);
				$data['bkg_cmnt'] = $this->booking_model->GetBookingcmnt($bkg_id);
				$data['cust_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "customer");
				$data['files'] = $this->booking_model->getBookingFiles($bkg_id);
				$data['inv'] = $this->booking_model->getinvdata($bkg_id);
				if (checkAccess($user_role, 'admin_view_booking_page')) {
					$data['supp_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "supplier");
				}
				$data['payment_requests'] = $this->booking_model->GetpaymentRequest($bkg_id);
				$data['tkt_requests'] = $this->booking_model->GettktRequest($bkg_id);
				$data['head']['page_title'] = $bkg_id . " " . $data['booking']['bkg_status'];
				$this->load->view('booking_view_delete', $data);
			} else {
				$status = $data['booking']['bkg_status'];
				header("Location:" . base_url("booking/" . $status . "/" . hashing($bkg_id)));
			}
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function Invoice($bkg_id = '')
	{
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['user_email'] = $user_email = $this->session->userdata('user_email');
		$bkg_id = hashing($bkg_id, 'd');
		$data['booking'] = $this->booking_model->GetBookingDetails($bkg_id);
		if ((checkBrandaccess($data['booking']['bkg_brandname'], 'invoice') && $user_brand == $data['booking']['bkg_brandname']) || ($user_brand == 'All')) {
			$data['brand'] = $this->booking_model->GetBookingbrand($data['booking']['bkg_brandname']);
			$data['hotel'] = $this->booking_model->GetBookinghotel($bkg_id);
			$data['booking_suppliers'] = $this->booking_model->Getsuppliers();
			$data['cab'] = $this->booking_model->GetBookingcab($bkg_id);
			$data['pax'] = $this->booking_model->GetBookingpax($bkg_id);
			$data['cust_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "customer");
			$data['head']['page_title'] = "Invoice " . $bkg_id;
			$this->load->view('booking/invoice', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function Alert($type = '')
	{
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (!empty($_REQUEST) && checkAccess($user_role, 'all_agents_pending_booking')) {
			if (!empty($_REQUEST['agent'])) {
				$agent = $_REQUEST['agent'];
			} else {
				$agent = '';
			}
			if (!empty($_REQUEST['brand']) && $_REQUEST['brand'] != 'All') {
				$brand = $_REQUEST['brand'];
			} else {
				$brand = '';
			}
		} else {
			if (!checkAccess($user_role, 'all_agents_pending_booking')) {
				$agent = $user_name;
			}
			if ($user_brand != 'All') {
				$brand = $user_brand;
			}
		}
		if ($type == 'departure_date') {
			$data['d_page_title'] = "Upcoming Traveling - Say Good Bye";
			$data['date_type'] = 'Traveling';
		} elseif ($type == 'retrun_date') {
			$data['d_page_title'] = "Passenger Return - Say Hi";
			$data['date_type'] = 'Return';
		} elseif ($type == 'birthday') {
			$data['d_page_title'] = "Passenger's Birthday - Say Happy Birthday";
			$data['date_type'] = 'Traveling';
		}
		$this->header_data["title"] = $data['d_page_title'];
		$data["css_includes"][] = "assets/node_modules/summernote/dist/summernote.css";
		$data["js_includes"][] = "assets/node_modules/summernote/dist/summernote.min.js?v1.3";
		$data["js_includes"][] = "/assets/node_modules/datatables/jquery.dataTables.min.js?v1.3";
		$data["js_includes"][] = "dist/js/pendingbooking.js?v1.9";
		if (checkAccess($user_role, 'pending_booking_view')) {
			$data['pending_bookings'] = $this->booking_model->getdept_due($brand, $agent, $type);
			$data['brands'] = GetBrands();
			$data['brand'] = $brand;
			$this->load->view('booking_alert_list', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function send_invoice()
	{
		$data = $this->input->post();
		$bkg_id = $data['bkg_no'];
		$inv['booking'] = $this->booking_model->GetBookingDetails($bkg_id);
		$inv['brand'] = $this->booking_model->GetBookingbrand($inv['booking']['bkg_brandname']);
		$inv['flight_leg'] = $this->booking_model->GetBookingflight($bkg_id);
		$inv['pax'] = $this->booking_model->GetBookingpax($bkg_id);
		$inv['cust_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "customer");
		$data['invoice'] = $this->load->view('ajax/invoice', $inv, true);
		$invoice_hmtl = preg_replace('/>\s+</', "><", $data['invoice']);
		$this->pdf->loadHtml($invoice_hmtl);
		$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->render();
		$pdf_file = $this->pdf->output();
		$brand_name = $inv['booking']['bkg_brandname'];
		$user = $this->db->select('user_work_email')->from('user_profile')->where('user_id', $this->session->userdata('user_id'))->get()->row_array();
		$user_mail = $user['user_work_email'];
		$brand = $this->db->select('brand_email')->from('brand')->where('brand_name', $brand_name)->get()->row_array();
		$brand_mail = $brand['brand_email'];

		$to = $data['emailTo'];
		$from = $brand_mail;
		$cc = $brand_mail . ',' . $user_mail;
		$subject = "Booking Confirmation Invoice " . $bkg_id;
		$message = $data['emailMessage'];
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from($from, $brand_name);
		$this->email->to($to);
		$this->email->cc($cc);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->attach($pdf_file, 'application/pdf', "Invoice-" . $bkg_id . ".pdf", false);
		$r = @$this->email->send();
		if ($r) {
			$result = 'true';
		} else {
			$result = 'false';
		}
		echo json_encode($result);
	}
	public function gettranshead()
	{
		$result = array();
		$data['trans_head'] = $this->booking_model->GetTransHead();
		foreach ($data['trans_head'] as $key => $value) {
			$result[] = $value['trans_head'];
		}
		echo json_encode($result);
	}
	// public function add_booking()
	// {
	// 	$data = $this->input->post();
	// 	$user_role = $agent = $brand = '';
	// 	$user_role = $this->session->userdata('user_role');
	// 	$user_name = $this->session->userdata('user_name');
	// 	$user_brand = $this->session->userdata('user_brand');
	// 	if (!checkAccess($user_role, 'all_agents_add_booking')) {
	// 		$data['booking_agent'] = $user_name;
	// 	}
	// 	if (!checkAccess($user_role, 'admin_view_add_booking')) {
	// 		$data['booking_brand'] = $user_brand;
	// 	}
	// 	$result = array();
	// 	$flt_details = $data['flight'];
	// 	if ($flt_details['flight_segments'] > 0) {
	// 		$flt_details['leg'] = $data['leg'];
	// 		unset($data['leg']);
	// 	}
	// 	$htl_details = $data['hotel'];
	// 	$htl_details['checkin'] = date('Y-m-d H:i:s', strtotime($htl_details['checkin']));
	// 	$htl_details['checkout'] = date('Y-m-d H:i:s', strtotime($htl_details['checkout']));
	// 	$cab_details = $data['cab'];
	// 	$cab_details['from_date'] = date('Y-m-d H:i:s', strtotime($cab_details['from_date']));
	// 	$cab_details['to_date'] = date('Y-m-d H:i:s', strtotime($cab_details['to_date']));
	// 	unset($data['flight']);
	// 	unset($data['hotel']);
	// 	unset($data['cab']);
	// 	$bkgid = $this->booking_model->new_booking($data);
	// 	if (isset($data['flightcheck']) && $data['flightcheck']) {
	// 		$this->booking_model->add_flight($flt_details, $bkgid);
	// 	}
	// 	if (isset($data['hotelcheck']) && $data['hotelcheck']) {
	// 		$this->booking_model->add_hotel($htl_details, $bkgid);
	// 	}
	// 	if (isset($data['cabcheck']) && $data['cabcheck']) {
	// 		$this->booking_model->add_cab($cab_details, $bkgid);
	// 	}
	// 	$result['bkg_id'] = hashing($bkgid);
	// 	$response = array(
	// 		'status' => 'success',
	// 		'response' => 'Booking Added Successfully..!!!'
	// 	);
	// 	$this->session->set_flashdata('notify', json_encode($response));
	// 	$result['status'] = 'True';
	// 	echo json_encode($result);
	// }
	public function add_booking()
	{
		$data = $this->input->post();

		$user_role = $agent = $brand = '';
		$user_role = $this->session->userdata('user_role');
		$user_name = $this->session->userdata('user_name');
		$user_brand = $this->session->userdata('user_brand');

		$this->db->trans_start(); // Start a database transaction

		try {
			if (!checkAccess($user_role, 'all_agents_add_booking')) {
				$data['booking_agent'] = $user_name;
			}
			if (!checkAccess($user_role, 'admin_view_add_booking')) {
				$data['booking_brand'] = $user_brand;
			}

			$result = array();
			$flt_details = $data['flight'];

			if ($flt_details['flight_segments'] > 0) {
				$flt_details['leg'] = $data['leg'];
				unset($data['leg']);
			}

			$htl_details = $data['hotel'];
			$cab_details = $data['cab'];
			$visa_details = $data['visa'];

			unset($data['flight']);
			unset($data['hotel']);
			unset($data['cab']);

			$bkgid = $this->booking_model->new_booking($data);

			if (isset($data['flightcheck']) && $data['flightcheck']) {
				$this->booking_model->add_flight($flt_details, $bkgid);
			}

			if (isset($data['hotelcheck']) && $data['hotelcheck'] && is_array($htl_details['name'])) {
				for ($i = 0; $i < count($htl_details['name']); $i++) {
					$htl_data = array(
						'name' => $htl_details['name'][$i],
						'supplier' => $htl_details['supplier'][$i],
						'ref_name' => $htl_details['ref_name'][$i],
						'sup_ref' => $htl_details['sup_ref'][$i],
						'location' => $htl_details['location'][$i],
						'checkin' => date('Y-m-d H:i:s', strtotime($htl_details['checkin'][$i])),
						'checkout' => date('Y-m-d H:i:s', strtotime($htl_details['checkout'][$i])),
						'rooms' => $htl_details['rooms'][$i],
						'details' => $htl_details['details'][$i],
						'cost' => $htl_details['cost'][$i],
					);

					// Create booking for each hotel
					$this->booking_model->add_hotel($htl_data, $bkgid);
				}
			}

			if (isset($data['cabcheck']) && $data['cabcheck']) {
				$cab_details['from_date'] = date('Y-m-d H:i:s', strtotime($cab_details['from_date']));
				$cab_details['to_date'] = date('Y-m-d H:i:s', strtotime($cab_details['to_date']));
				$this->booking_model->add_cab($cab_details, $bkgid);
			}

			if (isset($data['visacheck'])  && $data['visacheck']) {
				$this->booking_model->add_visa($visa_details, $bkgid);
			}

			$this->db->trans_complete(); // Commit the database transaction

			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Database transaction failed');
			}

			$result['bkg_id'] = hashing($bkgid);
			$response = array(
				'status' => 'success',
				'response' => 'Booking Added Successfully..!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			$result['status'] = 'True';
			echo json_encode($result);
		} catch (Exception $e) {
			$this->db->trans_rollback(); // Rollback the transaction if an exception occurs
			echo 'Transaction failed: ' . $e->getMessage();
		}
	}

	public function getAirport()
	{
		$out = '';
		$q = $this->input->get('query');
		$airports = $this->booking_model->GetAirports($q);
		foreach ($airports as $key => $value) {
			$out .= '"' . $value["airport_name"] . ' - ' . $value["airport_code"] . '",';
		}
		echo '[' . trim($out, ",") . ']';
	}
	public function getAirline()
	{
		$out = '';
		$q = $this->input->get('query');
		$airports = $this->booking_model->GetAirline($q);
		foreach ($airports as $key => $value) {
			$out .= '"' . $value["airline_name"] . ' - ' . $value["airline_code"] . '",';
		}
		echo '[' . trim($out, ",") . ']';
	}
	public function inlineEdit()
	{
		$user_role = $this->session->userdata('user_role');
		$user_brand = $this->session->userdata('user_brand');
		$data = $this->input->post();
		if ($data['editfor'] == 'flight') {
			$table = 'bookings';
		} else if ($data['editfor'] == 'hotel') {
			$table = 'bookings_hotel';
		} else if ($data['editfor'] == 'cab') {
			$table = 'bookings_cab';
		}
		unset($data['editfor']);
		$extra_cost = array('cost_bank_charges_internal', 'cost_cardcharges', 'cost_postage', 'cost_cardverfication');
		if ((status_check($data['bkg_no'], 'Pending') || status_check($data['bkg_no'], 'Cancelled Pending')) && (checkagntbkg($data['bkg_no']) || checkAccess($user_role, 'admin_view_booking_page')) && ($user_brand == 'All' || checkbrndbkg($data['bkg_no']))) {
			foreach ($data as $key => $value) {
				if ($key == 'bkg_no') {
					continue;
				} else {
					if (in_array($key, $extra_cost)) {
						if (checkAccess($user_role, 'add_cost_edit_booking_page')) {
							$result = $this->booking_model->inlineUpdate($data, $table);
							$result['toaster'] = 'success';
						} else {
							$result['status'] = 'false';
							$result['toaster'] = 'error';
						}
					} else {
						if ($key != 'flt_bookingnote') {
							$result = $this->booking_model->inlineUpdate($data, $table);
							$result['toaster'] = 'success';
						} else {
							$result = $this->booking_model->addbookingnote($data);
							$result['toaster'] = 'success';
						}
					}
				}
			}
			echo json_encode($result);
		} else {
			$result['status'] = 'false';
			$result['toaster'] = 'error';
			echo json_encode($result);
		}
	}
	public function amendsegajax()
	{
		$user_role = $this->session->userdata('user_role');
		$user_brand = $this->session->userdata('user_brand');
		$data['bkg_id'] = $this->input->post('booking_id');
		if ((status_check($data['bkg_id'], 'Pending') || status_check($data['bkg_id'], 'Cancelled Pending')) && (checkagntbkg($data['bkg_id']) || checkAccess($user_role, 'admin_view_booking_page')) && ($user_brand == 'All' || checkbrndbkg($data['bkg_id']))) {
			$data['flight_leg'] = $this->booking_model->GetBookingflight($data['bkg_id']);
			$html = $this->load->view('ajax/amendsegments', $data, true);
			$result['toaster'] = 'success';
			$result['html'] = $html;
			echo json_encode($result);
		} else {
			$result['toaster'] = 'error';
			echo json_encode($result);
		}
	}
	public function amendpaxajax()
	{
		$user_role = $this->session->userdata('user_role');
		$user_brand = $this->session->userdata('user_brand');
		$data['bkg_id'] = $this->input->post('booking_id');
		if ((status_check($data['bkg_id'], 'Pending') || status_check($data['bkg_id'], 'Cancelled Pending')) && (checkagntbkg($data['bkg_id']) || checkAccess($user_role, 'admin_view_booking_page')) && ($user_brand == 'All' || checkbrndbkg($data['bkg_id']))) {
			$data['pax'] = $this->booking_model->GetBookingpax($data['bkg_id']);
			$html = $this->load->view('booking/ajax/amendpax', $data, true);
			$result['toaster'] = 'success';
			$result['html'] = $html;
			echo json_encode($result);
		} else {
			$result['toaster'] = 'error';
			echo json_encode($result);
		}
	}
	public function update_flightsegment()
	{
		$data = $this->input->post();
		if (status_check($data['bkg_id'], 'Pending') || status_check($data['bkg_id'], 'Cancelled Pending')) {
			$result['status'] = $this->booking_model->updateFlights($data);
			$response = array(
				'status' => 'success',
				'response' => 'Flight Segment Updated Successfully..!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo json_encode($result);
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Booking is not Pending'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo json_encode('false');
		}
	}
	public function update_pax()
	{
		$data = $this->input->post();
		if (status_check($data['bkg_id'], 'Pending') || status_check($data['bkg_id'], 'Cancelled Pending')) {
			$result['status'] = $this->booking_model->updatePax($data);
			$response = array(
				'status' => 'success',
				'response' => 'Passengers Updated Successfully..!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo json_encode($result);
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Booking is not Pending'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo json_encode('false');
		}
	}
	public function selectdata()
	{
		$user_role = $agent = $brand = '';
		$user_role = $this->session->userdata('user_role');
		$user_name = $this->session->userdata('user_name');
		$user_brand = $this->session->userdata('user_brand');
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		if (!checkAccess($user_role, 'all_agents_booking_page')) {
			$agent = $user_name;
		}
		$selectFor = $this->input->post("dataform");
		if ($selectFor == 'bkg_brandname') {
			$result = array();
			$data['booking_brands'] = $this->booking_model->Getbrands($brand);
			foreach ($data['booking_brands'] as $value) {
				$result[] = $value['brand_name'];
			}
		} elseif ($selectFor == 'bkg_agent') {
			$result = array();
			$data['booking_agents'] = $this->booking_model->Getagents($agent, $brand);
			foreach ($data['booking_agents'] as $value) {
				$result[] = $value['user_name'];
			}
		} elseif ($selectFor == 'sup_name' || $selectFor == 'supplier') {
			$result = array();
			$data['booking_suppliers'] = $this->booking_model->Getsuppliers();
			foreach ($data['booking_suppliers'] as $key => $value) {
				$result[] = $value['supplier_name'];
			}
		} elseif ($selectFor == 'pmt_payingby') {
			$result = array("Self", "Third Party");
		} elseif ($selectFor == 'pmt_mode') {
			$result = array("Cash", "Bank Transfer", "Credit Card", "Debit Card", "American Express");
		} elseif ($selectFor == 'flt_flighttype') {
			$result = array("Oneway", "Return");
		} elseif ($selectFor == 'flt_class') {
			$result = array("Economy", "Economy Premium", "Business", "First Class");
		} elseif ($selectFor == 'flt_gds') {
			$result = array("Worldspan", "Galileo", "Sabre", "Amadeus", "Web");
		} elseif ($selectFor == 'cst_source') {
			$result = array("Newsletter", "Google", "Bing", "SMS", "Friend", "Repeat");
		} elseif ($selectFor == 'trip') {
			$result = array("Round", "Oneway", "Cab Hire");
		}
		echo json_encode($result);
	}
	public function addpaymentRequest()
	{
		$data = $this->input->post();
		$result['status'] = $this->booking_model->addPaymentReq($data);
		if ($result['status'] == 'true') {
			$response = array(
				'status' => 'success',
				'response' => 'Payment Request Sent Successfully..!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Payment Request Not Sent...!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		}
		echo json_encode($result);
	}
	public function addtktRequest()
	{
		$data = $this->input->post();
		$result['status'] = $this->booking_model->addTktReq($data);
		if ($result['status'] == 'true') {
			$response = array(
				'status' => 'success',
				'response' => 'Ticket Request Sent Successfully..!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Ticket Request Not Sent...!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		}
		echo json_encode($result);
	}
	public function cancelPending()
	{
		$bkg_id = $this->input->post('bkg_id');
		if (status_check($bkg_id, 'Pending') || status_check($bkg_id, 'Cancelled Pending')) {
			$result = $this->booking_model->cancelPending($bkg_id);
			echo json_encode($result);
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Booking is not Pending'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo json_encode('false');
		}
	}
	public function createDuplicate()
	{
		$user_role = $this->session->userdata('user_role');
		if (checkAccess($user_role, 'duplicate_booking')) {
			$bkg_id = $this->input->post('bkg_id');
			$result = $this->booking_model->createDup($bkg_id);
			echo json_encode($result);
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Access Denied..!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo json_encode('false');
		}
	}
	public function viewcardajax()
	{
		$user_role = $this->session->userdata('user_role');
		$data['bkg_id'] = $bkg_id = $this->input->post('bkgId');
		if (!empty($_REQUEST['amount'])) {
			$data['amount'] = @$this->input->post('amount');
		}
		if (checkAccess($user_role, 'card_charge_booking_page')) {
			$data['details'] = $this->booking_model->GetCardDetails($bkg_id);
			$html = $this->load->view('booking/ajax/cardcharge', $data, true);
			echo json_encode($html);
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Acess Denied'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo json_encode('false');
		}
	}
	public function issuetktajax()
	{
		$data = $this->input->post();
		$bkg_id = $data['bkgId'];
		if (status_check($bkg_id, 'Pending') || status_check($bkg_id, 'Cancelled Pending')) {
			$data['bkg'] = $this->booking_model->GetissuanceDetails($bkg_id);
			if ($data['bkg']['hotel']) {
				$data['htl'] = $this->booking_model->GetBookinghotel($bkg_id);
			}
			if ($data['bkg']['cab']) {
				$data['cab'] = $this->booking_model->GetBookingcab($bkg_id);
			}
			$data['pax'] = $this->booking_model->GetBookingpax($bkg_id);
			$data['cust_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "customer");
			$data['supp_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "supplier");
			$data['suppliers'] = $this->booking_model->Getsuppliers();
			$html = $this->load->view('booking/ajax/issuancedetails', $data, true);
			echo json_encode($html);
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Booking is not Pending'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo json_encode('false');
		}
	}
	public function issuebooking()
	{
		$data = $this->input->post();
		$updateBooking = $this->booking_model->updateBookingissuance($data);
		if ($updateBooking) {
			$issuanceData = array();
			$issuanceData['admin_cost'] = (float)$data["cost_bank_charges_internal"] + (float)$data["cost_cardcharges"] + (float)$data["cost_postage"] + (float)$data["cost_cardverfication"];
			$issuanceData['total_sale'] = (float)$data["totalsale"];
			$issuanceData['profit'] = (float)$issuanceData['total_sale'] -  (float)$issuanceData['admin_cost'];
			$issuanceData['cab'] = $data['cab'];
			$issuanceData['flight'] = $data['flight'];
			$issuanceData['hotel'] = $data['hotel'];
			if ($data['flight']) {
				$issuanceData['flt_sup'] = $data["supplier_name"];
				$issuanceData['flt_price'] = $data["totalflight"];
				$issuanceData['flt_cost'] = (float)$data["cost_basic"] + (float)$data["cost_tax"] + (float)$data["cost_apc"] + (float)$data["cost_misc"];
				$issuanceData['profit'] -= $issuanceData['flt_cost'];
			}
			if ($data['hotel']) {
				$issuanceData['htl_sup'] = $data['htl_sup'];
				$issuanceData['htl_price'] = $data["totalhotel"];
				$issuanceData['htl_cost'] = $data['htl_cost'];
				$issuanceData['profit'] -= $issuanceData['htl_cost'];
			}
			if ($data['cab']) {
				$issuanceData['cab_sup'] = $data['cab_sup'];
				$issuanceData['cab_price'] = $data["totalcab"];
				$issuanceData['cab_cost'] = $data['cab_cost'];
				$issuanceData['profit'] -= $issuanceData['cab_cost'];
			}
			$issuanceData['apc_payable'] = (float)$data["cost_postage"];
			$issuanceData['bkg_no'] = $data["bkg_no"];
			$issuanceData['issue_date'] = $data["issue_date"];
			$salepurchase = $this->booking_model->insertSalePurchase($issuanceData);
			echo json_encode($salepurchase);
		}
	}
	public function cancelTicket()
	{
		$data = $this->input->post();
		$cancelBkg = $this->booking_model->cancelBooking($data);
		if ($cancelBkg['status'] == 'true') {
			$response = array(
				'status' => 'success',
				'response' => 'Booking Cancelled Successfully..!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		} elseif ($cancelBkg['status'] == 'true') {
			$response = array(
				'status' => 'error',
				'response' => 'There is some error, try again..!!!'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		}
		echo json_encode($cancelBkg);
	}
	public function DeleteBooking()
	{
		$bkg_id = $this->input->post('bkg_id');
		if (status_check($bkg_id, 'Pending') || status_check($bkg_id, 'Cancelled Pending')) {
			$result = $this->booking_model->DeleteBkg($bkg_id);
			echo json_encode($result);
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Booking is not Pending'
			);
			$this->session->set_flashdata('notify', json_encode($response));
			echo json_encode('false');
		}
	}
	public function searchreasults()
	{
		$search_value = $this->input->get_post('search_value');
		$search_value = str_replace(" ", "", $search_value);
		$result['results'] = $this->booking_model->searchrefbkg($search_value);
		if ($result['results'] != 'false') {
			if ($result['results']['bkg_status'] == 'Pending' || $result['results']['bkg_status'] == 'Cancelled Pending') {
				$bkg_id = hashing($result['results']['bkg_no']);
				$url = base_url("booking/pending/" . $bkg_id);
				//header('Location: '.base_url("booking/pending/".$bkg_id));
			} elseif ($result['results']['bkg_status'] == 'Issued') {
				$bkg_id = hashing($result['results']['bkg_no']);
				$url = base_url("booking/issued/" . $bkg_id);
				//header('Location: '.base_url("booking/issued/".$bkg_id));
			} elseif ($result['results']['bkg_status'] == 'Cancelled') {
				$bkg_id = hashing($result['results']['bkg_no']);
				$url = base_url("booking/cancelled/" . $bkg_id);
				//header('Location: '.base_url("booking/cancelled/".$bkg_id));
			} elseif ($result['results']['bkg_status'] == 'Deleted') {
				$bkg_id = hashing($result['results']['bkg_no']);
				$url = base_url("booking/Deleted/" . $bkg_id);
				//header('Location: '.base_url("booking/Deleted/".$bkg_id));
			}
			$result['url'] = $url;
			$result['status'] = true;
			echo json_encode($result);
		} else {
			echo json_encode(false);
			// $response = array(
			//     'status' => 'error',
			//     'response' => 'Booking not found'
			// );
			// $this->session->set_flashdata('notify', json_encode($response));
			// header('Location: '.$_SERVER['HTTP_REFERER']);
		}
	}
	public function pendingBooking()
	{
		$bkg_id = $this->input->post('bkg_id');
		$result = $this->booking_model->pendingBkg($bkg_id);
		if ($result['status']) {
			$response = array(
				'status' => 'success',
				'response' => 'Booking Status Changed...!!!'
			);
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Error While Changing Booking Status...!!!'
			);
		}
		$this->session->set_flashdata('notify', json_encode($response));
		echo json_encode($result);
	}
	public function sendpaymentlink()
	{
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data = $this->input->post();
		if (checkBrandaccess($data['brand'], 'link') || $user_brand == 'All') {
			$data['bkgRef'] = $bkgRef = _crypt($data['bkg_id'], 'e');
			$data['amt'] = $amt = _crypt($data['amount'], 'e');
			$opamount = str_replace(' ', '', $data['amount']);
			$opamount = str_replace(',', '', $opamount);
			$branddetails = getbkgbrnddetails($data['bkg_id']);
			$pform = array(
				'req_payment_date' => date('Y-m-d'),
				'bookingid' => $data['bkg_id'],
				'agentname' => $branddetails['brand_name'],
				'agentcode' => $branddetails['brand_pre_post_fix'],
				'req_note' => '3D Card Payment Has Been Requested',
				'req_payment_bank' => '',
				'req_amount' => $opamount,
				'pstatus' => 0,
				'req_payment_type' => '3D Card Payment Link',
			);
			$pid = $this->booking_model->addPaymentReqauto($pform);
			$logmsg = '3D Card Payment Link amounting &pound; ' . $data['amount'] . ' has been sent to : ' . $data['cust_email'];
			addlog($data['bkg_id'], $logmsg);
			$pid = _crypt($pid, 'e');
			$data['pmtURL'] = "https://www.web.co.uk/booking-details.php?bookingref=$bkgRef&amt=$amt&pid=$pid";
			$result['status'] = $this->mailer_model->mail_send_payemtlink($data);
		} else {
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	public function sendtkt()
	{
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data = $this->input->post();
		$status = $this->mailer_model->mail_send_etkt($data);
		if ($status) {
			$response = array(
				'status' => 'success',
				'response' => 'E-Ticket has been sent.'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'There was some error please try again later.'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		}
		redirect($_SERVER['HTTP_REFERER'], 'refresh');
	}
	public function sendreviewinvitation()
	{
		$user_role = $agent = $brand = '';
		$data = $this->input->post();
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkBrandaccess($data['bkg_brandname'], 'review') || $data['user_brand'] == 'All') {
			$log_msg = "Review Invitation Requested : <strong class='text-dark'>" . $data['cust_email'] . "</strong>";
			addlog($data['bkg_no'], $log_msg);
			echo json_encode($this->mailer_model->mail_send_review_invitation($data));
		} else {
			echo json_encode(false);
		}
	}
	public function sendreminder()
	{
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkBrandaccess($user_brand, 'reminder') || $user_brand == 'All') {
			$data = $this->input->post();
			$result['status'] = $this->mailer_model->mail_send_reminder($data);
			echo json_encode($result);
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Access Denied...!!!'
			);
			echo json_encode('false');
		}
	}
	public function sendpaymentnotification()
	{
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkBrandaccess($user_brand, 'reminder') || $user_brand == 'All') {
			$data = $this->input->post();
			$result['status'] = $this->mailer_model->mail_send_payment_notification($data);
			echo json_encode($result);
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'Access Denied...!!!'
			);
			echo json_encode('false');
		}
	}
	public function searchbooking()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if ($user_brand != 'All') {
			$brand = $user_brand;
		}
		$data['d_page_title'] = "Search Booking";
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'search_booking_view')) {
			$this->load->view('booking/search', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function searchbookingsbydate()
	{
		$data = $this->input->post();
		$data['results'] = $this->booking_model->sbbdate($data);
		$result = $this->load->view('booking/ajax/searchresult', $data, true);
		echo json_encode($result);
	}
	public function searchbookingsbyvalue()
	{
		$data = $this->input->post();
		$data['results'] = $this->booking_model->sbbvalue($data);
		//echo $this->db->last_query();
		$result = $this->load->view('booking/ajax/searchresult', $data, true);
		echo json_encode($result);
	}
	public function uploadFile()
	{
		$config = array();
		$config['upload_path'] = "./uploads/file_data"; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|csv|txt|doc|docx|rar|zip|svg|xml|GIF|JPG|PNG|JPEG|PDF|DOC|XML|DOCX|xls|xlsx|CSV|TXT|SVG';
		$config['max_size'] = 10000;
		$config['file_ext_tolower'] = true;
		$config['file_name'] = "Upload-" . date("d_M_Y-h_i_s_A");
		$this->load->library('upload', $config);
		$data = $this->input->post();
		if (!empty($_FILES['upload_file']['name'])) {
			$uploading = $this->upload->do_upload('upload_file');
			$error = array('error' => $this->upload->display_errors());
			if ($uploading) {
				$upload_name   = $this->upload->data();
				$data['fileName']  = $upload_name['file_name']; //get file name
				$result = $this->booking_model->uploadFile($data);
				if ($result > 0) {
					$response = array(
						'status' => 'success',
						'response' => 'File Uploaded'
					);
					$this->session->set_flashdata('notify', json_encode($response));
					redirect($_SERVER['HTTP_REFERER']);
				}
			} else {
				$response = array(
					'status' => 'error',
					'response' => $error['error']
				);
				$this->session->set_flashdata('notify', json_encode($response));
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}
	public function deleteFiles()
	{
		$data = $this->input->post();
		$path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/file_data/';
		$files = glob($path . $data['file']);
		foreach ($files as $key => $file) {
			unlink($file);
		}
		$this->db->where('file_name', $data['file']);
		$this->db->where('booking_id', $data['bkg']);
		$this->db->delete('booking_file');
		echo json_encode(true);
	}
	public function updateservices()
	{
		$data = $this->input->post();
		$result = $this->booking_model->updateServices($data);
		if ($result) {
			$response = array(
				'status' => 'success',
				'response' => 'file updated'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		} else {
			$response = array(
				'status' => 'error',
				'response' => 'There was some error please try again'
			);
			$this->session->set_flashdata('notify', json_encode($response));
		}
		echo json_encode($result);
	}
}

/* End of file Add_booking.php */
/* Location: ./application/controllers/Add_booking.php */
