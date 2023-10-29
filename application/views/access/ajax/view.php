<div class="modal fade" id="viewAccessLevel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold"><?php echo $role_name;?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table full-color-table full-info-table table-bordered">
                        <thead>
                            <tr>
                                <th width="20%" class="text-center">Page Name</th>
                                <th width="80%" class="text-center">Access Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($role_access['access_page'] as $key => $page) {
                            ?>
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="badge bg-red"><?php echo $page['access_page']; ?></span>
                                </td>
                                <td class="align-middle">
                                    <?php 
                                        foreach ($role_access['access_name'] as $key => $access){
                                            if($access['access_page'] == $page['access_page']){
                                    ?>
                                    <span class="badge bg-info"><?php echo $access['access_name']; ?></span>
                                    <?php 
                                            }
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-warning text-dark" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>