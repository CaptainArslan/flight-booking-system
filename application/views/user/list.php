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
                                <?php
                                    if(checkAccess($session_role,'user_add')){
                                ?>
                                <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#add_user">Add User</button>
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
                                    <table id="usersTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center text-white">#</th>
                                                <th width="20%" class="text-center text-white">User Name</th>
                                                <th width="20%" class="text-center text-white">User Brand</th>
                                                <th width="20%" class="text-center text-white">User Level</th>
                                                <th width="20%" class="text-center text-white">User Status</th>
                                                <th width="10%" class="text-center text-white">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $sr = 1;
                                                foreach ($users as $key => $user) {
                                                    if($user['user_name'] == 'IT Manager'){
                                                        continue;
                                                    }
                                            ?>
                                            <tr bgcolor="#fff">
                                                <td width="5%" class="text-center align-middle"><?php echo $sr; ?></td>
                                                <td width="20%" class="text-center align-middle">
                                                    <a href="./user/profile/<?php echo hashing($user['user_id']); ?>" target="_blank" class="text-info">
                                                        <?php echo $user['user_name']; ?>
                                                    </a>
                                                </td>
                                                <td width="20%" class="text-center align-middle"><?php echo $user['user_brand']; ?></td>
                                                <td width="20%" class="text-center align-middle">
                                                    <span class="badge badge-pill bg-danger text-white ml-auto"><?php echo $user['user_role']; ?></span>
                                                </td>
                                                <td width="20%" class="text-center align-middle text-<?php echo($user['user_status'] == 'active')?"success":"danger"; ?>"><?php echo $user['user_status']; ?></td>
                                                <td width="10%" class="text-center align-middle">
                                                    <div class="btn-group">
                                                    <?php
                                                        if(checkAccess($session_role,'user_edit')){
                                                    ?>
                                                    <button class="btn btn-sm btn-success edituser" data-user-id="<?php echo $user['user_id']; ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                                                    </button>
                                                    <?php }if(checkAccess($session_role,'user_delete')){ ?>
                                                    <button class="btn btn-sm btn-danger deluser" data-user-id="<?php echo $user['user_id']; ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                    </button>
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
        <div class="modal fade" id="add_user">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Add User</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="add_user_form">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label text-left">User Name<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="user_name" class="form-control" value="" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-left">User Brand<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <select name="user_brand" required class="form-control" >
                                                <option value="">Select User Brand</option>
                                                <?php 
                                                    foreach ($brands as $key => $brand){
                                                ?>
                                                <option value="<?php echo $brand['brand_name'];?>"> <?php echo $brand['brand_name'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-left">User Level<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <select name="user_role" required class="form-control" >
                                                <option value="">Select User Level</option>
                                                <?php 
                                                    foreach ($roles as $key => $user){
                                                ?>
                                                <option value="<?php echo $user['role_name'];?>"> <?php echo $user['role_name'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-left">Password<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="password" name="user_password" class="form-control" value="" required>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-left">User Status<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <select name="user_status" id="" required class="form-control">
                                                <option value="">Select User Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-sm">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="edituserajax"></div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
        <script>
            $(document).on('submit','#add_user_form', function(e){
                e.preventDefault();
                var form = $('#add_user_form').serialize();
                $('#add_user').modal('hide');
                $.ajax({
                    url:base_url+"/users/add_user",
                    data:form,
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        location.reload(true);
                    }
                });
            });
            $(document).on('click','.edituser', function(){
                var user_id = $(this).data('user-id');
                $.ajax({
                    url:base_url+"/users/edit_userajax",
                    data:{
                        user_id: user_id,
                    },
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        if(output != "false"){
                            $('.edituserajax').html(output);
                            $('#edituserajax').modal('show');
                        }else{
                            location.reload(true);
                        }
                    }
                });
            });
            $(document).on('submit','#edit_user_form', function(e){
                e.preventDefault();
                var form = $('#edit_user_form').serialize();
                $('#edituserajax').modal('hide');
                $.ajax({
                    url:base_url+"/users/edit_user",
                    data:form,
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        location.reload(true);
                    }
                });
            });
            $('.deluser').click(function(){
                var user_id = $(this).data('user-id');
                Swal.fire({
                    html:
                        '<div class="text-center text-danger m-t-30 m-b-30"><h1 style="font-size:40px;"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg></h1></div>'+
                        '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>'+
                        'That you want to <b class="text-danger">delete this user</b> ',
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
                        url: "<?php echo base_url('users/delete_user') ; ?>",
                        type: "POST",
                        data: {
                            user_id: user_id,
                        },
                        dataType: "json",
                        success: function (output) {
                            if(output) {
                                Swal.fire({
                                        title:"Done!",
                                        text:"It was succesfully deleted!",
                                        type: "success"
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload(true);
                                        }
                                    });
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
            $('#loginTable').DataTable({
                ordering: true,
                paging: false,
                columnDefs : [
                    {
                        targets:[5],
                        "orderable": false
                    }
                ],
            });
        </script>
    </body>
</html>