<div class="card">
    <div class="card-body p-0-0">
        <h4 class="card-title text-cyan">Booking Search Results By <span class="text-danger"><?php echo getfieldName($searchby); ?></span></h4>
        <div class="table-responsive">
            <table id="pendingPayments" class="table full-color-table full-info-table hover-table m-b-0">
                <thead>
                    <tr>
                        <th class="text-center align-middle" rowspan="2" width="04%">#</th>
                        <th class="text-center align-middle" rowspan="2" width="10%">Booking<br>Date</th>
                        <th class="text-center align-middle" rowspan="2" width="10%">Travel<br>Date</th>
                        <th class="text-center align-middle" rowspan="2" width="07%">Ref. No.</th>
                        <th class="text-center align-middle" rowspan="2" width="10%">Sup. Ref.</th>
                        <th class="text-center align-middle" rowspan="2" width="14%">Customer Name</th>
                        <th class="text-center align-middle" rowspan="2" width="10%">Cancellation<br>Date</th>
                        <th class="text-center align-middle" rowspan="2" width="09%">Issuance<br>Date</th>
                        <th class="text-center align-middle" rowspan="2" width="08%">Brand</th>
                        <th class="text-center align-middle" rowspan="2" width="08%">Agent</th>
                        <th class="text-center align-middle" rowspan="2" width="10%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sr = 1;
                        if(count($results) > 0){
                            foreach ($results as $key => $result) {
                                if($result['bkg_status'] == 'Cancelled Pending'){
                                    $status = 'Pending';
                                }else if($result['bkg_status'] == 'Cleared'){
                                    $status = 'Issued';
                                }else{
                                    $status = $result['bkg_status'];
                                }
                    ?>
                    <tr style="border-bottom: thin dotted #039be0;">
                        <td class="text-center"><?php echo $sr; ?></td>
                        <td class="text-center"><?php echo date('d-M-y',strtotime($result['bkg_date'])) ; ?></td>
                        <td class="text-center"><?php echo date('d-M-y',strtotime($result['flt_departuredate'])) ; ?></td>
                        <td class="text-center">
                            <a class="font-weight-600" target="_blank" href="<?php echo base_url("booking/".$status."/".hashing($result['bkg_no'])) ; ?>"><?php echo $result['bkg_no'] ; ?></a>
                        </td>
                        <td class="text-center"><?php echo $result['bkg_supplier_reference'] ; ?></td>
                        <td class="text-left"><?php custom_echo($result['cst_name'],13); ?></td>
                        <td class="text-center"><?php echo($result['cnl_date'] == "0000-00-00" || $result['cnl_date'] == '')?'-':date('d-M-y',strtotime($result['cnl_date'])); ?></td>
                        <td class="text-center"><?php echo($result['clr_date'] == "0000-00-00" || $result['clr_date'] == '')?'-':date('d-M-y',strtotime($result['clr_date'])); ?></td>
                        <td><?php remove_space($result['bkg_brandname']); ?></td>
                        <td><?php remove_space($result['bkg_agent']) ; ?></td>
                        <td><?php echo $result['bkg_status'] ; ?></td>
                    </tr>
                    <?php 
                            $sr++;
                            }
                        }else{
                    ?>
                    <tr style="border-bottom: thin dotted #039be0;">
                        <td colspan="11" class="text-center">No Result Found...!!!</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>