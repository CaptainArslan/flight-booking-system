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
                                <div class="card card-body">
                                    <form id="trialBalForm" autocomplete="off">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="p-0 col-3 col-form-label font-weight-600 text-center">From</label>
                                                    <div class="col-9">
                                                        <input name="start_date" class="date form-control form-control-sm" type="text" value="01-Jan-2010" placeholder="Enter Start Date" required onchange="trialBalFormsubmit();">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="p-0 col-3 col-form-label font-weight-600 text-center">To</label>
                                                    <div class="col-9">
                                                        <input name="end_date" class="date form-control form-control-sm" type="text" value="<?php echo $edate ; ?>" placeholder="Enter End Date" required onchange="trialBalFormsubmit();">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <button class="trialBalFormbtn btn btn-sm btn-success" type="submit">Submit</button>
                                            </div>
                                        </div>            
                                    </form>
                                </div>
                                <div class="card trialbalancedetails mt-3">
                                    <div class="table-responsive mb-0">
                                        <table id="tb_table" class="table-striped table led-table-bg" style="font-weight: 300 !important;letter-spacing: 1.1px !important">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <th width="5%" class="text-center text-white">#</th>
                                                    <th width="45%" class="text-center text-white">Head</th>
                                                    <th width="25%" class="text-center text-white">Dr.</th>
                                                    <th width="25%" class="text-center text-white">Cr.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $srn = 1;
                                                    $drtotal = 0;
                                                    $crtotal = 0;
                                                    foreach($thobal as $k => $v) {
                                                        if(round(abs($v)) == 0){
                                                            continue;
                                                        }
                                                ?>
                                                <tr>
                                                    <td class=" text-center text-middle"><?php echo $srn; ?></td>
                                                    <td class=" text-left text-middle"><?php echo substr($k,1); ?></td>
                                                    <td class=" text-center text-middle">
                                                        <?php 
                                                            if($v >= 0){ 
                                                                echo number_format(round(abs($v),2),2); 
                                                                $drtotal = (double)round($drtotal,2) + (double)round($v,2);
                                                            }else{
                                                                echo "-";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class=" text-center text-middle">
                                                        <?php 
                                                            if($v <= 0){ 
                                                                echo number_format(round(abs($v),2),2); 
                                                                $crtotal = (double)round($crtotal,2) + (double)round($v,2);
                                                            }else{
                                                                echo "-";
                                                            } 
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php 
                                                    $srn++;
                                                    } 
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>
                                                        <table cellpadding="0" cellspacing="0" width="100%">
                                                            <tr style="border-bottom: 0 !important;background: #ffffff !important;">
                                                                <th style="padding: 0px; border: none !important;">
                                                                    <?php 
                                                                        $balance = 0;
                                                                        $balance = round(abs($drtotal),2)-round(abs($crtotal),2);
                                                                        if($balance !=0){ 
                                                                    ?>
                                                                    Variance: <?php echo number_format(round($balance,2),2) ; ?>
                                                                    <?php } ?>
                                                                </th>
                                                                <th style="padding: 0px; border: none !important;" class="text-right">Total</th>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                    <th class="text-center text-middle"><?php echo number_format(round($drtotal,2),2); ?></th>
                                                    <th class="text-center text-middle"><?php echo number_format(round(abs($crtotal),2),2); ?></th>
                                                </tr>
                                            </tfoot>
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