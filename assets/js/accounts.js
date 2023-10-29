var base_url = window.location.origin;
$(document).on('click','.bkgNewTrans',function (){
    var thismain = $(this) ;
    thismain.attr("disabled","disabled");
    thismain.html('Processing...');
    var bkg_no = thismain.data('bkg-no');
    $('.loadmodaldiv').html('');
    $.ajax({
        type: "get",
        url:base_url+"/accounts/new_transaction_modal",
        data: {
            bkg_no : bkg_no ,
        },
        dataType: "json",
        success: function (response) {
            $('.loadmodaldiv').html(response);
            $('.NewTransModal').modal('show');
            thismain.removeAttr("disabled");
            thismain.html("Add Transaction");
            datefu();
            $("form").parsley({ 'trigger': 'focusout focusin'});
        }
    });
});
$(document).on("click",".bkgEditTrans", function() {
    var thismain = $(this) ;
    var btnhtml = thismain.html();
    thismain.attr("disabled","disabled");
    thismain.html('...');
    $('.loadmodaldiv').html('');
    var trans_id = $(this).data('trans-id');
    var page = '';
    if (typeof $(this).data('page') !== 'undefined') {
        page = $(this).data('page') ;
    }
    $.ajax({
        url: base_url+"/accounts/edit_transaction_modal",
        data:{
            transId: trans_id,
            page : page,
        },
        type:"post",
        dataType:"json",
        success:function(output){
            if(output != 'false'){
                $('.loadmodaldiv').html(output);
                $("form").parsley({ 'trigger': 'focusout focusin'});
                datefu();
                $('.EditTransModal').modal('show');
                thismain.removeAttr("disabled");
                thismain.html(btnhtml);
            }else{
                location.reload(true);
            }
        }
    });
});
function round(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}
$(document).on("click","#addTransDr", function(){
    $.ajax({
        url:base_url+"/booking/gettranshead",
        dataType:"json",
        success:function(output){
            var headOptions;
            $.each(output, function(index, val) {
                headOptions += '<option value="'+val+'" >'+val+'</option>';  
            });
            $(".ExtratransDr").append(
                '<div class="row mb-2 mt-2">'+
                    '<div class="col-md-3">'+
                        '<div class="form-group m-b-5">'+
                            '<div class="controls">'+
                                '<input type="number" name="dr[trans_bkg_ref][]" class="form-control" required>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-5">'+
                        '<div class="form-group m-b-5">'+
                            '<div class="controls">'+
                                '<select name="dr[trans_to][]" required class="form-control">'+
                                    '<option value="">Select Transaction Head</option>'+
                                    ''+headOptions+''+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                        '<div class="form-group m-b-5">'+
                            '<div class="controls">'+
                                '<input type="number" step=0.01 value="0.00" name="dr[amount][]" class="dramt form-control" required autocomplete="off">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-1">'+
                        '<div class="form-group m-b-5">'+
                            '<div class="controls">'+
                                '<button type="button" class="btn btn-sm btn-success deleteTransDr">x</button>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            );
            $("form").parsley({ 'trigger': 'focusout focusin'});
        }
    });
});
$(document).on("click",".deleteTransDr", function(){
    var val = $(this).parent().parent().parent().parent().find('.dramt').val();
    var ttldramt = parseFloat($('#dr_total_amount').val()) - parseFloat(val) ;
    $('.totaldramt').text(ttldramt.toFixed(2));
    $('#dr_total_amount').val(ttldramt.toFixed(2));
    $(this).parent().parent().parent().parent().remove();
});
$(document).on("click","#addTransCr", function(){
    $.ajax({
        url:base_url+"/booking/gettranshead",
        dataType:"json",
        success:function(output){
            var headOptions;
            $.each(output, function(index, val) {
                headOptions += '<option value="'+val+'" >'+val+'</option>';  
            });
            $(".ExtratransCr").append(
                '<div class="row mb-2 mt-2">'+
                    '<div class="col-md-3">'+
                        '<div class="form-group m-b-5">'+
                            '<div class="controls">'+
                                '<input type="number" name="cr[trans_bkg_ref][]" class="form-control" required>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-5">'+
                        '<div class="form-group m-b-5">'+
                            '<div class="controls">'+
                                '<select name="cr[trans_by][]" required class="form-control">'+
                                    '<option value="">Select Transaction Head</option>'+
                                    ''+headOptions+''+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                        '<div class="form-group m-b-5">'+
                            '<div class="controls">'+
                                '<input type="number" step=0.01 name="cr[amount][]" value="0.00" class="cramt form-control" required autocomplete="off"s>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-1">'+
                        '<div class="form-group m-b-5">'+
                            '<div class="controls">'+
                                '<button type="button" class="btn btn-sm btn-success deleteTransCr">x</button>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            );
            $("form").parsley({ 'trigger': 'focusout focusin'});
        }
    });     
});
$(document).on("click",".deleteTransCr", function(){
    var val = $(this).parent().parent().parent().parent().find('.cramt').val();
    var ttlcramt = parseFloat($('#cr_total_amount').val()) - parseFloat(val) ;
    $('.totalcramt').text(ttlcramt.toFixed(2));
    $('#cr_total_amount').val(ttlcramt.toFixed(2));
    $(this).parent().parent().parent().parent().remove();    
}); 
$(document).on('keyup',".dramt", function(){
    var drTotal = 0;
    $('.totaldramt').text(drTotal);
    $('.dramt').each(function(index, el){
        if (isNaN($(el).val()) || $(el).val()=== '') {
            drTotal = 0;
        }else{
            drTotal += parseFloat($(el).val());
            drTotal = round(drTotal , 2);
        }
    });
    $('.totaldramt').text(drTotal.toFixed(2));
    $('#dr_total_amount').val(drTotal);
});
$(document).on('keyup',".cramt", function(){
    var crTotal = 0;
    $('.totalcramt').text(crTotal);
    $('.cramt').each(function(index, el){
        if (isNaN($(el).val()) || $(el).val()=== '') {
            crTotal = 0;
        }else{
            crTotal += parseFloat($(el).val());
            crTotal = round(crTotal , 2);

        }
    });
    $('.totalcramt').text(crTotal.toFixed(2));
    $('#cr_total_amount').val(crTotal);
});
$(document).on('submit',"#addTransForm", function(e){
    e.preventDefault();
    var addtrnsBtn =  $("#addtrnsBtn") ;
    addtrnsBtn.attr("disabled","disabled");
    addtrnsBtn.html("Processing...");
    if ($('#cr_total_amount').val() != $('#dr_total_amount').val()) {
        $('.trans_alert_msg').text('Debit is not Equal to Credit');
        $('.trans_alert').show(500);
        setTimeout(function(){
            $('.trans_alert').hide(500);
        },5000);
    }else{
        var form = $('#addTransForm').serialize();
        $.ajax({
            url: base_url+"/accounts/addTrans",
            data:form,
            type:"post",
            dataType:"json",
            success: function(output){
                addtrnsBtn.removeAttr("disabled");
                addtrnsBtn.html("Submit");
                if(output.status === true){
                    $.toast({
                        heading: 'Success',
                        text: 'Transaction added successfully', 
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 3500,
                        stack: 6
                    });
                    setTimeout(function () {
                        if(output.bkgid === "0"){
                            location.reload(true);
                        }else{
                            window.location.href = base_url+"/booking/pending/"+output.bkgid;
                        }
                    }, 1000);                    
                }else{
                	if(output.toaster === 'permission'){
                		$.toast({
	                        heading: 'Access Denied',
	                        text: 'Permission to Add Transaction is Denied', 
	                        position: 'top-right',
	                        loaderBg: '#ff6849',
	                        icon: 'error',
	                        hideAfter: 3500,
	                        stack: 6
	                    });
                	}else{
	                    $.toast({
	                        heading: 'Error',
	                        text: 'Transaction not Addedd', 
	                        position: 'top-right',
	                        loaderBg: '#ff6849',
	                        icon: 'error',
	                        hideAfter: 3500,
	                        stack: 6
	                    });
	                }
                }
            }
        });
    }
    addtrnsBtn.removeAttr("disabled");
    addtrnsBtn.html("Submit");
});
$(document).on('submit',"#editTransForm", function(e){
    e.preventDefault();
    $("#EditSubmitBtn").attr("disabled","disabled");
    $("#EditSubmitBtn").html("Processing...");
    if ($('#cr_total_amount').val() != $('#dr_total_amount').val()) {
        $('.trans_alert_msg').text('Debit is not Equal to Credit');
        $('.trans_alert').show(500);
        setTimeout(function(){
            $('.trans_alert').hide(500);
        },5000);
    }else{
        var form = $('#editTransForm').serialize();
        var page = $('#page').val();
        $.ajax({
            url: base_url+"/accounts/editTrans",
            data:form,
            type:"post",
            success: function(output){
                if(output === 'true'){
                    $('.EditTransModal').modal('toggle');
                    $.toast({
                        heading: 'Success',
                        text: 'Transaction Updated successfully', 
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 3500,
                        stack: 6
                    });
                    if(page === 'ledger'){
                        ledgerFormsubmit();
                    }else if(page === 'cardcharge'){
                        cardChargesubmit();
                    }else if(page === 'bankbook'){
                        bankBookFormsubmit();
                    }else if(page === 'expenses'){
                        expendseFormsubmit();
                    }else{
                        location.reload(true);
                    }
                }else{
                    $.toast({
                        heading: 'Error',
                        text: 'Transaction not Updated', 
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
    $("#EditSubmitBtn").removeAttr("disabled");
    $("#EditSubmitBtn").html("Submit");
});
$(document).on("click",".deleteTrans",function() {
    var trans_id = $(this).data('trans-id');
    var page = $(this).data('page');
    Swal.fire({
      html:
            '<div class="text-center text-danger mt-3 mb-3"><h1 style="font-size:40px;">'+
            '<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v2m0 4v.01"></path><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path></svg></h1></div>'+
            '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>'+
            'That you want to <b class="text-danger">delete this Transaction</b>',
      confirmButtonColor: '#00c292',
      confirmButtonText: '<small>Yes, Delete It!</small>',
      cancelButtonText: '<small>Cancel</small>',
      showCancelButton: true,
      cancelButtonColor: '#d33',
      customClass: {
        confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
        cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
      }
    }).then((result) => {
      if (result.value) {
        $.ajax({
            url: base_url+"/accounts/deleteTrans",
            type: "POST",
            data: {
                trans_id: trans_id,
            },
            dataType: "json",
            success: function (output) {
                if(output) {
                    $('#editTrans').modal('toggle');
                    $.toast({
                        heading: 'Successful',
                        text: 'Transaction Deleted Succesfully', 
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 3500,
                        stack: 6
                    });
                    if(page === 'ledger'){
                        ledgerFormsubmit();
                    }else if(page === 'cardcharge'){
                        cardChargesubmit();
                    }else if(page === 'bankbook'){
                        bankBookFormsubmit();
                    }else if(page === 'expenses'){
                        expendseFormsubmit();
                    }else{
                        location.reload(true);
                    }
                }else{
                    Swal.fire("Error Deleting!", "Please try again", "error");  
                }
            },
            error: function (output) {
                Swal.fire("Error deleting!", "Please try again", "error");
            }
        });
      }
    }); 
});
$(document).on('submit','#ledgerForm',function(e){
    e.preventDefault();
    ledgerFormsubmit();    
});
function ledgerFormsubmit() {
    var head = $('#trans_head').val();
    var form = $('#ledgerForm').serialize();
    $(".ledgerFormbtn").attr("disabled","disabled");
    $(".ledgerFormbtn").html("Processing...");
    $('.ledgerdetails').html(loader);
    $.ajax({
        url: base_url+"/accounts/ledgerAjax",
        type: "POST",
        data: form,
        dataType: "json",
        success: function (output) {
            if(output) {
                $('.ledgerdetails').html(output);
                var $tr = $('#ledger_table tr.fixed'); //get the reference of row with the class no-sort
                var mySpecialRow = $tr.prop('outerHTML'); //get html code of tr
                $tr.remove(); //remove row of table
                $('#ledger_table').DataTable({
                    dom: 'Bfrtip',
                    ordering: true,
                    select: false,
                    paging: false,
                    columnDefs: [
                        {targets:0,type:"date"},
                        {targets:[4,8],"orderable": false}
                    ],
                    buttons: [
                        {
                            extend: 'excel',
                            footer: true,
                            autoFilter: true,
                            className: 'ledger-excel btn-sm',
                            sheetName: head+' - Ledger',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6,7]
                            }
                        }
                    ],
                    "fnDrawCallback": function(){
                        //add the row with 'prepend' method: in the first children of TBODY
                        $('#ledger_table tbody').prepend(mySpecialRow);

                    }
                });
                $(document).on('click','.sortBal',function(){
                    var ob = $.trim($('.openingBalance').text()).replace(/,/g , '');
                    var count = 1;
                    var namt = 0;
                    $(".balance").each(function(){
                        var drAmt = $.trim($(".dramt", $(this).closest("tr")).text()).replace(/,/g , '');
                        if(drAmt === ''){
                            drAmt = 0;
                        }
                        var crAmt = $.trim($(".cramt", $(this).closest("tr")).text()).replace(/,/g , '');
                        if(crAmt === ''){
                            crAmt = 0;
                        }
                        var curtr = $.trim($(this).text());
                        if(count === 1){
                            namt = (parseFloat(drAmt) - parseFloat(crAmt))+parseFloat(ob);
                        }else{
                            namt = (parseFloat(drAmt) - parseFloat(crAmt))+parseFloat(namt);
                        }
                        $(this).html(namt.toFixed(2));
                        count++;
                    });
                });
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            }
        }
    });
    setTimeout(function() {
        $(".ledgerFormbtn").removeAttr("disabled");
        $(".ledgerFormbtn").html("Submit");
    }, 2500);
}
$(document).on('submit','#cardCharge',function(e){
    e.preventDefault();    
    cardChargesubmit();
});
function cardChargesubmit() {
    var head = $('#trans_head').val();
    var form = $('#cardCharge').serialize();
    $(".cardChargebtn").attr("disabled","disabled");
    $(".cardChargebtn").html("Processing...");
    $('.cardchargedetails').html(loader);
    $.ajax({
        url: base_url+"/accounts/cardChargeAjax",
        type: "POST",
        data: form,
        dataType: "json",
        success: function (output) {
            if(output) {
                $('.cardchargedetails').html(output);
                var $tr = $('#cardcharge_table tr.fixed'); //get the reference of row with the class no-sort
                var mySpecialRow = $tr.prop('outerHTML'); //get html code of tr
                $tr.remove(); //remove row of table
                $('#cardcharge_table').DataTable({
                    dom: 'Bfrtip',
                    ordering: true,
                    select: false,
                    paging: false,
                    columnDefs: [
                        {targets:0,type:"date"},
                        {targets:[5,9],"orderable": false}
                    ],
                    buttons: [
                        {
                            extend: 'excel',
                            footer: true,
                            autoFilter: true,
                            className: 'ledger-excel btn-sm',
                            sheetName: head+' - Ledger',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6,7,8]
                            }
                        }
                    ],
                    "fnDrawCallback": function(){
                        //add the row with 'prepend' method: in the first children of TBODY
                        $('#cardcharge_table tbody').prepend(mySpecialRow);

                    }
                });
                $(document).on('click','.sortBal',function(){
                    var ob = $.trim($('.openingBalance').text()).replace(/,/g , '');
                    var count = 1;
                    var namt = 0;
                    $(".balance").each(function(){
                        var drAmt = $.trim($(".dramt", $(this).closest("tr")).text()).replace(/,/g , '');
                        if(drAmt === ''){
                            drAmt = 0;
                        }
                        var crAmt = $.trim($(".cramt", $(this).closest("tr")).text()).replace(/,/g , '');
                        if(crAmt === ''){
                            crAmt = 0;
                        }
                        var curtr = $.trim($(this).text());
                        if(count === 1){
                            namt = (parseFloat(drAmt) - parseFloat(crAmt))+parseFloat(ob);
                        }else{
                            namt = (parseFloat(drAmt) - parseFloat(crAmt))+parseFloat(namt);
                        }
                        $(this).html(namt.toFixed(2));
                        count++;
                    });
                });
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            }
        }
    });
    setTimeout(function() {
        $(".cardChargebtn").removeAttr("disabled");
        $(".cardChargebtn").html("Submit");
    }, 2500);
}
$(document).on('submit','#bankBookForm',function(e){
    e.preventDefault();    
    bankBookFormsubmit();
});
function bankBookFormsubmit() {
    var head = $('#trans_head').val();
    var form = $('#bankBookForm').serialize();
    $(".bankBookFormbtn").attr("disabled","disabled");
    $(".bankBookFormbtn").html("Processing...");
    $('.bankBookdetails').html(loader);
    $.ajax({
        url: base_url+"/accounts/bankBookAjax",
        type: "POST",
        data: form,
        dataType: "json",
        success: function (output) {
            if(output) {
                $('.bankBookdetails').html(output);
                var $tr = $('#bankbook_table tr.fixed'); //get the reference of row with the class no-sort
                var mySpecialRow = $tr.prop('outerHTML'); //get html code of tr
                $tr.remove(); //remove row of table
                $('#bankbook_table').DataTable({
                    dom: 'Bfrtip',
                    ordering: true,
                    select: false,
                    paging: false,
                    columnDefs: [
                        {targets:0,type:"date"},
                        {targets:[3,7],"orderable": false}
                    ],
                    buttons: [
                        {
                            extend: 'excel',
                            footer: true,
                            autoFilter: true,
                            className: 'ledger-excel btn-sm',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6]
                            }
                        }
                    ],
                    "fnDrawCallback": function(){
                        //add the row with 'prepend' method: in the first children of TBODY
                        $('#bankbook_table tbody').prepend(mySpecialRow);

                    }
                });
                $(document).on('click','.sortBal',function(){
                    var ob = $.trim($('.openingBalance').text()).replace(/,/g , '');
                    var count = 1;
                    var namt = 0;
                    $(".balance").each(function(){
                        var drAmt = $.trim($(".dramt", $(this).closest("tr")).text()).replace(/,/g , '');
                        if(drAmt === ''){
                            drAmt = 0;
                        }
                        var crAmt = $.trim($(".cramt", $(this).closest("tr")).text()).replace(/,/g , '');
                        if(crAmt === ''){
                            crAmt = 0;
                        }
                        var curtr = $.trim($(this).text());
                        if(count === 1){
                            namt = (parseFloat(drAmt) - parseFloat(crAmt))+parseFloat(ob);
                        }else{
                            namt = (parseFloat(drAmt) - parseFloat(crAmt))+parseFloat(namt);
                        }
                        $(this).html(namt.toFixed(2));
                        count++;
                    });
                });
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            }
        }
    });
    setTimeout(function() {
        $(".bankBookFormbtn").removeAttr("disabled");
        $(".bankBookFormbtn").html("Submit");
    }, 2500);
}
$(document).on('submit','#expendseForm',function(e){
    e.preventDefault();
    expendseFormsubmit();
});
function expendseFormsubmit() {
    var head = $('#trans_head').val();
    var form = $('#expendseForm').serialize();
    $(".expendseFormbtn").attr("disabled","disabled");
    $(".expendseFormbtn").html("Processing...");
    $('.expendsedetails').html(loader);
    $.ajax({
        url: base_url+"/accounts/expendseAjax",
        type: "POST",
        data: form,
        dataType: "json",
        success: function (output) {
            if(output) {
                $('.expendsedetails').html(output);
                var $tr = $('#expendse_table tr.fixed'); //get the reference of row with the class no-sort
                var mySpecialRow = $tr.prop('outerHTML'); //get html code of tr
                $tr.remove(); //remove row of table
                $('#expendse_table').DataTable({
                    dom: 'Bfrtip',
                    ordering: true,
                    select: false,
                    paging: false,
                    columnDefs: [
                        {targets:0,type:"date"},
                        {targets:[3,7],"orderable": false}
                    ],
                    buttons: [
                        {
                            extend: 'excel',
                            footer: true,
                            autoFilter: true,
                            className: 'ledger-excel btn-sm',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6]
                            }
                        }
                    ],
                    "fnDrawCallback": function(){
                        //add the row with 'prepend' method: in the first children of TBODY
                        $('#expendse_table tbody').prepend(mySpecialRow);

                    }
                });
                $(document).on('click','.sortBal',function(){
                    var ob = $.trim($('.openingBalance').text()).replace(/,/g , '');
                    var count = 1;
                    var namt = 0;
                    $(".balance").each(function(){
                        var drAmt = $.trim($(".dramt", $(this).closest("tr")).text()).replace(/,/g , '');
                        if(drAmt === ''){
                            drAmt = 0;
                        }
                        var crAmt = $.trim($(".cramt", $(this).closest("tr")).text()).replace(/,/g , '');
                        if(crAmt === ''){
                            crAmt = 0;
                        }
                        var curtr = $.trim($(this).text());
                        if(count === 1){
                            namt = (parseFloat(drAmt) - parseFloat(crAmt))+parseFloat(ob);
                        }else{
                            namt = (parseFloat(drAmt) - parseFloat(crAmt))+parseFloat(namt);
                        }
                        $(this).html(namt.toFixed(2));
                        count++;
                    });
                });
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            }
        }
    });
    setTimeout(function() {
        $(".expendseFormbtn").removeAttr("disabled");
        $(".expendseFormbtn").html("Submit");
    }, 2500);
}
$(document).on('submit','#trialBalForm',function(e){
    e.preventDefault();
    trialBalFormsubmit();
});
function trialBalFormsubmit() {
    var head = $('#trans_head').val();
    var form = $('#trialBalForm').serialize();
    $(".trialBalFormbtn").attr("disabled","disabled");
    $(".trialBalFormbtn").html("Processing...");
    $('.trialbalancedetails').html(loader);
    $.ajax({
        url: base_url+"/accounts/trialBalanceAjax",
        type: "POST",
        data: form,
        dataType: "json",
        success: function (output) {
            if(output) {
                $('.trialbalancedetails').html(output);
                $('#tb_table').DataTable({
                    dom: 'Bfrtip',
                    ordering: true,
                    select: false,
                    paging: false,
                    buttons: [
                        {
                            extend: 'excel',
                            footer: true,
                            autoFilter: true,
                            className: 'btn-sm',
                            exportOptions: {
                                columns: [0,1,2,3]
                            }
                        }
                    ],
                });
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            }
        }
    });
    setTimeout(function() {
        $(".trialBalFormbtn").removeAttr("disabled");
        $(".trialBalFormbtn").html("Submit");
    }, 2500);
}
if($('#tb_table').length){
    $('#tb_table').DataTable({
        dom: 'Bfrtip',
        ordering: true,
        select: false,
        paging: false,
        buttons: [
            {
                extend: 'excel',
                footer: true,
                autoFilter: true,
                className: 'btn-sm',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            }
        ],
    });
}
if($('#pl_table').length){
    $('#pl_table').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        searching: false,
        select: false,
        paging: false,
        bInfo : false,
        buttons: [
            {
                extend: 'excel',
                footer: true,
                autoFilter: true,
                className: 'btn-sm pl-btn',
                exportOptions: {
                    columns: [0,1,2]
                }
            }
        ],
    });
}
if($('#bl_table').length){
    $('#bl_table').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        searching: false,
        select: false,
        paging: false,
        bInfo : false,
        buttons: [
            {
                extend: 'excel',
                footer: true,
                autoFilter: true,
                className: 'btn-sm pl-btn',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            }
        ],
    });
}
$(document).on('click','.addHead', function(){
    $(this).attr("disabled","disabled");
    $.ajax({
        url: base_url+"/accounts/loadaddhead",
        dataType: "json",
        success: function (output) {
            $('.addHead').removeAttr("disabled");
            $('.addheadmodal').html(output);
            $('#addHead_form').parsley();
            $('#addHead').modal('show');
        }
    });
});
$(document).on('blur','.trans_head',function(){
    var head = $('.trans_head').val();
    $.ajax({
        url: base_url+"/accounts/checkTransHead",
        type: "post",
        data: {
            trans_head: head,
        },
        dataType: "json",
        success: function (output) {
            if(output=== true){
                var response = [];
                response.item = 'trans_head';
                response.message = 'Head Exist';
                $('[name=' + response.item + ']').val('');
                $('.trans_head_owner').val('').parsley().validate();
                $('.trans_head_tb').val('').parsley().validate();
                var FieldInstance = $('[name=' + response.item + ']').parsley(),
                    errorName = response.item + '-custom';
                /**
                 * You'll probably need to remove the error first, so the error
                 * doesn't show multiple times
                 */
                window.ParsleyUI.removeError(FieldInstance, errorName);

                // now display the error
                window.ParsleyUI.addError(FieldInstance, errorName, response.message);
            }else{
                $(this).parsley().validate();
            }
        }
    });
    $('#trans_head_owner').val(head).parsley().validate();
    $('#trans_head_tb').val(head).parsley().validate();
});
$(document).on("click",".addcharges_btn",function(){ 
    $(".blank").html('');
    $.ajax({
        type:"POST",
        url: base_url+"/accounts/appendcharges",
        dataType:"json",
        success: function (data) {
            $(".addheadchargesrows").append(data);    
        }
    });
});
$(document).on('change','.charges_brand',function(){
    var mainthis = $(this);
    var brand = mainthis.val();
    $.ajax({
        type: "POST",
        url: base_url+"/accounts/getbrandagent",
        data: {
            brand : brand,
        },
        dataType: "json",
        success: function (data) {
            var options = [];
            var counter = 1;
            $.each(data, function () {
                if(counter === 1){
                    options.push('<option value="all">All</option>');
                }
                options.push('<option value="' + this.user_name + '">' + this.user_name + '</option>');
                counter ++;
            });
            mainthis.closest('td').next('td').find(".charges_agent").html(options.join(""));
        }
    });
});
$(document).on("click",".deletecharges", function(){
    $(this).parent().parent().remove();
});
$(document).on('submit','#addHead_form',function(e){
    e.preventDefault();
    $(".addHead_btn").attr("disabled","disabled");
    $(".addHead_btn").html("Processing...");
    $(this).parsley();
    var form = $(this).serialize();
    $.ajax({
        url: base_url+"/accounts/addTransHead",
        type: "POST",
        dataType: "json",
        data: form,
        success: function (output) {
            if(output){
                $.toast({
                    heading: 'Head Added',
                    text: 'Transaction head has been added', 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 3500,
                    stack: 6
                });
                location.reload(true);
            }else{
                $.toast({
                    heading: 'Head Not Added',
                    text: 'Error while adding transaction head', 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3500,
                    stack: 6
                });
                $(".addHead_btn").removeAttr("disabled");
                $(".addHead_btn").html("Add Trans Head");
            }
        },
        error: function (output) {
            $(".addHead_btn").removeAttr("disabled");
            $(".addHead_btn").html("Add Trans Head");
        }
    });
});
$(document).on('submit','#editHead_form',function(e){
    e.preventDefault();
    $(".updateHead_btn").attr("disabled","disabled");
    $(".updateHead_btn").html("Processing...");
    $(this).parsley();
    var form = $(this).serialize();
    $.ajax({
        url: base_url+"/accounts/updatTransHead",
        type: "POST",
        dataType: "json",
        data: form,
        success: function (output) {
            if(output){
                $.toast({
                    heading: 'Head Updated',
                    text: 'Transaction head has been updated', 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 3500,
                    stack: 6
                });
                location.reload(true);
            }else{
                $.toast({
                    heading: 'Head Not Updated',
                    text: 'Error while updating transaction head', 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3500,
                    stack: 6
                });
                $(".updateHead_btn").removeAttr("disabled");
                $(".updateHead_btn").html("Update Trans Head");
            }
        },
        error: function (output) {
            $(".updateHead_btn").removeAttr("disabled");
            $(".updateHead_btn").html("Update Trans Head");
        }
    });
});
$(document).on('click','.edithead', function(){
	var mainthis = $(this);
    mainthis.attr("disabled","disabled");
	var trans_head = mainthis.data('transhead');
    $.ajax({
        url: base_url+"/accounts/loadedithead",
        type: "POST",
        data: {
        	trans_head: trans_head,
        },
        dataType: "json",
        success: function (output) {
            mainthis.removeAttr("disabled");
            $('.editheadmodal').html(output);
            $('#editHead_form').parsley();
            $('#editHead').modal('show');
        }
    });
});
$(document).on("click",".deletehead",function() {
    var transhead = $(this).data('transhead');
    Swal.fire({
        html:
            '<div class="text-center text-danger mt-3 mb-3"><h1 style="font-size:40px;"><svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v2m0 4v.01"></path><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path></svg></h1></div>'+
            '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>'+
            'That you want to <b class="text-danger">delete this Transaction Head</b>',
        confirmButtonColor: '#00c292',
        confirmButtonText: '<small>Yes, Delete It!</small>',
        cancelButtonText: '<small>Cancel</small>',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        customClass: {
            confirmButton: 'pt-1 pb-2 pl-2 pr-2 ',
            cancelButton: 'pt-1 pb-2 pl-2 pr-2 '
        }
    }).then((result) => {
      if (result.value) {
        $.ajax({
            url: base_url+"/accounts/deltranshead",
            type: "POST",
            data: {
                trans_head: transhead,
            },
            dataType: "json",
            success: function (output) {
                if(output) {
                    $.toast({
                        heading: 'Successful',
                        text: 'Transaction Head Deleted Succesfully', 
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 3500,
                        stack: 6
                    });
                    location.reload(true);
                }else{
                    Swal.fire("Error Deleting!", "Please try again", "error");  
                }
            },
            error: function (output) {
                Swal.fire("Error deleting!", "Please try again", "error");
            }
        });
      }
    }); 
});