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
            <div class="page-body">
                <div class="container-xl">
                    <div class="row">
                        <div class="col">
                            <form id="addBookingForm" data-parsley-validate="">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="font-weight-600">Booking Details</h3>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Booking Date <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <input type="text" name="booking_date" class="booking_date date form-control" value="<?php echo date('d-M-Y'); ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $disabled_agents = $disabled_brands = '';
                                            if (!checkAccess($user_role, 'all_agents_add_booking')) {
                                                $disabled_agents = 'disabled';
                                            }
                                            if (!checkAccess($user_role, 'admin_view_add_booking')) {
                                                $disabled_brands = 'disabled';
                                            }
                                            ?>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Booking Agent <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <select name="booking_agent" class="form-control" required <?php echo $disabled_agents; ?>>
                                                            <option value="">Select Booking Agent</option>
                                                            <?php
                                                            foreach ($booking_agents as $key => $agent) {
                                                            ?>
                                                                <option value="<?php echo $agent['user_name']; ?>" <?php echo ($agent['user_name'] == $user_name) ? 'selected' : ''; ?>>
                                                                    <?php echo $agent['user_name']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Booking Brand <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <select name="booking_brand" class="form-control" required <?php echo $disabled_brands; ?>>
                                                            <option value="">Select Booking Brand</option>
                                                            <?php
                                                            foreach ($booking_brands as $key => $brand) {
                                                                if ($brand['brand_name'] == 'All') {
                                                                    continue;
                                                                }
                                                            ?>
                                                                <option value="<?php echo $brand['brand_name']; ?>" <?php echo ($brand['brand_name'] == $user_brand) ? 'selected' : ''; ?>>
                                                                    <?php echo $brand['brand_name']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Services <span class="text-danger">*</span></label>
                                                    <div class="form-check-inline">
                                                        <label>
                                                            <input class="servicecheck" type="checkbox" value="1" name="flightcheck" checked> Flight
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label>
                                                            <input class="servicecheck" type="checkbox" value="1" name="hotelcheck"> Hotel
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label>
                                                            <input class="servicecheck" type="checkbox" value="1" name="cabcheck"> Transportation
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label>
                                                            <input class="servicecheck" type="checkbox" value="1" name="visacheck"> Visa
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="font-weight-600">Customer Contacts</h3>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <input type="text" name="cust_full_name" id="cust_full_name" class="cust_full_name form-control" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <input type="email" name="cust_email" class="form-control" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Address</label>
                                                    <div class="controls">
                                                        <input type="text" name="cust_post_addess" class="form-control" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">City</label>
                                                    <div class="controls">
                                                        <input type="text" name="cust_post_city" class="form-control" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Postal Code</label>
                                                    <div class="controls">
                                                        <input type="text" name="cust_post_code" class="form-control" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Mobile No <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <input type="text" name="cust_mobile" class="form-control" required data-parsley-pattern="^[0-9]+$" data-parsley-maxlength="11" data-parsley-minlength="11" maxlength="11" minlength="11" data-parsley-error-message="11 Digit Mobile #" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Phone No</label>
                                                    <div class="controls">
                                                        <input type="text" name="cust_phone" class="form-control" data-parsley-pattern="^[0-9 ]+$" data-parsley-error-message="11 Digit Phone #">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Source <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <select name="booking_source" class="form-control">
                                                            <option value="">Select Booking Source</option>
                                                            <option value="Newsletter" selected="selected">Newsletter</option>
                                                            <option value="Google">Google</option>
                                                            <option value="Bing">Bing</option>
                                                            <option value="SMS">SMS</option>
                                                            <option value="Friend">Friend</option>
                                                            <option value="Repeat">Repeat</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="font-weight-600">Receipt Details</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Paying By <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <select name="payment_paid_by" class="form-control" required>
                                                            <option value="">Select Payment Party</option>
                                                            <option value="Self">Self</option>
                                                            <option value="Third Party">Third Party</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Receipt Mode <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <select name="payment_receipt_mode" id="payment_receipt_mode" class="payment_receipt_mode form-control" required>
                                                            <option value="">Select Payment Methods</option>
                                                            <option value="Cash">Cash</option>
                                                            <option value="Bank Transfer">Bank Transfer</option>
                                                            <option value="Credit Card">Credit Card</option>
                                                            <option value="Debit Card">Debit Card</option>
                                                            <option value="American Express">American Express</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Payment Due Date <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <input type="text" name="payment_due_date" class="datetime form-control" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="card_method" class="row card_method mb-3"></div>
                                        <ul class="nav nav-tabs" id="detailtab" data-bs-toggle="tabs">
                                            <li class="nav-item flight">
                                                <a class="nav-link active show" id="flight-tab" data-bs-toggle="tab" href="#flight"><Strong>Flight</Strong></a>
                                            </li>
                                            <li class="nav-item hotel" style="display:none;">
                                                <a class="nav-link" id="hotel-tab" data-bs-toggle="tab" href="#hotel"><strong>Hotel</strong></a>
                                            </li>
                                            <li class="nav-item cab" style="display:none;">
                                                <a class="nav-link" id="cab-tab" data-bs-toggle="tab" href="#cab"><strong>Transportation</strong></a>
                                            </li>
                                            <li class="nav-item visa" style="display:none;">
                                                <a class="nav-link" id="visa-tab" data-bs-toggle="tab" href="#visa"><strong>Visa</strong></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="detailsTabs">
                                            <div class="tab-pane fade active show" id="flight">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Flight Supplier <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="flight[booking_supplier]" class="form-control flt-input" required>
                                                                    <option value="">Select Booking Supplier</option>
                                                                    <?php
                                                                    foreach ($booking_suppliers as $key => $supplier) {
                                                                        if ($supplier['supplier_name'] == 'All') {
                                                                            continue;
                                                                        }
                                                                    ?>
                                                                        <option value="<?php echo $supplier['supplier_name']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Supplier's Agent</label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[supplier_agent]" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Supplier Reference</label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[supplier_reference]" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Departure Airport <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[departure_airport]" id="departure_airport" class="airport typeahead form-control flt-input" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Destination Airport <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[destination_airport]" id="destination_airport" class="airport typeahead form-control flt-input" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Via <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[via_airport]" id="via_airport" class="airport typeahead form-control flt-input" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Flight Type <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="flight[flight_type]" id="flight_type" class="flight_type form-control flt-input" required>
                                                                    <option value="">Select Type</option>
                                                                    <option value="Oneway">Oneway</option>
                                                                    <option value="Return" selected="selected">Return</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dept-date col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Departure Date <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[departure_date]" id="departure_date" class="datetime form-control flt-input startdate" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="return-date col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Return Date <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[return_date]" id="return_date" class="datetime form-control flt-input enddate" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Flight Class <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="flight[flight_class]" id="flight_class" class="form-control flt-input" required>
                                                                    <option value="">Select Flight Class</option>
                                                                    <option value="Economy" selected="selected">Economy</option>
                                                                    <option value="Economy Premium">Economy Premium</option>
                                                                    <option value="Business">Business</option>
                                                                    <option value="First Class">First Class</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Airline <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[airline]" id="airline" class="airline typeahead form-control flt-input" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="flight[flight_segments]" id="flight_segments" value="0">
                                                    <!-- <div class="col-md-1">
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Seg. # <span class="flt-req text-danger">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="flight[flight_segments]" id="flight_segments" class="form-control flt-input" required data-parsley-pattern="^[0-9]+$" data-parsley-maxlength="2"  data-parsley-error-message="Number Of Segment" data-parsley-errors-messages-disabled>
                                                                    <small class="help-block text-danger">Important</small>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">PNR <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[pnr]" id="pnr" class="pnr form-control flt-input" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">GDS <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="flight[flight_gds]" id="flight_gds" class="form-control flt-input">
                                                                    <option value="">Select Booking GDS</option>
                                                                    <option value="World-Span" selected="selected">World Span</option>
                                                                    <option value="Galileo">Galileo</option>
                                                                    <option value="Sabre">Sabre</option>
                                                                    <option value="Amadeus">Amadeus</option>
                                                                    <option value="Web">Web</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">PNR Expiry <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[pnr_expire_date]" id="pnr_expire_date" class="datetime form-control flt-input" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Fare Expiry <span class="flt-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="flight[fare_expire_date]" id="fare_expire_date" class="datetime form-control flt-input" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table id="paxtable" class="table full-color-table full-info-table m-b-10">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%" rowspan="2" class="text-center text-middle">Flight #</th>
                                                                            <th colspan="2" class="text-center text-middle">Departure</th>
                                                                            <th colspan="2" class="text-center text-middle">Arrival</th>
                                                                            <th width="13%" rowspan="2" class="text-center text-middle">Airline</th>
                                                                            <th width="3%" rowspan="2" class="text-center text-middle"><i class="fa fa-trash"></i></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th width="17%" class="text-center text-middle">Airport</th>
                                                                            <th width="20%" class="text-center text-middle">Date/Time</th>
                                                                            <th width="17%" class="text-center text-middle">Airport</th>
                                                                            <th width="20%" class="text-center text-middle">Date/Time</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="extendleg">
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="7" class="text-right p-0-3">
                                                                                <a id="addleg" class="text-white btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Segment</a>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">PNR Details</label>
                                                        <textarea class="tkt_details custom" id="tkt_details" name="flight[tkt_details]"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="hotel">
                                                <div class="hotel-entries-container" id="hotel-entries-container">
                                                    <div class="hotel-entry mt-2 border p-3">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Hotel <span class="htl-req text-danger">*</span></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="hotel[name][]" class="form-control htl-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Hotel Supplier <span class="htl-req text-danger">*</span></label>
                                                                    <div class="controls">
                                                                        <select name="hotel[supplier][]" class="form-control htl-input">
                                                                            <option value="">Select Hotel Supplier</option>
                                                                            <?php
                                                                            foreach ($booking_suppliers as $key => $supplier) {
                                                                                if ($supplier['supplier_name'] == 'All') {
                                                                                    continue;
                                                                                }
                                                                            ?>
                                                                                <option value="<?php echo $supplier['supplier_name']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Supplier's Agent <span class="htl-req text-danger">*</span></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="hotel[ref_name][]" class="form-control htl-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Hotel Ref# <span class="htl-req text-danger">*</span></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="hotel[sup_ref][]" class="form-control htl-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Hotel Location <span class="htl-req text-danger">*</span></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="hotel[location][]" class="form-control htl-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Checkin Date <span class="htl-req text-danger">*</span></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="hotel[checkin][]" class="startdatetime checkin form-control htl-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Checkout Date <span class="htl-req text-danger">*</span></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="hotel[checkout][]" class="enddatetime checkout form-control htl-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Rooms <span class="htl-req text-danger">*</span></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="hotel[rooms][]" class="form-control htl-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label class="form-label">Hotel Details</label>
                                                                <textarea class="tkt_details custom" id="hotel_details" name="hotel[details][]"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-info pull-right mt-3" id="addHotelEntry">Add Hotel Entry</button>
                                            </div>
                                            <div class="tab-pane fade" id="cab">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Cab <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[name]" class="form-control cab-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Cab Supplier <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="cab[supplier]" class="form-control cab-input">
                                                                    <option value="">Select Cab Supplier</option>
                                                                    <?php
                                                                    foreach ($booking_suppliers as $key => $supplier) {
                                                                        if ($supplier['supplier_name'] == 'All') {
                                                                            continue;
                                                                        }
                                                                    ?>
                                                                        <option value="<?php echo $supplier['supplier_name']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Supplier's Agent <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[ref_name]" class="form-control cab-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Cab Ref# <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[sup_ref]" class="form-control cab-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Vehicle Type <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[type]" class="form-control cab-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Cab Trip <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select name="cab[trip]" class="form-control cab-input">
                                                                    <option value="Round">Round</option>
                                                                    <option value="Oneway">Oneway</option>
                                                                    <option value="Cab Hire">Cab Hire</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">From <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[from_date]" class="startdatetime cabfrom form-control cab-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">To <span class="cab-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[to_date]" class="enddatetime cabto form-control cab-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">Cab Details</label>
                                                        <textarea class="tkt_details custom" id="cab_details" name="cab[details]"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="visa">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Visa Number<span class="visa-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="number" name="visa[number]" class="form-control visa-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Visa Type<span class="visa-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="visa[type]" class="form-control visa-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Visa Cost<span class="visa-req text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="number" name="visa[cost]" class="form-control visa-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h3 class="font-weight-600">Booking Note</h3>
                                                    <div class="controls">
                                                        <textarea name="booking_note" class="form-control" placeholder="Enter your message"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="font-weight-600">Ticket Cost: <strong class="tkt_cost text-success">0.00</strong></h3>
                                        <div class="row">
                                            <div class="col-md-6" style="border-right: thin solid #bfbfbf;">
                                                <label class="form-label">I) Payable to Supplier: <strong class="supp_payment text-success">0.00</strong></label>
                                                <div class="row maincost">
                                                    <div class="cost_class col-md-3">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">Basic<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="fare_basic" class="fare_basic defaultInt form-control" required value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Digits Only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cost_class col-md-3">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">Tax<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="fare_tax" class="fare_tax defaultInt form-control" required value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Digits Only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cost_class col-md-3">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">APC<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="fare_apc" class="fare_apc defaultInt form-control" required value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Digits Only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cost_class col-md-3">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">SAFI<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="fare_safi" class="fare_safi defaultInt form-control" required value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Digits Only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cost_class col-md-3" style="display:none;">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">Hotel<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="hotel[cost]" class="fare_hotel defaultInt form-control" required value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Digits Only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cost_class col-md-3" style="display:none;">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">Cab<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="cab[cost]" class="fare_cab defaultInt form-control" required value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Digits Only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">II) Additional Expenses: <strong class="add_exp text-success">0.00</strong></label>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">Bank Fee<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="charges_bank" readonly class="charges_bank defaultInt form-control" required value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Digits Only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">Card Fee<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="charges_card" readonly class="charges_card defaultInt form-control" required value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Digits Only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">APC Payable<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="apc_payable" readonly class="apc_payable defaultInt form-control" required value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Digits Only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">Misc.<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" name="charges_misc" readonly class="charges_misc defaultInt form-control" required value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-error-message="Digits Only">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="font-weight-600">Sale Price: <span class="total_sale text-success">0.00</span></h3>
                                        <label class="form-label">Passenger Details:</label>
                                        <div class="table-responsive">
                                            <table class="table full-color-table full-info-table m-b-0">
                                                <thead>
                                                    <tr>
                                                        <th width="08%" class="p-0-5 text-center text-middle">Title <span class="text-danger">*</span></th>
                                                        <th width="14%" class="p-0-5 text-center text-middle">First Name<span class="text-danger">*</span></th>
                                                        <th width="07%" class="p-0-5 text-center text-middle">Middle</th>
                                                        <th width="14%" class="p-0-5 text-center text-middle">Sur Name<span class="text-danger">*</span></th>
                                                        <th width="06%" class="p-0-5 text-center text-middle">DOB</th>
                                                        <th width="06%" class="p-0-5 text-center text-middle">type<span class="text-danger">*</span></th>
                                                        <th width="08%" class="p-0-5 text-center text-middle">Flight<span class="text-danger">*</span></th>
                                                        <th width="08%" class="p-0-5 text-center text-middle">Hotel<span class="text-danger">*</span></th>
                                                        <th width="08%" class="p-0-5 text-center text-middle">Cab<span class="text-danger">*</span></th>
                                                        <th width="08%" class="p-0-5 text-center text-middle">Fee<span class="text-danger">*</span></th>
                                                        <th width="08%" class="p-0-5 text-center text-middle">Total</th>
                                                        <th width="05%" class="p-0-5 text-center text-middle">-</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="extendPax">
                                                    <tr>
                                                        <td class="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <select name="pax[pax_title][]" class="form-control" required data-parsley-errors-messages-disabled>
                                                                        <option value="">Title</option>
                                                                        <option value="MR">MR</option>
                                                                        <option value="MISS">MISS</option>
                                                                        <option value="MRS">MRS</option>
                                                                        <option value="MS">MS</option>
                                                                        <option value="MSTR">MSTR</option>
                                                                        <option value="DR">DR</option>
                                                                        <option value="Prof.">Prof.</option>
                                                                    </select>
                                                                    <input type="hidden" name="pax[pax_eticket_no][]" value="" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <input type="text" name="pax[pax_first_name][]" class="main_pax form-control" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-errors-messages-disabled />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <input type="text" name="pax[pax_mid_name][]" class="form-control" data-parsley-pattern="^[a-zA-Z -]+$" data-parsley-errors-messages-disabled />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <input type="text" name="pax[pax_sur_name][]" class="form-control" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-errors-messages-disabled />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <input type="text" name="pax[pax_age][]" class="form-control" data-parsley-errors-messages-disabled />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td lass="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <select name="pax[pax_type][]" class="form-control" required data-parsley-errors-messages-disabled>
                                                                        <option value="Adult">Adult</option>
                                                                        <option value="Youth">Youth</option>
                                                                        <option value="Child">Child</option>
                                                                        <option value="Infant">Infant</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_sale][]" class="sale_price text-center form-control" required data-parsley-errors-messages-disabled value="0.00" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_hotel][]" class="hotel_price text-center form-control" required data-parsley-errors-messages-disabled value="0.00" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_cab][]" class="cab_price text-center form-control" required data-parsley-errors-messages-disabled value="0.00" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_fee][]" class="booking_fee text-center form-control" required value="0.00" data-parsley-errors-messages-disabled />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-0-3">
                                                            <div class="form-group m-b-0">
                                                                <div class="controls">
                                                                    <input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_sale_total][]" readonly class="pax_total text-center form-control" required data-parsley-errors-messages-disabled value="0.00" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-0-3 text-center text-middle">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="12" class="p-0-3 text-right">
                                                            <a id="addPax" class="btn btn-sm btn-outline-info pull-right">Add More</a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" id="submitButton" data-process="<i class='fa fa-gear faa-spin animated'></i> Processing" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('common/scripts', @$scripts); ?>
    <script>
        $(document).on('change', 'input[name="flight[departure_date]"]', function() {
            var depdate = $(this).val();
            $('.checkin').val(depdate);
            $('.cabfrom').val(depdate);
        });
        $(document).on('change', 'input[name="flight[return_date]"]', function() {
            var retdate = $(this).val();
            $('.checkout').val(retdate);
            $('.cabto').val(retdate);
        });
        $('.servicecheck').on('click', function() {
            var fcheck = $('input[name ="flightcheck"]').is(':checked');
            var hcheck = $('input[name ="hotelcheck"]').is(':checked');
            var ccheck = $('input[name ="cabcheck"]').is(':checked');
            var vcheck = $('input[name ="visacheck"]').is(':checked');
            var inputname = $(this).attr('name');
            if ($(this).is(':checked')) {
                if (inputname === 'flightcheck') {
                    $('.flt-input').attr('required', 'required');
                    $('.flight').css('display', 'block');
                    $('.flt-req').css('display', '');
                    $('.flight > a').addClass('active show');
                    $('#flight').addClass('active show');
                    $('.hotel > a').removeClass('active show');
                    $('#hotel').removeClass('active show');
                    $('.cab > a').removeClass('active show');
                    $('#cab').removeClass('active show');
                    $('.visa > a').removeClass('active show');
                    $('#visa').removeClass('active show');
                } else if (inputname === 'hotelcheck') {
                    $('.hlt-req').css('display', '');
                    $('.htl-input').attr('required', 'required');
                    $('.hotel').css('display', 'block');
                    $('.cost_class').removeClass('col-md-3');
                    $('.cost_class').addClass('col-md-2');
                    $('input[name ="hotel[cost]"]').parent().parent().parent().css('display', 'block');
                    $('.flight > a').removeClass('active show');
                    $('#flight').removeClass('active show');
                    $('.hotel > a').addClass('active show');
                    $('#hotel').addClass('active show');
                    $('.cab > a').removeClass('active show');
                    $('#cab').removeClass('active show');
                    $('.visa > a').removeClass('active show');
                    $('#visa').removeClass('active show');
                } else if (inputname === 'cabcheck') {
                    $('.cab-req').css('display', '');
                    $('.cab-input').attr('required', 'required');
                    $('.cab').css('display', 'block');
                    $('.cost_class').removeClass('col-md-3');
                    $('.cost_class').addClass('col-md-2');
                    $('input[name ="cab[cost]"]').parent().parent().parent().css('display', 'block');
                    $('.flight > a').removeClass('active show');
                    $('#flight').removeClass('active show');
                    $('.hotel > a').removeClass('active show');
                    $('#hotel').removeClass('active show');
                    $('.cab > a').addClass('active show');
                    $('#cab').addClass('active show');
                    $('.visa > a').removeClass('active show');
                    $('#visa').removeClass('active show');
                } else if (inputname === 'visacheck') {
                    $('.visa-req').css('display', '');
                    $('.visa-input').attr('required', 'required');
                    $('.visa').css('display', 'block');
                    $('.cost_class').removeClass('col-md-3');
                    $('.cost_class').addClass('col-md-2');
                    $('input[name ="visa[cost]"]').parent().parent().parent().css('display', 'block');
                    $('.flight > a').removeClass('active show');
                    $('#flight').removeClass('active show');
                    $('.hotel > a').removeClass('active show');
                    $('#hotel').removeClass('active show');
                    $('.cab > a').removeClass('active show');
                    $('#cab').removeClass('active show');
                    $('.visa > a').addClass('active show');
                    $('#visa').addClass('active show');
                }
            } else {
                if (inputname === 'flightcheck') {
                    $('.flt-req').css('display', 'none');
                    $('.flight').css('display', 'none');
                    $('#flight').removeClass('active show');
                    $('.flt-input').removeAttr('required');
                } else if (inputname === 'hotelcheck') {
                    $('.htl-req').css('display', 'none');
                    $('.hotel').css('display', 'none');
                    $('#hotel').removeClass('active show');
                    $('.htl-input').removeAttr('required');
                    $('input[name ="hotel[cost]"]').parent().parent().parent().css('display', 'none');
                } else if (inputname === 'cabcheck') {
                    $('.cab-req').css('display', 'none');
                    $('.cab').css('display', 'none');
                    $('#cab').removeClass('active show');
                    $('.cab-input').removeAttr('required');
                    $('input[name ="cab[cost]"]').parent().parent().parent().css('display', 'none');
                } else if (inputname === 'visacheck') {
                    $('.visa-req').css('display', 'none');
                    $('.visa').css('display', 'none');
                    $('#visa').removeClass('active show');
                    $('.visa-input').removeAttr('required');
                    $('input[name ="visa[cost]"]').parent().parent().parent().css('display', 'none');
                }
                if (!fcheck && !hcheck && !ccheck && !vcheck) {
                    alert('Please select atleast one option');
                    $('.flt-req').css('display', '');
                    $('.flt-input').attr('required', 'required');
                    $('input[name ="flightcheck"]').prop('checked', true);
                    $('.flight').css('display', 'block');
                    $('.flight > a').addClass('active show');
                    $('#flight').addClass('active show');
                    $('.hotel > a').removeClass('active show');
                    $('#hotel').removeClass('active show');
                    $('.cab > a').removeClass('active show');
                    $('#cab').removeClass('active show');
                }
            }
        });
        $('#addBookingForm').on('submit', function(e) {
            e.preventDefault();
            var form = $('#addBookingForm').serialize();
            var subText = $("#submitButton").data("process");
            $("#submitButton").attr("disabled", "disabled");
            $("#submitButton").html(subText);
            $.ajax({
                url: '<?php echo base_url("booking/add_booking"); ?>',
                data: form,
                type: "post",
                dataType: "json",
                success: function(output) {
                    console.log(output);
                    if (output.status === 'True') {
                        location.href = "<?php echo base_url("booking/pending/"); ?>" + output.bkg_id;
                    } else {
                        alert('Error Occured while adding booking');
                    }
                }
            }).done(function(response) {
                // Handle successful response
            }).fail(function(jqXHR, textStatus, errorThrown) {
                // Handle AJAX request failure
                alert('Error Occured while adding booking');
                console.log("AJAX Error: " + errorThrown);
            });;
            setTimeout(function() {
                $("#submitButton").removeAttr("disabled");
                $("#submitButton").html("Submit");
            }, 5000);
        });

        $("#addPax").on("click", function() {
            html = '<tr>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<select name="pax[pax_title][]"  class="form-control " required data-parsley-errors-messages-disabled>' +
                '<option value="">Title</option>' +
                '<option value="MR">MR</option>' +
                '<option value="MISS">MISS</option>' +
                '<option value="MRS">MRS</option>' +
                '<option value="MS">MS</option>' +
                '<option value="MSTR">MSTR</option>' +
                '<option value="DR">DR</option>' +
                '<option value="Prof.">Prof.</option>' +
                '</select>' +
                ' <input type="hidden" name="pax[pax_eticket_no][]" value="" />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" name="pax[pax_first_name][]" class="form-control " required data-parsley-errors-messages-disabled/>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" name="pax[pax_mid_name][]" class="form-control " data-parsley-errors-messages-disabled/>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" name="pax[pax_sur_name][]" class="form-control "  autocomplete="off" required data-parsley-errors-messages-disabled/>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" name="pax[pax_age][]" class="form-control " data-parsley-errors-messages-disabled/>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<select name="pax[pax_type][]"  class="form-control " required data-parsley-errors-messages-disabled >' +
                '<option value="Adult">Adult</option>' +
                '<option value="Youth">Youth</option>' +
                '<option value="Child">Child</option>' +
                '<option value="Infant">Infant</option>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_sale][]" class="sale_price text-center form-control " required  data-parsley-errors-messages-disabled value="0.00" />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_hotel][]" class="hotel_price text-center form-control " required  data-parsley-errors-messages-disabled value="0.00" />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_cab][]" class="cab_price text-center form-control " required  data-parsley-errors-messages-disabled value="0.00" />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" data-parsley-pattern="^[0-9.]+$" name="pax[pax_fee][]" class="booking_fee text-center form-control " required value="0.00" data-parsley-errors-messages-disabled  />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3">' +
                '<div class="form-group m-b-0">' +
                '<div class="controls">' +
                '<input type="text" name="pax[pax_sale_total][]" readonly class="pax_total text-center form-control " required value="0.00" data-parsley-errors-messages-disabled />' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="p-0-3 text-center text-middle">' +
                '<a class="deletepax">--</a>' +
                '</td>' +
                '</tr>';
            $("#extendPax").append(html);

        });
        $(document).on("click", ".deletepax", function() {
            $(this).parent().parent().remove();
        });
        // $('.airport').typeahead({
        //     hint: true,
        //     highlight: true,
        //     minLength: 2,
        //     limit: 5
        //     }, {
        //         source: function (q, cb) {
        //         return $.ajax({
        //             dataType: 'json',
        //             type: 'get',
        //             url: "<?php echo base_url('booking/getAirport?query='); ?>" + q,
        //             chache: false,
        //             success: function (data) {
        //                 var result = [];
        //                 $.each(data, function (index, val) {
        //                     result.push({
        //                         value: val
        //                     });
        //                 });
        //                 cb(result);
        //             }
        //         });
        //     }
        // });
        // $('.airline').typeahead({
        //     hint: true,
        //     highlight: true,
        //     minLength: 2,
        //     limit: 5
        //     }, {
        //     source: function (q, cb) {
        //         return $.ajax({
        //             dataType: 'json',
        //             type: 'get',
        //             url: "<?php echo base_url('booking/getAirline?query='); ?>" + q,
        //             chache: false,
        //             success: function (data) {
        //                 var result = [];
        //                 $.each(data, function (index, val) {
        //                     result.push({
        //                         value: val
        //                     });
        //                 });
        //                 cb(result);
        //             }
        //         });
        //     }
        // });
        // function typeahead_initialize() {
        //     $('.leg_airport').typeahead({
        //         hint: true,
        //         highlight: true,
        //         minLength: 2,
        //         limit: 5
        //     }, {
        //         source: function (q, cb) {
        //             return $.ajax({
        //                 dataType: 'json',
        //                 type: 'get',
        //                 url: "<?php echo base_url('booking/getAirport?query='); ?>" + q,
        //                 chache: false,
        //                 success: function (data) {
        //                     var result = [];
        //                     $.each(data, function (index, val) {
        //                         result.push({
        //                             value: val
        //                         });
        //                     });
        //                     cb(result);
        //                 }
        //             });
        //         }
        //     });
        //     $('.leg_airline').typeahead({
        //         hint: true,
        //         highlight: true,
        //         minLength: 2,
        //         limit: 5
        //     }, {
        //         source: function (q, cb) {
        //             return $.ajax({
        //                 dataType: 'json',
        //                 type: 'get',
        //                 url: "<?php echo base_url('booking/getAirline?query=') ?>" + q,
        //                 chache: false,
        //                 success: function (data) {
        //                     var result = [];
        //                     $.each(data, function (index, val) {
        //                         result.push({
        //                             value: val
        //                         });
        //                     });
        //                     cb(result);
        //                 }
        //             });
        //         }
        //     });
        // }
        $("input.tt-hint").removeAttr("required data-parsley-error-message data-parsley-trigger");
        $(document).on("blur", ".cab_price", function() {
            var salePrice = $.trim($(".sale_price", $(this).closest("tr")).val());
            var bookingFee = $.trim($(".booking_fee", $(this).closest("tr")).val());
            var hotelprice = $.trim($(".hotel_price", $(this).closest("tr")).val());
            var cabprice = $.trim($(this).val());
            if (bookingFee == "") {
                bookingFee = 0;
            }
            if (salePrice == "") {
                salePrice = 0;
            }
            if (hotelprice == "") {
                hotelprice = 0;
            }
            if (cabprice == "") {
                cabprice = 0;
            }
            $(".pax_total", $(this).closest("tr")).val(parseFloat(bookingFee) + parseFloat(salePrice) + parseFloat(hotelprice) + parseFloat(cabprice));
            var total = 0;
            $(".pax_total").each(function() {
                total += Number($(this).val());
            });
            $('.total_sale').html(Math.round(total * 100) / 100);
        });
        $(document).on("blur", ".hotel_price", function() {
            var salePrice = $.trim($(".sale_price", $(this).closest("tr")).val());
            var bookingFee = $.trim($(".booking_fee", $(this).closest("tr")).val());
            var cabprice = $.trim($(".cab_price", $(this).closest("tr")).val());
            var hotelprice = $.trim($(this).val());
            if (bookingFee == "") {
                bookingFee = 0;
            }
            if (salePrice == "") {
                salePrice = 0;
            }
            if (hotelprice == "") {
                hotelprice = 0;
            }
            if (cabprice == "") {
                cabprice = 0;
            }
            $(".pax_total", $(this).closest("tr")).val(parseFloat(bookingFee) + parseFloat(salePrice) + parseFloat(hotelprice) + parseFloat(cabprice));
            var total = 0;
            $(".pax_total").each(function() {
                total += Number($(this).val());
            });
            $('.total_sale').html(Math.round(total * 100) / 100);
        });
        $(document).on("blur", ".booking_fee", function() {
            var bookingFee = $.trim($(this).val());
            var salePrice = $.trim($(".sale_price", $(this).closest("tr")).val());
            var hotelprice = $.trim($(".hotel_price", $(this).closest("tr")).val());
            var cabprice = $.trim($(".cab_price", $(this).closest("tr")).val());
            if (bookingFee == "") {
                bookingFee = 0;
            }
            if (salePrice == "") {
                salePrice = 0;
            }
            if (hotelprice == "") {
                hotelprice = 0;
            }
            if (cabprice == "") {
                cabprice = 0;
            }
            $(".pax_total", $(this).closest("tr")).val(parseFloat(bookingFee) + parseFloat(salePrice) + parseFloat(hotelprice) + parseFloat(cabprice));
            var total = 0;
            $(".pax_total").each(function() {
                total += Number($(this).val());
            });
            $('.total_sale').html(Math.round(total * 100) / 100);
        });
        $(document).on("blur", ".sale_price", function() {
            var salePrice = $.trim($(this).val());
            var hotelprice = $.trim($(".hotel_price", $(this).closest("tr")).val());
            var cabprice = $.trim($(".cab_price", $(this).closest("tr")).val());
            var bookingFee = $.trim($(".booking_fee", $(this).closest("tr")).val());
            if (bookingFee == "") {
                bookingFee = 0;
            }
            if (salePrice == "") {
                salePrice = 0;
            }
            if (hotelprice == "") {
                hotelprice = 0;
            }
            if (cabprice == "") {
                cabprice = 0;
            }
            $(".pax_total", $(this).closest("tr")).val(parseFloat(bookingFee) + parseFloat(salePrice) + parseFloat(hotelprice) + parseFloat(cabprice));
            var total = 0;
            $(".pax_total").each(function() {
                total += Number($(this).val());
            });
            $('.total_sale').html(Math.round(total * 100) / 100);
        });
        $(document).on("blur", ".typeahead", function() {
            var details = $.trim($(this).val());
            $(".typeahead", $(this).closest("span")).attr("value", details);
        });
        $(document).on("change", ".defaultInt", function() {
            var amount = $.trim($(this).val());
            var input_name = $(this).attr("name");
            if (amount === '') {
                $(this).val('0.00');
            } else {
                var fare_basic = Number($('.fare_basic').val());
                var fare_tax = Number($('.fare_tax').val());
                var fare_apc = Number($('.fare_apc').val());
                var fare_safi = Number($('.fare_safi').val());
                var fare_hotel = Number($('.fare_hotel').val());
                var fare_cab = Number($('.fare_cab').val());

                var charges_bank = Number($('.charges_bank').val());
                var charges_card = Number($('.charges_card').val());
                var apc_payable = Number($('.apc_payable').val());
                var charges_misc = Number($('.charges_misc').val());

                var ttl_cost = 0;
                var sup_cost = 0;
                var add_cost = 0;

                sup_cost = fare_basic + fare_tax + fare_apc + fare_safi + fare_hotel + fare_cab;
                add_cost = charges_bank + charges_card + apc_payable + charges_misc;
                ttl_cost = sup_cost + add_cost;
                $('.tkt_cost').html(Math.round(ttl_cost * 100) / 100);
                $('.supp_payment').html(Math.round(sup_cost * 100) / 100);
                $('.add_exp').html(Math.round(add_cost * 100) / 100);
            }
        });
        $(document).on('change', '.payment_receipt_mode', function() {
            var payment_mode = $(this).val();
            var full_name = $('#cust_full_name').val();
            var modes = ["Credit Card", "Debit Card"];
            if (jQuery.inArray(payment_mode, modes) !== -1) {
                html = '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="form-label">Card Holder Name <span class="text-danger">*</span></label>' +
                    '<div class="controls">' +
                    '<input type="text" name="card_holder_name" class="val card_holder_name form-control " value="" autocomplete="off" required data-parsley-pattern="^[a-zA-Z ]+$" / >' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="form-label">Card No  <span class="text-danger">*</span></label>' +
                    '<div class="controls">' +
                    '<input type="text" name="card_number" class="card_number val form-control " autocomplete="off" required data-parsley-pattern="^[0-9 ]+$"  data-parsley-maxlength="19" maxlength="19" minlength="19" data-parsley-error-message="Enter Exact 16 Digits Card Number"/> ' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="form-label">Expiry Date <span class="text-danger">*</span></label>' +
                    '<div class="row">' +
                    '<div class="col-md-6">' +
                    '<div class="controls">' +
                    '<select name="card_exp_month" class="val form-control " autocomplete="off" required="" data-parsley-error-message="Select Month" >' +
                    '<option value="">Select Month</option>' +
                    '<option value="01">January</option>' +
                    '<option value="02">February</option>' +
                    '<option value="03">March</option>' +
                    '<option value="04">April</option>' +
                    '<option value="05">May</option>' +
                    '<option value="06">June</option>' +
                    '<option value="07">July</option>' +
                    '<option value="08">August</option>' +
                    '<option value="09">September</option>' +
                    '<option value="10">October</option>' +
                    '<option value="11">November</option>' +
                    '<option value="12">December</option>' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<div class="controls">' +
                    '<select name="card_exp_year" class="val form-control " autocomplete="off" required="" data-parsley-error-message="Select Year" >' +
                    '<option value="">Select Year</option>' +
                    '<option value="2021">2021</option>' +
                    '<option value="2022">2022</option>' +
                    '<option value="2023">2023</option>' +
                    '<option value="2024">2024</option>' +
                    '<option value="2025">2025</option>' +
                    '<option value="2026">2026</option>' +
                    '<option value="2027">2027</option>' +
                    '<option value="2028">2028</option>' +
                    '<option value="2029">2029</option>' +
                    '<option value="2030">2030</option>' +
                    '<option value="2031">2031</option>' +
                    '<option value="2032">2032</option>' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="form-label">Security Code  <span class="text-danger">*</span></label>' +
                    '<div class="controls">' +
                    '<input type="text" name="card_cvc" id="card_cvc" class="val form-control " autocomplete="off" required data-parsley-pattern="^[0-9]+$"  data-parsley-maxlength="3" data-parsley-minlength="3" maxlength="3" minlength="3" data-parsley-error-message="Enter CVC XXX"/>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $('.card_method').html(html);
                $('.card_holder_name').val(full_name);
                $('.val').parsley();
            } else if (payment_mode === "American Express") {
                html = '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="form-label">Card Holder Name <span class="text-danger">*</span></label>' +
                    '<div class="controls">' +
                    '<input type="text" name="card_holder_name" class="val card_holder_name form-control " value="" autocomplete="off" required data-parsley-pattern="^[a-zA-Z ]+$" / >' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="form-label">Card No  <span class="text-danger">*</span></label>' +
                    '<div class="controls">' +
                    '<input type="text" name="card_number" class="card_number val form-control " autocomplete="off" required data-parsley-pattern="^[0-9 ]+$"  data-parsley-maxlength="18" maxlength="18" minlength="18" data-parsley-error-message="Enter Exact 15 Digits Card Number"/> ' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="form-label">Expiry Date <span class="text-danger">*</span></label>' +
                    '<div class="row">' +
                    '<div class="col-md-6">' +
                    '<div class="controls">' +
                    '<select name="card_exp_month" class="val form-control " autocomplete="off" required="" data-parsley-error-message="Select Month" >' +
                    '<option value="">Select Month</option>' +
                    '<option value="01">January</option>' +
                    '<option value="02">February</option>' +
                    '<option value="03">March</option>' +
                    '<option value="04">April</option>' +
                    '<option value="05">May</option>' +
                    '<option value="06">June</option>' +
                    '<option value="07">July</option>' +
                    '<option value="08">August</option>' +
                    '<option value="09">September</option>' +
                    '<option value="10">October</option>' +
                    '<option value="11">November</option>' +
                    '<option value="12">December</option>' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<div class="controls">' +
                    '<select name="card_exp_year" class="val form-control " autocomplete="off" required="" data-parsley-error-message="Select Year" >' +
                    '<option value="">Select Year</option>' +
                    '<option value="2021">2021</option>' +
                    '<option value="2022">2022</option>' +
                    '<option value="2023">2023</option>' +
                    '<option value="2024">2024</option>' +
                    '<option value="2025">2025</option>' +
                    '<option value="2026">2026</option>' +
                    '<option value="2027">2027</option>' +
                    '<option value="2028">2028</option>' +
                    '<option value="2029">2029</option>' +
                    '<option value="2030">2030</option>' +
                    '<option value="2031">2031</option>' +
                    '<option value="2032">2032</option>' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="form-label">Security Code  <span class="text-danger">*</span></label>' +
                    '<div class="controls">' +
                    '<input type="text" name="card_cvc" id="card_cvc" class="val form-control " autocomplete="off" required data-parsley-pattern="^[0-9]+$"  data-parsley-maxlength="4" data-parsley-minlength="4" maxlength="4" minlength="4" data-parsley-error-message="Enter CVC XXXX"/>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $('.card_method').html(html);
                $('.card_holder_name').val(full_name);
                $('.val').parsley();
            } else {
                $(".card_method").html("");
            }
        });
        $(document).on('keyup', '.card_number', function() {
            var ele = $(this).val();
            ele = ele.split(' ').join(''); // Remove dash (-) if mistakenly entered.
            var finalVal = ele.match(/.{1,4}/g).join(' ');
            $(this).val(finalVal);
        });
        $(document).on('keyup', '.pnr', function() {
            var ele = $(this).val();
            ele = ele.split(' ').join(''); // Remove space if mistakenly entered.
            ele = ele.split(',').join(''); // Remove comma (,) if mistakenly entered.
            var finalVal = ele.match(/.{1,6}/g).join(', ');
            $(this).val(finalVal);
        });
        $(document).on('change', '.flight_type', function() {
            var f_type = $(this).val();
            var r_date = '';
            if (f_type === 'Oneway') {
                r_date = '<input type="hidden" name="return_date" value="">';
                $('.return-date').html(r_date).removeClass('col-md-2');
                $('.dept-date').removeClass('col-md-2').addClass('col-md-4');
            } else {
                r_date = '<div class="form-group">' +
                    '<label class="form-label">Return Date <span class="text-danger">*</span></label>' +
                    '<div class="controls">' +
                    '<input type="text" name="return_date" id="return_date" class="enddatetime form-control " required>' +
                    '</div>' +
                    '</div>';
                $('.return-date').html(r_date).addClass('col-md-2');
                $('.dept-date').removeClass('col-md-4').addClass('col-md-2');
                $(".enddatetime").datetimepicker({
                    format: "dd-M-yyyy HH:ii P",
                    autoclose: true,
                    todayBtn: true,
                    todayHighlight: true,
                    showMeridian: true,
                    startView: 2,
                    minView: 0,
                }).on('changeDate', function(selected) {
                    $(this).parsley().validate();
                });
            }
        });
        $(document).on('keyup', '.cust_full_name', function() {
            var main_name = $(this).val();
            $('.main_pax').val(main_name);
        });
    </script>
    <script>
        $(document).ready(function() {
            let hotelEntryCounter = 1;

            $("#addHotelEntry").on("click", function() {
                var newHotelEntry = $('#hotel-entries-container .hotel-entry:first').clone();
                hotelEntryCounter++;

                newHotelEntry.append('<button type="button" class="deleteHotelEntry btn btn-sm btn-outline-danger pull-right">Delete</button>');
                $('#hotel-entries-container').append(newHotelEntry);

                // newHotelEntry.find('input, select, textarea').each(function() {
                //     const currentID = $(this).attr('id');
                //     if (currentID) {
                //         const newID = currentID.replace(/\d+$/, '') + hotelEntryCounter;
                //         $(this).attr('id', newID);
                //         $(this).val('');
                //     }
                // });
                newHotelEntry.find('textarea').each(function() {
                    $(this).addClass('tkt_details' + hotelEntryCounter).removeClass('tkt_details');
                    $(this).attr('id', 'tkt_details' + hotelEntryCounter);
                    tinymce.init({
                        selector: `textarea#tkt_details${hotelEntryCounter}`,
                        theme: "modern",
                        menubar: false,
                        toolbar: false,
                        height: 100,
                    });
                });

                // $(".date").datepicker({
                //     todayBtn: true,
                //     todayHighlight: true,
                //     autoclose: true,
                //     format: "dd-M-yyyy",
                // }).on('changeDate', function(e) {
                //     $(this).parsley().validate();
                // });
                // $('#addBookingForm').parsley();
                $(".startdatetime").datetimepicker({
                    format: "dd-M-yyyy HH:ii P",
                    autoclose: true,
                    todayBtn: true,
                    todayHighlight: true,
                    showMeridian: true,
                    startView: 2,
                    minView: 0,
                }).on('changeDate', function(selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('.enddatetime').datetimepicker('setStartDate', minDate);
                    $(this).parsley().validate();
                });

                $(".enddatetime").datetimepicker({
                    format: "dd-M-yyyy HH:ii P",
                    autoclose: true,
                    todayBtn: true,
                    todayHighlight: true,
                    showMeridian: true,
                    startView: 2,
                    minView: 0,
                }).on('changeDate', function(selected) {
                    $(this).parsley().validate();
                });


            });


            // Delete a hotel entry
            $('#hotel-entries-container').on('click', '.deleteHotelEntry', function() {
                $(this).closest('.hotel-entry').remove();
            });
        });
    </script>

</body>

</html>