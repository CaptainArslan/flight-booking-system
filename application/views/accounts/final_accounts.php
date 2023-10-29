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
                                <!-- <div class="page-pretitle"><?php echo($this->user_brand == 'All')?'All Brands':$this->user_brand; ?></div> -->
                                <h2 class="page-title"><?php echo $head['page_title']?></h2>
                            </div>
                            <div class="col-auto ms-auto">
                                <a href="<?php echo base_url('accounts/new_transaction') ; ?>" class="btn btn-sm btn-success">Add Transaction</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col">
                                <div class="card card-body">
                                    <form id="finalAccountForm" method="post" action="<?php echo base_url('accounts/final_accounts'); ?>" autocomplete="off">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group m-b-0 row">
                                                    <label for="example-text-input" class="p-0 col-5 col-form-label font-weight-600 text-center">Closing Date</label>
                                                    <div class="col-7">
                                                        <input name="end_date" class="date form-control form-control-sm" type="text" value="<?php echo $edate; ?>" placeholder="Enter End Date" required onchange="this.form.submit()">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-left">
                                                <button class="finalAccountFormbtn btn btn-sm btn-success" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card mt-3">
                                    <div class="card-body p-0-0">
                                        <h4 class="card-title p-0-15 m-b-0">Profit &amp; Loss Account</h4>
                                        <div class="table-striped table-responsive pl-table">
                                            <table id="pl_table" class="table  led-table-bg m-b-0" style="font-weight: 300 !important;letter-spacing: 1.1px !important">
                                                <thead>
                                                    <tr>
                                                        <th width="70%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white">Head</th>
                                                        <th width="15%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white">Sub Total</th>
                                                        <th width="15%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sale_purchase = $pnl['sale_purchase'];
                                                    $flight_sales = 0;
                                                    $hotel_sales = 0;
                                                    $cab_sales = 0;
                                                    $total_sales = 0;
                                                    foreach ($sale_purchase as $k => $v) {
                                                        if (substr($k, 1) == "Air Ticket Sales") {
                                                    ?>
                                                            <tr>
                                                                <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle">
                                                                    <?php echo substr($k, 1); ?>
                                                                </td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">
                                                                    <?php
                                                                    if (abs($v) >= 0) {
                                                                        echo number_format(abs($v), 2);
                                                                        $flight_sales = abs($v);
                                                                    } else {
                                                                        echo "(0)";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        } elseif (substr($k, 1) == "Hotel Sales") {
                                                        ?>
                                                            <tr>
                                                                <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle">
                                                                    <?php echo substr($k, 1); ?>
                                                                </td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">
                                                                    <?php
                                                                    if (abs($v) >= 0) {
                                                                        echo number_format(abs($v), 2);
                                                                        $hotel_sales = abs($v);
                                                                    } else {
                                                                        echo "(0)";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        } elseif (substr($k, 1) == "Cab Sales") {
                                                        ?>
                                                            <tr>
                                                                <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle">
                                                                    <?php echo substr($k, 1); ?>
                                                                </td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">
                                                                    <?php
                                                                    if (abs($v) >= 0) {
                                                                        echo number_format(abs($v), 2);
                                                                        $cab_sales = abs($v);
                                                                    } else {
                                                                        echo "(0)";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    }
                                                    $total_sales = $flight_sales + $hotel_sales + $cab_sales;
                                                    $flight_purchases = $hotel_purchases = $cab_purchases = $total_purchases = 0;
                                                    foreach ($sale_purchase as $k => $v) {
                                                        if (substr($k, 1) == "Air Ticket Purchases") {
                                                        ?>
                                                            <tr>
                                                                <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle">(-) <?php echo substr($k, 1); ?></td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">
                                                                    <?php
                                                                    if (abs($v) >= 0) {
                                                                        echo number_format(abs($v), 2);
                                                                        $flight_purchases = abs($v);
                                                                    } else {
                                                                        echo "(0)";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        } elseif (substr($k, 1) == "Hotel Purchases") {
                                                        ?>
                                                            <tr>
                                                                <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle">(-) <?php echo substr($k, 1); ?></td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">
                                                                    <?php
                                                                    if (abs($v) >= 0) {
                                                                        echo number_format(abs($v), 2);
                                                                        $hotel_purchases = abs($v);
                                                                    } else {
                                                                        echo "(0)";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        } elseif (substr($k, 1) == "Cab Purchases") {
                                                        ?>
                                                            <tr>
                                                                <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle">(-) <?php echo substr($k, 1); ?></td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">
                                                                    <?php
                                                                    if (abs($v) >= 0) {
                                                                        echo number_format(abs($v), 2);
                                                                        $cab_purchases = abs($v);
                                                                    } else {
                                                                        echo "(0)";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    $total_purchases = $flight_purchases + $hotel_purchases + $cab_purchases;
                                                    ?>
                                                    <tr>
                                                        <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle font-weight-500">Gross Profit</td>
                                                        <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                        <td class="p-t-5 p-b-5 text-center text-middle font-weight-500">
                                                            <?php
                                                            echo number_format((float)$total_sales - (float)$total_purchases, 2);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 10px !important;" class="p-t-10 p-b-10 p-l-10 text-left text-middle">
                                                            <h5 class="m-b-0 font-weight-600">Expenditures</h5>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <?php
                                                    $adminexp = $pnl['adminexp'];
                                                    $i = 1;
                                                    $total_salesadmin_exp = 0;
                                                    foreach ($adminexp as $k => $v) {
                                                        if (round($v, 2) != 0) {
                                                    ?>
                                                            <tr>
                                                                <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle"><?php echo substr($k, 1); ?></td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">
                                                                    <?php
                                                                    echo number_format($v, 2);
                                                                    if ($v >= 0) {
                                                                        $total_salesadmin_exp = (float)$total_salesadmin_exp + (float)abs($v);
                                                                    } else {
                                                                        $total_salesadmin_exp = (float)$total_salesadmin_exp - (float)abs($v);
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle font-weight-500">Total Expenditures</td>
                                                        <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                        <td class="p-t-5 p-b-5 text-center text-middle font-weight-500">
                                                            <?php echo "(" . number_format($total_salesadmin_exp, 2) . ")"; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-t-10 p-b-10 p-l-10 text-left text-middle">
                                                            <h5 class="m-b-0 font-weight-600">Misc Incomes</h5>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <?php
                                                    $miscincome = $pnl['miscincome'];
                                                    $i = 1;
                                                    $total_salesadmin_inc = 0;
                                                    foreach ($miscincome as $k => $v) {
                                                        if (round($v, 2) != 0) {
                                                    ?>
                                                            <tr>
                                                                <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle"><?php echo substr($k, 1); ?></td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                                <td class="p-t-5 p-b-5 text-center text-middle">
                                                                    <?php
                                                                    if (abs($v) >= 0) {
                                                                        echo number_format(abs($v), 2);
                                                                        $total_salesadmin_inc = (float)$total_salesadmin_inc + (float)abs($v);
                                                                    } else {
                                                                        echo "0";
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle font-weight-500">Total Misc Incomes</td>
                                                        <td class="p-t-5 p-b-5 text-center text-middle">&nbsp;</td>
                                                        <td class="p-t-5 p-b-5 text-center text-middle font-weight-500">
                                                            <?php echo number_format($total_salesadmin_inc, 2); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 10px !important;" class="p-t-5 p-b-5 p-l-10 text-left text-middle">
                                                            <h5 class="m-b-0 font-weight-600">Net Profit Or Loss</h5>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td class="p-t-5 p-b-5 text-center text-middle">
                                                            <h5 class="m-b-0 font-weight-600">
                                                                <?php echo number_format((float)$total_sales - (float)$total_purchases - (float)$total_salesadmin_exp + (float)$total_salesadmin_inc, 2); ?>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $prolos = (float)$total_sales - (float)$total_purchases - (float)$total_salesadmin_exp + (float)$total_salesadmin_inc;
                                ?>
                                <div class="card mt-3">
                                    <div class="card-body p-0-0">
                                        <h4 class="card-title p-0-15 m-b-0">
                                            Balance Sheet <span class="text-danger">As On : <?php echo $edate; ?></span>
                                        </h4>
                                        <div class="table-striped table-responsive bl_sheet">
                                            <table id="bl_table" class="table  led-table-bg m-b-0" style="font-weight: 300 !important;letter-spacing: 1.1px !important">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white">Sr#</th>
                                                        <th width="65%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white">Head</th>
                                                        <th width="15%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white">Assets (&pound;)</th>
                                                        <th width="15%" class="p-r-0 p-l-0 p-t-10 p-b-10 text-center text-white">Liabilities (&pound;)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $srn = 1;
                                                    $drtotal = 0;
                                                    $crtotal = 0;
                                                    $bs = $pnl['balsheet'];
                                                    ?>
                                                    <tr>
                                                        <td class="p-t-5 p-b-5 text-center text-middle">1</td>
                                                        <td class="p-t-5 p-b-5 p-l-10 text-left text-middle">
                                                            Share Capital <small>(Capital <?php echo abs(@$bs["1Share Capital"]); ?>, <?php if (isset($bs["2Drawings"])) { ?>Drawings <?php echo $bs["2Drawings"]; ?>,<?php } ?> <?php if (isset($bs["2Share Holder Dividend"])) { ?>Share Holder Dividend <?php echo $bs["2Share Holder Dividend"]; ?>,<?php } ?> <?php if (isset($bs["1Profit and Loss Account"])) { ?>Retained Profit or Loss <?php echo abs($bs["1Profit and Loss Account"]); ?>,<?php } ?> Current Profit or Loss <?php echo number_format($prolos, 2); ?>)</small>
                                                        </td>
                                                        <td class="p-t-5 p-b-5 text-center text-middle">-</td>
                                                        <td class="p-t-5 p-b-5 text-center text-middle">
                                                            <?php
                                                            echo number_format((float)abs(@$bs["1Share Capital"]) - (float)@$bs["2Drawings"] + abs(@$bs["1Profit and Loss Account"]) + $prolos - (float)@$bs["2Share Holder Dividend"], 2);
                                                            $crtotal = (float)$crtotal + (float)abs(@$bs["1Share Capital"]) - (float)@$bs["2Drawings"] + abs(@$bs["1Profit and Loss Account"]) + $prolos - (float)@$bs["2Share Holder Dividend"];
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $crtotal = $crtotal * -1;
                                                    $srn++;
                                                    ksort($bs);
                                                    $i = 1;
                                                    foreach ($bs as $k => $v) {
                                                        if (round($v, 2) != 0) {
                                                            if ($k <> "2Drawings" && $k <> "2Share Holder Dividend" && $k <> "1Share Capital" && $k <> "1Profit and Loss Account" && $k <> "1Accumulated Deperication AC") {
                                                    ?>
                                                                <tr>
                                                                    <td class="p-t-5 p-b-5 text-center text-middle"><?php echo $srn; ?></td>
                                                                    <td class="p-t-5 p-b-5 p-l-10 text-left text-middle">
                                                                        <?php
                                                                        echo substr($k, 1);
                                                                        if (substr($k, 1) == "Tangible Fixed Assets") {
                                                                            echo "<small> (Assets " . abs($v) . ", Acc. Depriciation " . abs($bs["1Accumulated Deperication AC"]) . ")</small>";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td class="p-t-5 p-b-5 text-center text-middle">
                                                                        <?php
                                                                        if ($v >= 0) {
                                                                            if (substr($k, 1) == "Tangible Fixed Assets") {
                                                                                echo number_format(abs($v) - abs($bs["1Accumulated Deperication AC"]), 2);
                                                                                $drtotal = (float)$drtotal + (float)$v - abs($bs["1Accumulated Deperication AC"]);
                                                                            } else {
                                                                                echo number_format(abs($v), 2);
                                                                                $drtotal = (float)$drtotal + (float)$v;
                                                                            }
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td class="p-t-5 p-b-5 text-center text-middle">
                                                                        <?php
                                                                        if ($v <= 0) {
                                                                            echo number_format(abs($v), 2);
                                                                            $crtotal = (float)$crtotal + (float)$v;
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                    <?php
                                                                $srn++;
                                                                $i++;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <?php
                                                        $balance = 0;
                                                        $balance = round(abs($drtotal), 2) - round(abs($crtotal), 2);
                                                        if ($balance != 0) {
                                                        ?>
                                                            <th>
                                                                <table cellpadding="0" cellspacing="0" width="100%">
                                                                    <tr style="border-bottom: 0 !important;background: #fff !important">
                                                                        <th style="padding: 0px; border: none !important;">
                                                                            Variance: <?php echo number_format(round($balance, 2), 2); ?>
                                                                        </th>
                                                                        <th style="padding: 0px; border: none !important;" class="text-right">Total</th>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        <?php } else { ?>
                                                            <th class="p-l-0 p-r-0 text-right">Total</th>
                                                        <?php } ?>
                                                        <th class="p-l-0 p-r-0 text-center">
                                                            <?php echo number_format($drtotal, 2); ?>
                                                        </th>
                                                        <th class="p-l-0 p-r-0 text-center">
                                                            <?php echo number_format(abs($crtotal), 2); ?>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
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