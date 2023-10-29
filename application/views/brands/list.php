
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
                <div class="page-header bg-white m-0 pt-2 pb-2">
                    <div class="container-xl">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h2 class="page-title"><?php echo $head['page_title']?></h2>
                            </div>
                            <div class="col-auto ms-auto">
                                <?php if (checkAccess($session_role, 'brand_add')) { ?>
                                    <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#add_brand">Add Brand</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table id="brandsTable" class="table-striped table led-table-bg">
                                        <thead>
                                            <tr>
                                                <th width="04%" class="align-middle text-center text-white">#</th>
                                                <th width="15%" class="align-middle text-center text-white">Name</th>
                                                <th width="10%" class="align-middle text-center text-white">Phone #</th>
                                                <th width="15%" class="align-middle text-center text-white">Email</th>
                                                <th width="07%" class="align-middle text-center text-white">Status</th>
                                                <th width="07%" class="align-middle text-center text-white">Gateway</th>
                                                <th width="07%" class="align-middle text-center text-white">Invoice</th>
                                                <th width="07%" class="align-middle text-center text-white">Reminder</th>
                                                <th width="07%" class="align-middle text-center text-white">Review</th>
                                                <th width="07%" class="align-middle text-center text-white">Direct Card</th>
                                                <th width="07%" class="align-middle text-center text-white">Direct TKT Order</th>
                                                <?php if (checkAccess($session_role, 'brand_view') || checkAccess($session_role, 'brand_edit') || checkAccess($session_role, 'brand_delete')) { ?>
                                                    <th width="07%" class="align-middle text-center text-white">-</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sr = 1;
                                            foreach ($brands as $key => $brand) {
                                                if($brand["brand_name"] == 'All'){
                                                    continue;
                                                }
                                            ?>
                                                <tr>
                                                    <td class="align-middle text-center text-middle"><?php echo $sr; ?></td>
                                                    <td class="align-middle text-center text-middle"><?php echo $brand["brand_name"]; ?></td>
                                                    <td class="align-middle text-center text-middle"><?php echo $brand["brand_phone"]; ?></td>
                                                    <td class="text-left text-middle" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $brand['brand_email']; ?>"><?php custom_echo($brand["brand_email"], 18); ?></td>
                                                    <td class="align-middle text-center text-middle font-weight-600 text-<?php echo ($brand["brand_status"] == 'active') ? 'success' : 'danger'; ?>"><small><?php echo $brand["brand_status"]; ?></small></td>
                                                    <td class="align-middle text-center text-middle font-weight-600 text-<?php echo ($brand["authorise_paymentlink"] == '1') ? 'success' : 'danger'; ?>"><small><?php echo ($brand["authorise_paymentlink"] == '1') ? 'Granted' : 'Denied'; ?></small></td>
                                                    <td class="align-middle text-center text-middle font-weight-600 text-<?php echo ($brand["send_invoice"] == '1') ? 'success' : 'danger'; ?>"><small><?php echo ($brand["send_invoice"] == '1') ? 'Granted' : 'Denied'; ?></small></td>
                                                    <td class="align-middle text-center text-middle font-weight-600 text-<?php echo ($brand["send_reminder_notify"] == '1') ? 'success' : 'danger'; ?>"><small><?php echo ($brand["send_reminder_notify"] == '1') ? 'Granted' : 'Denied'; ?></small></td>
                                                    <td class="align-middle text-center text-middle font-weight-600 text-<?php echo ($brand["review"] == '1') ? 'success' : 'danger'; ?>"><small><?php echo ($brand["review"] == '1') ? 'Granted' : 'Denied'; ?></small></td>
                                                    <td class="align-middle text-center text-middle font-weight-600 text-<?php echo ($brand["direct_link"] == '1') ? 'success' : 'danger'; ?>"><small><?php echo ($brand["direct_link"] == '1') ? 'Granted' : 'Denied'; ?></small></td>
                                                    <td class="align-middle text-center text-middle font-weight-600 text-<?php echo ($brand["direct_tktorder"] == '1') ? 'success' : 'danger'; ?>"><small><?php echo ($brand["direct_tktorder"] == '1') ? 'Granted' : 'Denied'; ?></small></td>
                                                    <?php if (checkAccess($session_role, 'brand_view') || checkAccess($session_role, 'brand_edit') || checkAccess($session_role, 'brand_delete')) { ?>
                                                        <td class="align-middle text-center text-middle">
                                                            <div class="btn-group">
                                                            <?php
                                                            if (checkAccess($session_role, 'brand_view')) {
                                                            ?>
                                                                <button class="btn btn-sm btn-info p-0 view-brand" title="View Brand" data-brand-id="<?php echo $brand["brand_id"]; ?>"><svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="32" height="32" viewBox="0 0 32 32" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></button>
                                                            <?php
                                                            }
                                                            if (checkAccess($session_role, 'brand_edit')) {
                                                            ?>
                                                                <button class="btn btn-sm btn-warning p-0 edit-brand" title="Edit Brand" data-brand-id="<?php echo $brand["brand_id"]; ?>"><svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="32" height="32" viewBox="0 0 32 32" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg></buttom>
                                                            <?php
                                                            }
                                                            if (checkAccess($session_role, 'brand_delete')) {
                                                            ?>
                                                                <button class="btn btn-sm btn-danger p-0 delete-brand" title="Delete Brand" data-brand-id="<?php echo $brand["brand_id"]; ?>"><svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="32" height="32" viewBox="0 0 32 32" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></buttom>
                                                            <?php } ?>
                                                            </buttom>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php
                                                $sr++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
        <script>
            $(document).on('click','.view-brand', function(){
                var brand_id = $(this).data('brand-id');
                $.ajax({
                    url:base_url+"/brands/view_brandajax",
                    data:{
                        brand_id: brand_id,
                    },
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        if(output != 'false'){
                            $('.brandView').html(output);
                            $('#brandView').modal('show');
                        }else{
                            location.reload(true);
                        }
                    }
                });
            });
            $(document).on('click','.edit-brand', function(){
                var brand_id = $(this).data('brand-id');
                $.ajax({
                    url:base_url+"/brands/edit_brandajax",
                    data:{
                        brand_id: brand_id,
                    },
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        if(output != 'false'){
                            $('.brandedit').html(output);
                            $('#brandedit').modal('show');
                            $('.dropify').dropify();
                        }else{
                            location.reload(true);
                        }
                    }
                });
            });
            $('.delete-brand').click(function(){
                var brand_id = $(this).data('brand-id');
                Swal.fire({
                    html:
                        '<div class="align-middle text-center text-danger m-t-30 m-b-30"><h1 style="font-size:40px;"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></h1></div>'+
                        '<div class="align-middle text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>'+
                        'That you want to <b class="text-danger">delete this brand</b> ',
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
                    $.ajax({
                        url: "brands/delete_brand",
                        type: "POST",
                        data: {
                            brand_id: brand_id,
                        },
                        dataType: "json",
                        success: function (output) {
                            if(output) {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Brand was succesfully deleted!', 
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    stack: 6
                                });
                                location.reload(true);
                            }else{
                                Swal.fire("Error deleting!", "Please try again", "error");	
                            }
                        },
                        error: function (output) {
                            Swal.fire("Error deleting!", "Please try again", "error");
                        }
                    });
                }
                });
            });
        </script>
        <div class="modal fade" id="add_brand">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title font-weight-bold">Add Brand</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<form method="post" action="<?php echo base_url('brands/add_brand'); ?>" id="addbrand_form" enctype="multipart/form-data" accept-charset="utf-8">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand Name<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="text" name="brand_name" class="form-control" required autocomplete="off">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand Pre/Post-fix<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="text" name="brand_pre_post_fix" class="form-control" required autocomplete="off">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand Phone<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="number" name="brand_phone" class="form-control" required autocomplete="off">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand Fax<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="number" name="brand_fax" class="form-control" required autocomplete="off">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand Email<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="email" name="brand_email" class="form-control" required autocomplete="off">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand Website<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="text" name="brand_website" class="form-control" required autocomplete="off">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand Address<span class="text-danger">*</span></label>
										<div class="controls">
											<textarea name="brand_address" class="form-control" autocomplete="off" rows="2"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand T&amp;C URL<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="text" name="brand_tc_url" class="form-control" required autocomplete="off">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand Commision(%)<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="text" name="brand_commision" class="form-control" required autocomplete="off">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand Logo<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="file" name="brand_logo" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">Brand Status<span class="text-danger">*</span></label>
										<div class="controls">
											<select name="brand_status" required class="form-control">
												<option>Select Brand Status</option>
												<option value="active">Active</option>
												<option value="inactive">In Active</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">
                                            <input type="checkbox" name="link_access" class="mt-2" value="1"> Payment Gateway
										</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">
                                            <input type="checkbox" name="inv_access" class="mt-2" value="1"> Invoice Access
										</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">
                                            <input type="checkbox" name="reminder_access" class="mt-2" value="1"> Reminder Access
										</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">
                                            <input type="checkbox" name="review_access" class="mt-2" value="1"> Review Access
										</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">
                                            <input type="checkbox" name="direct_link_access" class="mt-2" value="1"> Direct Card Access
										</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="form-label mb-0">
                                            <input type="checkbox" name="direct_tktorder" class="mt-2" value="1"> Direct Tkt Order Access
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-sm btn-warning" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-sm btn-success">Add Brand</button>
						</div>
					</form>
				</div>
			</div>
		</div>
        <div class="brandView"></div>
		<div class="brandedit"></div>
    </body>
</html>