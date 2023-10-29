<div class="modal fade" id="sup_viewmodel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title font-weight-bold" id="sup_viewmodelLabel1">View Supplier</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Supplier Name</label>
							<div class="controls">
								<p><?php echo $sup_details['supplier_name']; ?></p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Supplier Phone</label>
							<div class="controls">
								<p><?php echo $sup_details['supplier_phn']; ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Supplier Email</label>
							<div class="controls">
								<p><?php echo $sup_details['supplier_mail']; ?></p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Ticket Order Mail</label>
							<div class="controls">
								<p><?php echo $sup_details['tkt_order_mail']; ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Supplier ATOL</label>
							<div class="controls">
								<p><?php echo $sup_details['supplier_atol']; ?></p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Supplier IATA</label>
							<div class="controls">
								<p><?php echo $sup_details['supplier_iata']; ?></p>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label">Supplier Status</label>
							<div class="controls">
								<p class="text-<?php echo ($sup_details["supplier_status"] == 'active') ? 'success' : 'danger'; ?>"><strong><?php echo ($sup_details["supplier_status"] == 'active') ? 'Active' : 'Inactive'; ?></strong></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
