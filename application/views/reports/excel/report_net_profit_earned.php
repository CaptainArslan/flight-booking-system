<?php 
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=net_profit.xls");
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
									Net Profit Sheet
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
							                    $total_profit_issued_un = 0;
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
							                        if($profit > 0){
							                            $total_profit_issued_un += $profit;
							                        }
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
							                    $total_profit_cancelled_un = 0;
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
							                        if($profit > 0){
							                            $total_profit_cancelled_un += $profit;
							                        }
							                        
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
							                    <th colspan="8">&nbsp;</th>
							                    <th colspan="3" align="left">Total Gross Profit</th>
							                    <th>&nbsp;</th>
							                    <th align="center">
							                        <?php echo number_format($total_profit_issued+$total_profit_cancelled,2) ; ?>
							                    </th>
							                </tr>
							                <tr bgcolor="#fff">
							                    <th colspan="8" >&nbsp;</th>
							                    <th colspan="3" align="left" ><strong>Less Expenses:</strong></th>
							                    <th >&nbsp;</th>
							                    <th >&nbsp;</th>
							                </tr>
							                <?php 
							                    $grand_total = (double)$total_profit_issued+(double)$total_profit_cancelled;
							                    $grand_total_un = (double)$total_profit_issued_un +(double)$total_profit_cancelled_un;
							                    $comm = 0;
							                    if($brand != 'All' && $brand_com_rate != 0){
							                        $comm = $brand_com_rate;
							                        $comm =  round((($grand_total_un*(double)$brand_com_rate)/100),2);

							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8" style="line-height:18px;font-size:12px;">&nbsp;</th>
							                    <th colspan="3" align="left" style="line-height:18px;font-size:12px;">Service Commission</th>
							                    <th align="right" style="line-height:18px;font-size:12px;">
							                    	<?php echo number_format($comm,2); ?>
							                    </th>
							                    <th style="line-height:18px;font-size:12px;">&nbsp;</th>
							                </tr>
							                <?php 
							                    }
							                    $total_exp = 0;
							                    $no_exp = count($expenses);
							                    if($no_exp > 0 ){
							                        foreach ($expenses as $key => $exp) {
							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8" style="line-height:18px;font-size:12px;">&nbsp;</th>
							                    <th colspan="3" align="left" style="line-height:18px;font-size:12px;">
							                        <?php echo $exp['head'] ; ?>
							                    </th>
							                    <th align="right" style="line-height:18px;font-size:12px;">
							                        <?php echo number_format($exp['exp_amt'],2) ; ?>
							                    </th>
							                    <th style="line-height:18px;font-size:12px;">&nbsp;</th>
							                </tr>
							                <?php
							                        $total_exp += $exp['exp_amt'];
							                        }
							                    }
							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8">&nbsp;</th>
							                    <th colspan="3" align="left" style="color: #666;">
							                        <strong><em>Total Expenses</em></strong>
							                    </th>
							                    <th>&nbsp;</th>
							                    <th align="center" style="border-bottom:thin solid #bbbbbb !important;border-top:none;color: #F00;">
							                        (<?php echo number_format($total_exp+$comm,2) ; ?>)
							                    </th>
							                </tr>
							                <?php 
							                    $total_incomes = 0;
							                    $ttlcm = 0;
							                    if($brand == $this->mainbrand){
							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8" style="line-height:18px;font-size:12px;">&nbsp;</th>
							                    <th colspan="3" align="left" style="line-height:18px;font-size:12px;color: #666;">&nbsp;</th>
							                    <th style="line-height:18px;font-size:12px;">&nbsp;</th>
							                    <th align="center" style="line-height:18px;font-size:12px;">
							                        <strong><?php echo number_format($grand_total - ($total_exp+$comm),2) ; ?></strong>
							                    </th>
							                </tr>
							                <<?php 
							                        $no_oi = count($other_income);
							                        if($no_oi > 0 ){
							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8">&nbsp;</th>
							                    <th colspan="3" align="left"><strong>Additional Incomes:</strong></th>
							                    <th>&nbsp;</th>
							                    <th>&nbsp;</th>
							                </tr>
							                <?php
							                            foreach ($other_income as $key => $oi) {
							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8" style="line-height:18px;font-size:12px;">&nbsp;</th>
							                    <th colspan="3" align="left" style="line-height:18px;font-size:12px;">
							                        <?php echo $oi['head'] ; ?>
							                    </th>
							                    <th align="right" style="line-height:18px;font-size:12px;">
							                        <?php echo number_format($oi['incm_amt'],2) ; ?>
							                    </th>
							                    <th style="line-height:18px;font-size:12px;">&nbsp;</th>
							                </tr>
							                <?php
							                            $total_incomes += $oi['incm_amt'];
							                            }
							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8">&nbsp;</th>
							                    <th colspan="3" align="left" style="color: #666;">
							                        <strong><em>Total Misc Income</em></strong>
							                    </th>
							                    <th>&nbsp;</th>
							                    <th align="center" style="border-bottom:thin solid #bbbbbb !important;border-top:none;color: #F00;">
							                        (<?php echo number_format($total_incomes,2) ; ?>)
							                    </th>
							                </tr>
							                <tr bgcolor="#fff">
							                    <th colspan="8" style="line-height:18px;font-size:12px;">&nbsp;</th>
							                    <th colspan="3" align="left" style="line-height:18px;font-size:12px;color: #666;">&nbsp;</th>
							                    <th style="line-height:18px;font-size:12px;">&nbsp;</th>
							                    <th align="center" style="line-height:18px;font-size:12px;">
							                        <strong><?php echo number_format($grand_total+$total_incomes - ($total_exp+$comm),2) ; ?></strong>
							                    </th>
							                </tr>
							                <?php 
							                        }
							                        $no_sa = count($sub_agent);
							                        if($no_sa > 0 ){
							                        
							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8">&nbsp;</th>
							                    <th colspan="3" align="left"><strong>Additional Incomes:</strong></th>
							                    <th>&nbsp;</th>
							                    <th>&nbsp;</th>
							                </tr>
							                <?php
							                            foreach ($sub_agent as $key => $sub_a) {
							                                if($sub_a['head_amt'] == 0){
							                                    continue;
							                                }
							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8" style="line-height:18px;font-size:12px;">&nbsp;</th>
							                    <th colspan="3" align="left" style="line-height:18px;font-size:12px;">
							                        <?php echo $sub_a['head'] ; ?>
							                    </th>
							                    <th align="right" style="line-height:18px;font-size:12px;">
							                        <?php echo number_format($sub_a['head_amt'],2) ; ?>
							                    </th>
							                    <th style="line-height:18px;font-size:12px;">&nbsp;</th>
							                </tr>
							                <?php
							                            $ttlcm += $sub_a['head_amt'];
							                            }
							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8">&nbsp;</th>
							                    <th colspan="3" align="left" style="color: #666;">
							                        <strong><em>Total Sub Agents Comm.</em></strong>
							                    </th>
							                    <th>&nbsp;</th>
							                    <th align="center" style="border-bottom:thin solid #bbbbbb !important;border-top:none;color: #F00;">
							                        (<?php echo number_format($ttlcm,2) ; ?>)
							                    </th>
							                </tr>
							                <?php
							                        }
							                    }
							                ?>
							                <tr bgcolor="#fff">
							                    <th colspan="8" style="line-height:18px;font-size:12px;">&nbsp;</th>
							                    <th colspan="3" align="left" style="line-height:18px;font-size:12px;color: #666;">
							                        <strong>Net Balance:</strong>
							                    </th>
							                    <th style="line-height:18px;font-size:12px;">&nbsp;</th>
							                    <th align="center" style="line-height:18px;font-size:12px;">
							                        <strong><?php echo number_format(round(($grand_total+$total_incomes+$ttlcm),2) - ($total_exp+$comm),2) ; ?></strong>
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