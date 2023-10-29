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
                                <div class="page-pretitle"><?php echo($this->user_brand == 'All')?'All Brands':$this->user_brand; ?></div>
                                <h2 class="page-title"><?php echo $head['page_title']?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
						<div class="row">
							<div class="col">
                                <div class="card-group mt-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        <i class="glyphicon glyphicon-envelope text-info"></i>
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        -
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        <?php echo str_pad($header['mail_inq'], 4, '0', STR_PAD_LEFT); ?>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        <i class="glyphicon glyphicon-phone text-danger"></i>
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        -
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        <?php echo str_pad($header['call_enq'], 4, '0', STR_PAD_LEFT); ?>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        <i class="glyphicon glyphicon-comment text-warning"></i>
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        -
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        <?php echo str_pad($header['chat_enq'], 4, '0', STR_PAD_LEFT); ?>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        <i class="glyphicon glyphicon-info-sign text-success"></i>
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        -
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h4 class="text-center m-b-10 nopadding">
                                                                        <?php echo str_pad($header['whatsapp_enq'], 4, '0', STR_PAD_LEFT); ?>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 bottom-align">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h5 class="mb-2">Total Open Inquiries</h5>
                                                        </div>
                                                        <div class="col-md-4 text-right">
                                                            <h5 class="mb-2 font-weight-600">
                                                                <?php echo $header['mail_inq'] + $header['call_enq'] + $header['chat_enq'] + $header['whatsapp_enq']; ?>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="progress mt-1">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Column -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5 class="mb-0 text-info font-weight-600">Picked</h5>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="row">
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-envelope text-info"></i> <?php echo ($header['picked_mail_inq'] > 0) ? str_pad($header['picked_mail_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-phone text-danger"></i> <?php echo ($header['picked_call_inq'] > 0) ? str_pad($header['picked_call_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-comment text-warning"></i> <?php echo ($header['picked_chat_inq'] > 0) ? str_pad($header['picked_chat_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-info-sign text-success"></i> <?php echo ($header['picked_whatsapp_inq'] > 0) ? str_pad($header['picked_whatsapp_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5 class="mb-0 text-success font-weight-600">Mature</h5>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="row">
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-envelope text-info"></i> <?php echo ($header['mature_mail_inq'] > 0) ? str_pad($header['mature_mail_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-phone text-danger"></i> <?php echo ($header['mature_call_inq'] > 0) ? str_pad($header['mature_call_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-comment text-warning"></i> <?php echo ($header['mature_chat_inq'] > 0) ? str_pad($header['mature_chat_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-info-sign text-success"></i> <?php echo ($header['mature_whatsapp_inq'] > 0) ? str_pad($header['mature_whatsapp_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5 class="mb-0 text-danger font-weight-600">Closed</h5>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="row">
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-envelope text-info"></i> <?php echo ($header['closed_mail_inq'] > 0) ? str_pad($header['closed_mail_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-phone text-danger"></i> <?php echo ($header['closed_call_inq'] > 0) ? str_pad($header['closed_call_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-comment text-warning"></i> <?php echo ($header['closed_chat_inq'] > 0) ? str_pad($header['closed_chat_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                                <div class="col-md-3 nopadding text-center">
                                                                    <i class="glyphicon glyphicon-info-sign text-success"></i> <?php echo ($header['closed_whatsapp_inq'] > 0) ? str_pad($header['closed_whatsapp_inq'], 2, '0', STR_PAD_LEFT) : "-"; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 bottom-align">
                                                    <h5 class="mb-2">Today's Summary</h5>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: 100%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Column -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h6 class="mb-0 text-success">- Today's Active</h6>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <h6 class="text-center mb-0 text-success font-weight-600"><?php echo ($header['todays_active'] > 0) ? str_pad($header['todays_active'], 2, '0', STR_PAD_LEFT) : '-'; ?></h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h6 class="mb-0 text-danger">- Total Passed</h6>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <h6 class="text-center mb-0 text-danger font-weight-600"><?php echo ($header['total_passed'] > 0) ? str_pad($header['total_passed'], 2, '0', STR_PAD_LEFT) : '-'; ?></h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h6 class="mb-0 text-warning">- Remaining Active</h6>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <h6 class="text-center mb-0 text-warning font-weight-600"><?php echo ($header['remain_active'] > 0) ? str_pad($header['remain_active'], 2, '0', STR_PAD_LEFT) : '-'; ?></h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h6 class="mb-0 text-info">- Total Reminders</h6>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <h6 class="text-center mb-0 text-info font-weight-600"><?php echo (($header['todays_active'] + $header['total_passed'] + $header['remain_active']) > 0) ? str_pad(($header['todays_active'] + $header['total_passed'] + $header['remain_active']), 2, '0', STR_PAD_LEFT) : '-'; ?></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 bottom-align">
                                                    <h5 class="mb-1">Reminder Summary</h5>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="card card-body nopadding">
                                            <div class="table-responsive">
                                                <?php if(checkAccess($user_role,'admin_view_new_inq')){ $table_id = "newInquiries_admin"; }else{ $table_id = "newInquiries_user"; } ?>
                                                <table id="<?php echo $table_id; ?>" class="table">
                                                    <thead>
                                                        <?php
                                                            if(checkAccess($user_role,'admin_view_new_inq')){
                                                        ?>
                                                        <tr>
                                                            <th class="align-middle text-center pl-0 pr-0" width="06%">#</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="13%">Date</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="06%">Id</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="10%">Dept Date</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="33%">Details</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="13%">Feed Back</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="09%">Picked By</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="10%">Action</th>
                                                        </tr>
                                                        <?php }else{ ?>
                                                        <tr>
                                                            <th class="align-middle text-center pl-0 pr-0" width="05%">#</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="11%">Date</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="06%">Id</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="10%">Dept</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="42%">Details</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="12%">Contact</th>
                                                            <th class="align-middle text-center pl-0 pr-0" width="14%">Feed Back</th>
                                                        </tr>
                                                        <?php } ?>
                                                    </thead>
                                                    <?php 
                                                        if(checkAccess($user_role,'admin_view_new_inq')){
                                                    ?>
                                                    <tbody>
                                                        <?php
                                                            $sr = 1;
                                                            if(count($dept_date_passed) > 0){
                                                                foreach ($dept_date_passed as $key => $inq) {
                                                                    $date = strtotime($inq['enq_receive_time']);
                                                                    $cust_dest = $inq['enq_dest'];
                                                                    $cust_dept_date = date("d-M-y",strtotime($inq['enq_dept_date']));
                                                                    $cust_name = mb_strtolower($inq['enq_cust_name']);
                                                                    $cust_phone = mb_strtolower($inq['enq_cust_phone']);
                                                                    $cust_email = mb_strtolower($inq['enq_cust_email']);
                                                                    $lastCmnt = $inq['new_last_cmnt'];
                                                                    $row_color = inqcolor($cust_dept_date,$inq['alert_datetime']);
                                                        ?>
                                                        <tr bgcolor="<?php echo $row_color; ?>">
                                                            <td class="text-center align-middle p-0" data-order="<?php echo $sr; ?>"><?php echo $sr; ?></td>
                                                            <td class="text-center align-middle p-0" data-bs-toggle="tooltip" title="<?php echo date("d-M-Y h:i A",$date) ; ?>" data-order="<?php echo date("d-M-Y h:i A",$date) ; ?>">
                                                                <?php
                                                                    echo date('d-M h:i A',$date);
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0">
                                                                <a target="_blank" href="<?php echo base_url("inquiry/view/".hashing($inq['enq_id'])) ; ?>" class="text-blue font-weight-600">
                                                                    <?php echo $inq['enq_id'] ; ?>
                                                                </a>
                                                            </td>
                                                            <td class="text-center align-middle p-0" data-order="<?php echo date("d-M-y",strtotime($cust_dept_date)); ?>">
                                                                <?php echo $cust_dept_date ; ?>
                                                            </td>
                                                            <td class="text-left align-middle p-0">
                                                                <?php if($inq['enq_type'] == "Mail"){ ?>
                                                                <i class="glyphicon glyphicon-envelope" title="Web Inquiry"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Call"){  ?>
                                                                <i class="glyphicon glyphicon-phone" title="Call Received"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Chat"){  ?>
                                                                <i class="glyphicon glyphicon-comment" title="Chat"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Whatsapp"){  ?>
                                                                <i class="glyphicon glyphicon-info-sign" title="Whatsapp"></i>&nbsp;
                                                                <?php } ?>
                                                                <?php 
                                                                    if($inq['alert_datetime'] != null ){
                                                                ?>
                                                                <i class="glyphicon glyphicon-bell text-dark font-weight-600" data-bs-toggle="tooltip" title="Reminder: <?php echo date("d-M-y h:i a",strtotime($inq['alert_datetime'])) ; ?>"></i>&nbsp;
                                                                <?php } ?>
                                                                <?php echo str_replace("Flight ","", $inq['enq_page'])." - ".bfr_dash($inq['enq_dest'])." - ".$inq['enq_device'] ; ?>
                                                            </td>
                                                            <td class="text-left align-middle p-0" data-bs-toggle="tooltip" title="<?php echo $lastCmnt ;?>" data-order="<?php echo $lastCmnt; ?>" data-search="<?php echo $lastCmnt; ?>">
                                                                <?php 
                                                                    custom_echo($lastCmnt,10);                                       
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0" data-bs-toggle="tooltip" title="<?php echo $inq['picked_by'] ; ?>" data-order="<?php echo $inq['picked_by'] ; ?>">
                                                                <?php 
                                                                    echo($inq['picked_by'] != '')?remove_space($inq['picked_by']):'-';
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0">
                                                                <?php if($inq['picked_by'] == ''){ ?>
                                                                    <button class="pickInq btn btn-sm p-1 btn-warning" data-enq-id="<?php echo $inq['enq_id'] ; ?>"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                                                                <?php } ?>
                                                                <button class="deleteInq btn btn-sm p-1 btn-danger" data-enq-id="<?php echo $inq['enq_id'] ; ?>">
                                                                    <i class="glyphicon glyphicon-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                                $sr++;
                                                                }
                                                            }
                                                            if(count($alerted_inq) > 0){
                                                                foreach ($alerted_inq as $key => $inq) {
                                                                    $date = strtotime($inq['enq_receive_time']);
                                                                    $cust_dest = $inq['enq_dest'];
                                                                    $cust_dept_date = date("d-M-y",strtotime($inq['enq_dept_date']));
                                                                    $cust_name = mb_strtolower($inq['enq_cust_name']);
                                                                    $cust_phone = mb_strtolower($inq['enq_cust_phone']);
                                                                    $cust_email = mb_strtolower($inq['enq_cust_email']);
                                                                    $lastCmnt = $inq['new_last_cmnt'];
                                                                    $row_color = inqcolor($cust_dept_date,$inq['alert_datetime']);
                                                        ?>
                                                        <tr bgcolor="<?php echo $row_color; ?>">
                                                            <td class="text-center align-middle p-0" data-order="<?php echo $sr; ?>"><?php echo $sr; ?></td>
                                                            <td class="text-center align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo date("d-M-Y h:i A",$date) ; ?>" data-order="<?php echo date("d-M-Y h:i A",$date) ; ?>">
                                                                <?php
                                                                    echo date('d-M h:i A',$date);
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0">
                                                                <a target="_blank" href="<?php echo base_url("inquiry/view/".hashing($inq['enq_id'])) ; ?>" class="text-blue font-weight-600">
                                                                    <?php echo $inq['enq_id'] ; ?>
                                                                </a>
                                                            </td>
                                                            <td class="text-center align-middle p-0" data-order="<?php echo date("d-M-y",strtotime($cust_dept_date)); ?>">
                                                                <?php echo $cust_dept_date ; ?>
                                                            </td>
                                                            <td class="text-left align-middle p-0">
                                                                <?php if($inq['enq_type'] == "Mail"){ ?>
                                                                <i class="glyphicon glyphicon-envelope" title="Web Inquiry"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Call"){  ?>
                                                                <i class="glyphicon glyphicon-phone" title="Call Received"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Chat"){  ?>
                                                                <i class="glyphicon glyphicon-comment" title="Chat"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Whatsapp"){  ?>
                                                                <i class="glyphicon glyphicon-info-sign" title="Whatsapp"></i>&nbsp;
                                                                <?php } ?>
                                                                <?php 
                                                                    if($inq['alert_datetime'] != null ){
                                                                ?>
                                                                <i class="glyphicon glyphicon-bell text-dark font-weight-600" data-bs-toggle="tooltip" data-bs-placement="left" title="Reminder: <?php echo date("d-M-y h:i a",strtotime($inq['alert_datetime'])) ; ?>"></i>&nbsp;
                                                                <?php } ?>
                                                                <?php echo str_replace("Flight ","", $inq['enq_page'])." - ".bfr_dash($inq['enq_dest'])." - ".$inq['enq_device'] ; ?>
                                                            </td>
                                                            <td class="text-left align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $lastCmnt ;?>" data-order="<?php echo $lastCmnt; ?>" data-search="<?php echo $lastCmnt; ?>">
                                                                <?php 
                                                                    custom_echo($lastCmnt,10);                                       
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $inq['picked_by'] ; ?>" data-order="<?php echo $inq['picked_by'] ; ?>">
                                                                <?php 
                                                                    echo($inq['picked_by'] != '')?remove_space($inq['picked_by']):'-';
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0">
                                                                <?php if($inq['picked_by'] == ''){ ?>
                                                                    <button class="pickInq btn btn-sm p-1 btn-warning" data-enq-id="<?php echo $inq['enq_id'] ; ?>"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                                                                <?php } ?>
                                                                <button class="deleteInq btn btn-sm p-1 btn-danger" data-enq-id="<?php echo $inq['enq_id'] ; ?>">
                                                                    <i class="glyphicon glyphicon-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                                $sr++;
                                                                }
                                                            }
                                                            if(count($remaining_inq) > 0){
                                                                foreach ($remaining_inq as $key => $inq) {
                                                                    $date = strtotime($inq['enq_receive_time']);
                                                                    $cust_dest = $inq['enq_dest'];
                                                                    $cust_dept_date = date("d-M-y",strtotime($inq['enq_dept_date']));
                                                                    $cust_name = mb_strtolower($inq['enq_cust_name']);
                                                                    $cust_phone = mb_strtolower($inq['enq_cust_phone']);
                                                                    $cust_email = mb_strtolower($inq['enq_cust_email']);
                                                                    $lastCmnt = $inq['new_last_cmnt'];
                                                                    $row_color = inqcolor($cust_dept_date,$inq['alert_datetime']);
                                                        ?>
                                                        <tr bgcolor="<?php echo $row_color; ?>">
                                                            <td class="text-center align-middle p-0" data-order="<?php echo $sr; ?>"><?php echo $sr; ?></td>
                                                            <td class="text-center align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo date("d-M-Y h:i A",$date) ; ?>" data-order="<?php echo date("d-M-Y h:i A",$date) ; ?>">
                                                                <?php
                                                                    echo date('d-M h:i A',$date);
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0">
                                                                <a target="_blank" href="<?php echo base_url("inquiry/view/".hashing($inq['enq_id'])) ; ?>" class="text-blue font-weight-600">
                                                                    <?php echo $inq['enq_id'] ; ?>
                                                                </a>
                                                            </td>
                                                            <td class="text-center align-middle p-0" data-order="<?php echo date("d-M-y",strtotime($cust_dept_date)); ?>">
                                                                <?php echo $cust_dept_date ; ?>
                                                            </td>
                                                            <td class="text-left align-middle p-0">
                                                                <?php if($inq['enq_type'] == "Mail"){ ?>
                                                                <i class="glyphicon glyphicon-envelope" title="Web Inquiry"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Call"){  ?>
                                                                <i class="glyphicon glyphicon-phone" title="Call Received"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Chat"){  ?>
                                                                <i class="glyphicon glyphicon-comment" title="Chat"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Whatsapp"){  ?>
                                                                <i class="glyphicon glyphicon-info-sign" title="Whatsapp"></i>&nbsp;
                                                                <?php } ?>
                                                                <?php 
                                                                    if($inq['alert_datetime'] != null ){
                                                                ?>
                                                                <i class="glyphicon glyphicon-bell text-dark font-weight-600" data-bs-toggle="tooltip" data-bs-placement="left" title="Reminder: <?php echo date("d-M-y h:i a",strtotime($inq['alert_datetime'])) ; ?>"></i>&nbsp;
                                                                <?php } ?>
                                                                <?php echo str_replace("Flight ","", $inq['enq_page'])." - ".bfr_dash($inq['enq_dest'])." - ".$inq['enq_device'] ; ?>
                                                            </td>
                                                            <td class="text-left align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $lastCmnt ;?>" data-order="<?php echo $lastCmnt; ?>" data-search="<?php echo $lastCmnt; ?>">
                                                                <?php 
                                                                    custom_echo($lastCmnt,10);                                       
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $inq['picked_by'] ; ?>" data-order="<?php echo $inq['picked_by'] ; ?>">
                                                                <?php 
                                                                    echo($inq['picked_by'] != '')?remove_space($inq['picked_by']):'-';
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0">
                                                                <?php if($inq['picked_by'] == ''){ ?>
                                                                    <button class="pickInq btn btn-sm p-1 btn-warning" data-enq-id="<?php echo $inq['enq_id'] ; ?>"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                                                                <?php } ?>
                                                                <button class="deleteInq btn btn-sm p-1 btn-danger" data-enq-id="<?php echo $inq['enq_id'] ; ?>">
                                                                    <i class="glyphicon glyphicon-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                                $sr++;
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                    <?php 
                                                        }else{
                                                    ?>
                                                    <tbody>
                                                        <?php 
                                                            $sr = 1;
                                                            if(count($dept_date_passed) > 0){
                                                                foreach ($dept_date_passed as $key => $inq) {
                                                                    $date = strtotime($inq['enq_receive_time']);
                                                                    $cust_dest = $inq['enq_dest'];
                                                                    $cust_dept_date = date("d-M-y",strtotime($inq['enq_dept_date']));
                                                                    $cust_name = mb_strtolower($inq['enq_cust_name']);
                                                                    $cust_phone = mb_strtolower($inq['enq_cust_phone']);
                                                                    $cust_email = mb_strtolower($inq['enq_cust_email']);
                                                                    $row_color = inqcolor($cust_dept_date,$inq['alert_datetime']);
                                                                    $lastCmnt = $inq['new_last_cmnt'];
                                                        ?>
                                                        <tr bgcolor="<?php echo $row_color ; ?>">
                                                            <td class="p-0-5 text-center align-middle p-0" data-order="<?php echo $sr; ?>">
                                                                <?php echo $sr; ?>
                                                            </td>
                                                            <td class="p-0-5 text-center align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo date("d-M-Y",$date) ; ?>" data-order="<?php echo date("d-M-Y",$date) ; ?>">
                                                                <?php
                                                                    echo date('d-M h:i A',$date);
                                                                ?>
                                                            </td>
                                                            <td class="p-0-5 text-center align-middle p-0" data-order="<?php echo $inq['enq_id']; ?>">
                                                                <?php 
                                                                    if($inq['picked_by'] == $user_name){ 
                                                                ?>
                                                                <a target="_blank" href="<?php echo base_url("inquiry/view/".hashing($inq['enq_id'])) ; ?>" class="text-blue font-weight-600">
                                                                    <?php echo $inq['enq_id'] ; ?>
                                                                </a>
                                                                <?php 
                                                                    }else{
                                                                        echo $inq['enq_id'];
                                                                    } 
                                                                ?>
                                                            </td>
                                                            <td class="p-0-5 text-center align-middle p-0" data-order="<?php echo date("d-M-y",strtotime($cust_dept_date)); ?>">
                                                                <?php echo $cust_dept_date ; ?>
                                                            </td>
                                                            <td class="p-0-5 text-left align-middle p-0">
                                                                <?php if($inq['enq_type'] == "Mail"){ ?>
                                                                <i class="glyphicon glyphicon-envelope" title="Web Inquiry"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Call"){  ?>
                                                                <i class="glyphicon glyphicon-phone" title="Call Received"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Chat"){  ?>
                                                                <i class="glyphicon glyphicon-comment" title="Chat"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Whatsapp"){  ?>
                                                                <i class="glyphicon glyphicon-info-sign" title="Whatsapp"></i>&nbsp;
                                                                <?php } ?>
                                                                <?php 
                                                                    if($inq['alert_datetime'] != null ){
                                                                ?>
                                                                <i class="glyphicon glyphicon-bell text-dark font-weight-600" data-bs-toggle="tooltip" data-bs-placement="left" title="Reminder: <?php echo date("d-M-y h:i a",strtotime($inq['alert_datetime'])) ; ?>"></i>&nbsp;
                                                                <?php 
                                                                    } 
                                                                    echo str_replace("Flight ","", $inq['enq_page'])." - ".bfr_dash($inq['enq_dest'])." by ".$cust_name." - ".$inq['enq_device'] ; 
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $cust_phone ;?>" data-order="<?php echo $cust_phone; ?>" data-search="<?php echo $cust_phone; ?>">
                                                                <?php 
                                                                    custom_echo($cust_phone,11);                                       
                                                                ?>
                                                            </td>
                                                            <td class="text-left align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $lastCmnt ;?>" data-order="<?php echo $lastCmnt; ?>" data-search="<?php echo $lastCmnt; ?>">
                                                                <?php 
                                                                    custom_echo($lastCmnt,15);                                       
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                                $sr++;
                                                                }
                                                            }
                                                            if(count($alerted_inq) > 0){
                                                                foreach ($alerted_inq as $key => $inq) {
                                                                    $date = strtotime($inq['enq_receive_time']);
                                                                    $cust_dest = $inq['enq_dest'];
                                                                    $cust_dept_date = date("d-M-y",strtotime($inq['enq_dept_date']));
                                                                    $cust_name = mb_strtolower($inq['enq_cust_name']);
                                                                    $cust_phone = mb_strtolower($inq['enq_cust_phone']);
                                                                    $cust_email = mb_strtolower($inq['enq_cust_email']);
                                                                    $lastCmnt = $inq['new_last_cmnt'];
                                                                    $row_color = inqcolor($cust_dept_date,$inq['alert_datetime']);
                                                        ?>
                                                        <tr bgcolor="<?php echo $row_color ; ?>">
                                                            <td class="p-0-5 text-center align-middle p-0" data-order="<?php echo $sr; ?>">
                                                                <?php echo $sr; ?>
                                                            </td>
                                                            <td class="p-0-5 text-center align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo date("d-M-Y",$date) ; ?>" data-order="<?php echo date("d-M-Y",$date) ; ?>">
                                                                <?php
                                                                    echo date('d-M h:i A',$date);
                                                                ?>
                                                            </td>
                                                            <td class="p-0-5 text-center align-middle p-0" data-order="<?php echo $inq['enq_id']; ?>">
                                                                <?php 
                                                                    if($inq['picked_by'] == $user_name){ 
                                                                ?>
                                                                <a target="_blank" href="<?php echo base_url("inquiry/view/".hashing($inq['enq_id'])) ; ?>" class="text-blue font-weight-600">
                                                                    <?php echo $inq['enq_id'] ; ?>
                                                                </a>
                                                                <?php 
                                                                    }else{
                                                                        echo $inq['enq_id'];
                                                                    } 
                                                                ?>
                                                            </td>
                                                            <td class="p-0-5 text-center align-middle p-0" data-order="<?php echo date("d-M-y",strtotime($cust_dept_date)); ?>">
                                                                <?php echo $cust_dept_date ; ?>
                                                            </td>
                                                            <td class="p-0-5 text-left align-middle p-0">
                                                                <?php if($inq['enq_type'] == "Mail"){ ?>
                                                                <i class="glyphicon glyphicon-envelope" title="Web Inquiry"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Call"){  ?>
                                                                <i class="glyphicon glyphicon-phone" title="Call Received"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Chat"){  ?>
                                                                <i class="glyphicon glyphicon-comment" title="Chat"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Whatsapp"){  ?>
                                                                <i class="glyphicon glyphicon-info-sign" title="Whatsapp"></i>&nbsp;
                                                                <?php } ?>
                                                                <?php 
                                                                    if($inq['alert_datetime'] != null ){
                                                                ?>
                                                                <i class="glyphicon glyphicon-bell text-dark font-weight-600" data-bs-toggle="tooltip" data-bs-placement="left" title="Reminder: <?php echo date("d-M-y h:i a",strtotime($inq['alert_datetime'])) ; ?>"></i>&nbsp;
                                                                <?php 
                                                                    } 
                                                                    echo str_replace("Flight ","", $inq['enq_page'])." - ".bfr_dash($inq['enq_dest'])." by ".$cust_name." - ".$inq['enq_device'] ; 
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $cust_phone ;?>" data-order="<?php echo $cust_phone; ?>" data-search="<?php echo $cust_phone; ?>">
                                                                <?php 
                                                                    custom_echo($cust_phone,11);                                       
                                                                ?>
                                                            </td>
                                                            <td class="text-left align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $lastCmnt ;?>" data-order="<?php echo $lastCmnt; ?>" data-search="<?php echo $lastCmnt; ?>">
                                                                <?php 
                                                                    custom_echo($lastCmnt,15);                                       
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                                $sr++;
                                                                }
                                                            }
                                                            if(count($remaining_inq) > 0){
                                                                foreach ($remaining_inq as $key => $inq) {
                                                                    $date = strtotime($inq['enq_receive_time']);
                                                                    $cust_dest = $inq['enq_dest'];
                                                                    $cust_dept_date = date("d-M-y",strtotime($inq['enq_dept_date']));
                                                                    $cust_name = mb_strtolower($inq['enq_cust_name']);
                                                                    $cust_phone = mb_strtolower($inq['enq_cust_phone']);
                                                                    $cust_email = mb_strtolower($inq['enq_cust_email']);
                                                                    $lastCmnt = $inq['new_last_cmnt'];
                                                                    $row_color = inqcolor($cust_dept_date,$inq['alert_datetime']);
                                                        ?>
                                                        <tr bgcolor="<?php echo $row_color ; ?>">
                                                            <td class="p-0-5 text-center align-middle p-0" data-order="<?php echo $sr; ?>">
                                                                <?php echo $sr; ?>
                                                            </td>
                                                            <td class="p-0-5 text-center align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo date("d-M-Y",$date) ; ?>" data-order="<?php echo date("d-M-Y",$date) ; ?>">
                                                                <?php
                                                                    echo date('d-M-Y',$date);
                                                                ?>
                                                            </td>
                                                            <td class="p-0-5 text-center align-middle p-0" data-order="<?php echo $inq['enq_id']; ?>">
                                                                <?php 
                                                                    if($inq['picked_by'] == $user_name){ 
                                                                ?>
                                                                <a target="_blank" href="<?php echo base_url("inquiry/view/".hashing($inq['enq_id'])) ; ?>" class="text-blue font-weight-600">
                                                                    <?php echo $inq['enq_id'] ; ?>
                                                                </a>
                                                                <?php 
                                                                    }else{
                                                                        echo $inq['enq_id'];
                                                                    } 
                                                                ?>
                                                            </td>
                                                            <td class="p-0-5 text-center align-middle p-0" data-order="<?php echo date("d-M-y",strtotime($cust_dept_date)); ?>">
                                                                <?php echo $cust_dept_date ; ?>
                                                            </td>
                                                            <td class="p-0-5 text-left align-middle p-0">
                                                                <?php if($inq['enq_type'] == "Mail"){ ?>
                                                                <i class="glyphicon glyphicon-envelope" title="Web Inquiry"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Call"){  ?>
                                                                <i class="glyphicon glyphicon-phone" title="Call Received"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Chat"){  ?>
                                                                <i class="glyphicon glyphicon-comment" title="Chat"></i>&nbsp;
                                                                <?php }elseif($inq['enq_type'] == "Whatsapp"){  ?>
                                                                <i class="glyphicon glyphicon-info-sign" title="Whatsapp"></i>&nbsp;
                                                                <?php } ?>
                                                                <?php 
                                                                    if($inq['alert_datetime'] != null ){
                                                                ?>
                                                                <i class="glyphicon glyphicon-bell text-dark font-weight-600" data-bs-toggle="tooltip" data-bs-placement="left" title="Reminder: <?php echo date("d-M-y h:i a",strtotime($inq['alert_datetime'])) ; ?>"></i>&nbsp;
                                                                <?php 
                                                                    } 
                                                                    echo str_replace("Flight ","", $inq['enq_page'])." - ".bfr_dash($inq['enq_dest'])." by ".$cust_name." - ".$inq['enq_device'] ; 
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $cust_phone ;?>" data-order="<?php echo $cust_phone; ?>" data-search="<?php echo $cust_phone; ?>">
                                                                <?php 
                                                                    custom_echo($cust_phone,11);                                       
                                                                ?>
                                                            </td>
                                                            <td class="text-left align-middle p-0" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $lastCmnt ;?>" data-order="<?php echo $lastCmnt; ?>" data-search="<?php echo $lastCmnt; ?>">
                                                                <?php 
                                                                    custom_echo($lastCmnt,15);                                       
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                                $sr++;
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
    </body>
</html>