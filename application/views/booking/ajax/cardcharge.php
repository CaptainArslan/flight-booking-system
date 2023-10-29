<div class="modal modal-blur fade card_charge">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title font-weight-bold" id="sendpaylinkLabel1">Card Charge - <span class="text-danger"><?php echo $bkg_id; ?></span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<?php
			$cd = hashing($details["tpp_cardno"], 'd');
			$ce = hashing($cd, 'e');
			$card_num = $details["tpp_cardno"];
			if ($ce == $card_num) {
				$cardNumber = hashing($card_num, 'd');
			} else {
				$cardNumber = $card_num;
			}
			?>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<label class="control-label text-left"><strong>Card Type</strong></label>
						<p class="form-control-static mb-1"><?php echo $details['pmt_mode']; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class="control-label text-left"><strong>Card Holder Name</strong></label>
						<p class="form-control-static mb-1">
							<?php echo ($details['tpp_cardholdername'] == '') ? '-' : $details['tpp_cardholdername']; ?>
						</p>
					</div>
					<div class="col-md-6">
						<label class="control-label text-left"><strong>Card No</strong></label>
						<p class="form-control-static mb-1">
							<?php echo ($details['tpp_cardno'] == '') ? '-' : $cardNumber; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class="control-label text-left"><strong>Expiry Date</strong></label>
						<p class="form-control-static mb-1">
							<?php echo ($details['tpp_cardexpirydate'] == '') ? '-' : $details['tpp_cardexpirydate']; ?>
						</p>
					</div>
					<div class="col-md-6">
						<label class="control-label text-left"><strong>Security Code</strong></label>
						<p class="form-control-static mb-1">
							<?php echo ($details['tpp_securitycode'] == '') ? '-' : $details['tpp_securitycode']; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label class="control-label text-left"><strong>Billing Address</strong></label>
						<p class="form-control-static mb-1"><?php echo $details['cst_address'].', '.$details['cst_city'].', '.$details['cst_postcode']; ?></p>
					</div>
				</div>
				<hr class="mb-2 mt-2">
				<div class="row">
					<div class="col-md-6">
						<label class="control-label text-left"><strong>Mobile</strong></label>
						<p class="form-control-static mb-1"><?php echo $details['cst_mobile']; ?></p>
					</div>
					<div class="col-md-6">
						<label class="control-label text-left"><strong>Phone</strong></label>
						<p class="form-control-static mb-1"><?php echo $details['cst_phone']; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class="control-label text-left"><strong>E-mail</strong></label>
						<p class="form-control-static mb-1"><?php echo $details['cst_email']; ?></p>
					</div>
					<div class="col-md-6">
						<label class="control-label text-left"><strong>Amount</strong></label>
						<p class="form-control-static mb-1"><?php echo @$amount; ?></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>