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
                            <div class="col">
                                <div class="page-pretitle"><?php echo($this->user_brand == 'All')?'All Brands':$this->user_brand; ?></div>
                                <h2 class="page-title"><?php echo $head['page_title']?></h2>
                            </div>
                            <div class="col-auto ms-auto">
                                <?php
                                    if((checkAccess($user_role,'admin_view_pending_booking')) && (checkAccess($user_role,'all_agents_pending_booking'))){
                                ?>
                                <form method="post" action="<?php echo base_url("booking/pending"); ?>">
                                    <div class="form-group row mb-0">
                                        <label class="p-0 col-auto col-form-label font-weight-600 text-right">Brand</label>
                                        <div class="col-auto">
                                            <select name="brand" class="form-control form-control-sm" onchange="this.form.submit()">
                                                <option value="All"> All</option>
                                                <?php
                                                    foreach ($booking_brands as $key => $booking_brand) {
                                                ?>
                                                <option value="<?php echo $booking_brand['bkg_brandname']; ?>" <?php echo(isset($_REQUEST['brand']) && $_REQUEST['brand'] == $booking_brand['bkg_brandname'])?'selected':''; ?>><?php echo $booking_brand['bkg_brandname']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <a href="<?php echo base_url('booking/add') ; ?>" class="btn btn-sm btn-success">Add Booking</a>
                                        </div>
                                    </div>
                                </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body mt-0">
                    <div class="container-xl p-0">
                        <div class="table-responsive">
                            <table id="pendingbookings" class="table table-vcenter mb-0 hover-table" width="100%" style="font-size: 12px;width: 100%;font-weight: 400;">
                                <thead>
                                    <?php
                                        if((checkAccess($user_role,'admin_view_pending_booking')) && (checkAccess($user_role,'all_agents_pending_booking'))){
                                    ?>
                                    <tr>
                                        <th class="text-center align-middle p-2" rowspan="2" width="04%">#</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="04%">Alert</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="08%">Booking<br>Date</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="08%">Travel<br>Date</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="07%">Booking<br>Ref#</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="10%">Sup. Ref.</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="21%">Customer Name</th>
                                        <th class="text-center align-middle p-2" colspan="4" >Amount Received</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="06%">Amount<br>Due</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="06%">Brand</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="06%">Agent</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center align-middle p-2" width="5%"><small>Bank</small></th>
                                        <th class="text-center align-middle p-2" width="5%"><small>Card</small></th>
                                        <th class="text-center align-middle p-2" width="5%"><small>Cash</small></th>
                                        <th class="text-center align-middle p-2" width="5%"><small>Other</small></th>
                                    </tr>
                                    <?php }elseif((!checkAccess($user_role,'admin_view_pending_booking')) && (checkAccess($user_role,'all_agents_pending_booking'))){ ?>
                                    <tr>
                                        <th class="text-center align-middle p-2" rowspan="2" width="04%">#</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="04%">Alert</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="08%">Booking<br>Date</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="08%">Travel<br>Date</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="07%">Ref. No.</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="09%">Sup. Ref.</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="21%">Customer Name</th>
                                        <th class="text-center align-middle p-2" colspan="4" >Amount Received</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="07%">Amount<br>Due</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="07%">Agent</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center align-middle p-2" width="6%"><small>Bank</small></th>
                                        <th class="text-center align-middle p-2" width="6%"><small>Card</small></th>
                                        <th class="text-center align-middle p-2" width="6%"><small>Cash</small></th>
                                        <th class="text-center align-middle p-2" width="6%"><small>Other</small></th>
                                    </tr>
                                    <?php }else{ ?>
                                    <tr>
                                        <th class="text-center align-middle p-2" rowspan="2" width="05%">#</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="05%">Alert</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="07%">Booking<br>Date</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="07%">Travel<br>Date</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="08%">Ref. No.</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="10%">Sup. Ref.</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="22%">Customer Name</th>
                                        <th class="text-center align-middle p-2" colspan="4" >Amount Received</th>
                                        <th class="text-center align-middle p-2" rowspan="2" width="08%">Amount<br>Due</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center align-middle p-2" width="6%"><small>Bank</small></th>
                                        <th class="text-center align-middle p-2" width="6%"><small>Card</small></th>
                                        <th class="text-center align-middle p-2" width="6%"><small>Cash</small></th>
                                        <th class="text-center align-middle p-2" width="6%"><small>Other</small></th>
                                    </tr>
                                    <?php } ?>
                                </thead>
                                <tbody>
                                    <?php
                                        $sr = 1;
                                        $total_bank = 0;
                                        $total_card = 0;
                                        $total_cash = 0;
                                        $total_others = 0;
                                        $total_due = 0;

                                        $bank = 0;
                                        $card = 0;
                                        $cash = 0;
                                        $others = 0;
                                        $due = 0;
                                        foreach ($pending_bookings as $key => $booking) {
                                            date_default_timezone_set('Europe/London');
                                            $datetime = date('Y-m-d h:i:s');
                                            $fareduedate = $booking['flt_fare_expiry'];
                                            $pnrduedate = $booking['flt_pnr_expiry'];
                                            $datetime = strtotime($datetime);
                                            $fareduedate = strtotime($fareduedate);
                                            $pnrduedate = strtotime($pnrduedate);
                                            $amtRcv = $this->booking_model->GetAmountRcv($booking['bkg_no']);
                                            $bank = $amtRcv['bank'];
                                            $card = $amtRcv['card'];
                                            $cash = $amtRcv['cash'];
                                            $others = $amtRcv['others'];
                                            $due = $amtRcv['due'];
                                            $total_rcv = $bank + $card + $cash + $others;
                                    ?>
                                    <tr bgcolor="#<?php if($booking['flt_departuredate'] < date('Y-m-d') && $total_rcv != 0 ){echo 'ffafaf' ;}elseif($booking['flt_departuredate'] < date('Y-m-d') && $total_rcv == 0 ){ echo 'dddddd' ; }else{ echo 'ffffff';} ?>">
                                        <td class="text-center align-middle"><?php echo $sr; ?></td>
                                        <td class="text-center align-middle">
                                            <?php if((round(($fareduedate - $datetime) / 3600,2) < 48 || round(($pnrduedate - $datetime) / 3600,2) < 48) || ($due == 0)){ ?>
                                            <span class="badge bg-danger p-0">
                                                <small>
                                                <?php if(round(($fareduedate - $datetime) / 3600,2) < 48 || round(($pnrduedate - $datetime) / 3600,2) < 48){ ?>
                                                <!-- Download SVG icon from http://tabler-icons.io/i/bell-ringing -->
                                                <svg data-bs-toggle="tooltip" data-bs-placement="top" title="Expiring Fares &amp; PNRs" xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /><path d="M21 6.727a11.05 11.05 0 0 0 -2.794 -3.727" /><path d="M3 6.727a11.05 11.05 0 0 1 2.792 -3.727" /></svg>
                                                <?php } ?>
                                                <?php if($due == 0){ ?>
                                                <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                                                <svg data-bs-toggle="tooltip" data-bs-placement="top" title="Full Payment Received" xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12.01" y2="8" /><polyline points="11 12 12 12 12 16 13 16" /></svg>
                                                <?php } ?>
                                                </small>
                                            </span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center align-middle"><?php echo date("d-M-y",strtotime($booking['bkg_date'])); ?></td>
                                        <td class="text-center align-middle"><?php echo date("d-M-y",strtotime($booking['flt_departuredate'])); ?></td>
                                        <td class="text-center align-middle">
                                            <a target="_blank" class="text-blue font-weight-600" href="<?php echo base_url("booking/pending/").hashing($booking['bkg_no']); ?>"><strong><?php echo $booking['bkg_no']."-".$booking['brand_pre_post_fix']; ?></strong></a>
                                        </td>
                                        <td class="text-center align-middle" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $booking['bkg_supplier_reference'] ;?>">
                                            <?php 
                                                //custom_echo($booking['bkg_supplier_reference'],11); 
                                                echo $booking['bkg_supplier_reference']; 
                                            ?>
                                        </td>
                                        <td class="text-left align-middle" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $booking['cst_name'] ;?>">
                                            <?php 
                                                // custom_echo($booking['cst_name'],15);
                                                echo $booking['cst_name'] ;
                                            ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php echo($bank == 0 || $bank == '')?"-":round($bank); ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php echo($card == 0 || $card == '')?"-":round($card); ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php echo($cash == 0 || $cash == '')?"-":round($cash); ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php echo($others == 0 || $others == '')?"-":round($others); ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php echo($due == 0 || $due == '')?"-":round($due); ?>
                                        </td>
                                        <?php
                                            if(checkAccess($user_role,'admin_view_pending_booking') && (checkAccess($user_role,'all_agents_pending_booking'))){
                                        ?>
                                        <td class="text-center align-middle" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $booking['bkg_brandname'] ;?>">
                                            <?php custom_echo($booking['bkg_brandname'], 7); ?>
                                                
                                            </td>
                                        <td class="text-center align-middle" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $booking['bkg_agent'] ;?>">
                                            <?php remove_space($booking['bkg_agent']); ?>
                                        </td>
                                        <?php }else if((!checkAccess($user_role,'admin_view_pending_booking')) && (checkAccess($user_role,'all_agents_pending_booking'))){ ?>
                                        <td class="text-center align-middle" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $booking['bkg_agent'] ;?>">
                                            <?php remove_space($booking['bkg_agent']); ?>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php 
                                        $total_bank += $bank;
                                        $total_card += $card;
                                        $total_cash += $cash;
                                        $total_others += $others;
                                        $total_due += $due;
                                        $sr++;
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <?php
                                        if((checkAccess($user_role,'admin_view_pending_booking')) && (checkAccess($user_role,'all_agents_pending_booking'))){
                                    ?>
                                    <tr>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">Total</th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_bank) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_card) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_cash) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_others) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_due) ; ?></small></th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                    </tr>
                                    <?php }elseif((!checkAccess($user_role,'admin_view_pending_booking')) && (checkAccess($user_role,'all_agents_pending_booking'))){ ?>
                                    <tr>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">Total</th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_bank) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_card) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_cash) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_others) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_due) ; ?></small></th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                    </tr>
                                    <?php }else{ ?>
                                    <tr>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">&nbsp;</th>
                                        <th class="text-center align-middle">Total</th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_bank) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_card) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_cash) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_others) ; ?></small></th>
                                        <th class="text-center align-middle" style="padding: 0px !important"><small><?php echo round($total_due) ; ?></small></th>
                                    </tr>
                                    <?php } ?>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
    </body>
</html>