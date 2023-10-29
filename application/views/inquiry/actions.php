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
                            <?php if (checkAccess($user_role, 'admin_view_new_inq')) { ?>
                                <div class="form-group row">
                                    <label class="col-auto form-label">Agents</label>
                                    <div class="col-auto">
                                        <form method="post">
                                            <select name="agent" class="agent form-control form-control-sm" onchange="this.form.submit();">
                                                <option value="">Select All</option>
                                                <?php foreach ($agents as $key => $user) {
                                                    if ($user['user_name'] != '') { ?>
                                                        <option value="<?php echo $user['user_name']; ?>" <?php echo (isset($agent) && $agent == $user['user_name']) ? 'selected' : ''; ?>><?php echo $user['user_name']; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
						<div class="row">
							<div class="col">
                                <div class="card card-body nopadding">
                                    <div class="table-responsive">
                                        <table id="<?php echo (checkAccess($user_role, 'admin_view_new_inq')) ? 'inq_action_admin' : 'inq_action_user'; ?>" class="table ">
                                            <thead>
                                                <?php
                                                if (checkAccess($user_role, 'admin_view_new_inq')) {
                                                ?>
                                                    <tr>
                                                        <th class="align-middle text-center" width="05%">#</th>
                                                        <th class="align-middle text-center" width="10%">Date</th>
                                                        <th class="align-middle text-center" width="07%">Id</th>
                                                        <th class="align-middle text-center" width="10%">Dept Date</th>
                                                        <th class="align-middle text-center" width="22%">Details</th>
                                                        <th class="align-middle text-center" width="15%">Feed Back</th>
                                                        <th class="align-middle text-center" width="09%">Agent</th>
                                                        <th class="align-middle text-center" width="09%">Status</th>
                                                        <th class="align-middle text-center" width="09%">Action</th>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <th class="align-middle text-center" width="06%">#</th>
                                                        <th class="align-middle text-center" width="10%">Date</th>
                                                        <th class="align-middle text-center" width="08%">Id</th>
                                                        <th class="align-middle text-center" width="10%">Dept Date</th>
                                                        <th class="align-middle text-center" width="24%">Details</th>
                                                        <th class="align-middle text-center" width="18%">Feed Back</th>
                                                        <th class="align-middle text-center" width="10%">Picked By</th>
                                                        <th class="align-middle text-center" width="10%">Status</th>
                                                    </tr>
                                                <?php } ?>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sr = 1;
                                                foreach ($inquiries as $key => $inquiry) {
                                                    $date_rec = date('d-M-y', strtotime($inquiry['enq_receive_time']));
                                                    $cust_dept_date = date("d-M-y", strtotime($inquiry['enq_dept_date']));
                                                    $cust_dest = $inquiry['enq_dest'];
                                                    $cust_dept_date = date("d-M-y", strtotime($inquiry['enq_dept_date']));
                                                    $cust_name = mb_strtolower($inquiry['enq_cust_name']);
                                                    $cust_phone = mb_strtolower($inquiry['enq_cust_phone']);
                                                    $cust_email = mb_strtolower($inquiry['enq_cust_email']);
                                                    $lastCmnt = $inquiry['new_last_cmnt'];
                                                ?>
                                                    <tr data-row-id="<?php echo $inquiry['enq_id'] ?>">
                                                        <td class="text-center align-middle"><?php echo $sr; ?></td>
                                                        <td class="text-center align-middle"><?php echo $date_rec; ?></td>
                                                        <td class="text-center align-middle">
                                                            <a target="_blank" href="<?php echo base_url("inquiry/view/" . hashing($inquiry['enq_id'])); ?>" class="text-blue font-weight-600">
                                                                <?php echo $inquiry['enq_id']; ?>
                                                            </a>
                                                        <td class="text-center align-middle"><?php echo $cust_dept_date; ?></td>
                                                        <td class=" text-left align-middle">
                                                            <?php if ($inquiry['enq_type'] == "Mail") { ?>
                                                                <i class="glyphicon glyphicon-envelope" title="Web Inquiry"></i>&nbsp;
                                                            <?php } elseif ($inquiry['enq_type'] == "Call") {  ?>
                                                                <i class="glyphicon glyphicon-phone" title="Call Received"></i>&nbsp;
                                                            <?php } elseif ($inquiry['enq_type'] == "Chat") {  ?>
                                                                <i class="glyphicon glyphicon-comment" title="Chat"></i>&nbsp;
                                                            <?php } elseif ($inquiry['enq_type'] == "Whatsapp") {  ?>
                                                                <i class="glyphicon glyphicon-info-sign" title="Whatsapp"></i>&nbsp;
                                                            <?php } ?>
                                                            <?php echo bfr_dash($inquiry['enq_dest']) . " by " . $cust_name; ?>
                                                        </td>
                                                        <td class=" text-left align-middle" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $lastCmnt; ?>" data-order="<?php echo $lastCmnt; ?>" data-search="<?php echo $lastCmnt; ?>">
                                                            <?php
                                                            custom_echo($lastCmnt, 18);
                                                            ?>
                                                        </td>
                                                        <td class="text-center align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $inquiry['picked_by']; ?>" data-order="<?php echo $inquiry['picked_by']; ?>">
                                                            <?php
                                                            echo ($inquiry['picked_by'] != '') ? remove_space($inquiry['picked_by']) : '-';
                                                            ?>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <?php echo $inquiry['enq_status'] ?>
                                                        </td>
                                                        <?php if (checkAccess($user_role, 'admin_view_new_inq')) { ?>
                                                            <td class="text-center align-middle">
                                                                <div class="btn-group">
                                                                    <button class="inqaction btn btn-sm btn-primary" data-inq-id="<?php echo $inquiry['enq_id'] ?>" data-status="Closed">
                                                                        <i class="glyphicon glyphicon-remove-circle"></i>
                                                                    </button>
                                                                    <button class="inqaction btn btn-sm btn-success" data-inq-id="<?php echo $inquiry['enq_id'] ?>" data-status="Open">
                                                                        <i class="glyphicon glyphicon-refresh"></i>
                                                                    </button>
                                                                    <button class="deleteInq btn btn-sm btn-danger" data-enq-id="<?php echo $inquiry['enq_id'] ?>">
                                                                        <i class="glyphicon glyphicon-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php
                                                    $sr++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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