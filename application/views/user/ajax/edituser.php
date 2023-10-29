<div class="modal fade" id="edituserajax">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold">Edit User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="edit_user_form">
                <div class="modal-body">
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">User Name<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="user_name" class="form-control" value="<?php echo $user_detail['user_name']; ?>" required autocomplete="off">
                                    <input type="hidden" name="user_id" value="<?php echo $user_detail['user_id']; ?>">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">User Status<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select name="user_status" id="" required class="form-control">
                                        <option value="">Select User Status</option>
                                        <option value="active" <?php echo($user_detail['user_status'] == "active")?"selected":""; ?>>Active</option>
                                        <option value="inactive" <?php echo($user_detail['user_status'] == "inactive")?"selected":""; ?>>Inactive</option>
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">User Brand<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select name="user_brand" required class="form-control">
                                        <option value="">Select User Brand</option>
                                        <?php 
                                            foreach ($brands as $key => $brand){
                                        ?>
                                        <option value="<?php echo $brand['brand_name'];?>" <?php echo($brand['brand_name'] == $user_detail['user_brand'])?"selected":""; ?>> <?php echo $brand['brand_name'];?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">User Level<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select name="user_role" required class="form-control" data-validation-required-message="Select a user level">
                                        <option value="">Select User Level</option>
                                        <?php 
                                            foreach ($roles as $key => $user){
                                        ?>
                                        <option value="<?php echo $user['role_name'];?>" <?php echo($user['role_name'] == $user_detail['user_role'])?"selected":""; ?>> <?php echo $user['role_name'];?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="form-label">Password<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="password" name="user_password" id="user_password" class="form-control" value="<?php echo hashing($user_detail['user_password'],'d'); ?>" required>
                                    <span toggle="#user_password" class="field-icon viewpass toggle-password">view password</span>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".toggle-password").click(function() {
        $(this).toggleClass("viewpass");
        var input = $($(this).attr("toggle"));
        if(input.attr("type") == "password"){
          input.attr("type", "text");
        }else{
          input.attr("type", "password");
        }
      });
</script>