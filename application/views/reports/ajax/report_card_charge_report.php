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
            <table id="report_table" class="table">
                <thead>
                    <!-- <tr>
                        <td colspan="11" style="padding: 0px !important;border: none;">&nbsp;</td>
                    </tr>
                    <tr valign="middle">
                        <td style="padding: 0px !important;border: none;">&nbsp;</td>
                        <td style="padding: 0px !important;border: none;font-weight: 500;font-size: 20px;line-height: 40px;" colspan="6" align="left">
                            <?php echo getrptname($report); ?>
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
                        <td  style="padding: 10px 0px !important; border: none;" colspan="9">
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
                                    <td width="08%" style="padding: 0px !important; border: none;font-weight: 500">Card :</td>
                                    <td width="12%" style="padding: 0px !important; border: none;">
                                        <?php echo $card; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td  style="padding: 10px 0px !important; border: none;" >&nbsp;</td>
                    </tr> -->
                    <tr bgcolor="#fff">
                        <td colspan="11" style="padding: 10px !important;border: none;font-size: 16px;font-weight: 500;">
                            Bookings
                        </td>
                    </tr>
                    <tr>
                        <th width="03%" class="text-center align-middle text-white">#</th>
                        <th width="08%" class="text-center align-middle text-white">Charge<br>Date</th>
                        <th width="07%" class="text-center align-middle text-white">Booking<br>Id</th>
                        <th width="20%" class="text-center align-middle text-white">Customer<br>Name</th>
                        <th width="08%" class="text-center align-middle text-white">Booking<br>Status</th>
                        <th width="14%" class="text-center align-middle text-white">Authorization<br>Code</th>
                        <th width="08%" class="text-center align-middle text-white">Amount<br>Charged</th>
                        <th width="08%" class="text-center align-middle text-white">Amount<br>Refunded</th>
                        <th width="08%" class="text-center align-middle text-white">Balance</th>
                        <th width="08%" class="text-center align-middle text-white">Charges</th>
                        <th width="08%" class="text-center align-middle text-white">Net<br>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sr = 1;
                        $total_amt_net = $total_amt_chrges = $total_amt_bal = $total_amt_rfnd = $total_amt_chrgd = 0;
                        foreach ($report_details as $key => $booking) {                    	
                            $amt_net = $amt_chrges = $amt_bal = $amt_rfnd = $amt_chrgd = 0;
                            $amt_chrgd = $booking['amnt_recvd'];
                            $amt_rfnd = $booking['amnt_paid'];
                            $amt_bal = round($amt_chrgd,2) - round($amt_rfnd,2);
                            if($amt_bal > 0){
                                $amt_chrges = ($amt_bal*5)/100;
                            }
                            $amt_net = round($amt_bal,2) - round($amt_chrges,2);
                            $total_amt_net += $amt_net;
                            $total_amt_chrges += $amt_chrges;
                            $total_amt_bal += $amt_bal;
                            $total_amt_rfnd += $amt_rfnd;
                            $total_amt_chrgd += $amt_chrgd;
                    ?>
                    <tr bgcolor="#fff">
                        <td class=" text-center align-middle"><?php echo $sr; ?></td>
                        <td class=" text-center align-middle">
                            <?php 
                                echo date('d-M-y',strtotime($booking['trans_date'])) ;
                            ?>
                        </td>
                        <td class=" text-center align-middle">
                            <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/".$booking['bkg_status']."/".hashing($booking['bkg_no'])) ?>"><?php echo $booking['bkg_no']; ?></a>
                        </td>
                        <td class=" text-left align-middle"><?php echo $booking['cst_name']; ?></td>
                        <td class=" text-center align-middle"><?php echo $booking['bkg_status'] ; ?></td>
                        <td class=" text-center align-middle"><?php echo $booking['authcode'] ; ?></td>
                        <td class=" text-right align-middle"><?php echo(abs($amt_chrgd) != 0)?number_format($amt_chrgd,2):'-'; ?></td>
                        <td class=" text-right align-middle"><?php echo(abs($amt_rfnd) != 0)?number_format($amt_rfnd,2):'-'; ?></td>
                        <td class=" text-right align-middle"><?php echo(abs($amt_bal) != 0)?number_format($amt_bal,2):'-'; ?></td>
                        <td class=" text-right align-middle"><?php echo(abs($amt_chrges) != 0)?number_format($amt_chrges,2):'-'; ?></td>
                        <td class=" text-right align-middle"><?php echo number_format($amt_net,2) ; ?></td>
                    </tr>
                    <?php 
                        $sr++;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr bgcolor="#fff">
                        <th class="text-right " colspan="6">Total</th>
                        <th class="text-right "><?php echo number_format($total_amt_chrgd,2) ; ?></th>
                        <th class="text-right "><?php echo number_format($total_amt_rfnd,2) ; ?></th>
                        <th class="text-right "><?php echo number_format($total_amt_bal,2) ; ?></th>
                        <th class="text-right "><?php echo number_format($total_amt_chrges,2) ; ?></th>
                        <th class="text-right "><?php echo number_format($total_amt_net,2) ; ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>