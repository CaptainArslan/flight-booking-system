<!doctype html>
<html lang="en">
    <head>
        <?php 
            $this->load->view('common/head', @$head); 
            $removed = array(
                'gds_report',
                'cust_direct_payment_supplier',
            );
        ?>
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
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h4 class="card-title m-t-0">Selection Criteria</h4>
                                        <form id="reportForm" autocomplete="off">
                                            <?php 
                                                if(checkAccess($user_role,'admin_view_reports')){
                                            ?>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">From <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <input type="text" name="start_date" id="start_date" class="startdate form-control" value="<?php echo date('01-M-Y'); ?>">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">To <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <input type="text" name="end_date" id="end_date" class="enddate form-control" value="<?php echo date('d-M-Y'); ?>">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">Brand</label>
                                                        <div class="controls">
                                                            <select name="brand" id="brand" class="form-control">
                                                                <option value="">Select Brand</option>
                                                                <?php
                                                                    foreach ($brands as $key => $brand) {
                                                                ?>
                                                                <option value="<?php echo $brand['brand_name']; ?>" <?php echo($brand['brand_name'] == 'All')?'selected':'' ; ?>><?php echo $brand['brand_name']; ?></option>
                                                                <?php 
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">Supplier</label>
                                                        <div class="controls">
                                                            <select name="supplier" id="supplier" class="form-control">
                                                                <option value="">Select Supplier</option>
                                                                <option value="All" selected>All</option>
                                                                <?php
                                                                    foreach ($suppliers as $key => $supplier) {
                                                                ?>
                                                                <option value="<?php echo $supplier['supplier_name']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                                <?php 
                                                                    }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">Agent</label>
                                                        <div class="controls">
                                                            <select name="agent" id="agent" class="form-control">
                                                                <option value="" >Select Agent</option>
                                                                <option value="All" selected>All</option>
                                                                <?php
                                                                    foreach ($agents as $key => $agent) {
                                                                ?>
                                                                <option value="<?php echo $agent['user_name']; ?>"><?php echo $agent['user_name']; ?></option>
                                                                <?php 
                                                                    }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">Card</label>
                                                        <div class="controls">
                                                            <select name="card" id="card" class="form-control">
                                                                <option value="">Select Card</option>
                                                                <option value="All" selected>All</option>
                                                                <?php
                                                                    foreach ($cards as $key => $card) {
                                                                ?>
                                                                <option value="<?php echo $card['card_name']; ?>"><?php echo $card['card_name']; ?></option>
                                                                <?php 
                                                                    }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">GDS</label>
                                                        <div class="controls">
                                                            <select name="gds" id="gds" class="form-control">
                                                                <option value="">Select GDS</option>
                                                                <option value="All" selected>All</option>
                                                                <option value="World-Span">World Span</option>
                                                                <option value="Galileo">Galileo</option>
                                                                <option value="Sabre">Sabre</option>
                                                                <option value="Amadeus">Amadeus</option>
                                                                <option value="Web">Web</option>
                                                            </select>
                                                            
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">Report <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <select name="report_name" id="report_name" class="form-control" required>
                                                                <option value="" selected>Select Report</option>
                                                                <?php
                                                                    foreach ($reports as $key => $report) {
                                                                        $report_id = $report['report_id'];
                                                                        if(in_array($report_id,$removed)){
                                                                            continue ;
                                                                        }
                                                                ?>
                                                                <option value="<?php echo $report_id; ?>"><?php echo getrptname($report_id); ?></option>
                                                                <?php 
                                                                    }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">&nbsp;</label>
                                                        <div class="controls text-center">
                                                            <button type="submit" class="reportFormbtn btn btn-success btn-sm">Submit</button>
                                                        </div>                                                
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">From <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <input type="text" name="start_date" id="start_date" class="date form-control">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">To <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <input type="text" name="end_date" id="end_date" class="date form-control">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <?php 
                                                    $col = "col-md-3";
                                                    $col2 = "col-md-4";
                                                    if(checkAccess($user_role,'all_agents_reports')){
                                                        $col = "col-md-2";
                                                        $col2 = "col-md-3";
                                                ?>
                                                <div class="<?php echo $col; ?>">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">Agent</label>
                                                        <div class="controls">
                                                            <select name="agent" id="agent" class="form-control">
                                                                <option value="" selected>Select Agent</option>
                                                                <option value="All">All</option>
                                                                <?php
                                                                    foreach ($agents as $key => $agent) {
                                                                ?>
                                                                <option value="<?php echo $agent['user_name']; ?>"><?php echo $agent['user_name']; ?></option>
                                                                <?php 
                                                                    }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="<?php echo $col; ?>">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">Supplier</label>
                                                        <div class="controls">
                                                            <select name="supplier" id="supplier" class="form-control">
                                                                <option value="" selected>Select Supplier</option>
                                                                <option value="All">All</option>
                                                                <?php
                                                                    foreach ($suppliers as $key => $supplier) {
                                                                ?>
                                                                <option value="<?php echo $supplier['supplier_name']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                                <?php 
                                                                    }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>                                                
                                                    </div>
                                                </div>                    
                                                <div class="<?php echo $col2; ?>">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">Report <span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <select name="report_name" id="report_name" class="form-control" required>
                                                                <option value="" selected>Select Report</option>
                                                                <?php
                                                                    foreach ($reports as $key => $report) {
                                                                        $report_id = $report['report_id'];
                                                                        if(in_array($report_id,$removed)){
                                                                            continue ;
                                                                        }
                                                                ?>
                                                                <option value="<?php echo $report_id; ?>"><?php echo getrptname($report_id); ?></option>
                                                                <?php 
                                                                    }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group m-b-0">
                                                        <label class="form-label">&nbsp;</label>
                                                        <div class="controls text-center">
                                                            <button type="submit" class="reportFormbtn btn btn-success btn-sm">Submit</button>
                                                        </div>                                                
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                                <div class="reportdetails"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
        <script>
            $(document).on('change', '#report_name', function () {
                var report_name = $('#report_name').val();
                if (report_name === 'supplier_variance_p_t') {
                    $('#start_date').val('');
                    $('#end_date').val('');
                }
            });
            $(document).on('submit', '#reportForm', function (e) {
                e.preventDefault();
                var report_name = $("#report_name").val();
                var gds = $("#gds").val();
                var card = $("#card").val();
                var agent = $("#agent").val();
                var supplier = $("#supplier").val();
                var brand = $("#brand").val();
                var sdate = $("#start_date").val();
                var edate = $("#end_date").val();
                if (report_name === 'gross_profit_earned') {
                    if (sdate === '' || edate === '' || agent === '' || brand === '' || supplier === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        if (agent === '') {
                            text += '<li>Select Agent</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        if (supplier === '') {
                            text += '<li>Select Supplier</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                agent: agent,
                                brand: brand,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                } else if (report_name === 'net_profit_earned') {
                    if (sdate === '' || edate === '' || agent === '' || brand === '' || supplier === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        if (agent === '') {
                            text += '<li>Select Agent</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        if (supplier === '') {
                            text += '<li>Select Supplier</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                agent: agent,
                                brand: brand,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                } else if (report_name === 'client_data') {
                    if (sdate === '' || edate === '' || agent === '' || brand === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        if (agent === '') {
                            text += '<li>Select Agent</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                agent: agent,
                                brand: brand,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                } else if (report_name === 'customer_due_balance') {
                    if (sdate === '' || edate === '' || agent === '' || brand === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        if (agent === '') {
                            text += '<li>Select Agent</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        if (supplier === '') {
                            text += '<li>Select supplier</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                agent: agent,
                                brand: brand,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                } else if (report_name === 'supplier_due_balance') {
                    if (sdate === '' || edate === '' || agent === '' || brand === '' || supplier === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        if (agent === '') {
                            text += '<li>Select Agent</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        if (supplier === '') {
                            text += '<li>Select Supplier</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                agent: agent,
                                brand: brand,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                } else if (report_name === 'supplier_variance_p_t') {
                    if (agent === '' || brand === '' || supplier === '') {
                        var text = '<ul>';
                        // if (sdate === '') {
                        // 	text += '<li>Enter Start Date</li>';
                        // }
                        // if (edate === '') {
                        // 	text += '<li>Enter End Date</li>';
                        // }
                        if (agent === '') {
                            text += '<li>Select Agent</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        if (supplier === '') {
                            text += '<li>Select Supplier</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                agent: agent,
                                brand: brand,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                } else if (report_name === 'cust_direct_payment_supplier') {
                    if (sdate === '' || edate === '' || agent === '' || brand === '' || supplier === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        if (agent === '') {
                            text += '<li>Select Agent</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        if (supplier === '') {
                            text += '<li>Select Supplier</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                agent: agent,
                                brand: brand,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                } else if (report_name === 'card_charge_report') {
                    if (sdate === '' || edate === '' || agent === '' || brand === '' || card === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        if (agent === '') {
                            text += '<li>Select Agent</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        if (card === '') {
                            text += '<li>Select Card Head</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                agent: agent,
                                brand: brand,
                                card: card,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                    // }else if(report_name === 'supplier_card_charge_report'){
                    // 	if(sdate ==='' || edate==='' || agent==='' || brand==='' || supplier===''){
                    // 		var text = '<ul>';
                    // 		if(sdate ===''){
                    // 			text += '<li>Enter Start Date</li>';
                    // 		}
                    // 		if(edate ===''){
                    // 			text += '<li>Enter End Date</li>';
                    // 		}
                    // 		if(agent ===''){
                    // 			text += '<li>Select Agent</li>';
                    // 		}
                    // 		if(supplier ===''){
                    // 			text += '<li>Select Supplier</li>';
                    // 		}
                    // 		if(brand ===''){
                    // 			text += '<li>Select Brand</li>';
                    // 		}
                    // 		text += '</ul>';
                    // 		$.toast({
                    //             heading: 'Selection Criteria',
                    //             text: 'Please select the following fields.'+text,
                    //             position: 'top-right',
                    //             loaderBg: '#ff6849',
                    //             icon: 'error',
                    //             hideAfter: 3500,
                    //             stack: 6
                    //         });
                    // 	}else{
                    // 		$('.reportdetails').html(loader);
                    // 		$.ajax({
                    //             url: base_url+"/reports/"+report_name,
                    //             data:{
                    //             	report: report_name,
                    //             	start_date: sdate,
                    //             	end_date: edate,
                    //             	agent: agent,
                    //             	brand: brand,
                    //             	supplier: supplier,
                    //             },
                    //             type:"post",
                    //             dataType:"json",
                    //             success: function(output){
                    //             	$('.reportdetails').html(output);
                    //             }
                    //         });
                    // 	}
                } else if (report_name === 'activity_summary') {
                    if (sdate === '' || edate === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                agent: agent,
                                brand: brand,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                    // }else if(report_name === 'bt_panel_card_charge'){
                    // 	if(sdate ==='' || edate===''){
                    // 		var text = '<ul>';
                    // 		if(sdate ===''){
                    // 			text += '<li>Enter Start Date</li>';
                    // 		}
                    // 		if(edate ===''){
                    // 			text += '<li>Enter End Date</li>';
                    // 		}
                    // 		text += '</ul>';
                    // 		$.toast({
                    //             heading: 'Selection Criteria',
                    //             text: 'Please select the following fields.'+text,
                    //             position: 'top-right',
                    //             loaderBg: '#ff6849',
                    //             icon: 'error',
                    //             hideAfter: 3500,
                    //             stack: 6
                    //         });
                    // 	}
                } else if (report_name === 'gds_report') {
                    if (sdate === '' || edate === '' || brand === '' || gds === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        if (gds === '') {
                            text += '<li>Select GDS</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                brand: brand,
                                gds: gds,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                } else if (report_name === 's_p_report') {
                    if (sdate === '' || edate === '' || agent === '' || brand === '' || supplier === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        if (agent === '') {
                            text += '<li>Select Agent</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        if (supplier === '') {
                            text += '<li>Select Supplier</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                brand: brand,
                                agent: agent,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                } else if (report_name === 'sale_variance_file_t_report') {
                    if (sdate === '' || edate === '' || agent === '' || brand === '' || supplier === '') {
                        var text = '<ul>';
                        if (sdate === '') {
                            text += '<li>Enter Start Date</li>';
                        }
                        if (edate === '') {
                            text += '<li>Enter End Date</li>';
                        }
                        if (agent === '') {
                            text += '<li>Select Agent</li>';
                        }
                        if (brand === '') {
                            text += '<li>Select Brand</li>';
                        }
                        if (supplier === '') {
                            text += '<li>Select Supplier</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.' + text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    } else {
                        $('.reportdetails').html(loader);
                        $.ajax({
                            url: base_url + "/reports/" + report_name,
                            data: {
                                report: report_name,
                                start_date: sdate,
                                end_date: edate,
                                brand: brand,
                                agent: agent,
                                supplier: supplier,
                            },
                            type: "post",
                            dataType: "json",
                            success: function (output) {
                                if (output.status === 'true') {
                                    $('.reportdetails').html(output.html);
                                } else {
                                    $('.reportdetails').html('');
                                    $.toast({
                                        heading: 'Access Denied',
                                        text: 'Permission to access this report is denied.',
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'error',
                                        hideAfter: 3500,
                                        stack: 6
                                    });
                                }
                            }
                        });
                    }
                }
            });
            $(document).on('click', '.exportexcel', function () {
                $('#reportForm').attr('action', base_url + "/export/exportexcel");
                $('#reportForm').attr('method', 'post');
                $('#reportForm')[0].submit();
            });
        </script>
    </body>
</html>