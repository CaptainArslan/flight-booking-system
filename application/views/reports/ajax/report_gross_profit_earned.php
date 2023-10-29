<div class="card">
    <div class="card-header bg-danger">
        <div class="row w-100">
            <div class="col-auto">
                <h4 class="card-title text-white"><?php echo getrptname($report); ?></h4>
            </div>
            <div class="col-auto ms-auto text-right">
                <?php
                    if($_SERVER['HTTP_REFERER'] != base_url("dashboard")){ ?>
                <button class="exportexcel btn btn-sm btn-warning">Export to Excel</button>
                <?php } ?>
            </div>
        </div>
    </div> 
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="report_table" class="table">
                <thead>
                    <!-- <tr style="border: none !important;">
                        <td colspan="13" style="padding: 0px !important;">&nbsp;</td>
                    </tr>
                    <tr valign="middle" style="border: none !important;">
                        <td colspan="13" style="padding: 0px !important;">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr valign="middle" style="border: none !important;">
                                    <td width="04%" style="padding: 0px !important;">&nbsp;</td>
                                    <td width="46%" style="padding: 0px !important;font-weight: 500;font-size: 20px;line-height: 40px;">
                                        Gross Profit Sheet
                                    </td>
                                    <td width="46%" style="padding: 0px !important;text-align:right;font-weight: 500;font-size: 20px;line-height: 40px;">
                                        <?php 
                                            if($this->session->userdata('user_brand')=='All'){
                                                echo "";
                                            }else{
                                                echo $this->session->userdata('user_brand');
                                            }
                                        ?>
                                    </td>
                                    <td width="04%" style="padding: 0px !important;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="border: none !important;">
                        <td  style="padding: 10px 0px !important;" colspan="13">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr style="border: none !important;">
                                    <td width="04%" style="padding: 0px !important;">&nbsp;</td>
                                    <td width="06%" style="padding: 0px !important;font-weight: 500;">From :</td>
                                    <td width="10%" style="padding: 0px !important;">
                                        <?php echo date("d-M-Y",strtotime($start_date)); ?>
                                    </td>
                                    <td width="06%" style="padding: 0px !important;font-weight: 500">To :</td>
                                    <td width="10%" style="padding: 0px !important;">
                                        <?php echo date("d-M-Y",strtotime($end_date)); ?>
                                    </td>
                                    <td width="06%" style="padding: 0px !important;font-weight: 500">Agent :</td>
                                    <td width="14%" style="padding: 0px !important;">
                                        <?php echo $agent; ?>
                                    </td>
                                    <td width="06%" style="padding: 0px !important;font-weight: 500">Brand :</td>
                                    <td width="14%" style="padding: 0px !important;">
                                        <?php echo $brand; ?>
                                    </td>
                                    <td width="06%" style="padding: 0px !important;font-weight: 500">Supplier :</td>
                                    <td width="14%" style="padding: 0px !important;">
                                        <?php echo $supplier; ?>
                                    </td>
                                    <td width="04%" style="padding: 0px !important;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr> -->
                    <tr bgcolor="#fff">
                        <td colspan="13" style="padding: 10px !important;border: none;font-size: 16px;font-weight: 500;">
                            Issued Bookings
                        </td>
                    </tr>
                    <tr>
                        <th width="03%" class="text-center align-middle text-white" rowspan="2">Sr.<br>No.</th>
                        <th width="08%" class="text-center align-middle text-white" rowspan="2">Issue<br>Date</th>
                        <th width="10%" class="text-center align-middle text-white" rowspan="2">Agent<br>Name</th>
                        <th width="06%" class="text-center align-middle text-white" rowspan="2">Booking<br>Ref No.</th>
                        <th width="10%" class="text-center align-middle text-white" rowspan="2">Supplier<br>Ref No.</th>
                        <th width="18%" class="text-center align-middle text-white" rowspan="2">Customer Name</th>
                        <th width="04%" class="text-center align-middle text-white" rowspan="2">Dest.</th>
                        <th width="04%" class="text-center align-middle text-white" rowspan="2">Pax</th>
                        <th width="09%" class="text-center align-middle text-white" rowspan="2">Sale<br>Price</th>
                        <th class="text-center align-middle text-white" colspan="3">Cost</th>
                        <th width="09%" class="text-center align-middle text-white" rowspan="2">Profit</th>
                    </tr>
                    <tr>
                        <th width="6.33%" class="text-center align-middle text-white">Supplier</th>
                        <th width="6.33%" class="text-center align-middle text-white">Addi.</th>
                        <th width="6.33%" class="text-center align-middle text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sr = 1;
                        $total_sale = 0;
                        $total_supplier = 0;
                        $total_add_cost = 0;
                        $total_cost = 0;
                        $total_profit_issued = 0;
                        $total_no_pax = 0;
                        $issueances = $report_details['issued_booking'];
                        foreach ($issueances as $key => $issue) {
                            $no_pax = Getpax($issue['bkg_no']);
                            $sale = $issue['saleprice'] ;
                            $supplier = $issue['bkg_cost'] ;
                            $add_cost = $issue['admin_exp'] ;
                            $cost = $supplier+$add_cost;
                            $profit = $sale - $cost;
                            $total_sale += $sale;
                            $total_supplier += $supplier;
                            $total_add_cost += $add_cost;
                            $total_cost += $cost;
                            $total_profit_issued += $profit;
                            $total_no_pax += $no_pax;
                    ?>
                    <tr bgcolor="#fff" style="border-bottom: thin dotted #bbbbbb;">
                        <td width="03%" class=" text-center align-middle"><?php echo $sr; ?></td>
                        <td width="08%" class=" text-center align-middle"><?php echo date('d-M-y',strtotime($issue['clr_date'])) ;?></td>
                        <td width="10%" class=" text-center align-middle"><?php echo $issue['bkg_agent'] ; ?></td>
                        <td width="06%" class=" text-center align-middle">
                            <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/issued/".hashing($issue['bkg_no'])) ?>"><?php echo $issue['bkg_no']; ?></a>
                        </td>
                        <td width="10%" class=" text-center align-middle"><?php echo $issue['bkg_supplier_reference'] ; ?></td>
                        <td width="18%" class=" text-left align-middle"><?php custom_echo($issue['cst_name'],25) ; ?></td>
                        <td width="04%" class=" text-center align-middle"><?php echo substr($issue['flt_destinationairport'],-3) ; ?></td>
                        <td width="04%" class=" text-center align-middle"><?php echo $no_pax; ?></td>
                        <td width="09%" class=" text-center align-middle"><?php echo number_format($sale,2) ; ?></td>
                        <td width="6.33%" class=" text-center align-middle"><?php echo number_format($supplier,2) ; ?></td>
                        <td width="6.33%" class=" text-center align-middle"><?php echo number_format($add_cost,2) ; ?></td>
                        <td width="6.33%" class=" text-center align-middle"><?php echo number_format($cost,2) ; ?></td>
                        <td width="09%" class=" text-center align-middle"><?php echo number_format($profit,2) ; ?></td>
                    </tr>
                    <?php 
                        $sr++;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr bgcolor="#fff" style="border-bottom: thin dotted #bbbbbb;">
                        <th class="text-center " colspan="5">&nbsp;</th>
                        <th class="text-center " colspan="2">Total</th>
                        <th class="text-center "><?php echo number_format($total_no_pax) ; ?></th>
                        <th class="text-center "><?php echo number_format($total_sale,2) ; ?></th>
                        <th class="text-center "><?php echo number_format($total_supplier,2) ; ?></th>
                        <th class="text-center "><?php echo number_format($total_add_cost,2) ; ?></th>
                        <th class="text-center "><?php echo number_format($total_cost,2) ; ?></th>
                        <th class="text-center "><?php echo number_format($total_profit_issued,2) ; ?></th>
                    </tr>
                </tfoot>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <td width="100%" colspan="13" style="padding: 10px !important;border: none;font-size: 16px;font-weight: 500;">
                            Cancelled Bookings
                        </td>
                    </tr>
                    <tr>
                        <th width="03%" class="text-center align-middle text-white" >Sr.<br>No.</th>
                        <th width="08%" class="text-center align-middle text-white" >Cancel<br>Date</th>
                        <th width="10%" class="text-center align-middle text-white" >Agent<br>Name</th>
                        <th width="06%" class="text-center align-middle text-white" >Booking<br>Ref No.</th>
                        <th width="10%" class="text-center align-middle text-white" >Supplier<br>Ref No.</th>
                        <th width="18%" class="text-center align-middle text-white" >Customer Name</th>
                        <th width="04%" class="text-center align-middle text-white" >Dest.</th>
                        <th width="04%" class="text-center align-middle text-white" >Pax</th>
                        <th width="09%" class="text-center align-middle text-white" >Amount<br>Received</th>
                        <th width="6.33%" class="text-center align-middle text-white">Amount<br>Refunded</th>
                        <th width="6.33%" class="text-center align-middle text-white">Supplier<br>Cost</th>
                        <th width="6.33%" class="text-center align-middle text-white">Additional<br>Exp.</th>
                        <th width="09%" class="text-center align-middle text-white" rowspan="2">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sr = 1;
                        $total_no_pax = 0;
                        $total_amt_rec = 0;
                        $total_amt_rfnd = 0;
                        $total_amt_bkg_cost = 0;
                        $total_amt_admin_cost = 0;
                        $total_profit_cancelled = 0;
                        $cancellations = $report_details['cancelled'];
                        foreach ($cancellations as $key => $cancelled) {
                            $amt_rec = 0;
                            $amt_rfnd = 0;
                            $amt_bkg_cost = 0;
                            $amt_admin_cost = 0;
                            $no_pax = 0;
                            $profit = 0;
                            $no_pax = Getpax($cancelled['bkg_no']);
                            $amt = Getrcepaid($cancelled['bkg_no']);
                            $amt_rec = $amt['amt_received'] ;
                            $amt_rfnd = $amt['amt_refund'] ;
                            $amt_bkg_cost = $cancelled['bkg_cost'];
                            $amt_admin_cost = $cancelled['admin_exp'];
                            $profit = round($amt_rec-($amt_rfnd+$amt_bkg_cost+$amt_admin_cost),2);
                            $total_no_pax += $no_pax;
                            $total_amt_rec += $amt_rec;
                            $total_amt_rfnd += $amt_rfnd;
                            $total_amt_bkg_cost += $amt_bkg_cost;
                            $total_amt_admin_cost += $amt_admin_cost;
                            $total_profit_cancelled += $profit;
                            
                    ?>
                    <tr bgcolor="#fff" style="border-bottom: thin dotted #bbbbbb;">
                        <td width="03%" class=" text-center align-middle">
                            <?php echo $sr; ?>
                        </td>
                        <td width="08%" class=" text-center align-middle">
                            <?php echo date('d-M-y',strtotime($cancelled['cnl_date'])); ?>
                        </td>
                        <td width="10%" class=" text-center align-middle">
                            <?php echo $cancelled['bkg_agent']; ?>
                        </td>
                        <td width="06%" class=" text-center align-middle">
                            <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/cancelled/".hashing($cancelled['bkg_no'])) ?>">
                                <?php echo $cancelled['bkg_no']; ?>
                            </a>
                        </td>
                        <td width="10%" class=" text-center align-middle">
                            <?php echo $cancelled['bkg_supplier_reference'] ; ?>
                        </td>
                        <td width="18%" class=" text-left align-middle">
                            <?php custom_echo($cancelled['cst_name'],25) ; ?>
                        </td>
                        <td width="04%" class=" text-center align-middle">
                            <?php echo substr($cancelled['flt_destinationairport'],-3) ; ?>
                        </td>
                        <td width="04%" class=" text-center align-middle">
                            <?php echo $no_pax ; ?>
                        </td>
                        <td width="09%" class=" text-center align-middle">
                            <?php echo number_format($amt_rec,2) ; ?>
                        </td>
                        <td width="6.33%" class=" text-center align-middle">
                            <?php echo number_format($amt_rfnd,2) ; ?>
                        </td>
                        <td width="6.33%" class=" text-center align-middle">
                            <?php echo number_format($amt_bkg_cost,2) ; ?>
                        </td>
                        <td width="6.33%" class=" text-center align-middle">
                            <?php echo number_format($amt_admin_cost,2) ?>
                        </td>
                        <td width="09%" class=" text-center align-middle">
                            <?php echo number_format($profit,2) ; ?>
                        </td>
                    </tr>
                    <?php 
                        $sr++;
                        } 
                    ?>
                </tbody>
                <tfoot>
                    <tr bgcolor="#fff" style="border-bottom: thin dotted #bbbbbb;">
                        <th class="text-center " colspan="5">&nbsp;</th>
                        <th class="text-center " colspan="2">Total</th>
                        <th class="text-center ">
                            <?php echo $total_no_pax ; ?>
                        </th>
                        <th class="text-center ">
                            <?php echo number_format($total_amt_rec,2) ; ?>
                        </th>
                        <th class="text-center ">
                            <?php echo number_format($total_amt_rfnd,2) ; ?>
                        </th>
                        <th class="text-center ">
                            <?php echo number_format($total_amt_bkg_cost,2) ; ?>
                        </th>
                        <th class="text-center ">
                            <?php echo number_format($total_amt_admin_cost,2) ?>
                        </th>
                        <th class="text-center ">
                            <?php echo number_format($total_profit_cancelled,2) ; ?>
                        </th>
                    </tr>
                    <tr bgcolor="#fff" style="border-bottom: thin dotted #bbbbbb;">
                        <th class="text-center " colspan="7">&nbsp;</th>
                        <th class="text-center " colspan="4">Total Gross Profit</th>
                        <th class="text-center " colspan="2">
                            <?php echo number_format($total_profit_issued+$total_profit_cancelled,2) ; ?>
                        </th>
                    </tr>

                </tfoot>
            </table>
        </div>
    </div>
</div>