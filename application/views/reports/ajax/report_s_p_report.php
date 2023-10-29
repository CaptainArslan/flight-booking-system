<div class="card">
    <div class="card-header bg-danger">
        <div class="row w-100">
            <div class="col-auto">
                <h4 class="card-title text-white"><?php echo getrptname($report); ?></h4>
            </div>
            <div class="col-auto ms-auto text-right">
                <button class="exportexcel btn btn-sm btn-warning">Export to Excel</button>
            </div>
        </div>
    </div> 
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="report_table" class="table">
                <thead>
                    <!-- <tr>
                        <td colspan="13" style="padding: 0px !important;border: none;">&nbsp;</td>
                    </tr>
                    <tr valign="middle">
                        <td style="padding: 0px !important;border: none;">&nbsp;</td>
                        <td style="padding: 0px !important;border: none;font-weight: 500;font-size: 20px;line-height: 40px;" colspan="8" align="left">
                            Sale Purchase Sheet
                        </td>
                        <td style="padding: 0px !important;border: none;font-weight: 500;font-size: 20px;line-height: 40px;" colspan="3" align="right">
                            <?php 
                                echo($this->session->userdata('user_brand')=='All')?"":$this->session->userdata('user_brand');
                            ?>
                        </td>
                        <td style="padding: 0px !important;border: none;">&nbsp;</td>
                    </tr>
                    <tr style="border-bottom: none !important;">
                        <td  style="padding: 10px 0px !important; border: none;" >&nbsp;</td>
                        <td  style="padding: 10px 0px !important; border: none;" colspan="11">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr style="border-bottom: none !important;">
                                    <td width="08%" style="padding: 0px !important; border: none;font-weight: 500;">From :</td>
                                    <td width="12%" style="padding: 0px !important; border: none;">
                                        <?php echo date("d-M-Y",strtotime($start_date)); ?>
                                    </td>
                                    <td width="08%" style="padding: 0px !important; border: none;font-weight: 500">To :</td>
                                    <td width="12%" style="padding: 0px !important; border: none;">
                                        <?php echo date("d-M-Y",strtotime($end_date)); ?>
                                    </td>
                                    <td width="08%" style="padding: 0px !important; border: none;font-weight: 500">Agent :</td>
                                    <td width="12%" style="padding: 0px !important; border: none;">
                                        <?php echo $agent; ?>
                                    </td>
                                    <td width="08%" style="padding: 0px !important; border: none;font-weight: 500">Brand :</td>
                                    <td width="12%" style="padding: 0px !important; border: none;">
                                        <?php echo $brand; ?>
                                    </td>
                                    <td width="08%" style="padding: 0px !important; border: none;font-weight: 500">Supplier :</td>
                                    <td width="12%" style="padding: 0px !important; border: none;">
                                        <?php echo $supplier; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="padding: 10px 0px !important; border: none;" >&nbsp;</td>
                    </tr> -->
                    <tr bgcolor="#fff">
                        <td colspan="13" style="padding: 10px !important;border: none;font-size: 16px;font-weight: 500;">
                            Issued Bookings
                        </td>
                    </tr>
                    <tr>
                        <th width="03%" class="text-center align-middle text-white" rowspan="2">Sr.<br>No.</th>
                        <th width="08%" class="text-center align-middle text-white" rowspan="2">Issue<br>Date</th>
                        <th width="07%" class="text-center align-middle text-white" rowspan="2">Agent<br>Name</th>
                        <th width="07%" class="text-center align-middle text-white" rowspan="2">Booking<br>Ref No.</th>
                        <th width="10%" class="text-center align-middle text-white" rowspan="2">Supplier<br>Ref No.</th>
                        <th width="15%" class="text-center align-middle text-white" rowspan="2">Customer Name</th>
                        <th width="07%" class="text-center align-middle text-white" rowspan="2">Trans<br>Sale</th>
                        <th width="07%" class="text-center align-middle text-white" rowspan="2">Bkg<br>Sale</th>
                        <th width="07%" class="text-center align-middle text-white" rowspan="2">Trans<br>Cost</th>
                        <th class="text-center align-middle text-white" colspan="3">Cost</th>
                        <th width="08%" class="text-center align-middle text-white" rowspan="2">Profit</th>
                    </tr>
                    <tr>
                        <th width="07%" class="text-center align-middle text-white">Bkg Cost</th>
                        <th width="07%" class="text-center align-middle text-white">Addi.</th>
                        <th width="07%" class="text-center align-middle text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sr = 1;
                        $total_bkg_sale = 0;
                        $total_bkg_cost = 0;
                        $total_trns_sale = 0;
                        $total_trns_cost = 0;
                        $total_add_cost = 0;
                        $total_cost = 0;
                        $total_profit_issued = 0;
                        $issueances = $report_details['issued_booking'];
                        foreach ($issueances as $key => $issue) {
                            $trns_sale = GetTransSale($issue['bkg_no']);
                            $total_trns_sale += $trns_sale;
                            $trns_cost = GetTransCost($issue['bkg_no']);
                            $total_trns_cost += $trns_cost;
                            $bkg_sale = $issue['saleprice'] ;
                            $total_bkg_sale += $bkg_sale;
                            $bkg_cost = $issue['bkg_cost'] ;
                            $total_bkg_cost += $bkg_cost;
                            $add_cost = $issue['admin_exp'] ;
                            $total_add_cost += $add_cost;
                            $cost = $bkg_cost+$add_cost;
                            $total_cost += $cost;
                            $profit = $bkg_sale - $cost;
                            $total_profit_issued += $profit;
                    ?>
                    <tr bgcolor="#fff">
                        <td width="03%" class="text-center align-middle"><?php echo $sr; ?></td>
                        <td width="08%" class="text-center align-middle"><?php echo date('d-M-y',strtotime($issue['clr_date'])) ;?></td>
                        <td width="07%" class="text-center align-middle"><?php remove_space($issue['bkg_agent']); ?></td>
                        <td width="07%" class="text-center align-middle">
                            <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/issued/".hashing($issue['bkg_no'])) ?>"><?php echo $issue['bkg_no']; ?></a>
                        </td>
                        <td width="10%"class="text-center align-middle"><?php custom_echo($issue['bkg_supplier_reference'],15) ; ?></td>
                        <td width="15%" class="text-left align-middle"><?php custom_echo($issue['cst_name'],25) ; ?></td>
                        <td width="07%" class="text-center align-middle" bgcolor="#<?php echo($trns_sale!=$bkg_sale)?"f8dde0":"fff"; ?>">
                            <?php echo number_format($trns_sale,2) ; ?>
                        </td>
                        <td width="07%" class="text-center align-middle" bgcolor="#<?php echo($trns_sale!=$bkg_sale)?"f8dde0":"fff"; ?>">
                            <?php echo number_format($bkg_sale,2) ; ?>
                        </td>
                        <td width="07%" class="text-center align-middle" bgcolor="#<?php echo($trns_cost!=$bkg_cost)?"f8dde0":"fff"; ?>">
                            <?php echo number_format($trns_cost,2) ; ?>
                        </td>
                        <td width="08%" class="text-center align-middle" bgcolor="#<?php echo($trns_cost!=$bkg_cost)?"f8dde0":"fff"; ?>">
                            <?php echo number_format($bkg_cost,2) ; ?>
                        </td>
                        <td width="07%" class="text-center align-middle"><?php echo number_format($add_cost,2) ; ?></td>
                        <td width="07%" class="text-center align-middle"><?php echo number_format($cost,2) ; ?></td>
                        <td width="07%" class="text-center align-middle"><?php echo number_format($profit,2) ; ?></td>
                    </tr>
                    <?php 
                        $sr++;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr bgcolor="#fff">
                        <th class="text-right" colspan="6">Total</th>
                        <th class="text-center"><?php echo number_format($total_trns_sale) ; ?></th>
                        <th class="text-center"><?php echo number_format($total_bkg_sale,2) ; ?></th>
                        <th class="text-center"><?php echo number_format($total_trns_cost,2) ; ?></th>
                        <th class="text-center"><?php echo number_format($total_bkg_cost,2) ; ?></th>
                        <th class="text-center"><?php echo number_format($total_add_cost,2) ; ?></th>
                        <th class="text-center"><?php echo number_format($total_cost,2) ; ?></th>
                        <th class="text-center"><?php echo number_format($total_profit_issued,2) ; ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>