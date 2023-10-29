
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
                                <?php if (checkAccess($user_role, 'supplier_add')) { ?>
									<button class="btn btn-sm btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#add_supplier">Add Supplier</button>
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
                                    <table id="supplierTable" class="table-striped table led-table-bg">
                                        <thead>
                                            <tr>
                                                <th width="05%" class="text-center text-white">#</th>
                                                <th width="16%" class="text-center text-white">Name</th>
                                                <th width="13%" class="text-center text-white">Phone#</th>
                                                <th width="16%" class="text-center text-white">Email</th>
                                                <th width="16%" class="text-center text-white">Ticket Order</th>
                                                <th width="08%" class="text-center text-white">ATOL#</th>
                                                <th width="08%" class="text-center text-white">IATA#</th>
                                                <th width="08%" class="text-center text-white">Status</th>
                                                <?php if (checkAccess($user_role, 'supplier_view') || checkAccess($user_role, 'supplier_edit') || checkAccess($user_role, 'supplier_delete')) { ?>
                                                    <th width="10%" class="text-center text-white">-</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sr = 1;
                                            foreach ($suppliers as $key => $sup) {
                                            ?>
                                                <tr>
                                                    <td class="text-center align-middle"><?php echo $sr; ?></td>
                                                    <td class="text-center align-middle"><?php echo $sup["supplier_name"]; ?></td>
                                                    <td class="text-center align-middle"><?php echo ($sup["supplier_phn"] == '') ? '-' : $sup["supplier_phn"]; ?></td>
                                                    <td class="text-center align-middle" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $sup['supplier_mail']; ?>"><?php if($sup['supplier_mail'] == '') { echo '-'; } else { custom_echo($sup["supplier_mail"], 18); } ?></td>
                                                    <td class="text-center align-middle" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo $sup['tkt_order_mail']; ?>"><?php if ($sup['tkt_order_mail'] == '') { echo '-'; } else { custom_echo($sup["tkt_order_mail"], 18); } ?></td>
                                                    <td class="text-center align-middle"><?php echo ($sup["supplier_atol"] == '') ? '-' : $sup["supplier_atol"]; ?></td>
                                                    <td class="text-center align-middle"><?php echo ($sup["supplier_iata"] == '') ? '-' : $sup["supplier_iata"]; ?></td>
                                                    <td class="text-center align-middle  text-<?php echo ($sup["supplier_status"] == 'active') ? 'success' : 'danger'; ?>"><small><?php echo ($sup["supplier_status"] == 'active') ? 'Active' : 'Inactive'; ?></small></td>
                                                    <?php if (checkAccess($user_role, 'supplier_view') || checkAccess($user_role, 'supplier_edit') || checkAccess($user_role, 'supplier_delete')) { ?>
                                                        <td class="text-center align-middle">
                                                            <div class="btn-group">
                                                            <?php
                                                            if (checkAccess($user_role, 'supplier_view')) {
                                                            ?>
                                                                <button type="button" class="btn btn-sm p-0 btn-info view-sup" title="View Supplier" data-sup-id="<?php echo $sup["supplier_id"]; ?>"><svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="32" height="32" viewBox="0 0 32 32" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></button>
                                                            <?php
                                                            }
                                                            if (checkAccess($user_role, 'supplier_edit')) {
                                                            ?>
                                                                <button type="button" class="btn btn-sm p-0 btn-success edit-sup" title="Edit Supplier" data-sup-id="<?php echo $sup["supplier_id"]; ?>"><svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="32" height="32" viewBox="0 0 32 32" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg></button>
                                                            <?php
                                                            }
                                                            if (checkAccess($user_role, 'supplier_delete')) {
                                                            ?>
                                                                <button type="button" class="btn btn-sm p-0 btn-danger delete-sup" title="Delete Supplier" data-sup-id="<?php echo $sup["supplier_id"]; ?>"><svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="32" height="32" viewBox="0 0 32 32" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></button>
                                                            <?php } ?>
                                                            </div>
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
            $('.edit-sup').on('click',function(){
                var main_this = $(this) ;
                var id = main_this.data("sup-id");
                main_this.attr('disabled','disabled');
                $.ajax({
                    url:base_url+"/supplier/editajax",
                    data:{
                        id:id,
                    },
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        $('.ajaxload').html(output);
                        $('#sup_updatemodel').modal('show');
                        $('#sup_updateform').parsley();
                        main_this.removeAttr('disabled');
                    }
                });
            });
            $('.view-sup').on('click',function(){
                var main_this = $(this) ;
                var id = main_this.data("sup-id");
                main_this.attr('disabled','disabled');
                $.ajax({
                    url:base_url+"/supplier/viewajax",
                    data:{
                        id:id,
                    },
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        $('.ajaxload').html(output);
                        $('#sup_viewmodel').modal('show');
                        main_this.removeAttr('disabled');
                    }
                });
            });
            $('.delete-sup').click(function(){
                var id = $(this).data('sup-id');
                Swal.fire({
                    html:
                        '<div class="text-center text-danger m-t-30 m-b-30"><h1 style="font-size:40px;"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></h1></div>'+
                        '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>'+
                        'That you want to <b class="text-danger">delete this supplier</b>',
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
                        url: "supplier/delete",
                        type: "POST",
                        data: {
                            id: id,
                        },
                        dataType: "json",
                        success: function (output) {
                            location.reload(true);
                        },
                        error: function (output) {
                            Swal.fire("Error deleting!", "Please try again", "error");
                        }
                    });
                }
                });
            });
        </script>
        <div class="modal fade" id="add_supplier">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title font-weight-bold" id="add_supplierLabel1">Add Supplier</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<form method="post" action="<?php echo base_url('supplier/add'); ?>" id="sup_addform">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-1">
										<label class="form-label">Supplier Name<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="text" name="supplier_name" class="form-control" required>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-1">
										<label class="form-label">Supplier Phone<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="number" name="supplier_phn" class="form-control" required >
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-1">
										<label class="form-label">Supplier Email<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="email" name="supplier_mail" class="form-control" required >
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-1">
										<label class="form-label">Ticket Order Mail<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="email" name="tkt_order_mail" class="form-control" required >
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-1">
										<label class="form-label">Supplier ATOL<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="text" name="supplier_atol" class="form-control" >
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-1">
										<label class="form-label">Supplier IATA<span class="text-danger">*</span></label>
										<div class="controls">
											<input type="text" name="supplier_iata" class="form-control" >
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-sm btn-warning" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-sm btn-success">Add Supplier</button>
						</div>
					</form>
				</div>
			</div>
		</div>
        <div class="ajaxload"></div>
    </body>
</html>