<?php 
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=gross_profit.xls");
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
									Gross Profit Sheet
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
								<td colspan="3" style="font-size: 16px;"><strong>Issued Bookings</strong></td>
							</tr>
							<tr>
								<td colspan="3">
									<table cellspacing="0" cellpadding="0" width="100%" style="border: this solid #000;">
										<thead>
											<tr>
							                    <th align="center" width="03%" rowspan="2" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Sr.<br>No.
							                    </th>
							                    <th align="center" width="08%" rowspan="2" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Issue<br>Date
							                    </th>
							                    <th align="center" width="12%" rowspan="2" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Agent<br>Name
							                    </th>
							                    <th align="center" width="08%" rowspan="2" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Booking<br>Ref No.
							                    </th>
							                    <th align="center" width="08%" rowspan="2" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Supplier<br>Ref No.
							                    </th>
							                    <th align="center" width="20%" rowspan="2" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
								                    Customer Name
								                </th>
							                    <th align="center" width="03%" rowspan="2" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
								                    Dest.
								                </th>
							                    <th align="center" width="03%" rowspan="2" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
								                    Pax
								                </th>
							                    <th align="center" width="07%" rowspan="2" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Sale<br>Price
							                    </th>
							                    <th colspan="3" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
								                    Cost
								                </th>
							                    <th align="center" width="07%" rowspan="2" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
								                    Profit
								                </th>
							                </tr>
							                <tr>
							                    <th align="center" width="07%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">Supplier</th>
							                    <th align="center" width="07%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">Add</th>
							                    <th align="center" width="07%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">Total</th>
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
							                <tr bgcolor="#fff">
							                    <td width="03%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $sr; ?>
							                    </td>
							                    <td width="08%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo date('d-M-y',strtotime($issue['clr_date'])) ;?>
							                    </td>
							                    <td width="12%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $issue['bkg_agent']; ?>
							                    </td>
							                    <td width="08%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                        <a href="<?php echo base_url("booking/issued/".hashing($issue['bkg_no'])) ?>">
							                        	<?php echo $issue['bkg_no']; ?>
							                        </a>
							                    </td>
							                    <td width="08%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php custom_echo($issue['bkg_supplier_reference'],12) ; ?>
							                    </td>
							                    <td width="20%" align="left" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	&nbsp;<?php custom_echo($issue['cst_name'],25); ?>
							                    </td>
							                    <td width="03%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo substr($issue['flt_destinationairport'],-3) ; ?>
							                    </td>
							                    <td width="03%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $no_pax; ?>&nbsp;
							                    </td>
							                    <td width="07%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($sale,2) ; ?>&nbsp;
							                    </td>
							                    <td width="07%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($supplier,2) ; ?>&nbsp;
							                    </td>
							                    <td width="07%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($add_cost,2) ; ?>&nbsp;
							                    </td>
							                    <td width="07%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($cost,2) ; ?>&nbsp;
							                    </td>
							                    <td width="07%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($profit,2) ; ?>&nbsp;
							                    </td>
							                </tr>
							                <?php 
							                    $sr++;
							                    }
							                ?>
							            </tbody>
							            <tfoot>
							                <tr bgcolor="#fff">
							                    <th align="right" style="font-size:14px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5" colspan="7">Total</th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_no_pax) ; ?>&nbsp;
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_sale,2) ; ?>&nbsp;
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_supplier,2) ; ?>&nbsp;
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_add_cost,2) ; ?>&nbsp;
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_cost,2) ; ?>&nbsp;
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_profit_issued,2) ; ?>&nbsp;
							                    </th>
							                </tr>
							            </tfoot>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" style="font-size: 16px;"><strong>Cancelled Bookings</strong></td>
							</tr>
							<tr>
								<td colspan="3">
									<table cellspacing="0" cellpadding="0" width="100%" style="border: this solid #000;">
										<thead>
											<tr>
							                    <th align="center" height="20px" width="03%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Sr.<br>No.
							                    </th>
							                    <th align="center" height="20px" width="08%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Cancel<br>Date
							                    </th>
							                    <th align="center" height="20px" width="12%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Agent<br>Name
							                    </th>
							                    <th align="center" height="20px" width="08%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Booking<br>Ref No.
							                    </th>
							                    <th align="center" height="20px" width="08%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Supplier<br>Ref No.
							                    </th>
							                    <th align="center" height="20px" width="20%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
								                    Customer Name
								                </th>
							                    <th align="center" height="20px" width="03%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
								                    Dest.
								                </th>
							                    <th align="center" height="20px" width="03%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
								                    Pax
								                </th>
							                    <th align="center" height="20px" width="07%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Amount<br>Received
							                    </th>
							                    <th align="center" height="20px" width="07%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Amount<br>Refunded
							                    </th>
							                    <th align="center" height="20px" width="07%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Supplier<br>Cost
							                    </th>
							                    <th align="center" height="20px" width="07%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Additional<br>Exp.
							                    </th>
							                    <th align="center" height="20px" width="07%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
								                    Profit
								                </th>
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
							                <tr bgcolor="#fff">
							                    <td width="03%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $sr; ?>
							                    </td>
							                    <td width="08%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo date('d-M-y',strtotime($cancelled['cnl_date'])); ?>
							                    </td>
							                    <td width="12%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $cancelled['bkg_agent']; ?>
							                    </td>
							                    <td width="08%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                        <a href="<?php echo base_url("booking/cancelled/".hashing($cancelled['bkg_no'])) ?>">
							                        	<?php echo $cancelled['bkg_no']; ?>
							                        </a>
							                    </td>
							                    <td width="08%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php custom_echo($cancelled['bkg_supplier_reference'],12) ; ?>
							                    </td>
							                    <td width="20%" align="left" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	&nbsp;<?php custom_echo($cancelled['cst_name'],25); ?>
							                    </td>
							                    <td width="03%" align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo substr($cancelled['flt_destinationairport'],-3) ; ?>
							                    </td>
							                    <td width="03%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $no_pax; ?>&nbsp;
							                    </td>
							                    <td width="07%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($amt_rec,2) ; ?>&nbsp;
							                    </td>
							                    <td width="07%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($amt_rfnd,2) ; ?>&nbsp;
							                    </td>
							                    <td width="07%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($amt_bkg_cost,2) ; ?>&nbsp;
							                    </td>
							                    <td width="07%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($amt_admin_cost,2) ?>&nbsp;
							                    </td>
							                    <td width="07%" align="right" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($profit,2) ; ?>&nbsp;
							                    </td>
							                </tr>
							                <?php 
							                    $sr++;
							                    }
							                ?>
							            </tbody>
							            <tfoot>
							                <tr bgcolor="#fff">
							                    <th align="right" style="font-size:14px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5" colspan="7">Total</th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo $total_no_pax ; ?>&nbsp;
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_amt_rec,2) ; ?>&nbsp;
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_amt_rfnd,2) ; ?>&nbsp;
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_amt_bkg_cost,2) ; ?>&nbsp;
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_amt_admin_cost,2) ?>&nbsp;
							                    </th>
							                    <th align="right" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_profit_cancelled,2) ; ?>&nbsp;
							                    </th>
							                </tr>
							                <tr>
							                	<td colspan="13">&nbsp;</td>
							                </tr>
							                <tr bgcolor="#fff">
							                    <th colspan="7">&nbsp;</th>
							                    <th colspan="4">Total Gross Profit</th>
							                    <th colspan="2">
							                        <?php echo number_format($total_profit_issued+$total_profit_cancelled,2) ; ?>
							                    </th>
							                </tr>
							            </tfoot>
									</table>
								</td>
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