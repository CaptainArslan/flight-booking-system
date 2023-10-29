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
                <div class="page-header bg-white m-0 pt-2 pb-2">
                    <div class="container-xl">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h2 class="page-title"><?php echo $head['page_title']?> - <?php echo(isset($_GET['attendance_month']))?$_GET['attendance_month']:date('M, Y');  ?></h2>
                            </div>
                            <div class="col-auto ms-auto">
                                <form>
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="form-group row">
                                                <label class="col-auto form-label font-weight-600 text-center">Month</label>
                                                <div class="col">
                                                    <input type="text" name="attendance_month" id="attendance_month" value="<?php echo ($this->input->get('attendance_month'))?$this->input->get('attendance_month'):date('M-Y'); ?>" class="monthpicker form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-sm btn-success" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col">
                            <?php 
                                if(checkAccess($session_role,'attendance_update')){ 
                            ?>
                            <div class="card mb-3">
                                <h5 class="card-header bg-danger text-white">Mark Attendance</h5>
                                <div class="card-body">
                                    <form action="<?php echo base_url('attendance/mark_attendance'); ?>" method="post">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">User</label>
                                                    <select class="form-control" name="user_id">
                                                        <?php foreach ($agents as $key => $agent) { ?>
                                                            <option <?php echo ($this->input->get('user_id') == $agent['user_id'])?"selected":""; ?> value="<?php echo $agent['user_id']; ?>"><?php echo $agent['user_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Date &amp; Time</label>
                                                    <input type="text" name="attendance_date" id="attendance_date" value="" class="form-control datetime" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-control" name="attendance_status" required="">
                                                        <option value="">-- Select Status --</option>
                                                        <option value="1">Present</option>
                                                        <option value="2">Leave</option>
                                                        <option value="3">Short Leave</option>
                                                        <option value="4">Absent</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group mt-4">
                                                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="table-responsive">
                                <table class="table table-bordered led-table-bg">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center text-white align-middle" style="word-break: normal;">User Name</th>
                                            <?php 
                                            for ($i= 1; $i <= $totalDays ; $i++) { ?>
                                                <th rowspan="2" class="text-center text-white align-middle" style="word-break: normal;">
                                                    <?php echo date("D", mktime(0,0,0,$selectedMonth,$i,$selectedYear)); ?>
                                                    <br>
                                                    <?php echo $i; ?>
                                                </th>
                                            <?php } ?>
                                            <th colspan="4" class="text-center text-white align-middle" style="word-break: normal;">Summary Period</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center text-white align-middle" style="word-break: normal;">P</th>
                                            <th class="text-center text-white align-middle" style="word-break: normal;">A</th>
                                            <th class="text-center text-white align-middle" style="word-break: normal;">L</th>
                                            <th class="text-center text-white align-middle" style="word-break: normal;">SL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach ($calendar as $user => $cal) {
                                                if($cal['user_name'] == 'IT Manager'){
                                                    continue;
                                                }
                                            $user_name = $cal['user_name'];
                                            $presents = $cal['presents'];
                                            $absents = $cal['absents'];
                                            $leaves = $cal['leaves'];
                                            $shortleaves = $cal['shortleaves'];
                                            unset($cal['presents']);
                                            unset($cal['absents']);
                                            unset($cal['leaves']);
                                            unset($cal['shortleaves']);
                                            unset($cal['user_name']);
                                            ?>
                                            <tr bgcolor="#fff">
                                                <td style="padding:5px 0px !important;word-break: normal;" class="text-center"><?php echo custom_echo($user_name,5); ?></td>
                                                <?php foreach ($cal as $key => $attend) { ?>
                                                    <td style="padding:5px 0px !important;word-break: normal;background-color: <?php echo $attend['color']; ?>" class="text-center small-font"><small><?php echo $attend['type']; ?></small></td>
                                                <?php } ?>
                                                <td style="padding:5px 0px !important;word-break: normal;" class="text-center"><small><?php echo @$presents; ?></small></td>
                                                <td style="padding:5px 0px !important;word-break: normal;" class="text-center"><small><?php echo @$absents; ?></small></td>
                                                <td style="padding:5px 0px !important;word-break: normal;" class="text-center"><small><?php echo @$leaves; ?></small></td>
                                                <td style="padding:5px 0px !important;word-break: normal;" class="text-center"><small><?php echo @$shortleaves; ?></small></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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