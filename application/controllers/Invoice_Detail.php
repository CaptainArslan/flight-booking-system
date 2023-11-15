<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_Detail extends PL_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if (!checkLogin()) {
        //     redirect(base_url() . '?err=no_login');
        // }
        $this->footer_data = array();
        $this->sidebar_data = array();
        $this->load->model('booking_model');
        // $this->load->model('mailer_model');
        // $this->load->library('dpdf');
    }

    public function detail($bkg_id = '')
    {
        $bkg_id = hashing($bkg_id, 'd');
        $data['booking'] = $this->booking_model->GetBookingDetails($bkg_id);

        if (!empty($data['booking'])) {
            $data['brand'] = $this->booking_model->GetBookingbrand($data['booking']['bkg_brandname']);
            $data['hotel'] = $this->booking_model->GetBookinghotel($bkg_id);
            $data['booking_suppliers'] = $this->booking_model->Getsuppliers();
            $data['cab'] = $this->booking_model->GetBookingcab($bkg_id);
            $data['pax'] = $this->booking_model->GetBookingpax($bkg_id);
            $data['cust_trans'] = $this->booking_model->GetBookingTrans($bkg_id, "customer");
            $data['head']['page_title'] = "Invoice " . $bkg_id;
            $this->load->view('booking/detail', $data);
        } else {
            $this->load->view('user.access_denied');
        }
    }
}
