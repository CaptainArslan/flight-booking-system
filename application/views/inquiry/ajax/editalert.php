<div class="modal fade" id="editAlert">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold" id="editAlertLabel1">Edit Reminder</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editalertform">
                    <input type="hidden" name="enq_id" value="<?php echo $alert_details['enq_id']; ?>">
                    <input type="hidden" name="alert_id" value="<?php echo $alert_details['id']; ?>">
                    <input type="hidden" name="alertedit_by" value="<?php echo $this->session->userdata('user_name'); ?>">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group m-b-5">
                                <h6>Date &amp; Time <span class="text-danger">*</span></h6>
                                <div class="controls">
                                    <input type="text" name="alertdatetime" class="datetime form-control" required value="<?php echo date("d-M-Y h:i A",strtotime($alert_details['alert_datetime'])) ; ?>">
                                </div>                                               
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-b-0">
                                <h6>Message <span class="text-danger">*</span></h6>
                                <div class="controls">
                                    <textarea name="alertmsg" type="text" rows="5" class="form-control" required><?php
                                        echo $alert_details['alert_msg'];
                                    ?></textarea> 
                                </div>                                               
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="editalertform" class="editalertformbtn btn btn-success btn-sm">Edit</button>
            </div>
        </div>
    </div>
</div>