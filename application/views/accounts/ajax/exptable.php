<div class="card-header bg-danger">
    <div class="row">
        <div class="col-md-12">
            <h4 class="card-title m-t-5 m-b-0 text-white"><?php echo $trans_head ; ?></h4>
        </div>
    </div>
</div>
<div class="card-body p-0-0">
    <div class="table-responsive">
        <table id="expendse_table" class="table-striped table led-table-bg m-b-0 font-weight-400">
            <thead>
                <tr>
                    <th width="10%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white sortBal">Date</th>
                    <th width="10%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white sortBal">Ref.</th>
                    <th width="20%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white sortBal">By/To</th>
                    <th width="25%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white">Note</th>
                    <th width="10%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white sortBal">Dr.</th>
                    <th width="10%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white sortBal">Cr.</th>
                    <th width="12%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white">Bal.</th>
                    <th width="03%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white">-</th>
                </tr>
            </thead>
            <tbody>
                <tr class="fixed" bgcolor="#eee">
                    <th class="p-l-0 p-r-0 text-center text-middle"><?php echo date('d-M-y',strtotime($start_date)) ; ?></th>
                    <th colspan="2" class="p-l-0 p-r-0 text-center text-middle">&nbsp;</th>
                    <th class="p-l-0 p-r-0 text-center text-middle" style="display: none;">&nbsp;</th>
                    <th colspan="3" class="p-l-0 p-r-0 text-center text-middle font-weight-600">Opening Balance</th>
                    <th class="p-l-0 p-r-0 text-center text-middle" style="display: none;">&nbsp;</th>
                    <th class="p-l-0 p-r-0 text-center text-middle" style="display: none;">&nbsp;</th>
                    <th class="p-l-0 p-r-0 text-center text-middle openingBalance"><?php echo $opening_balance  ; ?></th>
                    <th class="p-l-0 p-r-0 text-center text-middle">&nbsp;</th>
                </tr>
                <?php
                    $endBalance = $opening_balance;
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
                    <td class="p-0-3 text-center text-middle"><?php echo date('d-M-y',strtotime($ledg_row['trans_date'])); ?></td>
                    <td class="p-0-3 text-center text-middle">
                        <?php 
                            if(checkAccess($user_role,'view_booking_page')){
                                if($ledg_row['trans_ref'] != 0){
                        ?>
                        <a class="text-blue font-weight-500" href="<?php echo base_url("booking/pending/".hashing($ledg_row['trans_ref'])); ?>"><?php echo(is_null($ledg_row['brand_pre_post_fix']))?$ledg_row['trans_ref']:$ledg_row['brand_pre_post_fix']."-".$ledg_row['trans_ref'] ; ?></a>
                        <?php 
                                }else{ 
                                    echo '-';
                                }
                            }else if($ledg_row['trans_ref'] != 0){
                                echo(is_null($ledg_row['brand_pre_post_fix']))?$ledg_row['trans_ref']:$ledg_row['brand_pre_post_fix']."-".$ledg_row['trans_ref'] ;
                            }else{
                                echo "-";
                            }
                        ?>
                    </td>
                    <td class="p-0-3 text-center text-middle" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $ledg_row['trans_by_to'] ;?>"><?php custom_echo($ledg_row['trans_by_to'],20) ; ?></td>
                    <td class="p-0-3 text-center text-middle" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $ledg_row['trans_description']) ;?>"><?php echo preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $ledg_row['trans_description']) ; ?> <small class="text-success font-weight-600">(<?php echo getinitials($ledg_row['trans_created_by']); ?>)</small></td>
                    <td class="p-0-3 text-center text-middle dramt"><?php echo($dr_amt!= '')?number_format($dr_amt,2):''; ?></td>
                    <td class="p-0-3 text-center text-middle dramt"><?php echo($cr_amt!= '')?number_format($cr_amt,2):''; ?></td>
                    <td class="p-0-3 text-center text-middle balance"><?php echo number_format($endBalance,2) ?></td>
                    <td class="p-0-3 text-center text-middle">
                        <?php if(checkAccess($user_role,'edit_transaction')){ ?>
                        <a class="edittrans text-danger" data-trans-id="<?php echo $ledg_row['trans_id']; ?>" data-page="expenses"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg></a>
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