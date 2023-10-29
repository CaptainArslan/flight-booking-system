
<div class="col-md-12">
    <?php
        if(count($enq_feedback) > 0 || $enq_details['enq_feedback'] != ''){
            echo '<hr class="mt-2 mb-2">';
        }
        foreach ($enq_feedback as $key => $feed) {
    ?>
    <p class="mb-0">
        <strong class="font-weight-600"><?php echo $feed['cmnt_by'] ; ?> (<?php echo date('d-M-y G:ia',strtotime($feed['cmnt_datetime'])) ; ?>)</strong><br>
        <span class="text-dark"><?php echo $feed['enq_cmnt']; ?></span>
    </p>
    <?php 
        } 
        if($enq_details['enq_feedback'] != ''){ 
    ?>
    <p class="mb-0">
        <?php echo nl2br(str_replace("<br><br>","<br>", $enq_details['enq_feedback'])); ?>
    </p>
    <?php
        }
    ?>
</div>