<div class="card-body">
    <div class="table-responsive">
        <table id="tb_table" class="table-striped table led-table-bg">
            <thead>
                <tr>
                    <th width="5%" class="text-center text-white">#</th>
                    <th width="45%" class="text-center text-white">Head</th>
                    <th width="25%" class="text-center text-white">Dr.</th>
                    <th width="25%" class="text-center text-white">Cr.</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $srn = 1;
                    $drtotal = 0;
                    $crtotal = 0;
                    foreach($thobal as $k => $v) {
                        if(round(abs($v)) == 0){
                            continue;
                        }
                 ?>
                <tr>
                    <td class="text-center align-middle"><?php echo $srn; ?></td>
                    <td class="text-left align-middle"><?php echo substr($k,1); ?></td>
                    <td class="text-center align-middle">
                        <?php 
                            if($v >= 0){ 
                                echo number_format(round(abs($v),2),2); 
                                $drtotal = (double)round($drtotal,2) + (double)round($v,2);
                            }else{
                                echo "-";
                            }
                        ?>
                    </td>
                    <td class="text-center align-middle">
                        <?php 
                            if($v <= 0){ 
                                echo number_format(round(abs($v),2),2); 
                                $crtotal = (double)round($crtotal,2) + (double)round($v,2);
                            }else{
                                echo "-";
                            } 
                        ?>
                    </td>
                </tr>
                <?php 
                    $srn++;
                    } 
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr style="border-bottom: 0 !important;background: #fff !important">
                                <th style="padding: 0px; border: none !important;">
                                    <?php 
                                        $balance = 0;
                                        $balance = round(abs($drtotal),2)-round(abs($crtotal),2);
                                        if($balance !=0){ 
                                    ?>
                                    Variance: <?php echo number_format(round($balance,2),2) ; ?> <small class="text-danger">(if any)</small>
                                    <?php } ?>
                                </th>
                                <th style="padding: 0px; border: none !important;" class="text-right">Total</th>
                            </tr>
                        </table>
                    </th>
                    <th class="text-center align-middle"><?php echo number_format(round($drtotal,2),2); ?></th>
                    <th class="text-center align-middle"><?php echo number_format(round(abs($crtotal),2),2); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>