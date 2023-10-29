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
                <div class="page-header bg-white m-0 pt-3 pb-2">
                    <div class="container-xl">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="page-pretitle"><?php echo($this->user_brand == 'All')?'All Brands':$this->user_brand; ?></div>
                                <h2 class="page-title"><?php echo $head['page_title']?></h2>
                            </div>
                            <div class="col-auto ms-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <input type="text" name="month" class="inq_month monthpicker form-control form-control-sm" required="" placeholder="Select a month" onchange="this.form.submit();" value="<?php echo date("M-Y",strtotime($month)) ?>" />
                                    </div>
                                    <div class="col-auto ms-auto">
                                        <select name="agent" class="agent form-control form-control-sm" onchange="this.form.submit();">
                                            <option value="" <?php echo(isset($agent) && $agent == '')?"selected":""; ?>>Select All</option>
                                            <?php foreach ($agents as $key => $user) { if($user['user_name'] != ''){?>
                                            <option value="<?php echo $user['user_name'] ; ?>" <?php echo(isset($agent) && $agent == $user['user_name'])?'selected':''; ?>><?php echo $user['user_name'] ; ?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body analytics-info">
                                        <h4 class="card-title text-success">Mature</h4>
                                        <div class="stats-row">
                                            <div class="stat-item">
                                                <h6><?php echo date("M-Y",strtotime($month)) ?></h6>
                                                <h6><?php echo($header_data_report['cur_mth_inq'] != 0)?$header_data_report['cur_mth_mat_inq']." / ".$header_data_report['cur_mth_inq']." - ".round(($header_data_report['cur_mth_mat_inq'] / $header_data_report['cur_mth_inq'])*100)."%":"0 / 0 - 0%"; ?></h6>
                                            </div>
                                            <div class="stat-item">
                                                <h6>Today</h6>
                                                <h6><?php echo $header_data_report['tdy_mat_inq']; ?></h6>
                                            </div>
                                        </div>
                                        <div id="mature_graph"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body analytics-info">
                                        <h4 class="card-title text-danger">Unmature</h4>
                                        <div class="stats-row">
                                            <div class="stat-item">
                                                <h6><?php echo date("M-Y",strtotime($month)) ?></h6>
                                                <h6><?php echo($header_data_report['cur_mth_inq'] != 0)?$header_data_report['cur_mth_unmat_inq']." / ".$header_data_report['cur_mth_inq']." - ".round(($header_data_report['cur_mth_unmat_inq'] / $header_data_report['cur_mth_inq'])*100)."%":"0 / 0 - 0%"; ?></h6></div>
                                            <div class="stat-item">
                                                <h6>Today</h6>
                                                <h6><?php echo $header_data_report['tdy_unmat_inq']; ?></h6></div>
                                        </div>
                                        <div id="unmature_graph"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body analytics-info">
                                        <h4 class="card-title text-info">Open</h4>
                                        <div class="stats-row">
                                            <div class="stat-item">
                                                <h6><?php echo date("M-Y",strtotime($month)) ?></h6>
                                                <h6><?php echo($header_data_report['cur_mth_inq'] != 0)?$header_data_report['cur_mth_opn_inq']." / ".$header_data_report['cur_mth_inq']." - ".round(($header_data_report['cur_mth_opn_inq'] / $header_data_report['cur_mth_inq'])*100)."%":"0 / 0 - 0%"; ?></h6></div>
                                            <div class="stat-item">
                                                <h6>Today</h6>
                                                <h6><?php echo $header_data_report['tdy_opn_inq']; ?></h6></div>
                                        </div>
                                        <div id="open_graph"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body analytics-info">
                                        <h4 class="card-title text-warning">Closed</h4>
                                        <div class="stats-row">
                                            <div class="stat-item">
                                                <h6><?php echo date("M-Y",strtotime($month)) ?></h6>
                                                <h6><?php echo($header_data_report['cur_mth_inq'] != 0)?$header_data_report['cur_mth_cls_inq']:"0"; ?></h6></div>
                                            <div class="stat-item">
                                                <h6>Today</h6>
                                                <h6><?php echo $header_data_report['tdy_cls_inq']; ?></h6></div>
                                        </div>
                                        <div id="cls_graph"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Agent's Inquiry Chart <strong class="text-info"><?php echo(@$agent !='')?$agent:date("M-Y",strtotime($month)) ; ?></strong></h4>
                                        <div id="morris-bar-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
    </body>
</html>