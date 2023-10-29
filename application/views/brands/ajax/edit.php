<div class="modal fade" id="brandedit">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title font-weight-bold">Update Brand</h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<form method="post" action="<?php echo base_url(); ?>brands/edit_brand" id="addbrand_form" enctype="multipart/form-data" accept-charset="utf-8">
				<input type="hidden" name="brand_id" value="<?php echo $brand_details['brand_id']; ?>">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Brand Name<span class="text-danger">*</span></label>
								<div class="controls">
									<input type="text" name="brand_name" class="form-control" value="<?php echo $brand_details['brand_name']; ?>" required>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Brand Pre/Post-fix<span class="text-danger">*</span></label>
								<div class="controls">
									<input type="text" name="brand_pre_post_fix" class="form-control" value="<?php echo $brand_details['brand_pre_post_fix']; ?>" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Brand Phone<span class="text-danger">*</span></label>
								<div class="controls">
									<input type="number" name="brand_phone" class="form-control" value="<?php echo $brand_details['brand_phone']; ?>" required>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Brand Fax<span class="text-danger">*</span></label>
								<div class="controls">
									<input type="number" name="brand_fax" class="form-control" value="<?php echo $brand_details['brand_fax']; ?>" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Brand Email<span class="text-danger">*</span></label>
								<div class="controls">
									<input type="email" name="brand_email" class="form-control" value="<?php echo $brand_details['brand_email']; ?>" required>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Brand Website<span class="text-danger">*</span></label>
								<div class="controls">
									<input type="text" name="brand_website" class="form-control" value="<?php echo $brand_details['brand_website']; ?>" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Brand Address<span class="text-danger">*</span></label>
								<div class="controls">
									<textarea name="brand_address" class="form-control" rows="2"><?php echo $brand_details['brand_address']; ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Brand Status<span class="text-danger">*</span></label>
								<div class="controls">
									<select name="brand_status" required class="form-control">
										<option value="">Select Brand Status</option>
										<option value="active" <?php echo ($brand_details['brand_status'] == 'active') ? 'selected' : ''; ?>>Active</option>
										<option value="inactive" <?php echo ($brand_details['brand_status'] == 'inactive') ? 'selected' : ''; ?>>In Active</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Brand T&amp;C URL<span class="text-danger">*</span></label>
								<div class="controls">
									<input type="text" name="brand_tc_url" class="form-control" value="<?php echo $brand_details['brand_tc_url']; ?>" required>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Brand Commision(%)<span class="text-danger">*</span></label>
								<div class="controls">
									<input type="text" name="brand_commision" class="form-control" value="<?php echo $brand_details['brand_commission']; ?>" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">
									<input type="checkbox" name="link_access" value="1" <?php echo ($brand_details['authorise_paymentlink'] == '1') ? 'checked' : ''; ?>> Payment Gateway
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">
									<input type="checkbox" name="inv_access" value="1" <?php echo ($brand_details['send_invoice'] == '1') ? 'checked' : ''; ?>> Invoice Access
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">
									<input type="checkbox" name="reminder_access" value="1" <?php echo ($brand_details['send_reminder_notify'] == '1') ? 'checked' : ''; ?>> Reminder Access
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">
									<input type="checkbox" name="review_access" value="1" <?php echo ($brand_details['review'] == '1') ? 'checked' : ''; ?>> Review Access
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">
									<input type="checkbox" name="direct_link_access" value="1" <?php echo ($brand_details['direct_link'] == '1') ? 'checked' : ''; ?>> Direct Card Access
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">
									<input type="checkbox" name="direct_tktorder" value="1" <?php echo ($brand_details['direct_tktorder'] == '1') ? 'checked' : ''; ?>> Direct Tkt Order Access
								</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group mb-1">
								<label class="form-label">Brand Logo<span class="text-danger">*</span></label>
								<div class="controls">
									<input type="file" name="brand_logo" class="dropify" url="<?php echo base_url('assets/images/brand_logo/'.$brand_details['brand_logo']); ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-warning" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-sm btn-success">Update Brand</button>
				</div>
			</form>
		</div>
	</div>
</div>