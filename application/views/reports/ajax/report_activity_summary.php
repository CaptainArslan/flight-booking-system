<div class="card-header bg-danger">
    <div class="row">
        <div class="col-md-12">
            <h4 class="card-title text-white"><?php echo getrptname($report); ?></h4>
        </div>
    </div>
</div> 
<div class="card card-body">
    <div class="table-responsive">
        <table class="table led-table-bg" style="width: 50%;margin: 0px 0px 10px 10px;">
            <thead>
                <tr>
                    <td colspan="3" style="padding:5px !important;border: none;font-size: 18px;font-weight: 500;">Finances</td>
                </tr>
                <tr>
                    <th width="34%" class="text-center align-middle text-white">Head</th>
                    <th width="33%" class="text-center align-middle text-white">In</th>
                    <th width="33%" class="text-center align-middle text-white">Out</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $finances = $report_details['finances'];
                    $total_in = 0;
                    $total_out = 0;
                    foreach ($finances as $key => $finance) {
                        $total_in += $finance['amt_in'];
                        $total_out += $finance['amt_out'];
                ?>
                <tr>
                    <td class="text-center align-middle"><?php echo $finance['head'] ; ?></td>
                    <td class="text-center align-middle"><?php echo($finance['amt_in'] != 0)?number_format($finance['amt_in'] ,2):'-'; ?></td>
                    <td class="text-center align-middle"><?php echo($finance['amt_out'] != 0)?number_format($finance['amt_out'],2):'-'; ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center align-middle">Total</th>
                    <th class="text-center align-middle"><?php echo number_format($total_in ,2) ; ?></th>
                    <th class="text-center align-middle"><?php echo number_format($total_out,2) ; ?></th>
                </tr>
            </tfoot>
        </table>
        <table class="table led-table-bg" style="margin:10px !important;width: 98.5% !important;">
            <thead>
                <tr>
                    <td colspan="7" style="padding: 0px 0px 0px 15px;border: none;font-size: 18px;font-weight: 500;">Bookings</td>
                </tr>
                <tr>
                    <th width="16%" class="text-center align-middle text-white">Brands</th>
                    <th width="14%" class="text-center align-middle text-white">New Bookings</th>
                    <th width="14%" class="text-center align-middle text-white">Issued Bookings</th>
                    <th width="14%" class="text-center align-middle text-white">Profit on Issuance</th>
                    <th width="14%" class="text-center align-middle text-white">Cancelled Bookings</th>
                    <th width="14%" class="text-center align-middle text-white">Profit on Cancellation</th>
                    <th width="14%" class="text-center align-middle text-white">Total Profit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $brands = $report_details['brands_activity'];
                    $total_new_bkg = 0;
                    $total_issued_bkg = 0;
                    $total_cancelled_bkg = 0;
                    $total_issuance_profit = 0;
                    $total_cancellation_profit = 0;
                    $total_profit = 0;
                    foreach ($brands as $key => $brand) {
                        $brand_name = $brand['brand_name'];
                        $new_bkg = $brand['total_bkg'];
                        $issued_bkg = $brand['total_issued_bkg'];
                        $cancelled_bkg = $brand['total_cancel_bkg'];
                        $issuance_profit = $brand['total_issued_profit'];
                        $cancellation_profit = $brand['total_cancelled_profit'];
                        $profit = $issuance_profit+$cancellation_profit;
                        $total_new_bkg += $new_bkg;
                        $total_issued_bkg += $issued_bkg;
                        $total_cancelled_bkg += $cancelled_bkg;
                        $total_issuance_profit += round($issuance_profit,2);
                        $total_cancellation_profit += round($cancellation_profit,2);
                        $total_profit += round($profit,2);

                        if($new_bkg==0 && $issued_bkg==0 && $cancelled_bkg==0 && $issuance_profit==0 && $cancellation_profit==0 && $profit==0){
                            continue;
                        }
                ?>
                <tr>
                    <td class="text-center align-middle"><?php echo $brand_name ; ?></td>
                    <td class="text-center align-middle"><?php echo($new_bkg != 0)?$new_bkg:'-'; ?></td>
                    <td class="text-center align-middle"><?php echo($issued_bkg != 0)?$issued_bkg:'-'; ?></td>
                    <td class="text-center align-middle"><?php echo($issuance_profit != 0)?number_format($issuance_profit,2):'-'; ?></td>
                    <td class="text-center align-middle"><?php echo($cancelled_bkg != 0)?$cancelled_bkg:'-'; ?></td>
                    <td class="text-center align-middle"><?php echo($cancellation_profit!=0)?number_format($cancellation_profit,2):'-'; ?></td>
                    <td class="text-center align-middle"><?php echo($profit!=0)?number_format($profit,2):'-'; ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center align-middle">Total</th>
                    <th class="text-center align-middle"><?php echo($total_new_bkg != 0)?$total_new_bkg:'-'; ?></th>
                    <th class="text-center align-middle"><?php echo($total_issued_bkg != 0)?$total_issued_bkg:'-'; ?></th>
                    <th class="text-center align-middle"><?php echo($total_issuance_profit != 0)?number_format($total_issuance_profit,2):'-'; ?></th>
                    <th class="text-center align-middle"><?php echo($total_cancelled_bkg != 0)?$total_cancelled_bkg:'-'; ?></th>
                    <th class="text-center align-middle"><?php echo($total_cancellation_profit!=0)?number_format($total_cancellation_profit,2):'-'; ?></th>
                    <th class="text-center align-middle"><?php echo($total_profit!=0)?number_format($total_profit,2):'-'; ?></th>
                </tr>
            </tfoot>
        </table>
        <table class="table led-table-bg" style="width: 50%;margin: 0px 0px 10px 10px;">
            <thead>
                <tr>
                    <td colspan="3" style="padding:5px !important;border: none;font-size: 18px;font-weight: 500;">Tickets</td>
                </tr>
                <tr>
                    <th width="34%" class="text-center align-middle text-white">Supplier</th>
                    <th width="33%" class="text-center align-middle text-white">No. Of Tickets</th>
                    <th width="33%" class="text-center align-middle text-white">Sale Price</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $tickets = $report_details['tickets'];
                    $total_bkgs = 0;
                    $total_amount = 0;
                    foreach ($tickets as $key => $tkt) {
                        $total_bkgs += $tkt['total_passengers'];
                        $total_amount += $tkt['total_saleprice'];
                ?>
                <tr>
                    <td class="text-center align-middle"><?php echo $tkt['supplier'] ; ?></td>
                    <td class="text-center align-middle"><?php echo($tkt['total_passengers'] != 0)?number_format($tkt['total_passengers'] ,2):'-'; ?></td>
                    <td class="text-center align-middle"><?php echo($tkt['total_saleprice'] != 0)?number_format($tkt['total_saleprice'],2):'-'; ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center align-middle">Total</th>
                    <th class="text-center align-middle"><?php echo number_format($total_bkgs ,2) ; ?></th>
                    <th class="text-center align-middle"><?php echo number_format($total_amount,2) ; ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>