<div class="modal fade" id="editAccessLevel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold">Edit Level - <span class="text-success"><?php echo $role_name;?></span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="editacclvl">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group m-b-0">
                                <label class="form-label">Access Level Name<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="role_name" class="form-control" value="<?php echo $role_name;?>" required>
                                    <input type="hidden" name="old_role_name" value="<?php echo $role_name;?>">
                                    <input type="hidden" name="role_id" value="<?php echo $role_id;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-danger">Page Access</h4>
                    <hr class="mt-1 mb-1">
                    <?php 
                        $sr = 1;
                        asort($details['all_pages']);
                        foreach ($details['all_pages'] as $key => $page) {
                    ?>
                    <h5 class="card-title text-cyan mb-0"><?php echo $page['access_page']; ?></h5>
                    <div class="row mb-2">
                        <?php
                            foreach ($details['all_access'] as $key => $access) {
                                if($page['access_page'] == $access['access_page']){
                        ?>
                        <div class="col-md-3">
                            <div class="controls">
                                <div class="custom-control custom-checkbox">
                                    <label class="form-label" for="customCheck<?php echo $sr; ?>">
                                    <input type="checkbox" value="<?php echo $access['access_id']; ?>" id="customCheck<?php echo $sr; ?>" name="access_name[]" <?php echo(in_array($access['access_name'] , $role_access))?'checked':''; ?>> <?php echo $access['access_name']; ?></label>
                                </div>
                            </div>
                        </div>
                        <?php 
                                }
                            $sr++;
                            }
                        ?>
                    </div>   
                    <?php } ?>                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-warning" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Edit Access Level</button>
                </div>
            </form>
        </div>
    </div>
</div>