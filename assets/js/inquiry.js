var base_url = window.location.origin;
$(document).ready(function () {
    $(".tt-hint").removeAttr("required");    
});
$(document).on('change','.flight_type',function() {
    var f_type = $(this).val();
    var r_date = '';
    if(f_type === 'Oneway'){
        r_date = '<input type="hidden" name="enq_rtrn_date" value="">';
        $('.return-date').html(r_date).removeClass('col-md-6');
        $('.dept-date').removeClass('col-md-6').addClass('col-md-12');
    }else{
        r_date = '<div class="form-group mb-2">'+
                    '<label class="form-label">Retrn Date<span class="text-danger">*</span></label>'+
                    '<div class="controls">'+
                        '<input type="text" name="enq_rtrn_date" class="startdate form-control" value=""  required>'+
                    '</div>'+                                               
                '</div>';
        $('.return-date').html(r_date).addClass('col-md-6');
        $('.dept-date').removeClass('col-md-12').addClass('col-md-6');
        $(".startdate").datetimepicker({
            format: "dd-M-yyyy",
            autoclose: true,
            todayBtn : true ,
            todayHighlight: true ,
            showMeridian: true, 
            startView:2,
            minView:2,
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('.enddate').datetimepicker('setStartDate', minDate);
            $(this).parsley().validate();
        });
        $(".enddate").datetimepicker({
            format: "dd-M-yyyy",
            autoclose: true,
            todayBtn : true ,
            todayHighlight: true ,
            showMeridian: true, 
            startView:2,
            minView:2,
        }).on('changeDate', function (selected) {
            $(this).parsley().validate();
        });
    }
});
$(document).on('submit',"#addInq",function(e){
    $("input.tt-hint").removeAttr("required");
    e.preventDefault();
    $(".addIndsubbtn").attr("disabled","disabled");
    var form = $('#addInq').serialize();
    $.ajax({
        url:base_url+"/inquiry/addInquiy",
        data:form,
        type:"post",
        dataType:"json",
        success:function(output){
            if(output){
                location.reload(true);
            }else{
                $(".addIndsubbtn").removeAttr("disabled");
                $.toast({
                    heading: 'Error',
                    text: 'There is some error while adding Inquiry', 
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
$('#newInquiries_admin').DataTable( {
    ordering: true,
    order: [],
    select: true,
    paging: false,
    columnDefs: [
		{targets:[1,3],type:"date"},
		{targets:[7],"orderable": false}
	],
    dom: 'Bfrtip',
    buttons: [
        {
            text: 'Close',
            className: 'btn btn-sm btn-primary mr-10',
            action: function ( e, dt, node, config ) {
                var rows = [];
                var count = 0;
                $('tr.selected').each(function(){
                   var row_id = $(this).data("row-id");
                   rows.push(row_id);
                   count ++ ;
                });
                if(count > 0){
					Swal.fire({
                        html:
                                '<div class="text-center text-warning mt-3 mb-3">'+
                                '<h1 style="font-size:40px;"><i class="icon glyphicon m-0 glyphicon-remove-circle icon-lg text-danger" style="font-size: 62px;"></i></h1></div>'+
                                '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>'+
                                'That you want to <b class="text-danger">close selected enquiries.</b>',
                        confirmButtonColor: '#00c292',
                        confirmButtonText: '<small>Yes, Close It!</small>',
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
								url:base_url+"/inquiry/inqAction",
								data:{
									inq_ids : rows,
									action : 'Closed',
									page : 'bulk',
								},
								type:"post",
								dataType:"json",
								success:function(output){
									if(output.status){
										location.reload(true);
									}else{
										$.toast({
											heading: 'Error',
											text: 'These was some error while closing inquiries..!!!', 
											position: 'bottom-right',
											loaderBg: '#ff6849',
											icon: 'error',
											hideAfter: 3500,
											stack: 6
										});
									}
								}
							});
						}
					}); 
                }else{
                    $.toast({
						heading: 'Error',
						text: 'Please select a row to close it.', 
						position: 'top-right',
						loaderBg: '#ff6849',
						icon: 'error',
						hideAfter: 3500,
						stack: 6
					});
                }
            }
        }
    ]
});
$('#newInquiries_user').DataTable({
    ordering: true,
    order: [],
    select: true,
    paging: false,
    columnDefs: [
        {targets:[1,3],type:"date"},
        // {targets:[6],"orderable": false}
    ]
});
$('.admin_newinq').DataTable({
    paging: true,
    pageLength: 100,
    order: [[ 0, "desc" ]],
    columnDefs: [
        {targets: [0],className: 'text-center text-middle'},
        {targets: [1],className: 'text-center text-middle'},
        {targets: [2],className: 'text-center text-middle'},
        {targets: [3],className: 'text-center text-middle'},
        {targets: [4],className: 'text-center text-middle'},
        {targets: [5],className: 'text-middle'},
        {targets: [6],className: 'text-center text-middle'},
        {targets: [7],className: 'text-center text-middle'},
        {targets: [8],orderable: false,className: 'text-center text-middle'},
    ],
    processing: true,
    serverSide: true,
    ajax: {
        url: base_url+'/inquiry/getinquiries',
        dataType: 'json',
        type: 'POST',
        data: {
            'user':'admin',
            'type':'new',
        }
    },
    columns: [
        { data: 'sr' },
        { data: 'inq_date' },
        { data: 'brand'},
        { data: 'inq_id'},
        { data: 'dept_date'},
        { data: 'details'},
        { data: 'feedback'},
        { data: 'pick_by'},
        { data: 'action'},
    ]
});
$('.user_newinq').DataTable({
    paging: true,
    pageLength: 100,
    order: [[ 3, "asc" ]],
    columnDefs: [
        {targets: [0],className: 'text-center text-middle'},
        {targets: [1],className: 'text-center text-middle'},
        {targets: [2],className: 'text-center text-middle'},
        {targets: [3],className: 'text-center text-middle'},
        {targets: [4],className: 'text-middle'},
        {targets: [5],className: 'text-center text-middle'},
        {targets: [6],orderable: false,className: 'text-center text-middle'},
    ],
    processing: true,
    serverSide: true,
    ajax: {
        url: base_url+'/inquiry/getinquiries',
        dataType: 'json',
        type: 'POST',
        data: {
            'user':'user',
            'type':'new',
        }
    },
    columns: [
        { data: 'sr' },
        { data: 'inq_date' },
        { data: 'inq_id'},
        { data: 'dept_date'},
        { data: 'details'},
        { data: 'pick_by'},
        { data: 'action'},
    ]
});
$('.admin_tdpinq').DataTable({
    paging: true,
    pageLength: 100,
    order: [[ 4, "asc" ]],
    select: true,
    columnDefs: [
        {targets: [0],className: 'text-center text-middle'},
        {targets: [1],className: 'text-center text-middle'},
        {targets: [2],className: 'text-center text-middle'},
        {targets: [3],className: 'text-center text-middle'},
        {targets: [4],className: 'text-center text-middle'},
        {targets: [5],className: 'text-middle'},
        {targets: [6],className: 'text-center text-middle'},
        {targets: [7],className: 'text-center text-middle'},
        {targets: [8],orderable: false,className: 'text-center text-middle'},
    ],
    processing: true,
    serverSide: true,
    ajax: {
        url: base_url+'/inquiry/getinquiries',
        dataType: 'json',
        type: 'POST',
        data: {
            'user':'admin',
            'type':'tdp',
        }
    },
    columns: [
        { data: 'sr' },
        { data: 'inq_date' },
        { data: 'brand'},
        { data: 'inq_id'},
        { data: 'dept_date'},
        { data: 'details'},
        { data: 'feedback'},
        { data: 'pick_by'},
        { data: 'action'},
    ],
    dom: 'Bfrtip',
    buttons: [
        {
            text: 'Close',
            className: 'btn btn-sm btn-primary mr-10',
            action: function ( e, dt, node, config ) {
                var rows = [];
                var count = 0;
                $('tr.selected').each(function(){
                   var row_id = $(this).data("row-id");
                   rows.push(row_id);
                   count ++ ;
                });
                if(count > 0){
					Swal.fire({
						html:
                            '<div class="text-center text-warning mt-3 mb-3">'+
                            '<h1 style="font-size:40px;"><i class="icon glyphicon m-0 glyphicon-remove-circle icon-lg text-danger" style="font-size: 62px;"></i></h1></div>'+
                            '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>'+
                            'That you want to <b class="text-danger">close selected enquiries.</b>',
                        confirmButtonColor: '#00c292',
                        confirmButtonText: '<small>Yes, Close It!</small>',
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
								url:base_url+"/inquiry/inqAction",
								data:{
									inq_ids : rows,
									action : 'Closed',
									page : 'bulk',
								},
								type:"post",
								dataType:"json",
								success:function(output){
									if(output.status){
										location.reload(true);
									}else{
										$.toast({
											heading: 'Error',
											text: 'These was some error while closing inquiries..!!!', 
											position: 'bottom-right',
											loaderBg: '#ff6849',
											icon: 'error',
											hideAfter: 3500,
											stack: 6
										});
									}
								}
							});
						}
					}); 
                }else{
                    $.toast({
						heading: 'Error',
						text: 'Please select a row to close it.', 
						position: 'top-right',
						loaderBg: '#ff6849',
						icon: 'error',
						hideAfter: 3500,
						stack: 6
					});
                }
            }
        }
    ],
    createdRow: function (row, data, dataIndex) {
        var str = data.inq_id ;
        var results = [];
        $("<div></div>").html(str).find("a").each(function(l) {
            results.push($(this).text());
        });
        var res = results.toString().replace(/\s/g, '');
        $(row).attr('data-row-id', res);
    }
});
$('.user_tdpinq').DataTable({
    paging: true,
    pageLength: 100,
    order: [[ 3, "asc" ]],
    columnDefs: [
        {targets: [0],className: 'text-center text-middle'},
        {targets: [1],className: 'text-center text-middle'},
        {targets: [2],className: 'text-center text-middle'},
        {targets: [3],className: 'text-center text-middle'},
        {targets: [4],className: 'text-middle'},
        {targets: [5],className: 'text-center text-middle'},
        {targets: [6],orderable: false,className: 'text-center text-middle'},
    ],
    processing: true,
    serverSide: true,
    ajax: {
        url: base_url+'/inquiry/getinquiries',
        dataType: 'json',
        type: 'POST',
        data: {
            'user':'user',
            'type':'tdp',
        }
    },
    columns: [
        { data: 'sr' },
        { data: 'inq_date' },
        { data: 'inq_id'},
        { data: 'dept_date'},
        { data: 'details'},
        { data: 'pick_by'},
        { data: 'action'},
    ]
});
$('.admin_reminq').DataTable({
    paging: true,
    pageLength: 100,
    order: [[ 0, "desc" ]],
    select: true,
    columnDefs: [
        {targets: [0],className: 'text-center text-middle'},
        {targets: [1],className: 'text-center text-middle',type:'date'},
        {targets: [2],className: 'text-center text-middle'},
        {targets: [3],className: 'text-center text-middle'},
        {targets: [4],className: 'text-center text-middle',type:'date'},
        {targets: [5],className: 'text-middle'},
        {targets: [6],className: 'text-center text-middle'},
        {targets: [7],className: 'text-center text-middle'},
        {targets: [8],orderable: false,className: 'text-center text-middle'},
    ],
    processing: true,
    serverSide: true,
    ajax: {
        url: base_url+'/inquiry/getinquiries',
        dataType: 'json',
        type: 'POST',
        data: {
            'user':'admin',
            'type':'rem',
        }
    },
    columns: [
        { data: 'sr' },
        { data: 'inq_date' },
        { data: 'brand'},
        { data: 'inq_id'},
        { data: 'dept_date'},
        { data: 'details'},
        { data: 'feedback'},
        { data: 'pick_by'},
        { data: 'action'},
    ],
});
$('.user_reminq').DataTable({
    paging: true,
    pageLength: 100,
    order: [[ 0, "desc" ]],
    columnDefs: [
        {targets: [0],className: 'text-center text-middle'},
        {targets: [1],className: 'text-center text-middle',type:'date'},
        {targets: [2],className: 'text-center text-middle'},
        {targets: [3],className: 'text-center text-middle',type:'date'},
        {targets: [4],className: 'text-middle'},
        {targets: [5],className: 'text-center text-middle'},
        {targets: [6],orderable: false,className: 'text-center text-middle'},
    ],
    processing: true,
    serverSide: true,
    ajax: {
        url: base_url+'/inquiry/getinquiries',
        dataType: 'json',
        type: 'POST',
        data: {
            'user':'user',
            'type':'rem',
        }
    },
    columns: [
        { data: 'sr' },
        { data: 'inq_date' },
        { data: 'inq_id'},
        { data: 'dept_date'},
        { data: 'details'},
        { data: 'pick_by'},
        { data: 'action'},
    ]
});
$('#closed_inq').DataTable({
    ordering: true,
    order: [],
    select: true,
    paging: false,
    columnDefs: [
        {targets:[1,3],type:"date"},
        // {targets:[6],"orderable": false}
    ]
});
$('#inq_action_admin').DataTable( {
    ordering: true,
    order: [],
    select: true,
    paging: false,
    columnDefs: [
        {targets:[1,3],type:"date"},
    ],
    dom: 'Bfrtip',
    buttons: [
        {
            text: 'Close',
            className: 'btn btn-sm btn-primary mr-10',
            action: function ( e, dt, node, config ) {
                var rows = [];
                var count = 0;
                $('tr.selected').each(function(){
                   var row_id = $(this).data("row-id");
                   rows.push(row_id);
                   count ++ ;
                });
                if(count > 0){
                    $.ajax({
                        url:base_url+"/inquiry/inqAction",
                        data:{
                            inq_ids : rows,
                            action : 'Closed',
                            page : 'bulk',
                        },
                        type:"post",
                        dataType:"json",
                        success:function(output){
                            if(output.status){
                                location.reload(true);
                            }else{
                                $.toast({
                                    heading: 'Error',
                                    text: 'These was some error while closing inquiries..!!!', 
                                    position: 'bottom-right',
                                    loaderBg: '#ff6849',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    stack: 6
                                });
                            }
                        }
                    });
                }else{
                    alert("Please select an inquiry to close.");
                }
            }
        },
        {
            text: 'Re-Open',
            className: 'btn btn-sm btn-success mr-10',
            action: function ( e, dt, node, config ) {
                var rows = [];
                var count = 0;
                $('tr.selected').each(function(){
                   var row_id = $(this).data("row-id");
                   rows.push(row_id);
                   count ++ ;
                });
                if(count > 0){
                    $.ajax({
                        url:base_url+"/inquiry/inqAction",
                        data:{
                            inq_ids : rows,
                            action : 'Open',
                            page : 'bulk',
                        },
                        type:"post",
                        dataType:"json",
                        success:function(output){
                            if(output.status){
                                location.reload(true);
                            }else{
                                $.toast({
                                    heading: 'Error',
                                    text: 'These was some error while re-opening inquiries..!!!', 
                                    position: 'bottom-right',
                                    loaderBg: '#ff6849',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    stack: 6
                                });
                            }
                        }
                    });
                }else{
                    alert("Please select an inquiry to Re-Open.");
                }
            }
        },
        {
            text: 'Delete',
            className: 'btn btn-sm btn-danger mr-10',
            action: function ( e, dt, node, config ) {
                var rows = [];
                var count = 0;
                $('tr.selected').each(function(){
                   var row_id = $(this).data("row-id");
                   rows.push(row_id);
                   count ++ ;
                });
                if(count > 0){
                    $.ajax({
                        url:base_url+"/inquiry/deleteinq",
                        data:{
                            inq_ids : rows,
                            page : 'bulk',
                        },
                        type:"post",
                        dataType:"json",
                        success:function(output){
                            if(output.status){
                                location.reload(true);
                            }else{
                                $.toast({
                                    heading: 'Error',
                                    text: 'These was some error while delete inquiries..!!!', 
                                    position: 'bottom-right',
                                    loaderBg: '#ff6849',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    stack: 6
                                });
                            }
                        }
                    });
                }else{
                    alert("Please select an inquiry to delete.");
                }
            }
        }
    ]
});
$('#inq_action_user').DataTable( {
    ordering: true,
    order: [],
    select: false,
    paging: false,
    columnDefs: [
        {targets:[1,3],type:"date"},
    ]
});
$('#pickedInquiries').DataTable({
    ordering: true,
    order: [],
    select: true,
    paging: false,
    columnDefs: [
        {targets:[1,2],type:"date"},
        {targets:[4,5,6],"orderable": false},
        {targets: [0,1],"searchable": false},
    ]
});
$(document).on('submit','#inqalertform',function(e){
    e.preventDefault();
    $('#inqalertform').parsley();
    var form = $('#inqalertform').serialize();
    $(".inqalertformbtn").attr("disabled","disabled");
    $(".inqalertformbtn").html("...");
    $.ajax({
        url:base_url+"/inquiry/addinqalert",
        data:form,
        type:"post",
        dataType:"json",
        success:function(output){
            $('#inquiryAlert').modal('hide');
            if(output.status){
                $.toast({
                    heading: 'Reminder Set',
                    text: output.heading, 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 5000,
                    stack: 6
                });
                location.reload(true);
            }else{
                $.toast({
                    heading: 'Error',
                    text: output.heading, 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3500,
                    stack: 6
                });
                $(".inqalertformbtn").removeAttr("disabled");
                $(".inqalertformbtn").html('Set');
            }
        }
    });
    setTimeout(function() {
        $(".inqalertformbtn").removeAttr("disabled");
        $(".inqalertformbtn").html('Set');
    },2000);    
});
$(document).on("click",".editalert",function(){
    var thisdata =$(this);
    thisdata.attr("disabled","disabled");
    var enq_id = thisdata.data('inq-id');
    var alert_id = thisdata.data('alert-id');
    $.ajax({
        url: base_url+"/inquiry/editalertmodal",
        type: "POST",
        data: {
            enq_id: enq_id,
            alert_id: alert_id,
        },
        dataType: "json",
        success: function (output) {
            thisdata.attr("disabled","disabled");
            $('.editalertModal').html(output);
            $('#editAlert').modal('show');
            thisdata.removeAttr("disabled");
            $('.datetime').datetimepicker({
                todayBtn : true,
                format: "dd-M-yy HH:ii P",
                showMeridian: true,
                todayHighlight: true,
                autoclose: true,
            }).on('changeDate', function(e) {
                $(this).parsley().validate();
            });            
        },
        error:function (output) {
            thisdata.attr("disabled","disabled");            
        }
    });
});
$(document).on('submit','#editalertform',function(e){
    e.preventDefault();
    $('#editalertform').parsley();
    var form = $('#editalertform').serialize();
    $(".editalertformbtn").attr("disabled","disabled");
    $(".editalertformbtn").html("...");
    $.ajax({
        url:base_url+"/inquiry/editinqalert",
        data:form,
        type:"post",
        dataType:"json",
        success:function(output){
            $('#editAlert').modal('hide');
            if(output.status){
                $.toast({
                    heading: 'Reminder Edited',
                    text: output.heading, 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 5000,
                    stack: 6
                });
                location.reload(true);
            }else{
                $.toast({
                    heading: 'Error',
                    text: output.heading, 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3500,
                    stack: 6
                });
                $(".editalertformbtn").removeAttr("disabled");
                $(".editalertformbtn").html('Edit');
            }
        }
    });   
});
$(document).on('submit','#compalertform',function(e){
    e.preventDefault();
    $('#compalertform').parsley();
    var form = $('#compalertform').serialize();
    $(".compalertformbtn").attr("disabled","disabled");
    $(".compalertformbtn").html("...");
    $.ajax({
        url:base_url+"/inquiry/compinqalert",
        data:form,
        type:"post",
        dataType:"json",
        success:function(output){
            $('#editAlert').modal('hide');
            if(output.status){
                $.toast({
                    heading: 'Reminder Completed',
                    text: output.heading, 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 5000,
                    stack: 6
                });
                location.reload(true);
            }else{
                $.toast({
                    heading: 'Error',
                    text: output.heading, 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3500,
                    stack: 6
                });
                $(".compalertformbtn").removeAttr("disabled");
                $(".compalertformbtn").html('Edit');
            }
        }
    });   
});
$(document).on("click",".removeAlert",function() {
    var thisdata =$(this);
    thisdata.attr("disabled","disabled");
    thisdata.html("...");
    var alert_id = thisdata.data('alert-id');
    var enq_id = thisdata.data('inq-id');
    Swal.fire({
        html:
            '<div class="text-center text-warning mt-3 mb-3">'+
            '<h1 style="font-size:40px;"><i class="icon-lg icon glyphicon glyphicon-bell text-warning" style="font-size:62px"></i></h1></div>'+
            '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>'+ 
            'That you want to remove <b>Reminder</b>',
        confirmButtonColor: '#00c292',
        confirmButtonText: '<small>Yes, Remove It!</small>',
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
            url: base_url+"/inquiry/removealert",
            type: "POST",
            data: {
                alert_id: alert_id,
                enq_id: enq_id,
            },
            dataType: "json",
            success: function (output) {
                if(output.status) {
                    $.toast({
                        heading: 'Success',
                        text: 'Inquiry Reminder Removed..!!!', 
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 3500,
                        stack: 6
                    });
                    window.location.href = base_url+"/inquiry/view/"+output.inq_id;
                }else{
                    Swal.fire("Error!", "Please try again", "error");  
                    thisdata.removeAttr("disabled");
                    thisdata.html('<i class="icon glyphicon m-0 glyphicon-remove-circle" title="Remove Reminder"></i>');
                }
            },
            error: function (output) {
                Swal.fire("Error!", "Please try again", "error");
                thisdata.removeAttr("disabled");
                thisdata.html('<i class="icon glyphicon m-0 glyphicon-remove-circle" title="Remove Reminder"></i>');
            }
        });
      }else{
        thisdata.removeAttr("disabled");
        thisdata.html('<i class="icon glyphicon m-0 glyphicon-remove-circle" title="Remove Reminder"></i>');
      }
    }); 
    setTimeout(function() {
        thisdata.removeAttr("disabled");
        thisdata.html('<i class="icon glyphicon m-0 glyphicon-remove-circle" title="Remove Reminder"></i>');
    },2000);
});
$(document).on("click",".pickInq",function(){
 	var thisdata =$(this);
    thisdata.attr("disabled","disabled");
    thisdata.html("...");
    var enq_id = thisdata.data('enq-id');
    $.ajax({
        url: base_url+"/inquiry/pickinq",
        type: "POST",
        data: {
            enq_id: enq_id,
        },
        dataType: "json",
        success: function (output) {
            if(output.status == 'true') {
                $.toast({
                    heading: 'Success',
                    text: 'Inquiry Picked.', 
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 3500,
                    stack: 6
                });
                location.reload(true);
            }else{
                Swal.fire("Error!", "Please try again", "error");  
                thisdata.removeAttr("disabled");
                thisdata.html('<i class="icon glyphicon m-0 glyphicon-thumbs-up"></i>');
            }
        },
        error: function (output) {
            Swal.fire("Error!", "Please try again", "error");
            thisdata.removeAttr("disabled");
            thisdata.html('<i class="icon glyphicon m-0 glyphicon-thumbs-up"></i>');
        }
    });
    setTimeout(function() {
        thisdata.removeAttr("disabled");
        thisdata.html('<i class="icon glyphicon m-0 glyphicon-thumbs-up"></i>');
    },2000);
});
$('#feedBackForm').parsley();
$(document).on('submit','#feedBackForm',function(e){
	e.preventDefault();
    var form = $('#feedBackForm').serialize();
    $(".btnFeedback").attr("disabled","disabled");
    $(".btnFeedback").html("...");
    $.ajax({
        url:base_url+"/inquiry/addfeedback",
        data:form,
        type:"post",
        dataType:"json",
        success:function(output){
            $('#feedback').html(output);            
			$('#feedBackForm').trigger("reset");
            $(".btnFeedback").removeAttr("disabled");
        	$(".btnFeedback").html('<i class="icon glyphicon m-0 glyphicon-check"></i> Submit');
        }
    });
    setTimeout(function() {
        $(".btnFeedback").removeAttr("disabled");
        $(".btnFeedback").html('<i class="icon glyphicon m-0 glyphicon-check"></i> Submit');
    },2000);
});
$(document).on('click','.assigninq',function (e){
    e.preventDefault();
    var mainthis = $(this);
    var assign_name = mainthis.data("assign-name");
    var inq_id = mainthis.data("inq-id");
    var pre_name = mainthis.data("pre-name");
    $("#assigninq").attr("disabled","disabled");
    $.ajax({
        url:base_url+"/inquiry/assignInq",
        data:{
            assign_name : assign_name,
            inq_id : inq_id,
            pre_name : pre_name
        },
        type:"post",
        dataType:"json",
        success:function(output){
            location.reload(true);
        }
    });
    setTimeout(function() {
        $("#assigninq").removeAttr("disabled");
    },2000);
});
$(document).on("click",".inqaction",function() {
    var this_btn = $(this);
    var inq_id = this_btn.data("inq-id");
    var status = this_btn.data("status");
    this_btn.attr("disabled","disabled");
    Swal.fire({
        html:
        '<div class="text-center text-danger mt-3 mb-3">'+
            '<h1 style="font-size:40px;">'+
                '<i class="glyphicon glyphicon-warning-sign icon icon-lg text-danger" style="font-size:62px;"></i>'+
            '</h1>'+
        '</div>'+
        '<div class="text-center">'+
            '<h3 class="font-weight-bold">Are You Sure?</h3>'+
        '</div>'+
        'That you want to <b class="text-danger">'+status+'</b> this inquiry',
        confirmButtonColor: '#00c292',
        confirmButtonText: '<small>Yes, '+status+' It!</small>',
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
            url: base_url+"/inquiry/inqAction",
            type: "POST",
            data: {
                inq_id : inq_id,
                status : status,
            },
            dataType: "json",
            success: function (output) {
                if(output.status) {
                    $.toast({
                        heading: 'Success',
                        text: 'Action has been performed.', 
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 3500,
                        stack: 6
                    });
                    window.location.href = base_url+"/inquiry/view/"+output.inq_id;
                }else{
                    Swal.fire("Error!", "Please try again", "error");  
                    this_btn.removeAttr("disabled");
                }
            },
            error: function (output) {
                Swal.fire("Error!", "Please try again", "error");
                this_btn.removeAttr("disabled");
            }
        });
      }else{
        this_btn.removeAttr("disabled");
      }
    });
});
$(document).on("click",".deleteInq",function() {
    var thisdata =$(this);
    thisdata.attr("disabled","disabled");
    thisdata.html("...");
    var enq_id = thisdata.data('enq-id');
    Swal.fire({
      html:
        '<div class="text-center text-warning mt-3 mb-3">'+
        '<h1 style="font-size:40px;"><i class="glyphicon glyphicon-trash text-danger icon icon-lg" style="font-size:62px;"></i></h1></div>'+
        '<div class="text-center"><h3 class="font-weight-bold">Are You Sure?</h3></div>'+
        'That you want to <b class="text-danger">Delete Enq# '+enq_id+'</b>',
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
            url: base_url+"/inquiry/deleteinq",
            type: "POST",
            data: {
                enq_id: enq_id,
            },
            dataType: "json",
            success: function (output) {
                if(output.status == 'true') {
                    $.toast({
                        heading: 'Success',
                        text: 'Inquiry Deleted..!!!', 
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 3500,
                        stack: 6
                    });
                    window.location.href = base_url+"/inquiry/unpicked/";
                }else{
                    Swal.fire("Error!", "Please try again", "error");  
                    thisdata.removeAttr("disabled");
                    thisdata.html('<i class="icon glyphicon m-0 glyphicon-trash"></i>');
                }
            },
            error: function (output) {
                Swal.fire("Error!", "Please try again", "error");
                thisdata.removeAttr("disabled");
                thisdata.html('<i class="icon glyphicon m-0 glyphicon-trash"></i>');
            }
        });
      }else{
        thisdata.removeAttr("disabled");
        thisdata.html('<i class="icon glyphicon m-0 glyphicon-trash"></i>');
      }
    }); 
    setTimeout(function() {
        thisdata.removeAttr("disabled");
        thisdata.html('<i class="icon glyphicon m-0 glyphicon-trash"></i>');
    },2000);
});
$('.datetime').datetimepicker({
    todayBtn : true,
    format: "dd-M-yy HH:ii P",
    showMeridian: true,
    todayHighlight: true,
    autoclose: true,
}).on('changeDate', function(e) {
    $(this).parsley().validate();
});
