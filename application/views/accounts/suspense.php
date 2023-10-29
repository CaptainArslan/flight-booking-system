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
                                <div class="card">
                                    <div class="table-responsive">
                                        <table id="suspense_table" class="table-striped table led-table-bg m-b-0">
                                            <thead>
                                                <tr>
                                                    <th width="10%" class="text-center text-white">Date</th>
                                                    <th width="25%" class="text-center text-white">By/To</th>
                                                    <th width="30%" class="text-center text-white">Note</th>
                                                    <th width="10%" class="text-center text-white">Dr.</th>
                                                    <th width="10%" class="text-center text-white">Cr.</th>
                                                    <th width="10%" class="text-center text-white">Bal.</th>
                                                    <th width="05%" class="text-center text-white">-</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $endBalance = 0;
                                                    $total_dr = 0;
                                                    $total_cr = 0;
                                                    foreach ($ledg_rows as $key => $ledg_row) {
                                                        $dr_amt = '';
                                                        $cr_amt = '';
                                                        if($ledg_row['trans_type']=="Cr"){
                                                            $cr_amt = $ledg_row['trans_amount'];
                                                            $total_cr += $cr_amt;
                                                            $endBalance = $endBalance - $ledg_row['trans_amount'];
                                                        }elseif($ledg_row['trans_type']=="Dr"){
                                                            $dr_amt = $ledg_row['trans_amount'];
                                                            $total_dr += $dr_amt;
                                                            $endBalance = $endBalance + $ledg_row['trans_amount'];
                                                        }

                                                ?>
                                                <tr>
                                                    <td class="p-0-3 text-center text-middle">
                                                        <?php echo date('d-M-y',strtotime($ledg_row['trans_date'])); ?>
                                                    </td>
                                                    <td class="p-0-3 text-center text-middle" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $ledg_row['trans_by_to'] ;?>">
                                                        <?php custom_echo($ledg_row['trans_by_to'],20) ; ?>
                                                    </td>
                                                    <td class="p-0-3 text-center text-middle" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $ledg_row['trans_description'] ;?>">
                                                        <?php echo $ledg_row['trans_description'] ; ?>
                                                    </td>
                                                    <td class="p-0-3 text-center text-middle dramt">
                                                        <?php echo($dr_amt!= '')?number_format($dr_amt,2):''; ?>
                                                    </td>
                                                    <td class="p-0-3 text-center text-middle dramt">
                                                        <?php echo($cr_amt!= '')?number_format($cr_amt,2):''; ?>
                                                    </td>
                                                    <td class="p-0-3 text-center text-middle balance">
                                                        <?php echo number_format($endBalance,2) ?>
                                                    </td>
                                                    <td class="p-0-3 text-center text-middle">
                                                        <?php if(checkAccess($user_role,'edit_transaction')){ ?>
                                                        <a class="bkgEditTrans text-danger" data-trans-id="<?php echo $ledg_row['trans_id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg></a>
                                                        <?php }else{ ?>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="p-l-0 p-r-0 text-center text-middle">&nbsp;</th>
                                                    <th class="p-l-0 p-r-0 text-center text-middle">&nbsp;</th>
                                                    <th class="text-right">Total</th>
                                                    <th class="p-l-0 p-r-0 text-center"><?php echo number_format($total_dr,2) ?></th>
                                                    <th class="p-l-0 p-r-0 text-center"><?php echo number_format($total_cr,2) ?></th>
                                                    <th class="p-l-0 p-r-0 text-center"><?php echo number_format($endBalance,2) ?></th>
                                                    <th></th>
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
        <div class="ptasktrans"></div>
        <div class="edittransaction"></div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
    </body>
</html>