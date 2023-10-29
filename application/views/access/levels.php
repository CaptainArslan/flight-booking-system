
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
                                <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#add_role">Add Level</button>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table id="loginTable" class="table table-bordered led-table-bg">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center text-white p-r-5 p-l-5 p-t-10 p-b-10">Sr. #</th>
                                                <th width="30%" class="text-center text-white p-r-5 p-l-5 p-t-10 p-b-10">Access Level</th>
                                                <th width="20%" class="text-center text-white p-r-5 p-l-5 p-t-10 p-b-10">Date Created</th>
                                                <th width="20%" class="text-center text-white p-r-5 p-l-5 p-t-10 p-b-10">Last Updated</th>
                                                <th width="10%" class="text-center text-white p-r-5 p-l-5 p-t-10 p-b-10">Status</th>
                                                <th width="10%" class="text-center text-white p-r-5 p-l-5 p-t-10 p-b-10">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sr = 1;
                                                foreach ($roles as $key => $role) {
                                            ?>
                                            <tr>
                                                <td width="5%" class="text-center align-middle">
                                                    <?php echo $sr; ?>
                                                </td>
                                                <td width="30%" class="text-center align-middle">
                                                    <?php echo $role['role_name'] ; ?>                                            
                                                </td>                                      
                                                <td width="20%" class="text-center align-middle">
                                                    <?php echo date("d-M-Y h:ia",strtotime($role['created_at'])) ; ?>                                       
                                                </td>                                      
                                                <td width="20%" class="text-center align-middle">
                                                    <?php echo date("d-M-Y h:ia",strtotime($role['updated_at'])) ; ?>                                            
                                                </td>                                      
                                                <td width="10%" class="text-center align-middle text-success"><?php echo $role['role_status']  ?></td>
                                                <td width="10%" class="text-center align-middle">
                                                    <div class="btn-group">
                                                    <?php  if(checkAccess($session_role,'role_view')){ ?>
                                                    <button class="btn btn-sm text-center p-0 btn-success viewrole" type="button" title="View Role Access" data-role-id="<?php echo $role['role_id']; ?>" data-role-name="<?php echo $role['role_name']; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="27" height="27" viewBox="0 0 27 27" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                                                    </button>
                                                    <?php } if(checkAccess($session_role,'role_edit')){ ?>
                                                    <button class="btn btn-sm text-center p-0 btn-warning editrole" type="button" title="Edit Role Access" data-role-id="<?php echo $role['role_id']; ?>" data-role-name="<?php echo $role['role_name']; ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="27" height="27" viewBox="0 0 27 27" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                                                    </button>
                                                    <?php } if(checkAccess($session_role,'role_delete')){ ?>
                                                    <button class="btn btn-sm text-center p-0 btn-danger deleAccessRole" type="button" title="Delete" data-role-id="<?php echo $role['role_id']; ?>" data-role-name="<?php echo $role['role_name']; ?>"><svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="27" height="27" viewBox="0 0 27 27" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></button>
                                                    <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $sr++;} ?>
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
            $(document).on('click','.viewrole', function(){
                var role_id = $(this).data('role-id');
                var role_name = $(this).data('role-name');
                $.ajax({
                    url:base_url+"/access_level/viewAlAjax",
                    data:{
                        role_id: role_id,
                        role_name: role_name,
                    },
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        if(output != 'false'){
                            $('.viewAccessLevel').html(output);
                            $('#viewAccessLevel').modal('show');
                        }else{
                            location.reload(true);
                        }			
                    }
                });
            });
            $(document).on('click','.editrole', function(){
                var role_id = $(this).data('role-id');
                var role_name = $(this).data('role-name');
                $.ajax({
                    url:base_url+"/access_level/editAlAjax",
                    data:{
                        role_id: role_id,
                        role_name: role_name,
                    },
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        if(output != 'false'){
                            $('.editAccessLevel').html(output);
                            $('#editAccessLevel').modal('show');
                        }else{
                            location.reload(true);
                        }			
                    }
                });
            });
            $(document).on('submit','#editacclvl', function(e){
                e.preventDefault();
                var form = $('#editacclvl').serialize();
                $('#editAccessLevel').modal('hide');
                $.ajax({
                    url:base_url+"/access_level/edit_role",
                    data:form,
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        location.reload(true);
                    }
                });
            });
            $(document).on('submit','#addacclevel', function(e){
                e.preventDefault();
                var form = $('#addacclevel').serialize();
                $('#add_role').modal('hide');
                $.ajax({
                    url:base_url+"/access_level/add_role",
                    data:form,
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        location.reload(true);
                    }
                });
            });
            $(document).on('click','.deleAccessRole',function(){
                var role_id = $(this).data('role-id');
                var role_name = $(this).data('role-name');
                Swal.fire({
                    html:
                        '<div class="text-center text-danger m-t-30 m-b-30"><h1 style="font-size:40px;"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></h1></div>'+
                        '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>'+
                        'That you want to <b class="text-danger">delete Access Role</b> '+ role_name,
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
                        url: "access_level/delete_role",
                        type: "POST",
                        data: {
                            role_id: role_id,
                            role_name: role_name,
                        },
                        dataType: "json",
                        success: function (output) {
                            if(output) {
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
        <div class="modal fade" id="add_role">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Add Access Level</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="" id="addacclevel">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Access Level Name<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="role_name" class="form-control" value="" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-danger">Page Access</h4>
                            <hr class="mt-1 mb-1">
                            <?php 
                                $sr = 1;
                                $query = "SELECT DISTINCT `access_page` FROM `access`;";
                                $result = $this->db->query($query)->result_array();
                                asort($result);
                                foreach ($result as $key => $page) {
                            ?>
                            <h5 class="card-title text-cyan mb-0"><?php echo $page['access_page']; ?></h5>
                            <div class="row mb-2">
                                <?php
                                    $query = "SELECT `access_id`,`access_name` FROM `access` where `access_page` = '".$page['access_page']."';";
                                    $result = $this->db->query($query)->result_array();
                                    foreach ($result as $key => $access) {
                                ?>
                                <div class="col-md-3">
                                    <div class="controls">
                                        <div class="custom-control custom-checkbox">
                                            <label class="form-label" for="customCheck<?php echo $sr; ?>"><input type="checkbox" value="<?php echo $access['access_id']; ?>" id="customCheck<?php echo $sr; ?>" name="access_name[]"> <?php echo $access['access_name']; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <?php $sr++;} ?>
                            </div>   
                            <?php } ?>                     
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-warning" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-success">Add Access Level</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="viewAccessLevel"></div>
        <div class="editAccessLevel"></div>
    </body>
</html>