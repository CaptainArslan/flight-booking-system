<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=supplier_due_balance.xls");
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

		body,
		td,
		th {
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
									echo ($this->session->userdata('user_brand') == 'All') ? "" : $this->session->userdata('user_brand');
									?>
								</td>
							</tr>
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>
							<tr>
								<td width="70%">
									<strong>From : </strong><?php echo date("d-M-Y", strtotime($start_date)); ?>&nbsp;&nbsp;&nbsp;<strong>To : </strong><?php echo date("d-M-Y", strtotime($end_date)); ?>
								</td>
								<td colspan="2"><?php echo date("d-M-Y"); ?></td>
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
									<table cellspacing="0" cellpadding="0" width="100%" style="border: this solid #000;table-layout: fixed;word-wrap:break-word;">
										<thead>
											<tr>
												<th align="center" width="05%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
													#
												</th>
												<th align="center" width="10%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
													Issue
												</th>
												<th align="center" width="10%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
													Agent
												</th>
												<th align="center" width="15%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
													Brand
												</th>
												<th align="center" width="10%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
													Bkg Id
												</th>
												<th align="center" width="20%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
													Supplier Name
												</th>
												<th align="center" width="15%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
													Supp. Ref
												</th>
												<th align="center" width="15%" bgcolor="#039be0" style="color:#ffffff;border: thin solid #bbbbbb">
													Balance Due
												</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sr = 1;
											$total_supp_due = 0;
											foreach ($report_details as $key => $issue) {
												$amt_due = $issue['ticket_cost'];
												$total_supp_due += $amt_due;

											?>
												<tr bgcolor="#fff">
													<td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
														<?php echo $sr; ?>
													</td>
													<td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
														<?php echo date('d-M-y', strtotime($issue['issued_date'])); ?>
													</td>
													<td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
														<?php echo $issue['bkg_agent']; ?>
													</td>
													<td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
														<?php echo $issue['bkg_brandname']; ?>
													</td>
													<td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
														<a class="font-weight-bold text-blue" href="<?php echo base_url("booking/issued/" . hashing($issue['trans_ref'])) ?>"><?php echo $issue['trans_ref']; ?></a>
													</td>
													<td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
														<?php echo $issue['supplier']; ?>
													</td>
													<td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
														<?php echo $issue['sup_ref']; ?>
													</td>
													<td align="center" style="border-bottom: thin solid #bbbbbb;font-size: 15px;">
														<?php echo number_format($amt_due, 2); ?>
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
												<th align="center" style="font-size:15px;border: thin solid #bbbbbb;" bgcolor="#f5f5f5">
													<?php echo number_format($total_supp_due, 2); ?>
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
