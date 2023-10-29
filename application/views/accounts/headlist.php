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
                <div class="page-header bg-white m-0 pt-2 pb-2">
                    <div class="container-xl">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <!-- <div class="page-pretitle"><?php echo($this->user_brand == 'All')?'All Brands':$this->user_brand; ?></div> -->
                                <h2 class="page-title"><?php echo $head['page_title']?></h2>
                            </div>
                            <div class="col-auto ms-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <form method="get" action="">
                                            <div class="form-group row">
                                                <label class="col-auto p-0 m-0 form-label text-center">Sort By</label>
                                                <div class="col">
                                                    <select name="sort_by" class="form-control form-control-sm" onchange="this.form.submit();">
                                                        <option value="">Select Sort By</option>
                                                        <option <?php echo($_REQUEST['sort_by']='trans_head')?'selected':''; ?> value="trans_head">Head Name</option>
                                                        <option <?php echo($_REQUEST['sort_by']='trans_head_mode')?'selected':''; ?> value="trans_head_mode">Head Mode</option>
                                                        <option <?php echo($_REQUEST['sort_by']='owner')?'selected':''; ?> value="owner">Head Owner</option>
                                                        <option <?php echo($_REQUEST['sort_by']='type')?'selected':''; ?> value="type">Head Type</option>
                                                        <option <?php echo($_REQUEST['sort_by']='trans_head_status')?'selected':''; ?> value="trans_head_status">Head Status</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <button type="button" class="addHead btn btn-sm btn-info">Add Heads</button>
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
                                <div class="card card-body">
                                    <div class="table-responsive">
                                        <table id="acccount_heads" class="table-striped table led-table-bg m-b-0" style="letter-spacing: 1.1px !important;font-weight: 300 !important;font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th width="04%" rowspan="2" class="text-center align-middle text-white">#</th>
                                                    <th width="17%" rowspan="2" class="text-center align-middle text-white">Head Name</th>
                                                    <th width="7%" rowspan="2" class="text-center align-middle text-white">Mode</th>
                                                    <th width="14%" rowspan="2" class="text-center align-middle text-white">Head Owner</th>
                                                    <th width="10%" rowspan="2" class="text-center align-middle text-white">Head Type</th>
                                                    <th colspan="5" ="2" class="text-center align-middle text-white">Charges</th>
                                                    <th width="7%" rowspan="2" class="text-center align-middle text-white">Status</th>
                                                    <th width="04%" rowspan="2" class="text-center align-middle text-white">-</th>
                                                </tr>
                                                <tr>
                                                    <th width="10%" class="text-center align-middle text-white">Brand</th>
                                                    <th width="09%" class="text-center align-middle text-white">Agent</th>
                                                    <th width="06%" class="text-center align-middle text-white">Dr.</th>
                                                    <th width="06%" class="text-center align-middle text-white">Cr.</th>
                                                    <th width="06%" class="text-center align-middle text-white">Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sr =1;
                                                    $counter = 0;
                                                    foreach ($heads as $key => $head) {
                                                        $counter++;
                                                        $hd = $head['trans_head'];
                                                        if($head['type'] == 1){
                                                            $head_type = 'Asset / Liab';
                                                        }else if($head['type'] == 2){
                                                            $head_type = 'Cust / Supp';
                                                        }else if($head['type'] == 3){
                                                            $head_type = 'Expenditures';
                                                        }else if($head['type'] == 4){
                                                            $head_type = 'Income';
                                                        }else if($head['type'] == 5){
                                                            $head_type = 'Charges';
                                                        }else if($head['type'] == 6){
                                                            $head_type = 'Suspense';
                                                        }
                                                        if($head['trans_head_status'] == 1){
                                                            $status = 'Active';
                                                            $color = 'success';
                                                        }else{
                                                            $status = 'Inactive';
                                                            $color = 'danger';
                                                        }
                                                        if($counter == 1){
                                                            $newheads[$hd]['head_mode'] = $head['trans_head_mode'];
                                                            $newheads[$hd]['head_owner'] = $head['owner'];
                                                            $newheads[$hd]['type'] = $head_type;                                
                                                            $newheads[$hd]['status'] = $status;                                
                                                            $newheads[$hd]['color'] = $color;                                
                                                            $newheads[$hd]['rowspan'] = 1;
                                                        }else{
                                                            foreach ($newheads as $key2 => $headdetails) {
                                                                if($key2 == $hd){
                                                                    $newheads[$key2]['rowspan'] = $headdetails['rowspan']+1;      
                                                                }else{
                                                                    $newheads[$hd]['head_mode'] = $head['trans_head_mode'];
                                                                    $newheads[$hd]['head_owner'] = $head['owner'];
                                                                    $newheads[$hd]['type'] = $head_type;                                
                                                                    $newheads[$hd]['status'] = $status;                                
                                                                    $newheads[$hd]['color'] = $color;                                
                                                                    $newheads[$hd]['rowspan'] = 1;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    if(count($newheads) > 0){
                                                        foreach ($newheads as $keyhead => $newhead) {
                                                                $rows = $newhead['rowspan'];                                        
                                                ?>
                                                <tr>
                                                    <td rowspan="<?php echo $rows; ?>" class="text-center align-middle" ><?php 
                                                        echo  $sr;
                                                    ?></td>
                                                    <td rowspan="<?php echo $rows; ?>" class="text-left align-middle" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo $keyhead; ?>"><?php 
                                                        custom_echo($keyhead,18);
                                                    ?></td>
                                                    <td rowspan="<?php echo $rows; ?>" class="text-center align-middle" ><?php 
                                                        echo  $newhead['head_mode'];
                                                    ?></td>
                                                    <td rowspan="<?php echo $rows; ?>" class="text-left align-middle" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo $newhead['head_owner']; ?>"><?php 
                                                        custom_echo($newhead['head_owner'],12);
                                                    ?></td>
                                                    <td rowspan="<?php echo $rows; ?>" class="text-center align-middle" ><?php echo $newhead['type'];?></td>
                                                    <?php 
                                                        $chrg_type = $chrg_brand = $chrg_agent = $dr_charges = $cr_charges = '-';
                                                        $rep_counter = 0;
                                                        foreach ($heads as $key => $head) {
                                                            if($head['trans_head'] == $keyhead){
                                                                if($head['id'] != NULL){
                                                                    if($head['charges_type'] == 'percentage'){
                                                                        $chrg_type = '%';
                                                                    }else{
                                                                        $chrg_type = 'Fixed';
                                                                    }
                                                                    if($head['brand_name'] == NULL){
                                                                        $chrg_brand = 'All';
                                                                    }else{
                                                                        $chrg_brand = bfr_space($head['brand_name']);
                                                                    }
                                                                    if($head['agent_name'] == NULL){
                                                                        $chrg_agent = 'All';
                                                                    }else{
                                                                        $chrg_agent = bfr_space($head['agent_name']);
                                                                    }
                                                                    if($head['dr_charges'] != NULL){
                                                                        $dr_charges = '<svg xmlns="http://www.w3.org/2000/svg" class="icon text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Charges On Debit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="8" y1="12" x2="12" y2="16" /><line x1="12" y1="8" x2="12" y2="16" /><line x1="16" y1="12" x2="12" y2="16" /></svg>'.$head['dr_charges'] ;
                                                                    }
                                                                    if($head['cr_charges'] != NULL){
                                                                        $cr_charges = '<svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Charges On Credit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="8" y2="12" /><line x1="12" y1="8" x2="12" y2="16" /><line x1="16" y1="12" x2="12" y2="8" /></svg>'.$head['cr_charges']; 
                                                                    }
                                                                }
                                                                if($rep_counter > 0){
                                                                    echo "</tr><tr>";
                                                                }

                                                    ?>
                                                    <td rowspan="1" class="text-center align-middle" ><?php echo $chrg_brand; ?></td>
                                                    <td rowspan="1" class="text-center align-middle" ><?php echo $chrg_agent; ?></td>
                                                    <td rowspan="1" class="text-center align-middle" ><?php echo $dr_charges ; ?></td>
                                                    <td rowspan="1" class="text-center align-middle" ><?php echo $cr_charges; ?></td>
                                                    <td rowspan="1" class="text-center align-middle" ><?php echo $chrg_type; ?></td>
                                                    <td rowspan="1" class="font-weight-600 text-center align-middle text-<?php echo  $newhead['color']?>" ><?php 
                                                            echo $newhead['status'];
                                                        ?></td>
                                                    <td rowspan="1" class="text-center align-middle font-weight-600" >
                                                        <div class="btn-group">
                                                            <a class="edithead btn btn-sm btn-success p-1" data-transhead="<?php echo $keyhead; ?>">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                                                            </a>
                                                            <?php
                                                                if(!is_transhead($keyhead)){
                                                            ?>
                                                            <a class="deletehead btn btn-sm btn-danger p-1" data-transhead="<?php echo $keyhead; ?>">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                            </a>
                                                            <?php }else{ ?>
                                                                <button type="button" class="btn btn-sm" disabled>
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                                </button>
                                                            <?php } ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                    <?php    
                                                            $rep_counter++;
                                                            }
                                                        }
                                                    ?>
                                                <?php 
                                                        $sr++;
                                                        } 
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
        <div class="addheadmodal"></div>
        <div class="editheadmodal"></div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
    </body>
</html>