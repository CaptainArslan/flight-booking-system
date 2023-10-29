<div class="modal fade" id="brandView">
 	<div class="modal-dialog modal-md">
 		<div class="modal-content">
 			<div class="modal-header">
 				<h4 class="modal-title font-weight-bold" id="brandViewLabel1"><?php echo $brand_details['brand_name']; ?></h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
 			</div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Brand Name</strong></label>
                        <p class="form-control-static"><?php echo $brand_details['brand_name']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Post Fix</strong></label>
                        <p class="form-control-static"><?php echo $brand_details['brand_pre_post_fix']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Website</strong></label>
                        <p class="form-control-static"><?php echo $brand_details['brand_website']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Terms &amp; Conditions</strong></label>
                        <p class="form-control-static"><?php echo $brand_details['brand_tc_url']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Commission Rate</strong></label>
                        <p class="form-control-static"><?php echo $brand_details['brand_commission']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Status</strong></label>
                        <p class="form-control-static text-<?php echo ($brand_details["brand_status"] == 'active') ? 'success' : 'danger'; ?>"><?php echo $brand_details['brand_status']; ?></p>
                    </div>
                </div>
                <hr class="mb-1 mt-1">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Phone</strong></label>
                        <p class="form-control-static"><?php echo $brand_details['brand_phone']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Fax</strong></label>
                        <p class="form-control-static"><?php echo $brand_details['brand_fax']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>E-mail</strong></label>
                        <p class="form-control-static"><?php echo $brand_details['brand_email']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Address</strong></label>
                        <p class="form-control-static"><?php echo $brand_details['brand_address']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Payment Gateway Access</strong></label>
                        <p class="form-control-static">
                            <?php echo ($brand_details['authorise_paymentlink'] == '1') ? '<span class="text-success">Granted</span>' : '<span class="text-danger">Denied</span>'; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Invoice Access</strong></label>
                        <p class="form-control-static">
                            <?php echo ($brand_details['send_invoice'] == '1') ? '<span class="text-success">Granted</span>' : '<span class="text-danger">Denied</span>'; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Reminder Access</strong></label>
                        <p class="form-control-static">
                            <?php echo ($brand_details['send_reminder_notify'] == '1') ? '<span class="text-success">Granted</span>' : '<span class="text-danger">Denied</span>'; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Review Access</strong></label>
                        <p class="form-control-static">
                            <?php echo ($brand_details['review'] == '1') ? '<span class="text-success">Granted</span>' : '<span class="text-danger">Denied</span>'; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Direct Card Access</strong></label>
                        <p class="form-control-static">
                            <?php echo ($brand_details['direct_link'] == '1') ? '<span class="text-success">Granted</span>' : '<span class="text-danger">Denied</span>'; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-left"><strong>Direct Tkt Order Access</strong></label>
                        <p class="form-control-static">
                            <?php echo ($brand_details['direct_tktorder'] == '1') ? '<span class="text-success">Granted</span>' : '<span class="text-danger">Denied</span>'; ?>
                        </p>
                    </div>
                </div>
                <?php if ($brand_details['brand_logo'] != '') { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label text-left"><strong>Logo</strong></label>
                            <p class="form-control-static text-center">
                                <img src="<?php echo base_url('assets/images/brand_logo/'.$brand_details['brand_logo']); ?>" class="img-fluid" width="150px">
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </div>
 			<div class="modal-footer">
 				<button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
 			</div>
 		</div>
 	</div>
 </div>
