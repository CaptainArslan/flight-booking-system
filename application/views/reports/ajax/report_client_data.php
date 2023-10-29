<div class="card">
    <div class="card-header bg-danger">
        <div class="row w-100">
            <div class="col-auto">
                <h4 class="card-title text-white"><?php echo getrptname($report); ?></h4>
            </div>
            <div class="col-auto ms-auto">
                <button class="exportexcel btn btn-sm btn-warning align-middle">
                    Export to Excel
                </button>
            </div>
        </div>
    </div> 
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="report_table" class="table" style="table-layout: fixed;word-wrap:break-word;">
                <thead>
                    <!-- <tr>
                        <td width="03%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="07%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="07%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="05%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="08%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="17%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="18%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="10%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="04%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="03%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="06%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="06%" class="text-center align-middle text-white">&nbsp;</td>
                        <td width="06%" class="text-center align-middle text-white">&nbsp;</td>
                    </tr>
                    <tr valign="middle">
                        <td style="padding: 0px !important;border: none;">&nbsp;</td>
                        <td style="padding: 0px !important;border: none;font-weight: 500;font-size: 20px;line-height: 40px;" colspan="6" align="left">
                            Client Data
                        </td>
                        <td style="padding: 0px !important;border: none;font-weight: 500;font-size: 20px;line-height: 40px;" colspan="5" align="right">
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
                        <th class="text-center align-middle text-white">#</th>
                        <th class="text-center align-middle text-white">Issue</th>
                        <th class="text-center align-middle text-white">Agent</th>
                        <th class="text-center align-middle text-white">Bkg ID</th>
                        <th class="text-center align-middle text-white">Sup. Ref</th>
                        <th class="text-center align-middle text-white">Customer Name</th>
                        <th class="text-center align-middle text-white">Email</th>
                        <th class="text-center align-middle text-white">Cell</th>
                        <th class="text-center align-middle text-white">Dest</th>
                        <th class="text-center align-middle text-white">Air</th>
                        <th class="text-center align-middle text-white">Sale</th>
                        <th class="text-center align-middle text-white">Cost</th>
                        <th class="text-center align-middle text-white">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sr = 1;
                        $total_sale = 0;
                        $total_cost = 0;
                        $total_profit_issued = 0;
                        $issueances = $report_details['issued_booking'];
                        foreach ($issueances as $key => $issue) {
                            $sale = $issue['saleprice'] ;
                            $cost = $issue['bkg_cost'];
                            $profit = $sale - $cost;
                            $total_sale += $sale;
                            $total_cost += $cost;
                            $total_profit_issued += $profit;
                    ?>
                    <tr bgcolor="#fff" style="border-bottom: thin dotted #bbbbbb;">
                        <td class="p-0-3 text-center align-middle"><?php echo $sr; ?></td>
                        <td class="p-0-3 text-center align-middle"><?php echo date('d-M-y',strtotime($issue['clr_date'])) ;?></td>
                        <td class="p-0-3 text-center align-middle"><?php remove_space($issue['bkg_agent']); ?></td>
                        <td class="p-0-3 text-center align-middle">
                            <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/issued/".hashing($issue['bkg_no'])) ?>"><?php echo $issue['bkg_no']; ?></a>
                        </td>
                        <td class="p-0-3 text-center align-middle"><?php echo $issue['bkg_supplier_reference'] ; ?></td>
                        <td class="p-0-3 text-left align-middle"><?php echo $issue['cst_name'] ; ?></td>
                        <td class="p-0-3 text-left align-middle"><?php echo $issue['cst_email'] ; ?></td>
                        <td class="p-0-3 text-left align-middle"><?php echo $issue['cst_mobile'] ; ?></td>
                        <td class="p-0-3 text-center align-middle"><?php echo substr($issue['flt_destinationairport'],-3) ; ?></td>
                        <td class="p-0-3 text-center align-middle"><?php echo substr($issue['flt_airline'],-2) ; ?></td>
                        <td class="p-0-3 text-center align-middle"><?php echo number_format($sale,2) ; ?></td>
                        <td class="p-0-3 text-center align-middle"><?php echo number_format($cost,2) ; ?></td>
                        <td class="p-0-3 text-center align-middle"><?php echo number_format($profit,2) ; ?></td>
                    </tr>
                    <?php 
                        $sr++;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr bgcolor="#fff" style="border-bottom: thin dotted #bbbbbb;">
                        <th class="text-center " colspan="6">&nbsp;</th>
                        <th class="text-center " colspan="4">Total</th>
                        <th class="text-center "><?php echo number_format($total_sale,2) ; ?></th>
                        <th class="text-center "><?php echo number_format($total_cost,2) ; ?></th>
                        <th class="text-center "><?php echo number_format($total_profit_issued,2) ; ?></th>
                    </tr>
                </tfoot>
            </table>
            <table class="table led-table-bg m-b-0" style="table-layout: fixed;word-wrap:break-word;">
                <thead>
                    <tr>
                        <td width="03%">&nbsp;</td>
                        <td width="08%">&nbsp;</td>
                        <td width="07%">&nbsp;</td>
                        <td width="05%">&nbsp;</td>
                        <td width="18%">&nbsp;</td>
                        <td width="18%">&nbsp;</td>
                        <td width="10%">&nbsp;</td>
                        <td width="04%">&nbsp;</td>
                        <td width="03%">&nbsp;</td>
                        <td width="06%">&nbsp;</td>
                        <td width="06%">&nbsp;</td>
                        <td width="06%">&nbsp;</td>
                        <td width="06%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="13" style="padding: 10px !important;border: none;font-size: 16px;font-weight: 500;">
                            Cancelled Bookings
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center align-middle text-white">#</th>
                        <th class="text-center align-middle text-white">Cancel</th>
                        <th class="text-center align-middle text-white">Agent</th>
                        <th class="text-center align-middle text-white">Bkg ID</th>
                        <th class="text-center align-middle text-white">Customer Name</th>
                        <th class="text-center align-middle text-white">Email</th>
                        <th class="text-center align-middle text-white">Cell</th>
                        <th class="text-center align-middle text-white">Dest</th>
                        <th class="text-center align-middle text-white">Air</th>
                        <th class="text-center align-middle text-white">Recvd</th>
                        <th class="text-center align-middle text-white">Refund</th>
                        <th class="text-center align-middle text-white">Cost</th>
                        <th class="text-center align-middle text-white">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sr = 1;
                        $total_amt_rec = 0;
                        $total_amt_rfnd = 0;
                        $total_amt_bkg_cost = 0;
                        $total_profit_cancelled = 0;
                        $cancellations = $report_details['cancelled'];
                        foreach ($cancellations as $key => $cancelled) {
                            $amt_rec = 0;
                            $amt_rfnd = 0;
                            $amt_bkg_cost = 0;
                            $profit = 0;
                            $amt = Getrcepaid($cancelled['bkg_no']);
                            $amt_rec = $amt['amt_received'] ;
                            $amt_rfnd = $amt['amt_refund'] ;
                            $amt_bkg_cost = $cancelled['bkg_cost'];
                            $profit = round($amt_rec-($amt_rfnd+$amt_bkg_cost),2);
                            $total_amt_rec += $amt_rec;
                            $total_amt_rfnd += $amt_rfnd;
                            $total_amt_bkg_cost += $amt_bkg_cost;
                            $total_profit_cancelled += $profit;
                            
                    ?>
                    <tr bgcolor="#fff" style="border-bottom: thin dotted #bbbbbb;">
                        <td class=" text-center align-middle">
                            <?php echo $sr; ?>
                        </td>
                        <td class=" text-center align-middle">
                            <?php echo date('d-M-y',strtotime($cancelled['cnl_date'])); ?>
                        </td>
                        <td class=" text-center align-middle">
                            <?php remove_space($cancelled['bkg_agent']); ?>
                        </td>
                        <td class=" text-center align-middle">
                            <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/cancelled/".hashing($cancelled['bkg_no'])) ?>">
                                <?php echo $cancelled['bkg_no']; ?>
                            </a>
                        </td>
                        <td class=" text-left align-middle">
                            <?php echo $cancelled['cst_name'] ; ?>
                        </td>
                        <td class=" text-left align-middle">
                            <?php echo $cancelled['cst_email'] ; ?>
                        </td>
                        <td class=" text-left align-middle">
                            <?php echo $cancelled['cst_mobile'] ; ?>
                        </td>
                        <td class=" text-center align-middle">
                            <?php echo substr($cancelled['flt_destinationairport'],-3) ; ?>
                        </td>
                        <td class=" text-center align-middle">
                            <?php echo substr($cancelled['flt_airline'],-2) ; ?>
                        </td>
                        <td class=" text-center align-middle">
                            <?php echo number_format($amt_rec,2) ; ?>
                        </td>
                        <td class=" text-center align-middle">
                            <?php echo number_format($amt_rfnd,2) ; ?>
                        </td>
                        <td class=" text-center align-middle">
                            <?php echo number_format($amt_bkg_cost,2) ; ?>
                        </td>
                        <td class=" text-center align-middle">
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
                        <th class="text-center " colspan="7">&nbsp;</th>
                        <th class="text-center " colspan="2">Total</th>
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
                            <?php echo number_format($total_profit_cancelled,2) ; ?>
                        </th>
                    </tr>
                    <tr bgcolor="#fff">
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