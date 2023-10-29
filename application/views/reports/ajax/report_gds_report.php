<div class="card-header bg-danger">
    <div class="row">
        <div class="col-md-6">
            <h4 class="card-title m-t-5 m-b-0 text-white"><?php echo getrptname($report); ?></h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="exportexcel btn btn-sm btn-warning text-dark text-middle">
                <i class="fa fa-file-excel-o"></i> Export to Excel
            </button>
        </div>
    </div>
</div> 
<div class="card card-body p-0-0">
    <div class="table-responsive">
        <table id="report_table" class="table led-table-bg m-b-0">
            <thead>
                <tr>
                    <td colspan="11" style="padding: 0px !important;border: none;">&nbsp;</td>
                </tr>
                <tr valign="middle">
                    <td style="padding: 0px !important;border: none;">&nbsp;</td>
                    <td style="padding: 0px !important;border: none;font-weight: 500;font-size: 20px;line-height: 40px;" colspan="8" align="left">
                        <?php echo getrptname($report); ?>
                    </td>
                    <td style="padding: 0px !important;border: none;font-weight: 500;font-size: 20px;line-height: 40px;" colspan="4" align="right">
                        <?php 
                            echo($this->session->userdata('user_brand')=='All')?"":$this->session->userdata('user_brand');
                        ?>
                    </td>
                    <td style="padding: 0px !important;border: none;">&nbsp;</td>
                </tr>
                <tr style="border-bottom: none !important;">
                    <td  style="padding: 10px 0px !important; border: none;" >&nbsp;</td>
                    <td  style="padding: 10px 0px !important; border: none;" colspan="12">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr style="border-bottom: none !important;">
                                <td width="10%" style="padding: 0px !important; border: none;font-weight: 500;">From :</td>
                                <td width="15%" style="padding: 0px !important; border: none;">
                                    <?php echo date("d-M-Y",strtotime($start_date)); ?>
                                </td>
                                <td width="10%" style="padding: 0px !important; border: none;font-weight: 500">To :</td>
                                <td width="15%" style="padding: 0px !important; border: none;">
                                    <?php echo date("d-M-Y",strtotime($end_date)); ?>
                                </td>
                                <td width="10%" style="padding: 0px !important; border: none;font-weight: 500">Brand :</td>
                                <td width="15%" style="padding: 0px !important; border: none;">
                                    <?php echo $brand; ?>
                                </td>
                                <td width="10%" style="padding: 0px !important; border: none;font-weight: 500">GDS :</td>
                                <td width="15%" style="padding: 0px !important; border: none;">
                                    <?php echo $gds; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td  style="padding: 10px 0px !important; border: none;" >&nbsp;</td>
                </tr>
                <tr>
                    <th width="03%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">#</th>
                    <th width="08%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">Issue<br>Date</th>
                    <th width="08%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">Brand<br>Name</th>
                    <th width="07%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">Booking<br>Ref</th>
                    <th width="15%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">Customer Name</th>
                    <th width="09%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">GDS</th>
                    <th width="05%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">Dest</th>
                    <th width="05%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">Airline</th>
                    <th width="07%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">PNR</th>
                    <th width="10%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">E-Ticket No.</th>
                    <th width="04%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">Pax</th>
                    <th width="04%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">Seg.</th>
                    <th width="07%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">Total<br>Seg</th>
                    <th width="08%" class="p-l-0 p-r-0 p-t-5 p-b-5 text-center text-middle text-white">Ticket<br>Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sr = 1;
                    $total_pax = $total_seg = $total_total_seg = $total_cost =  0;
                    foreach ($report_details as $key => $booking) { 
                        $total_pax += $booking['pax'];
                        $seg = $booking['legs'];
                        $total_seg += $seg;
                        $totalseg = $booking['legs']*$booking['pax'];                      
                        $total_total_seg += $totalseg;
                        $cost = round($booking['cost'],2);
                        $total_cost += $cost;
                ?>
                <tr bgcolor="#fff">
                    <td class="p-0-5 text-center text-middle"><?php echo $sr; ?></td>
                    <td class="p-0-5 text-center text-middle"><?php echo date('d-M-y',strtotime($booking['date'])) ;?></td>
                    <td class="p-0-5 text-center text-middle"><?php remove_space($booking['brand']); ?></td>
                    <td class="p-0-5 text-center text-middle">
                        <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/issued/".hashing($booking['bkg_no'])) ?>"><?php echo $booking['bkg_no']; ?></a>
                    </td>
                    <td class="p-0-5 text-left text-middle"><?php echo $booking['cust_name']; ?></td>
                    <td class="p-0-5 text-center text-middle"><?php echo $booking['gds'] ; ?></td>
                    <td class="p-0-5 text-center text-middle"><?php echo substr($booking['dest'],-3) ; ?></td>
                    <td class="p-0-5 text-center text-middle"><?php echo substr($booking['airline'],-2) ; ?></td>
                    <td class="p-0-5 text-center text-middle"><?php echo $booking['pnr'] ; ?></td>
                    <td class="p-0-5 text-center text-middle"><?php echo $booking['tkt_no'] ; ?></td>
                    <td class="p-0-5 text-center text-middle"><?php echo $booking['pax'] ; ?></td>
                    <td class="p-0-5 text-center text-middle"><?php echo $booking['legs'] ; ?></td>
                    <td class="p-0-5 text-center text-middle"><?php echo $totalseg ; ?></td>
                    <td class="p-0-5 text-center text-middle"><?php echo(abs($cost) != 0)?number_format($cost,2):'-'; ?></td>
                </tr>
                <?php 
                    $sr++;
                    }
                ?>
            </tbody>
            <tfoot>
                <tr bgcolor="#fff">
                    <th class="text-right p-0-5" colspan="10">Total</th>
                    <th class="text-center p-0-5"><?php echo number_format($total_pax,2) ; ?></th>
                    <th class="text-center p-0-5"><?php echo number_format($total_seg,2) ; ?></th>
                    <th class="text-center p-0-5"><?php echo number_format($total_total_seg,2) ; ?></th>
                    <th class="text-center p-0-5"><?php echo number_format($total_cost,2) ; ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>