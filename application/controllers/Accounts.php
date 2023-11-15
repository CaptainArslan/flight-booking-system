<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accounts extends PL_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!checkLogin()) {
			redirect(base_url('login?err=no_login'));
		}
		$this->headdata = array(
			'head' => array(
				'page_title' => 'Accounts',
				'css' => array(
					'assets/css/accounts.css',
				),
			),
			'scripts' => array(
				'js' => array(
					'assets/libs/datatables/jquery.dataTables.min.js',
					'assets/libs/datatables/dataTables.buttons.min.js',
					'assets/libs/datatables/jszip.min.js',
					'assets/libs/datatables/pdfmake.min.js',
					'assets/libs/datatables/vfs_fonts.js',
					'assets/libs/datatables/buttons.html5.min.js',
					'assets/libs/datatables/buttons.print.min.js',
				),
			),
		);
		$this->load->model('accounts_model');
		$this->load->model('booking_model');
	}


	public function test(){
		echo 'test';
	}

	public function new_transaction()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = "New Transaction";
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'new_transaction_view')) {
			$data['trans_head'] = $this->accounts_model->GetTransHead();
			$this->load->view('accounts/newtransaction', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function new_transaction_modal()
	{
		// die('here');
		$user_role = $this->session->userdata('user_role');
		if (checkAccess($user_role, 'add_transaction')) {
			$data = $this->input->get();
			$data['trans_head'] = $this->accounts_model->GetTransHead();
			$html = $this->load->view('accounts/ajax/new_trans_modal', $data, true);
			echo json_encode($html);
		} else {
			echo json_encode('false');
		}
	}
	public function ledgers()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = "Ledgers";
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'ledgers_view')) {
			$head_types = array('2', '5');
			$data['trans_head'] = $this->accounts_model->Getheadowners('', $head_types);
			$this->load->view('accounts/ledger', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function heads()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = "Transaction Heads";
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'head_view')) {
			if (!empty($_REQUEST['sort_by'])) {
				$sort_by = $_REQUEST['sort_by'];
			} else {
				$sort_by = '';
			}
			$data['heads'] = $this->accounts_model->get_heads($sort_by);
			$this->load->view('accounts/headlist', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function card_charge()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = "Card Charge";
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'card_charge_view')) {
			$data['trans_head'] = $this->accounts_model->Getheads('card', '1');
			$this->load->view('accounts/cardcharge', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function bank_book()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = "Bank Book";
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'bank_book_view')) {
			$data['trans_head'] = $this->accounts_model->Getheads('bank', '1');
			$this->load->view('accounts/bankbook', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function expenditures()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = "Expenditures";
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'expenditures_view')) {
			$data['trans_head'] = $this->accounts_model->Getheads('', array('3', '4'));
			$this->load->view('accounts/expenditures', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function suspense()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = "Suspense Account";
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'suspense_account_view')) {
			$data['ledg_rows'] = $this->accounts_model->Getsuspense();
			$this->load->view('accounts/suspense', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function trial_balance()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = "Trial Balance";
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'trial_balance_view')) {
			$edate = date('d-M-Y');
			$data['edate'] = $edate;
			$data['thobal'] = $this->accounts_model->GettrialBalance('', $edate);
			$this->load->view('accounts/trial_balance', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function final_accounts()
	{
		$user_role = $agent = $brand = '';
		$data = $this->headdata;
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['d_page_title'] = "Final Accounts";
		$data['head']['page_title'] = $data['d_page_title'];
		if (checkAccess($user_role, 'final_accounts_view')) {
			$date = '';
			$date = @$this->input->post('end_date');
			if ($date != '') {
				$date = $this->input->post('end_date');
				$edate = date('d-M-Y', strtotime($date));
			} else {
				$edate = date('d-M-Y');
			}
			$data['edate'] = $edate;
			$data['pnl'] = $this->accounts_model->GetprofitLoss($edate);
			$this->load->view('accounts/final_accounts', $data);
		} else {
			$this->load->view('access_denied', $data);
		}
	}
	public function addTrans()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'add_transaction')) {
			$drcounter = count($data["dr"]['trans_bkg_ref']);
			$crcounter = count($data["cr"]['trans_bkg_ref']);
			$iss_can_counter = 0;
			$iss_can_array = array();
			for ($i = 0; $i < $drcounter; $i++) {
				$bkg_no = $data['dr']['trans_bkg_ref'][$i];
				if (status_check($bkg_no, 'Issued')) {
					$iss_can_counter++;
					$status_change_msg = 'Transaction added in issued file.';
					$clr_date = getclr_cancel_date($bkg_no, 'Issued');
					$iss_can_array[$iss_can_counter]['bkg_no'] = $bkg_no;
					$iss_can_array[$iss_can_counter]['status'] = 'Issued';
					$iss_can_array[$iss_can_counter]['clr_date'] = $clr_date;
					$this->booking_model->pendingBkg($bkg_no, $status_change_msg);
				} elseif (status_check($bkg_no, 'Cancelled')) {
					$status_change_msg = 'Transaction added in cancelled file.';
					$iss_can_counter++;
					$cnl_date = getclr_cancel_date($bkg_no, 'Cancelled');
					$iss_can_array[$iss_can_counter]['bkg_no'] = $bkg_no;
					$iss_can_array[$iss_can_counter]['status'] = 'Cancelled';
					$iss_can_array[$iss_can_counter]['cnl_date'] = $cnl_date;
					$this->booking_model->pendingBkg($bkg_no, $status_change_msg);
				}
			}
			for ($j = 0; $j < $crcounter; $j++) {
				$bkg_no = $data['cr']['trans_bkg_ref'][$j];
				if (status_check($bkg_no, 'Issued')) {
					$status_change_msg = 'Transaction added in issued file.';
					$iss_can_counter++;
					$clr_date = getclr_cancel_date($bkg_no, 'Issued');
					$iss_can_array[$iss_can_counter]['bkg_no'] = $bkg_no;
					$iss_can_array[$iss_can_counter]['status'] = 'Issued';
					$iss_can_array[$iss_can_counter]['clr_date'] = $clr_date;
					$this->booking_model->pendingBkg($bkg_no, $status_change_msg);
				} elseif (status_check($bkg_no, 'Cancelled')) {
					$status_change_msg = 'Transaction added in cancelled file.';
					$iss_can_counter++;
					$cnl_date = getclr_cancel_date($bkg_no, 'Cancelled');
					$iss_can_array[$iss_can_counter]['bkg_no'] = $bkg_no;
					$iss_can_array[$iss_can_counter]['status'] = 'Cancelled';
					$iss_can_array[$iss_can_counter]['cnl_date'] = $cnl_date;
					$this->booking_model->pendingBkg($bkg_no, $status_change_msg);
				}
			}
			$data = $this->accounts_model->AddTransaction();
			if (count($iss_can_array) > 0) {
				foreach ($iss_can_array as $key => $iss_can) {
					if ($iss_can['status'] == 'Issued') {
						$this->booking_model->issueontrans($iss_can);
					} else if ($iss_can['status'] == 'Cancelled') {
						$this->booking_model->cancelontrans($iss_can);
					}
				}
			}
		} else {
			$data['status'] = false;
			$data['toaster'] = 'permission';
		}
		echo json_encode($data);
	}
	public function editTrans()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'edit_transaction')) {
			$this->accounts_model->editTransaction();
			echo "true";
		} else {
			echo "false";
		}
	}
	public function deleteTrans()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		if (checkAccess($user_role, 'delete_transaction')) {
			$transID = $this->input->post('trans_id');
			$this->accounts_model->deleteTransaction($transID);
			echo "true";
		} else {
			echo "false";
		}
	}
	public function edit_transajax()
	{
		$data['trans_id'] = $this->input->post('transId');
		$data['trans_details'] = $this->accounts_model->GetTrans($data['trans_id']);
		$data['trans_head'] = $this->accounts_model->GetTransHead();
		$data['page'] = $this->input->post('page');
		$html = $this->load->view('ajax/edittrans', $data, true);
		echo json_encode($html);
	}
	public function edit_transaction_modal()
	{
		$data['trans_id'] = $this->input->post('transId');
		$data['trans_details'] = $this->accounts_model->GetTrans($data['trans_id']);
		$data['trans_head'] = $this->accounts_model->GetTransHead();
		$data['page'] = $this->input->post('page');
		$html = $this->load->view('accounts/ajax/edit_trans_modal', $data, true);
		echo json_encode($html);
	}
	public function addtransajax()
	{
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['trans_head'] = $this->accounts_model->GetTransHead();
		$html = $this->load->view('ajax/addtransajax', $data, true);
		echo json_encode($html);
	}
	public function ledgerAjax()
	{
		$data = $this->input->post();
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['opening_balance'] = $this->accounts_model->Getbalance($data['start_date'], $data['trans_head']);
		$data['ledg_rows'] = $this->accounts_model->GetLedger($data);
		$html = $this->load->view('accounts/ajax/ledgertable', $data, true);
		echo json_encode($html);
	}
	public function cardChargeAjax()
	{
		$data = $this->input->post();
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['opening_balance'] = $this->accounts_model->GetccBalance($data);
		$data['ledg_rows'] = $this->accounts_model->GetcardCharge($data);
		$html = $this->load->view('accounts/ajax/cardchargetable', $data, true);
		echo json_encode($html);
	}
	public function bankBookAjax()
	{
		$data = $this->input->post();
		$user_role = $agent = $brand = '';
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['opening_balance'] = $this->accounts_model->GetHeadBalance($data);
		$data['ledg_rows'] = $this->accounts_model->GetbankBook($data);
		$html = $this->load->view('accounts/ajax/bankbooktable', $data, true);
		echo json_encode($html);
	}
	public function expendseAjax()
	{
		$data = $this->input->post();
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$data['opening_balance'] = $this->accounts_model->GetHeadBalance($data);
		$data['ledg_rows'] = $this->accounts_model->GetbankBook($data);
		$html = $this->load->view('accounts/ajax/exptable', $data, true);
		echo json_encode($html);
	}
	public function trialBalanceAjax()
	{
		$data = $this->input->post();
		$data['user_role'] = $user_role = $this->session->userdata('user_role');
		$data['user_name'] = $user_name = $this->session->userdata('user_name');
		$data['user_brand'] = $user_brand = $this->session->userdata('user_brand');
		$sdate = $data['start_date'];
		$edate = $data['end_date'];
		$data['thobal'] = $this->accounts_model->GettrialBalance($sdate, $edate);
		$html = $this->load->view('accounts/ajax/trialbalance', $data, true);
		echo json_encode($html);
	}
	public function loadaddhead()
	{
		$html = $this->load->view('accounts/ajax/addheadmodal', '', true);
		echo json_encode($html);
	}
	public function checkTransHead()
	{
		$trans_head = $this->input->post('trans_head');
		$result =  $this->accounts_model->checkexisthead($trans_head);
		echo json_encode($result);
	}
	public function getbrandagent()
	{
		$brand = $this->input->post('brand');
		$result = $this->accounts_model->brandagents($brand);
		echo json_encode($result);
	}
	public function appendcharges()
	{
		$html = $this->load->view('accounts/ajax/appendcharges', '', true);
		echo json_encode($html);
	}
	public function addTransHead()
	{
		$data = $this->input->post();
		$result =  $this->accounts_model->addtranshead($data);
		echo json_encode($result);
	}
	public function loadedithead()
	{
		$data['trans_head'] = $trans_head = $this->input->post('trans_head');
		$data['head'] = $this->accounts_model->gethead($trans_head);
		$data['head_charges'] = $this->accounts_model->getheadallcharges($trans_head);
		$html = $this->load->view('accounts/ajax/editheadmodal', $data, true);
		echo json_encode($html);
	}
	public function deltranshead()
	{
		$data = $this->input->post();
		$trans_head = $data['trans_head'];
		$this->accounts_model->delTrans_head($trans_head);
		echo json_encode('true');
	}
	public function updatTransHead()
	{
		$data = $this->input->post();
		$trans_head = $data['trans_head'];
		$this->accounts_model->delTrans_head($trans_head);
		$result =  $this->accounts_model->addtranshead($data);
		echo json_encode($result);
	}
}

/* End of file Accounts.php */
/* Location: ./application/controllers/Accounts.php */