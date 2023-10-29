<div class="modal fade" id="addHead">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold">Add Head</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addHead_form">
                <div class="modal-body">
                    <div class="row m-b-10">
                        <div class="col-md-2">
                            <div class="form-group m-b-0">
                                <label class="control-label font-weight-600 text-left m-b-0">Head Name<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="trans_head" id="trans_head" class="trans_head form-control form-control-sm" required  data-parsley-error-message="Required"   >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-b-0">
                                <label class="control-label font-weight-600 text-left m-b-0">Head Mode</label>
                                <div class="controls">
                                    <select name="head_mode" class="form-control form-control-sm">
                                        <option value="">Select Head Mode</option>
                                        <option value="bank">Bank</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="others">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-b-0">
                                <label class="control-label font-weight-600 text-left m-b-0">Head Owner<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="trans_head_owner" id="trans_head_owner" class="trans_head_owner form-control form-control-sm" value="" required  data-parsley-error-message="Required"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-b-0">
                                <label class="control-label font-weight-600 text-left m-b-0">Head Type<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select name="head_type" class="form-control form-control-sm" required  data-parsley-error-message="Required" >
                                        <option value="">Select Head Type</option>
                                        <option value="1">Asset/Liability</option>
                                        <option value="2">Customer/Supplier</option>
                                        <option value="3">Expenditure</option>
                                        <option value="4">Other Income</option>
                                        <option value="5">Charges</option>
                                        <option value="6">Suspense</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-b-0">
                                <label class="control-label font-weight-600 text-left m-b-0">Trial Balance<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="trans_head_tb" id="trans_head_tb" class="trans_head_tb form-control form-control-sm" value="" required  data-parsley-error-message="Required"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-b-0">
                                <label class="control-label font-weight-600 text-left m-b-0">Status<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select name="head_status" class="form-control form-control-sm" required  data-parsley-error-message="Required" >
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
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
                                    <tr class="blank">
                                        <td colspan="6" class="text-center">No Charges Added</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                   <tr>
                                       <td colspan="6" class="text-right p-0-3">
                                            <a class="addcharges_btn btn btn-sm btn-warning pull-right">Add Charges</a>
                                       </td>
                                   </tr> 
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="addHead_btn btn btn-success btn-sm">Add Trans Head</button>
                </div>
            </form>
        </div>
    </div>
</div>