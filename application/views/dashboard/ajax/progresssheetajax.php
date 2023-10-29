<table id="progsheet" class="table table-bordered table-vcenter table-hover table-striped mb-0">
    <thead>
        <tr>
            <th width="6%" class="text-center align-middle" rowspan="2">Rank</th>
            <th width="14%" class="text-center align-middle" rowspan="2">Agent</th>
            <th class="text-center align-middle" colspan="5">Bookings</th>
            <th class="text-center align-middle" colspan="4">Profit</th>
        </tr>
        <tr>
            <th width="8%" class="text-center align-middle">Total<br>Pending</th>
            <th width="8%" class="text-center align-middle">Today</th>
            <th width="7%" class="text-center align-middle">New <br><?php echo date('M-y',strtotime($sdate)); ?></th>
            <th width="8%" class="text-center align-middle">Issued <br><?php echo date('M-y',strtotime($sdate)); ?></th>
            <th width="9%" class="text-center align-middle">Cancelled <br><?php echo date('M-y',strtotime($sdate)); ?></th>
            <th width="10%" class="text-center align-middle">Issuance <br><?php echo date('M-y',strtotime($sdate)); ?></th>
            <th width="10%" class="text-center align-middle">Cancellation <br><?php echo date('M-y',strtotime($sdate)); ?></th>
            <th width="12%" class="text-center align-middle">Total</th>
            <th width="8%" class="text-center align-middle">Average</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $s_agent  = $this->session->userdata('user_name');
            $sr = 1;
            $bgcolorcheck = 1; 
            $t_p_b = 0;
            $t_c_b = 0;
            $t_cm_b = 0;
            $t_cmi_b = 0;
            $t_cmc_b = 0;
            $t_cmi_p = 0;
            $t_cmc_p = 0;
            $t_cmt_p = 0;
            $t_cma_p = 0;
            if($progressheet != 'false'){
                $currentmonthtotalprofit = array_column($progressheet, 'currentmonthtotalprofit');
                $pendingbookings = array_column($progressheet, 'pendingbookings');
                array_multisort($currentmonthtotalprofit, SORT_DESC,$pendingbookings, SORT_DESC, $progressheet);
                $cnt = 0;
                $agents = $progressheet;
                foreach( $agents as $agentname => $data) { 
                    $p_b = $c_b = $cm_b = $cmi_b = $cmc_b = $cmi_p = $cmc_p = $cmt_p = $cma_p = 0;
                    $p_b = @$agents["$agentname"]["pendingbookings"]; 
                    $c_b = @$agents["$agentname"]["currentdaybookings"]; 
                    $cm_b = @$agents["$agentname"]["currentmonthbookings"]; 
                    $cmi_b = @$agents["$agentname"]["currentmonthissuedbookings"]; 
                    $cmc_b = @$agents["$agentname"]["currentmonthcancelledbookings"]; 
                    $cmi_p = @$agents["$agentname"]["currentmonthissuanceprofit"]; 
                    $cmc_p = @$agents["$agentname"]["currentmonthcancellationprofit"]; 
                    $cmt_p = round($cmi_p,2) + round($cmc_p,2);
                    if(($cmi_b + $cmc_b) != 0){
                        $cma_p =  round(($cmt_p)/($cmi_b + $cmc_b),2);
                    } 
                    if(($p_b =='' || $p_b == 0 ) && ($c_b =='' || $c_b == 0 ) && ($cm_b =='' || $cm_b == 0 ) && ($cmi_b =='' || $cmi_b == 0 ) && ($cmc_b =='' || $cmc_b == 0 ) && ($cmi_p =='' || $cmi_p == 0 ) && ($cmc_p =='' || $cmc_p == 0 ) && ($cmt_p =='' || $cmt_p == 0 ) && ($cma_p =='' || $cma_p == 0 )){
                        continue;
                    }
                    $cnt++; 
                    if(!checkAccess($role,'admin_view') && !checkAccess($role,'all_agent')){
                        if($agentname != $s_agent){
                            $p_b = $cm_b = $cmi_b = $cmc_b = $cmi_p = $cmc_p = $cmt_p = $cma_p = 0;
                        }
                    }
        ?>
        <tr style="border-bottom: thin dotted #dcdcdc;">
            <td class="p-0-5 text-center">
                <?php echo $sr; ?>
            </td>
            <td class="p-0-5 text-left">
                <?php echo $agentname ;?>
            </td>
            <td class="p-0-5 text-center font-weight-bold">
                <?php if(checkAccess($role,'admin_view') || checkAccess($role,'all_agent')){ ?>
                <a href="<?php echo base_url("booking/pending/?agent=".$agentname); ?>" target="_blank" class="text-info">
                <?php }else if($agentname == $s_agent){ ?>
                <a href="<?php echo base_url("booking/pending/"); ?>" target="_blank" class="text-info">
                <?php } ?>
                    <?php echo($p_b == 0 || $p_b == '')?"-":$p_b; ?>
                <?php if(checkAccess($role,'admin_view') || checkAccess($role,'all_agent')){ ?>
                </a>
                <?php }else if($agentname == $s_agent){ ?>
                </a>
                <?php } ?>
                
            </td>
            <td class="p-0-5 text-center bg-yellow">
                <?php echo($c_b == 0 || $c_b == '')?"-":$c_b; ?>
            </td>
            <td class="p-0-5 text-center">
                <?php echo($cm_b == 0 || $cm_b == '')?"-":$cm_b; ?>
            </td>
            <td class="p-0-5 text-center font-weight-bold">
                <?php echo($cmi_b == 0 || $cmi_b == '')?"-":$cmi_b; ?>
            </td>
            <td class="p-0-5 text-center">
                <?php echo($cmc_b == 0 || $cmc_b == '')?"-":$cmc_b; ?>
            </td>
            <td class="p-0-5 text-center">
                <?php echo($cmi_p == 0 || $cmi_p == '')?"-":number_format($cmi_p,2); ?>
            </td>
            <td class="p-0-5 text-center">
                <?php echo($cmc_p == 0 || $cmc_p == '')?"-":number_format($cmc_p,2); ?>
            </td>
            <td class="p-0-5 text-center font-weight-600 <?php echo(checkAccess($role,'admin_view') || $agentname == $s_agent || checkAccess($role,'all_agent'))?'grossprofit_details':''; ?>">
                <?php if(checkAccess($role,'admin_view') || $agentname == $s_agent || checkAccess($role,'all_agent')){ ?>
                <a href="JavaScript:Void(0)" data-agent="<?php echo $agentname; ?>" data-brand="<?php echo geruserbrand($agentname); ?>" data-sdate="<?php echo date('Y-m-01',strtotime($sdate)); ?>" data-edate="<?php echo date('Y-m-t',strtotime($edate)); ?>" class="text-info">
                    <?php echo($cmt_p == 0 || $cmt_p == '')?"-":number_format($cmt_p,2); ?>
                </a>
                <?php }else{ ?>
                    <?php echo($cmt_p == 0 || $cmt_p == '')?"-":number_format($cmt_p,2); ?>
                <?php } ?>
            </td>
            <td class="p-0-5 text-center">
                <?php echo($cma_p == 0 || $cma_p == '')?"-":number_format($cma_p,2); ?>
            </td>
        </tr>
        <?php
                    $t_p_b += $p_b;
                    $t_c_b += $c_b;
                    $t_cm_b += $cm_b;
                    $t_cmi_b += $cmi_b;
                    $t_cmc_b += $cmc_b;
                    $t_cmi_p += $cmi_p;
                    $t_cmc_p += $cmc_p;
                    $t_cmt_p += $cmt_p;
                    if(($t_cmi_b + $t_cmc_b) != 0){
                        $t_cma_p =  round(($t_cmt_p)/($t_cmi_b + $t_cmc_b),2);
                    }
                    $sr++;
                } 
            }else{
        ?>
        <tr>
            <td colspan="11" class="text-center">No Progress...!!!</td>
        </tr>
        <?php } ?>
    </tbody>
    <?php
        if(checkAccess($role,'admin_view') || checkAccess($role,'all_agent')){
    ?>
    <tfoot>
        <tr style="border-top: solid thin #dcdcdc;border-bottom: solid thin #dcdcdc;">
            <th class="text-center p-0-5" colspan="2">Total</th>
            <th class="text-center p-0-5">
                <a href="<?php echo base_url("booking/pending/?brand=".$brand); ?>" target="_blank" class="text-info">
                    <?php echo $t_p_b ; ?>
                </a>
            </th>
            <th class="text-center p-0-5"><?php echo $t_c_b ; ?></th>
            <th class="text-center p-0-5"><?php echo $t_cm_b ; ?></th>
            <th class="text-center p-0-5"><?php echo $t_cmi_b ; ?></th>
            <th class="text-center p-0-5"><?php echo $t_cmc_b ; ?></th>
            <th class="text-center p-0-5"><?php echo number_format($t_cmi_p,2) ?></th>
            <th class="text-center p-0-5"><?php echo number_format($t_cmc_p,2) ?></th>
            <th class="text-center p-0-5 <?php echo(checkAccess($role,'admin_view'))?'netprofit_details':''; ?>">
                <?php if(checkAccess($role,'admin_view')){ ?>
                <a href="JavaScript:Void(0)" data-agent="All" data-brand="<?php echo $brand; ?>" data-sdate="<?php echo date('Y-m-01',strtotime($sdate)); ?>" data-edate="<?php echo date('Y-m-t',strtotime($edate)); ?>" class="text-info">
                    <?php echo number_format($t_cmt_p,2) ?>
                </a>
                <?php }else{ ?>
                <?php echo number_format($t_cmt_p,2) ?>
                <?php } ?>
            </th>
            <th class="text-center p-0-5"><?php echo number_format($t_cma_p,2) ?></th>
        </tr>
    </tfoot>
    <?php } ?>
