<div class="card">
    <div class="card-header bg-danger">
        <div class="row w-100">
            <div class="col-auto">
                <h4 class="card-title text-white"><?php echo getrptname($report); ?></h4>
            </div>
            <div class="col-auto ms-auto">
                <button class="exportexcel btn btn-sm btn-warning">Export to Excel</button>
            </div>
        </div>
    </div> 
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="report_table" class="table">
                <thead>
                    <tr bgcolor="#fff">
                        <td colspan="10" style="padding: 10px !important;border: none;font-size: 16px;font-weight: 500;">
                            Issued Bookings
                        </td>
                    </tr>
                    <tr>
                        <th width="05%" class="text-center align-middle text-white">#</th>
                        <th width="08%" class="text-center align-middle text-white">Issue</th>
                        <th width="08%" class="text-center align-middle text-white">Agent</th>
                        <th width="10%" class="text-center align-middle text-white">Brand</th>
                        <th width="08%" class="text-center align-middle text-white">Bkg Id</th>
                        <th width="15%" class="text-center align-middle text-white">Supp. Ref</th>
                        <th width="06%" class="text-center align-middle text-white">PNR</th>
                        <th width="20%" class="text-center align-middle text-white">Customer Name</th>
                        <th width="10%" class="text-center align-middle text-white">Balance Due</th>
                        <th width="10%" class="text-center align-middle text-white">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sr = 1;
                        $total_cust_due = 0;
                        $total_profit = 0;
                        $issueances = $report_details['issued_booking'];
                        foreach ($issueances as $key => $issue) {
                            $amt_balance = Getcustreceived($issue['bkg_no']);
                            $sale = $issue['saleprice'] ;
                            $amt_due = round($sale,2) - round($amt_balance,2);
                            if($amt_due == 0){
                                continue;
                            }
                            $total_cust_due += $amt_due;
                            $supplier = $issue['bkg_cost'] ;
                            $add_cost = $issue['admin_exp'] ;
                            $cost = $supplier+$add_cost;
                            $profit = $sale - $cost;
                            $total_profit += $profit;
                    ?>
                    <tr bgcolor="#fff" style="border-bottom: thin dotted #bbbbbb;">
                        <td class="text-center align-middle"><?php echo $sr; ?></td>
                        <td class="text-center align-middle"><?php echo date('d-M-y',strtotime($issue['clr_date'])) ;?></td>
                        <td class="text-center align-middle"><?php remove_space($issue['bkg_agent']); ?></td>
                        <td class="text-center align-middle"><?php remove_space($issue['bkg_brandname']); ?></td>
                        <td class="text-center align-middle">
                            <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/issued/".hashing($issue['bkg_no'])) ?>"><?php echo $issue['bkg_no']; ?></a>
                        </td>
                        <td class="text-center align-middle"><?php custom_echo($issue['bkg_supplier_reference'],15) ; ?></td>
                        <td class="text-center align-middle"><?php echo $issue['flt_pnr']; ?></td>
                        <td class="text-left align-middle"><?php custom_echo($issue['cst_name'],25) ; ?></td>
                        <td class="text-center align-middle"><?php echo number_format($amt_due,2) ; ?></td>
                        <td class="text-center align-middle"><?php echo number_format($profit,2) ; ?></td>
                    </tr>
                    <?php 
                        $sr++;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr bgcolor="#fff">
                        <th class="text-right p-0-5" colspan="8">Total</th>
                        <th class="text-center p-0-5"><?php echo number_format($total_cust_due,2) ; ?></th>
                        <th class="text-center p-0-5"><?php echo number_format($total_profit,2) ; ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>