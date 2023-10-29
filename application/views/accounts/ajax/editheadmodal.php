<div class="modal fade" id="editHead">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold">Edit Head - <span><?php echo $trans_head; ?></span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editHead_form">
                <div class="modal-body">
                    <div class="row m-b-10">
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label class="form-label font-weight-600 text-left ">Head Name<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <?php
                                        if(is_transhead($head['trans_head'])){
                                    ?>
                                    <input type="text" name="" id="" value="<?php echo $head['trans_head'] ?>" class="form-control form-control-sm" disabled>
                                    <?php }else{ ?>
                                    <input type="text" name="trans_head" id="trans_head" value="<?php echo $head['trans_head'] ?>" class="form-control form-control-sm" required  data-parsley-error-message="Required">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label class="form-label font-weight-600 text-left ">Head Mode</label>
                                <div class="controls">
                                    <select name="head_mode" class="form-control form-control-sm">
                                        <option value="">Select Head Mode</option>
                                        <option value="bank" <?php echo($head['trans_head_mode'] == 'bank')?'selected':''; ?>>Bank</option>
                                        <option value="cash" <?php echo($head['trans_head_mode'] == 'cash')?'selected':''; ?>>Cash</option>
                                        <option value="card" <?php echo($head['trans_head_mode'] == 'card')?'selected':''; ?>>Card</option>
                                        <option value="others" <?php echo($head['trans_head_mode'] == 'others')?'selected':''; ?>>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label class="form-label font-weight-600 text-left ">Head Owner<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="trans_head_owner" id="trans_head_owner" class="form-control form-control-sm" value="<?php echo $head['owner'] ?>" required  data-parsley-error-message="Required" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label class="form-label font-weight-600 text-left ">Head Type<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select name="head_type" class="form-control form-control-sm" required  data-parsley-error-message="Required">
                                        <option value="">Select Head Type</option>
                                        <option value="1" <?php echo($head['type'] == '1')?'selected':''; ?>>Asset/Liability</option>
                                        <option value="2" <?php echo($head['type'] == '2')?'selected':''; ?>>Customer/Supplier</option>
                                        <option value="3" <?php echo($head['type'] == '3')?'selected':''; ?>>Expenditure</option>
                                        <option value="4" <?php echo($head['type'] == '4')?'selected':''; ?>>Other Income</option>
                                        <option value="5" <?php echo($head['type'] == '5')?'selected':''; ?>>Charges</option>
                                        <option value="6" <?php echo($head['type'] == '6')?'selected':''; ?>>Suspense</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label class="form-label font-weight-600 text-left ">Trial Balance<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="trans_head_tb" id="trans_head_tb" class="form-control form-control-sm" value="<?php echo $head['trial_balance_head'] ; ?>" required  data-parsley-error-message="Required" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label class="form-label font-weight-600 text-left ">Status<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select name="head_status" class="form-control form-control-sm" required  data-parsley-error-message="Required">
                                        <option value="1" <?php echo($head['trans_head_status'] == '1')?'selected':''; ?>>Active</option>
                                        <option value="0" <?php echo($head['trans_head_status'] == '0')?'selected':''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 ">
                        <div class="table-responsive">
                            <table id="paxtable" class="table full-color-table full-info-table m-b-10">
                                <thead>
                                    <tr>
                                        <th width="25%" class="text-white text-center text-middle">Brand Name</th>
                                        <th width="25%" class="text-white text-center text-middle">Agent Name</th>
                                        <th width="15%" class="text-white text-center text-middle">Dr. Charges</th>
                                        <th width="15%" class="text-white text-center text-middle">Cr. Charges</th>
                                        <th width="15%" class="text-white text-center text-middle">Charges Type</th>
                                        <th width="05%" class="text-white text-center text-middle">-</th>
                                    </tr>
                                </thead>
                                <tbody class="addheadchargesrows">
                                    <?php 
                                        if(count($head_charges) > 0){
                                            foreach ($head_charges as $key => $charge) {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <select name="charges[brand_name][]"  class="charges_brand form-control form-control-sm" <?php echo(($charge['brand_name'] == 'all' || $charge['brand_name'] == '') && ($charge['agent_name'] == '' || $charge['agent_name'] == 'all'))?'disabled':''; ?> >
                                                        <?php 
                                                            $brands = GetBrands();
                                                            foreach ($brands as $key => $brand) {
                                                        ?>
                                                        <option value="<?php echo $brand['brand_name'] ?>" <?php echo($brand['brand_name'] == $charge['brand_name'])?'selected':''; ?>><?php echo $brand['brand_name'] ?></option>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </select>
                                                    <?php if(($charge['brand_name'] == 'all' || $charge['brand_name'] == '') && ($charge['agent_name'] == '' || $charge['agent_name'] == 'all')){?>
                                                    <input type="hidden" name="charges[brand_name][]" value="<?php echo $charge['brand_name']; ?>">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <select name="charges[agent_name][]"  class="charges_agent form-control form-control-sm" <?php echo(($charge['brand_name'] == 'all' || $charge['brand_name'] == '') && ($charge['agent_name'] == '' || $charge['agent_name'] == 'all'))?'disabled':''; ?>>
                                                        <option value="">All</option>
                                                        <?php 
                                                            $agents = getUser('',$charge['brand_name']);
                                                                foreach ($agents as $key => $user) {
                                                        ?>
                                                        <option value="<?php echo $user['user_name'] ?>" <?php echo($user['user_name'] == $charge['agent_name'])?'selected':''; ?>><?php echo $user['user_name'] ?></option>
                                                        <?php } ?>
                                                        <?php if(($charge['brand_name'] == 'all' || $charge['brand_name'] == '') && ($charge['agent_name'] == '' || $charge['agent_name'] == 'all')){?>
                                                        <input type="hidden" name="charges[agent_name][]" value="<?php echo $charge['agent_name']; ?>">
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="charges[dr_charges][]" class="form-control form-control-sm" value="<?php echo $charge['dr_charges'] ; ?>" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Enter Digits Only"> 
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <input type="text" name="charges[cr_charges][]" class="form-control form-control-sm" value="<?php echo $charge['cr_charges'] ; ?>" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Enter Digits Only">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <div class="controls">
                                                    <select name="charges[charges_type][]"  class="form-control form-control-sm">
                                                        <option value="">Select type</option>
                                                        <option value="percentage" <?php echo($charge['charges_type'] == 'percentage')?'selected':''; ?>>Percentage</option>
                                                        <option value="fixed" <?php echo($charge['charges_type'] == 'fixed')?'selected':''; ?>>Fixed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-0-3 text-center text-middle">
                                            <?php if($charge['brand_name'] != '' || $charge['agent_name'] != ''){ ?> 
                                            <a class="deletecharges">-</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                            } 
                                        }else{ 
                                    ?>
                                    <tr class="blank">
                                        <td colspan="6" class="text-center">No Charges Added</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                   <tr>
                                       <td colspan="6" class="text-right p-0-3">
                                            <a class="addcharges_btn btn btn-sm btn-warning pull-right"><i class="fa fa-plus"></i> Add Charges</a>
                                       </td>
                                   </tr> 
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php
                        if(is_transhead($head['trans_head'])){
                    ?>
                    <input type="hidden" name="trans_head" id="trans_head" value="<?php echo $head['trans_head'] ?>" />
                    <?php } ?>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="updateHead_btn btn btn-success btn-sm">Update Trans Head</button>
                </div>
            </form>
        </div>
    </div>
</div>