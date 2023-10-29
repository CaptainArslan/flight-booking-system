<!doctype html>
<html lang="en">
    <head>
        <?php $this->load->view('common/head', @$head); ?>
    </head>
    <body class="antialiased">
        <div class="wrapper">
            <?php 
                $this->load->view('common/sidebar', @$sidebar);
                $this->load->view('common/header', @$header);
            ?>
            <div class="page-wrapper">                
                <div class="page-header bg-white m-0 pt-3 pb-2">
                    <div class="container-xl">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="page-pretitle"><?php echo($this->user_brand == 'All')?'All Brands':$this->user_brand; ?></div>
                                <h2 class="page-title"><?php echo $head['page_title']?></h2>
                            </div>
                            <div class="col-auto ms-auto">
								<?php if (checkAccess($user_role, 'admin_view_pending_task')) { ?>
								<button type="button" class="bkgNewTrans btn btn-sm btn-info d-none d-lg-block m-l-15">Add Transaction</button>
								<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
						<div class="row" id="pendingTask">
							<div class="col">
								<div class="card">
									<div class="card-header"><h4 class="card-subtitle m-b-0 font-weight-600">Payments &amp; Others</h4></div>
									<div class="card-body p-0">
										<div class="table-responsive">
											<table id="pendingPayments" class="table table-bordered table-vcenter table-striped mb-0" style="font-size: 13px;font-weight: 400">
												<thead>
													<tr>
														<th class="p-1" width="4%">#</th>
														<th class="p-1" width="10%">Date</th>
														<th class="p-1" width="10%">File #</th>
														<th class="p-1" width="15%">Brand</th>
														<th class="p-1" width="16%">Bank</th>
														<th class="p-1" width="15%">Payment</th>
														<th class="p-1" width="20%">Details</th>
														<th class="p-1" width="10%">Actions</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sr = 1;
													$totaltask = count($pay_tasks);
													if ($totaltask > 0) {
														foreach ($pay_tasks as $key => $pay_task) {
															$p_color = '';
															$p_type = '';
															if ($pay_task['payment_type'] == 'Other') {
																$p_type = 'Other';
																$p_color = 'red';
															} elseif ($pay_task['payment_type'] == 'Card Payment') {
																$p_type = 'Card';
																$p_color = 'orange';
															} elseif ($pay_task['payment_type'] == 'Bank Payment') {
																$p_type = 'Bank';
																$p_color = 'green';
															} elseif ($pay_task['payment_type'] == '3D Card Payment Link') {
																$p_type = '3DLink';
																$p_color = 'blue';
															}
													?>
															<tr class="table-<?php echo $p_color; ?>">
																<td class="text-center p-1" data-order="<?php echo $sr; ?>"><?php echo $sr; ?><br><span class="text-center <?php echo ($pay_task['payment_type'] == 'Card Payment') ? 'cardChange' : ''; ?> badge bg-<?php echo $p_color; ?>" <?php if ($pay_task['payment_type'] == 'Card Payment') { ?>data-bkg-id="<?php echo $pay_task['bookingid']; ?>" data-amount="<?php echo number_format($pay_task['pamount'], 2); ?>" style="cursor: pointer;" <?php } ?>><small><?php echo $p_type ?></small></span></td>
																<td class="text-center p-1" data-order="<?php echo date('d-M-Y H:i', strtotime($pay_task['timestamp'])); ?>"><?php echo date('d-M', strtotime($pay_task['timestamp'])); ?><br><?php echo date('H:i', strtotime($pay_task['timestamp'])); ?></td>
																<td class="text-center p-1">
																	<a target="_blank" href="<?php echo base_url("booking/pending/" . hashing($pay_task['bookingid'])) ?>"><strong style="font-size: 14px !important;"><?php echo ($pay_task['agentcode'] != '') ? $pay_task['bookingid'] . '-' . $pay_task['agentcode'] : $pay_task['bookingid']; ?></strong><br><?php custom_echo(getbkgsupref($pay_task['bookingid']), 15); ?></a>
																</td>
																<td class="text-center p-1">
																	<?php custom_echo($pay_task['agentname'], 15); ?><br>
																	<?php custom_echo(getbkgagnt($pay_task['bookingid']), 15); ?>
																</td>
																<td class="text-center p-1"><?php echo ($pay_task['bank_name'] != '') ? str_replace('Bank', '', $pay_task['bank_name']) : '-'; ?></td>
																<td class="text-center p-1">
																	<strong style="font-size: 14px !important;">
																		<?php echo number_format($pay_task['pamount'], 2); ?>
																	</strong><?php
																				if ($pay_task['pdate'] != '1970-01-01') {
																					echo '<br>' . date('d-M-y', strtotime($pay_task['pdate']));
																				}
																				?></td>
																<td class="text-left p-1"><?php echo $pay_task['paymentdescription']; ?></td>
																<td class="text-center p-1">
																	<?php
																	if ($pay_task['payment_type'] != 'Other' && $pay_task['payment_type'] != '3D Card Payment Link' && checkAccess($user_role, 'admin_view_pending_task')) {
																	?>
																		<button class="confirmPtask btn btn-success btn-icon btn-sm" type="button" data-pid="<?php echo $pay_task['pid']; ?>">
																			<!-- Download SVG icon from http://tabler-icons.io/i/check -->
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
																		</button>
																	<?php
																	} elseif ($pay_task['payment_type'] == 'Other' && checkAccess($user_role, 'admin_view_pending_task')) {
																	?>
																		<button class="confirmOtask btn btn-success btn-icon btn-sm" type="button" data-pid="<?php echo $pay_task['pid']; ?>">
																			<!-- Download SVG icon from http://tabler-icons.io/i/check -->
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
																		</button>
																	<?php
																	}
																	if (checkAccess($user_role, 'admin_view_pending_task') || $pay_task['payment_type'] == '3D Card Payment Link') {
																	?>
																		<button class="declineptask btn btn-warning btn-icon btn-sm" type="button" data-pid="<?php echo $pay_task['pid']; ?>">
																			<!-- Download SVG icon from http://tabler-icons.io/i/x -->
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
																		</button>
																	<?php
																	} else {
																	?>
																		-
																	<?php
																	}
																	if ($pay_task['payment_type'] != '3D Card Payment Link' && checkAccess($user_role, 'admin_view_pending_task')) {
																	?>
																		<button class="delteptask btn btn-danger btn-icon btn-sm" type="button" data-pid="<?php echo $pay_task['pid']; ?>">
																			<!-- Download SVG icon from http://tabler-icons.io/i/trash -->
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
																		</button>
																	<?php
																	}
																	?>
																</td>
															</tr>
														<?php
															$sr++;
														}
													} else {
														?>
														<tr class="table-info">
															<td colspan="8" class="text-center">Wow No Pending Tasks....!!!!</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="card mt-3">
									<div class="card-header"><h4 class="card-subtitle m-b-0 font-weight-600">Tickets</h4></div>
									<div class="card-body p-0">
										<div class="table-responsive">
											<table id="pendingTickets" class="table table-bordered table-vcenter table-striped mb-0" style="font-size: 13px;font-weight: 400;color: #000 !important;">
												<thead>
													<tr>
														<th class="p-1 text-center" width="05%">ID#</th>
														<th class="p-1 text-center" width="09%">Date</th>
														<th class="p-1 text-center" width="09%">File #</th>
														<th class="p-1 text-center" width="12%">Brand</th>
														<th class="p-1 text-center" width="12%">Supplier/Ref</th>
														<th class="p-1 text-center" width="12%">GDS/PNR</th>
														<th class="p-1 text-center" width="11%">Cost</th>
														<?php
														if (checkAccess($user_role, 'admin_view_pending_task')) {
														?>
															<th class="p-1 text-center" width="20%">Details</th>
															<th class="p-1 text-center" width="10%">Actions</th>
														<?php } else { ?>
															<th class="p-1 text-center" width="30%">Details</th>
														<?php } ?>
													</tr>
												</thead>
												<tbody>
													<?php
													$sr = 1;
													$total_order = count($tkt_tasks);
													if ($total_order > 0) {
														foreach ($tkt_tasks as $key => $tkt_task) {
															$bg = '';
															if ($tkt_task['direct_send'] == '1') {
																$bg = 'bg-green';
															}
													?>
															<tr class="<?php echo $bg; ?>">
																<td class="p-1 text-center" data-order="<?php echo $sr; ?>"><?php echo $sr;
																													if (!invoicechecker($tkt_task['bookingid']) && $this->session->userdata('user_role') == 'Super Admin') { ?> <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
																														<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12.01" y2="8" /><polyline points="11 12 12 12 12 16 13 16" /></svg><?php } ?><br>
																	<span class="badge bg-<?php echo ($tkt_task['priority'] == 'High') ? 'red' : 'green'; ?>"><small><?php echo ($tkt_task['priority'] == 'High') ? 'Urgent' : 'Normal'; ?></small></span>
																</td>
																<td class="p-1 text-center" data-order="<?php echo date('d-M-Y H:i', strtotime($tkt_task['timestamp'])); ?>"><?php echo date("d-M", strtotime($tkt_task['timestamp'])); ?><br>
																	<?php echo date("H:i", strtotime($tkt_task['timestamp'])); ?>
																</td>
																<td class="p-1 text-center">
																	<strong style="font-size: 14px !important;">
																		<a target="_blank" href="<?php echo base_url("booking/pending/" . hashing($tkt_task['bookingid'])) ?>">
																			<?php echo ($tkt_task['agentcode'] != '') ? $tkt_task['bookingid'] . '-' . $tkt_task['agentcode'] : $tkt_task['bookingid']; ?>
																		</a><br><span class="badge bg-yellow"><small><?php echo $tkt_task['type']; ?></small></span>
																	</strong>
																</td>
																<td class="p-1 text-center">
																	<?php custom_echo($tkt_task['agentname'], 10); ?><br>
																	<?php custom_echo(getbkgagnt($tkt_task['bookingid']), 15); ?>
																</td>
																<td class="p-1 text-center"><?php echo $tkt_task['supplier']; ?><br>
																	<?php echo $tkt_task['supplier_ref']; ?>
																</td>
																<td class="p-1 text-center"><?php echo $tkt_task['gds']; ?><br>
																	<?php echo $tkt_task['pnr']; ?>
																</td>
																<td class="p-1 text-center">
																	<strong style="font-size: 14px !important;">
																		<?php echo number_format($tkt_task['ticket_cost'], 2); ?>
																	</strong>
																</td>
																<td class="text-left p-1"><?php echo $tkt_task['message']; ?></td>
																<?php
																if (checkAccess($user_role, 'admin_view_pending_task')) {
																?>
																	<td class="p-1 text-center">
																		<?php if (invoicechecker($tkt_task['bookingid']) || $this->session->userdata('user_role') == 'Super Admin') { ?>
																			<button class="<?php echoconfirmclass($tkt_task['bookingid']); ?> btn btn-success btn-icon btn-sm" type="button" data-bid="<?php echo $tkt_task['bookingid']; ?>" data-tid="<?php echo $tkt_task['tid']; ?>">
																				<!-- Download SVG icon from http://tabler-icons.io/i/check -->
																				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
																			</button>
																		<?php } ?>
																		<button class="declinetkttask btn btn-warning btn-icon btn-sm" type="button" data-tid="<?php echo $tkt_task['tid']; ?>">
																			<!-- Download SVG icon from http://tabler-icons.io/i/x -->
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
																		</button>
																		<button class="deltetkttask btn btn-danger btn-icon btn-sm" type="button" data-tid="<?php echo $tkt_task['tid']; ?>">
																			<!-- Download SVG icon from http://tabler-icons.io/i/trash -->
																			<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
																		</button>
																	</td>
																<?php } ?>
															</tr>
														<?php
															$sr++;
														}
													} else {
														?>
														<tr>
															<td colspan="9" class="text-center p-1">Hurreeyyy All Issued....!!!!</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
			<div class="ptasktrans"></div>
			<div class="issueTicket"></div>
			<div class="viewcardcharge"></div>
        </div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
		<script>
			$(document).on("click", ".delteptask", function () {
				var pid = $(this).data('pid');
				$(this).attr("disabled", "disabled");
				$(this).html('...');
				Swal.fire({
					html: '<div class="text-center text-danger mt-3 mb-3">' +
						'<h1 style="font-size:40px;">' +
						'<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>' +
						'</h1>' +
						'</div>' +
						'<div class="text-center">' +
						'<h3 class="font-weight-bold">Please Enter the Reason</h3>' +
						'</div>' +
						'<input id="swal-input1" class="swal2-input form-control form-control-sm" placeholder="Enter the reason to delete this task..!!">',
					confirmButtonColor: '#00c292',
                    confirmButtonText: '<small>Yes, Delete It!</small>',
                    cancelButtonText: '<small>Cancel</small>',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    customClass: {
                        confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                        cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                    }
				}).then((result) => {
					if (result.value) {
						var reason = document.getElementById('swal-input1').value;
						$.ajax({
							url: "<?php echo base_url('pending_task/deletePtask')?>",
							type: "POST",
							data: {
								pid: pid,
								reason: reason
							},
							dataType: "json",
							success: function (output) {
								if (output.status) {
									$.toast({
										heading: 'Success',
										text: 'Payment Task Deleted...!!!',
										position: 'top-right',
										loaderBg: '#ff6849',
										icon: 'success',
										hideAfter: 3500,
										stack: 6
									});
									location.reload(true);
								} else {
									Swal.fire("Error!", "Please try again", "error");
								}
							},
							error: function (output) {
								Swal.fire("Error!", "Please try again", "error");
							}
						});
					} else {
						$(".delteptask").removeAttr("disabled");
						$(".delteptask").html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>');
					}
				});
				setTimeout(function () {
					$(this).removeAttr("disabled");
					$(this).html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>');
				}, 2000);
			});
			$(document).on("click", ".declineptask", function () {
				var pid = $(this).data('pid');
				$(this).attr("disabled", "disabled");
				$(this).html('...');
				Swal.fire({
					html: '<div class="text-center text-danger mt-3 mb-3">' +
						'<h1 style="font-size:40px;">' +
						'<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 12l4 4m0 -4l-4 4" /></svg>' +
						'</h1>' +
						'</div>' +
						'<div class="text-center">' +
						'<h3 class="font-weight-bold">Please Enter the Reason</h3>' +
						'</div>' +
						'<input id="swal-input1" class="swal2-input form-control form-control-sm" placeholder="Why Payment is Declined..!!!">',
					confirmButtonColor: '#00c292',
                    confirmButtonText: '<small>Yes, Decline It!</small>',
                    cancelButtonText: '<small>Cancel</small>',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    customClass: {
                        confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                        cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                    }
				}).then((result) => {
					if (result.value) {
						var reason = document.getElementById('swal-input1').value;
						$.ajax({
							url: "<?php echo base_url('pending_task/declinePtask') ; ?>",
							type: "POST",
							data: {
								pid: pid,
								reason: reason
							},
							dataType: "json",
							success: function (output) {
								if (output.status) {
									$.toast({
										heading: 'Success',
										text: 'Payment Declined...!!!',
										position: 'top-right',
										loaderBg: '#ff6849',
										icon: 'success',
										hideAfter: 3500,
										stack: 6
									});
									location.reload(true);
								} else {
									Swal.fire("Error!", "Please try again", "error");
								}
							},
							error: function (output) {
								Swal.fire("Error!", "Please try again", "error");
							}
						});
					} else {
						$(".declineptask").removeAttr("disabled");
						$(".declineptask").html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>');
					}
				});
				setTimeout(function () {
					$(this).removeAttr("disabled");
					$(this).html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>');
				}, 2000);
			});
			$(document).on("click", ".confirmPtask", function () {
				var pid = $(this).data('pid');
				$(this).attr("disabled", "disabled");
				$(this).html('...');
				$('.loadmodaldiv').html('');
				$.ajax({
					url: "<?php echo base_url('pending_task/addtransajax') ; ?>",
					data: {
						pid: pid
					},
					type: "post",
					dataType: "json",
					success: function (output) {
						if (output != 'false') {
							$('.loadmodaldiv').html(output);
							$('.NewTransModal').modal('show');
							
							$('.formClose').on('click', function () {
								$('.confirmPtask').removeAttr("disabled");
								$('.confirmPtask').html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>');
							});
						} else {
							location.reload(true);
						}
					}
				});
				setTimeout(function () {
					$(".confirmPtask").removeAttr("disabled");
					$(".confirmPtask").html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>');
				}, 2000);
			});
			$(document).on('submit',".ptaskTransForm", function(e){
				e.preventDefault();
				$("#addtrnsBtn").attr("disabled","disabled");
				$("#addtrnsBtn").html("Processing...");
				$('.ptaskTransForm').parsley();
				if ($('#cr_total_amount').val() != $('#dr_total_amount').val()) {
					$('.trans_alert_msg').text('Debit is not Equal to Credit');
					$('.trans_alert').show(500);
					setTimeout(function(){
						$('.trans_alert').hide(500);
					},5000);
				}else{
					var form = $('.ptaskTransForm').serialize();
					$.ajax({
						url: "<?php echo base_url('pending_task/paddTrans') ; ?>",
						data:form,
						type:"post",
						dataType: "json",
						success: function(output){
							if(output.status === true){
								$.toast({
									heading: 'Success',
									text: 'Transaction added successfully', 
									position: 'top-right',
									loaderBg: '#ff6849',
									icon: 'success',
									hideAfter: 3500,
									stack: 6
								});
								window.location.href = "<?php echo base_url('booking/pending/') ; ?>"+output.bkg_id;
							}else if(output.status === false){
								$.toast({
									heading: 'Error',
									text: 'Transaction not Addedd', 
									position: 'top-right',
									loaderBg: '#ff6849',
									icon: 'error',
									hideAfter: 3500,
									stack: 6
								});
							}
						}
					});
				}
				setTimeout(function() {
				$("#addtrnsBtn").removeAttr("disabled");
				$("#addtrnsBtn").html("Submit");
				}, 2500);
			});
			$(document).on("click", ".confirmOtask", function () {
				var mainthis = $(this);
				var pid = $(this).data('pid');
				mainthis.attr("disabled", "disabled");
				mainthis.html('...');
				Swal.fire({
					html: '<div class="text-center text-danger mt-3 mb-3">' +
						'<h1 style="font-size:40px;">' +
						'<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 11 12 14 20 6" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>' +
						'</h1>' +
						'</div>' +
						'<div class="text-center">' +
						'<h3 class="font-weight-bold">Other Task Confirmed</h3>' +
						'</div>' +
						'<input id="swal-input1" class="swal2-input form-control form-control-sm" placeholder="Please Enter the Remark...">',
					confirmButtonColor: '#00c292',
                    confirmButtonText: '<small>Yes, Confirm It!</small>',
                    cancelButtonText: '<small>Cancel</small>',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    customClass: {
                        confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                        cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                    }
				}).then((result) => {
					if (result.value) {
						var reason = document.getElementById('swal-input1').value;
						$.ajax({
							url: "<?php echo base_url('pending_task/confirmOtask') ; ?>",
							type: "POST",
							data: {
								pid: pid,
								reason: reason
							},
							dataType: "json",
							success: function (output) {
								if (output.status) {
									$.toast({
										heading: 'Success',
										text: 'Other Task Confirmed...!!!',
										position: 'top-right',
										loaderBg: '#ff6849',
										icon: 'success',
										hideAfter: 3500,
										stack: 6
									});
									location.reload(true);
								} else {
									Swal.fire("Error!", "Please try again", "error");
								}
							},
							error: function (output) {
								Swal.fire("Error!", "Please try again", "error");
							}
						});
					} else {
						mainthis.removeAttr("disabled");
						mainthis.html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>');
					}
				});
				setTimeout(function () {
					mainthis.removeAttr("disabled");
					mainthis.html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>');
				}, 2000);
			});
			$(document).on("click", ".deltetkttask", function () {
				var tid = $(this).data('tid');
				$(this).attr("disabled", "disabled");
				$(this).html('...');
				Swal.fire({
					html: '<div class="text-center text-danger mt-3 mb-3">' +
						'<h1 style="font-size:40px;">' +
						'<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>' +
						'</h1>' +
						'</div>' +
						'<div class="text-center">' +
						'<h3 class="font-weight-bold">Please Enter the Reason</h3>' +
						'</div>' +
						'<input id="swal-input1" class="swal2-input form-control form-control-sm" placeholder="Enter the reason to delete this task..!!">',
					confirmButtonColor: '#00c292',
                    confirmButtonText: '<small>Yes, Delete It!</small>',
                    cancelButtonText: '<small>Cancel</small>',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    customClass: {
                        confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                        cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                    }
				}).then((result) => {
					if (result.value) {
						var reason = document.getElementById('swal-input1').value;
						$.ajax({
							url: "<?php echo base_url('pending_task/deleteTktTask') ; ?>",
							type: "POST",
							data: {
								tid: tid,
								reason: reason
							},
							dataType: "json",
							success: function (output) {
								if (output.status) {
									$.toast({
										heading: 'Success',
										text: 'Ticket Order Deleted...!!!',
										position: 'top-right',
										loaderBg: '#ff6849',
										icon: 'success',
										hideAfter: 3500,
										stack: 6
									});
									location.reload(true);
								} else {
									Swal.fire("Error!", "Please try again", "error");
								}
							},
							error: function (output) {
								Swal.fire("Error!", "Please try again", "error");
							}
						});
					} else {
						$(".deltetkttask").removeAttr("disabled");
						$(".deltetkttask").html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>');
					}
				});
				setTimeout(function () {
					$(this).removeAttr("disabled");
					$(this).html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>');
				}, 2000);
			});
			$(document).on("click", ".declinetkttask", function () {
				var tid = $(this).data('tid');
				$(this).attr("disabled", "disabled");
				$(this).html('...');
				Swal.fire({
					html: '<div class="text-center text-danger mt-3 mb-3">' +
						'<h1 style="font-size:40px;">' +
						'<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 12l4 4m0 -4l-4 4" /></svg>' +
						'</h1>' +
						'</div>' +
						'<div class="text-center">' +
						'<h3 class="font-weight-bold">Please Enter the Reason</h3>' +
						'</div>' +
						'<input id="swal-input1" class="swal2-input form-control form-control-sm" placeholder="Enter the reason to delete this task..!!">',
					confirmButtonColor: '#00c292',
                    confirmButtonText: '<small>Yes, Decline It!</small>',
                    cancelButtonText: '<small>Cancel</small>',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    customClass: {
                        confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                        cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                    }
				}).then((result) => {
					if (result.value) {
						var reason = document.getElementById('swal-input1').value;
						$.ajax({
							url: "<?php echo base_url('pending_task/declineTkttask') ; ?>",
							type: "POST",
							data: {
								tid: tid,
								reason: reason
							},
							dataType: "json",
							success: function (output) {
								if (output.status) {
									$.toast({
										heading: 'Success',
										text: 'Ticket Order Declined...!!!',
										position: 'top-right',
										loaderBg: '#ff6849',
										icon: 'success',
										hideAfter: 3500,
										stack: 6
									});
									location.reload(true);
								} else {
									Swal.fire("Error!", "Please try again", "error");
								}
							},
							error: function (output) {
								Swal.fire("Error!", "Please try again", "error");
							}
						});
					} else {
						$(".declinetkttask").removeAttr("disabled");
						$(".declinetkttask").html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>');
					}
				});
				setTimeout(function () {
					$(this).removeAttr("disabled");
					$(this).html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>');
				}, 2000);
			});
			$(document).on("click", ".confirmtkttask", function () {
				var tid = $(this).data('tid');
				$(this).attr("disabled", "disabled");
				$(this).html('...');
				Swal.fire({
					html: '<div class="text-center text-success mt-3 mb-3">' +
						'<h1 style="font-size:40px;">' +
						'<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 11 12 14 20 6" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>' +
						'</h1>' +
						'</div>' +
						'<div class="text-center">' +
						'<h3 class="font-weight-bold">Are you sure that<br>you want to confirm the issuance?</h3>' +
						'</div>',
					confirmButtonColor: '#00c292',
                    confirmButtonText: '<small>Yes, Confirm It!</small>',
                    cancelButtonText: '<small>Cancel</small>',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    customClass: {
                        confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
                        cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
                    }
				}).then((result) => {
					if (result.value) {
						$.ajax({
							url: "<?php echo base_url('pending_task/confirmTkttask')?>",
							type: "POST",
							data: {
								tid: tid,
							},
							dataType: "json",
							success: function (output) {
								if (output.status) {
									$.toast({
										heading: 'Success',
										text: 'Ticket Order Confirmed...!!!',
										position: 'top-right',
										loaderBg: '#ff6849',
										icon: 'success',
										hideAfter: 3500,
										stack: 6
									});
									location.reload(true);
								} else {
									Swal.fire("Error!", "Please try again", "error");
								}
							},
							error: function (output) {
								Swal.fire("Error!", "Please try again", "error");
							}
						});
					} else {
						$(".declinetkttask").removeAttr("disabled");
						$(".declinetkttask").html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>');
					}
				});
				setTimeout(function () {
					$(this).removeAttr("disabled");
					$(this).html('<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>');
				}, 2000);
			});
			$(document).on("click", ".issuetkttask", function () {
				var bkgId = $(this).data('bid');
				var pId = $(this).data('tid');
				$.ajax({
					url: base_url + "/booking/issuetktajax",
					data: {
						bkgId: bkgId,
						pid: pId
					},
					type: "post",
					dataType: "json",
					success: function (output) {
						if (output != 'false') {
							$('.issueTicket').html(output);
							$('#issue_booking').modal('show');
							if ($("#tkt_details").length > 0) {
								tinymce.init({
									selector: "textarea#tkt_details",
									theme: "modern",
									menubar: false,
									toolbar: false,
									height: 100,
								});
							}
							$(".date").datepicker({
								todayBtn: true,
								todayHighlight: true,
								autoclose: true,
								format: "dd-M-yyyy",
							}).on('changeDate', function (e) {
								$(this).parsley().validate();
							});
							$('#issuanceForm').parsley();
						} else {
							location.reload(true);
						}
					}
				});
			});
			$(document).on("submit", "#issuanceForm", function (e) {
				e.preventDefault();
				$('#issuanceForm').parsley();
				var form = $('#issuanceForm').serialize();
				var amtPending = $('.amtpend').text();
				var msg = '';
				if (amtPending > 0) {
					msg = 'ticket with customer amount pending by ' + amtPending;
				} else {
					msg = 'this ticket';
				}
				$('.issue_button').attr("disabled", "disabled");
				$('.issue_button').html("processing...");
				Swal.fire({
					html: '<div class="text-center text-warning mt-3 mb-3">' +
						'<h1 style="font-size:40px;"><i class="fa circle-warning fa-check-square-o faa-pulse animated"></i></h1></div>' +
						'<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>' +
						'That you want to issue <b class="text-danger">' + msg + '</b>',
					confirmButtonColor: '#00c292',
					confirmButtonText: 'Yes, Issue It!',
					showCancelButton: true,
					cancelButtonColor: '#d33'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							url: base_url + "/pending_task/issuetkt",
							type: "POST",
							data: form,
							dataType: "json",
							success: function (output) {
								if (output.status == 'true') {
									$.toast({
										heading: 'Success',
										text: 'Booking Issued..!!!',
										position: 'top-right',
										loaderBg: '#ff6849',
										icon: 'success',
										hideAfter: 3500,
										stack: 6
									});
									window.location.href = base_url + "/booking/issued/" + output.bkg_id;
								} else {
									Swal.fire("Error!", "Please try again", "error");
								}
							},
							error: function (output) {
								Swal.fire("Error!", "Please try again", "error");
							}
						});
					}
				});
				setTimeout(function () {
					$('.issue_button').removeAttr("disabled");
					$('.issue_button').html("Issue Booking");
				}, 2000);
			});
			$(document).on("click", ".cardChange", function () {
				var bkgId = $(this).data('bkg-id');
				var amount = $(this).data('amount');
				var mainthis = $(this);
				$('.loadmodaldiv').html('');
				mainthis.attr("disabled", "disabled");
				mainthis.html("...");
				$.ajax({
					url: "<?php echo base_url('booking/viewcardajax') ; ?>",
					data: {
						bkgId: bkgId,
						amount: amount,
					},
					type: "post",
					dataType: "json",
					success: function (output) {
						if (output != 'false') {
                            $('.loadmodaldiv').html(output);
                            $('.card_charge').modal('show');
                            mainthis.removeAttr("disabled");
                            mainthis.html("Card Charge");
                        } else {
                            location.reload(true);
                        }
					}
				});
				setTimeout(function () {
					mainthis.removeAttr("disabled");
					mainthis.html("card");
				}, 2000);
			});
		</script>
    </body>
</html>