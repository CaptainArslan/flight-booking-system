<!doctype html>
<html lang="en">
    <head>
        <?php $this->load->view('common/head', @$head); ?>
        <style>
            .m_total{
                display: none;
                cursor: pointer;
            }
            .m_hide{
                cursor: pointer;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="wrapper">
            <?php 
                $this->load->view('common/sidebar', @$sidebar);
                $this->load->view('common/header', @$header);
            ?>
            <div class="page-wrapper">                
                <div class="page-header bg-white m-0 pt-3 pb-2">
                    <div class="container-xl">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="page-pretitle"><?php echo($this->user_brand == 'All')?'All Brands':$this->user_brand; ?></div>
                                <h2 class="page-title"><?php echo $head['page_title']?></h2>
                            </div>
                            <div class="col-auto ms-auto">
                                <form id="monthform">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="form-group row">
                                                <label class="form-label col-auto col-form-label pt-1">Month</label>
                                                <div class="col-auto">
                                                    <input name="report_month" class="report_month form-control form-control-sm monthpicker" type="text" value="<?php echo date("M-Y"); ?>" placeholder="Enter Month" required>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (checkAccess($role, 'admin_view')) {
                                        ?>
                                        <div class="col-auto">
                                            <div class="form-group row">
                                                <label class="form-label col-auto col-form-label pt-1">Brand</label>
                                                <div class="col-auto">
                                                    <select name="report_brand" class="brand_name form-control form-control-sm">
                                                        <?php
                                                        $brands = GetBrands();
                                                        foreach ($brands as $key => $brand) {
                                                        ?>
                                                            <option value="<?php echo $brand['brand_name']; ?>">
                                                                <?php echo $brand['brand_name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>    
                                        <div class="col-auto">
                                            <button class="reportsubmitnbutton btn btn-sm btn-success ms-auto" type="submit">Submit</button>
                                        </div>                                   
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body p-2 text-center">
                                    <div class="h1 m-0 text-success"><?php echo $total_pending_inq; ?></div>
                                    <div class="text-muted mb-3">Pending Inquiries</div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body p-2 text-center">
                                    <div class="h1 m-0 text-primary">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Total Pending Bookings"><?php echo $total_bookings; ?></span> / <span data-bs-toggle="tooltip" data-bs-placement="top" title="Total Bookings For This Month"><?php echo $month_bookings; ?></span>
                                    </div>
                                    <div class="text-muted mb-3">Bookings</div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-auto">
                                            <a class="text-success font-weight-medium" href="<?php echo base_url("booking/alert/departure_date"); ?>">Upcoming Travelling</a>
                                        </div>
                                        <div class="col-auto ms-auto"><?php echo $ttldeptdue; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <a class="text-danger font-weight-medium" href="<?php echo base_url("booking/alert/retrun_date"); ?>">Just Arrived - Say Hi</a>
                                        </div>
                                        <div class="col-auto ms-auto"><?php echo $returned; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <a class="text-info font-weight-medium" href="<?php echo base_url("booking/alert/birthday"); ?>">Birthdays</a>
                                        </div>
                                        <div class="col-auto ms-auto"><?php echo $b_days; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="progress mt-2">
                                                <div class="progress-bar bg-cyan" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body p-2 text-center">
                                    <div class="h1 m-0 text-purple">
                                        <span class="m_hide" title="Click to Show Margin">****</span>
                                        <span class="m_total" title="Click to Hide Margin">&pound;<?php echo number_format($month_margin, 2) ?></span>
                                    </div>
                                    <div class="text-muted mb-3"><?php echo date("M"); ?> Margin</div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-purple" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="progress" class="table-responsive mt-3">
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
                                        <th width="7%" class="text-center align-middle">New <br><?php echo date('M-y'); ?></th>
                                        <th width="8%" class="text-center align-middle">Issued <br><?php echo date('M-y'); ?></th>
                                        <th width="9%" class="text-center align-middle">Cancelled <br><?php echo date('M-y'); ?></th>
                                        <th width="10%" class="text-center align-middle">Issuance <br><?php echo date('M-y'); ?></th>
                                        <th width="10%" class="text-center align-middle">Cancellation <br><?php echo date('M-y'); ?></th>
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
                                    if ($progressheet != 'false') {
                                        $currentmonthtotalprofit = array_column($progressheet, 'currentmonthtotalprofit');
                                        $pendingbookings = array_column($progressheet, 'pendingbookings');
                                        array_multisort($currentmonthtotalprofit, SORT_DESC, $pendingbookings, SORT_DESC, $progressheet);
                                        $cnt = 0;
                                        $agents = $progressheet;
                                        foreach ($agents as $agentname => $data) {
                                            $p_b = $c_b = $cm_b = $cmi_b = $cmc_b = $cmi_p = $cmc_p = $cmt_p = $cma_p = 0;
                                            $p_b = @$agents["$agentname"]["pendingbookings"];
                                            $c_b = @$agents["$agentname"]["currentdaybookings"];
                                            $cm_b = @$agents["$agentname"]["currentmonthbookings"];
                                            $cmi_b = @$agents["$agentname"]["currentmonthissuedbookings"];
                                            $cmc_b = @$agents["$agentname"]["currentmonthcancelledbookings"];
                                            $cmi_p = @$agents["$agentname"]["currentmonthissuanceprofit"];
                                            $cmc_p = @$agents["$agentname"]["currentmonthcancellationprofit"];
                                            $cmt_p = round($cmi_p, 2) + round($cmc_p, 2);
                                            if (($cmi_b + $cmc_b) != 0) {
                                                $cma_p =  round(($cmt_p) / ($cmi_b + $cmc_b), 2);
                                            }
                                            if (($p_b == '' || $p_b == 0) && ($c_b == '' || $c_b == 0) && ($cm_b == '' || $cm_b == 0) && ($cmi_b == '' || $cmi_b == 0) && ($cmc_b == '' || $cmc_b == 0) && ($cmi_p == '' || $cmi_p == 0) && ($cmc_p == '' || $cmc_p == 0) && ($cmt_p == '' || $cmt_p == 0) && ($cma_p == '' || $cma_p == 0)) {
                                                continue;
                                            }
                                            $cnt++;
                                            if (!checkAccess($role, 'admin_view') && !checkAccess($role, 'all_agent')) {
                                                if ($agentname != $s_agent) {
                                                    //$p_b = $cm_b = $cmi_b = $cmc_b = $cmi_p = $cmc_p = $cmt_p = $cma_p = 0;
                                                    $sr++;
                                                    continue;
                                                }
                                            }
                                    ?>
                                            <tr>
                                                <td class=" text-center">
                                                    <?php echo $sr; ?>
                                                </td>
                                                <td class=" text-center">
                                                    <?php echo $agentname; ?>
                                                </td>
                                                <td class=" text-center font-weight-bold">
                                                    <?php if (checkAccess($role, 'admin_view') || checkAccess($role, 'all_agent')) { ?>
                                                        <a href="<?php echo base_url("booking/pending/?agent=" . $agentname); ?>" target="_blank" class="text-info">
                                                        <?php } else if ($agentname == $s_agent) { ?>
                                                            <a href="<?php echo base_url("booking/pending/"); ?>" target="_blank" class="text-info">
                                                            <?php } ?>
                                                            <?php echo ($p_b == 0 || $p_b == '') ? "-" : $p_b; ?>
                                                            <?php if (checkAccess($role, 'admin_view') || checkAccess($role, 'all_agent')) { ?>
                                                            </a>
                                                        <?php } else if ($agentname == $s_agent) { ?>
                                                        </a>
                                                    <?php } ?>

                                                </td>
                                                <td class=" text-center bg-yellow">
                                                    <?php echo ($c_b == 0 || $c_b == '') ? "-" : $c_b; ?>
                                                </td>
                                                <td class=" text-center">
                                                    <?php echo ($cm_b == 0 || $cm_b == '') ? "-" : $cm_b; ?>
                                                </td>
                                                <td class=" text-center font-weight-bold">
                                                    <?php echo ($cmi_b == 0 || $cmi_b == '') ? "-" : $cmi_b; ?>
                                                </td>
                                                <td class=" text-center">
                                                    <?php echo ($cmc_b == 0 || $cmc_b == '') ? "-" : $cmc_b; ?>
                                                </td>
                                                <td class=" text-center">
                                                    <?php echo ($cmi_p == 0 || $cmi_p == '') ? "-" : number_format($cmi_p, 2); ?>
                                                </td>
                                                <td class=" text-center">
                                                    <?php echo ($cmc_p == 0 || $cmc_p == '') ? "-" : number_format($cmc_p, 2); ?>
                                                </td>
                                                <td class=" text-center font-weight-600 <?php echo (checkAccess($role, 'admin_view') || $agentname == $s_agent || checkAccess($role, 'all_agent')) ? 'grossprofit_details' : ''; ?>">
                                                    <?php if (checkAccess($role, 'admin_view') || $agentname == $s_agent || checkAccess($role, 'all_agent')) { ?>
                                                        <a href="JavaScript:Void(0)" data-agent="<?php echo $agentname; ?>" data-brand="<?php echo geruserbrand($agentname); ?>" data-sdate="<?php echo date('Y-m-01'); ?>" data-edate="<?php echo date('Y-m-t'); ?>" class="text-info">
                                                            <?php echo ($cmt_p == 0 || $cmt_p == '') ? "-" : number_format($cmt_p, 2); ?>
                                                        </a>
                                                    <?php } else { ?>
                                                        <?php echo ($cmt_p == 0 || $cmt_p == '') ? "-" : number_format($cmt_p, 2); ?>
                                                    <?php } ?>
                                                </td>
                                                <td class=" text-center">
                                                    <?php echo ($cma_p == 0 || $cma_p == '') ? "-" : number_format($cma_p, 2); ?>
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
                                            if (($t_cmi_b + $t_cmc_b) != 0) {
                                                $t_cma_p =  round(($t_cmt_p) / ($t_cmi_b + $t_cmc_b), 2);
                                            }
                                            $sr++;
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="11" class="text-center">No Progress...!!!</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <?php
                                if (checkAccess($role, 'admin_view') || checkAccess($role, 'all_agent')) {
                                ?>
                                    <tfoot>
                                        <tr style="border-top: solid thin #dcdcdc;border-bottom: solid thin #dcdcdc;">
                                            <th class="text-center " colspan="2">Total</th>
                                            <th class="text-center ">
                                                <a href="<?php echo base_url("booking/pending/"); ?>" target="_blank" class="text-info">
                                                    <?php echo $t_p_b; ?>
                                                </a>
                                            </th>
                                            <th class="text-center "><?php echo $t_c_b; ?></th>
                                            <th class="text-center "><?php echo $t_cm_b; ?></th>
                                            <th class="text-center "><?php echo $t_cmi_b; ?></th>
                                            <th class="text-center "><?php echo $t_cmc_b; ?></th>
                                            <th class="text-center "><?php echo number_format($t_cmi_p, 2) ?></th>
                                            <th class="text-center "><?php echo number_format($t_cmc_p, 2) ?></th>
                                            <th class="text-center  <?php echo (checkAccess($role, 'admin_view')) ? 'netprofit_details' : ''; ?>">
                                                <?php if (checkAccess($role, 'admin_view')) { ?>
                                                    <a href="JavaScript:Void(0)" data-agent="All" data-brand="All" data-sdate="<?php echo date('Y-m-01'); ?>" data-edate="<?php echo date('Y-m-t'); ?>" class="text-info">
                                                        <?php echo number_format($t_cmt_p, 2) ?>
                                                    </a>
                                                <?php } else { ?>
                                                    <?php echo number_format($t_cmt_p, 2) ?>
                                                <?php } ?>
                                            </th>
                                            <th class="text-center "><?php echo number_format($t_cma_p, 2) ?></th>
                                        </tr>
                                    </tfoot>
                                <?php } ?>
                            </table>
                            <?php
                            if (checkAccess($role, 'admin_view') || checkAccess($role, 'all_agent')) {
                                if (!is_array($brand) && $brand != $this->mainbrand) {
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
                                                if ($no_sa > 0) {
                                                    foreach ($sub_agent as $key => $sub_a) {
                                                        if ($sub_a['head'] == $brand) {
                                                            $subagent_comm = $sub_a['head_amt'];
                                                ?>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="m-b-0">Service Commission</label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <p class="m-b-0"><?php echo number_format($subagent_comm, 2); ?></p>
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
                                                if ($no_exp > 0) {
                                                    foreach ($expenses as $key => $exp) {
                                                ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="m-b-0"><?php echo $exp['head']; ?></label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p class="m-b-0"><?php echo number_format($exp['exp_amt'], 2); ?></p>
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
                                                        <p class="m-b-0 text-danger font-weight-600 text-center" style="border-bottom: thin solid #000">(<?php echo number_format($total_exp + $subagent_comm, 2); ?>)</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="offset-md-9 col-md-3">
                                                        <p class="m-b-0 font-weight-600 text-center">
                                                            <?php
                                                            echo number_format($t_cmt_p - ($total_exp + $subagent_comm), 2);
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
        <script>
            var base_url = window.location.origin;
            var loader = '<div class="card card-body"><div class="col-12"><div class="progress progress-sm"><div class="progress-bar progress-bar-indeterminate"></div></div></div></div>';
            $('#monthform').parsley();  
            $(document).on('submit','#monthform',function(e){
                e.preventDefault();
                var form = $('#monthform').serialize();
                var previoushtml = $('#progress').html();
                $(".reportsubmitnbutton").attr("disabled","disabled");
                $(".reportsubmitnbutton").html("<i class='fa fa-gear faa-spin animated'></i>");
                $('#progress').html(loader);
                $.ajax({
                    url:base_url+"/dashboard/progform",
                    data:form,
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        if(output !== 'error'){
                            $('#progress').html(output);
                        }else{
                            $('#progress').html(previoushtml);
                        }
                    }
                });
                setTimeout(function() {
                    $(".reportsubmitnbutton").removeAttr("disabled");
                    $(".reportsubmitnbutton").html("Submit");
                },2000);
            });
            $(document).on('change','.brand_name',function(e){
                e.preventDefault();
                var form = $('#monthform').serialize();
                var previoushtml = $('#progress').html();
                $(".reportsubmitnbutton").attr("disabled","disabled");
                $(".reportsubmitnbutton").html("<i class='fa fa-gear faa-spin animated'></i>");
                $('#progress').html(loader);
                $.ajax({
                    url:base_url+"/dashboard/progform",
                    data:form,
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        if(output !== 'error'){
                            $('#progress').html(output);
                        }else{
                            $('#progress').html(previoushtml);
                        }
                    }
                });
                setTimeout(function() {
                    $(".reportsubmitnbutton").removeAttr("disabled");
                    $(".reportsubmitnbutton").html("Submit");
                },2000);
            });
            $(document).on('change','.report_month',function(e){
                e.preventDefault();
                var form = $('#monthform').serialize();
                var previoushtml = $('#progress').html();
                $(".reportsubmitnbutton").attr("disabled","disabled");
                $(".reportsubmitnbutton").html("<i class='fa fa-gear faa-spin animated'></i>");
                $('#progress').html(loader);
                $.ajax({
                    url:base_url+"/dashboard/progform",
                    data:form,
                    type:"post",
                    dataType:"json",
                    success:function(output){
                        if(output !== 'error'){
                            $('#progress').html(output);
                        }else{
                            $('#progress').html(previoushtml);
                        }
                    }
                });
                setTimeout(function() {
                    $(".reportsubmitnbutton").removeAttr("disabled");
                    $(".reportsubmitnbutton").html("Submit");
                },2000);
            });
            $(document).on('click','.grossprofit_details a',function(e){
                e.preventDefault();
                $("#sidebarButton").trigger('click');
                var agent = $(this).data('agent');
                var supplier = 'All';
                var brand = $(this).data('brand');
                var sdate = $(this).data('sdate');
                var edate = $(this).data('edate');
                var report_name = 'gross_profit_earned';
                var previoushtml = $('#progress').html();
                $('#progress').html(loader);
                $.ajax({
                    url: base_url+"/reports/"+report_name,
                    data:{
                        report: report_name,
                        start_date: sdate,
                        end_date: edate,
                        agent: agent,
                        brand: brand,
                        supplier: supplier,
                    },
                    type:"post",
                    dataType:"json",
                    success: function(output){
                        if(output.status === 'true'){
                            $('#progress').html(output.html);
                        }else{
                            $('#progress').html(previoushtml);
                        }
                    }
                });
            });
            $(document).on('click','.netprofit_details a',function(e){
                e.preventDefault();
                $("#sidebarButton").trigger('click');
                var agent = $(this).data('agent');
                var supplier = 'All';
                var brand = $(this).data('brand');
                var sdate = $(this).data('sdate');
                var edate = $(this).data('edate');
                var report_name = 'net_profit_earned';
                var previoushtml = $('#progress').html();
                $('#progress').html(loader);
                $.ajax({
                    url: base_url+"/reports/"+report_name,
                    data:{
                        report: report_name,
                        start_date: sdate,
                        end_date: edate,
                        agent: agent,
                        brand: brand,
                        supplier: supplier,
                    },
                    type:"post",
                    dataType:"json",
                    success: function(output){
                        if(output.status === 'true'){
                            $('#progress').html(output.html);
                        }else{
                            $('#progress').html(previoushtml);
                        }
                    }
                });
            });
            $(document).on('click','.m_hide',function(){ 
                $(this).hide();
                $('.m_total').show();
            });
            $(document).on('click','.m_total',function(){ 
                $(this).hide();
                $('.m_hide').show();
            });         
        </script>
    </body>
</html>