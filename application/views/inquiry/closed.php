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
                                <div class="card card-body nopadding">
                                    <div class="table-responsive">
                                        <table id="closed_inq" class="table full-color-table full-info-table hover-table">
                                            <thead>
                                                <?php
                                                    if(checkAccess($user_role,'admin_view_new_inq')){
                                                ?>
                                                <tr>
                                                    <th class="align-middle text-center" width="06%">#</th>
                                                    <th class="align-middle text-center" width="13%">Date</th>
                                                    <th class="align-middle text-center" width="06%">Id</th>
                                                    <th class="align-middle text-center" width="10%">Dept Date</th>
                                                    <th class="align-middle text-center" width="38%">Details</th>
                                                    <th class="align-middle text-center" width="18%">Feed Back</th>
                                                    <th class="align-middle text-center" width="09%">Picked By</th>
                                                </tr>
                                                <?php }else{ ?>
                                                <tr>
                                                    <th class="align-middle text-center" width="05%">#</th>
                                                    <th class="align-middle text-center" width="16%">Date</th>
                                                    <th class="align-middle text-center" width="07%">Id</th>
                                                    <th class="align-middle text-center" width="12%">Dept Date</th>
                                                    <th class="align-middle text-center" width="50%">Details</th>
                                                    <th class="align-middle text-center" width="10%">Status</th>
                                                </tr>
                                                <?php } ?>
                                            </thead>
                                            <?php 
                                                if(checkAccess($user_role,'admin_view_new_inq')){
                                            ?>
                                            <tbody>
                                                <?php
                                                    $sr = 1;
                                                    if(count($closed_inq) > 0){
                                                        foreach ($closed_inq as $key => $inq) {
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
                                                    <td class="text-center align-middle" data-order="<?php echo $sr; ?>"><?php echo $sr; ?></td>
                                                    <td class="text-center align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo date("d-M-Y h:i A",$date) ; ?>" data-order="<?php echo date("d-M-Y h:i A",$date) ; ?>">
                                                        <?php
                                                            echo date('d-M h:i A',$date);
                                                        ?>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <a target="_blank" href="<?php echo base_url("inquiry/view/".hashing($inq['enq_id'])) ; ?>" class="text-blue font-weight-600">
                                                            <?php echo $inq['enq_id'] ; ?>
                                                        </a>
                                                    </td>
                                                    <td class="text-center align-middle" data-order="<?php echo date("d-M-y",strtotime($cust_dept_date)); ?>">
                                                        <?php echo $cust_dept_date ; ?>
                                                    </td>
                                                    <td class="text-left align-middle">
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
                                                    <td class="text-left align-middle" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $lastCmnt ;?>" data-order="<?php echo $lastCmnt; ?>" data-search="<?php echo $lastCmnt; ?>">
                                                        <?php 
                                                            custom_echo($lastCmnt,10);                                       
                                                        ?>
                                                    </td>
                                                    <td class="text-center align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $inq['picked_by'] ; ?>" data-order="<?php echo $inq['picked_by'] ; ?>">
                                                        <?php 
                                                            echo($inq['picked_by'] != '')?remove_space($inq['picked_by']):'-';
                                                        ?>
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
                                                    if(count($closed_inq) > 0){
                                                        foreach ($closed_inq as $key => $inq) {
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
                                                    <td class="text-center align-middle" data-order="<?php echo $sr; ?>">
                                                        <?php echo $sr; ?>
                                                    </td>
                                                    <td class="text-center align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo date("d-M-Y h:i A",$date) ; ?>" data-order="<?php echo date("d-M-Y h:i A",$date) ; ?>">
                                                        <?php
                                                            echo date('d-M h:i A',$date);
                                                        ?>
                                                    </td>
                                                    <td class="text-center align-middle" data-order="<?php echo $inq['enq_id']; ?>">
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
                                                    <td class="text-center align-middle" data-order="<?php echo date("d-M-y",strtotime($cust_dept_date)); ?>">
                                                        <?php echo $cust_dept_date ; ?>
                                                    </td>
                                                    <td class="text-left align-middle">
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
                                                    <td class="text-center align-middle" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $inq['enq_status'] ; ?>">
                                                        <?php 
                                                            echo $inq['enq_status'] ;
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
        <?php $this->load->view('common/scripts', @$scripts); ?>
    </body>
</html>