</table>
<?php
    if(checkAccess($role,'admin_view') || checkAccess($role,'all_agent')){
        if($brand == $this->mainbrand){
?>
<div class="card card-body" style="font-weight: 400; letter-spacing: 1.1px;">
    <div class="row">
        <div class="offset-md-6 col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-600">Less Expenses:</label>
                </div>
            </div>
            <?php
                $total_exp = 0;
                $no_exp = count($expenses);
                if($no_exp > 0 ){
                    foreach ($expenses as $key => $exp) {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <label class="m-b-0"><?php echo $exp['head'] ; ?></label>
                </div>
                <div class="col-md-3">
                    <p class="m-b-0"><?php echo number_format($exp['exp_amt'],2) ; ?></p>
                </div>
            </div>
            <?php
                    $total_exp += $exp['exp_amt'];
                    }  
                }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <label class="m-b-0 font-weight-600"><i class="text-gray">Total Expenses</i></label>
                </div>
                <div class="offset-md-3 col-md-3">
                    <p class="m-b-0 text-danger font-weight-600 text-center" style="border-bottom: thin solid #000">(<?php echo number_format($total_exp,2) ; ?>)</p>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-9 col-md-3">
                    <p class="m-b-0 font-weight-600 text-center">
                        <?php
                            echo number_format($t_cmt_p-$total_exp,2);
                        ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-600">Add Incomes:</label>
                </div>
            </div>
            <?php
                $total_incomes = 0;
                $ttlcm = 0;
                $no_oi = count($other_income);
                if($no_oi > 0 ){
                    foreach ($other_income as $key => $oi) {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <label class="m-b-0"><?php echo $oi['head'] ; ?></label>
                </div>
                <div class="col-md-3">
                    <p class="m-b-0"><?php echo number_format($oi['incm_amt'],2) ; ?></p>
                </div>
            </div>
            <?php 
                    $total_incomes += $oi['incm_amt'];
                    }
                }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <label class="m-b-0 font-weight-600"><i class="text-gray">Total Misc Income</i></label>
                </div>
                <div class="offset-md-3 col-md-3">
                    <p class="m-b-0 font-weight-600 text-center" style="border-bottom: thin solid #000">
                        (<?php echo number_format($total_incomes,2) ; ?>)
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-9 col-md-3">
                    <p class="m-b-0 font-weight-600 text-center">
                        <?php echo number_format($t_cmt_p+$total_incomes - ($total_exp),2) ; ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-600">Add Sub Agents Comm.:</label>
                </div>
            </div>
            <?php 
                $no_sa = count($sub_agent);
                if($no_sa > 0 ){
                    foreach ($sub_agent as $key => $sub_a) {
                        if($sub_a['head_amt'] == 0){
                            continue;
                        }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <label class="m-b-0"><?php echo $sub_a['head'] ; ?></label>
                </div>
                <div class="col-md-3">
                    <p class="m-b-0"><?php echo number_format($sub_a['head_amt'],2) ; ?></p>
                </div>
            </div>
            <?php 
                    $ttlcm += $sub_a['head_amt'];
                    }
                }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <label class="m-b-0 font-weight-600"><i class="text-gray">Total Sub Agents Comm.</i></label>
                </div>
                <div class="offset-md-3 col-md-3">
                    <p class="m-b-0 font-weight-600 text-center" style="border-bottom: thin solid #000">
                        (<?php echo number_format($ttlcm,2) ; ?>)
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="m-b-0 font-weight-600">Net Balance</label>
                </div>
                <div class="offset-md-3 col-md-3">
                    <p class="m-b-0 font-weight-600 text-center" style="border-bottom: thin solid #000">
                        <?php echo number_format(round(($t_cmt_p+$total_incomes+$ttlcm),2) - ($total_exp),2) ; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
        }else{
?>
<div class="card card-body" style="font-weight: 400; letter-spacing: 1.1px;">
    <div class="row">
        <div class="offset-md-6 col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-600">Less Expenses:</label>
                </div>
            </div>
            <?php 
                $no_sa = count($sub_agent);
                $subagent_comm = 0;
                if($no_sa > 0 ){
                    foreach ($sub_agent as $key => $sub_a) {
                        if($sub_a['head'] == $brand){
                            $subagent_comm = $sub_a['head_amt'];
            ?>
            <div class="row">
                <div class="col-md-6">
                    <label class="m-b-0">Service Commission</label>
                </div>
                <div class="col-md-3">
                    <p class="m-b-0"><?php echo number_format($subagent_comm,2) ; ?></p>
                </div>
            </div>
            <?php 
                        }
                    }
                }
            ?>
            <?php
                $total_exp = 0;
                $no_exp = count($expenses);
                if($no_exp > 0 ){
                    foreach ($expenses as $key => $exp) {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <label class="m-b-0"><?php echo $exp['head'] ; ?></label>
                </div>
                <div class="col-md-3">
                    <p class="m-b-0"><?php echo number_format($exp['exp_amt'],2) ; ?></p>
                </div>
            </div>
            <?php
                    $total_exp += $exp['exp_amt'];
                    }  
                }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <label class="m-b-0 font-weight-600"><i class="text-gray">Total Expenses</i></label>
                </div>
                <div class="offset-md-3 col-md-3">
                    <p class="m-b-0 text-danger font-weight-600 text-center" style="border-bottom: thin solid #000">(<?php echo number_format($total_exp+$subagent_comm,2) ; ?>)</p>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-9 col-md-3">
                    <p class="m-b-0 font-weight-600 text-center">
                        <?php
                            echo number_format($t_cmt_p-($total_exp+$subagent_comm),2);
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        }
    }
    ?>