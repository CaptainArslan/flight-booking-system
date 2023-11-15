<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('common/head', @$head); ?>
    <style>
        page {
            background: #fff !important;
            display: block;
            margin: 0 auto;
            /* margin-bottom: .5cm; */
            /* box-shadow: 0 0 .5cm rgba(0, 0, 0, .5) */
        }

        page[size=A4] {
            width: 21cm;
            height: auto;
            position: relative;
            background: #fff !important
        }

        page[size=A4][layout=landscape] {
            width: 29.7cm;
            height: 21cm;
            background: #fff !important
        }

        @media print {

            body,
            page {
                margin: 0;
                height: 100%;
                /* box-shadow: 0 */
            }

            .bg-gray {
                background-color: #eee
            }

            page {
                background: #fff !important;
                height: 100%;
                display: block;
                position: relative;
                margin: 0 auto;
                /* margin-bottom: .5cm; */
                /* box-shadow: 0 0 .5cm rgba(0, 0, 0, .5); */
                page-break-after: always !important
            }

            .footer {
                position: absolute;
                bottom: 0px;
                left: 0px;
            }

            page[size=A4] {
                width: 100%;
                height: 41cm;
                position: relative;
                background: #fff !important
            }
        }
    </style>
</head>

<body class="antialiased">
    <div class="wrapper">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    <div class="row">
                        <div class="col" id="printThis">    
                            <page>
                                <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                                    <tr>
                                        <td width="95%" valign="bottom" height="100px" align="right">
                                            <img src="<?php echo base_url(); ?>assets/images/brand_logo/<?php echo $brand['brand_logo'] ?>" width="160px">
                                        </td>
                                        <td valign="middle" width="5%">&nbsp;</td>
                                    </tr>
                                </table>
                                <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                                    <tr>
                                        <td height="20px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td valign="middle" width="5%">&nbsp;</td>
                                                    <td valign="top" width="45%">
                                                        <table cellspacing="0" cellpadding="0" width="100%">
                                                            <tr>
                                                                <td>
                                                                    <h1 style="font-size: 50px">INVOICE</h1>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td valign="middle" width="45%" align="right">
                                                        <table width="70%" cellspacing="0" cellpadding="0">
                                                            <?php if ($brand['brand_phone'] != 0) { ?>
                                                                <tr>
                                                                    <td width="90%" align="right" style="font-size: 13px;"><?php echo $brand['brand_phone'] ?></td>
                                                                    <td width="10%" align="center"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                                                            <path d="M15 7a2 2 0 0 1 2 2" />
                                                                            <path d="M15 3a6 6 0 0 1 6 6" />
                                                                        </svg></td>
                                                                </tr>
                                                            <?php }
                                                            if ($brand['brand_fax'] != 0) { ?>
                                                                <tr>
                                                                    <td width="90%" align="right" style="font-size: 13px;"><?php echo $brand['brand_fax'] ?></td>
                                                                    <td width="10%" align="center"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                                            <line x1="9" y1="7" x2="10" y2="7" />
                                                                            <line x1="9" y1="13" x2="15" y2="13" />
                                                                            <line x1="13" y1="17" x2="15" y2="17" />
                                                                        </svg></td>
                                                                </tr>
                                                            <?php }
                                                            if ($brand['brand_email'] != '') { ?>
                                                                <tr>
                                                                    <td width="90%" align="right" style="font-size: 13px;"><?php echo $brand['brand_email'] ?></td>
                                                                    <td width="10%" align="center"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <rect x="3" y="5" width="18" height="14" rx="2" />
                                                                            <polyline points="3 7 12 13 21 7" />
                                                                        </svg></td>
                                                                </tr>
                                                            <?php }
                                                            if ($brand['brand_website'] != '') { ?>
                                                                <tr>
                                                                    <td width="90%" align="right" style="font-size: 13px;"><?php echo $brand['brand_website'] ?></td>
                                                                    <td width="10%" align="center"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <circle cx="12" cy="12" r="9" />
                                                                            <line x1="3.6" y1="9" x2="20.4" y2="9" />
                                                                            <line x1="3.6" y1="15" x2="20.4" y2="15" />
                                                                            <path d="M11.5 3a17 17 0 0 0 0 18" />
                                                                            <path d="M12.5 3a17 17 0 0 1 0 18" />
                                                                        </svg></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </td>
                                                    <td valign="middle" width="5%">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="50px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td valign="middle" width="5%">&nbsp;</td>
                                                    <td valign="top" width="50%">
                                                        <table valign="top" cellspacing="0" cellpadding="0" width="100%">
                                                            <tr>
                                                                <td>
                                                                    <h5>
                                                                        To,
                                                                    </h5>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h4><?php echo $booking['cst_name']; ?></h4>
                                                                    <p class="mb-0">
                                                                        <?php echo $booking['cst_address'] . ',<br>' . $booking['cst_city'] . ', ' . $booking['cst_postcode']; ?>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p class="mb-0"><?php echo $booking['cst_mobile'] . '<br>' . $booking['cst_email']; ?></p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td valign="middle" width="40%">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="55%" align="left" style="border-right: thin solid #e5e5e5;">
                                                                    <span class="font-weight-bold">Invoice #</span>
                                                                </td>
                                                                <td width="45%" class="text-right">&nbsp;&nbsp; <?php echo $booking['bkg_no']; ?><?php echo ($brand['brand_pre_post_fix'] != '') ? "-" . $brand['brand_pre_post_fix'] : ""; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <hr class="mb-1 mt-1">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" style="border-right: thin solid #e5e5e5;">
                                                                    <span class="font-weight-bold">Invoice Date</span>
                                                                </td>
                                                                <td class="text-right">&nbsp;&nbsp;<?php echo date("d-M-Y", strtotime($booking['bkg_date'])); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <hr class="mb-1 mt-1">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" style="border-right: thin solid #e5e5e5;">
                                                                    <span class="font-weight-bold">Airline Confirmation #</span>
                                                                </td>
                                                                <td class="text-right">&nbsp;&nbsp;<?php echo $booking['flt_pnr']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <hr class="mb-1 mt-1">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" style="border-right: thin solid #e5e5e5;">
                                                                    <span class="font-weight-bold">Agent Name</span>
                                                                </td>
                                                                <td class="text-right">&nbsp;&nbsp;<?php echo $booking['bkg_agent']; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td valign="middle" width="10%">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                    if ($booking['flight']) {
                                    ?>
                                        <tr>
                                            <td align="center">
                                                <table width="90%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <hr class="mt-2 mb-2">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="font-weight-bold">Flight Details</h5>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <table cellpadding="0" cellspacing="0" width="90%">
                                                    <tr>
                                                        <td width="25%">
                                                            <span class="font-weight-bold">Departure Airport:</span>
                                                        </td>
                                                        <td width="25%" align="left">
                                                            <?php echo $booking['flt_departureairport']; ?>
                                                        </td>
                                                        <td width="25%">
                                                            <span class="font-weight-bold">Destination Airport:</span>
                                                        </td>
                                                        <td width="25%" align="left">
                                                            <?php echo $booking['flt_destinationairport']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">Departure Date:</span>
                                                        </td>
                                                        <td align="left">
                                                            <?php echo date("d-M-Y", strtotime($booking['flt_departuredate'])); ?>
                                                        </td>
                                                        <?php if ($booking['flt_flighttype'] == 'Return') { ?>
                                                            <td>
                                                                <span class="font-weight-bold">Return Date:</span>
                                                            </td>
                                                            <td align="left">
                                                                <?php echo date("d-M-Y", strtotime($booking['flt_returningdate'])); ?>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td colspan="2"></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">Cabin Class:</span>
                                                        </td>
                                                        <td align="left">
                                                            <?php echo $booking['flt_class']; ?>
                                                        </td>
                                                        <td>
                                                            <span class="font-weight-bold">Flight Type:</span>
                                                        </td>
                                                        <td align="left">
                                                            <?php echo $booking['flt_flighttype']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">Air Line:</span>
                                                        </td>
                                                        <td align="left">
                                                            <?php echo $booking['flt_airline']; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <table width="90%" cellpadding="0" cellspacing="0" style="table-layout: fixed;">
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">Details</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 10px;">
                                                            <div style="width: 100%;">
                                                                <div style="width: 700px;display: inline-block;"><?php echo nl2br($booking['flt_ticketdetail']); ?></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    if ($booking['hotel']) {
                                    ?>
                                        <tr>
                                            <td align="center">
                                                <table width="90%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <hr class="m-t-10 m-b-10">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="font-weight-bold">Hotel Details</h5>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <table cellpadding="0" cellspacing="0" width="90%">
                                                    <tr>
                                                        <td width="25%">
                                                            <span class="font-weight-bold">Hotel:</span>
                                                        </td>
                                                        <td width="25%" align="left">
                                                            <?php echo $hotel['name']; ?>
                                                        </td>
                                                        <td width="25%">
                                                            <span class="font-weight-bold">Rooms:</span>
                                                        </td>
                                                        <td width="25%" align="left">
                                                            <?php echo $hotel['rooms']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">Checkin Date:</span>
                                                        </td>
                                                        <td align="left">
                                                            <?php echo date("d-M-Y", strtotime($hotel['checkin'])); ?>
                                                        </td>
                                                        <?php if ($hotel['checkout'] != '0000-00-00') { ?>
                                                            <td>
                                                                <span class="font-weight-bold">Checkout Date:</span>
                                                            </td>
                                                            <td align="left">
                                                                <?php echo date("d-M-Y", strtotime($hotel['checkout'])); ?>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td colspan="2"></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">Hotel Location:</span>
                                                        </td>
                                                        <td colspan="3" align="left">
                                                            <?php echo $hotel['location']; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <table width="90%" cellpadding="0" cellspacing="0" style="table-layout: fixed;">
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">Details</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 10px;">
                                                            <div style="width: 100%;">
                                                                <div style="width: 700px;display: inline-block;"><?php echo nl2br($hotel['details']); ?></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if ($booking['cab']) {
                                    ?>
                                        <tr>
                                            <td align="center">
                                                <table width="90%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <hr class="m-t-10 m-b-10">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="font-weight-bold">Cab Details</h5>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <table cellpadding="0" cellspacing="0" width="90%">
                                                    <tr>
                                                        <td width="25%">
                                                            <span class="font-weight-bold">Cab:</span>
                                                        </td>
                                                        <td width="25%" align="left">
                                                            <?php echo $cab['name']; ?>
                                                        </td>
                                                        <td width="25%">
                                                            <span class="font-weight-bold">Cab Type:</span>
                                                        </td>
                                                        <td width="25%" align="left">
                                                            <?php echo $cab['type']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">Cab Trip:</span>
                                                        </td>
                                                        <td colspan="3" align="left">
                                                            <?php echo $cab['trip']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">From Date:</span>
                                                        </td>
                                                        <td align="left">
                                                            <?php echo date("d-M-Y", strtotime($cab['from_date'])); ?>
                                                        </td>
                                                        <?php if ($cab['trip'] != 'Oneway') { ?>
                                                            <td>
                                                                <span class="font-weight-bold">To Date:</span>
                                                            </td>
                                                            <td align="left">
                                                                <?php echo date("d-M-Y", strtotime($cab['to_date'])); ?>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td colspan="2"></td>
                                                        <?php } ?>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <table width="90%" cellpadding="0" cellspacing="0" style="table-layout: fixed;">
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">Details</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 10px;">
                                                            <div style="width: 100%;">
                                                                <div style="width: 700px;display: inline-block;"><?php echo nl2br($cab['details']); ?></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td align="center">
                                            <table width="90%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <h5 class="font-weight-bold">Passenger Details</h5>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <div class="table-responsive m-t-10" style="clear: both;">
                                                <table class="table full-color-table full-info-table  m-t-0" style="max-width: 90%;width: 90%;">
                                                    <thead>
                                                        <tr>
                                                            <th width="07%" class="p-1 text-center text-middle">Sr #</th>
                                                            <th width="78%" class="p-1 text-center text-middle">Passenger Name</th>
                                                            <th width="15%" class="p-1 text-center text-middle">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $amountRec = 0;
                                                        $totaltrans_row = count($cust_trans);
                                                        $sr = 1;
                                                        $bFee = 0;
                                                        $paxTotals = 0;
                                                        $totalpax = 0;
                                                        $totalpax = count($pax);
                                                        if ($totalpax > 0) {
                                                            foreach ($pax as $key => $paxdetails) {
                                                                $bFee += $paxdetails['p_bookingfee'];
                                                                $total = $paxdetails['p_basic'] + $paxdetails['p_tax'] + $paxdetails['p_others'] + $paxdetails['p_hotel'] + $paxdetails['p_cab'];
                                                                $paxTotals += $total;
                                                        ?>
                                                                <tr>
                                                                    <td class="p-1 text-center"><?php echo $sr; ?></td>
                                                                    <td class="p-1 text-center">
                                                                        <?php echo $paxdetails['p_title'] . ' ' . $paxdetails['p_firstname'] . ' ' . $paxdetails['p_middlename'] . ' ' . $paxdetails['p_lastname']; ?>
                                                                    </td>
                                                                    <td class="p-1 text-center">&pound; <?php echo number_format($total, 2); ?></td>
                                                                </tr>
                                                            <?php
                                                                $sr++;
                                                            }
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td colspan="3" class="p-1 text-center">No Passengers</td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3">
                                                                <table cellspacing="0" cellpadding="0" width="100%">
                                                                    <tr>
                                                                        <td width="40%" class="p-1 text-left font-weight-bold">Total Price :</td>
                                                                        <td width="45%" class="p-1 text-center font-weight-bold">&nbsp;</td>
                                                                        <td width="15%" class="p-1 text-center">£ <?php echo number_format($paxTotals, 2) ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="border-top-none p-1 text-left font-weight-bold">Total Booking Fee :</td>
                                                                        <td class="p-1 text-center border-top-none">&nbsp;</td>
                                                                        <td class="border-top-none p-1 text-center">£ <?php echo number_format($bFee, 2) ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="border-top-none p-1 text-left font-weight-bold">Grand Total :</td>
                                                                        <td class="p-1 text-center border-top-none">&nbsp;</td>
                                                                        <td class="p-1 text-center" style="border-color: #000 !important;">£ <?php echo number_format($bFee + $paxTotals, 2) ?></td>
                                                                    </tr>
                                                                    <?php if ($totaltrans_row > 0) { ?>
                                                                        <tr style="border: none !important;">
                                                                            <td class="border-top-none p-1 text-left font-weight-bold">Amount Paid :</td>
                                                                            <td class="border-top-none p-1 text-center">&nbsp;</td>
                                                                            <td class="border-top-none p-1 text-center">&nbsp;</td>
                                                                        </tr>
                                                                        <tr style="border: none !important;">
                                                                            <td colspan="3" style="padding: 0px !important;">
                                                                                <table cellspacing="0" cellpadding="0" width="100%" class="m-t-0 mb-0" style="font-size: 11px;font-weight:500;">
                                                                                    <thead>
                                                                                        <tr style="border: none !important;">
                                                                                            <td width="5%" class="p-1 text-center text-middle">
                                                                                                <strong>#</strong>
                                                                                            </td>
                                                                                            <td width="17%" class="p-1 text-center text-middle">
                                                                                                <strong>Date</strong>
                                                                                            </td>
                                                                                            <td width="28%" class="p-1 text-center text-middle">
                                                                                                <strong>Paymend Method</strong>
                                                                                            </td>
                                                                                            <td width="20%" class="p-1 text-center text-middle">
                                                                                                <strong>Auth. Code</strong>
                                                                                            </td>
                                                                                            <td width="15%" class="p-1 text-center text-middle">
                                                                                                <strong>Amount</strong>
                                                                                            </td>
                                                                                            <td width="15%" class="p-1 text-center text-middle">
                                                                                                <strong></strong>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                        $trsr = 1;
                                                                                        foreach ($cust_trans as $key => $cust_tran) {
                                                                                            $amt = 0;
                                                                                            $head = $cust_tran['trans_by_to'];
                                                                                            $authcode = $cust_tran['t_card'];
                                                                                            if ($cust_tran['trans_type'] == "Dr") {
                                                                                                $amt -= $cust_tran['trans_amount'];
                                                                                            } else {
                                                                                                $amt += $cust_tran['trans_amount'];
                                                                                            }
                                                                                            $amountRec += $amt;
                                                                                        ?>
                                                                                            <tr style="border: none !important;">
                                                                                                <td class="p-1 text-center text-middle">
                                                                                                    <?php echo $trsr; ?>
                                                                                                </td>
                                                                                                <td class="p-1 text-center text-middle">
                                                                                                    <?php
                                                                                                    echo date('d-M-y', strtotime($cust_tran['trans_date']));
                                                                                                    ?>
                                                                                                </td>
                                                                                                <td class="p-1 text-center text-middle">
                                                                                                    <?php echo $head; ?>
                                                                                                </td>
                                                                                                <td class="p-1 text-center text-middle">
                                                                                                    <?php
                                                                                                    echo ($authcode != '') ? $authcode : '-';
                                                                                                    ?>
                                                                                                </td>
                                                                                                <td class="p-1 text-center text-middle">
                                                                                                    <?php
                                                                                                    echo '&pound; ' . number_format($amt, 2);
                                                                                                    ?>
                                                                                                </td>
                                                                                                <?php if ($trsr == $totaltrans_row) { ?>
                                                                                                    <td class="p-1 text-center text-middle" style="font-size: 14px;font-weight:300;">
                                                                                                        <?php echo '&pound; ' . number_format($amountRec, 2); ?>
                                                                                                    </td>
                                                                                                <?php } else { ?>
                                                                                                    <td class="p-1 text-center text-middle">&nbsp;</td>
                                                                                                <?php } ?>
                                                                                            </tr>
                                                                                        <?php
                                                                                            $trsr++;
                                                                                        }
                                                                                        ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } else { ?>
                                                                        <tr>
                                                                            <td class="border-top-none p-1 text-left font-weight-bold">Amount Paid :</td>
                                                                            <td class="border-top-none p-1 text-center">&nbsp;</td>
                                                                            <td class="border-top-none p-1 text-center">&pound; <?php echo number_format($amountRec, 2); ?></td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td class="border-top-none p-1 text-left font-weight-bold">Due Balance :</td>
                                                                        <td class="p-1 text-left border-top-none">
                                                                            <span class="font-weight-bold">Due Date: </span><?php echo date("d-M-y,D h:i a", strtotime($booking['recpt_due_date'])); ?>
                                                                        </td>
                                                                        <td class="p-1 text-center" style="border-color: #000 !important;">£ <?php echo number_format(($bFee + $paxTotals) - $amountRec, 2) ?></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="80px">&nbsp;</td>
                                    </tr>
                                </table>
                                <table class="footer" width="100%" cellpadding="0" cellspacing="0" bgcolor="#f1f1f1">
                                    <tr>
                                        <td align="center" class="p-1" valign="middle">
                                            <p class="mb-0" style="font-size: 11px;color: #000;">
                                                Address: <?php echo $brand['brand_address'] ?><br>
                                                Registered in United Kingdom with Registration No. 12748896
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </page>
                            <page>
                                <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                                    <tr>
                                        <td width="95%" valign="bottom" height="100px" align="right">
                                            <img src="<?php echo base_url(); ?>assets/images/brand_logo/<?php echo $brand['brand_logo'] ?>" width="160px">
                                        </td>
                                        <td valign="middle" width="5%">&nbsp;</td>
                                    </tr>
                                </table>
                                <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                                    <tr>
                                        <td height="20px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td valign="middle" width="5%">&nbsp;</td>
                                                    <td valign="top" width="45%">
                                                        <table cellspacing="0" cellpadding="0" width="100%">
                                                            <tr>
                                                                <td>
                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td valign="middle" width="45%" align="right">
                                                        <table width="70%" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="90%" align="right" style="font-size: 13px;"><?php echo $brand['brand_phone'] ?></td>
                                                                <td width="10%" align="center"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                                                        <path d="M15 7a2 2 0 0 1 2 2" />
                                                                        <path d="M15 3a6 6 0 0 1 6 6" />
                                                                    </svg></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="90%" align="right" style="font-size: 13px;"><?php echo $brand['brand_fax'] ?></td>
                                                                <td width="10%" align="center"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                                        <line x1="9" y1="7" x2="10" y2="7" />
                                                                        <line x1="9" y1="13" x2="15" y2="13" />
                                                                        <line x1="13" y1="17" x2="15" y2="17" />
                                                                    </svg></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="90%" align="right" style="font-size: 13px;"><?php echo $brand['brand_email'] ?></td>
                                                                <td width="10%" align="center"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <rect x="3" y="5" width="18" height="14" rx="2" />
                                                                        <polyline points="3 7 12 13 21 7" />
                                                                    </svg></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="90%" align="right" style="font-size: 13px;"><?php echo $brand['brand_website'] ?></td>
                                                                <td width="10%" align="center"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <circle cx="12" cy="12" r="9" />
                                                                        <line x1="3.6" y1="9" x2="20.4" y2="9" />
                                                                        <line x1="3.6" y1="15" x2="20.4" y2="15" />
                                                                        <path d="M11.5 3a17 17 0 0 0 0 18" />
                                                                        <path d="M12.5 3a17 17 0 0 1 0 18" />
                                                                    </svg></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td valign="middle" width="5%">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="4 0px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td width="5%">&nbsp;</td>
                                                    <td width="90%">
                                                        <table cellspacing="0" cellpadding="0" width="100%">
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" style="font-size: 20px; font-weight: bold;">Booking Terms &amp; Conditions</td>
                                                            </tr>
                                                            <tr>
                                                                <td height="10"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size: 13px; text-align:justify;">Please read these carefully as the person making this booking (either for him selves or for any other passenger) accepts all the below terms and conditions of <?php echo $booking['bkg_brandname'] ?>.</td>
                                                            </tr>
                                                            <tr>
                                                                <td height="10" style="font-size: 12px"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p style="font-size: 13px; font-weight: bold;text-align:center;">DEPOSITS FOR HOLIDAY ARE NEITHER REFUNDABLE NOR CHANGEABLE (Terms & Conditions May Apply).</p>
                                                                    <p style="font-size: 12px;text-align:justify;">Unless Specified, All the deposits paid for flights and accommodation purchased/issued is non-refundable. In case of cancellation or no show (Failure to arrive or check-in on time) and non-changeable before or after departure (date change is not permitted). Once holiday is reserved, bookings/tickets are non-transferable to any other person means that name changes are not permitted.</p>
                                                                    <p style="font-size: 12px;text-align:justify;">If you are reserving the flight or accommodation or both by making the advance partial payment (Initial deposit) then please note that fare/taxes may increase at any time without the prior notice. It means the price is not guaranteed unless the ticket is issued because the airline/consolidator has the right to increase the price due to any reason. In that case, we will not be liable and the passenger has to pay the fare/tax difference. We always recommend you to pay ASAP and get issue your flight tickets or holiday to avoid this situation. Furthermore, if you will cancel your reservation due to any reason, then the paid deposit(s) will be non-refundable.</p>
                                                                    <?php if ($booking['flight']) { ?>
                                                                        <strong>CHECKING ALL FLIGHT DETIALS & PASSENGER NAME(S)</strong>
                                                                        <p style="font-size: 12px;text-align:justify;">It is your responsibility to check all the details are correct i.e. Passenger names (are same as appearing on passport/travel docs), Travelling dates, Transit Time, Origin & Destination, Stop Over, Baggage Allowance, and other flight information. Once the ticket is issued then no changes can be made, unless specified.</p>
                                                                        <strong>PASSPORT, VISA & IMMIGRATION REQUIREMENTS</strong>
                                                                        <p style="font-size: 12px;text-align:justify;">You are responsible for checking all these items like Passport, Visa (including Transit Visa), and other immigration requirements. You must consult with the relevant Embassy/Consulate, well before the departure time for up-to-date information as requirements may change from time to time. We regret we cannot accept the liability of any transit visa and if you are refused to board the flight or could not clear the immigration or any kind of failure in providing the information required like passport, visa or other documents required by any airline, authority or country. We also recommend you that to check this link <a href="https://www.gov.uk/foreign-travel-advice">https://www.gov.uk/foreign-travel-advice</a> for travel advice.</p>
                                                                        <strong>RECONFIRMING RETURN/ONWARD FLIGHTS</strong>
                                                                        <p style="font-size: 12px;text-align:justify;">It is the traveler's responsibility to RECONFIRM your flights at least 72 hours before your departure time either with your travel agent or the relevant Airline directly. The company will not be liable for any additional costs due to your failure to reconfirm your flights.</p>
                                                                        <strong>SPECIAL REQUESTS AND MEDICAL PROBLEMS</strong>
                                                                        <p style="font-size: 12px;text-align:justify;">If you have any special requests like meal preference, Seat Allocation and wheelchair request, etc, please advise us at the time of issuance of the ticket. We will try our best to fulfill these bypassing this request to the relevant airlines, but we cannot guarantee and failure to meet any special request will not hold us liable for any claim.</p>
                                                                    <?php
                                                                    }
                                                                    if ($booking['hotel']) {
                                                                    ?>
                                                                        <strong>Accommodations:</strong>
                                                                        <p style="font-size: 12px;text-align:justify;">Please note that, unless expressly indicated otherwise, all prices are for room reservations only, for the specified stay dates and number of people. Without prejudice to what is set out below, before you confirm a reservation, The total price is payable, including taxes and service fees, and what is included.<br>
                                                                            In addition to the reservation prices, some Accommodations will charge mandatory service fees, surcharges, and local taxes (for example, resort or amenity fees, transportation transfers, and city tourist tax). These service fees and local taxes may be collected directly from you by the Accommodation, in addition to the price you pay for your reservation.<br>
                                                                            Standard room reservations are for single or double occupancy. Extra guests or beds will usually incur extra charges. An Accommodation may refuse to allow additional guests to stay in a room – you must specify the correct number of persons, including children who will occupy each room you reserve.<br>
                                                                            You will incur additional charges at the Accommodation for all services and products you use that are not included in the reservation price as expressly described by the booking conditions. Charges for amenities you use and products you consume during your stay (for example, parking, internet access, food and drink) are not included in the reservation price unless specified.<br>
                                                                            During special events and periods, some Accommodations require each guest to purchase additional services (for example, a dinner on New Year’s Eve)<br>
                                                                            Many Accommodations have specific policies around children, accompanying travelers and/or traveling with pets. You are strongly advised to check with Customer Service, the Accommodation itself or to verify the Accommodation policies.<br>
                                                                            Special Needs: If you have special needs (e.g., wheelchair accessible room) you must contact Customer Service or the Accommodation and verify that special needs can be met. Please note that all special requests are subject to availability and are not guaranteed. Depending on the policy of the applicable Accommodation.</p>
                                                                    <?php
                                                                    }
                                                                    if ($booking['cab']) {
                                                                    ?>
                                                                        <strong>TRANSPORTATION SERVICES</strong>
                                                                        <p style="font-size: 12px;text-align:justify;">We offer a range of services to which the Transport Operators have given their accord. These are private Transfer Services and shared or shuttle Transfer Services.<br>
                                                                            The route to or from the destination chosen cannot be guaranteed, In the event that you are unable to locate the driver of your private transfer or the representative of the shuttle Transport Operator, it is your responsibility to contact us on the 24/7 telephone numbers printed on your Transfer Voucher.<br>
                                                                            If you fail to call these numbers and make alternative travel arrangements, we will be unable to provide the service, the Transport Operator will be relieved of their obligations and a refund will not be due.<br>
                                                                            You are responsible for checking the agreed pickup time and for ensuring that you arrive at the airport, station or port with enough time to check in or make any other preparations for your journey.<br>
                                                                            The Transport Operator will pick you up and set you down as close as possible to the given addresses. In the event that access via a conventional route is closed due to weather conditions, road accidents etc., the Transport Operator will, at your express request, use a longer route to reach the agreed destination, but in such instances you may be liable for any additional costs
                                                                        </p>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <strong>Covid-19</strong>
                                                                    <p style="font-size: 12px;text-align:justify;">Due to Covid-19, Additional entry requirements have been introduced which varies from country to country and may be subject to change with short notice. You are responsible for checking and conforming with the entry and exit requirements at their origins and destinations. Requirements may include proof of negative PCR Covid-19 tests, temperature checks or completion of forms, etc.<br>
                                                                        If the flight is affected due to Covid-19 then airline policies will be applied. To accommodate the traveler, it is quite possible that the airline only offers the future date change or credit voucher option instead of a refund. In that case, you must have to follow the airline rules and cannot demand a refund. If a full refund is permitted, A admin fee (Per person) will be deducted as the service charges and a refund can take up to 3 months. If the flight is operated by the airline and you decide not to board the flight, then you will be ineligible for a refund. In this case (if your ticket is refundable) then airline fare rules (cancellation fee) will be applied for processing the refunds.</p>
                                                                    <strong>VERY IMPORTANT:</strong>
                                                                    <p style="font-size: 12px;text-align:justify;"><?php echo $brand['brand_name']; ?> does not accept responsibility for any kind of loss if the airline fails to operate due to any unforeseen circumstances like weather, war, natural disaster, pandemic, riots, strikes, etc. Passengers will be solely responsible for that so it is highly recommended that separate travel and health insurance must be arranged to protect you.</p>
                                                                    <strong style="font-size: 13px;">We advise you to read our complete terms and conditions mentioned at <a href="<?php echo $brand['brand_tc_url']; ?>" target="_blank"><?php echo $brand['brand_tc_url']; ?></a> on our website.</strong>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="5%">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20px">&nbsp;</td>
                                    </tr>
                                </table>
                                <table class="footer" width="100%" cellpadding="0" cellspacing="0" bgcolor="#f1f1f1">
                                    <tr>
                                        <td align="center" class="p-1" valign="middle">
                                            <p class="mb-0" style="font-size: 11px;color: #000;">
                                                Address: <?php echo $brand['brand_address'] ?><br>
                                                Registered in United Kingdom with Registration No. 12748896
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </page>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('common/scripts', @$scripts); ?>
    <script>
        $(document).on('click', '#print', function() {
            var printContents = document.getElementById('printThis').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        });
        $(document).on('click', '.invoicesend', function() {
            var thishtml = $(this).html();
            var thismain = $(this);
            thismain.attr("disabled", "disabled");
            thismain.html("Processing...");
            Swal.fire({
                html: '<div class="text-center text-danger m-t-30 m-b-30">' +
                    '<h1 style="font-size:40px;">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>' +
                    '</h1>' +
                    '</div>' +
                    '<div class="text-center">' +
                    '<h3 class="font-weight-bold">Are You Sure?</h3>' +
                    '</div>' +
                    'That you want to <b class="text-danger">Send Invoice</b>',
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
                    window.location.href = "<?php echo base_url('invoice/sendinv/' . $booking['bkg_no']); ?>";
                }
            });
            thismain.removeAttr("disabled");
            thismain.html(thishtml);
        });
    </script>
</body>

</html>