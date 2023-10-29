<?php 
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=gds_report.xls");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body {
			margin-left: 0px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 0px;
		}
		body,td,th {
			font-family: "Calibri", Arial, Helvetica, sans-serif;
		}
	</style>
</head>
<body>
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tbody>
			<tr>
				<td>&nbsp;</td>
				<td>
					<table cellspacing="0" cellpadding="0" width="95%" align="center" border="0">
						<tbody>
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>
							<tr>
								<td width="70%" style="font-weight: bold;font-size: 20px;" align="left">
									<?php echo getrptname($report_name); ?>
								</td>
								<td width="30%" colspan="2" style="font-weight: bold;font-size: 20px;" align="right">
									<?php 
				                        echo($this->session->userdata('user_brand')=='All')?"":$this->session->userdata('user_brand');
				                    ?>
								</td>
							</tr>
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>
							<tr>
								<td width="70%">
									<strong>From : </strong><?php echo date("d-M-Y",strtotime($start_date)); ?>&nbsp;&nbsp;&nbsp;<strong>To : </strong><?php echo date("d-M-Y",strtotime($end_date)); ?>
								</td>
								<td colspan="2"><?php echo date("d-M-Y") ;?></td>
							</tr>
							<tr>
								<td width="70%">
									<strong>Agent : </strong><?php echo $agent; ?>
								</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td width="70%">
									<strong>Brand : </strong><?php echo $brand; ?>
								</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td width="70%">
									<strong>Supplier : </strong><?php echo $supplier; ?>
								</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" style="font-size: 16px;"><strong>Pending Bookings</strong></td>
							</tr>
							<tr>
								<td colspan="3">
									<table cellspacing="0" cellpadding="0" width="100%" style="border: this solid #000;table-layout: fixed;word-wrap:break-word;">
										<thead>
											<tr>
							                    <th width="03%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	#
							                    </th>
							                    <th width="08%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Issue<br>Date
						                    	</th>
							                    <th width="12%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Brand<br>Name
						                    	</th>
							                    <th width="08%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Booking<br>Ref
						                    	</th>
							                    <th width="15%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Customer Name
							                    </th>
							                    <th width="11%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	GDS
							                    </th>
							                    <th width="05%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Dest
							                    </th>
							                    <th width="05%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Airline
							                    </th>
							                    <th width="07%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	PNR
							                    </th>
							                    <th width="10%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	E-Ticket No.
							                    </th>
							                    <th width="03%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Pax
							                    </th>
							                    <th width="03%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Seg.
							                    </th>
							                    <th width="05%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Total<br>Seg
						                    	</th>
							                    <th width="05%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Ticket<br>Cost
						                    	</th>
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
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $sr; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo date('d-M-y',strtotime($booking['date'])) ;?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php remove_space($booking['brand']); ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<a class="font-weight-bold text-blue" href="<?php echo base_url("booking/issued/".hashing($booking['bkg_no'])) ?>"><?php echo $booking['bkg_no']; ?></a>
							                    </td>
							                    <td align="left" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['cust_name']; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['gds'] ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo substr($booking['dest'],-3) ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo substr($booking['airline'],-2) ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['pnr'] ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['tkt_no'] ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['pax'] ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['legs'] ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $totalseg ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo(abs($cost) != 0)?number_format($cost,2):'-'; ?>
							                    </td>
							                </tr>
							                <?php 
							                    $sr++;
							                    }
							                ?>
							            </tbody>
							            <tfoot>
							            	<tr bgcolor="#fff">
							                    <th align="right" style="font-size:14px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5" colspan="10">
							                    	Total
							                    </th>
							                    <th align="center" style="font-size:14px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_pax,2) ; ?>
							                    </th>
							                    <th align="center" style="font-size:14px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_seg,2) ; ?>
							                    </th>
							                    <th align="center" style="font-size:14px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_total_seg,2) ; ?>
							                    </th>
							                    <th align="center" style="font-size:14px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_cost,2) ; ?>
							                    </th>
							                </tr>
							            </tfoot>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td>&nbsp;</td>
			</tr>
		</tbody>
	</table>
</body>
</html>