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
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col">
                                <div class="card mb-4">
                                    <div class="card-header bg-dark">
                                        <h4 class="card-title text-white">Search Criteria</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="searchBookingForm" autocomplete="off">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">Search By</label>
                                                            <select name="searchby" class="searchby form-control" required data-parsley-trigger="focusin focusout">
                                                                <option value="">Select Search</option>
                                                                <option value="bkg_date">Booking Date</option>
                                                                <option value="flt_departuredate">Traveling Date</option>
                                                                <option value="clr_date">Ticket Issuance Date</option>
                                                                <option value="cnl_date">Cancellation Date </option>
                                                                <option value="bkg_no">Booking Ref No</option>
                                                                <option value="p_lastname">Passenger SurName</option>
                                                                <option value="p_firstname">Passenger First Name</option>
                                                                <option value="flt_pnr">PNR</option>
                                                                <option value="flt_ticketdetail">Ticket Details</option>
                                                                <option value="p_eticket_no">eTicket No</option>
                                                                <option value="flt_gds">GDS</option>
                                                                <option value="flt_airline">Airline</option>
                                                                <option value="bkg_supplier_reference">Supplier Reference</option>
                                                                <option value="cst_mobile">Phone/Mobile</option>
                                                                <option value="cst_email">Email</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="hidevalue" class="col-4">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">Value</label>
                                                            <input type="text" name="searchvalue" class="searchvalue form-control" placeholder="Enter any Value" data-parsley-trigger="focusin focusout">
                                                        </div>
                                                    </div>
                                                    <div id="startdate" class="col-2">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">Start Date</label>
                                                            <input type="text" name="startdate" id="startdate" class="startdate form-control" placeholder="Enter Start Date" data-parsley-trigger="focusin focusout">
                                                        </div>
                                                    </div>
                                                    <div id="enddate" class="col-2">
                                                        <div class="form-group m-b-0">
                                                            <label class="form-label">End Date</label>
                                                            <input type="text" name="enddate" id="enddate" class="enddate form-control" placeholder="Enter End Date" data-parsley-trigger="focusin focusout">
                                                        </div>
                                                    </div>
                                                    <div class="col-1">
                                                        <div class="form-actions text-right">
                                                            <button type="submit" class="searchsubmitbtn btn btn-success btn-sm mt-4">Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="searchresults"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
        <script>
            $(document).on("submit","#searchBookingForm",function(e){
                e.preventDefault();
                var searchby = $('.searchby').val();
                var searchvalue = $('.searchvalue').val();
                var startdate = $('.startdate').val();
                var enddate = $('.enddate').val();
                if(searchby === 'bkg_date' || searchby === 'flt_departuredate' || searchby === 'clr_date' || searchby === 'cnl_date'){
                    if(startdate ==='' || enddate ===''){
                        var text = '<ul>';
                        if(startdate ===''){
                            text += '<li>Enter Start Date</li>';
                        }
                        if(enddate ===''){
                            text += '<li>Enter End Date</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.'+text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    }else{
                        $(".searchsubmitbtn").attr("disabled","disabled");
                        $(".searchsubmitbtn").html('Searching...');
                        $('.searchresults').html(loader);
                        $.ajax({
                            url:base_url+"/booking/searchbookingsbydate",
                            data:{
                                searchby : searchby,
                                startdate : startdate,
                                enddate : enddate
                            },
                            type:"post",
                            dataType:"json",
                            success:function(output){
                                $('.searchresults').html(output);
                            }
                        });
                        setTimeout(function() {
                            $(".searchsubmitbtn").removeAttr("disabled");
                            $(".searchsubmitbtn").html('Search');
                        },5000);
                    }
                }else if(searchby === 'bkg_no' || searchby === 'p_lastname' || searchby === 'p_firstname' || searchby === 'flt_pnr' || searchby === 'p_eticket_no' || searchby === 'flt_gds' || searchby === 'flt_airline' || searchby === 'bkg_supplier_reference' || searchby === 'cst_mobile' || searchby === 'cst_email' || searchby === 'flt_ticketdetail'){
                    if(searchvalue ===''){
                        var text = '<ul>';
                        if(searchvalue ===''){
                            text += '<li>Enter Value</li>';
                        }
                        text += '</ul>';
                        $.toast({
                            heading: 'Selection Criteria',
                            text: 'Please select the following fields.'+text,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    }else{
                        $(".searchsubmitbtn").attr("disabled","disabled");
                        $(".searchsubmitbtn").html('Searching...');
                        $('.searchresults').html(loader);
                        $.ajax({
                            url:base_url+"/booking/searchbookingsbyvalue",
                            data:{
                                searchby : searchby,
                                searchvalue : searchvalue
                            },
                            type:"post",
                            dataType:"json",
                            success:function(output){
                                $('.searchresults').html(output);
                            }
                        });
                        setTimeout(function() {
                            $(".searchsubmitbtn").removeAttr("disabled");
                            $(".searchsubmitbtn").html('Search');
                        },5000);
                    }
                }
            });
        </script>
    </body>
</html>