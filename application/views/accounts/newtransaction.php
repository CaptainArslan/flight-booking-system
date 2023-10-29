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
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col">
                                <div class="card p-3">
                                    <div class="card-body">
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
                                        <form id="addTransForm">
                                            <div class="row mb-2">
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <label class="form-label">Transaction Date:</label>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <input type="text" name="trans_date" id="trans_date" class="date form-control form-control-sm" required  value="<?php echo date("d-M-Y"); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row m-t-0">
                                                <div class="col-md-3">
                                                    <div class="form-group ">
                                                        <label class="form-label">Booking Ref <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <input type="number" name="dr[trans_bkg_ref][]" class="form-control" required value="<?php echo @$bkg_no ; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group ">
                                                        <label class="form-label">To (Dr.) <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <select name="dr[trans_to][]" required class="form-control">
                                                                <option value="">Select Transaction Head</option>
                                                                <?php foreach ($trans_head as $key => $trans) { ?>
                                                                <option value="<?php echo $trans['trans_head']; ?>"><?php echo $trans['trans_head']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group ">
                                                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <input type="number" step=0.01 name="dr[amount][]" class="dramt form-control " required value="0.00" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group ">
                                                        <label class="form-label">&nbsp;</label>
                                                        <div class="controls">
                                                            <a id="addTransDr" class="btn btn-sm btn-info text-white">+</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ExtratransDr"></div>
                                            <div class="row m-t-0">
                                                <div class="offset-md-8 col-md-4">
                                                    <div class="form-group m-b-0 m-t-10">
                                                        <label class="form-label">Dr. Amount:
                                                            <span class="text-danger">&pound; <span class="totaldramt">0.00</span></span>
                                                            <input type="hidden" name="dr_total_amount" value="0.00" id="dr_total_amount">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mb-2 mt-2">
                                            <div class="row m-t-0">
                                                <div class="col-md-3">
                                                    <div class="form-group ">
                                                        <label class="form-label">Booking Ref <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <input type="number" name="cr[trans_bkg_ref][]" class="form-control " required value="<?php echo @$bkg_no ; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group ">
                                                        <label class="form-label">To (Cr.) <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <select name="cr[trans_by][]" required class="form-control ">
                                                                <option value="">Select Transaction Head</option>
                                                                <?php
                                                                foreach ($trans_head as $key => $trans) {
                                                                ?>
                                                                    <option value="<?php echo $trans['trans_head']; ?>">
                                                                        <?php echo $trans['trans_head']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group ">
                                                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <input type="number" step=0.01 name="cr[amount][]" class="cramt form-control" required value="0.00" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group ">
                                                        <label class="form-label">&nbsp;</label>
                                                        <div class="controls">
                                                            <a id="addTransCr" class="btn btn-sm btn-info text-white">+</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ExtratransCr"></div>
                                            <div class="row m-t-0">
                                                <div class="offset-md-8 col-md-4">
                                                    <div class="form-group m-b-0 m-t-10">
                                                        <label class="form-label">Cr. Amount:
                                                            <span class="text-danger">&pound; <span class="totalcramt">0.00</span></span>
                                                            <input type="hidden" name="cr_total_amount" value="0.00" id="cr_total_amount">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mb-2 mt-2">
                                            <div class="row m-t-0">
                                                <div class="col-md-3">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">Authorization <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <input type="text" name="auth_code" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">Description <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <input type="text" name="trans_desc" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-12 text-center">
                                                    <button id="addtrnsBtn" class="btn btn-success btn-sm" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ptasktrans"></div>
        <div class="edittransaction"></div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
    </body>
</html>