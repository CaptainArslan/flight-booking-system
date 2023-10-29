<div class="modal fade" id="sup_updatemodel">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title font-weight-bold">Update Supplier</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<form method="post" action="<?php echo base_url('supplier/update'); ?>" id="sup_updateform">
				<input type="hidden" name="supplier_id" value="<?php echo $sup_details['supplier_id']; ?>">
				<input type="hidden" name="supplier_pre" value="<?php echo $sup_details['supplier_name']; ?>">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Supplier Name<span class="text-danger">*</span></label>
								<div class="controls">
									<input type="text" name="supplier_name" class="form-control" required value="<?php echo $sup_details['supplier_name']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Supplier Phone</label>
								<div class="controls">
									<input type="number" name="supplier_phn" class="form-control" value="<?php echo $sup_details['supplier_phn']; ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Supplier Email</label>
								<div class="controls">
									<input type="email" name="supplier_mail" class="form-control" value="<?php echo $sup_details['supplier_mail']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Ticket Order Mail</label>
								<div class="controls">
									<input type="email" name="tkt_order_mail" class="form-control" value="<?php echo $sup_details['tkt_order_mail']; ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Supplier ATOL</label>
								<div class="controls">
									<input type="text" name="supplier_atol" class="form-control" value="<?php echo $sup_details['supplier_atol']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-1">
								<label class="form-label">Supplier IATA</label>
								<div class="controls">
									<input type="text" name="supplier_iata" class="form-control" value="<?php echo $sup_details['supplier_iata']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group mb-1">
								<label class="form-label">Supplier Status<span class="text-danger">*</span></label>
								<div class="controls">
									<select name="supplier_status" class="form-control" required>
										<option value="" <?php echo ($sup_details['supplier_status'] == '') ? 'selected' : ''; ?>>Select Status</option>
										<option value="active" <?php echo ($sup_details['supplier_status'] == 'active') ? 'selected' : ''; ?>>Active</option>
										<option value="inactive" <?php echo ($sup_details['supplier_status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-warning" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-sm btn-success">Update Supplier</button>
				</div>
			</form>
		</div>
	</div>
</div>