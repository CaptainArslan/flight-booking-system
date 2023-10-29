<div class="modal modal-blur fade amendpax">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title font-weight-bold"><strong>Amend Passengers - <span class="text-danger"><?php echo $bkg_id; ?></span></strong></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <form id="formpax">
					<input type="hidden" name="bkg_id" value="<?php echo $bkg_id; ?>">
                    <div class="table-responsive">
                        <table class="table full-color-table full-info-table dataTable m-b-10">
                            <thead>
                                <tr>
                                    <th width="07%" class="p-0-5 text-center text-middle">Title</th>
                                    <th width="13%" class="p-0-5 text-center text-middle">First Name</th>
                                    <th width="07%" class="p-0-5 text-center text-middle">Middle</th>
                                    <th width="13%" class="p-0-5 text-center text-middle">Sur Name</th>
                                    <th width="07%" class="p-0-5 text-center text-middle">Age/DOB</th>
                                    <th width="08%" class="p-0-5 text-center text-middle">Pax type</th>
                                    <th width="08%" class="p-0-5 text-center text-middle">Flight</th>
                                    <th width="08%" class="p-0-5 text-center text-middle">Hotel</th>
                                    <th width="08%" class="p-0-5 text-center text-middle">Cab</th>
                                    <th width="08%" class="p-0-5 text-center text-middle">Fee</th>
                                    <th width="08%" class="p-0-5 text-center text-middle">Total</th>
                                    <th width="05%" class="p-0-5 text-center text-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody id="extendPax">
                                <?php
                                $total_pax = count($pax);
                                if ($total_pax > 0) {
                                    foreach ($pax as $key => $passenger) {
                                ?>
                                        <tr>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <select name="pax[pax_title][]" class="form-control form-control-sm" required data-parsley-errors-messages-disabled>
                                                            <option value="">Title</option>
                                                            <option <?php echo ($passenger['p_title'] == "MR") ? "selected" : ""; ?> value="MR">MR</option>
                                                            <option <?php echo ($passenger['p_title'] == "MISS") ? "selected" : ""; ?> value="MISS">MISS</option>
                                                            <option <?php echo ($passenger['p_title'] == "MRS") ? "selected" : ""; ?> value="MRS">MRS</option>
                                                            <option <?php echo ($passenger['p_title'] == "MS") ? "selected" : ""; ?> value="MS">MS</option>
                                                            <option <?php echo ($passenger['p_title'] == "MSTR") ? "selected" : ""; ?> value="MSTR">MSTR</option>
                                                            <option <?php echo ($passenger['p_title'] == "DR") ? "selected" : ""; ?> value="DR">DR</option>
                                                            <option <?php echo ($passenger['p_title'] == "Prof.") ? "selected" : ""; ?> value="Prof.">Prof.</option>
                                                        </select>
                                                        <input type="hidden" name="pax[pax_eticket_no][]" value="<?php echo $passenger['p_eticket_no']; ?>" />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <input type="text" name="pax[pax_first_name][]" class="form-control form-control-sm" required value="<?php echo $passenger['p_firstname']; ?>" data-parsley-errors-messages-disabled />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <input type="text" name="pax[pax_mid_name][]" class="form-control form-control-sm" value="<?php echo $passenger['p_middlename']; ?>" data-parsley-errors-messages-disabled />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <input type="text" name="pax[pax_sur_name][]" class="form-control form-control-sm" required value="<?php echo $passenger['p_lastname']; ?>" data-parsley-errors-messages-disabled />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <input type="text" name="pax[pax_age][]" class="form-control form-control-sm" value="<?php echo $passenger['p_age']; ?>" data-parsley-errors-messages-disabled />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <select name="pax[pax_type][]" class="form-control form-control-sm" required data-parsley-errors-messages-disabled>
                                                            <option <?php echo ($passenger['p_catagory'] == "Adult") ? "selected" : ""; ?> value="Adult">Adult</option>
                                                            <option <?php echo ($passenger['p_catagory'] == "Youth") ? "selected" : ""; ?> value="Youth">Youth</option>
                                                            <option <?php echo ($passenger['p_catagory'] == "Child") ? "selected" : ""; ?> value="Child">Child</option>
                                                            <option <?php echo ($passenger['p_catagory'] == "Infant") ? "selected" : ""; ?> value="Infant">Infant</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <input type="text" data-parsley-pattern="^[0-9.-]+$" name="pax[pax_sale][]" class="sale_price text-center form-control form-control-sm" required value="<?php echo $passenger['p_basic'] + $passenger['p_tax']; ?>" data-parsley-errors-messages-disabled />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <input type="text" data-parsley-pattern="^[0-9.-]+$" name="pax[pax_hotel][]" class="hotel_price text-center form-control form-control-sm" required value="<?php echo $passenger['p_hotel']; ?>" data-parsley-errors-messages-disabled />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <input type="text" data-parsley-pattern="^[0-9.-]+$" name="pax[pax_cab][]" class="cab_price text-center form-control form-control-sm" required value="<?php echo $passenger['p_cab']; ?>" data-parsley-errors-messages-disabled />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <input type="text" data-parsley-pattern="^[0-9.-]+$" name="pax[pax_fee][]" class="booking_fee text-center form-control form-control-sm" required value="<?php echo $passenger['p_bookingfee'] + $passenger['p_cardcharges'] + $passenger['p_others']; ?>" data-parsley-errors-messages-disabled />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <div class="controls">
                                                        <input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_sale_total][]" readonly class="pax_total text-center form-control form-control-sm" required value="<?php echo $passenger['p_basic'] + $passenger['p_tax'] + $passenger['p_bookingfee'] + $passenger['p_cardcharges'] + $passenger['p_others'] + $passenger['p_hotel'] + $passenger['p_cab']; ?>" data-parsley-errors-messages-disabled />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($key != 0) { ?>
                                                    <a class="deletepax">-</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php   }
                                } else {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <select name="pax[pax_title][]" class="form-control form-control-sm" required data-parsley-errors-messages-disabled>
                                                        <option value="">Title</option>
                                                        <option value="MR">MR</option>
                                                        <option value="MISS">MISS</option>
                                                        <option value="MRS">MRS</option>
                                                        <option value="MS">MS</option>
                                                        <option value="MSTR">MSTR</option>
                                                        <option value="DR">DR</option>
                                                        <option value="Prof.">Prof.</option>
                                                    </select>
                                                    <input type="hidden" name="pax[pax_eticket_no][]" value="" />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="pax[pax_first_name][]" class="form-control form-control-sm" required value="" data-parsley-errors-messages-disabled />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="pax[pax_mid_name][]" class="form-control form-control-sm" value="" data-parsley-errors-messages-disabled />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="pax[pax_sur_name][]" class="form-control form-control-sm" required value="" data-parsley-errors-messages-disabled />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="pax[pax_age][]" class="form-control form-control-sm" value="" data-parsley-errors-messages-disabled />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <select name="pax[pax_type][]" class="form-control form-control-sm" required data-parsley-errors-messages-disabled>
                                                        <option value="Adult">Adult</option>
                                                        <option value="Youth">Youth</option>
                                                        <option value="Child">Child</option>
                                                        <option value="Infant">Infant</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="pax[pax_sale][]" class="sale_price text-center form-control form-control-sm" required value="" data-parsley-errors-messages-disabled />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="pax[pax_hotel][]" class="hotel_price text-center form-control form-control-sm" required value="" data-parsley-errors-messages-disabled />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="pax[pax_cab][]" class="cab_price text-center form-control form-control-sm" required value="" data-parsley-errors-messages-disabled />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="pax[pax_fee][]" class="booking_fee text-center form-control form-control-sm" required value="0" data-parsley-errors-messages-disabled />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="pax[pax_sale_total][]" readonly class="pax_total text-center form-control form-control-sm" required value="" data-parsley-errors-messages-disabled />
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="12" class="text-right p-l-0 p-r-0 p-b-0">
                                        <a id="addPax" class="btn btn-xs btn-outline-info pull-right btn-sm">Add More</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
			</div>
			<div class="modal-footer p-r-30">
				<button type="submit" id="submitButton" class="btn btn-success btn-sm" form="formpax">Update</button>
			</div>
		</div>
	</div>
</div>
