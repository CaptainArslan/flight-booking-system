<div class="modal modal-blur fade issue_booking">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title font-weight-bold" id="sendpaylinkLabel1">Issue Booking - <?php echo $bkg['bkg_no']; ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<form id="issuanceForm">
					<input type="hidden" name="pid" value="<?php echo @$pid; ?>">
					<input type="hidden" name="bkg_no" value="<?php echo $bkg['bkg_no']; ?>">
					<input type="hidden" name="cost_bank_charges_internal" value="<?php echo $bkg['cost_bank_charges_internal']; ?>">
					<input type="hidden" name="cost_cardcharges" value="<?php echo $bkg['cost_cardcharges']; ?>">
					<input type="hidden" name="flight" value="<?php echo $bkg['flight'] ?>">
					<input type="hidden" name="hotel" value="<?php echo $bkg['hotel'] ?>">
					<input type="hidden" name="cab" value="<?php echo $bkg['cab'] ?>">
					<h4>Issuance Details</h4>
					<div class="row m-t-5">
						<div class="col-md-2">
							<div class="form-group">
								<label class="form-label">Issuance Date <span class="text-danger">*</span></label>
								<div class="controls">
									<input type="text" name="issue_date" class="date form-control " value="<?php echo date('d-M-Y'); ?>" autocomplete="off" required data-parsley-error-message="Enter Booking Date" data-parsley-trigger="focusin focusout">
								</div>
							</div>
						</div>
						<?php
						if ($bkg['flight']) {
						?>

							<div class="col-md-2">
								<div class="form-group">
									<label class="form-label">Flight Supplier <span class="text-danger">*</span></label>
									<div class="controls">
										<select name="supplier_name" class="form-control " autocomplete="off" required data-parsley-error-message="Select Booking Supplier" data-parsley-trigger="focusin focusout">
											<option value="">Select Booking Supplier</option>
											<?php
											foreach ($suppliers as $key => $supplier) {
												if ($supplier['supplier_name'] == 'All') {
													continue;
												}
											?>
												<option value="<?php echo $supplier['supplier_name']; ?>" <?php echo ($supplier['supplier_name'] == $bkg['sup_name']) ? 'selected' : ''; ?>><?php echo $supplier['supplier_name']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="form-label">Flight Supplier Ref#<span class="text-danger">*</span></label>
									<div class="controls">
										<input type="text" name="bkg_supplier_reference" class="form-control " autocomplete="off" data-parsley-trigger="focusin focusout" value="<?php echo $bkg['bkg_supplier_reference']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="form-label">GDS <span class="text-danger">*</span></label>
									<div class="controls">
										<select name="flt_gds" id="flt_gds" class="form-control " autocomplete="off" required data-parsley-trigger="focusin focusout" data-parsley-error-message="Select Booking GDS">
											<option value="">Select Booking GDS</option>
											<option value="World-Span" <?php echo ($bkg['flt_gds'] == 'World-Span') ? 'selected' : '' ?>>
												World Span
											</option>
											<option value="Galileo" <?php echo ($bkg['flt_gds'] == 'Galileo') ? 'selected' : '' ?>>
												Galileo
											</option>
											<option value="Sabre" <?php echo ($bkg['flt_gds'] == 'Sabre') ? 'selected' : '' ?>>
												Sabre
											</option>
											<option value="Amadeus" <?php echo ($bkg['flt_gds'] == 'Amadeus') ? 'selected' : '' ?>>
												Amadeus
											</option>
											<option value="Web" <?php echo ($bkg['flt_gds'] == 'Web') ? 'selected' : '' ?>>
												Web
											</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="form-label">PNR<span class="text-danger">*</span></label>
									<div class="controls">
										<input type="text" name="flt_pnr" id="flt_pnr" class="form-control " autocomplete="off" required data-parsley-trigger="focusin focusout" data-parsley-error-message="Enter Flight PNR" value="<?php echo $bkg['flt_pnr']; ?>">
									</div>
								</div>
							</div>

						<?php
						} ?>
					</div>
					<div class="row m-t-5">
						<?php
						if ($bkg['hotel']) {
						?>
							<div class="col-md-2">
								<div class="form-group">
									<label class="form-label">Hotel<span class="text-danger">*</span></label>
									<div class="controls">
										<input type="text" name="htl_name" class="form-control " autocomplete="off" data-parsley-trigger="focusin focusout" value="<?php echo $htl['name']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="form-label">Hotel Supplier <span class="text-danger">*</span></label>
									<div class="controls">
										<select name="htl_sup" class="form-control " autocomplete="off" required data-parsley-error-message="Select Booking Supplier" data-parsley-trigger="focusin focusout">
											<option value="">Select Hotel Supplier</option>
											<?php
											foreach ($suppliers as $key => $supplier) {
												if ($supplier['supplier_name'] == 'All') {
													continue;
												}
											?>
												<option value="<?php echo $supplier['supplier_name']; ?>" <?php echo ($supplier['supplier_name'] == $htl['supplier']) ? 'selected' : ''; ?>><?php echo $supplier['supplier_name']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="form-label">Hotel Supplier Ref#<span class="text-danger">*</span></label>
									<div class="controls">
										<input type="text" name="htl_sup_ref" class="form-control " autocomplete="off" data-parsley-trigger="focusin focusout" value="<?php echo $htl['sup_ref']; ?>">
									</div>
								</div>
							</div>
						<?php
						}
						if ($bkg['cab']) {
						?>
							<div class="col-md-2">
								<div class="form-group">
									<label class="form-label">Cab<span class="text-danger">*</span></label>
									<div class="controls">
										<input type="text" name="cab_name" class="form-control " autocomplete="off" data-parsley-trigger="focusin focusout" value="<?php echo $cab['name']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="form-label">Cab Supplier <span class="text-danger">*</span></label>
									<div class="controls">
										<select name="cab_sup" class="form-control " autocomplete="off" required data-parsley-error-message="Select Booking Supplier" data-parsley-trigger="focusin focusout">
											<option value="">Select Cab Supplier</option>
											<?php
											foreach ($suppliers as $key => $supplier) {
												if ($supplier['supplier_name'] == 'All') {
													continue;
												}
											?>
												<option value="<?php echo $supplier['supplier_name']; ?>" <?php echo ($supplier['supplier_name'] == $cab['supplier']) ? 'selected' : ''; ?>><?php echo $supplier['supplier_name']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="form-label">Cab Supplier Ref#<span class="text-danger">*</span></label>
									<div class="controls">
										<input type="text" name="cab_sup_ref" class="form-control " autocomplete="off" data-parsley-trigger="focusin focusout" value="<?php echo $cab['sup_ref']; ?>">
									</div>
								</div>
							</div>
						<?php
						}
						?>
					</div>
					<div class="row m-t-5">
						<div class="col-md-12">
							<div class="form-group m-b-0">
								<label class="form-label">Booking Note</label>
								<div class="controls">
									<textarea name="flt_bookingnote" class="form-control " rows="3"></textarea>
								</div>
							</div>
						</div>
					</div>
					<hr class="m-b-0">
					<?php
					$tkt_cost = 0;
					$payable_sup = 0;
					$add_exp = 0;
					$add_exp = $bkg['cost_bank_charges_internal'] + $bkg['cost_cardcharges'] + $bkg['cost_postage'] + $bkg['cost_cardverfication'];
					if ($bkg['flight']) {
						$payable_sup = $bkg['cost_basic'] + $bkg['cost_tax'] + $bkg['cost_apc'] + $bkg['cost_misc'] + $bkg['cost_safi'];
					}
					if ($bkg['hotel']) {
						$payable_sup += $htl['cost'];
					}
					if ($bkg['cab']) {
						$payable_sup += $cab['cost'];
					}
					$tkt_cost = $payable_sup + $add_exp;
					?>
					<div class="row m-t-5">
						<div class="col-md-12">
							<h4 class="m-t-20">Ticket Cost: <strong style="font-weight: 600;" class="text-danger tkt_cost"><?php echo number_format($tkt_cost, 2); ?></strong></h4>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<h5 class="card-title">I) Payable to Supplier: <strong class="text-danger payable_sup"><?php echo number_format($payable_sup, 2); ?></strong></h5>
								</div>
								<?php
								$cost_class = 'col-md-3';
								if ($bkg['cab'] || $bkg['hotel']) {
									$cost_class = 'col-md-2';
								}
								if ($bkg['flight']) {
								?>
									<div class="<?php echo $cost_class; ?>">
										<div class="form-group">
											<label class="form-label">Basic <span class="text-danger">*</span></label>
											<div class="controls">
												<input type="number" step="0.01" name="cost_basic" id="cost_basic" class="form-control  costs" data-parsley-error-message="Please enter digits" data-parsley-trigger="focusin focusout" value="<?php echo $bkg['cost_basic']; ?>">
											</div>
										</div>
									</div>
									<div class="<?php echo $cost_class; ?>">
										<div class="form-group">
											<label class="form-label">Tax <span class="text-danger">*</span></label>
											<div class="controls">
												<input type="number" step="0.01" name="cost_tax" id="cost_tax" class="form-control  costs" data-parsley-error-message="Please enter digits" data-parsley-trigger="focusin focusout" value="<?php echo $bkg['cost_tax']; ?>">
											</div>
										</div>
									</div>
									<div class="<?php echo $cost_class; ?>">
										<div class="form-group">
											<label class="form-label">APC <span class="text-danger">*</span></label>
											<div class="controls">
												<input type="number" step="0.01" name="cost_apc" id="cost_apc" class="form-control  costs" data-parsley-error-message="Please enter digits" data-parsley-trigger="focusin focusout" value="<?php echo $bkg['cost_apc']; ?>">
											</div>
										</div>
									</div>
									<div class="<?php echo $cost_class; ?>">
										<div class="form-group">
											<label class="form-label">Misc. <span class="text-danger">*</span></label>
											<div class="controls">
												<input type="number" step="0.01" name="cost_misc" id="cost_misc" class="form-control  costs" data-parsley-error-message="Please enter digits" data-parsley-trigger="focusin focusout" value="<?php echo $bkg['cost_misc']; ?>">
											</div>
										</div>
									</div>
								<?php
								}
								if ($bkg['hotel']) {
								?>
									<div class="<?php echo $cost_class; ?>">
										<div class="form-group">
											<label class="form-label">Hotel <span class="text-danger">*</span></label>
											<div class="controls">
												<input type="number" step="0.01" name="htl_cost" id="htl_cost" class="form-control  costs" data-parsley-error-message="Please enter digits" data-parsley-trigger="focusin focusout" value="<?php echo $htl['cost']; ?>">
											</div>
										</div>
									</div>
								<?php
								}
								if ($bkg['cab']) {
								?>
									<div class="<?php echo $cost_class; ?>">
										<div class="form-group">
											<label class="form-label">Cab <span class="text-danger">*</span></label>
											<div class="controls">
												<input type="number" step="0.01" name="cab_cost" id="cab_cost" class="form-control  costs" data-parsley-error-message="Please enter digits" data-parsley-trigger="focusin focusout" value="<?php echo $cab['cost']; ?>">
											</div>
										</div>
									</div>
								<?php
								}
								?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<h5 class="card-title">II) Additional Expenses: <strong class="text-danger add_exp"><?php echo number_format($add_exp, 2); ?></strong></h5>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="form-label">Bank <span class="text-danger">*</span></label>
										<div class="controls">
											<input type="number" step="0.01" disabled class="form-control " value="<?php echo $bkg['cost_bank_charges_internal']; ?>">
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="form-label">Card <span class="text-danger">*</span></label>
										<div class="controls">
											<input type="number" step="0.01" disabled class="form-control " value="<?php echo $bkg['cost_cardcharges']; ?>">
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="form-label">APC <span class="text-danger">*</span></label>
										<div class="controls">
											<input type="number" step="0.01" name="cost_postage" id="cost_postage" class="form-control  costs" data-parsley-error-message="Please enter digits" data-parsley-trigger="focusin focusout" value="<?php echo $bkg['cost_postage']; ?>">
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="form-label">Misc. <span class="text-danger">*</span></label>
										<div class="controls">
											<input type="number" step="0.01" name="cost_cardverfication" id="cost_cardverfication" class="form-control  costs" data-parsley-error-message="Please enter digits" data-parsley-trigger="focusin focusout" value="<?php echo $bkg['cost_cardverfication']; ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h4 class="card-title m-t-0 m-b-10">Passenger Details</h4>
						</div>
					</div>
					<div class="table-responsive">
						<table id="paxtable" class="table full-color-table full-info-table hover-table m-b-0">
							<thead>
								<tr>
									<th width="05%" class="text-center">Title</th>
									<th width="12%" class="text-center">First Name</th>
									<th width="05%" class="text-center">Mid</th>
									<th width="12%" class="text-center">Sur Name</th>
									<th width="07%" class="text-center">Age/DOB</th>
									<th width="07%" class="text-center">Pax type</th>
									<th width="07%" class="text-center">Flight</th>
									<th width="07%" class="text-center">Hotel</th>
									<th width="07%" class="text-center">Cab</th>
									<th width="07%" class="text-center">Fee</th>
									<th width="07%" class="text-center">Total</th>
									<th width="17%" class="text-center">E-ticket #</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$totalsale = 0;
								$totalflight = 0;
								$totalhotel = 0;
								$totalcab = 0;
								$profit = 0;
								foreach ($pax as $key => $passenger) {
								?>
									<tr>
										<td class="p-0-5 text-center"><?php echo $passenger['p_title']; ?></td>
										<td class="p-0-5 text-center"><?php echo $passenger['p_firstname']; ?></td>
										<td class="p-0-5 text-center"><?php echo $passenger['p_middlename']; ?></td>
										<td class="p-0-5 text-center"><?php echo $passenger['p_lastname']; ?></td>
										<td class="p-0-5 text-center"><?php echo $passenger['p_age']; ?></td>
										<td class="p-0-5 text-center"><?php echo $passenger['p_catagory']; ?></td>
										<td class="p-0-5 text-center"><?php echo number_format($passenger['p_basic'] + $passenger['p_tax'], 2); ?></td>
										<td class="p-0-5 text-center"><?php echo number_format($passenger['p_hotel'], 2); ?></td>
										<td class="p-0-5 text-center"><?php echo number_format($passenger['p_cab'], 2); ?></td>
										<td class="p-0-5 text-center"><?php echo number_format($passenger['p_bookingfee'] + $passenger['p_cardcharges'] + $passenger['p_others'], 2); ?></td>
										<td class="p-0-5 text-center">
											<?php
											echo number_format(($passenger['p_basic'] + $passenger['p_tax'] + $passenger['p_bookingfee'] + $passenger['p_cardcharges'] + $passenger['p_others'] + $passenger['p_hotel'] + $passenger['p_cab']), 2);
											?>
										</td>
										<td class="p-0-5 text-center">
											<input type="text" value="<?php echo $passenger['p_eticket_no']; ?>" name="eticket[<?php echo $passenger['p_id'] ?>]" class="form-control " required>
										</td>
									</tr>
								<?php
									$totalflight += $passenger['p_basic'] + $passenger['p_tax'] + $passenger['p_bookingfee'] + $passenger['p_cardcharges'] + $passenger['p_others'];
									$totalhotel += $passenger['p_hotel'];
									$totalcab += $passenger['p_cab'];
									$totalsale += $passenger['p_basic'] + $passenger['p_tax'] + $passenger['p_bookingfee'] + $passenger['p_cardcharges'] + $passenger['p_others'] + $passenger['p_hotel'] + $passenger['p_cab'];
								}
								$profit = $totalsale - $tkt_cost;
								?>
								<input type="hidden" name="totalsale" value="<?php echo $totalsale; ?>">
								<input type="hidden" name="totalflight" value="<?php echo $totalflight; ?>">
								<input type="hidden" name="totalhotel" value="<?php echo $totalhotel; ?>">
								<input type="hidden" name="totalcab" value="<?php echo $totalcab; ?>">
							</tbody>
						</table>
						<table id="paxtable" class="table full-color-table full-info-table hover-table">
							<tfoot>
								<tr>
									<th width="1%">&nbsp;</th>
									<th width="14%" class="text-left">Total Sale Price:</th>
									<th width="58%" class="text-danger"><strong><?php echo number_format($totalsale, 2); ?></strong></th>
									<th width="12%" class="text-right">Profit:</th>
									<th width="15%" class="text-danger"><strong><?php echo number_format($profit, 2); ?></strong></th>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h4 class="card-title m-t-0 m-b-10">Receipts from Customer</h4>
						</div>
					</div>
					<div class="table-responsive">
						<table id="paxtable" class="table full-color-table full-info-table hover-table m-b-0">
							<thead>
								<tr>
									<th width="7%" class="text-center">Trans. ID</th>
									<th width="13%" class="text-center">Receipt Date</th>
									<th width="30%" class="text-center">Receipt Via</th>
									<th width="30%" class="text-center">Authorization Code</th>
									<th width="20%" class="text-center">Amount Received</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sr = 1;
								$total_rows = count($cust_trans);
								$amountRec = 0;
								foreach ($cust_trans as $key => $cust_tran) {
								?>
									<tr>
										<td width="07%" class="text-center text-middle p-0-5"><?php echo $cust_tran['trans_id']; ?></td>
										<td width="13%" class="text-center text-middle p-0-5"><?php echo date("d-M-Y", strtotime($cust_tran['trans_date'])); ?></td>
										<td width="30%" class="text-center text-middle p-0-5"><?php echo $cust_tran['trans_by_to']; ?></td>
										<td width="30%" class="text-center text-middle p-0-5"><?php echo $cust_tran['t_card']; ?></td>
										<td width="20%" class="text-center text-middle p-0-5"><?php echo ($cust_tran["trans_type"] == 'Dr') ? "-" . $cust_tran['trans_amount'] : $cust_tran['trans_amount']; ?></td>
									</tr>
									<tr>
										<td colspan="5" class="p-t-0 p-b-0 p-r-0 p-l-10 <?php echo ($sr != $total_rows) ? "border-bottom-dark" : ""; ?>">
											<small class="font-weight-600"><?php echo $cust_tran['trans_description']; ?></small>
										</td>
									</tr>
									<?php
									$sr++;
									if ($cust_tran['trans_amount'] == "Dr") {
										$amountRec -= $cust_tran['trans_amount'];
									} else {
										$amountRec += $cust_tran['trans_amount'];
									}
								}
								if ($total_rows == 0) {
									?>
									<tr>
										<td colspan="5" class="text-center p-0-5">No Transaction Found</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<table id="paxtable" class="table full-color-table full-info-table hover-table">
							<tfoot>
								<tr>
									<th width="1%">&nbsp;</th>
									<th width="19%" class="text-left">Amount Pending:</th>
									<th width="20%" class="text-danger"><strong class="font-weight-600 amtpend"><?php echo number_format($totalsale - $amountRec, 2); ?></strong></th>
									<th width="35%" class="text-right">Total Amount Received:</th>
									<th width="25%" class="text-danger"><strong class="font-weight-600"><?php echo number_format($amountRec, 2); ?></strong></th>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h4 class="card-title m-t-0 m-b-10">Payments to Supplier</h4>
						</div>
					</div>
					<div class="table-responsive">
						<table id="paxtable" class="table full-color-table full-info-table hover-table m-b-0">
							<thead>
								<tr>
									<th width="7%" class="text-center">Trans. ID</th>
									<th width="13%" class="text-center">Payment Date</th>
									<th width="30%" class="text-center">Payment Via</th>
									<th width="30%" class="text-center">Authorization Code</th>
									<th width="20%" class="text-center">Amount Paid</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sr = 1;
								$total_rows = count($supp_trans);
								$amountpaid = 0;
								foreach ($supp_trans as $key => $supp_tran) {
								?>
									<tr>
										<td width="07%" class="text-center text-middle p-0-5"><?php echo $supp_tran['trans_id']; ?></td>
										<td width="13%" class="text-center text-middle p-0-5"><?php echo date("d-M-Y", strtotime($supp_tran['trans_date'])); ?></td>
										<td width="30%" class="text-center text-middle p-0-5"><?php echo $supp_tran['trans_by_to']; ?></td>
										<td width="30%" class="text-center text-middle p-0-5"><?php echo $supp_tran['t_card']; ?></td>
										<td width="20%" class="text-center text-middle p-0-5"><?php echo ($supp_tran["trans_type"] == 'Cr') ? "-" . $supp_tran['trans_amount'] : $supp_tran['trans_amount']; ?></td>
									</tr>
									<tr>
										<td colspan="5" class="p-t-0 p-b-0 p-r-0 p-l-10 <?php echo ($sr != $total_rows) ? "border-bottom-dark" : ""; ?>">
											<small class="font-weight-600"><?php echo $supp_tran['trans_description']; ?></small>
										</td>
									</tr>
									<?php
									$sr++;
									if ($supp_tran['trans_amount'] == "Dr") {
										$amountpaid -= $supp_tran['trans_amount'];
									} else {
										$amountpaid += $supp_tran['trans_amount'];
									}
								}
								if ($total_rows == 0) {
									?>
									<tr>
										<td colspan="5" class="text-center p-0-5">No Transaction Found</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<table id="paxtable" class="table full-color-table full-info-table hover-table">
							<tfoot>
								<tr>
									<th width="1%">&nbsp;</th>
									<th width="14%" class="text-left">Total Payable:</th>
									<th width="15%" class="text-danger">
										<strong><?php echo number_format($payable_sup, 2); ?></strong>
									</th>
									<th width="23%" class="text-right">Total Amount Paid:</th>
									<th width="20%" class="text-danger">
										<strong><?php echo number_format($amountpaid, 2); ?></strong>
									</th>
									<th width="14%" class="text-right">Pending Amount:</th>
									<th width="13%" class="text-danger">
										<strong><?php echo number_format($payable_sup - $amountpaid, 2); ?></strong>
									</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="issue_close btn-sm btn btn-warning" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="issue_button btn-sm btn btn-success" form="issuanceForm">Issue Booking</button>
			</div>
		</div>
	</div>
</div>
