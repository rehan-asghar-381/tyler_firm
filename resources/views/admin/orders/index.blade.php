@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.text-smaller{
	font-size: 12px !important;
}
.td-width{
	width: 100px !important;
	font-size: 12px !important;
}
.btn-sucess-custom{
	background-color: #28a745;
	color: #fff;
}
.dropdown-toggle::after {
	/* border: none !important; */
}
.form-control{
	font-size: 12px !important;
}
@keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 0; }
	100% { opacity: 1; }
}

.blinking {
	cursor: pointer;
	animation: blink 1s infinite;
}
</style>
<div class="body-content">
	<form action="" id="reportForm">
		<input type="hidden" name="order_id" value="{{$order_id}}">
		<div class="row mb-4">
			<div class="col-md-2 mb-3" style="margin-right: 10px;">
				<div class="form-group">
					<label>Client: </label>&nbsp;&nbsp;&nbsp;
					<select type="text" name="client_id" id="client_id" class="form-control select-one" value="" >
						<option value="">--select--</option>
						@foreach ($clients as $client)
						<option value="{{ $client->id }}">{{ $client->company_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<label>Assignee</label>
				<select type="text" name="user_id" id="user_id" class="form-control require required-online" value="" >
					<option value="">--select--</option>
					@foreach ($users as $id=>$user)
					<option value="{{ $user->id }}">{{ $user->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-2">
				<label>Status</label>
				<select type="text" name="status_id" id="order_type" class="form-control require required-online" value="" >
					<option value="">--select--</option>
					@foreach ($statuses_arr as $id=>$status)
					@php
					$status  	= json_decode($status, true);
					@endphp
					<option value="{{ $status['id'] }}" @if ($status_filter == $status['id']) {{ "selected" }} @endif>{{ $status['name'] }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-2">
				<label>Comp Status</label>
				<select type="text" name="comp_status" id="comp_status" class="form-control require required-online" value="" >
					<option value="">--select--</option>
					@foreach ($comp_statuses as $id=>$comp_status)
					<option value="{{ $comp_status->name }}" @if ($comp_filter == $comp_status->name) {{ "selected" }} @endif>{{ $comp_status->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-1 mb-3" style="margin-left: 44px;">
				<button class="btn btn-success" style="margin-top: 31px;width:150px;float:right" id="search-button">Search</button>
			</div>
		</div>
	</form>
	<div class="row">
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Orders List</h6>
						</div>
						@can('order-create')
						<div class="text-right">
							<a class="" href="{{ route('admin.order.create') }}"><i class="far fa fa-plus"></i> Add Order</a>
						</div>
						@endcan
					</div>
				</div>
				<div class="card-body">
					@if (Session::has('resp'))
					@php
					$resp = session()->get("resp");
					$msg = session()->get("msg");
					@endphp
					<div class="col-md-12">
						@if ($resp=="success")
						<div class="alert alert-success">
							{!!$msg!!}
						</div>
						@endif
					</div>
					@endif
					@if(Session::has('success'))
					<div class="alert alert-success" role="alert">
						{{ Session::get('success') }}
					</div>
					@endif
					<div class="table-responsive">
						<table class="table table-borderless table-striped" style="font-size:11px !important;">
							<thead style="background-color: #6aa4e6;color: #ffffff;">
								<tr>
									{{-- <th width="250px">Sr.</th> --}}
									<th width="250px">Action Log</th>
									<th>Action</th>
									<th width="250px">Quote #</th>
									<th width="250px">Job Name</th>
									<th width="250px">Company</th>
									<th width="250px">PO #</th>
									<th width="250px">Assignee</th>
									<th width="250px">Quantity</th>
									<th width="250px">Due Date</th>
									<th width="250px">Event</th>
									<th width="250px">Status</th>
									<th width="250px">Quote Approval</th>
									<th width="250px">Blank</th>
									<th width="250px">Comp Status</th>
									<th width="500px" class="td-width">Comp Due</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<template>
			{{ json_encode($statuses_arr) }}
		</template>
             <template id="quote_approval">{{json_encode($quote_approval_arr)}}</template>
             <template id="blank">{{json_encode($blank_arr)}}</template>

		<div class="job-template">

		</div>
		<div class="email-popup">

		</div>
		<div class="action-log-popup">

		</div>
		<div class="doc-popup">

		</div>
	</div>
</div>
@endsection
@section('footer-script')
<script type="text/javascript">
	function _loadDatePicker(){
		$('.flatpickr').flatpickr({
			enableTime: false,
			dateFormat: "m-d-Y",
		});
	}
	function getDateTime() {
		var now = new Date();
		var year = now.getFullYear();
		var month = now.getMonth() + 1;
		var day = now.getDate();
		var hour = now.getHours();
		var minute = now.getMinutes();
		var second = now.getSeconds();
		if (month.toString().length == 1) {
			month = '0' + month;
		}
		if (day.toString().length == 1) {
			day = '0' + day;
		}
		if (hour.toString().length == 1) {
			hour = '0' + hour;
		}
		if (minute.toString().length == 1) {
			minute = '0' + minute;
		}
		if (second.toString().length == 1) {
			second = '0' + second;
		}
		var dateTime = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
		return dateTime;
	}

	var table = $('table').DataTable({
		processing: true,
		serverSide: true,
		searching: true,
		stateSave: false,
		pagingType: "full_numbers",
		lengthMenu: [
			[10, 25, 50, -1],  // Specify the number of records to display
			['10', '25', '50', 'Show All'] // Label for the options
		],
		pageLength: -1,
		// pageLength: 10,
		//order: [[ "2" , "DESC" ]],
		dom: 'lBfrtip',
		buttons: [
		{
			extend: 'colvis'
		}
		],
		ajax: {
			'url': '{!! route('admin.orders.ajaxdata') !!}',
			'data': function (d) {
				d.client_id = $("select[name='client_id']").val();
				d.status_id = $("select[name='status_id']").val();
				d.comp_status = $("select[name='comp_status']").val();
				d.user_id = $("select[name='user_id']").val();
				d.order_id = $("input[name='order_id']").val();
				return d;
			}
		},
		columns: [
		// {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center text-smaller'},
		{data: 'notification', name: 'notification', width:"250px", className: 'text-smaller'},
		{data: 'actions', name: 'actions'},
		{data: 'id', name: 'id', width:"250px", className: 'text-smaller'},
		{data: 'job_name', name: 'job_name', width:"250px", className: 'text-smaller'},
		{data: 'company_name', name: 'company_name', width:"250px", className: 'text-smaller', orderable: true},
		{data: 'order_number', name: 'order_number', width:"250px", className: 'text-smaller'},
		{data: 'created_by_name', name: 'created_by_name', width:"250px", className: 'text-smaller', orderable: true},
		{data: 'projected_units', name: 'projected_units', width:"250px", className: 'text-smaller'},
		{data: 'due_date', name: 'due_date', width:"250px", className: 'text-smaller'},
		{data: 'event', name: 'event', width:"250px", className: 'text-smaller', orderable: true},
		{data: 'status', name: 'status', width:"250px", className: 'text-smaller'},
		{data: 'quote_approval', name: 'quote_approval', width:"250px", className: 'text-smaller', orderable: true},
		{data: 'blank', name: 'blank', width:"250px", className: 'text-smaller', className: 'text-smaller'},
		{data: 'comp_approval', name: 'comp_approval', width:"250px", className: 'text-smaller', className: 'text-smaller'},
		{data: 'comp_due', name: 'comp_due', width:"500px", className: 'td-width'}
		]
	});
	function newexportaction(e, dt, button, config) {
		var self = this;
		var oldStart = dt.settings()[0]._iDisplayStart;
		dt.one('preXhr', function (e, s, data) {
	// Just this once, load all data from the server...
	data.start = 0;
	data.length = 2147483647;
	dt.one('preDraw', function (e, settings) {
		// Call the original action function
		if (button[0].className.indexOf('buttons-copy') >= 0) {
			$.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
		} else if (button[0].className.indexOf('buttons-excel') >= 0) {

			$.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
			$.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
			$.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
		} else if (button[0].className.indexOf('buttons-csv') >= 0) {

			$.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
			$.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
			$.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
		} else if (button[0].className.indexOf('buttons-pdf') >= 0) {

			$.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
			$.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
			$.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
		} else if (button[0].className.indexOf('buttons-print') >= 0) {

			$.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
		}
		dt.one('preXhr', function (e, s, data) {
		  // DataTables thinks the first item displayed is index 0, but we're not drawing that.
		  // Set the property to what it was before exporting.
		  settings._iDisplayStart = oldStart;
		  data.start = oldStart;
		});
	  // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
	  setTimeout(dt.ajax.reload, 0);
	  // Prevent rendering of the full data to the DOM
	  return false;
	});
}


);
	// Requery the server with the new one-time export settings
	dt.ajax.reload();
};   
table.ajax.reload();
setTimeout(function(){
	_loadDatePicker();
}, 1000);
	// $("#tarcking_status").select2();
	$(document).on('click', '._deld', function(){
		var f = window.confirm("Do you want to delete record?");
		if(f){
			window.location = $(this).attr("href");
		}
		return false;
	});
	$(document).on("click", ".btn-change-status", function(event){
		event.preventDefault();
		let url 			= "{{ route('admin.order.status_update') }}";
		var status_id 		= $(this).attr("data-status-id");
		var order_id 		= $(this).attr("data-order-id");

		var _confirm 		= true;
		if(status_id == 5 || status_id == 7){
			_confirm 		= confirm("Are you sure you want to perform this action?")
		}
		if(_confirm){
			$.ajax({
				url: url, 
				type: "GET",
				data: {
					status_id: status_id,
					order_id: order_id
				},
				success: function(data) {
					table.ajax.reload();
					setTimeout(function(){
						_loadDatePicker();
					}, 1000);

				},
				beforeSend: function() {
						$('.page-loader-wrapper').show();
				},
				complete: function(){
					$('.page-loader-wrapper').hide();
				},
			});
		}
	});	
	$(document).on("click", ".btn-change-quote_approval", function(event){
		event.preventDefault();
		let url 			= "{{ route('admin.order.quote_update') }}";
		var status_id 		= $(this).attr("data-status-id");
		var order_id 		= $(this).attr("data-order-id");
		$.ajax({
			url: url, 
			type: "GET",
			data: {
				status_id: status_id,
				order_id: order_id
			},
			success: function(data) {
				table.ajax.reload();
				setTimeout(function(){
					_loadDatePicker();
				}, 1000);
			},
			beforeSend: function() {
					$('.page-loader-wrapper').show();
			},
			complete: function(){
				$('.page-loader-wrapper').hide();
			},
		});
	});
	
	$(document).on("click", ".btn-change-blank", function(event){
		event.preventDefault();
		let url = "{{ route('admin.order.blank_update') }}";
		var status_id 		= $(this).attr("data-status-id");
		var order_id 		= $(this).attr("data-order-id");
		$.ajax({
			url: url, 
			type: "GET",
			data: {
				status_id: status_id,
				order_id: order_id
			},
			success: function(data) {
				table.ajax.reload();
				setTimeout(function(){
					_loadDatePicker();
				}, 1000);
			},
			beforeSend: function() {
					$('.page-loader-wrapper').show();
			},
			complete: function(){
				$('.page-loader-wrapper').hide();
			},
		});
	});
	
	$(document).on('click', '.close-modal', function(e){
		$('#job-modal').hide();
	});

	$("form#formElement").submit(function(){
		var formData = new FormData($(this)[0]);
	});
	$(document).on('click', '#save-form', function(e){
		var messages 	= "";
		
		var oneDay = 24 * 60 * 60 * 1000;
		$('.enddate').each(function(index, value){
			var endDate 	= new Date($(this).val());
			var startDate 	= new Date($(this).closest('.row').find('.startdate').val());
			
			var diffDays =(endDate.getTime() - startDate.getTime()) / (oneDay);
			var exct_diff = Math.ceil(diffDays);

			if (exct_diff < 0){
				var row = index++;
				messages 	+="Completion date must be smaller than Start Date at Row "+index+"\n";
			}
		});
		alert(messages);
		return false;
		if(messages == ""){
			$.ajax({
				{{-- url: "{{ route('admin.job.assign_job') }}", --}}
				type: "GET",
				data: $('#job-form').serialize(),
				success: function(data) {
					data = JSON.parse(data);
					if(data.status == true){
						alert(data.message);
					}
					window.location.reload();
				}
			});
		}else{
			alert(messages);
			return false;
		}
		
		
	});
	$(document).on('click', '.send-email-modal', function(e){
		e.preventDefault();
		$('.email-popup').empty();
		var order_id 		  	= $(this).attr('data-id');
		var client_id 		  	= $(this).attr('data-client_id');
		var email 		  		= $(this).attr('data-email');
		var sale_rep_name 		= $(this).attr('data-sale_rep_name');
		var company_name 		= $(this).attr('data-company_name');
		var job_name 			= $(this).attr('data-job_name');
		var order_number 		= $(this).attr('data-order_number');
		
		$.ajax({
			url: '{{ route("admin.email-template.email_popup") }}',
			type: "GET",
			data: {
				order_id: order_id,
				client_id: client_id,
				sale_rep_name: sale_rep_name,
				company_name: company_name,
				job_name: job_name,
				order_number: order_number,
				email: email
			},
			success: function(data) {
				$('.email-popup').html(data);
				"use strict"; // Start of use strict
				//summernote
				$('#summernote').summernote({
					height: 200, // set editor height
					minHeight: null, // set minimum height of editor
					maxHeight: null, // set maximum height of editor
					focus: true                  // set focus to editable area after initializing summernote
				});
				$('#send-email-modal').show();
			}
		});
	});
	$(document).on('change', '.template', function(e){
		e.preventDefault();
		$('.email-popup').empty();
		var order_id 		  	= $(this).closest("#sendEmail").find("#order_number").val();
		var client_id 		  	= $(this).closest("#sendEmail").find("#clientId").val();
		var email 		  		= $(this).closest("#sendEmail").find("#clientEmail").val();
		var sale_rep_name 		= $(this).closest("#sendEmail").find("#saleRepName").val();
		var company_name 		= $(this).closest("#sendEmail").find("#compantName").val();
		var job_name 			= $(this).closest("#sendEmail").find("#jobName").val();
		var order_number 		= $(this).closest("#sendEmail").find("#orderNumber").val();
		var template_id 		= $(this).val();
		$.ajax({
			url: '{{ route("admin.email-template.email_popup") }}',
			type: "GET",
			data: {
				order_id: order_id,
				client_id: client_id,
				sale_rep_name: sale_rep_name,
				company_name: company_name,
				template_id: template_id,
				job_name: job_name,
				order_number: order_number,
				email: email
			},
			success: function(data) {
				$('.email-popup').html(data);
				"use strict"; // Start of use strict
				//summernote
				$('#summernote').summernote({
					height: 200, // set editor height
					minHeight: null, // set minimum height of editor
					maxHeight: null, // set maximum height of editor
					focus: true                  // set focus to editable area after initializing summernote
				});
				$('#send-email-modal').show();
			}
		});
	});
	$(document).on('click', '.copy-to-clipboard', function(e){
		e.preventDefault();
		var link = $(this).attr('data-link');
		var temp = $("<input>");
		$("body").append(temp);
		temp.val(link).select();
		document.execCommand("copy");
		temp.remove();
	});
	$(document).on('click', '.close-modal', function(e){
  		$(this).closest('.modal').hide();
	});
	$(document).on('click', '.close-modal-comp-preview', function(e){
            $(this).closest('.modal').modal('hide');
        });
	$("#search-button").click(function (e) {
		e.preventDefault();
		table.ajax.reload();
		setTimeout(function(){
			_loadDatePicker();
		}, 2000);

	});	 
	$(document).ready(function (e) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).submit("form#sendEmail", function(e) {
			e.preventDefault();
			var form 		= $("form#sendEmail");
			var formData = new FormData(form[0]);
			$.ajax({
				url: "{{ route('admin.sendEmail')}}",
				type:'POST',
				data: formData,
				cache:false,
				contentType: false,
				processData: false,
				success: (data) => {
					$('#send-email-modal').modal('hide');
					$('#sendEmail').trigger('reset');
					console.log(data);
					$.confirm({
						title : "Alert",
						content:function(){
							return data;
						},
						buttons:{
							ok:{
								text:"Ok",
								btnClass:"btn btn-success confirmed"
							}
						}
					});
				},
				beforeSend: function() {
					$('.page-loader-wrapper').show();
				},
				complete: function(){
					$('.page-loader-wrapper').hide();
					$('.Order-form').show();
					$('#send-email-modal').show();
					$('.email-popup').empty();
				},
				error: function(data){
					console.log(data);
				}
			});
		});
		$(document).on('click', '.action-logs', function(e){
			e.preventDefault();
			$('.action-log-popup').empty();
			var order_id 		  	= $(this).attr('data-id');
			
			$.ajax({
				url: '{{ route("admin.email-template.action_log") }}',
				type: "GET",
				data: {
					order_id: order_id
				},
				success: function(data) {
					$('.action-log-popup').html(data);
					$('#action-log-modal').show();
				}
			});
		});

		function _docPopup(order_id=""){
			if(order_id != ""){

				$('.doc-popup').empty();
				$.ajax({
					url: '{{ route("admin.order.doc") }}',
					type: "GET",
					data: {
						order_id: order_id
					},
					success: function(data) {
						$('.doc-popup').html(data);
						$('#doc-modal').show();
					}
				});
			}
		}
		$(document).on('click', '.--open-doc-popup', function(e){
			e.preventDefault();
			var order_id 		  	= $(this).attr('data-id');
			_docPopup(order_id);
		});
		$(document).on('click', '.blinking', function(e){
			e.preventDefault();
			$('.action-log-popup').empty();
			var order_id 		  	= $(this).attr('data-id');
			var user_id 		  	= $(this).attr('data-user-id');
			$.ajax({
				url: '{{ route("admin.email-template.action_log_seen") }}',
				type: "GET",
				data: {
					order_id: order_id,
					user_id: user_id
				},
				success: function(data) {
					$('.action-log-popup').html(data);
					$('#action-log-modal').show();
				}
			});
		});
		$(document).on('change', '.--comp-due', function(e){
			e.preventDefault();
			var comp_due 		  	= $(this).val();
			var order_id 		  	= $(this).attr('data-order-id');
			$.ajax({
				url: '{{ route("admin.order.comp_due") }}',
				type: "GET",
				data: {
					comp_due: comp_due,
					order_id: order_id
				},
				success: function(data) {
					table.ajax.reload();
					setTimeout(function(){
						_loadDatePicker();
					}, 2000);
				},
				beforeSend: function() {
					$('.page-loader-wrapper').show();
				},
				complete: function(){
					$('.page-loader-wrapper').hide();
				},
			});
		});
		$(document).on('change', '.docFile', function(e){
			e.preventDefault();
			var formData = new FormData(document.getElementById('uploadForm'));
			console.log(formData);
			$.ajax({
				url: '{{ route("admin.order.upload_doc") }}',
				type: "POST",
				data: formData,
				processData: false,
        		contentType: false,
				success: function(data) {
					data 	= JSON.parse(data);
					_docPopup(data.order_id);
				},
				beforeSend: function() {
					$('.page-loader-wrapper').show();
				},
				complete: function(){
					$('.page-loader-wrapper').hide();
				},
			});
		});

		$(document).on("click", ".--delete-doc-file", function(){
			if(window.confirm('Are You Sure You Want To Delete?')){
				let file_id 		= $(this).attr("data-file-id");
				console.log("file_id", file_id);
				if(file_id != ""){
					$.ajax({
						url: '{{ route("admin.order.deletePurchaseDocFile") }}',
						type: "GET",
						data: {
							file_id:file_id
						},
						success: function(data) {
							data 	= JSON.parse(data);
							console.log(data);
							_docPopup(data.order_id);
						},
						beforeSend: function() {
							$('.page-loader-wrapper').show();
						},
						complete: function(){
							$('.page-loader-wrapper').hide();
						},
					});
				}
			}else{
				return false;
			}
		});
		$(document).on("click", ".del", function(){
			if(window.confirm('Are You Sure You Want To Delete?')){
				return true;
			}else{
				return false;
			}
		});
		
		$(document).on("click", ".--comp-preview", function(event){
			event.preventDefault();
			let popup_id        = $(this).attr('data-popup-id');
			$('#'+popup_id).modal('show');
		});

		$(document).on("click", ".--doc-preview", function(event){
			event.preventDefault();
			let popup_id        = $(this).attr('data-popup-id');
			$('#'+popup_id).modal('show');
		});
	});
</script>
@endsection