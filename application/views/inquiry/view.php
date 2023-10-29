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

                            <div class="col-6">

                                <div class="row">

                                    <div class="col-1 p-0 m-0"><label class="form-label mb-0">ID:</label></div>

                                    <div class="col-2 p-0 m-0"><span class="font-weight-bold"><?php echo $enq_details['enq_id'] ; ?></span></div>

                                    <div class="col-2 p-0 m-0"><label class="form-label mb-0">Status:</label></div>

                                    <div class="col-2 p-0 m-0">

                                        <?php 

                                            if($enq_details['enq_status'] == 'Open'){

                                        ?>

                                        <span class="font-weight-bold text-info">Open</span>

                                        <?php 

                                            }else if($enq_details['enq_status'] == 'Mature'){

                                        ?>

                                        <span class="font-weight-bold text-success">Mature</span>

                                        <?php 

                                            }else if($enq_details['enq_status'] == 'Dummy' || $enq_details['enq_status'] == 'Duplicate' || $enq_details['enq_status'] == 'Repeat' || $enq_details['enq_status'] == 'Unmature' ){

                                        ?>

                                        <span class="font-weight-bold text-warning"><?php echo $enq_details['enq_status'] ; ?></span>

                                        <?php 

                                            }else if($enq_details['enq_status'] == 'Closed'){

                                        ?>

                                        <span class="font-weight-bold text-danger">Closed</span>

                                        <?php 

                                            }

                                        ?>

                                    </div>

                                    <div class="col-2 p-0 m-0"><label class="form-label mb-0">Time Rcv:</label></div>

                                    <div class="col-3 p-0 m-0"><span class="font-weight-bold"><?php echo date('d-M-y G:ia',strtotime($enq_details['enq_receive_time'])) ; ?></span></div>

                                </div>

                                <div class="row">

                                    <div class="col-1 p-0 m-0"><label class="form-label mb-0">Type:</label></div>

                                    <div class="col-2 p-0 m-0"><?php echo $enq_details['enq_type'] ; ?></div>

                                    <div class="col-2 p-0 m-0"><label class="form-label mb-0">Agent:</label></div>

                                    <div class="col-2 p-0 m-0"><span class="font-weight-bold"><?php echo($enq_details['picked_by']!='')?$enq_details['picked_by']:'-'; ?></span></div>

                                    <div class="col-2 p-0 m-0"><label class="form-label mb-0">Time Pick:</label></div>

                                    <div class="col-3 p-0 m-0"><span class="font-weight-bold"><?php echo(strtotime($enq_details['enq_pick_time']) > 0)?date('d-M-y G:ia',strtotime($enq_details['enq_pick_time'])):'-'; ?></span></div>

                                </div>

                            </div>

                            <div class="col-auto ms-auto">

                                <div class="form-group mb-0">

                                    <?php if(empty($enq_alert)){ ?>

                                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#inquiryAlert">

                                        <i class="glyphicon glyphicon-bell"></i> Reminder

                                    </button>

                                    <?php }else{ ?>

                                    <div class="btn-group">

                                        <button class="editalert btn btn-sm btn-danger" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-alert-id="<?php echo $enq_alert['id']; ?>"><i class="glyphicon glyphicon-edit" title="Edit Reminder"></i></button>



                                        <button class="removeAlert btn btn-sm btn-warning" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-alert-id="<?php echo $enq_alert['id']; ?>"><i class="glyphicon glyphicon-remove-sign" title="Remove Reminder"></i></button>



                                        <button class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#compAlert">

                                            <i class="glyphicon glyphicon-ok-circle" title="Complete Reminder"></i>

                                        </button>

                                    </div>

                                    <?php 

                                        } 

                                        if($enq_details['enq_status'] != "Closed"){

                                            if($enq_details['enq_status'] == "Open"){

                                    ?>

                                    <div class="btn-group">

                                        <button class="inqaction btn btn-sm p-1 btn-success" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-status="Mature" title="Mature"><i class="glyphicon glyphicon-thumbs-up"></i></button>

                                        <button class="inqaction btn btn-sm p-1 btn-danger" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-status="Unmature" title="Unmature"><i class="glyphicon glyphicon-thumbs-down"></i></button>

                                    </div>

                                    <?php 

                                            }

                                            if(checkAccess($user_role,'admin_view_new_inq')){

                                    ?>

                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                                        <div class="btn-group" role="group">

                                            <button id="inq_action" type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Close</button>

                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                                <?php 

                                                    if($enq_details['enq_status'] != "Open"){

                                                ?>                                        

                                                <a class="dropdown-item <?php echo($enq_details['enq_status']=='Open')?'active':'inqaction'; ?>" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-status="Open" <?php echo($enq_details['enq_status']=='Open')?'disabled':''; ?>>

                                                    Re-Open

                                                </a>

                                                <?php   

                                                    }elseif($enq_details['enq_status'] != "Mature" || $enq_details['enq_status'] != "Unmature"){

                                                ?>

                                                <a class="dropdown-item <?php echo($enq_details['enq_status']=='Closed')?'active':'inqaction'; ?>" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-status="Closed" <?php echo($enq_details['enq_status']=='Closed')?'disabled':''; ?>>

                                                    Close

                                                </a>

                                                <?php 

                                                    }

                                                ?>

                                            </div>

                                        </div>

                                    </div>

                                    <?php 

                                            }elseif($enq_details['enq_status'] != "Mature" && $enq_details['enq_status'] != "Unmature"){

                                    ?>

                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                                        <div class="btn-group" role="group">

                                            <button id="inq_action" type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Close</button>

                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                                <a class="dropdown-item <?php echo($enq_details['enq_status']=='Repeat')?'active':'inqaction'; ?>" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-status="Repeat" <?php echo($enq_details['enq_status']=='Repeat')?'disabled':''; ?>>

                                                    Repeat

                                                </a>

                                                <a class="dropdown-item <?php echo($enq_details['enq_status']=='Duplicate')?'active':'inqaction'; ?>" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-status="Duplicate" <?php echo($enq_details['enq_status']=='Duplicate')?'disabled':''; ?>>

                                                    Duplicate

                                                </a>

                                                <a class="dropdown-item <?php echo($enq_details['enq_status']=='Dummy')?'active':'inqaction'; ?>" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-status="Dummy" <?php echo($enq_details['enq_status']=='Dummy')?'disabled':''; ?>>

                                                    Dummy

                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                    <?php 

                                            }

                                        }elseif($enq_details['enq_status'] == "Closed" && checkAccess($user_role,'admin_view_new_inq')){

                                    ?>

                                    <button class="inqaction btn btn-sm btn-warning" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-status="Open">

                                        <i class="glyphicon glyphicon-ok-circle"></i> Re-Open

                                    </button>

                                    <?php

                                        }

                                    ?>

                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                                        <div class="btn-group" role="group">

                                            <button id="assigninq" type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-users"></i> Assign</button>

                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                                <?php 
                                                    if($user_brand != "All"){
                                                        $agents = getUser('',$enq_details['enq_brand']);
                                                    }else{
                                                        $agents = getUser('','');
                                                    }
                                                    foreach ($agents as $key => $agent) {

                                                        if($enq_details['picked_by'] == $agent['user_name']){

                                                ?>

                                                <a class="dropdown-item active" disabled="disabled"><?php echo $agent['user_name'] ; ?></a>

                                                <?php 

                                                        }else{

                                                ?>

                                                <a class="assigninq dropdown-item" data-inq-id="<?php echo $enq_details['enq_id']; ?>" data-assign-name="<?php echo $agent['user_name'] ; ?>" data-pre-name="<?php echo $enq_details['picked_by'] ; ?>">

                                                    <?php echo $agent['user_name'] ; ?>

                                                </a>

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

                    </div>

                </div>

                <div class="page-body">

                    <div class="container-xl">

                        <div class="row">

                            <div class="col-8"> 

                                <div class="card">

                                    <div class="card-header text-white text-middle" style="background-color: #232e3c;">

                                        <?php if($enq_details['enq_type'] == "Mail"){ ?>

                                        <i class="glyphicon glyphicon-envelope" title="Web Inquiry"></i>&nbsp;

                                        <?php }elseif($enq_details['enq_type'] == "Call"){  ?>

                                        <i class="glyphicon glyphicon-phone" title="Call Received"></i>&nbsp;

                                        <?php }elseif($enq_details['enq_type'] == "Chat"){  ?>

                                        <i class="glyphicon glyphicon-comment" title="Chat"></i>&nbsp;

                                        <?php }elseif($enq_details['enq_type'] == "Whatsapp"){  ?>

                                        <i class="glyphicon glyphicon-info-sign" title="Whatsapp"></i>&nbsp;

                                        <?php } ?>

                                        <?php echo str_replace("Flight ","", $enq_details['enq_page'])." - ".bfr_dash($enq_details['enq_dest'])." - ".$enq_details['enq_device'] ; ?>

                                    </div>

                                    <div class="card-body p-0-10"  style="width:100%;height: 375px;display: table;">

                                        <div class="row" style="width:100%;display: table-cell;vertical-align: top;">

                                            <div class="col-lg-12">

                                                <h5 class="p-b-5 font-weight-bold" style="border-bottom: thin solid #bbb"><strong>Enquiry Details - <?php echo $enq_details['enq_id']; ?></strong></h5>

                                                <div class="table-responsive">

                                                    <table cellpadding="0" cellspacing="0" width="100%" style="line-height: 33px;">

                                                        <tbody>

                                                            <tr>

                                                                <td width="30%">From: <span class="font-weight-bold"><?php 

                                                                    echo $enq_details['enq_dept'] ; 

                                                                    ?></span>

                                                                </td>

                                                                <td width="30%">To: <span class="font-weight-bold"><?php 

                                                                    echo $enq_details['enq_dest'] ; ?></span>

                                                                </td>

                                                                <td width="20%">Dept: <span class="font-weight-bold"><?php 

                                                                    echo date("d-M-y",strtotime($enq_details['enq_dept_date'])) ; ?></span>

                                                                </td>

                                                                <td width="20%">Rtrn: <span class="font-weight-bold"><?php 

                                                                    echo($enq_details['enq_tkt_type'] !='Oneway' && $enq_details['enq_rtrn_date'])?date("d-M-y",strtotime($enq_details['enq_rtrn_date'])):'-'; ?></span>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td>Airline: <span class="font-weight-bold"><?php 

                                                                    echo($enq_details['enq_airline'] != '')?$enq_details['enq_airline']:'-'; ?></span>

                                                                </td>

                                                                <td>Price: <span class="font-weight-bold"><?php 

                                                                    echo $enq_details['enq_tkt_price']." &pound;";  ; ?></span>

                                                                </td>

                                                                <td>Type: <span class="font-weight-bold"><?php 

                                                                    echo $enq_details['enq_tkt_type'] ; ?></span>

                                                                </td>

                                                                <td>Class: <span class="font-weight-bold"><?php 

                                                                    echo($enq_details['enq_tkt_class'] != '')?$enq_details['enq_tkt_class']:'-'; ?></span>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td colspan="4">

                                                                    <table cellpadding="0" cellspacing="0" width="100%">

                                                                        <tbody>

                                                                            <tr>

                                                                                <td width="30%">Adult: <span class="font-weight-bold"><?php 

                                                                                    echo $enq_details['enq_adt'] ; ?></span>

                                                                                <td width="30%">Child: <span class="font-weight-bold"><?php

                                                                                    echo $enq_details['enq_chd'] ; ?></span>

                                                                                <td width="40%">Infant: <span class="font-weight-bold"><?php 

                                                                                    echo $enq_details['enq_inf'] ; ?></span>

                                                                            </tr>

                                                                        </tbody>

                                                                    </table>                                                    

                                                                </td>

                                                            </tr>

                                                            <tr><td class="4">&nbsp;</td></tr>

                                                            <tr>

                                                                <td colspan="4">

                                                                    <h5 class="p-b-5 font-weight-bold" style="border-bottom: thin solid #bbb"><strong>Customer Details</strong></h5>

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td colspan="4">

                                                                    <table cellpadding="0" cellspacing="0" width="100%">

                                                                        <tbody>

                                                                            <tr>

                                                                                <td width="30%">Name: <span class="font-weight-bold"><?php 

                                                                                    echo $enq_details['enq_cust_name'] ; ?></span>

                                                                                <td width="30%">Ph #: <span class="font-weight-bold"><?php

                                                                                    echo $enq_details['enq_cust_phone'] ; ?></span>

                                                                                <td width="40%">Email: <span class="font-weight-bold"><?php 

                                                                                    echo $enq_details['enq_cust_email'] ; ?></span>

                                                                            </tr>

                                                                        </tbody>

                                                                    </table>

                                                                </td>

                                                            <tr>

                                                                <td colspan="4">Comment: <span class="font-weight-bold"><?php 

                                                                    echo($enq_details['enq_cust_cmnt'] !='')?$enq_details['enq_cust_cmnt']:'-'; ?></span>

                                                                </td>

                                                            </tr>

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>               

                            </div>

                            <div class="col-4">

                                <div class="card" style="min-height: 420px;">

                                    <div class="card-header text-white font-weight-bold" style="background-color: #232e3c;">Feedback</div>

                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col">

                                                <form id="feedBackForm">

                                                    <input type="hidden" name="enq_id" value="<?php echo $enq_details['enq_id'] ; ?>">

                                                    <div class="form-group mb-1">

                                                        <div class="input-group">

                                                            <textarea name="feedback" rows="2" class="form-control" placeholder="Enter your comment" required data-parsley-errors-messages-disabled></textarea>

                                                            <button class="btnFeedback btn btn-success btn-sm" type="submit">Submit</button>

                                                        </div>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                        <div class="row" id="feedback">

                                            <div class="col-md-12">

                                                <?php

                                                    if(count($enq_feedback) > 0 || $enq_details['enq_feedback'] != ''){

                                                        echo '<hr class="mb-2 mt-2">';

                                                    }

                                                    foreach ($enq_feedback as $key => $feed) {

                                                ?>

                                                <p class="mb-0">

                                                    <strong class="font-weight-bold"><?php echo $feed['cmnt_by'] ; ?> (<?php echo date('d-M-y G:ia',strtotime($feed['cmnt_datetime'])) ; ?>)<br></strong>

                                                    <span class="text-dark"><?php echo $feed['enq_cmnt']; ?></span>

                                                </p>

                                                <?php 

                                                    } 

                                                    if($enq_details['enq_feedback'] != ''){ 

                                                ?>

                                                <p class="mb-0">

                                                    <?php echo nl2br(str_replace("<br><br>","<br>", $enq_details['enq_feedback'])); ?>

                                                </p>

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

            </div>

        </div>

        <?php $this->load->view('common/scripts', @$scripts); ?>

        <div class="modal fade" id="inquiryAlert">

            <div class="modal-dialog modal-md">

                <div class="modal-content">

                    <div class="modal-header">

                        <h4 class="modal-title font-weight-bold">Set Reminder</h4>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                    </div>

                    <div class="modal-body">

                        <form id="inqalertform">

                            <input type="hidden" name="enq_id" value="<?php echo $enq_details['enq_id']; ?>">

                            <input type="hidden" name="alertby" value="<?php echo $this->session->userdata('user_name'); ?>">

                            <div class="row">

                                <div class="col-md-5">

                                    <div class="form-group m-b-5">

                                        <label class="form-label">Date &amp; Time <span class="text-danger">*</span></label>

                                        <div class="controls">

                                            <input type="text" name="alertdatetime" class="datetime form-control" required data-parsley-trigger="focusin focusout" value="">

                                        </div>                                               

                                    </div>

                                </div>

                                <div class="col-md-12">

                                    <div class="form-group m-b-0">

                                        <label class="form-label">Message <span class="text-danger">*</span></label>

                                        <div class="controls">

                                            <textarea name="alertmsg" type="text" rows="5" class="form-control" required></textarea> 

                                        </div>                                               

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>

                        <button type="submit" form="inqalertform" class="inqalertformbtn btn btn-success btn-sm">Set</button>

                    </div>

                </div>

            </div>

        </div>

        <div class="modal fade" id="compAlert">

            <div class="modal-dialog modal-sm">

                <div class="modal-content">

                    <div class="modal-header">

                        <h4 class="modal-title font-weight-bold" id="compAlertLabel1">Complete Reminder</h4>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                    </div>

                    <div class="modal-body">

                        <form id="compalertform">

                            <input type="hidden" name="enq_id" value="<?php echo $enq_alert['enq_id']; ?>">

                            <input type="hidden" name="alert_id" value="<?php echo $enq_alert['id']; ?>">

                            <input type="hidden" name="alertedit_by" value="<?php echo $this->session->userdata('user_name'); ?>">

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="form-group m-b-0">

                                        <label class="form-label">Status <span class="text-danger">*</span></label>

                                        <div class="controls">

                                            <select name="inq_status" class="form-control" required>

                                                <option value="" selected="">Select Status</option>

                                                <option value="Mature">Mature</option>

                                                <option value="Unmature">Unmature</option>

                                            </select>

                                        </div>                                               

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="form-group m-b-0">

                                        <label class="form-label">Message <span class="text-danger">*</span></label>

                                        <div class="controls">

                                            <textarea name="alertmsg" type="text" rows="5" class="form-control" required></textarea> 

                                        </div>                                               

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>

                        <button type="submit" form="compalertform" class="compalertformbtn btn btn-success btn-sm">Submit</button>

                    </div>

                </div>

            </div>

        </div>

        <div class="editalertModal"></div>

    </body>

</html>