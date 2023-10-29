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
            <table id="report_table" class="table led-table-bg m-b-0">
                <thead>
                    <!-- <tr>
                        <td colspan="9" style="padding: 0px !important;border: none;">&nbsp;</td>
                    </tr>
                    <tr valign="middle">
                        <td style="padding: 0px !important;border: none;">&nbsp;</td>
                        <td style="padding: 0px !important;border: none;font-weight: 500;font-size: 20px;line-height: 40px;" colspan="6" align="left">
                            <?php echo getrptname($report); ?>
                        </td>
                        <td style="padding: 0px !important;border: none;font-weight: 500;font-size: 20px;line-height: 40px;" colspan="2" align="right">
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
                        <td colspan="10" style="padding: 10px !important;border: none;font-size: 16px;font-weight: 500;">
                            Pending Bookings
                        </td>
                    </tr>
                    <tr>
                        <th width="03%" class="text-center align-middle text-white">#</th>
                        <th width="09%" class="text-center align-middle text-white">Booking Date</th>
                        <th width="10%" class="text-center align-middle text-white">Traveling Date</th>
                        <th width="10%" class="text-center align-middle text-white">Supplier Name</th>
                        <th width="08%" class="text-center align-middle text-white">Bkg Id</th>
                        <th width="10%" class="text-center align-middle text-white">Supp. Ref</th>
                        <th width="20%" class="text-center align-middle text-white">Customer Name</th>
                        <th width="10%" class="text-center align-middle text-white">Brand</th>
                        <th width="10%" class="text-center align-middle text-white">Agent</th>
                        <th width="10%" class="text-center align-middle text-white">Balance Due</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sr = 1;
                        $total_due = 0;
                        foreach ($report_details as $key => $booking) {
                            $amt_due = $booking['total_received'];
                            if($amt_due == 0){
                                continue;
                            }
                            $total_due += $amt_due;
                            
                    ?>
                    <tr bgcolor="#fff">
                        <td class="text-center align-middle"><?php echo $sr; ?></td>
                        <td class="text-center align-middle">
                            <?php 
                                echo date('d-M-y',strtotime($booking['bkg_date'])) ;
                            ?>
                        </td>
                        <td class="text-center align-middle">
                            <?php 
                                echo date('d-M-y',strtotime($booking['flt_departuredate'])) ;
                            ?>
                        </td>
                        <td class="text-center align-middle"><?php echo $booking['sup_name'] ; ?></td>
                        <td class="text-center align-middle">
                            <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/pending/".hashing($booking['bkg_no'])) ?>"><?php echo $booking['bkg_no']; ?></a>
                        </td>
                        <td class="text-center align-middle"><?php echo $booking['bkg_supplier_reference'] ;?></td>
                        <td class="text-center align-middle"><?php echo $booking['cst_name']; ?></td>
                        <td class="text-center align-middle"><?php echo $booking['bkg_brandname'] ; ?></td>
                        <td class="text-center align-middle"><?php echo $booking['bkg_agent'] ; ?></td>
                        <td class="text-center align-middle"><?php echo number_format($amt_due,2) ; ?></td>
                    </tr>
                    <?php 
                        $sr++;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr bgcolor="#fff">
                        <th class="text-right" colspan="9">Total</th>
                        <th class="text-center"><?php echo number_format($total_due,2) ; ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>