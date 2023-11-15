<?php
defined('BASEPATH') or exit('No direct script access allowed');
class PL_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->title = "Booking Panel";
        $this->mainbrand = "RR Travels";
        $this->mail_panel = "panel@rrtravels.co.uk";
        $this->mail_panel_title = "Panel Mail";
        $this->mail_notification = "notification@rrtravels.co.uk";
        $this->mail_notification_title = "Booking Panel - Notification";
        $this->mail_info = "info@rrtravels.co.uk";
        $this->mail_info_title = "Info RR Travels";
        $this->mail_admin = "admin@rrtravels.co.uk";
        $this->mail_admin_title = "Admin RR Travels";
        $this->mail_accounts = "accounts@rrtravels.co.uk";
        $this->mail_accounts_title = "Accounts RR Travels";
        $this->mail_payments = "payments@rrtravels.co.uk";
        $this->mail_payments_title = "Payments RR Travels";
        $this->link_web = "https://rrtravels.co.uk";
        $this->link_review_trustpilot = "rrtravels.co.uk+1b8da91203@invite.trustpilot.com";
        // $this->link_esign = "http://esign.rrtravels.co.uk";
        $this->link_esign = "http://localhost/booking";
        if (checkLogin()) {
            $profile = profileDetails();
            $this->user_profile_id = $profile['user_id'];
            if ($profile['user_full_name'] != '') {
                $this->user_name = $profile['user_full_name'];
            } else {
                $this->user_name = $this->session->userdata('user_name');
            }
            if ($profile['user_post'] != '') {
                $this->user_role = $profile['user_post'];
            } else {
                $this->user_role = $this->session->userdata('user_role');
            }
            if ($profile['user_work_email'] != '') {
                $this->user_email = $profile['user_work_email'];
            } else {
                $this->user_email = 'Add Work Email Please';
            }
            $this->user_brand = $this->session->userdata('user_brand');
            $this->user_profile_pic = $profile['user_picture_id'];
            $this->navs = array(
                array(
                    'href' => base_url('dashboard'),
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>',
                    'title' => 'Dashboard',
                    'access' => 'dashboard_view',
                    'is_active' => (current_url() == base_url('dashboard')) ? true : false,
                    'subnav' => false
                ),
                array(
                    'href' => base_url('pending_task'),
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><path d="M9 14l2 2l4 -4" /></svg>',
                    'title' => 'Pending Task',
                    'access' => 'pending_task_view',
                    'is_active' => (current_url() == base_url('pending_task')) ? true : false,
                    'subnav' => false,
                    'count' =>  totalPtasks(),
                ),
                array(
                    'href' => false,
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 10h4a2 2 0 0 1 0 4h-4l-4 7h-3l2 -7h-4l-2 2h-3l2 -4l-2 -4h3l2 2h4l-2 -7h3z" /></svg>',
                    'title' => 'Client Bookings',
                    'access' => 'pending_booking_view',
                    'is_active' => ($this->uri->segment(1) == 'booking') ? true : false,
                    'subnav' => array(
                        array(
                            'href' => base_url('booking/add'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                            <line x1="12" y1="11" x2="12" y2="17"></line>
                            <line x1="9" y1="14" x2="15" y2="14"></line></svg>',
                            'title' => 'Add',
                            'access' => 'add_booking_view',
                            'is_active' => (current_url() == base_url('booking/add')) ? true : false,
                        ), array(
                            'href' => base_url('booking/pending'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-numbers" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M11 6h9"></path>
                            <path d="M11 12h9"></path>
                            <path d="M12 18h8"></path>
                            <path d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4"></path>
                            <path d="M6 10v-6l-2 2"></path></svg>',
                            'title' => 'Pending',
                            'access' => 'pending_booking_view',
                            'is_active' => (current_url() == base_url('booking/pending')) ? true : false,
                        ), array(
                            'href' => base_url('booking/issued'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3.5 5.5l1.5 1.5l2.5 -2.5"></path>
                            <path d="M3.5 11.5l1.5 1.5l2.5 -2.5"></path>
                            <path d="M3.5 17.5l1.5 1.5l2.5 -2.5"></path>
                            <line x1="11" y1="6" x2="20" y2="6"></line>
                            <line x1="11" y1="12" x2="20" y2="12"></line>
                            <line x1="11" y1="18" x2="20" y2="18"></line></svg>',
                            'title' => 'Issued',
                            'access' => 'pending_booking_view',
                            'is_active' => (current_url() == base_url('booking/issued')) ? true : false,
                        ), array(
                            'href' => base_url('booking/cancelled'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><path d="M10 12l4 4m0 -4l-4 4" /></svg>',
                            'title' => 'Cancelled',
                            'access' => 'pending_booking_view',
                            'is_active' => (current_url() == base_url('booking/cancelled')) ? true : false,
                        ), array(
                            'href' => base_url('booking/Cancelled_panding'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="9" y1="6" x2="20" y2="6"></line>
                            <line x1="9" y1="12" x2="20" y2="12"></line>
                            <line x1="9" y1="18" x2="20" y2="18"></line>
                            <line x1="5" y1="6" x2="5" y2="6.01"></line>
                            <line x1="5" y1="12" x2="5" y2="12.01"></line>
                            <line x1="5" y1="18" x2="5" y2="18.01"></line></svg>',
                            'title' => 'Hold Bookings',
                            'access' => 'cancelled_pending_booking_view',
                            'is_active' => (current_url() == base_url('booking/Cancelled_panding')) ? true : false,
                        ), array(
                            'href' => base_url('booking/searchbooking'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="15" cy="15" r="4"></circle>
                            <path d="M18.5 18.5l2.5 2.5"></path>
                            <path d="M4 6h16"></path>
                            <path d="M4 12h4"></path>
                            <path d="M4 18h4"></path></svg>',
                            'title' => 'Search',
                            'access' => 'search_booking_view',
                            'is_active' => (current_url() == base_url('booking/searchbooking')) ? true : false,
                        )
                    ),
                ),
                array(
                    'href' => false,
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="2" /><path d="M4 13h3l3 3h4l3 -3h3" /></svg>',
                    'title' => 'Client Inquiries',
                    'access' => 'new_inq_view',
                    'is_active' => ($this->uri->segment(1) == 'inquiry') ? true : false,
                    'subnav' => array(
                        array(
                            'href' => base_url('inquiry/enq_actions'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mailbox" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 21v-6.5a3.5 3.5 0 0 0 -7 0v6.5h18v-6a4 4 0 0 0 -4 -4h-10.5"></path>
                            <path d="M12 11v-8h4l2 2l-2 2h-4"></path>
                            <path d="M6 15h1"></path></svg>',
                            'title' => 'Actions',
                            'access' => 'inq_actions_view',
                            'is_active' => (current_url() == base_url('inquiry/enq_actions')) ? true : false,
                        ), array(
                            'href' => base_url('inquiry/unpicked'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 21v-13a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-9l-4 4"></path>
                            <line x1="10" y1="11" x2="14" y2="11"></line>
                            <line x1="12" y1="9" x2="12" y2="13"></line></svg>',
                            'title' => 'New',
                            'access' => 'new_inq_view',
                            'is_active' => (current_url() == base_url('inquiry/unpicked')) ? true : false,
                        ), array(
                            'href' => base_url('inquiry/picked'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-messages" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10"></path>
                            <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2"></path></svg>',
                            'title' => 'Picked',
                            'access' => 'picked_inq_view',
                            'is_active' => (current_url() == base_url('inquiry/picked')) ? true : false,
                        ), array(
                            'href' => base_url('inquiry/closed'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="3" y1="3" x2="21" y2="21"></line>
                            <path d="M17 17h-9l-4 4v-13c0 -1.086 .577 -2.036 1.44 -2.563m3.561 -.437h8a3 3 0 0 1 3 3v6c0 .575 -.162 1.112 -.442 1.568"></path></svg>',
                            'title' => 'Closed',
                            'access' => 'closed_inq_view',
                            'is_active' => (current_url() == base_url('inquiry/closed')) ? true : false,
                        ), array(
                            'href' => base_url('inquiry/inq_reports'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-bar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="3" y="12" width="6" height="8" rx="1"></rect>
                            <rect x="9" y="8" width="6" height="12" rx="1"></rect>
                            <rect x="15" y="4" width="6" height="16" rx="1"></rect>
                            <line x1="4" y1="20" x2="18" y2="20"></line></svg>',
                            'title' => 'Reports',
                            'access' => 'inq_reports_view',
                            'is_active' => (current_url() == base_url('inquiry/inq_reports')) ? true : false,
                        ),
                    ),
                ),
                array(
                    'href' => false,
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-exposure" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                    <line x1="4.6" y1="19.4" x2="19.4" y2="4.6"></line>
                    <path d="M7 9h4m-2 -2v4"></path>
                    <line x1="13" y1="16" x2="17" y2="16"></line></svg>',
                    'title' => 'Accounts',
                    'access' => 'ledgers_view',
                    'is_active' => ($this->uri->segment(1) == 'accounts') ? true : false,
                    'subnav' => array(
                        array(
                            'href' => base_url('accounts/ledgers'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="5" y="3" width="14" height="18" rx="2"></rect>
                            <line x1="9" y1="7" x2="15" y2="7"></line>
                            <line x1="9" y1="11" x2="15" y2="11"></line>
                            <line x1="9" y1="15" x2="13" y2="15"></line>
                            </svg>',
                            'title' => 'Ledgers',
                            'access' => 'ledgers_view',
                            'is_active' => (current_url() == base_url('accounts/ledgers')) ? true : false,
                        ), array(
                            'href' => base_url('accounts/card_charge'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="5" y="3" width="14" height="18" rx="2"></rect>
                            <line x1="9" y1="7" x2="15" y2="7"></line>
                            <line x1="9" y1="11" x2="15" y2="11"></line>
                            <line x1="9" y1="15" x2="13" y2="15"></line>
                            </svg>',
                            'title' => 'Card Charge A/C',
                            'access' => 'card_charge_view',
                            'is_active' => (current_url() == base_url('accounts/card_charge')) ? true : false,
                        ), array(
                            'href' => base_url('accounts/bank_book'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="5" y="3" width="14" height="18" rx="2"></rect>
                            <line x1="9" y1="7" x2="15" y2="7"></line>
                            <line x1="9" y1="11" x2="15" y2="11"></line>
                            <line x1="9" y1="15" x2="13" y2="15"></line>
                            </svg>',
                            'title' => 'Bank Book',
                            'access' => 'bank_book_view',
                            'is_active' => (current_url() == base_url('accounts/bank_book')) ? true : false,
                        ), array(
                            'href' => base_url('accounts/expenditures'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="5" y="3" width="14" height="18" rx="2"></rect>
                            <line x1="9" y1="7" x2="15" y2="7"></line>
                            <line x1="9" y1="11" x2="15" y2="11"></line>
                            <line x1="9" y1="15" x2="13" y2="15"></line>
                            </svg>',
                            'title' => 'Expenditures',
                            'access' => 'expenditures_view',
                            'is_active' => (current_url() == base_url('accounts/expenditures')) ? true : false,
                        ), array(
                            'href' => base_url('accounts/suspense'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="5" y="3" width="14" height="18" rx="2"></rect>
                            <line x1="9" y1="7" x2="15" y2="7"></line>
                            <line x1="9" y1="11" x2="15" y2="11"></line>
                            <line x1="9" y1="15" x2="13" y2="15"></line>
                            </svg>',
                            'title' => 'Suspense Account',
                            'access' => 'suspense_account_view',
                            'is_active' => (current_url() == base_url('accounts/suspense')) ? true : false,
                        ), array(
                            'href' => base_url('accounts/new_transaction'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><rect x="4" y="5" width="16" height="16" rx="2"></rect><line x1="16" y1="3" x2="16" y2="7"></line><line x1="8" y1="3" x2="8" y2="7"></line><line x1="4" y1="11" x2="20" y2="11"></line><line x1="10" y1="16" x2="14" y2="16"></line><line x1="12" y1="14" x2="12" y2="18"></line></svg>',
                            'title' => 'New Transaction',
                            'access' => 'new_transaction_view',
                            'is_active' => (current_url() == base_url('accounts/new_transaction')) ? true : false,
                        ), array(
                            'href' => base_url('accounts/trial_balance'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0"></path>
                            <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0"></path>
                            <line x1="3" y1="6" x2="3" y2="19"></line>
                            <line x1="12" y1="6" x2="12" y2="19"></line>
                            <line x1="21" y1="6" x2="21" y2="19"></line>
                            </svg>',
                            'title' => 'Trial Balance',
                            'access' => 'trial_balance_view',
                            'is_active' => (current_url() == base_url('accounts/trial_balance')) ? true : false,
                        ), array(
                            'href' => base_url('accounts/final_accounts'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notebook" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18"></path>
                            <line x1="13" y1="8" x2="15" y2="8"></line>
                            <line x1="13" y1="12" x2="15" y2="12"></line>
                            </svg>',
                            'title' => 'Final Accounts',
                            'access' => 'final_accounts_view',
                            'is_active' => (current_url() == base_url('accounts/final_accounts')) ? true : false,
                        ), array(
                            'href' => base_url('accounts/heads'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-invoice" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                            <line x1="9" y1="7" x2="10" y2="7"></line>
                            <line x1="9" y1="13" x2="15" y2="13"></line>
                            <line x1="13" y1="17" x2="15" y2="17"></line>
                            </svg>',
                            'title' => 'Transaction Heads',
                            'access' => 'head_view',
                            'is_active' => (current_url() == base_url('accounts/heads')) ? true : false,
                        ),
                    ),
                ),
                array(
                    'href' => false,
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tools" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 21h4l13 -13a1.5 1.5 0 0 0 -4 -4l-13 13v4"></path>
                    <line x1="14.5" y1="5.5" x2="18.5" y2="9.5"></line>
                    <polyline points="12 8 7 3 3 7 8 12"></polyline>
                    <line x1="7" y1="8" x2="5.5" y2="9.5"></line>
                    <polyline points="16 12 21 17 17 21 12 16"></polyline>
                    <line x1="16" y1="17" x2="14.5" y2="18.5"></line>
                    </svg>',
                    'title' => 'Administration',
                    'access' => 'reports_view',
                    'is_active' => true,
                    'subnav' => array(
                        array(
                            'href' => base_url('reports'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="12" rx="1" /><line x1="7" y1="20" x2="17" y2="20" /><line x1="9" y1="16" x2="9" y2="20" /><line x1="15" y1="16" x2="15" y2="20" /><path d="M8 12l3 -3l2 2l3 -3" /></svg>',
                            'title' => 'Reports',
                            'access' => 'reports_view',
                            'is_active' => (current_url() == base_url('reports')) ? true : false,
                            'subnav' => false
                        ),
                        array(
                            'href' => base_url('attendance'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 14v4h4" /><circle cx="18" cy="18" r="4" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" /></svg>',
                            'title' => 'Attendance Sheet',
                            'access' => 'attendance_sheet_view',
                            'is_active' => (current_url() == base_url('attendance')) ? true : false,
                            'subnav' => false
                        ),
                        array(
                            'href' => base_url('users'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>',
                            'title' => 'Users',
                            'access' => 'users_view',
                            'is_active' => (current_url() == base_url('users')) ? true : false,
                            'subnav' => false
                        ),
                        array(
                            'href' => base_url('access_level'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 4 4 8 12 12 20 8 12 4" /><polyline points="4 12 12 16 20 12" /><polyline points="4 16 12 20 20 16" /></svg>',
                            'title' => 'Access Level',
                            'access' => 'access_level_view',
                            'is_active' => (current_url() == base_url('access_level')) ? true : false,
                            'subnav' => false
                        ),
                        array(
                            'href' => base_url('brands'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 18v-9.5a4.5 4.5 0 0 1 4.5 -4.5h7a4.5 4.5 0 0 1 4.5 4.5v7a4.5 4.5 0 0 1 -4.5 4.5h-9.5a2 2 0 0 1 -2 -2z" /><path d="M8 12h3.5a2 2 0 1 1 0 4h-3.5v-7a1 1 0 0 1 1 -1h1.5a2 2 0 1 1 0 4h-1.5" /><line x1="16" y1="16" x2="16.01" y2="16" /></svg>',
                            'title' => 'Manage Brand',
                            'access' => 'manage_brands_view',
                            'is_active' => (current_url() == base_url('brands')) ? true : false,
                            'subnav' => false
                        ),
                        array(
                            'href' => base_url('supplier'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="6" cy="19" r="2" /><circle cx="17" cy="19" r="2" /><path d="M17 17h-11v-14h-2" /><path d="M20 6l-1 7h-13" /><path d="M10 10l6 -6" /><circle cx="10.5" cy="4.5" r=".5" /><circle cx="15.5" cy="9.5" r=".5" /></svg>',
                            'title' => 'Manage Suppliers',
                            'access' => 'supplier_view',
                            'is_active' => (current_url() == base_url('supplier')) ? true : false,
                            'subnav' => false
                        ),
                    ),
                ),
                // array(
                //     'href' => base_url('reports'),
                //     'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="12" rx="1" /><line x1="7" y1="20" x2="17" y2="20" /><line x1="9" y1="16" x2="9" y2="20" /><line x1="15" y1="16" x2="15" y2="20" /><path d="M8 12l3 -3l2 2l3 -3" /></svg>',
                //     'title' => 'Reports',
                //     'access' => 'reports_view',
                //     'is_active' => (current_url() == base_url('reports'))?true:false,
                //     'subnav' => false
                // ),
                // array(
                //     'href' => base_url('attendance'),
                //     'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 14v4h4" /><circle cx="18" cy="18" r="4" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" /></svg>',
                //     'title' => 'Attendance Sheet',
                //     'access' => 'attendance_sheet_view',
                //     'is_active' => (current_url() == base_url('attendance'))?true:false,
                //     'subnav' => false
                // ),
                // array(
                //     'href' => base_url('users'),
                //     'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>',
                //     'title' => 'Users',
                //     'access' => 'users_view',
                //     'is_active' => (current_url() == base_url('users'))?true:false,
                //     'subnav' => false
                // ),
                // array(
                //     'href' => base_url('access_level'),
                //     'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 4 4 8 12 12 20 8 12 4" /><polyline points="4 12 12 16 20 12" /><polyline points="4 16 12 20 20 16" /></svg>',
                //     'title' => 'Access Level',
                //     'access' => 'access_level_view',
                //     'is_active' => (current_url() == base_url('access_level'))?true:false,
                //     'subnav' => false
                // ),
                // array(
                //     'href' => base_url('brands'),
                //     'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 18v-9.5a4.5 4.5 0 0 1 4.5 -4.5h7a4.5 4.5 0 0 1 4.5 4.5v7a4.5 4.5 0 0 1 -4.5 4.5h-9.5a2 2 0 0 1 -2 -2z" /><path d="M8 12h3.5a2 2 0 1 1 0 4h-3.5v-7a1 1 0 0 1 1 -1h1.5a2 2 0 1 1 0 4h-1.5" /><line x1="16" y1="16" x2="16.01" y2="16" /></svg>',
                //     'title' => 'Manage Brand',
                //     'access' => 'manage_brands_view',
                //     'is_active' => (current_url() == base_url('brands'))?true:false,
                //     'subnav' => false
                // ),
                // array(
                //     'href' => base_url('supplier'),
                //     'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="6" cy="19" r="2" /><circle cx="17" cy="19" r="2" /><path d="M17 17h-11v-14h-2" /><path d="M20 6l-1 7h-13" /><path d="M10 10l6 -6" /><circle cx="10.5" cy="4.5" r=".5" /><circle cx="15.5" cy="9.5" r=".5" /></svg>',
                //     'title' => 'Manage Suppliers',
                //     'access' => 'supplier_view',
                //     'is_active' => (current_url() == base_url('supplier'))?true:false,
                //     'subnav' => false
                // ),
            );
        }
    }
}
/* End of file PL_Controller.php */