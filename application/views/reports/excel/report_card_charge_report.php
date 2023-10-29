<?php 
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=card_charge.xls");
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
						                    		Charge<br>Date
						                    	</th>
							                    <th width="07%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Booking<br>Id
						                    	</th>
							                    <th width="20%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Customer<br>Name
						                    	</th>
							                    <th width="08%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Booking<br>Status
						                    	</th>
							                    <th width="14%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Authorization<br>Code
						                    	</th>
							                    <th width="08%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Amount<br>Charged
						                    	</th>
							                    <th width="08%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Amount<br>Refunded
						                    	</th>
							                    <th width="08%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Balance
							                    </th>
							                    <th width="08%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Charges
							                    </th>
							                    <th width="08%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
						                    		Net<br>Amount
						                    	</th>
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
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $sr; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                        <?php echo date('d-M-y',strtotime($booking['trans_date'])) ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                        <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/".$booking['bkg_status']."/".hashing($booking['bkg_no'])) ?>"><?php echo $booking['bkg_no']; ?></a>
							                    </td>
							                    <td align="left" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['cst_name']; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['bkg_status'] ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['authcode'] ; ?>
							                    </td>
							                    <td align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo(abs($amt_chrgd) != 0)?number_format($amt_chrgd,2):'-'; ?>
							                    </td>
							                    <td align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo(abs($amt_rfnd) != 0)?number_format($amt_rfnd,2):'-'; ?>
							                    </td>
							                    <td align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo(abs($amt_bal) != 0)?number_format($amt_bal,2):'-'; ?>
							                    </td>
							                    <td align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo(abs($amt_chrges) != 0)?number_format($amt_chrges,2):'-'; ?>
							                    </td>
							                    <td align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($amt_net,2) ; ?>
							                    </td>
							                </tr>
							                <?php 
							                    $sr++;
							                    }
							                ?>
							            </tbody>
							            <tfoot>
							            	<tr bgcolor="#fff">
							                    <th align="right" style="font-size:14px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5" colspan="6">
							                    	Total
							                   	</th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_amt_chrgd,2) ; ?>
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_amt_rfnd,2) ; ?>
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_amt_bal,2) ; ?>
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_amt_chrges,2) ; ?>
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_amt_net,2) ; ?>
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