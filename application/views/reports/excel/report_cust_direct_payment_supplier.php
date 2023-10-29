<?php 
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Customer_Direct_Payment_supplier.xls");
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
							                    <th width="09%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Booking Date
							                    </th>
							                    <th width="10%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Traveling Date
							                    </th>
							                    <th width="10%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Supplier Name
							                    </th>
							                    <th width="08%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Bkg Id
							                    </th>
							                    <th width="10%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Supp. Ref
							                    </th>
							                    <th width="20%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Customer Name
							                    </th>
							                    <th width="10%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Brand
							                    </th>
							                    <th width="10%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Agent
							                    </th>
							                    <th width="10%" align="center" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
							                    	Balance Due
							                    </th>
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
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $sr; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                        <?php echo date('d-M-y',strtotime($booking['bkg_date'])) ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo date('d-M-y',strtotime($booking['flt_departuredate'])) ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['sup_name'] ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                        <a class="font-weight-bold text-blue" href="<?php echo base_url("booking/pending/".hashing($booking['bkg_no'])) ?>"><?php echo $booking['bkg_no']; ?></a>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['bkg_supplier_reference'] ;?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['cst_name']; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['bkg_brandname'] ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo $booking['bkg_agent'] ; ?>
							                    </td>
							                    <td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
							                    	<?php echo number_format($amt_due,2) ; ?>
							                    </td>
							                </tr>
							                <?php 
							                    $sr++;
							                    }
							                ?>
							            </tbody>
							            <tfoot>
							                <tr bgcolor="#fff">
							                    <th align="right" style="font-size:14px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5" colspan="9">Total</th>
							                    <th align="center" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
							                    	<?php echo number_format($total_due,2) ; ?>
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