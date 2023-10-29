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
                            <div class="col-auto ms-auto">
                                <div class="row">
                                    <?php if (checkAccess($user_role, 'admin_view_new_inq')) { ?>
                                        <div class="col-auto">
                                            <div class="form-group row">
                                                <?php  if ($user_brand == 'All') { ?>
                                                <label for="example-text-input" class="col-auto form-label">Brands</label>
                                                <div class="col-auto">
                                                    <form method="post">
                                                        <input type="hidden" name="agent" value="<?php echo @$agent; ?>">
                                                        <select name="brandname" class="brand form-control form-control-sm" onchange="this.form.submit();">
                                                            <option value="">All</option>
                                                            <?php foreach ($brands as $key => $brand) {
                                                                if ($brand['brandname'] != '') { ?>
                                                                    <option value="<?php echo $brand['brandname']; ?>" <?php echo (isset($brandname) && $brandname == $brand['brandname']) ? 'selected' : ''; ?>><?php echo $brand['brandname']; ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </form>
                                                </div>
                                                <?php }?>
                                                <label for="example-text-input" class="col-auto form-label">Agents</label>
                                                <div class="col-auto">
                                                    <form method="post">
                                                        <input type="hidden" name="brandname" value="<?php echo @$brandname; ?>">
                                                        <select name="agent" class="agent form-control form-control-sm" onchange="this.form.submit();">
                                                            <option value="">All</option>
                                                            <?php foreach ($agents as $key => $user) {
                                                                if ($user['user_name'] != '') { ?>
                                                                    <option value="<?php echo $user['user_name']; ?>" <?php echo (isset($agent) && $agent == $user['user_name']) ? 'selected' : ''; ?>><?php echo $user['user_name']; ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-auto ms-auto">
                                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_inq"><i class="icon m-0 glyphicon glyphicon-plus"></i> Add Inquiry</button>
                                    </div>
                                </div>
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
                                <div class="row mt-3">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <?php 
                                            if($new > 0){
                                        ?>
                                        <div class="card">
                                            <div class="card-header bg-danger">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="card-title m-t-5 mb-0 text-white">New Customer Inquiries</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <?php if (checkAccess($user_role, 'admin_view_new_inq')) {
                                                        $table_class = "admin_newinq";
                                                    } else {
                                                        $table_class = "user_newinq";
                                                    } ?>
                                                    <table class="<?php echo $table_class; ?> table full-color-table full-info-table hover-table">
                                                        <thead>
                                                            <?php
                                                            if (checkAccess($user_role, 'admin_view_new_inq')) {
                                                            ?>
                                                                <tr>
                                                                    <th class="align-middle text-center" width="06%">#</th>
                                                                    <th class="align-middle text-center" width="10%">Date</th>
                                                                    <th class="align-middle text-center" width="05%">BR</th>
                                                                    <th class="align-middle text-center" width="06%">Id</th>
                                                                    <th class="align-middle text-center" width="10%">Dept Date</th>
                                                                    <th class="align-middle text-center" width="32%">Details</th>
                                                                    <th class="align-middle text-center" width="13%">Feed Back</th>
                                                                    <th class="align-middle text-center" width="09%">Picked By</th>
                                                                    <th class="align-middle text-center" width="09%">Action</th>
                                                                </tr>
                                                            <?php } else { ?>
                                                                <tr>
                                                                    <th class="align-middle text-center" width="05%">#</th>
                                                                    <th class="align-middle text-center" width="14%">Date</th>
                                                                    <th class="align-middle text-center" width="07%">Id</th>
                                                                    <th class="align-middle text-center" width="12%">Dept Date</th>
                                                                    <th class="align-middle text-center" width="45%">Details</th>
                                                                    <th class="align-middle text-center" width="10%">Picked By</th>
                                                                    <th class="align-middle text-center" width="07%">Action</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            }
                                            if($tdp > 0){
                                        ?>
                                        <div class="card mt-3">
                                            <div class="card-header bg-danger">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="card-title m-t-5 mb-0 text-white">Traveling Date Passed</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <?php if (checkAccess($user_role, 'admin_view_new_inq')) {
                                                        $table_class = "admin_tdpinq";
                                                    } else {
                                                        $table_class = "user_tdpinq";
                                                    } ?>
                                                    <table class="<?php echo $table_class; ?> table full-color-table full-info-table hover-table">
                                                        <thead>
                                                            <?php
                                                            if (checkAccess($user_role, 'admin_view_new_inq')) {
                                                            ?>
                                                                <tr>
                                                                    <th class="align-middle text-center" width="06%">#</th>
                                                                    <th class="align-middle text-center" width="10%">Date</th>
                                                                    <th class="align-middle text-center" width="05%">BR</th>
                                                                    <th class="align-middle text-center" width="06%">Id</th>
                                                                    <th class="align-middle text-center" width="10%">Dept Date</th>
                                                                    <th class="align-middle text-center" width="32%">Details</th>
                                                                    <th class="align-middle text-center" width="13%">Feed Back</th>
                                                                    <th class="align-middle text-center" width="09%">Picked By</th>
                                                                    <th class="align-middle text-center" width="09%">Action</th>
                                                                </tr>
                                                            <?php } else { ?>
                                                                <tr>
                                                                    <th class="align-middle text-center" width="05%">#</th>
                                                                    <th class="align-middle text-center" width="14%">Date</th>
                                                                    <th class="align-middle text-center" width="07%">Id</th>
                                                                    <th class="align-middle text-center" width="12%">Dept Date</th>
                                                                    <th class="align-middle text-center" width="45%">Details</th>
                                                                    <th class="align-middle text-center" width="10%">Picked By</th>
                                                                    <th class="align-middle text-center" width="07%">Action</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            }
                                            if($rem > 0){
                                        ?>
                                        <div class="card mt-3">
                                            <div class="card-header bg-danger">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="card-title m-t-5 mb-0 text-white">Customer Inquiries</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <?php if (checkAccess($user_role, 'admin_view_new_inq')) {
                                                        $table_class = "admin_reminq";
                                                    } else {
                                                        $table_class = "user_reminq";
                                                    } ?>
                                                    <table class="<?php echo $table_class; ?> table full-color-table full-info-table hover-table">
                                                        <thead>
                                                            <?php
                                                            if (checkAccess($user_role, 'admin_view_new_inq')) {
                                                            ?>
                                                                <tr>
                                                                    <th class="align-middle text-center" width="06%">#</th>
                                                                    <th class="align-middle text-center" width="10%">Date</th>
                                                                    <th class="align-middle text-center" width="05%">BR</th>
                                                                    <th class="align-middle text-center" width="06%">Id</th>
                                                                    <th class="align-middle text-center" width="10%">Dept Date</th>
                                                                    <th class="align-middle text-center" width="32%">Details</th>
                                                                    <th class="align-middle text-center" width="13%">Feed Back</th>
                                                                    <th class="align-middle text-center" width="09%">Picked By</th>
                                                                    <th class="align-middle text-center" width="09%">Action</th>
                                                                </tr>
                                                            <?php } else { ?>
                                                                <tr>
                                                                    <th class="align-middle text-center" width="05%">#</th>
                                                                    <th class="align-middle text-center" width="14%">Date</th>
                                                                    <th class="align-middle text-center" width="07%">Id</th>
                                                                    <th class="align-middle text-center" width="12%">Dept Date</th>
                                                                    <th class="align-middle text-center" width="45%">Details</th>
                                                                    <th class="align-middle text-center" width="10%">Picked By</th>
                                                                    <th class="align-middle text-center" width="07%">Action</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            } 
                                        ?>
                                    </div>
                                </div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
        <div class="modal fade" id="add_inq">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="add_inqLabel1">Add Inquiry</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addInq" autocomplete="off">
                            <input type="hidden" name="enq_date" value="<?php echo date("Y-m-d"); ?>">
                            <input type="hidden" name="picked_by" value="<?php echo $this->session->userdata('user_name'); ?>">
                            <input type="hidden" name="enq_page" value="-">
                            <input type="hidden" name="enq_device" value="-">
                            <input type="hidden" name="enq_feedback" value="-">
                            <input type="hidden" name="enq_receive_time" value="<?php echo date('Y-m-d H:i:s') ?>">
                            <input type="hidden" name="enq_pick_time" value="<?php echo date('Y-m-d H:i:s') ?>">
                            <input type="hidden" name="enq_brand" value="<?php echo ($this->session->userdata('user_brand') != 'All') ? $this->session->userdata('user_brand') : $this->mainbrand; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Inquiry Type <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <select name="enq_type" class="form-control" required>
                                                <option value="">Select Type</option>
                                                <option value="Mail">Mail</option>
                                                <option value="Call">Call</option>
                                                <option value="Chat">Chat</option>
                                                <option value="Whatsapp">Whatsapp</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Inquiry Status</label>
                                        <div class="controls">
                                            <select name="enq_status" class="form-control" required>
                                                <option value="Open" selected>Open</option>
                                                <option value="Mature">Mature</option>
                                                <option value="Dummy">Dummy</option>
                                                <option value="Duplicate">Duplicate</option>
                                                <option value="Repeat">Repeat</option>
                                                <option value="Unmature">Unmature</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Ticket Class</label>
                                        <div class="controls">
                                            <select name="enq_tkt_class" class="form-control" required>
                                                <option value="Economy" selected>Economy</option>
                                                <option value="Business Class">Business Class</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Ticket Type</label>
                                        <div class="controls">
                                            <select name="enq_tkt_type" class="flight_type form-control" required>
                                                <option value="Return" selected>Return</option>
                                                <option value="Oneway">Oneway</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Deptarture<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="enq_dept" class="airport typeahead form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Destination<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="enq_dest" class="airport typeahead form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="dept-date col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Dept Date<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="enq_dept_date" class="startdate form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="return-date col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Retrn Date<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="enq_rtrn_date" class="enddate form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Name<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="enq_cust_name" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label class="form-label">phn #<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="enq_cust_phone" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="email" name="enq_cust_email" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Airline </label>
                                                <div class="controls">
                                                    <input type="text" name="enq_airline" class="airline typeahead form-control" value="-">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Price <span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" name="enq_tkt_price" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Adults</label>
                                                <div class="controls">
                                                    <input type="text" name="enq_adt" class="form-control" value="1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Children</label>
                                                <div class="controls">
                                                    <input type="text" name="enq_chd" class="form-control" value="0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Infants</label>
                                                <div class="controls">
                                                    <input type="text" name="enq_inf" class="form-control" value="0" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-0">
                                        <label class="form-label">Feedback</label>
                                        <div class="controls">
                                            <textarea name="enq_cust_cmnt" type="text" rows="3" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="addIndsubbtn btn btn-success btn-sm" form="addInq">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            window.setTimeout(function() {
                document.location.reload(true);
            }, 1000000);
        </script>
    </body>
</html>