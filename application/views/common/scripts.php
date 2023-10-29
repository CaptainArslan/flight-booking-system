<script src="<?php echo base_url('assets/libs/jquery/dist/jquery.min.js') ?>"></script>

<!-- Tabler Core -->

<script src="<?php echo base_url('assets/js/tabler.min.js') ?>"></script>

<script src="<?php echo base_url('assets/js/typeahead.js') ?>"></script>

<script src="<?php echo base_url('assets/js/parsley.js'); ?>"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.3/tinymce.min.js" referrerpolicy="origin"></script>

<script src="<?php echo base_url('assets/libs/jqtoast/jquery.toast.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/libs/sweetalert/sweetalert2.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js'); ?>"></script>

<!-- Libs JS -->

<?php

if (isset($js) && count($js) > 0) {

    foreach ($js as $key => $src) {

?>

        <script src="<?php echo base_url($src) ?>"></script>

<?php

    }
}

?>

<script src="<?php echo base_url('assets/js/accounts.js'); ?>"></script>

<script>
    var loader = '<div class="card card-body"><div class="col-12"><div class="progress progress-sm"><div class="progress-bar progress-bar-indeterminate"></div></div></div></div>';

    $(document).on("submit", "#searchbooking", function(e) {

        e.preventDefault();

        var search_value = $(".searchfield").val();

        $.ajax({

            url: "<?php echo base_url('booking/searchreasults') ?>",

            data: {

                search_value: search_value,

            },

            type: "post",

            dataType: "json",

            success: function(output) {

                if (output.status) {

                    window.open(output.url);

                } else {

                    $.toast({

                        heading: 'Not Found',

                        text: 'Booking not found',

                        position: 'top-right',

                        loaderBg: '#ff6849',

                        icon: 'error',

                        hideAfter: 3500,

                        stack: 6

                    });

                }

            }

        });

    });

    $(document).on('focus', 'input[type=number]', function(e) {

        $(this).on('wheel.disableScroll', function(e) {

            e.preventDefault();

        });

    });

    $(document).on('blur', 'input[type=number]', function(e) {

        $(this).off('wheel.disableScroll');

    });

    $(".monthpicker").datetimepicker({

        format: "M-yyyy",

        startView: 3,

        minView: 3,

        autoclose: true,

    }).on('changeDate', function(e) {

        $(this).parsley().validate();

    });

    function datefu() {

        $(".date").datetimepicker({

            format: "dd-M-yyyy",

            autoclose: true,

            todayBtn: true,

            todayHighlight: true,

            showMeridian: true,

            startView: 2,

            minView: 2,

        }).on('changeDate', function(e) {

            $(this).parsley().validate();

        });

        $(".datetime").datetimepicker({

            format: "dd-M-yyyy HH:ii P",

            autoclose: true,

            todayBtn: true,

            todayHighlight: true,

            showMeridian: true,

            startView: 2,

            minView: 0,

        }).on('changeDate', function(e) {

            $(this).parsley().validate();

        });

        $(".startdate").datetimepicker({

            format: "dd-M-yyyy",

            autoclose: true,

            todayBtn: true,

            todayHighlight: true,

            showMeridian: true,

            startView: 2,

            minView: 2,

        }).on('changeDate', function(selected) {

            var minDate = new Date(selected.date.valueOf());

            $('.enddate').datetimepicker('setStartDate', minDate);

            $(this).parsley().validate();

        });

        $(".enddate").datetimepicker({

            format: "dd-M-yyyy",

            autoclose: true,

            todayBtn: true,

            todayHighlight: true,

            showMeridian: true,

            startView: 2,

            minView: 2,

        }).on('changeDate', function(selected) {

            $(this).parsley().validate();

        });

    }

    $(".startdate").datetimepicker({

        format: "dd-M-yyyy",

        autoclose: true,

        todayBtn: true,

        todayHighlight: true,

        showMeridian: true,

        startView: 2,

        minView: 2,

    }).on('changeDate', function(selected) {

        var minDate = new Date(selected.date.valueOf());

        $('.enddate').datetimepicker('setStartDate', minDate);

        $(this).parsley().validate();

    });

    $(".enddate").datetimepicker({

        format: "dd-M-yyyy",

        autoclose: true,

        todayBtn: true,

        todayHighlight: true,

        showMeridian: true,

        startView: 2,

        minView: 2,

    }).on('changeDate', function(selected) {

        $(this).parsley().validate();

    });

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

    function formv() {

        $('form').parsley({

            'trigger': 'focusout focusin',

        });

    }

    tinymce.init({

        selector: 'textarea.custom',

        forced_root_block: "",

        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',

        menubar: 'file edit view insert format tools table help',

        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',

        toolbar_sticky: true,

        paste_data_images: true,

    });

    function typeahead_initialize() {

        $('.airport').typeahead({

            hint: true,

            highlight: true,

            minLength: 2,

            limit: 5

        }, {

            source: function(q, cb) {

                return $.ajax({

                    dataType: 'json',

                    type: 'get',

                    url: '<?php echo base_url("booking/getAirport?query=") ?>' + q,

                    chache: false,

                    success: function(data) {

                        var result = [];

                        $.each(data, function(index, val) {

                            result.push({

                                value: val

                            });

                        });

                        cb(result);

                    }

                });

            }

        });

        $('.airline').typeahead({

            hint: true,

            highlight: true,

            minLength: 2,

            limit: 5

        }, {

            source: function(q, cb) {

                return $.ajax({

                    dataType: 'json',

                    type: 'get',

                    url: '<?php echo base_url("booking/getAirline?query=") ?>' + q,

                    chache: false,

                    success: function(data) {

                        var result = [];

                        $.each(data, function(index, val) {

                            result.push({

                                value: val

                            });

                        });

                        cb(result);

                    }

                });

            }

        });

    }

    typeahead_initialize();

    datefu();

    formv();

    $("input.tt-hint").removeAttr("required data-parsley-error-message data-parsley-trigger");

    $(document).on('shown.bs.modal', '.modal', function() {

        datefu();

        typeahead_initialize();

        formv();

        $("input.tt-hint").removeAttr("required data-parsley-error-message data-parsley-trigger");

    });

    document.body.style.display = "block";
</script>

<?php

if ($this->session->flashdata('notify')) {

    $notify = $this->session->flashdata('notify');

    $notify = json_decode($notify);

?>

    <div class="alert alert-important <?php echo ($notify->status == 'success') ? 'alert-success' : 'alert-danger'; ?> alert-dismissible toast cust-toast" role="alert">

        <div class="d-flex">

            <div class="mr-1">

                <!-- Download SVG icon from http://tabler-icons.io/i/check -->

                <?php echo ($notify->status == 'success') ? '	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>' : '<svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v2m0 4v.01"></path><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path></svg>'; ?>

            </div>

            <div><?php echo $notify->response; ?></div>

        </div>

        <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>

    </div>

    <script>
        $('.toast').show();

        setTimeout(function() {

            $('.toast').hide(500);

        }, 5000);
    </script>

<?php

}

?>

<div class="loadmodaldiv"></div>