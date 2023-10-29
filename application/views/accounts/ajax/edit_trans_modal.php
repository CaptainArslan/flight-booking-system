<div class="modal modal-blur fade EditTransModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold" id="editTransLabel1">Edit Transaction</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col trans_alert">
                        <div class="alert alert-important alert-danger alert-dismissible alert-sm" role="alert">
                            <div class="d-flex">
                                <div><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="9"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg></div>
                                <div class="trans_alert_msg"></div>
                            </div>
                            <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    </div>
                </div>
                <form id="editTransForm">
                    <input type="hidden" name="page" id="page" value="<?php echo $page;?>">
                    <div class="row mb-3">
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Transaction Date:</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text" name="trans_date" id="trans_date" class="date form-control form-control-sm" required value="<?php echo date("d-M-Y",strtotime($trans_details[0]["trans_date"])) ; ?>">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Transaction Id:</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text" name="trans_id" id="trans_id" class="form-control form-control-sm" required value="<?php echo $trans_details[0]["trans_id"] ; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Booking Ref <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="form-label">To (Dr.) <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <h6>&nbsp;</h6>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $counter = 0;
                        $drTotal = 0;
                        foreach ($trans_details as $key => $trans_dtl) {
                            if ($trans_dtl['trans_type'] == 'Cr') {
                                continue;
                            }
                            $drTotal += $trans_dtl['trans_amount'];
                    ?>
                    <div class="row mb-2 mt-2">
                        <div class="col-3">
                            <div class="form-group">
                                <div class="controls">
                                    <input type="number" name="dr[trans_bkg_ref][]" class="form-control " required value="<?php echo $trans_dtl["trans_ref"] ;?>">
                                </div>                                                
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <div class="controls">
                                    <select name="dr[trans_to][]" required class="form-control ">
                                        <option value="">Select Transaction Head</option>
                                        <?php 
                                            foreach ($trans_head as $key => $trans) {
                                        ?>
                                        <option value="<?php echo $trans['trans_head'] ; ?>" <?php echo($trans_dtl["trans_head"] == $trans['trans_head'])?"selected":""; ?>><?php echo $trans['trans_head'] ; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <div class="controls">
                                    <input type="number" step=0.01 name="dr[amount][]" class="dramt form-control " required value="<?php echo $trans_dtl["trans_amount"] ;?>" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <div class="controls">
                                    <?php if ($counter < 1) { ?>
                                    <a id="addTransDr" class="btn btn-sm btn-outline-info">+</a>
                                    <?php }else{ ?>
                                    <button type="button" class="btn btn-sm btn-success deleteTransDr">x</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $counter++; } ?>
                    <div class="ExtratransDr"></div>
                    <div class="row">
                        <div class="offset-8 col-4">
                            <div class="form-group  m-t-10">
                                <label class="form-label">Dr. Amount: 
                                    <span class="text-danger">&pound; <span class="totaldramt"><?php echo number_format($drTotal,2); ?></span></span>
                                    <input type="hidden" name="dr_total_amount" value="<?php echo number_format($drTotal,2); ?>" id="dr_total_amount">
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-2 mt-2">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Booking Ref <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="form-label">To (Cr.) <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <h6>&nbsp;</h6>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $counter = 0;
                        $crTotal = 0;
                        foreach ($trans_details as $key => $trans_dtl) {
                            if ($trans_dtl['trans_type'] == 'Dr') {
                                continue;
                            }
                            $crTotal += $trans_dtl['trans_amount'];
                    ?>
                    <div class="row mb-2 mt-2">
                        <div class="col-3">
                            <div class="form-group">
                                <div class="controls">
                                    <input type="number" name="cr[trans_bkg_ref][]" class="form-control " required value="<?php echo $trans_dtl["trans_ref"] ;?>">
                                </div>                                                
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <div class="controls">
                                    <select name="cr[trans_by][]" required class="form-control ">
                                        <option value="">Select Transaction Head</option>
                                        <?php 
                                            foreach ($trans_head as $key => $trans) {
                                        ?>
                                        <option value="<?php echo $trans['trans_head'] ; ?>" <?php echo($trans_dtl["trans_head"] == $trans['trans_head'])?"selected":""; ?>><?php echo $trans['trans_head'] ; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <div class="controls">
                                    <input type="number" step=0.01 name="cr[amount][]" class="cramt form-control " required autocomplete="off" value="<?php echo $trans_dtl["trans_amount"] ;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <div class="controls">
                                    <?php if ($counter < 1) { ?>
                                    <a id="addTransCr" class="btn btn-sm btn-outline-info">+</a>
                                    <?php }else{ ?>
                                    <button type="button" class="btn btn-sm btn-success deleteTransCr">x</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $counter++; } ?>
                    <div class="ExtratransCr"></div>
                    <div class="row">
                        <div class="offset-8 col-4">
                            <div class="form-group  m-t-10">
                                <label class="form-label">Cr. Amount: 
                                    <span class="text-danger">&pound; <span class="totalcramt"><?php echo number_format($crTotal,2); ?></span></span>
                                    <input type="hidden" name="cr_total_amount" value="<?php echo number_format($crTotal,2); ?>" id="cr_total_amount">
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-2 mt-2">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group ">
                                <label class="form-label">Authorization <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="auth_code" class="form-control " value="<?php echo $trans_details[0]['t_card']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group ">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="trans_desc" required class="form-control "   value="<?php echo $trans_details[0]['trans_description']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer trans_actions">
                <div class="row w-100">
                    <div class="col">
                    <?php if(checkAccess($this->session->userdata('user_role'),'delete_transaction')){ ?>
                        <button type="button" data-trans-id="<?php echo $trans_details[0]["trans_id"];?>" data-page="<?php echo $page;?>" class="deleteTrans btn btn-danger font-weight-600 btn-sm" >Delete</button>
                    <?php } ?>
                    </div>
                    <div class="col text-center">
                        <button type="button" class="formClose btn btn-warning font-weight-600 btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                    <div class="col text-right">
                    <?php if(checkAccess($this->session->userdata('user_role'),'edit_transaction')){ ?>
                        <button id="EditSubmitBtn" class="btn btn-success font-weight-600 btn-sm" type="submit" form="editTransForm">Submit</button>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>