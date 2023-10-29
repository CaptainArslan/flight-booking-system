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
                                <a href="<?php echo base_url('accounts/new_transaction') ; ?>" class="btn btn-sm btn-success">Add Transaction</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col">
                                <div class="card card-body mb-4">
                                    <form id="expendseForm" autocomplete="off">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group m-b-0 row">
                                                    <label for="example-text-input" class="p-0 col-3 col-form-label font-weight-600 text-center">From</label>
                                                    <div class="col-9">
                                                        <input name="start_date" class="date form-control form-control-sm" type="text" value="<?php echo date('01-M-Y'); ?>" placeholder="Enter Start Date" required onchange="expendseFormsubmit();" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-b-0 row">
                                                    <label for="example-text-input" class="p-0 col-3 col-form-label font-weight-600 text-center">To</label>
                                                    <div class="col-9">
                                                        <input name="end_date" class="date form-control form-control-sm" type="text" value="<?php echo date('d-M-Y'); ?>" placeholder="Enter End Date" required onchange="expendseFormsubmit();" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group m-b-0 row">
                                                    <label for="example-text-input" class="p-0 col-3 col-form-label font-weight-600 text-center">Head</label>
                                                    <div class="col-9">
                                                        <select class="form-control form-control-sm" name="trans_head" id="trans_head" required onchange="expendseFormsubmit();">
                                                            <option selected="">Choose...</option>
                                                            <?php 
                                                                foreach ($trans_head as $key => $head) {
                                                            ?>
                                                            <option value="<?php echo $head['head'] ; ?>"><?php echo $head['head'] ; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                    <button class="expendseFormbtn btn btn-sm btn-success" type="submit">Submit</button>
                                            </div>
                                        </div>            
                                    </form>
                                </div>
                                <div class="card expendsedetails"></div>
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