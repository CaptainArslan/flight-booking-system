<?php
$etktmsg = "Attached Pls find your confirmed E-ticket.
                                                
If you need any Hotel, Airport Transfer or Rent a car, we can provide you at amazing low prices.

Have a safe and pleasant journey. Pls feel free to contact us in future for any kind of travel arrangements or travel advice. Looking for the long term business relations.

Thanks.";
?>
<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('common/head', @$head); ?>
</head>

<body class="antialiased">
    <div class="wrapper">
        <?php
        $this->load->view('common/sidebar', @$sidebar);
        $this->load->view('common/header', @$header);
        ?>
        <div class="page-wrapper">
            <div class="page-header bg-white m-0 pt-3 pb-2">
                <div class="container-xl">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <!-- <div class="page-pretitle"><?php echo $booking['bkg_status']; ?></div> -->
                            <h2 class="page-title" style="color: #<?php if ($booking['bkg_status'] == 'Pending') {
                                                                        echo 'c00';
                                                                    } elseif ($booking['bkg_status'] == 'Issued') {
                                                                        echo '090';
                                                                    } elseif ($booking['bkg_status'] == 'Cancelled') {
                                                                        echo 'F90';
                                                                    } else {
                                                                        echo '6b00b9';
                                                                    } ?>"><?php echo $booking['bkg_status']; ?> Booking # <?php echo $booking['bkg_no'] . '-' . $brand["brand_pre_post_fix"]; ?></h2>
                        </div>
                        <div class="col-auto ms-auto">
                            <a href="<?php echo base_url('booking/add'); ?>" class="btn btn-sm btn-success">Add Booking</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <div class="row">
                        <div class="col">
                            <div class="card " id="booking-details">
                                <div class="card-body booking-bg-green">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="text-cyan">Booking Details<span class="text-success"><?php echo (!checkAccess($user_role, 'admin_view_booking_page') && $booking['bkg_agent'] != $user_name) ? " - " . $booking['bkg_agent'] : ''; ?></span>
                                            </h3>
                                        </div>
                                        <?php
                                        $bkg_dtl_col = 'col-md-3';
                                        ?>
                                        <div class="<?php echo $bkg_dtl_col; ?>">
                                            <label class="control-label text-left">
                                                <strong><?php
                                                        if ($booking['bkg_status'] == 'Issued' || $booking['bkg_status'] == 'Cleared') {
                                                            echo 'Book / Issue Date';
                                                        } elseif ($booking['bkg_status'] == 'Cancelled') {
                                                            echo 'Book/cancel Date';
                                                        } elseif ($booking['bkg_status'] == 'Pending' || $booking['bkg_status'] == 'Cancelled Pending') {
                                                            echo 'Booking Date';
                                                        }
                                                        ?></strong>
                                            </label>
                                            <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="bkg_date" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="date" data-class="date" data-value="<?php echo date("d-M-Y", strtotime($booking['bkg_date'])); ?>">
                                                <?php
                                                if ($booking['bkg_status'] == 'Pending' || $booking['bkg_status'] == 'Cancelled Pending') {
                                                    echo date("d-M-Y", strtotime($booking['bkg_date']));
                                                } else {
                                                    echo date("d-M-y", strtotime($booking['bkg_date'])) . "<br>";
                                                    if ($booking['bkg_status'] == 'Issued' || $booking['bkg_status'] == 'Cleared') {
                                                        echo date("d-M-y", strtotime($booking['clr_date']));
                                                    } else {
                                                        echo date("d-M-y", strtotime($booking['cnl_date']));
                                                    }
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        <?php if (checkAccess($user_role, 'admin_view_booking_page')) { ?>
                                            <div class="<?php echo $bkg_dtl_col; ?>">
                                                <label class="control-label text-left"><strong>Brand</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="select" data-name="bkg_brandname" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['bkg_brandname']; ?>">
                                                    <?php echo $booking['bkg_brandname']; ?>
                                                </p>
                                            </div>
                                            <div class="<?php echo $bkg_dtl_col; ?>">
                                                <label class="control-label text-left"><strong>Agent</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="select" data-name="bkg_agent" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['bkg_agent']; ?>">
                                                    <?php echo $booking['bkg_agent']; ?>
                                                </p>
                                            </div>
                                        <?php } ?>
                                        <div class="<?php echo $bkg_dtl_col; ?>">
                                            <label class="control-label text-left"><strong>Services</strong></label><br>
                                            <?php
                                            if ($booking['flight'] && $booking['bkg_status'] == 'Pending') {
                                            ?>
                                                <div class="form-check-inline">
                                                    <input type="checkbox" name="flightcheck" class="servicecheck" id="flightcheck" checked data-bkg-no="<?php echo $booking['bkg_no']; ?>">
                                                    <label for="flightcheck">Flight</label>
                                                </div>
                                            <?php
                                            } elseif ($booking['flight'] && $booking['bkg_status'] != 'Pending') {
                                            ?>
                                                Flight
                                            <?php
                                            }
                                            if ($booking['hotel'] && $booking['bkg_status'] == 'Pending') {
                                            ?>
                                                <div class="form-check-inline">
                                                    <input type="checkbox" name="hotelcheck" class="servicecheck" id="hotelcheck" checked data-bkg-no="<?php echo $booking['bkg_no']; ?>">
                                                    <label for="hotelcheck">Hotel</label>
                                                </div>
                                            <?php
                                            } elseif ($booking['hotel'] && $booking['bkg_status'] != 'Pending') {
                                            ?>
                                                Hotel
                                            <?php
                                            }
                                            if ($booking['cab'] && $booking['bkg_status'] == 'Pending') {
                                            ?>
                                                <div class="form-check-inline">
                                                    <input type="checkbox" name="cabcheck" class="servicecheck" id="cabcheck" checked data-bkg-no="<?php echo $booking['bkg_no']; ?>">
                                                    <label for="cabcheck">Cab</label>
                                                </div>
                                            <?php
                                            } elseif ($booking['cab'] && $booking['bkg_status'] != 'Pending') {
                                            ?>
                                                Cab
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="text-cyan">Customer Contacts</h3>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label text-left"><strong>Full Name</strong></label>
                                            <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cst_name" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['cst_name']; ?>">
                                                <?php ifempty($booking['cst_name']); ?>
                                            </p>
                                        </div>
                                        <?php if (checkAccess($user_role, 'admin_view_booking_page') || ($booking['bkg_agent'] == $user_name)) { ?>
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>Mobile #</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="number" data-name="cst_mobile" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['cst_mobile']; ?>">
                                                    <?php ifempty($booking['cst_mobile']); ?>
                                                </p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>Phone #</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="number" data-name="cst_phone" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['cst_phone']; ?>">
                                                    <?php ifempty($booking['cst_phone']); ?>
                                                </p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>Source</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="select" data-name="cst_source" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['cst_source']; ?>">
                                                    <?php ifempty($booking['cst_source']); ?>
                                                </p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>Email</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="email" data-name="cst_email" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['cst_email']; ?>">
                                                    <?php ifempty($booking['cst_email']); ?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>Address</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cst_address" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['cst_address']; ?>">
                                                    <?php ifempty($booking['cst_address']); ?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>City</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cst_city" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['cst_city']; ?>">
                                                    <?php ifempty($booking['cst_city']); ?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>PostCode</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cst_postcode" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['cst_postcode']; ?>">
                                                    <?php ifempty($booking['cst_postcode']); ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="card-body  booking-bg-green">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="text-cyan">Receipt Details</h3>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label text-left"><strong>Paying By</strong></label>
                                            <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="select" data-name="pmt_payingby" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['pmt_payingby']; ?>">
                                                <?php echo $booking['pmt_payingby']; ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label text-left"><strong>Due Date</strong></label>
                                            <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="recpt_due_date" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="date" data-class="datetime" data-value="<?php echo date("d-M-Y h:i A", strtotime($booking['recpt_due_date'])); ?>">
                                                <?php echo date("d-M-y h:i A", strtotime($booking['recpt_due_date'])); ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label text-left"><strong>Mode</strong></label>
                                            <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="select" data-name="pmt_mode" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['pmt_mode']; ?>">
                                                <?php echo $booking['pmt_mode']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php
                                    $display = '';
                                    if ($booking['pmt_mode'] == 'Bank Transfer' || $booking['pmt_mode'] == 'Cash') {
                                        $display = 'none';
                                    }
                                    ?>
                                    <span class="card_details" style="<?php echo ($display != '') ? "display:" . $display : ''; ?>">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>Card Holder Name</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="tpp_cardholdername" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['tpp_cardholdername']; ?>">
                                                    <?php ifempty($booking['tpp_cardholdername']); ?></p>
                                            </div>
                                            <?php
                                            $cd = hashing($booking["tpp_cardno"], 'd');
                                            $ce = hashing($cd, 'e');
                                            $card_num = $booking["tpp_cardno"];
                                            if ($ce == $card_num) {
                                                $cardNumber = hashing($card_num, 'd');
                                            } else {
                                                $cardNumber = $card_num;
                                            }
                                            $ccdate = $booking['tpp_cardexpirydate'];
                                            if ($ccdate != '') {
                                                $ccdate = "XX - XXXX";
                                            } else {
                                                $ccdate = "-";
                                            }
                                            $cvc = $booking['tpp_securitycode'];
                                            if ($cvc != '') {
                                                $cvc = "XXX";
                                            } else {
                                                $cvc = "-";
                                            }
                                            ?>
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>Card #</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-class="card_number" data-name="tpp_cardno" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php ifcardempty($cardNumber); ?>">
                                                    <?php ifcardempty($cardNumber); ?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>Expiry Date</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="select" data-input-type="text" data-name="tpp_cardexpirydate" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $ccdate; ?>"><?php echo $ccdate; ?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label text-left"><strong>CVC</strong></label>
                                                <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="tpp_securitycode" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $cvc; ?>"><?php echo $cvc; ?></p>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <?php
                                if (isset($visa) && sizeof($visa) > 0) {
                                ?>
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="text-cyan">Visa details</h3>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label text-left">
                                                    <strong>Number</strong>
                                                </label>
                                                <p class="form-control-static">
                                                    <?php echo $visa['number']; ?>
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label text-left">
                                                    <strong>Type</strong>
                                                </label>
                                                <p class="form-control-static">
                                                    <?php echo $visa['type']; ?>
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label text-left">
                                                    <strong>Cost</strong>
                                                </label>
                                                <p class="form-control-static">
                                                    <?php echo $visa['cost']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>


                            </div>
                            <?php
                            $class_f = $class_h = $class_c = 'active show';
                            if ($booking['flight'] && $booking['hotel'] && $booking['cab']) {
                                $class_h = $class_c = '';
                            } else if ($booking['flight'] && $booking['hotel'] && !$booking['cab']) {
                                $class_h = $class_c = '';
                            } else if ($booking['flight'] && !$booking['hotel'] && $booking['cab']) {
                                $class_h = $class_c = '';
                            } else if ($booking['flight'] && !$booking['hotel'] && !$booking['cab']) {
                                $class_h = $class_c = '';
                            } else if (!$booking['flight'] && $booking['hotel'] && $booking['cab']) {
                                $class_f = $class_c = '';
                            } else if (!$booking['flight'] && $booking['hotel'] && !$booking['cab']) {
                                $class_f = $class_c = '';
                            } else if (!$booking['flight'] && !$booking['hotel'] && $booking['cab']) {
                                $class_f = $class_h = '';
                            } else if (!$booking['flight'] && !$booking['hotel'] && !$booking['cab']) {
                                $class_f = $class_h = $class_c = '';
                            }
                            ?>
                            <ul class="nav nav-tabs mt-3" id="detailtab" data-bs-toggle="tabs">
                                <?php
                                if ($booking['flight']) {
                                ?>
                                    <li class="nav-item flight">
                                        <a class="nav-link <?php echo $class_f; ?>" data-bs-toggle="tab" href="#flight"><Strong>Flight Details</Strong></a>
                                    </li>
                                <?php
                                }
                                if ($booking['hotel']) {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $class_h; ?>" data-bs-toggle="tab" href="#hotel"><strong>Hotel Details</strong></a>
                                    </li>
                                <?php
                                }
                                if ($booking['cab']) {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $class_c; ?>" data-bs-toggle="tab" href="#cab"><strong>Cab Details</strong></a>
                                    </li>
                                <?php
                                }
                                if (!$booking['flight'] && $booking['bkg_status'] == 'Pending') {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $class_f; ?>" data-bs-toggle="tab" href="#addflight"><Strong><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <line x1="12" y1="5" x2="12" y2="19" />
                                                    <line x1="5" y1="12" x2="19" y2="12" />
                                                </svg> Flight</Strong></a>
                                    </li>
                                <?php
                                }
                                if (!$booking['hotel'] && $booking['bkg_status'] == 'Pending') {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $class_h; ?>" data-bs-toggle="tab" href="#addhotel"><strong><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <line x1="12" y1="5" x2="12" y2="19" />
                                                    <line x1="5" y1="12" x2="19" y2="12" />
                                                </svg> Hotel</strong></a>
                                    </li>
                                <?php
                                }
                                if (!$booking['cab'] && $booking['bkg_status'] == 'Pending') {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $class_c; ?>" data-bs-toggle="tab" href="#addcab"><strong><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <line x1="12" y1="5" x2="12" y2="19" />
                                                    <line x1="5" y1="12" x2="19" y2="12" />
                                                </svg> Transportation</strong></a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                            <div class="tab-content mb-3" id="detailsTabs">
                                <?php
                                if ($booking['flight']) {
                                ?>
                                    <div class="tab-pane card fade rounded-0 <?php echo $class_f; ?>" id="flight">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="control-label text-left"><strong>Supplier</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="select" data-name="sup_name" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['sup_name']; ?>">
                                                        <?php echo $booking['sup_name']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label text-left"><strong>Sup Ref</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="bkg_supplier_reference" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['bkg_supplier_reference']; ?>">
                                                        <?php ifempty($booking['bkg_supplier_reference']); ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label text-left"><strong>Sup's Agent</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="bkg_sup_agent" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['bkg_sup_agent']; ?>">
                                                        <?php ifempty($booking['bkg_sup_agent']); ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="control-label text-left"><strong>Dept. Arpt.</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="flt_departureairport" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="typeahead" data-class="airport typeahead" data-value="<?php echo $booking['flt_departureairport']; ?>">
                                                        <?php echo $booking['flt_departureairport']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label text-left"><strong>Dest. Arpt.</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="flt_destinationairport" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="typeahead" data-class="airport typeahead" data-value="<?php echo $booking['flt_destinationairport']; ?>">
                                                        <?php echo $booking['flt_destinationairport']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label text-left"><strong>Via. Arpt.</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="flt_via" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="typeahead" data-class="airport typeahead" data-value="<?php echo $booking['flt_via']; ?>">
                                                        <?php echo $booking['flt_via']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label text-left"><strong>Flight Type</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="select" data-name="flt_flighttype" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['flt_flighttype']; ?>">
                                                        <?php echo $booking['flt_flighttype']; ?>
                                                    </p>
                                                </div>
                                                <?php
                                                $f_type = $booking['flt_flighttype'];
                                                if ($f_type == 'Oneway') {
                                                    $date_class = 'col-md-4';
                                                    $date_label = 'Departure Date';
                                                } else {
                                                    $date_class = 'col-md-2';
                                                    $date_label = 'Dept Date';
                                                }
                                                ?>
                                                <div class="<?php echo $date_class; ?>">
                                                    <label class="control-label text-left"><strong><?php echo $date_label; ?></strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="flt_departuredate" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="date" data-class="date" data-value="<?php echo date("d-M-Y", strtotime($booking['flt_departuredate'])); ?>">
                                                        <?php echo date("d-M-Y", strtotime($booking['flt_departuredate'])); ?>
                                                    </p>
                                                </div>
                                                <?php if ($f_type != 'Oneway') { ?>
                                                    <div class="col-md-2">
                                                        <label class="control-label text-left"><strong>Rtrn. Date</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="flt_returningdate" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="date" data-class="date" data-value="<?php echo date("d-M-Y", strtotime($booking['flt_returningdate'])); ?>">
                                                            <?php echo date("d-M-Y", strtotime($booking['flt_returningdate'])); ?>
                                                        </p>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-md-2">
                                                    <label class="control-label text-left"><strong>Flight Class</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="select" data-name="flt_class" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['flt_class']; ?>">
                                                        <?php echo $booking['flt_class']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label text-left"><strong>PNR</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="flt_pnr" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['flt_pnr']; ?>" data-class="pnr">
                                                        <?php echo $booking['flt_pnr']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label text-left"><strong>GDS</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="select" data-name="flt_gds" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo $booking['flt_gds']; ?>">
                                                        <?php ifempty($booking['flt_gds']); ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label text-left"><strong>Airline</strong></label>
                                                    <p style="font-size:13px ;" class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="flt_airline" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="typeahead" data-class="airline typeahead" data-value="<?php echo $booking['flt_airline']; ?>">
                                                        <?php echo $booking['flt_airline']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label text-left"><strong>PNR Expiry</strong></label>
                                                    <p style="font-size:13px ;" class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="flt_pnr_expiry" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="date" data-class="datetime" data-value="<?php echo date("d-M-Y h:i A", strtotime($booking['flt_pnr_expiry'])); ?>">
                                                        <?php echo date("d-M-y h:i a", strtotime($booking['flt_pnr_expiry'])); ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label text-left"><strong>Fare Expiry</strong></label>
                                                    <p style="font-size:13px ;" class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="flt_fare_expiry" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="date" data-class="datetime" data-value="<?php echo date("d-M-Y h:i A", strtotime($booking['flt_fare_expiry'])); ?>">
                                                        <?php echo date("d-M-y h:i a", strtotime($booking['flt_fare_expiry'])); ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="control-label text-left"><strong>Ticket Details:</strong></label>
                                                    <div style="width: 100%;" class="<?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="textarea" data-name="flt_ticketdetail" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="mymce" data-value="<?php echo str_replace('"', "'", $booking['flt_ticketdetail']); ?>">
                                                        <p class="form-control-static"><?php ifempty(nl2br($booking['flt_ticketdetail'])); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                if ($booking['hotel']) {
                                    // echo "<pre>";
                                    // print_r($hotels);
                                    // echo "</pre>";

                                ?>
                                    <div class="tab-pane card fade rounded-0 <?php echo $class_h; ?>" id="hotel">
                                        <?php foreach ($hotels as $key => $hotel) { ?>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="control-label text-left"><strong>Hotel</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="hotel" data-edit-type="input" data-input-type="text" data-name="name" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($hotel['name'] != '') ? $hotel['name'] : "-"; ?>">
                                                            <?php echo ($hotel['name'] != '') ? $hotel['name'] : "-"; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="control-label text-left"><strong>Hotel Supplier</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="hotel" data-edit-type="select" data-name="supplier" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($hotel['supplier'] == '') ? "-" : $hotel['supplier']; ?>">
                                                            <?php echo ($hotel['supplier'] == '') ? "-" : $hotel['supplier']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="control-label text-left"><strong>Supplier's Agent</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="hotel" data-edit-type="input" data-input-type="text" data-name="ref_name" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($hotel['ref_name'] == '') ? "-" : $hotel['ref_name']; ?>">
                                                            <?php echo ($hotel['ref_name'] == '') ? "-" : $hotel['ref_name']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="control-label text-left"><strong>Hotel Ref#</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="hotel" data-edit-type="input" data-input-type="text" data-name="sup_ref" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($hotel['sup_ref'] == '') ? "-" : $hotel['sup_ref']; ?>">
                                                            <?php echo ($hotel['sup_ref'] == '') ? "-" : $hotel['sup_ref']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="control-label text-left"><strong>Hotel Location</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="hotel" data-edit-type="input" data-input-type="text" data-name="location" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($hotel['location'] == '') ? "-" : $hotel['location']; ?>">
                                                            <?php echo ($hotel['location'] == '') ? "-" : $hotel['location']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="control-label text-left"><strong>Checkin</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="hotel" data-edit-type="input" data-input-type="text" data-name="checkin" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="date" data-class="date" data-value="<?php echo ($hotel['checkin'] != 0) ? date("d-M-Y", strtotime($hotel['checkin'])) : '-'; ?>">
                                                            <?php echo ($hotel['checkin'] != 0) ? date("d-M-Y", strtotime($hotel['checkin'])) : '-'; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="control-label text-left"><strong>Checkout</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="hotel" data-edit-type="input" data-input-type="text" data-name="checkout" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="date" data-class="date" data-value="<?php echo ($hotel['checkout'] != 0) ? date("d-M-Y", strtotime($hotel['checkout'])) : '-'; ?>">
                                                            <?php echo ($hotel['checkout'] != 0) ? date("d-M-Y", strtotime($hotel['checkout'])) : '-'; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="control-label text-left"><strong>Rooms</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="hotel" data-edit-type="input" data-input-type="text" data-name="rooms" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($hotel['rooms'] == '') ? "-" : $hotel['rooms']; ?>">
                                                            <?php echo ($hotel['rooms'] == '') ? "-" : $hotel['rooms']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="control-label text-left"><strong>Hotel Details</strong></label>
                                                        <div class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="hotel" data-edit-type="textarea" data-name="details" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="mymce" data-value="<?php echo str_replace('"', "'", $hotel['details']); ?>">
                                                            <div class="form-control-static">
                                                                <?php ifempty(nl2br($hotel['details'])); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                <?php
                                }
                                if ($booking['cab']) {
                                ?>
                                    <div class="tab-pane card fade rounded-0 <?php echo $class_c; ?>" id="cab">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>Cab</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="cab" data-edit-type="input" data-input-type="text" data-name="name" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($cab['name'] == '') ? "-" : $cab['name']; ?>">
                                                        <?php echo ($cab['name'] == '') ? "-" : $cab['name']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>Cab Supplier</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="cab" data-edit-type="select" data-name="supplier" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($cab['supplier'] == '') ? "-" : $cab['supplier']; ?>">
                                                        <?php echo ($cab['supplier'] == '') ? "-" : $cab['supplier']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>Supplier's Agent</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="cab" data-edit-type="input" data-input-type="text" data-name="ref_name" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($cab['ref_name'] == '') ? "-" : $cab['ref_name']; ?>">
                                                        <?php echo ($cab['ref_name'] == '') ? "-" : $cab['ref_name']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>Cab Ref#</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="cab" data-edit-type="input" data-input-type="text" data-name="sup_ref" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($cab['sup_ref'] == '') ? "-" : $cab['sup_ref']; ?>">
                                                        <?php echo ($cab['sup_ref'] == '') ? "-" : $cab['sup_ref']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>Cab Type</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="cab" data-edit-type="input" data-input-type="text" data-name="type" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($cab['type'] == '') ? "-" : $cab['type']; ?>">
                                                        <?php echo ($cab['type'] == '') ? "-" : $cab['type']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>Trip</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="cab" data-edit-type="select" data-name="trip" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="<?php echo ($cab['trip'] == '') ? "-" : $cab['trip']; ?>">
                                                        <?php echo ($cab['trip'] == '') ? "-" : $cab['trip']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>From</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="cab" data-edit-type="input" data-input-type="text" data-name="from_date" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="date" data-class="date" data-value="<?php echo ($cab['from_date'] != 0) ? date("d-M-Y", strtotime($cab['from_date'])) : "-"; ?>">
                                                        <?php echo ($cab['from_date'] != 0) ? date("d-M-Y", strtotime($cab['from_date'])) : "-"; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>To</strong></label>
                                                    <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="cab" data-edit-type="input" data-input-type="text" data-name="to_date" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="date" data-class="date" data-value="<?php echo ($cab['to_date'] != 0) ? date("d-M-Y", strtotime($cab['to_date'])) : "-"; ?>">
                                                        <?php echo ($cab['to_date'] != 0) ? date("d-M-Y", strtotime($cab['to_date'])) : "-"; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="control-label text-left"><strong>Cab Details</strong></label>
                                                    <div class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-for="cab" data-edit-type="textarea" data-name="details" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-picker="mymce" data-value="<?php echo str_replace('"', "'", $cab['details']); ?>">
                                                        <div class="form-control-static">
                                                            <?php ifempty(nl2br($cab['details'])); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                if (!$booking['flight'] && $booking['bkg_status'] == 'Pending') {
                                ?>
                                    <div class="tab-pane card fade rounded-0 <?php echo $class_c; ?>" id="addflight">
                                        <div class="card-body">
                                            <form id="addflightform" action="<?php echo base_url('booking/addflight'); ?>" method="post">
                                                <input type="hidden" name="bkg_no" value="<?php echo $booking['bkg_no']; ?>">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Flight Supplier <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="flight[booking_supplier]" class="form-control  flt-input" autocomplete="off" required data-parsley-error-message="Select Booking Supplier">
                                                                    <option value="">Select Booking Supplier</option>
                                                                    <?php
                                                                    foreach ($booking_suppliers as $key => $supplier) {
                                                                        if ($supplier['supplier_name'] == 'All') {
                                                                            continue;
                                                                        }
                                                                    ?>
                                                                        <option value="<?php echo $supplier['supplier_name']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Supplier's Agent</label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[supplier_agent]" class="form-control " autocomplete="off" data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-pattern="^[a-zA-Z]+$" data-parsley-error-message="Please Enter text only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Supplier Reference</label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[supplier_reference]" class="form-control " autocomplete="off" data-parsley-error-message="Enter Supplier Reference">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Departure Airport <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[departure_airport]" id="departure_airport" class="airport typeahead form-control  flt-input" autocomplete="off" required data-parsley-error-message="Enter Departure Airport">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Destination Airport <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[destination_airport]" id="destination_airport" class="airport typeahead form-control  flt-input" autocomplete="off" required data-parsley-error-message="Enter Destination Airport">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Via <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[via_airport]" id="via_airport" class="airport typeahead form-control  flt-input" autocomplete="off" required data-parsley-error-message="Enter Transit Airport">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Flight Type <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="flight[flight_type]" id="flight_type" class="flight_type form-control  flt-input" autocomplete="off" required data-parsley-error-message="Select Flight Type">
                                                                    <option value="">Select Type</option>
                                                                    <option value="Oneway">Oneway</option>
                                                                    <option value="Return" selected="selected">Return</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dept-date col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Departure Date <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[departure_date]" id="departure_date" class="datetime form-control  flt-input" autocomplete="off" required data-parsley-error-message="Enter Departure Date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="return-date col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Return Date <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[return_date]" id="return_date" class="datetime form-control  flt-input" autocomplete="off" required data-parsley-error-message="Enter Return Date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Flight Class <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="flight[flight_class]" id="flight_class" class="form-control  flt-input" autocomplete="off" required data-parsley-error-message="Select Flight Class">
                                                                    <option value="">Select Flight Class</option>
                                                                    <option value="Economy" selected="selected">Economy</option>
                                                                    <option value="Economy Premium">Economy Premium</option>
                                                                    <option value="Business">Business</option>
                                                                    <option value="First Class">First Class</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Airline <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[airline]" id="airline" class="airline typeahead form-control  flt-input" autocomplete="off" required data-parsley-error-message="Enter Airline Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="flight[flight_segments]" id="flight_segments" value="0">
                                                    <!-- <div class="col-md-1">
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Seg. # <span class="flt-req text-danger">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="flight[flight_segments]" id="flight_segments" class="form-control  flt-input" required data-parsley-pattern="^[0-9]+$" data-parsley-maxlength="2"  data-parsley-error-message="Enter Number Of Segment" data-parsley-errors-messages-disabled>
                                                                    <small class="help-block text-danger">Important</small>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">PNR <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[pnr]" id="pnr" class="pnr form-control  flt-input" autocomplete="off" required data-parsley-error-message="Enter PNR">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">GDS <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="flight[flight_gds]" id="flight_gds" class="form-control  flt-input" autocomplete="off" required data-parsley-error-message="Select Booking GDS">
                                                                    <option value="">Select Booking GDS</option>
                                                                    <option value="World-Span" selected="selected">World Span</option>
                                                                    <option value="Galileo">Galileo</option>
                                                                    <option value="Sabre">Sabre</option>
                                                                    <option value="Amadeus">Amadeus</option>
                                                                    <option value="Web">Web</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">PNR Expiry <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[pnr_expire_date]" id="pnr_expire_date" class="datetime form-control  flt-input" autocomplete="off" required data-parsley-error-message="Enter PNR Expiry Date & Time">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Fare Expiry <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[fare_expire_date]" id="fare_expire_date" class="datetime form-control  flt-input" autocomplete="off" required data-parsley-error-message="Enter Fare Expiry Date & Time">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">PNR Details</label>
                                                        <textarea class="tkt_details custom" id="tkt_details" name="flight[tkt_details]"></textarea>
                                                    </div>
                                                    <div class="col-md-12 text-center m-t-20 m-b-20">
                                                        <button type="submit" form="addflightform" class="btn btn-sm btn-success text-white">Submit Flight</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php
                                }
                                if (!$booking['hotel'] && $booking['bkg_status'] == 'Pending') {
                                ?>
                                    <div class="tab-pane card fade rounded-0 <?php echo $class_c; ?>" id="addhotel">
                                        <div class="card-body">
                                            <form id="addhotelform" action="<?php echo base_url('booking/addhotel'); ?>" method="post">
                                                <input type="hidden" name="hotel[bkg_no]" value="<?php echo $booking['bkg_no']; ?>">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Hotel <span class="htl-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="hotel[name]" class="form-control  htl-input" data-parsley-error-message="Required" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Hotel Supplier <span class="htl-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="hotel[supplier]" class="form-control  htl-input" autocomplete="off" data-parsley-error-message="Required" required>
                                                                    <option value="">Select Hotel Supplier</option>
                                                                    <?php
                                                                    foreach ($booking_suppliers as $key => $supplier) {
                                                                        if ($supplier['supplier_name'] == 'All') {
                                                                            continue;
                                                                        }
                                                                    ?>
                                                                        <option value="<?php echo $supplier['supplier_name']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Supplier's Agent <span class="htl-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="hotel[ref_name]" class="form-control  htl-input" data-parsley-error-message="Required" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Hotel Ref# <span class="htl-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="hotel[sup_ref]" class="form-control  htl-input" data-parsley-error-message="Required" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Hotel Location <span class="htl-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="hotel[location]" class="form-control  htl-input" data-parsley-error-message="Required" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Checkin Date <span class="htl-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="hotel[checkin]" class="date checkin form-control  htl-input" data-parsley-error-message="Required" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Checkout Date <span class="htl-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="hotel[checkout]" class="date checkout form-control  htl-input" data-parsley-error-message="Required" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Rooms <span class="htl-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="hotel[rooms]" class="form-control  htl-input" data-parsley-error-message="Required" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">Hotel Details</label>
                                                        <textarea class="tkt_details custom" id="hotel_details" name="hotel[details]"></textarea>
                                                    </div>
                                                    <div class="col-md-12 text-center m-t-20 m-b-20">
                                                        <button type="submit" form="addhotelform" class="btn btn-sm btn-success text-white">Submit Hotel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php
                                }
                                if (!$booking['cab'] && $booking['bkg_status'] == 'Pending') {
                                ?>
                                    <div class="tab-pane card fade rounded-0 <?php echo $class_c; ?>" id="addcab">
                                        <div class="card-body">
                                            <form id="addcabform" action="<?php echo base_url('booking/addcab'); ?>" method="post">
                                                <input type="hidden" name="cab[bkg_no]" value="<?php echo $booking['bkg_no']; ?>">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Cab <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[name]" class="form-control  cab-input" data-parsley-error-message="Required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Cab Supplier <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="cab[supplier]" class="form-control  cab-input" autocomplete="off" data-parsley-error-message="Required">
                                                                    <option value="">Select Cab Supplier</option>
                                                                    <?php
                                                                    foreach ($booking_suppliers as $key => $supplier) {
                                                                        if ($supplier['supplier_name'] == 'All') {
                                                                            continue;
                                                                        }
                                                                    ?>
                                                                        <option value="<?php echo $supplier['supplier_name']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Supplier's Agent <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[ref_name]" class="form-control  cab-input" data-parsley-error-message="Required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Cab Ref# <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[sup_ref]" class="form-control  cab-input" data-parsley-error-message="Required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Vehicle Type <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[type]" class="form-control  cab-input" data-parsley-error-message="Required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Cab Trip <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="cab[trip]" class="form-control  cab-input" data-parsley-error-message="Required">
                                                                    <option value="Round">Round</option>
                                                                    <option value="Oneway">Oneway</option>
                                                                    <option value="Cab Hire">Cab Hire</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">From <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[from_date]" class="date cabfrom form-control  cab-input" data-parsley-error-message="Required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">To <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[to_date]" class="date cabto form-control  cab-input" data-parsley-error-message="Required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">Cab Details</label>
                                                        <textarea class="tkt_details custom" id="cab_details" name="cab[details]"></textarea>
                                                    </div>
                                                    <div class="col-md-12 text-center m-t-20 m-b-20">
                                                        <button type="submit" form="addcabform" class="btn btn-sm btn-success text-white">Submit Cab</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="card mb-3">
                                <div id="costSection" class="card-body  booking-bg-green">
                                    <?php
                                    $tkt_cost = 0;
                                    $payable_sup = 0;
                                    $add_exp = 0;
                                    $add_exp = $booking['cost_bank_charges_internal'] + $booking['cost_cardcharges'] + $booking['cost_postage'] + $booking['cost_cardverfication'];
                                    if ($booking['flight']) {
                                        $payable_sup = $booking['cost_basic'] + $booking['cost_tax'] + $booking['cost_apc'] + $booking['cost_misc'] + $booking['cost_safi'];
                                    }
                                    if ($booking['hotel']) {
                                        $payable_sup += $hotel['cost'];
                                    }
                                    if ($booking['cab']) {
                                        $payable_sup += $cab['cost'];
                                    }
                                    $tkt_cost = $payable_sup + $add_exp;
                                    ?>
                                    <div class="row m-0">
                                        <div class="col-md-12 nopadding">
                                            <h4 class="card-title text-cyan">Ticket Cost: <strong class="text-success"><?php echo number_format($tkt_cost, 2) ?></strong></h4>
                                        </div>
                                        <div class="col-md-6 " style="border-right: thin solid #000000;">
                                            <div class="row">
                                                <div class="col-md-12 nopadding">
                                                    <h5 class="card-title text-cyan">I) Payable to Supplier: <strong class="text-success"><?php echo number_format($payable_sup, 2); ?></strong>
                                                    </h5>
                                                </div>
                                                <?php
                                                $cost_class = 'col-md-3 nopadding';
                                                if ($booking['cab'] || $booking['hotel']) {
                                                    $cost_class = 'col-md-2 nopadding';
                                                }
                                                if ($booking['flight']) {
                                                ?>
                                                    <div class="<?php echo $cost_class; ?>">
                                                        <label class="control-label text-left"><strong>Basic</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cost_basic" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['cost_basic']; ?>">
                                                            <?php echo $booking['cost_basic']; ?></p>
                                                    </div>
                                                    <div class="<?php echo $cost_class; ?>">
                                                        <label class="control-label text-left"><strong>Tax</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cost_tax" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['cost_tax']; ?>">
                                                            <?php echo $booking['cost_tax']; ?></p>
                                                    </div>
                                                    <div class="<?php echo $cost_class; ?>">
                                                        <label class="control-label text-left"><strong>APC</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cost_apc" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['cost_apc']; ?>">
                                                            <?php echo $booking['cost_apc']; ?></p>
                                                    </div>
                                                    <div class="<?php echo $cost_class; ?>">
                                                        <label class="control-label text-left"><strong>Misc.</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cost_misc" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['cost_misc']; ?>">
                                                            <?php echo $booking['cost_misc']; ?></p>
                                                    </div>
                                                <?php
                                                }
                                                if ($booking['hotel']) {
                                                ?>
                                                    <div class="<?php echo $cost_class; ?>">
                                                        <label class="control-label text-left"><strong>Hotel</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cost" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-edit-for="hotel" data-value="<?php echo ($hotel['cost']) ? $hotel['cost'] : '0.00'; ?>">
                                                            <?php echo ($hotel['cost']) ? $hotel['cost'] : '0.00'; ?></p>
                                                    </div>
                                                <?php
                                                }
                                                if ($booking['cab']) {
                                                ?>
                                                    <div class="<?php echo $cost_class; ?>">
                                                        <label class="control-label text-left"><strong>Cab</strong></label>
                                                        <p class="form-control-static <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cost" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-edit-for="cab" data-value="<?php echo ($cab['cost']) ? $cab['cost'] : '0.00'; ?></p>">
                                                            <?php echo ($cab['cost']) ? $cab['cost'] : '0.00'; ?></p>
                                                        </p>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="card-title text-cyan">II) Additional Expenses: <strong class="text-success"><?php echo number_format($add_exp, 2); ?></strong>
                                                    </h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>Bank</strong></label>
                                                    <p class="form-control-static <?php echo (checkAccess($user_role, 'add_cost_edit_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cost_bank_charges_internal" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['cost_bank_charges_internal']; ?>">
                                                        <?php echo $booking['cost_bank_charges_internal']; ?></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>Card</strong></label>
                                                    <p class="form-control-static <?php echo (checkAccess($user_role, 'add_cost_edit_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cost_cardcharges" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['cost_cardcharges']; ?>">
                                                        <?php echo $booking['cost_cardcharges']; ?></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>APC</strong></label>
                                                    <p class="form-control-static <?php echo (checkAccess($user_role, 'add_cost_edit_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cost_postage" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['cost_postage']; ?>">
                                                        <?php echo $booking['cost_postage']; ?></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label text-left"><strong>Misc.</strong></label>
                                                    <p class="form-control-static <?php echo (checkAccess($user_role, 'add_cost_edit_booking_page')) ? 'editField' : ''; ?>" data-edit-type="input" data-input-type="text" data-name="cost_cardverfication" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-class="" data-value="<?php echo $booking['cost_cardverfication']; ?>">
                                                        <?php echo $booking['cost_cardverfication']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header bg-body pt-1 pb-1">
                                    <?php if (($booking['bkg_status'] != 'Issued' && $booking['bkg_status'] != 'Cancelled') && (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page'))) { ?>
                                        <h4 class="card-title text-white">Passenger Details</h4>
                                        <a id="editpax" class="btn btn-xs btn-info text-white btn-sm ms-auto p-1" data-booking-id="<?php echo $booking['bkg_no']; ?>"><small>Amend Passengers</small></a>
                                    <?php } else { ?>
                                        <h4 class="card-title text-white">Passenger Details</h4>
                                    <?php } ?>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="paxtable" class="table full-color-table full-info-table ">
                                            <thead>
                                                <tr>
                                                    <th width="05%" class="text-center">Title</th>
                                                    <th width="11%" class="text-center">First Name</th>
                                                    <th width="07%" class="text-center">Mid</th>
                                                    <th width="11%" class="text-center">Sur Name</th>
                                                    <th width="06%" class="text-center">Age</th>
                                                    <th width="06%" class="text-center">Type</th>
                                                    <th width="08%" class="text-center">Flight</th>
                                                    <th width="08%" class="text-center">Hotel</th>
                                                    <th width="08%" class="text-center">Cab</th>
                                                    <th width="08%" class="text-center">Fee</th>
                                                    <th width="08%" class="text-center">Total</th>
                                                    <th width="14%" class="text-center">E-Ticket</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sr = 1;
                                                $total_rows = count($pax);
                                                $totalsale = 0;
                                                $totalhotelsale = 0;
                                                $totalcabsale = 0;
                                                $profit = 0;
                                                foreach ($pax as $key => $passenger) {
                                                ?>
                                                    <tr style="<?php echo ($sr != $total_rows) ? "" : "border-bottom:none !important;"; ?>">
                                                        <td class="text-center p-0-5"><?php echo $passenger['p_title']; ?></td>
                                                        <td class="text-center p-0-5"><?php echo $passenger['p_firstname']; ?>
                                                        </td>
                                                        <td class="text-center p-0-5"><?php echo $passenger['p_middlename']; ?>
                                                        </td>
                                                        <td class="text-center p-0-5"><?php echo $passenger['p_lastname']; ?>
                                                        </td>
                                                        <td class="text-center p-0-5"><?php echo $passenger['p_age']; ?></td>
                                                        <td class="text-center p-0-5"><?php echo $passenger['p_catagory']; ?>
                                                        </td>
                                                        <td class="text-center p-0-5">
                                                            <?php echo number_format(($passenger['p_basic'] + $passenger['p_tax']), 2); ?>
                                                        </td>
                                                        <td class="text-center p-0-5">
                                                            <?php echo number_format($passenger['p_hotel'], 2); ?>
                                                        </td>
                                                        <td class="text-center p-0-5">
                                                            <?php echo number_format($passenger['p_cab'], 2); ?>
                                                        </td>
                                                        <td class="text-center p-0-5">
                                                            <?php echo number_format(($passenger['p_bookingfee'] + $passenger['p_cardcharges'] + $passenger['p_others']), 2); ?>
                                                        </td>
                                                        <td class="text-center p-0-5">
                                                            <?php echo number_format(($passenger['p_basic'] + $passenger['p_tax'] + $passenger['p_bookingfee'] + $passenger['p_cardcharges'] + $passenger['p_others'] + $passenger['p_hotel'] + $passenger['p_cab']), 2); ?>
                                                        </td>
                                                        <?php // if($booking['bkg_status'] == 'Issued'){ 
                                                        ?>
                                                        <td class="text-center p-0-5"><?php echo $passenger['p_eticket_no']; ?>
                                                        </td>
                                                        <?php //} 
                                                        ?>
                                                    </tr>
                                                <?php
                                                    $sr++;
                                                    $totalsale += $passenger['p_basic'] + $passenger['p_tax'] + $passenger['p_bookingfee'] + $passenger['p_cardcharges'] + $passenger['p_others'] + $passenger['p_hotel'] + $passenger['p_cab'];
                                                    $totalhotelsale += $passenger['p_hotel'];
                                                    $totalcabsale += $passenger['p_cab'];
                                                }
                                                $profit = $totalsale - $tkt_cost;
                                                ?>
                                            </tbody>
                                        </table>
                                        <table id="paxtable" class="table full-color-table full-info-table hover-table">
                                            <tfoot>
                                                <tr style="border-bottom: thin solid #000000 !important ;border-top: thin solid #000000 !important ;">
                                                    <th width="50%" class="text-left" style="border:none !important;padding-left: 20px !important;font-size: 14px !important;">
                                                        Total Sale Price:
                                                        <strong class="text-danger">
                                                            <?php echo number_format($totalsale, 2); ?>
                                                        </strong>
                                                    </th>
                                                    <th width="50%" class="text-right" style="border:none !important;padding-right: 20px !important;font-size: 14px !important;">
                                                        Profit:
                                                        <strong class="text-danger">
                                                            <?php echo number_format($profit, 2); ?>
                                                        </strong>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $amountRec = 0;
                            $amountdue = 0;
                            foreach ($cust_trans as $key => $cust_tran) {
                                if ($cust_tran['trans_type'] == "Dr") {
                                    $amountRec -= $cust_tran['trans_amount'];
                                } else {
                                    $amountRec += $cust_tran['trans_amount'];
                                }
                            }
                            $amountdue = $totalsale - $amountRec;
                            ?>
                            <div class="card mb-3">
                                <div class="card-header bg-body pt-1 pb-1">
                                    <h4 class="card-title text-white">Receipts from Customer</h4>
                                    <?php
                                    if ((checkBrandaccess($booking['bkg_brandname'], 'reminder') || $this->session->userdata('user_brand') == 'All') && $amountdue > 0) {
                                    ?>
                                        <button class="send_reminder btn btn-xs btn-info btn-sm ms-auto p-1" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-email="<?php echo $booking['cst_email']; ?>" data-due-date="<?php echo date("d-M-Y h:i A", strtotime($booking['recpt_due_date'])); ?>" data-pending-amt="<?php echo number_format($amountdue, 2); ?>" data-cust-name="<?php echo $booking['cst_name']; ?>" data-brand="<?php echo $booking['bkg_brandname']; ?>"><small>Send Reminder</small></button>
                                    <?php
                                    }
                                    if (($booking['bkg_status'] != 'Issued' && $booking['bkg_status'] != 'Cancelled') && (checkAccess($user_role, 'add_transaction') || checkAccess($user_role, 'edit_transaction') || checkAccess($user_role, 'delete_transaction'))) {
                                    ?>
                                        <button type="button" data-bkg-no="<?php echo $booking['bkg_no']; ?>" class="btn btn-xs btn-info btn-sm bkgNewTrans ms-auto p-1">
                                            <small>Add Transaction</small>
                                        </button>
                                    <?php } ?>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="paxtable" class="table full-color-table full-info-table ">
                                            <thead>
                                                <tr>
                                                    <th width="08%" class="text-center">ID</th>
                                                    <th width="12%" class="text-center">Recpt. Date</th>
                                                    <th width="30%" class="text-center">Receipt Via</th>
                                                    <th width="20%" class="text-center">Authorization Code</th>
                                                    <th width="10%" class="text-center">&pound; Received</th>
                                                    <th width="20%" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sr = 1;
                                                $total_rows = count($cust_trans);
                                                $amountRec = 0;
                                                foreach ($cust_trans as $key => $cust_tran) {
                                                ?>
                                                    <tr>
                                                        <td class="text-center text-middle">
                                                            <?php echo $cust_tran['trans_id']; ?></td>
                                                        <td class="text-center text-middle">
                                                            <?php echo date("d-M-y", strtotime($cust_tran['trans_date'])); ?>
                                                        </td>
                                                        <td class="text-center text-middle">
                                                            <?php echo $cust_tran['trans_by_to']; ?></td>
                                                        <td class="text-center text-middle">
                                                            <?php echo $cust_tran['t_card']; ?></td>
                                                        <td class="text-center text-middle font-weight-600">
                                                            <?php echo ($cust_tran["trans_type"] == 'Dr') ? "-" . number_format($cust_tran['trans_amount'], 2) : number_format($cust_tran['trans_amount'], 2); ?>
                                                        </td>
                                                        <td rowspan="2" class="text-center text-middle <?php echo ($sr != $total_rows) ? "border-bottom-dark" : "border-bottom-none"; ?>">
                                                            <?php
                                                            if (checktransfornotify($cust_tran['trans_by_to'], $cust_tran['trans_head']) && (checkBrandaccess($booking['bkg_brandname'], 'reminder') || $this->session->userdata('user_brand') == 'All')) {
                                                                if ($cust_tran['notification'] == 0) { ?>
                                                                    <button class="notifyAlert btn btn-xs btn-success btn-sm" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-email="<?php echo $booking['cst_email']; ?>" data-trans-by-to="<?php echo $cust_tran['trans_by_to']; ?>" data-amt="<?php echo $cust_tran['trans_amount'] ?>" data-cust-name="<?php echo $booking['cst_name']; ?>" data-brand="<?php echo $booking['bkg_brandname']; ?>" data-trans-type="<?php echo $cust_tran["trans_type"]; ?>" data-trans-date="<?php echo date("d-M-Y", strtotime($cust_tran['trans_date'])); ?>" data-trans-id="<?php echo $cust_tran["trans_id"]; ?>" data-trans-cnt="<?php echo $cust_tran["trans_cnt"]; ?>">Notify</button>
                                                                <?php     } else { ?>
                                                                    <button class="btn btn-xs btn-success disabled" disabled="disabled">Notified</button>
                                                                <?php     }
                                                            }
                                                            if ((checkAccess($user_role, 'edit_transaction') || checkAccess($user_role, 'delete_transaction'))) {
                                                                ?>
                                                                <button data-trans-id="<?php echo $cust_tran['trans_id']; ?>" class="bkgEditTrans btn btn-xs btn-warning text-dark btn-sm">Edit / Delete</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr style="<?php echo ($sr != $total_rows) ? "" : "border-bottom:none !important;"; ?>">
                                                        <td colspan="6" class="<?php echo ($sr != $total_rows) ? "border-bottom-dark" : "border-bottom-none"; ?> pt-0 pb-0 pr-0 pl-2">
                                                            <small class="font-weight-600"><?php echo $cust_tran['trans_description']; ?><span class="text-success">(<?php echo getinitials($cust_tran['trans_created_by']); ?>)</span></small>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $sr++;
                                                    if ($cust_tran['trans_type'] == "Dr") {
                                                        $amountRec -= $cust_tran['trans_amount'];
                                                    } else {
                                                        $amountRec += $cust_tran['trans_amount'];
                                                    }
                                                }
                                                if ($total_rows == 0) {
                                                    ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center p-0-5">No Transaction Found</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <table id="paxtable" class="table full-color-table full-info-table">
                                            <tfoot>
                                                <tr style="border-bottom: thin solid #000000 !important ;border-top: thin solid #000000 !important ;">
                                                    <th width="50%" class="text-left" style="border:none !important;padding-left: 20px !important;font-size: 14px !important;">
                                                        Total Amount Received:
                                                        <strong class="text-danger">
                                                            <?php echo number_format($amountRec, 2); ?>
                                                        </strong>
                                                    </th>
                                                    <th width="50%" class="text-right" style="border:none !important;padding-right: 20px !important;font-size: 14px !important;">
                                                        Amount Pending:
                                                        <strong class="text-danger">
                                                            <?php echo number_format($totalsale - $amountRec, 2); ?>
                                                        </strong>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (checkAccess($user_role, 'bkg_sup_payment')) {
                            ?>
                                <div class="card mb-0">
                                    <div class="card-header bg-body pt-1 pb-1">
                                        <h4 class="card-title text-white">Payments to Supplier</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="paxtable" class="table full-color-table full-info-table ">
                                                <thead>
                                                    <tr>
                                                        <th width="8%" class="text-center">ID</th>
                                                        <th width="12%" class="text-center">Payment Date</th>
                                                        <th width="20%" class="text-center">Payment Via</th>
                                                        <th width="20%" class="text-center">Payment To</th>
                                                        <th width="15%" class="text-center">Authorization Code</th>
                                                        <th width="10%" class="text-center">&pound; Paid</th>
                                                        <th width="15%" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sr = 1;
                                                    $total_rows = count($supp_trans);
                                                    $amountpaid = 0;
                                                    $suppliers_cal = array();
                                                    foreach ($supp_trans as $key => $supp_tran) {
                                                        $to_sup = $supp_tran['trans_head'];
                                                        if ($key == 0) {
                                                            $suppliers_cal[$to_sup] = 0;
                                                            if ($supp_tran['trans_type'] == 'Dr') {
                                                                $suppliers_cal[$to_sup] += $supp_tran['trans_amount'];
                                                            } else if ($supp_tran['trans_type'] == 'Cr') {
                                                                $suppliers_cal[$to_sup] -= $supp_tran['trans_amount'];
                                                            }
                                                        } else {
                                                            if (array_key_exists($to_sup, $suppliers_cal)) {
                                                                if ($supp_tran['trans_type'] == 'Dr') {
                                                                    $suppliers_cal[$to_sup] += $supp_tran['trans_amount'];
                                                                } else if ($supp_tran['trans_type'] == 'Cr') {
                                                                    $suppliers_cal[$to_sup] -= $supp_tran['trans_amount'];
                                                                }
                                                            } else {
                                                                $suppliers_cal[$to_sup] = 0;
                                                                if ($supp_tran['trans_type'] == 'Dr') {
                                                                    $suppliers_cal[$to_sup] += $supp_tran['trans_amount'];
                                                                } else if ($supp_tran['trans_type'] == 'Cr') {
                                                                    $suppliers_cal[$to_sup] -= $supp_tran['trans_amount'];
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td class="text-center text-middle">
                                                                <?php echo $supp_tran['trans_id']; ?></td>
                                                            <td class="text-center text-middle">
                                                                <?php echo date("d-M-y", strtotime($supp_tran['trans_date'])); ?>
                                                            </td>
                                                            <td class="text-center text-middle">
                                                                <?php echo $supp_tran['trans_by_to']; ?></td>
                                                            <td class="text-center text-middle">
                                                                <?php echo $supp_tran['trans_head']; ?></td>
                                                            <td class="text-center text-middle">
                                                                <?php echo $supp_tran['t_card']; ?></td>
                                                            <td class="text-center text-middle font-weight-600">
                                                                <?php echo ($supp_tran["trans_type"] == 'Cr') ? "-" . number_format($supp_tran['trans_amount'], 2) : number_format($supp_tran['trans_amount'], 2); ?>
                                                            </td>
                                                            <td rowspan="2" class="text-center text-middle <?php echo ($sr != $total_rows) ? "border-bottom-dark" : "border-bottom-none"; ?>">
                                                                <?php if ((checkAccess($user_role, 'edit_transaction') || checkAccess($user_role, 'delete_transaction'))) {
                                                                ?>
                                                                    <button data-trans-id="<?php echo $supp_tran['trans_id']; ?>" class="bkgEditTrans btn btn-xs btn-warning text-dark btn-sm">Edit / Delete</button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <tr style="<?php echo ($sr != $total_rows) ? "" : "border-bottom:none !important;"; ?>">
                                                            <td colspan="7" class="<?php echo ($sr != $total_rows) ? "border-bottom-dark" : "border-bottom-none"; ?> pt-0 pb-0 pr-0 pl-2">
                                                                <small class="font-weight-600"><?php echo $supp_tran['trans_description']; ?><span class="text-success">(<?php echo getinitials($supp_tran['trans_created_by']); ?>)</span></small>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $sr++;
                                                        if ($supp_tran['trans_type'] == "Dr") {
                                                            $amountpaid += $supp_tran['trans_amount'];
                                                        } else {
                                                            $amountpaid -= $supp_tran['trans_amount'];
                                                        }
                                                    }
                                                    if ($total_rows == 0) {
                                                        ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center p-0-5">No Transaction Found</td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <table id="paxtable" class="table full-color-table full-info-table hover-table">
                                                <tfoot>
                                                    <tr style="border-bottom: thin solid #000000 !important ;border-top: thin solid #000000 !important ;">
                                                        <th width="33%" class="text-left" style="border:none !important;padding-left: 20px !important;font-size: 14px !important;">
                                                            Total Payable:
                                                            <strong class="text-danger">
                                                                <?php echo number_format($payable_sup, 2); ?>
                                                            </strong>
                                                        </th>
                                                        <th width="34%" class="text-center" style="border:none !important;font-size: 14px !important;">Total
                                                            Amount Paid:
                                                            <strong class="text-danger">
                                                                <?php echo number_format($amountpaid, 2); ?>
                                                            </strong>
                                                        </th>
                                                        <th width="33%" class="text-right" style="border:none !important;padding-right: 20px !important;font-size: 14px !important;">
                                                            Pending Amount:
                                                            <strong class="text-danger">
                                                                <?php echo number_format($payable_sup - $amountpaid, 2); ?>
                                                            </strong>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $d_totalpayable = 0;
                                $d_totalpaid = 0;
                                $fpayable = $payable_sup;
                                if ($booking['hotel']) {
                                    $fpayable -= $hotel['cost'];
                                }
                                if ($booking['cab']) {
                                    $fpayable -= $cab['cost'];
                                }
                                $fsup = @$booking['sup_name'];
                                $hsup = @$hotel['supplier'];
                                $csup = @$cab['supplier'];
                                $duec = 0;
                                if ((@$fsup == @$hsup) && (@$fsup == @$csup) && (@$hsup == @$csup)) {
                                    $payable = @$fpayable + @$hotel['cost'] + @$cab['cost'];
                                    $paid = @$suppliers_cal[$fsup];
                                    $sup_dueary[$duec] = array(
                                        'supp'         =>    @$fsup,
                                        'payable'     => round((@$payable), 2),
                                        'paid'        =>    round((@$paid), 2),
                                        'due'        =>    round((@$payable - @$paid), 2),
                                    );
                                } else if ((@$fsup == @$hsup) && (@$fsup != @$csup) && (@$hsup != @$csup)) {
                                    $payable = @$fpayable + @$hotel['cost'];
                                    $paid = @$suppliers_cal[$fsup];
                                    $sup_dueary[$duec] = array(
                                        'supp'         =>    @$fsup,
                                        'payable'     => round((@$payable), 2),
                                        'paid'        =>    round((@$paid), 2),
                                        'due'        =>    round((@$payable - @$paid), 2),
                                    );
                                    $duec++;
                                    if ($booking['cab'] && (@$cab['cost'] - @$suppliers_cal[$csup] != 0)) {
                                        $sup_dueary[$duec] = array(
                                            'supp'         =>    @$csup,
                                            'payable'     =>    round((@$cab['cost']), 2),
                                            'paid'        =>    round((@$suppliers_cal[$csup]), 2),
                                            'due'        =>    round((@$cab['cost'] - @$suppliers_cal[$csup]), 2),
                                        );
                                        $duec++;
                                    }
                                } else if ((@$fsup != @$hsup) && (@$fsup == @$csup) && (@$hsup != @$csup)) {
                                    $payable = @$fpayable + @$cab['cost'];
                                    $paid = @$suppliers_cal[$fsup];
                                    $sup_dueary[$duec] = array(
                                        'supp'         =>    @$fsup,
                                        'payable'     => round((@$payable), 2),
                                        'paid'        =>    round((@$paid), 2),
                                        'due'        =>    round((@$payable - @$paid), 2),
                                    );
                                    $duec++;
                                    if ($booking['hotel'] && (@$hotel['cost'] - @$suppliers_cal[$hsup] != 0)) {
                                        $sup_dueary[$duec] = array(
                                            'supp'         =>    @$hsup,
                                            'payable'     =>    round((@$hotel['cost']), 2),
                                            'paid'        =>    round((@$suppliers_cal[$hsup]), 2),
                                            'due'        =>    round((@$hotel['cost'] - @$suppliers_cal[$hsup]), 2),
                                        );
                                        $duec++;
                                    }
                                } else if ((@$fsup != @$hsup) && (@$hsup == @$csup) && (@$fsup != @$csup)) {
                                    $payable = @$hotel['cost'] + @$cab['cost'];
                                    $paid = @$suppliers_cal[$hsup];
                                    $sup_dueary[$duec] = array(
                                        'supp'         =>    @$fsup,
                                        'payable'     => round((@$payable), 2),
                                        'paid'        =>    round((@$paid), 2),
                                        'due'        =>    round((@$payable - @$paid), 2),
                                    );
                                    $duec++;
                                    if ($booking['flight'] && ($fpayable - @$suppliers_cal[$fsup] != 0)) {
                                        $sup_dueary[$duec] = array(
                                            'supp'         =>    @$fsup,
                                            'payable'     =>    round((@$fpayable), 2),
                                            'paid'        =>    round((@$suppliers_cal[$fsup]), 2),
                                            'due'        =>    round((@$fpayable - @$suppliers_cal[$fsup]), 2),
                                        );
                                        $duec++;
                                    }
                                } else {
                                    if ($booking['flight'] && ($fpayable - @$suppliers_cal[$fsup] != 0)) {
                                        $sup_dueary[$duec] = array(
                                            'supp'         =>    @$fsup,
                                            'payable'     =>    round((@$fpayable), 2),
                                            'paid'        =>    round((@$suppliers_cal[$fsup]), 2),
                                            'due'        =>    round((@$fpayable - @$suppliers_cal[$fsup]), 2),
                                        );
                                        $duec++;
                                    }
                                    if ($booking['hotel'] && (@$hotel['cost'] - @$suppliers_cal[$hsup] != 0)) {
                                        $sup_dueary[$duec] = array(
                                            'supp'         =>    @$hsup,
                                            'payable'     =>    round((@$hotel['cost']), 2),
                                            'paid'        =>    round((@$suppliers_cal[$hsup]), 2),
                                            'due'        =>    round((@$hotel['cost'] - @$suppliers_cal[$hsup]), 2),
                                        );
                                        $duec++;
                                    }
                                    if ($booking['cab'] && (@$cab['cost'] - @$suppliers_cal[$csup] != 0)) {
                                        $sup_dueary[$duec] = array(
                                            'supp'         =>    @$csup,
                                            'payable'     =>    round((@$cab['cost']), 2),
                                            'paid'        =>    round((@$suppliers_cal[$csup]), 2),
                                            'due'        =>    round((@$cab['cost'] - @$suppliers_cal[$csup]), 2),
                                        );
                                        $duec++;
                                    }
                                }
                                if (count(@$sup_dueary) > 0) {
                                    foreach ($sup_dueary as $key => $supduev) {
                                        if ($supduev['due'] == 0.00) {
                                            unset($sup_dueary[$key]);
                                        }
                                    }
                                ?>
                                    <div class="card mb-3">
                                        <div class="card-header bg-body pt-1 pb-1">
                                            <h4 class="card-title text-white">Supplier Due Balance</h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table id="paxtable" class="table full-color-table full-info-table hover-table">
                                                    <thead>
                                                        <tr>
                                                            <th width="25%" class="text-center"><strong>Suppliers</strong></th>
                                                            <th width="25%" class="text-center"><strong>Amount Payable</strong></th>
                                                            <th width="25%" class="text-center"><strong>Amount Paid</strong></th>
                                                            <th width="25%" class="text-center"><strong>Amount Pending</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($sup_dueary as $key => $supduev) {
                                                            if ($supduev['due'] == 0.00) {
                                                                continue;
                                                            }
                                                        ?>
                                                            <tr class="<?php echo ($supduev['due'] < 0) ? 'row-danger' : ''; ?>">
                                                                <td class="text-center p-0-5">
                                                                    <?php echo $supduev['supp']; ?>
                                                                </td>
                                                                <td class="text-center p-0-5">
                                                                    <?php
                                                                    echo number_format($supduev['payable'], 2);
                                                                    $d_totalpayable += $supduev['payable'];
                                                                    ?>
                                                                </td>
                                                                <td class="text-center p-0-5">
                                                                    <?php
                                                                    echo number_format(@$supduev['paid'], 2);
                                                                    $d_totalpaid += @$supduev['paid'];
                                                                    ?>
                                                                </td>
                                                                <td class="text-center p-0-5">
                                                                    <?php
                                                                    echo number_format(@$supduev['due'], 2);
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr style="border-bottom: thin solid #000000 !important ;border-top: thin solid #000000 !important ;">
                                                            <th class="text-center" style="border:none !important;padding-left: 20px !important;font-size: 14px !important;">
                                                                <strong class="text-danger">Total</strong>
                                                            </th>
                                                            <th class="text-center" style="border:none !important;padding-left: 20px !important;font-size: 14px !important;">
                                                                <strong class="text-danger">
                                                                    <?php echo number_format($d_totalpayable, 2); ?>
                                                                </strong>
                                                            </th>
                                                            <th class="text-center" style="border:none !important;font-size: 14px !important;">
                                                                <strong class="text-danger">
                                                                    <?php echo number_format($d_totalpaid, 2); ?>
                                                                </strong>
                                                            </th>
                                                            <th class="text-center" style="border:none !important;padding-right: 20px !important;font-size: 14px !important;">
                                                                <strong class="text-danger">
                                                                    <?php echo number_format($d_totalpayable - $d_totalpaid, 2); ?>
                                                                </strong>
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                            if (($booking['bkg_status'] != 'Issued' || $booking['bkg_status'] != 'Cancelled') && (checkAccess($user_role, 'card_charge_booking_page') || checkAccess($user_role, 'issue_booking_page') || checkAccess($user_role, 'cancel_booking_page') || checkAccess($user_role, 'delete_booking_page') || checkAccess($user_role, 'pending_issued_booking_page'))) {
                                ?>
                                <div class="row">
                                    <div class="col-md-12 p-t-10 p-b-10 text-center">
                                        <?php
                                        if (checkAccess($user_role, 'card_charge_booking_page')) {
                                        ?>
                                            <button class="cardChange btn btn-sm btn-info" data-bkg-id="<?php echo $booking['bkg_no']; ?>" type="button" style="<?php echo ($display != '') ? "display:" . $display : ''; ?>">Card Charge</button>
                                            <?php
                                        }
                                        if ($booking['bkg_status'] == 'Pending') {
                                            if (checkAccess($user_role, 'issue_booking_page') && invoicechecker($booking['bkg_no']) || $this->session->userdata('user_role') == 'Super Admin') {
                                            ?>
                                                <button class="issuetkt btn btn-sm btn-success" data-bkg-id="<?php echo $booking['bkg_no']; ?>" type="button">Issue Ticket</button>
                                            <?php
                                            }
                                            if (checkAccess($user_role, 'cancel_booking_page')) {
                                            ?>
                                                <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#cancel_booking">Cancel</button>
                                            <?php
                                            }
                                            if (!is_trans($booking['bkg_no']) && checkAccess($user_role, 'delete_booking_page')) {
                                            ?>
                                                <button class="btn btn-sm btn-danger DeleteBooking" data-bkg-id="<?php echo $booking['bkg_no']; ?>">Delete</button>
                                            <?php
                                            }
                                        } elseif (checkAccess($user_role, 'pending_issued_booking_page')) { ?>
                                            <button class="pendingBooking btn btn-sm btn-info" data-bkg-id="<?php echo $booking['bkg_no']; ?>" type="button">Pending Booking</button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php }
                            if (count($bkg_note) > 0) {
                            ?>
                                <div class="card mt-3 mb-3">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="card-title text-cyan">Booking Log:</h3>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php
                                                        foreach ($bkg_note as $key => $note) {
                                                        ?>
                                                            <p class="form-control-static mb-0">
                                                                <span class="text-dark"><?php echo $note['bkg_cmnt_by']; ?>&nbsp;<?php echo date('d-M-y h:i a', strtotime($note['bkg_cmnt_datetime'])); ?>:&nbsp;</span>
                                                                <span class="text-info"><?php echo $note['bkg_cmnt']; ?></span>&nbsp;
                                                            </p>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $invCount = 1;
                                            if (count($inv) > 0) {
                                            ?>
                                                <div class="col-md-12">
                                                    <div class="table-responsive mt-10">
                                                        <table id="paxtable" class="table full-color-table full-info-table ">
                                                            <thead>
                                                                <tr>
                                                                    <th width="05%" class="text-center">Id</th>
                                                                    <th width="10%" class="text-center">Status</th>
                                                                    <th width="14%" class="text-center">Sent to</th>
                                                                    <th width="12%" class="text-center">Sent at</th>
                                                                    <th width="12%" class="text-center">Open at</th>
                                                                    <th width="12%" class="text-center">Signed at</th>
                                                                    <th width="12%" class="text-center">Declined at</th>
                                                                    <th width="10%" class="text-center">IP</th>
                                                                    <th width="12%" class="text-center">View Doc(s)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($inv as $key => $invc) {

                                                                ?>
                                                                    <tr>
                                                                        <td class="text-center text-middle">
                                                                            <?php echo $invCount++; ?>
                                                                        </td>
                                                                        <td class="text-center text-middle">
                                                                            <?php if ($invc['status'] == 'Sent') { ?>
                                                                                <span class="badge badge-pill bg-warning">Sent</span>
                                                                            <?php } elseif ($invc['status'] == 'Open') { ?>
                                                                                <span class="badge badge-pill bg-info">Open</span>
                                                                            <?php } elseif ($invc['status'] == 'Signed') { ?>
                                                                                <span class="badge badge-pill bg-success">Signed</span>
                                                                            <?php } elseif ($invc['status'] == 'Declined') { ?>
                                                                                <span class="badge badge-pill bg-danger">Declined</span>
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td class="text-center text-middle">
                                                                            <span data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $invc['email']; ?>"><?php custom_echo($invc['email'], 12); ?></span>
                                                                        </td>
                                                                        <td class="text-center text-middle">
                                                                            <?php
                                                                            if ($invc['sent_datetime'] != 0) {
                                                                                echo date('d-M-y H:i', strtotime($invc['sent_datetime']));
                                                                            } else {
                                                                                echo "-";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center text-middle">
                                                                            <?php
                                                                            if ($invc['open_datetime'] != 0) {
                                                                                echo date('d-M-y H:i', strtotime($invc['open_datetime']));
                                                                            } else {
                                                                                echo "-";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center text-middle">
                                                                            <?php
                                                                            if ($invc['sign_datetime'] != 0) {
                                                                                echo date('d-M-y H:i', strtotime($invc['sign_datetime']));
                                                                            } else {
                                                                                echo "-";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center text-middle">
                                                                            <?php
                                                                            if ($invc['decline_datetime'] != 0) {
                                                                                echo date('d-M-y H:i', strtotime($invc['decline_datetime']));
                                                                            } else {
                                                                                echo "-";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center text-middle">
                                                                            <?php
                                                                            if ($invc['loc_ip'] != '') {
                                                                                echo $invc['loc_ip'];
                                                                            } else {
                                                                                echo "0.0.0.0";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center text-middle">
                                                                            <?php
                                                                            if ($invc['status'] == 'Signed') {
                                                                            ?>
                                                                                <a target="_blank" href="<?php echo $this->link_esign; ?>/signed/<?php echo $invc['access_token'] ?>.pdf" class="btn btn-xs btn-sm btn-info">Signed PDF</a>
                                                                            <?php } elseif ($invc['status'] == 'Declined') {
                                                                                echo "-";
                                                                            } else { ?>
                                                                                <a target="_blank" href="<?php echo $this->link_esign; ?>/invoice_detail/detail/<?php echo hashing($invc['bkgno']) ?>" class="btn btn-xs btn-sm btn-info">View Doc</a>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="card mb-3">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="card-title text-cyan">Booking Note:</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <?php if ($booking['bkg_status'] != 'Issued' && $booking['bkg_status'] != 'Cancelled') { ?>
                                                    <div class="col-md-12">
                                                        <p class="form-control-static text-success <?php echo (($booking['bkg_agent'] == $user_name) || checkAccess($user_role, 'admin_view_booking_page')) ? 'editField' : ''; ?>" data-edit-type="textarea" data-name="flt_bookingnote" data-bkg-id="<?php echo $booking['bkg_no']; ?>" data-value="Double click to add note">Double click to add note</p>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-md-12">
                                                    <?php
                                                    $total_cmnts = count($bkg_cmnt);
                                                    if ($total_cmnts > 0) {
                                                        foreach ($bkg_cmnt as $key => $cmnt) {
                                                    ?>
                                                            <p class="form-control-static mb-0">
                                                                <span class="text-dark"><?php echo $cmnt['bkg_cmnt_by']; ?>&nbsp;<?php echo date('d-M-y h:i a', strtotime($cmnt['bkg_cmnt_datetime'])); ?>:&nbsp;</span>
                                                                <span class="text-info"><?php echo $cmnt['bkg_cmnt']; ?></span>&nbsp;
                                                            </p>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $totalPaymentRequest = count($payment_requests);
                            $totaltktRequest = count($tkt_requests);
                            $flt_tkt_btn = $htl_tkt_btn = $cab_tkt_btn = TRUE;
                            if ($totalPaymentRequest != 0 || $totaltktRequest != 0) {
                            ?>
                                <div class="card mb-3">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="card-title   font-weight-600">
                                                    Pending Task</h4>
                                            </div>
                                        </div>
                                        <?php if ($totalPaymentRequest != 0) { ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="card-title  ">I) Payments &amp; Others</h5>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="paxtable" class="table full-color-table full-info-table hover-table">
                                                            <thead>
                                                                <?php if (checkAccess($user_role, 'direct_card_charge_through_panel') && checkBrandaccess($user_brand, 'direct_link') || $this->session->userdata('user_brand') == 'All') { ?>
                                                                    <tr>
                                                                        <th width="10%" class="text-center">S.No</th>
                                                                        <th width="15%" class="text-center">Payment Date</th>
                                                                        <th width="20%" class="text-center">Payment Type</th>
                                                                        <th width="10%" class="text-center">Amount</th>
                                                                        <th width="30%" class="text-center">Reference</th>
                                                                        <th width="15%" class="text-center">Action</th>
                                                                    </tr>
                                                                <?php } else { ?>
                                                                    <tr>
                                                                        <th width="10%" class="text-center">S.No</th>
                                                                        <th width="20%" class="text-center">Payment Date</th>
                                                                        <th width="20%" class="text-center">Payment Type</th>
                                                                        <th width="20%" class="text-center">Amount</th>
                                                                        <th width="30%" class="text-center">Reference</th>
                                                                    </tr>
                                                                <?php } ?>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sr = 1;
                                                                if ($totalPaymentRequest > 0) {
                                                                    foreach ($payment_requests as $key => $payment_request) {
                                                                ?>
                                                                        <tr>
                                                                            <td class="text-center p-0-5"><?php echo $sr; ?>
                                                                            </td>
                                                                            <td class="text-center p-0-5">
                                                                                <?php
                                                                                if ($payment_request['pdate'] == '1970-01-01') {
                                                                                    echo '-';
                                                                                } else {
                                                                                    echo date('d-M-Y', strtotime($payment_request['pdate']));
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td class="text-center p-0-5">
                                                                                <?php echo $payment_request['payment_type']; ?></td>
                                                                            <td class="text-center p-0-5">
                                                                                <?php echo number_format($payment_request['pamount'], 2); ?>
                                                                            </td>
                                                                            <td class="text-center p-0-5">
                                                                                <?php echo $payment_request['paymentdescription']; ?>
                                                                            </td>
                                                                            <?php if (checkAccess($user_role, 'direct_card_charge_through_panel') && checkBrandaccess($user_brand, 'direct_link') || $this->session->userdata('user_brand') == 'All') { ?>
                                                                                <td class="text-center">
                                                                                    <?php
                                                                                    if ($payment_request['payment_type'] == 'Card Payment') {
                                                                                    ?>
                                                                                        <button class="btn btn-xs btn-info btn-sm dcardcharge" data-pid="<?php echo $payment_request['pid']; ?>" data-orderid="<?php echo date('dmyHis', strtotime($payment_request['timestamp'])); ?>" data-amt="<?php echo $payment_request['pamount']; ?>" data-bkgid="<?php echo $booking['bkg_no']; ?>" data-brand="<?php echo $this->session->userdata('user_brand'); ?>">Charge Card</button>
                                                                                    <?php
                                                                                    } else {
                                                                                        echo '-';
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    <?php $sr++;
                                                                    }
                                                                } else { ?>
                                                                    <tr>
                                                                        <td colspan="5" class="text-center p-0-5">There is no Pending
                                                                            Payment Request...!!!</td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        if ($totaltktRequest != 0) {
                                        ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="card-title  ">II) Tickets</h5>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="paxtable" class="table full-color-table full-info-table hover-table">
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%" class="text-center">S.No</th>
                                                                    <th width="10%" class="text-center">Priority</th>
                                                                    <th width="10%" class="text-center">Type</th>
                                                                    <th width="15%" class="text-center">Supplier</th>
                                                                    <th width="15%" class="text-center">Supplier Ref</th>
                                                                    <th width="10%" class="text-center">GDS</th>
                                                                    <th width="10%" class="text-center">PNR</th>
                                                                    <th width="15%" class="text-center">Message</th>
                                                                    <th width="10%" class="text-center">Ticket Cost</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sr = 1;
                                                                if ($totaltktRequest > 0) {
                                                                    foreach ($tkt_requests as $key => $tkt_request) {
                                                                        if ($tkt_request['type'] == 'flight') {
                                                                            $flt_tkt_btn = FALSE;
                                                                        } else if ($tkt_request['type'] == 'hotel') {
                                                                            $htl_tkt_btn = FALSE;
                                                                        } else if ($tkt_request['type'] == 'cab') {
                                                                            $cab_tkt_btn = FALSE;
                                                                        }
                                                                        $bg = '';
                                                                        if ($tkt_request['direct_send'] == '1') {
                                                                            $bg = 'bg-green';
                                                                        }
                                                                ?>
                                                                        <tr class="<?php echo $bg; ?>">
                                                                            <td class="text-center p-0-5"><?php echo $sr; ?></td>
                                                                            <td class="text-center p-0-5"><?php echo $tkt_request['priority']; ?></td>
                                                                            <td class="text-center p-0-5"><?php echo $tkt_request['type']; ?></td>
                                                                            <td class="text-center p-0-5"><?php echo $tkt_request['supplier']; ?></td>
                                                                            <td class="text-center p-0-5"><?php echo $tkt_request['supplier_ref']; ?></td>
                                                                            <td class="text-center p-0-5"><?php echo $tkt_request['gds']; ?></td>
                                                                            <td class="text-center p-0-5"><?php echo $tkt_request['pnr']; ?></td>
                                                                            <td class="text-center p-0-5"><?php echo $tkt_request['message']; ?></td>
                                                                            <td class="text-center p-0-5"><?php echo number_format($tkt_request['ticket_cost'], 2); ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php
                                                                        $sr++;
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="9" class="text-center p-0-5">There is no Pending Ticket Request...!!!</td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto">
                                            <h3 class="card-title text-cyan align-middle mb-0 mt-1">File Upload:</h3>
                                        </div>
                                        <div class="col-auto ms-auto">
                                            <form method="post" action="<?php echo base_url("booking/uploadFile"); ?>" enctype="multipart/form-data" accept-charset="utf-8" class="">
                                                <input type="hidden" name="bkg_id" value="<?php echo $booking['bkg_no']; ?>">
                                                <div class="row">
                                                    <div class="input-group mb-0">
                                                        <input required type="file" name="upload_file" class="form-control " value="">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-primary rounded-0">Upload</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                        $totalfiles = 0;
                                        $totalfiles = count($files);
                                        if ($totalfiles > 0) {
                                            foreach ($files as $key => $file) {
                                                $key++;
                                                $icon = substr($file['file_name'], strpos($file['file_name'], ".") + 1);
                                        ?>
                                                <div class="col-md-2 text-center">
                                                    <a href="<?php echo base_url("uploads/file_data/" . $file['file_name']); ?>" target="_blank">
                                                        <img src="<?php echo base_url("assets/images/file-icon/$icon.jpg"); ?>">
                                                    </a>
                                                    <p><a href="<?php echo base_url("uploads/file_data/" . $file['file_name']); ?>" target="_blank"><small><?php echo $file['file_name']; ?></small></a></p>
                                                    <i class="fa fa-trash text-danger delete_files" data-file="<?php echo $file['file_name']; ?>" data-bkg="<?php echo $booking['bkg_no']; ?>"></i>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 p-t-10 p-b-10 text-center">
                                    <?php if (checkBrandaccess($booking['bkg_brandname'], 'invoice') || $this->session->userdata('user_brand') == 'All') { ?>
                                        <a target="_blank" href="<?php echo base_url("booking/invoice/" . hashing($booking['bkg_no'])); ?>" class="btn btn-sm btn-info">Invoice</a>
                                    <?php } ?>
                                    <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal" data-bs-target="#payment_req">Payment &amp; Others Request</button>
                                    <?php if ($booking['bkg_status'] != 'Issued' && $booking['bkg_status'] != 'Cancelled') {
                                        $amtdue_tktorder = $totalsale - $amountRec;
                                        if (($flt_tkt_btn && $booking['flight']) || ($htl_tkt_btn && $booking['hotel']) || ($cab_tkt_btn && $booking['cab'])) {
                                            if ($profit >= 0 && $amtdue_tktorder <= 0 && invoicechecker($booking['bkg_no']) && checkBrandaccess($booking['bkg_brandname'], 'direct_tktorder')) {
                                    ?>
                                                <button class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#ticket_req">Send Ticket Order Directly</button>
                                            <?php } else { ?>
                                                <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal" data-bs-target="#ticket_req">Ticket Order</button>
                                        <?php }
                                        }
                                    }
                                    if ($booking['bkg_status'] == 'Pending' && ($booking['bkg_agent'] == $user_name || checkAccess($user_role, 'admin_view_booking_page'))) { ?>
                                        <button class="btn btn-sm btn-info CancelPending" data-bkg-id="<?php echo $booking['bkg_no']; ?>">Cancel Pending</button>
                                    <?php } ?>
                                    <?php if (checkAccess($user_role, 'duplicate_booking')) { ?>
                                        <button class="btn btn-sm btn-info DuplicateFile" data-bkg-id="<?php echo $booking['bkg_no']; ?>">Create Duplicate File</button>
                                    <?php } ?>
                                    <button type="button" class="btn btn-sm btn-info m-r-10" data-bs-toggle="modal" data-bs-target="#sendeticket">Send E-Ticket</button>
                                    <?php if (checkBrandaccess($booking['bkg_brandname'], 'review') || $this->session->userdata('user_brand') == 'All') { ?>
                                        <button class="btn btn-sm btn-info rev_invitation" data-bkgid="<?php echo $booking['bkg_no']; ?>" data-brand="<?php echo $booking['bkg_brandname']; ?>" data-agent="<?php echo $booking['bkg_agent']; ?>" data-agent-email="<?php echo agentbookingemail($booking['bkg_no']); ?>" data-cust-name="<?php echo $booking['cst_name']; ?>" data-cust-email="<?php echo $booking['cst_email']; ?>">Review Invitation</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('common/scripts', @$scripts); ?>
    <script>
        $(document).on('change', '.servicecheck', function() {
            var fcheck = $('input[name ="flightcheck"]').is(':checked');
            var hcheck = $('input[name ="hotelcheck"]').is(':checked');
            var ccheck = $('input[name ="cabcheck"]').is(':checked');
            if (!fcheck && !hcheck && !ccheck) {
                alert('Please Add atleast one option');
                $(this).prop('checked', true);
            } else {
                var bkg_no = $(this).data('bkg-no');
                var inputname = $(this).attr('name');
                var service = value = '';
                if (inputname === 'flightcheck') {
                    service = 'flight';
                } else if (inputname === 'hotelcheck') {
                    service = 'hotel';
                } else if (inputname === 'cabcheck') {
                    service = 'cab';
                }
                if ($(this).is(':checked')) {
                    value = '1';
                } else {
                    value = '0';
                }
                Swal.fire({
                    html: '<div class="text-center text-danger mt-3 mb-3">' +
                        '<h1 style="font-size:40px;">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>' +
                        '</h1>' +
                        '</div>' +
                        '<div class="text-center">' +
                        '<h3 class="font-weight-bold">Are You Sure?</h3>' +
                        '</div>' +
                        'That you want to <b class="text-danger">Delete</b> ' + service + ' from this booking',
                    confirmButtonColor: '#00c292',
                    confirmButtonText: '<small>Yes, Delete It!</small>',
                    cancelButtonText: '<small>Cancel</small>',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    customClass: {
                        confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                        cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                    }
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "<?php echo base_url('booking/updateservices'); ?>",
                            data: {
                                service: service,
                                value: value,
                                bkg_no: bkg_no,
                            },
                            type: "post",
                            dataType: "json",
                            success: function(output) {
                                location.reload(true);
                            }
                        });
                    } else {
                        $(this).prop('checked', true);
                    }
                });
            }
        });
        $(document).on("click", "#editpax", function() {
            var bkgId = $(this).data('booking-id');
            $('.loadmodaldiv').html('');
            $.ajax({
                url: "<?php echo base_url('booking/amendpaxajax'); ?>",
                data: {
                    booking_id: bkgId
                },
                type: "post",
                dataType: "json",
                success: function(output) {
                    if (output.toaster == 'success') {
                        $('.loadmodaldiv').html(output.html);
                        $("form").parsley({
                            'trigger': 'focusout focusin'
                        });
                        $('.amendpax').modal('show');
                    } else if (output.toaster == 'error') {
                        $.toast({
                            heading: 'Access Denied',
                            text: 'Permission to amend passengers is denied',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    }
                }
            });
        });
        $(document).on("click", "#addPax", function() {
            html = '<tr>' +
                '<td class="p-0-3">' +
                '<div class="form-group mb-3 m-b-0">' +
                '<div class="controls">' +
                '<select name="pax[pax_title][]"  class="form-control form-control-sm" required  data-parsley-errors-messages-disabled>' +
                '<option value="">Title</option>' +
                '<option value="MR">MR</option>' +
                '<option value="MISS">MISS</option>' +
                '<option value="MRS">MRS</option>' +
                '<option value="MS">MS</option>' +
                '<option value="MSTR">MSTR</option>' +
                '<option value="DR">DR</option>' +
                '<option value="Prof.">Prof.</option>' +
                '</select>' +
                '<input type="hidden" name="pax[pax_eticket_no][]" value="" />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" name="pax[pax_first_name][]" class="form-control form-control-sm" required  data-parsley-errors-messages-disabled/>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" name="pax[pax_mid_name][]" class="form-control form-control-sm"  data-parsley-errors-messages-disabled/>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" name="pax[pax_sur_name][]" class="form-control form-control-sm" required  data-parsley-errors-messages-disabled/>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" name="pax[pax_age][]" class="form-control form-control-sm"  data-parsley-errors-messages-disabled/>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<select name="pax[pax_type][]"  class="form-control form-control-sm" required  data-parsley-errors-messages-disabled>' +
                '<option value="Adult">Adult</option>' +
                '<option value="Youth">Youth</option>' +
                '<option value="Child">Child</option>' +
                '<option value="Infant">Infant</option>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" data-parsley-pattern="^[0-9.-]+$" name="pax[pax_sale][]" class="sale_price text-center form-control form-control-sm" required value="0.00" data-parsley-errors-messages-disabled />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" data-parsley-pattern="^[0-9.-]+$" name="pax[pax_hotel][]" class="hotel_price text-center form-control form-control-sm" required value="0.00" data-parsley-errors-messages-disabled />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" data-parsley-pattern="^[0-9.-]+$" name="pax[pax_cab][]" class="cab_price text-center form-control form-control-sm" required value="0.00" data-parsley-errors-messages-disabled />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" data-parsley-pattern="^[0-9.-]+$" name="pax[pax_fee][]" class="booking_fee text-center form-control form-control-sm" required value="0.00"  data-parsley-errors-messages-disabled />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_sale_total][]" readonly class="pax_total text-center form-control form-control-sm" required value="0.00"  data-parsley-errors-messages-disabled />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<a class="deletepax">-</a>' +
                '</td>' +
                '</tr>';
            $("#extendPax").append(html);
            $('form').parsley();
        });
        $(document).on("click", ".deletepax", function() {
            $(this).parent().parent().remove();
        });
        $(document).on("submit", "#formpax", function(e) {
            e.preventDefault();
            var form = $('#formpax').serialize();
            var subText = $("#submitButton").data("process");
            $("#submitButton").attr("disabled", "disabled");
            $("#submitButton").html(subText);
            $.ajax({
                url: base_url + "/booking/update_pax",
                data: form,
                type: "post",
                dataType: "json",
                success: function(output) {
                    if (output.status === 'True') {
                        location.reload(true);
                    }
                }
            });
            setTimeout(function() {
                $("#submitButton").removeAttr("disabled");
                $("#submitButton").html("update");
            }, 5000);
        });
        $(document).on("blur", ".cab_price", function() {
            var salePrice = $.trim($(".sale_price", $(this).closest("tr")).val());
            var bookingFee = $.trim($(".booking_fee", $(this).closest("tr")).val());
            var hotelprice = $.trim($(".hotel_price", $(this).closest("tr")).val());
            var cabprice = $.trim($(this).val());
            if (bookingFee == "") {
                bookingFee = 0;
            }
            if (salePrice == "") {
                salePrice = 0;
            }
            if (hotelprice == "") {
                hotelprice = 0;
            }
            if (cabprice == "") {
                cabprice = 0;
            }
            $(".pax_total", $(this).closest("tr")).val(parseFloat(bookingFee) + parseFloat(salePrice) + parseFloat(hotelprice) + parseFloat(cabprice));

        });
        $(document).on("blur", ".hotel_price", function() {
            var salePrice = $.trim($(".sale_price", $(this).closest("tr")).val());
            var bookingFee = $.trim($(".booking_fee", $(this).closest("tr")).val());
            var cabprice = $.trim($(".cab_price", $(this).closest("tr")).val());
            var hotelprice = $.trim($(this).val());
            if (bookingFee == "") {
                bookingFee = 0;
            }
            if (salePrice == "") {
                salePrice = 0;
            }
            if (hotelprice == "") {
                hotelprice = 0;
            }
            if (cabprice == "") {
                cabprice = 0;
            }
            $(".pax_total", $(this).closest("tr")).val(parseFloat(bookingFee) + parseFloat(salePrice) + parseFloat(hotelprice) + parseFloat(cabprice));

        });
        $(document).on("blur", ".booking_fee", function() {
            var bookingFee = $.trim($(this).val());
            var salePrice = $.trim($(".sale_price", $(this).closest("tr")).val());
            var hotelprice = $.trim($(".hotel_price", $(this).closest("tr")).val());
            var cabprice = $.trim($(".cab_price", $(this).closest("tr")).val());
            if (bookingFee == "") {
                bookingFee = 0;
            }
            if (salePrice == "") {
                salePrice = 0;
            }
            if (hotelprice == "") {
                hotelprice = 0;
            }
            if (cabprice == "") {
                cabprice = 0;
            }
            $(".pax_total", $(this).closest("tr")).val(parseFloat(bookingFee) + parseFloat(salePrice) + parseFloat(hotelprice) + parseFloat(cabprice));

        });
        $(document).on("blur", ".sale_price", function() {
            var salePrice = $.trim($(this).val());
            var hotelprice = $.trim($(".hotel_price", $(this).closest("tr")).val());
            var cabprice = $.trim($(".cab_price", $(this).closest("tr")).val());
            var bookingFee = $.trim($(".booking_fee", $(this).closest("tr")).val());
            if (bookingFee == "") {
                bookingFee = 0;
            }
            if (salePrice == "") {
                salePrice = 0;
            }
            if (hotelprice == "") {
                hotelprice = 0;
            }
            if (cabprice == "") {
                cabprice = 0;
            }
            $(".pax_total", $(this).closest("tr")).val(parseFloat(bookingFee) + parseFloat(salePrice) + parseFloat(hotelprice) + parseFloat(cabprice));

        });
        $(document).on("blur", ".typeahead", function() {
            var details = $.trim($(this).val());
            $(".typeahead", $(this).closest("span")).attr("value", details);
        });
        $(document).keyup(function(e) {
            if (e.key === "Escape") {
                html = $(".updatingField").data("value");
                $(".updatingField").html(html);
                $(".updatingField").addClass("editField");
                $(".updatingField").removeClass("updatingField");
                $(".disableEdit").addClass("editField");
                $(".disableEdit").removeClass("disableEdit");
            }
        });
        $(document).on("click", ".cardChange", function() {
            var bkgId = $(this).data('bkg-id');
            var mainthis = $(this);
            $('.loadmodaldiv').html('');
            mainthis.attr("disabled", "disabled");
            mainthis.html('processing');
            $.ajax({
                url: "<?php echo base_url('booking/viewcardajax'); ?>",
                data: {
                    bkgId: bkgId
                },
                type: "post",
                dataType: "json",
                success: function(output) {
                    if (output != 'false') {
                        $('.loadmodaldiv').html(output);
                        $('.card_charge').modal('show');
                        mainthis.removeAttr("disabled");
                        mainthis.html("Card Charge");
                    } else {
                        location.reload(true);
                    }
                }
            });
        });
        $(document).on('submit', '#cancelForm', function(e) {
            e.preventDefault();
            $('#cancelForm').parsley();
            var form = $('#cancelForm').serialize();
            $(".canceltktBtn").attr("disabled", "disabled");
            $.ajax({
                url: "<?php echo base_url('booking/cancelTicket'); ?>",
                data: form,
                type: "post",
                dataType: "json",
                success: function(output) {
                    if (output.status == 'true') {
                        window.location.href = "<?php echo base_url('booking/cancelled/'); ?>" + output.booking_id;
                    } else if (output.status == 'false') {
                        location.reload(true);
                    }
                }
            });
            $(".canceltktBtn").removeAttr("disabled");
        });
        $(document).on("blur", ".costs", function() {
            var thisamount = $.trim($(this).val());
            var tktCost = 0;
            var payableSup = 0;
            var addExp = 0;
            var costBasic = $.trim($('#cost_basic').val());
            var costTax = $.trim($('#cost_tax').val());
            var costApc = $.trim($('#cost_apc').val());
            var costMisc = $.trim($('#cost_misc').val());
            var costBank = $.trim($('#cost_bank_charges_internal').val());
            var costCard = $.trim($('#cost_cardcharges').val());
            var costPost = $.trim($('#cost_postage').val());
            var costCardver = $.trim($('#cost_cardverfication').val());

            payableSup = parseFloat(costBasic) + parseFloat(costTax) + parseFloat(costApc) + parseFloat(costMisc);
            addExp = parseFloat(costBank) + parseFloat(costCard) + parseFloat(costPost) + parseFloat(costCardver);
            tktCost = parseFloat(payableSup) + parseFloat(addExp);

            $('.tkt_cost').html(parseFloat(tktCost));
            $('.payable_sup').html(parseFloat(payableSup));
            $('.add_exp').html(parseFloat(addExp));

            if (thisamount === '' || thisamount === '0' || thisamount === '0.0') {
                thisamount = '0.00';
                $(this).val(thisamount);
            }
            $(this).parsley().validate();
        });
        $(document).on("click", ".DeleteBooking", function() {
            var bkg_id = $(this).data('bkg-id');
            var thismain = $(this);
            thismain.attr("disabled", "disabled");
            thismain.html("Processing...");
            Swal.fire({
                html: '<div class="text-center text-danger mt-3 mb-3">' +
                    '<h1 style="font-size:40px;">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>' +
                    '</h1>' +
                    '</div>' +
                    '<div class="text-center">' +
                    '<h3 class="font-weight-bold">Are You Sure?</h3>' +
                    '</div>' +
                    'That you want to <b class="text-danger">Delete</b> this booking',
                confirmButtonColor: '#00c292',
                confirmButtonText: '<small>Yes, Delete It!</small>',
                cancelButtonText: '<small>Cancel</small>',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                    cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                }
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('booking/DeleteBooking'); ?>",
                        type: "POST",
                        data: {
                            bkg_id: bkg_id,
                        },
                        dataType: "json",
                        success: function(output) {
                            if (output) {
                                $.toast({
                                    heading: 'Successful',
                                    text: 'Booking Deleted..!!!',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    stack: 6
                                });
                                window.location.href = "<?php echo base_url('dashboard'); ?>";
                            } else {
                                Swal.fire("Error!", "Please try again", "error");
                            }
                        },
                        error: function(output) {
                            Swal.fire("Error!", "Please try again", "error");
                        }
                    });
                }
            });
            thismain.removeAttr("disabled");
            thismain.html("Delete");
        });
        $(document).on('change', '#payment_type', function() {
            var type = $(this).val();
            if (type === 'Bank Payment') {
                $('#bank_section').show(500);
                $('#payment_bank').attr('required');
            } else {
                $('#bank_section').hide(500);
                $('#payment_bank').removeAttr('required');
                $('#req_payment_date').removeAttr('required');
            }
        });
        $(document).on('submit', '#payment_request', function(e) {
            e.preventDefault();
            var form = $('#payment_request').serialize();
            $("#paymentreqsubmit").attr("disabled", "disabled");
            $("#paymentreqsubmit").html("Processing...");
            $.ajax({
                url: "<?php echo base_url('booking/addpaymentRequest'); ?>",
                data: form,
                type: "post",
                dataType: "json",
                success: function(output) {
                    location.reload(true);
                }
            });
            $("#paymentreqsubmit").removeAttr("disabled");
            $("#paymentreqsubmit").html("Submit");
        });
        $(document).on('change', '.tktorder', function() {
            var name = $(this).attr('name');
            if (name === 'flt_tkt_order') {
                if ($('input[name="flt_tkt_order"]').is(':checked')) {
                    $('.flt_tkt_details').css('display', '');
                } else {
                    $('.flt_tkt_details').css('display', 'none');
                }
            } else if (name === 'htl_tkt_order') {
                if ($('input[name="htl_tkt_order"]').is(':checked')) {
                    $('.htl_tkt_details').css('display', '');
                } else {
                    $('.htl_tkt_details').css('display', 'none');
                }
            } else if (name === 'cab_tkt_order') {
                if ($('input[name="cab_tkt_order"]').is(':checked')) {
                    $('.cab_tkt_details').css('display', '');
                } else {
                    $('.cab_tkt_details').css('display', 'none');
                }
            }
        });
        $(document).on('submit', '#tk_request', function(e) {
            e.preventDefault();
            var flt_tkt_order = htl_tkt_order = cab_tkt_order = false;
            if ($('input[name="flt_tkt_order"]').length != 0) {
                flt_tkt_order = $('input[name="flt_tkt_order"]').is(':checked');
            }
            if ($('input[name="htl_tkt_order"]').length != 0) {
                htl_tkt_order = $('input[name="htl_tkt_order"]').is(':checked');
            }
            if ($('input[name="cab_tkt_order"]').length != 0) {
                cab_tkt_order = $('input[name="cab_tkt_order"]').is(':checked');
            }
            if (!flt_tkt_order && !htl_tkt_order && !cab_tkt_order) {
                alert('Please select atleast one option');
            } else {
                var form = $('#tk_request').serialize();
                $("#tktreqsubmit").attr("disabled", "disabled");
                $("#tktreqsubmit").html("Processing...");
                $.ajax({
                    url: "<?php echo base_url('booking/addtktRequest') ?>",
                    data: form,
                    type: "post",
                    dataType: "json",
                    success: function(output) {
                        location.reload(true);
                    }
                });
                $("#tktreqsubmit").removeAttr("disabled");
                $("#tktreqsubmit").html("Submit");
            }
        });
        <?php if ($booking['bkg_status'] != 'Pending') { ?>
            $('.editField').removeClass('editField');
            $(document).on("click", ".pendingBooking", function() {
                var bkg_id = $(this).data('bkg-id');
                $('.pendingBooking').attr("disabled", "disabled");
                $('.pendingBooking').html("Processing...");
                Swal.fire({
                    html: '<div class="text-center text-danger mt-3 mb-3">' +
                        '<h1 style="font-size:40px;">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>' +
                        '</h1>' +
                        '</div>' +
                        '<div class="text-center">' +
                        '<h3 class="font-weight-bold">Are You Sure?</h3>' +
                        '</div>' +
                        'That you want to <b class="text-success">Pending</b> this booking',
                    confirmButtonColor: '#00c292',
                    confirmButtonText: '<small>Yes, Change It!</small>',
                    cancelButtonText: '<small>Cancel</small>',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    customClass: {
                        confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                        cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                    }
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "<?php echo base_url('booking/pendingBooking'); ?>",
                            type: "POST",
                            data: {
                                bkg_id: bkg_id,
                            },
                            dataType: "json",
                            success: function(output) {
                                if (output.status) {
                                    $.toast({
                                        heading: 'Successful',
                                        text: 'Booking Status Changed',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'success',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                    window.location.href = "<?php echo base_url('booking/pending/'); ?>" + output.id;
                                } else {
                                    Swal.fire("Error!", "Please try again", "error");
                                }
                            },
                            error: function(output) {
                                Swal.fire("Error!", "Please try again", "error");
                            }
                        });
                    }
                });
                $('.pendingBooking').removeAttr("disabled");
                $('.pendingBooking').html("Pending Booking");
            });
        <?php } elseif ($booking['bkg_status'] == 'Pending') { ?>
            $(document).on("dblclick", ".editField", function(e) {
                e.preventDefault();
                $(this).addClass("updatingField");
                $(".editField").addClass("disableEdit");
                $(".updatingField").removeClass("disableEdit");
                $(".editField").removeClass("editField");
                var field = $(this);
                var editType = $(this).data("edit-type");
                var bkgID = $(this).data("bkg-id");
                var inputType;
                var inputName;
                var inputClass;
                var inputPicker;
                var editfor = 'flight';
                if ($(this).data("edit-for")) {
                    editfor = $(this).data("edit-for");
                }
                if ($(this).data("input-type")) {
                    inputType = $(this).data("input-type");
                } else {
                    inputType = ' ';
                }
                if ($(this).data("name")) {
                    inputName = $(this).data("name");
                } else {
                    inputName = ' ';
                }
                if ($(this).data("class")) {
                    inputClass = $(this).data("class");
                } else {
                    inputClass = ' ';
                }
                if ($(this).data("picker")) {
                    inputPicker = $(this).data("picker");
                } else {
                    inputPicker = ' ';
                }
                if (inputName != 'flt_ticketdetail') {
                    var text = $.trim($(this).text());
                } else {
                    var text = $.trim($(this).data('value'));
                }
                if (editType === 'input') {
                    if (inputPicker === 'typeahead') {
                        $('.airport').typeahead('destroy');
                        $('.airline').typeahead('destroy');
                    }
                    if (inputClass === 'card_number') {
                        var minLength = 'maxlength="19" minlength="19"';
                    } else {
                        var minLength = '';
                    }
                    html = '<form id="inlineEditForm">' +
                        '<div class="input-group">' +
                        '<input type="hidden" name="bkg_no" value="' + bkgID + '"/>' +
                        '<input type="hidden" name="editfor" value="' + editfor + '"/>' +
                        '<input type="' + inputType + '" name="' + inputName + '" id="' + inputName + '" class="' + inputClass + ' editvalue form-control form-control-sm" value="' + text + '" autocomplete="off" ' + minLength + ' required data-parsley-errors-messages-disabled data-parsley-trigger="focusin focusout" />' +
                        '<span class="input-group-btn">' +
                        '<button id="submitButton" class="btn btn-success btn-sm" type="submit">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>' +
                        '</button>' +
                        '</span>' +
                        '</div>' +
                        '</form>';
                    $(this).html(html);
                    if (inputPicker === 'date') {
                        $(".date").datetimepicker({
                            format: "dd-M-yyyy",
                            autoclose: true,
                            todayBtn: true,
                            todayHighlight: true,
                            showMeridian: true,
                            startView: 2,
                            minView: 2,
                        }).on('changeDate', function(e) {
                            $(this).parsley().validate();
                        });
                        $(".datetime").datetimepicker({
                            format: "dd-M-yyyy HH:ii P",
                            autoclose: true,
                            todayBtn: true,
                            todayHighlight: true,
                            showMeridian: true,
                            startView: 2,
                            minView: 0,
                        }).on('changeDate', function(e) {
                            $(this).parsley().validate();
                        });
                    } else if (inputPicker === 'typeahead') {
                        typeahead_initialize();
                        $("input.tt-hint").removeAttr("required data-parsley-errors-messages-disabled data-parsley-trigger");
                        $("input.tt-hint").removeClass("editvalue");
                    }
                    $(document).on('keyup', '.card_number', function() {
                        var ele = $(this).val();
                        ele = ele.split(' ').join(''); // Remove dash (-) if mistakenly entered.
                        var finalVal = ele.match(/.{1,4}/g).join(' ');
                        $(this).val(finalVal);
                    });
                } else if (editType === 'select') {
                    var optionData;
                    if (inputName === 'tpp_cardexpirydate') {
                        html = '<form id="inlineEditForm">' +
                            '<div class="input-group">' +
                            '<input type="hidden" name="bkg_no" class="bkg_no" value="' + bkgID + '"/>' +
                            '<input type="hidden" name="editfor" class="editfor" value="' + editfor + '"/>' +
                            '<select name="card_exp_month" class="card_exp_month form-control form-control-sm" autocomplete="off" required="" data-parsley-error-message="Select Month" data-parsley-trigger="focusin focusout">' +
                            '<option value="">Month</option>' +
                            '<option value="01">January</option>' +
                            '<option value="02">February</option>' +
                            '<option value="03">March</option>' +
                            '<option value="04">April</option>' +
                            '<option value="05">May</option>' +
                            '<option value="06">June</option>' +
                            '<option value="07">July</option>' +
                            '<option value="08">August</option>' +
                            '<option value="09">September</option>' +
                            '<option value="10">October</option>' +
                            '<option value="11">November</option>' +
                            '<option value="12">December</option>' +
                            '</select>' +
                            '<select name="card_exp_year" class="card_exp_year form-control form-control-sm" autocomplete="off" required="" data-parsley-error-message="Select Year" data-parsley-trigger="focusin focusout">' +
                            '<option value="">Year</option>' +
                            '<option value="2021">2021</option>' +
                            '<option value="2022">2022</option>' +
                            '<option value="2023">2023</option>' +
                            '<option value="2024">2024</option>' +
                            '<option value="2025">2025</option>' +
                            '<option value="2026">2026</option>' +
                            '<option value="2027">2027</option>' +
                            '<option value="2028">2028</option>' +
                            '<option value="2029">2029</option>' +
                            '<option value="2030">2030</option>' +
                            '<option value="2031">2031</option>' +
                            '<option value="2032">2032</option>' +
                            '</select>' +
                            '<span class="input-group-btn">' +
                            '<button id="submitButton" class="btn btn-success btn-sm" type="submit">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>' +
                            '</button>' +
                            '</span>' +
                            '</div>' +
                            '</form>';
                        $(field).html(html);
                        $("#inlineEditForm").on("submit", function(e) {
                            e.preventDefault();
                            var bkg_no = $('.bkg_no').val();
                            var editfor = $('.editfor').val();
                            var card_exp_month = $('.card_exp_month').val();
                            var card_exp_year = $('.card_exp_year').val();
                            var tpp_cardexpirydate = card_exp_month + ' - ' + card_exp_year;
                            $("#submitButton").attr("disabled", "disabled");
                            $.ajax({
                                url: base_url + "/booking/inlineEdit",
                                data: {
                                    tpp_cardexpirydate: tpp_cardexpirydate,
                                    bkg_no: bkg_no,
                                    editfor: editfor,
                                },
                                type: "post",
                                dataType: "json",
                                success: function(output) {
                                    if (output.status === 'true') {
                                        if (output.toaster === 'success') {
                                            $.toast({
                                                heading: 'Edit Successful',
                                                text: 'This filed Has been updated',
                                                position: 'top-right',
                                                loaderBg: '#ff6849',
                                                icon: 'success',
                                                hideAfter: 3500,
                                                stack: 6
                                            });
                                        }
                                        var editValue = output.value;
                                        $(field).html(editValue);
                                        $(field).addClass("glow-success");
                                        setTimeout(function() {
                                            $(field).removeClass("glow-success");
                                        }, 5000);
                                        $(".updatingField").addClass("editField");
                                        $(".disableEdit").addClass("editField");
                                        $(".disableEdit").removeClass("disableEdit");
                                        $(field).removeClass("updatingField");
                                        location.reload();
                                    } else if (output.status === 'false') {
                                        var editValue = $('.updatingField').data("value"); //$(".editvalue").val();
                                        $(field).html(editValue);
                                        $(field).addClass("glow-danger");
                                        setTimeout(function() {
                                            $(field).removeClass("glow-danger");
                                        }, 5000);
                                        $(".updatingField").addClass("editField");
                                        $(".disableEdit").addClass("editField");
                                        $(".disableEdit").removeClass("disableEdit");
                                        $(field).removeClass("updatingField");
                                        // $('#costSection').load(document.URL +  ' #costSection >div');
                                        if (output.toaster === 'error') {
                                            $.toast({
                                                heading: 'Access Denied',
                                                text: 'Permission to edit this field is denied',
                                                position: 'top-right',
                                                loaderBg: '#ff6849',
                                                icon: 'error',
                                                hideAfter: 3500,
                                                stack: 6
                                            });
                                        }
                                    }
                                }
                            });
                            setTimeout(function() {
                                $("#submitButton").removeAttr("disabled");
                                $("#submitButton").html('<svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>');
                            }, 2000);
                        });
                    } else {
                        $.ajax({
                            url: base_url + "/booking/selectdata",
                            data: {
                                dataform: inputName
                            },
                            type: "post",
                            dataType: "json",
                            success: function(output) {
                                var opt;
                                $.each(output, function(index, val) {
                                    opt += '<option value="' + val + '" ';
                                    if (text === val) {
                                        opt += 'selected';
                                    }
                                    opt += '>' + val + '</option>';
                                });
                                html = '<form id="inlineEditForm">' +
                                    '<div class="input-group">' +
                                    '<input type="hidden" name="bkg_no" value="' + bkgID + '"/>' +
                                    '<input type="hidden" name="editfor" value="' + editfor + '"/>' +
                                    '<select name="' + inputName + '" id="' + inputName + '" class="' + inputClass + ' editvalue form-control form-control-sm" autocomplete="off" required data-parsley-errors-messages-disabled data-parsley-trigger="focusin focusout">' +
                                    '<option value="">Select an option</option>' +
                                    '' + opt + '' +
                                    '</select>' +
                                    '<span class="input-group-btn">' +
                                    '<button id="submitButton" class="btn btn-success btn-sm" type="submit">' +
                                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>' +
                                    '</button>' +
                                    '</span>' +
                                    '</div>' +
                                    '</form>';
                                $(field).html(html);
                                $("#inlineEditForm").on("submit", function(e) {
                                    e.preventDefault();
                                    var form = $('#inlineEditForm').serialize();
                                    $("#submitButton").attr("disabled", "disabled");
                                    $.ajax({
                                        url: base_url + "/booking/inlineEdit",
                                        data: form,
                                        type: "post",
                                        dataType: "json",
                                        success: function(output) {
                                            if (output.status === 'true') {
                                                if (output.toaster === 'success') {
                                                    $.toast({
                                                        heading: 'Edit Successful',
                                                        text: 'This filed Has been updated',
                                                        position: 'top-right',
                                                        loaderBg: '#ff6849',
                                                        icon: 'success',
                                                        hideAfter: 3500,
                                                        stack: 6
                                                    });
                                                }
                                                var editValue = output.value;
                                                $(field).html(editValue);
                                                if (output.field === 'pmt_mode') {
                                                    if (output.value === 'Bank Transfer' || output.value === 'Cash') {
                                                        $('.card_details').hide();
                                                        $('.cardChange').hide();

                                                    } else {
                                                        $('.cardChange').show();
                                                        $('.card_details').show();
                                                    }
                                                }
                                                $(field).addClass("glow-success");
                                                setTimeout(function() {
                                                    $(field).removeClass("glow-success");
                                                }, 5000);
                                                $(".updatingField").addClass("editField");
                                                $(".disableEdit").addClass("editField");
                                                $(".disableEdit").removeClass("disableEdit");
                                                $(field).removeClass("updatingField");
                                                location.reload();
                                            } else if (output.status === 'false') {
                                                var editValue = $('.updatingField').data("value"); //$(".editvalue").val();
                                                $(field).html(editValue);
                                                $(field).addClass("glow-danger");
                                                setTimeout(function() {
                                                    $(field).removeClass("glow-danger");
                                                }, 5000);
                                                $(".updatingField").addClass("editField");
                                                $(".disableEdit").addClass("editField");
                                                $(".disableEdit").removeClass("disableEdit");
                                                $(field).removeClass("updatingField");
                                                // $('#costSection').load(document.URL +  ' #costSection >div');
                                                if (output.toaster === 'error') {
                                                    $.toast({
                                                        heading: 'Access Denied',
                                                        text: 'Permission to edit this field is denied',
                                                        position: 'top-right',
                                                        loaderBg: '#ff6849',
                                                        icon: 'error',
                                                        hideAfter: 3500,
                                                        stack: 6
                                                    });
                                                }
                                            }
                                        }
                                    });
                                    setTimeout(function() {
                                        $("#submitButton").removeAttr("disabled");
                                        $("#submitButton").html('<svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>');
                                    }, 2000);
                                });
                            }
                        });
                    }
                } else if (editType === 'textarea') {
                    if (inputName !== 'flt_bookingnote') {
                        html = '<form id="inlineEditForm">' +
                            '<div class="input-group">' +
                            '<input type="hidden" name="bkg_no" value="' + bkgID + '" />' +
                            '<input type="hidden" name="editfor" value="' + editfor + '" />' +
                            '<textarea name="' + inputName + '" rows="2" id="' + inputName + '" class="form-control custom form-control-sm editvalue">' + text + '</textarea>' +
                            '<span class="input-group-btn">' +
                            '<button id="submitButton" class="btn btn-success btn-sm" type="submit">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>' +
                            '</button>' +
                            '</span>' +
                            '</div>' +
                            '</form>';
                    } else {
                        html = '<form id="inlineEditForm">' +
                            '<div class="input-group">' +
                            '<input type="hidden" name="bkg_no" value="' + bkgID + '" />' +
                            '<input type="hidden" name="editfor" value="' + editfor + '" />' +
                            '<textarea name="' + inputName + '" rows="2" id="' + inputName + '" class="form-control custom form-control-sm editvalue"></textarea>' +
                            '<span class="input-group-btn">' +
                            '<button id="submitButton" class="btn btn-success btn-sm" type="submit">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>' +
                            '</button>' +
                            '</span>' +
                            '</div>' +
                            '</form>';
                    }
                    $(this).html(html);
                    tinymce.init({
                        selector: 'textarea.custom',
                        forced_root_block: "",
                        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                        menubar: 'file edit view insert format tools table help',
                        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                        toolbar_sticky: true,
                        paste_data_images: true,
                    });
                }
                $("#inlineEditForm").on("submit", function(e) {
                    e.preventDefault();
                    var form = $('#inlineEditForm').serialize();
                    $("#submitButton").attr("disabled", "disabled");
                    $.ajax({
                        url: base_url + "/booking/inlineEdit",
                        data: form,
                        type: "post",
                        dataType: "json",
                        success: function(output) {
                            if (output.status === 'true') {
                                if (output.toaster === 'success') {
                                    $.toast({
                                        heading: 'Edit Successful',
                                        text: 'This filed Has been updated',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'success',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                                var editValue = output.value;
                                $(field).html(editValue);
                                $(field).addClass("glow-success");
                                setTimeout(function() {
                                    $(field).removeClass("glow-success");
                                }, 5000);
                                $(".updatingField").addClass("editField");
                                $(".disableEdit").addClass("editField");
                                $(".disableEdit").removeClass("disableEdit");
                                $(field).removeClass("updatingField");
                                location.reload();
                            } else if (output.status === 'false') {
                                var editValue = $('.updatingField').data("value"); //$(".editvalue").val();
                                $(field).html(editValue);
                                $(field).addClass("glow-danger");
                                setTimeout(function() {
                                    $(field).removeClass("glow-danger");
                                }, 5000);
                                $(".updatingField").addClass("editField");
                                $(".disableEdit").addClass("editField");
                                $(".disableEdit").removeClass("disableEdit");
                                $(field).removeClass("updatingField");
                                // $('#costSection').load(document.URL +  ' #costSection >div');
                                if (output.toaster === 'error') {
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to edit this field is denied',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }

                            }
                        }
                    });
                    setTimeout(function() {
                        $("#submitButton").removeAttr("disabled");
                        $("#submitButton").html('<svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>');
                    }, 2000);
                });
            });
            $(document).on("click", ".issuetkt", function() {
                $('.loadmodaldiv').html('');
                var bkgId = $(this).data('bkg-id');
                var thismain = $(this);
                var thishtml = thismain.html();
                thismain.attr("disabled", "disabled");
                thismain.html('processing');
                $.ajax({
                    url: "<?php echo base_url('booking/issuetktajax'); ?>",
                    data: {
                        bkgId: bkgId
                    },
                    type: "post",
                    dataType: "json",
                    success: function(output) {
                        if (output != 'false') {
                            $('.loadmodaldiv').html(output);
                            $('.issue_booking').modal('show');
                        } else {
                            location.reload(true);
                        }
                        thismain.removeAttr("disabled");
                        thismain.html(thishtml);
                    }
                });
            });
            $(document).on("submit", "#issuanceForm", function(e) {
                e.preventDefault();
                var form = $('#issuanceForm').serialize();
                var amtPending = $('.amtpend').text();
                var msg = '';
                if (amtPending > 0) {
                    msg = 'ticket with customer amount pending by ' + amtPending;
                } else {
                    msg = 'this ticket';
                }
                $('.issue_button').attr("disabled", "disabled");
                $('.issue_button').html("Processing...");
                Swal.fire({
                    html: '<div class="text-center text-warning mt-3 mb-3">' +
                        '<h1 style="font-size:40px;"><svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg></h1></div>' +
                        '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>' +
                        'That you want to issue <b class="text-danger">' + msg + '</b>',
                    confirmButtonColor: '#00c292',
                    confirmButtonText: '<small>Yes, Issue It!</small>',
                    cancelButtonText: '<small>Cancel</small>',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    customClass: {
                        confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                        cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                    }
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "<?php echo base_url('booking/issuebooking'); ?>",
                            type: "POST",
                            data: form,
                            dataType: "json",
                            success: function(output) {
                                if (output.status == 'true') {
                                    $.toast({
                                        heading: 'Successful',
                                        text: 'Booking Issued..!!!',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'success',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                    window.location.href = "<?php echo base_url('booking/issued/'); ?>" + output.booking_id;
                                } else {
                                    Swal.fire("Error!", "Please try again", "error");
                                }
                            },
                            error: function(output) {
                                Swal.fire("Error!", "Please try again", "error");
                            }
                        });
                    }
                });
                $('.issue_button').removeAttr("disabled");
                $('.issue_button').html("Issue Booking");
            });
        <?php } ?>
        $(document).on("click", ".CancelPending", function() {
            var bkg_id = $(this).data('bkg-id');
            var mainthing = $(this);
            mainthing.attr("disabled", "disabled");
            mainthing.html("Processing...");
            Swal.fire({
                html: '<div class="text-center text-warning mt-3 mb-3">' +
                    '<h1 style="font-size:40px;">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>' +
                    '</h1>' +
                    '</div>' +
                    '<div class="text-center">' +
                    '<h3 class="font-weight-bold">Are You Sure?</h3>' +
                    '</div>' +
                    'That you want to change the booking status to <b class="text-danger">Cancelled-Pending</b>',
                confirmButtonColor: '#00c292',
                confirmButtonText: '<small>Yes, Change It!</small>',
                cancelButtonText: '<small>Cancel</small>',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                    cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                }
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('booking/cancelPending'); ?>",
                        type: "POST",
                        data: {
                            bkg_id: bkg_id,
                        },
                        dataType: "json",
                        success: function(output) {
                            if (output) {
                                $.toast({
                                    heading: 'Successful',
                                    text: 'Booking Status Changed',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    stack: 6
                                });
                                location.reload(true);
                            } else {
                                Swal.fire("Error!", "Please try again", "error");
                            }
                        },
                        error: function(output) {
                            Swal.fire("Error!", "Please try again", "error");
                        }
                    });
                }
            });
            mainthing.removeAttr("disabled");
            mainthing.html("Cancel Pending");
        });
        $(document).on("click", ".DuplicateFile", function() {
            var bkg_id = $(this).data('bkg-id');
            var mainthis = $(this);
            mainthis.attr("disabled", "disabled");
            mainthis.html("Processing...");
            Swal.fire({
                html: '<div class="text-center text-warning mt-3 mb-3">' +
                    '<h1 style="font-size:40px;"><svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg></h1></div>' +
                    '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>' +
                    'That you want to create <b class="text-danger">duplicate booking</b>',
                confirmButtonColor: '#00c292',
                confirmButtonText: '<small>Yes, Duplicate It!</small>',
                cancelButtonText: '<small>Cancel</small>',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                    cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                }
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('booking/createDuplicate'); ?>",
                        type: "POST",
                        data: {
                            bkg_id: bkg_id,
                        },
                        dataType: "json",
                        success: function(output) {
                            if (output.status == 'true') {
                                $.toast({
                                    heading: 'Successful',
                                    text: 'Duplicate Booking Created..!!!',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    stack: 6
                                });
                                window.location.href = "<?php echo base_url('booking/pending/'); ?>" + output.booking_id;
                            } else {
                                location.reload(true);
                            }
                        },
                        error: function(output) {
                            Swal.fire("Error!", "Please try again", "error");
                        }
                    });
                }
            });
            mainthis.removeAttr("disabled");
            mainthis.html("Create Duplicate File");
        });
        $(document).on("click", ".send_reminder", function() {
            var bkg_id = $(this).data('bkg-id');
            var email = $(this).data('email');
            var due_date = $(this).data('due-date');
            var pending_amt = $(this).data('pending-amt');
            var cust_name = $(this).data('cust-name');
            var brand = $(this).data('brand');
            var mainthis = $(this);
            mainthis.attr("disabled", "disabled");
            mainthis.html("Processing...");
            Swal.fire({
                html: '<div class="text-center text-warning mt-3 mb-3">' +
                    '<h1 style="font-size:40px;">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>' +
                    '</h1>' +
                    '</div>' +
                    '<div class="text-center">' +
                    '<h3 class="font-weight-bold">Are You Sure?</h3>' +
                    '</div>' +
                    'That you want to send payment reminder to <br><strong>Email: </strong>' +
                    '<b class="text-danger">' + email + '</b><br>' +
                    '<strong>Due Date: </strong><b class="text-danger">' + due_date + '</b><br>' +
                    '<strong>Amount: </strong><b class="text-danger">£' + pending_amt + '</b>',
                confirmButtonColor: '#00c292',
                confirmButtonText: '<small>Yes, Send It!</small>',
                cancelButtonText: '<small>Cancel</small>',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                    cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                }
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('booking/sendreminder'); ?>",
                        type: "POST",
                        data: {
                            bkg_id: bkg_id,
                            email: email,
                            due_date: due_date,
                            pending_amt: pending_amt,
                            cust_name: cust_name,
                            brand: brand,
                        },
                        dataType: "json",
                        success: function(output) {
                            if (output.status === 'true') {
                                $.toast({
                                    heading: 'Successful',
                                    text: 'Reminder Has Been Sent',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    stack: 6
                                });
                                location.reload(true);
                            } else {
                                location.reload(true);
                            }
                        },
                        error: function(output) {
                            Swal.fire("Error!", "Please try again", "error");
                        }
                    });
                }
            });
            mainthis.removeAttr("disabled");
            mainthis.html("Send Reminder");
        });
        $(document).on('click', '.rev_invitation', function() {
            var bkgid = $(this).data('bkgid');
            var brand = $(this).data('brand');
            var agent_name = $(this).data('agent');
            var agent_email = $(this).data('agent-email');
            var cust_name = $(this).data('cust-name');
            var cust_email = $(this).data('cust-email');
            Swal.fire({
                html: '<div class="text-center text-warning mt-3 mb-3">' +
                    '<h1 style="font-size:40px;">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>' +
                    '</h1>' +
                    '</div>' +
                    '<div class="text-center">' +
                    '<h3 class="font-weight-bold">Are You Sure?</h3>' +
                    '</div>' +
                    'You want to send the review invitation? You won\'t be able to undo this',
                confirmButtonColor: '#00c292',
                confirmButtonText: '<small>Yes, Send It!</small>',
                cancelButtonText: '<small>Cancel</small>',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                    cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                }
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('booking/sendreviewinvitation'); ?>",
                        type: "POST",
                        data: {
                            bkg_no: bkgid,
                            bkg_brandname: brand,
                            agent_name: agent_name,
                            agent_email: agent_email,
                            cust_name: cust_name,
                            cust_email: cust_email,
                        },
                        dataType: "json",
                        success: function(output) {
                            if (output) {
                                $.toast({
                                    heading: 'Successful',
                                    text: 'Review Invitation has been sent.',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    stack: 6
                                });
                                location.reload();
                            } else {
                                Swal.fire("Error!", "Please try again", "error");
                            }
                        },
                        error: function(output) {
                            Swal.fire("Error!", "Please try again", "error");
                        }
                    });
                }
            });
        });
        $(document).on("click", ".notifyAlert", function() {
            var bkg_id = $(this).data('bkg-id');
            var email = $(this).data('email');
            var trans_by_to = $(this).data('trans-by-to');
            var trans_type = $(this).data('trans-type');
            var trans_date = $(this).data('trans-date');
            var trans_id = $(this).data('trans-id');
            var trans_cnt = $(this).data('trans-cnt');
            var amt = $(this).data('amt');
            var cust_name = $(this).data('cust-name');
            var brand = $(this).data('brand');
            $(this).attr("disabled", "disabled");
            $(this).html("Processing...");
            Swal.fire({
                html: '<div class="text-center text-warning mt-3 mb-3">' +
                    '<h1 style="font-size:40px;">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>' +
                    '</h1>' +
                    '</div>' +
                    '<div class="text-center">' +
                    '<h3 class="font-weight-bold">Are You Sure?</h3>' +
                    '</div>' +
                    'That you want to send payment notification to<br>' +
                    '<strong>Email: </strong><b class="text-danger">' + email + '</b><br>' +
                    '<strong>Amount: </strong><b class="text-danger">£' + amt + '</b>',
                confirmButtonColor: '#00c292',
                confirmButtonText: '<small>Yes, Send It!</small>',
                cancelButtonText: '<small>Cancel</small>',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                    cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                }
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: base_url + "<?php echo base_url('booking/sendpaymentnotification'); ?>",
                        type: "POST",
                        data: {
                            bkg_id: bkg_id,
                            email: email,
                            trans_by_to: trans_by_to,
                            trans_type: trans_type,
                            trans_date: trans_date,
                            trans_id: trans_id,
                            trans_cnt: trans_cnt,
                            amt: amt,
                            cust_name: cust_name,
                            brand: brand,
                        },
                        dataType: "json",
                        success: function(output) {
                            if (output.status === 'true') {
                                $.toast({
                                    heading: 'Successful',
                                    text: 'Notification Has Been Sent',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    stack: 6
                                });
                                location.reload(true);
                            } else {
                                location.reload(true);
                            }
                        },
                        error: function(output) {
                            Swal.fire("Error!", "Please try again", "error");
                        }
                    });
                }
            });
            setTimeout(function() {
                $('.notifyAlert').removeAttr("disabled");
                $('.notifyAlert').html("Notify");
            }, 2000);
        });
        $(document).on("click", ".dcardcharge", function() {
            var pid = $(this).data('pid');
            var amt = $(this).data('amt');
            var bkgid = $(this).data('bkgid');
            var orderid = $(this).data('orderid');
            var brand = $(this).data('brand');
            $('.dcardcharge').attr("disabled", "disabled");
            $('.dcardcharge').html('Processing...');
            Swal.fire({
                html: '<div class="text-center text-danger mt-3 mb-3">' +
                    '<h1 style="font-size:40px;">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>' +
                    '</h1>' +
                    '</div>' +
                    '<div class="text-center">' +
                    '<h3 class="font-weight-bold">Are You Sure?</h3>' +
                    '</div>' +
                    'That you want to <b class="text-success">charge the card</b> for: ' + amt + '/-',
                confirmButtonColor: '#00c292',
                confirmButtonText: '<small>Yes, Send It!</small>',
                cancelButtonText: '<small>Cancel</small>',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                    cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                }
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        html: '<div class="text-center text-danger mt-3 mb-3">' +
                            '<h1 style="font-size:80px;">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><polyline points="12 7 12 12 15 15" /></svg>' +
                            '</h1>' +
                            '</div>' +
                            '<div class="text-center">' +
                            '<h3 class="font-weight-bold">Processing Please Wait...!!!</h3>' +
                            '</div>',
                        showCancelButton: false,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    if (brand === 'Restricted') {
                        // $.ajax({
                        //     url: "<?php echo base_url('cardcharge/process'); ?>",
                        //     type: "POST",
                        //     data: {
                        //         pid: pid,
                        //         amt: amt,
                        //         bkgid: bkgid,
                        //         orderid: orderid,
                        //     },
                        //     dataType: "json",
                        //     success: function (output) {
                        //         if (output) {
                        //             Swal.fire({
                        //                 title: "Processed!",
                        //                 text: "Payment has been charged...!!!",
                        //                 type: "success"
                        //             }).then((result) => {
                        //                 if (result.value) {
                        //                     location.reload(true);
                        //                 }
                        //             });
                        //         } else {
                        //             Swal.fire({
                        //                 title: "Processed!",
                        //                 text: "Payment has been declined...!!!",
                        //                 type: "error"
                        //             }).then((result) => {
                        //                 if (result.value) {
                        //                     location.reload(true);
                        //                 }
                        //             });
                        //         }
                        //     },
                        //     error: function (output) {
                        //         Swal.fire("Error!", "Please try again", "error");
                        //     }
                        // });
                    } else {
                        setTimeout(function() {
                            Swal.fire({
                                title: "User Denied!",
                                text: "{User Trial Ended. Talk To Your IT Manager For Upgrading Plan.}",
                                type: "error"
                            }).then((result) => {
                                if (result.value) {
                                    location.reload(true);
                                }
                            });
                        }, 8000);
                    }
                }
            });
            $('.dcardcharge').removeAttr("disabled");
            $('.dcardcharge').html('Charge Card');
        });
    </script>
    <?php
    if (($booking['bkg_status'] != 'Issued' && $booking['bkg_status'] != 'Cancelled') && checkAccess($user_role, 'cancel_booking_page')) {
    ?>
        <div class="modal modal-blur fade" id="cancel_booking">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Cancel Booking - <?php echo $booking['bkg_no']; ?></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="cancelForm">
                            <input type="hidden" name="bkg_no" value="<?php echo $booking['bkg_no']; ?>">
                            <input type="hidden" name="add_exp" value="<?php echo $add_exp; ?>">
                            <input type="hidden" name="amtrec" value="<?php echo $amountRec; ?>">
                            <input type="hidden" name="profit" value="<?php echo $amountRec - $add_exp; ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Cencellation Date <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="cancel_date" class="date form-control" value="<?php echo date('d-M-Y'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Feedback</label>
                                        <div class="controls">
                                            <textarea name="msg" type="text" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="canceltktBtn btn btn-success" form="cancelForm">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="modal modal-blur fade" id="payment_req">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold" id="payment_reqLabel1">Payment Request</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="payment_request">
                        <input type="hidden" value="<?php echo $booking['bkg_no']; ?>" name="bookingid" />
                        <input type="hidden" value="<?php echo $booking['bkg_brandname']; ?>" name="agentname" />
                        <input type="hidden" value="<?php echo $brand["brand_pre_post_fix"]; ?>" name="agentcode" />
                        <div class="row m-t-5">
                            <div class="col-md-6">
                                <div class="form-group m-b-0">
                                    <label class="form-label">Request <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <select name="req_payment_type" id="payment_type" required class="form-control">
                                            <option value="">Select Task Request</option>
                                            <option value="Bank Payment">Bank Payment</option>
                                            <option value="Card Payment">Card Payment</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-b-0" id="bank_section">
                                    <label class="form-label">Bank <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <select name="req_payment_bank" id="payment_bank" required class="form-control">
                                            <option value="">Select Payment Bank</option>
                                            <?php
                                            foreach ($bank_head as $key => $bank) {
                                            ?>
                                                <option value="<?php echo $bank['trans_head']; ?>">
                                                    <?php echo $bank['trans_head']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-5">
                            <div class="col-md-6">
                                <div class="form-group m-b-0">
                                    <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="req_payment_date" id="req_payment_date" class="date form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-b-0">
                                    <label class="form-label">Amount <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <input type="number" step=0.01 name="req_amount" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-5">
                            <div class="col-md-12">
                                <div class="form-group m-b-0">
                                    <label class="form-label">Request Note</label>
                                    <div class="controls">
                                        <textarea name="req_note" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm" id="paymentreqsubmit" form="payment_request">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="ticket_req">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">Ticket Request</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $amtdue_tktorder = ($totalsale - $totalhotelsale - $totalcabsale) - $amountRec;
                    $bkgcheckfortktorder = 0;
                    if ($profit >= 0 && $amtdue_tktorder <= 0 && invoicechecker($booking['bkg_no'])) {
                        $bkgcheckfortktorder = 1;
                    }
                    ?>
                    <form id="tk_request">
                        <input type="hidden" value="<?php echo $booking['bkg_no']; ?>" name="bookingid" />
                        <input type="hidden" value="<?php echo $booking['bkg_brandname']; ?>" name="agentname" />
                        <input type="hidden" value="<?php echo $brand["brand_pre_post_fix"]; ?>" name="agentcode" />
                        <input type="hidden" value="<?php echo $bkgcheckfortktorder; ?>" name="bkgcheckfortktorder" />
                        <div class="row m-b-10">
                            <div class="col-md-12">
                                <?php
                                if ($booking['flight'] && $booking['bkg_status'] == 'Pending' && $flt_tkt_btn) {
                                ?>
                                    <div class="form-check-inline">
                                        <input type="checkbox" name="flt_tkt_order" class="tktorder" id="flt_tkt_order" <?php echo ($booking['flight'] && !$booking['hotel'] && !$booking['cab']) ? 'checked' : ''; ?> value="1">
                                        <label for="flt_tkt_order">Flight <?php echo ($bkgcheckfortktorder == 1) ? ' (Direct Send)' : ''; ?></label>
                                    </div>
                                <?php
                                }
                                if ($booking['hotel'] && $booking['bkg_status'] == 'Pending' && $htl_tkt_btn) {
                                ?>
                                    <div class="form-check-inline">
                                        <input type="checkbox" name="htl_tkt_order" class="tktorder" id="htl_tkt_order" <?php echo (!$booking['flight'] && $booking['hotel'] && !$booking['cab']) ? 'checked' : ''; ?> value="1">
                                        <label for="htl_tkt_order">Hotel</label>
                                    </div>
                                <?php
                                }
                                if ($booking['cab'] && $booking['bkg_status'] == 'Pending' && $cab_tkt_btn) {
                                ?>
                                    <div class="form-check-inline">
                                        <input type="checkbox" name="cab_tkt_order" class="tktorder" id="cab_tkt_order" <?php echo (!$booking['flight'] && !$booking['hotel'] && $booking['cab']) ? 'checked' : ''; ?> value="1">
                                        <label for="cab_tkt_order">Cab</label>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        $style_f = 'style="display: none;"';
                        $style_h = 'style="display: none;"';
                        $style_c = 'style="display: none;"';
                        if ($booking['flight'] && !$booking['hotel'] && !$booking['cab'] && $flt_tkt_btn) {
                            $style_f = 'style=""';
                        }
                        if (!$booking['flight'] && $booking['hotel'] && !$booking['cab'] && $htl_tkt_btn) {
                            $style_h = 'style=""';
                        }
                        if (!$booking['flight'] && !$booking['hotel'] && $booking['cab'] && $cab_tkt_btn) {
                            $style_c = 'style=""';
                        }
                        ?>
                        <?php if ($booking['flight'] && $flt_tkt_btn) {
                        ?>
                            <div class="row m-b-10 flt_tkt_details" <?php echo $style_f; ?>>
                                <div class="col-md-3">
                                    <label class="control-label text-left m-b-0"><strong>Supplier</strong></label>
                                    <p class="form-control-static m-b-5"><?php echo $booking['sup_name'] ?></p>
                                    <input type="hidden" name="flt_ordr[supplier]" value="<?php echo $booking['sup_name'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label text-left m-b-0"><strong>Supplier Ref.</strong></label>
                                    <p class="form-control-static m-b-5"><?php echo $booking['bkg_supplier_reference'] ?></p>
                                    <input type="hidden" name="flt_ordr[sup_ref]" value="<?php echo $booking['bkg_supplier_reference'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label text-left m-b-0"><strong>GDS</strong></label>
                                    <p class="form-control-static m-b-5"><?php echo $booking['flt_gds'] ?></p>
                                    <input type="hidden" name="flt_ordr[flt_gds]" value="<?php echo $booking['flt_gds'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label text-left m-b-0"><strong>PNR</strong></label>
                                    <p class="form-control-static m-b-5"><?php echo $booking['flt_pnr'] ?></p>
                                    <input type="hidden" name="flt_ordr[flt_pnr]" value="<?php echo $booking['flt_pnr'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label text-left m-b-0"><strong>Cost</strong></label>
                                    <p class="form-control-static m-b-5">&pound; <?php
                                                                                    if ($booking['hotel']) {
                                                                                        $payable_sup -= $hotel['cost'];
                                                                                    }
                                                                                    if ($booking['cab']) {
                                                                                        $payable_sup -= $cab['cost'];
                                                                                    }
                                                                                    echo number_format($payable_sup, 2);
                                                                                    ?>
                                    </p>
                                    <input type="hidden" name="flt_ordr[cost]" value="<?php echo $payable_sup ?>">
                                </div>
                            </div>
                        <?php
                        }
                        if ($booking['hotel'] && $htl_tkt_btn) {
                        ?>
                            <div class="row m-b-10 htl_tkt_details" <?php echo $style_h; ?>>
                                <div class="col-md-3">
                                    <label class="control-label text-left m-b-0"><strong>Supplier</strong></label>
                                    <p class="form-control-static m-b-5"><?php echo $hotel['supplier'] ?></p>
                                    <input type="hidden" name="htl_ordr[supplier]" value="<?php echo $hotel['supplier'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label text-left m-b-0"><strong>Supplier Ref.</strong></label>
                                    <p class="form-control-static m-b-5"><?php echo $hotel['sup_ref'] ?></p>
                                    <input type="hidden" name="htl_ordr[sup_ref]" value="<?php echo $hotel['sup_ref'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label text-left m-b-0"><strong>Cost</strong></label>
                                    <p class="form-control-static m-b-5">&pound; <?php echo number_format($hotel['cost'], 2); ?>
                                    </p>
                                    <input type="hidden" name="htl_ordr[cost]" value="<?php echo $hotel['cost']; ?>">
                                </div>
                            </div>
                        <?php
                        }
                        if ($booking['cab'] && $cab_tkt_btn) {
                        ?>
                            <div class="row m-b-10 cab_tkt_details" <?php echo $style_c; ?>>
                                <div class="col-md-3">
                                    <label class="control-label text-left m-b-0"><strong>Supplier</strong></label>
                                    <p class="form-control-static m-b-5"><?php echo $cab['supplier'] ?></p>
                                    <input type="hidden" name="cab_ordr[supplier]" value="<?php echo $cab['supplier'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label text-left m-b-0"><strong>Supplier Ref.</strong></label>
                                    <p class="form-control-static m-b-5"><?php echo $cab['sup_ref'] ?></p>
                                    <input type="hidden" name="cab_ordr[sup_ref]" value="<?php echo $cab['sup_ref'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label text-left m-b-0"><strong>Cost</strong></label>
                                    <p class="form-control-static m-b-5">&pound; <?php echo number_format($cab['cost'], 2); ?>
                                    </p>
                                    <input type="hidden" name="cab_ordr[cost]" value="<?php echo $cab['cost']; ?>">
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="row m-b-0">
                            <div class="col-md-6">
                                <div class="form-group m-b-0">
                                    <label class="control-label font-weight-bold text-left m-b-0">Priority</label>
                                    <div class="controls">
                                        <select name="priority" id="priority" required class="form-control">
                                            <option value="Normal" selected="selected">Normal</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-b-0">
                                    <label class="control-label font-weight-bold text-left m-b-0">Issuance Note</label>
                                    <div class="controls">
                                        <textarea name="issuance_note" class="form-control" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm" id="tktreqsubmit" form="tk_request">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="sendeticket">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">Send E-Ticket</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formsendetkt" method="post" action="<?php echo base_url("booking/sendtkt") ?>" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="modal-body">
                        <input type="hidden" value="<?php echo $booking['bkg_no']; ?>" name="bkg_id" />
                        <input type="hidden" value="<?php echo $booking['bkg_brandname']; ?>" name="brand" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group m-b-5">
                                    <label class="form-label">From <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <input type="email" name="from_email" class="form-control" required data-parsley-trigger="focusin focusout" value="<?php echo agentbookingemail($booking['bkg_no']); ?>" readonly>
                                        <input type="hidden" value="<?php echo $booking['bkg_agent']; ?>" name="from_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-b-5">
                                    <label class="form-label">To <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <input type="email" name="to_email" class="form-control" required data-parsley-trigger="focusin focusout" value="<?php echo $booking['cst_email']; ?>">
                                        <input type="hidden" value="<?php echo $booking['cst_name']; ?>" name="to_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-b-5">
                                    <label class="form-label">Subject <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="email_subject" class="form-control" required data-parsley-trigger="focusin focusout" value="<?php echo $booking['cst_name']; ?>, E-Tickets for Invoice # <?php echo $booking['bkg_no']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-b-5">
                                    <label class="form-label">Attachments <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <input type="file" name="email_att[]" class="form-control" required data-parsley-trigger="focusin focusout" value="" placeholder="Upload E-Ticket" multiple="multiple">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-b-0">
                                    <label class="form-label">Message <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <textarea name="msg" type="text" rows="5" class="form-control" required><?php
                                                                                                                echo $etktmsg;
                                                                                                                ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="formsendetktbtn btn btn-success btn-sm">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>