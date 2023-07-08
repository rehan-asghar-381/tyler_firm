@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.dropdown-toggle::after {
    border: none !important;
}
.modal-dialog {
    max-width: 900px !important;
}
</style>
<div class="body-content">
	<form action="" id="reportForm">
		<div class="row mb-4">
			<div class="col-md-3 mb-3">
			  <div class="form-group">
				<label>Tailor Name: </label>&nbsp;&nbsp;&nbsp;
				  <div class="input-group date">
					  <input type="text" name="name" class="form-control bg-light" value="">
				  </div>
				</div>
			</div>
			<div class="col-md-3 mb-3">
			  <div class="form-group">
				<label>Date From: </label>&nbsp;&nbsp;&nbsp;
				  <div class="input-group date">
					  <input type="text" name="date_from" class="form-control bg-light flatpickr" value="" required="" id="date_from">
					  <div class="input-group-addon input-group-append">
					  <div class="input-group-text">
					  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
					  </div>
					  </div>
				  </div>
				</div>
			</div>
		
			<div class="col-md-3 mb-3">
			  <div class="form-group">
				<label>Date To: </label>&nbsp;&nbsp;&nbsp;
				  <div class="input-group date">
					  <input type="text" name="date_to" class="form-control bg-light flatpickr" value="" required="" id="date_to">
					  <div class="input-group-addon input-group-append">
					  <div class="input-group-text">
					  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
					  </div>
					  </div>
				  </div>
				</div>
			</div>
			<div class="col-md-3">
				<label>Job Status</label>
				<select type="text" name="status_id" id="order_type" class="form-control require required-online" value="" >
					<option value="">--select--</option>
					<option value="0">Pending</option>
					<option value="1">In-progress</option>
					<option value="2">Completed</option>
				</select>
			</div>
		  	<div class="col-md-12 mb-3">
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
							<h6 class="fs-17 font-weight-600 mb-0">Task List</h6>
						</div>
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
						<table class="table table-borderless">
							<thead>
								<tr>
									<th width="250px">Sr.</th>
									<th width="250px">Task</th>
									<th width="250px">Order ID</th>
									<th width="250px">Tailor Name</th>
									<th width="250px">Start Date</th>
									<th width="250px">Completion Date</th>
									<th width="250px">Job Assigned By</th>
									<th width="250px">Notes</th>
									<th width="250px">Status</th>
									<th>Action</th>
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
			{{-- {{ json_encode($statuses_arr) }} --}}
		</template>
		<div class="job-template">

		</div>
	</div>
</div>
@endsection
@section('footer-script')
<script type="text/javascript">
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
		processing: false,
		serverSide: true,
		searching: false,
		stateSave: false,
		pagingType: "full_numbers",
		pageLength: 10,
		//order: [[ "2" , "DESC" ]],
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'colvis'
		}
		],
		ajax: {
			'url': '{!! route('admin.job.ajaxdata') !!}',
			'data': function (d) {
			    d.name = $("input[name='name']").val();
			    d.date_from = $("input[name='date_from']").val();
			    d.date_to = $("input[name='date_to']").val();
			    d.status_id = $("select[name='status_id']").val();
			    return d;
			}
		},
		columns: [
		{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},
		{data: 'status_id', name: 'status_id', width:"250px"},
		{data: 'order_id', name: 'order_id', width:"250px"},
		{data: 'tailor_id', name: 'tailor_id', width:"250px"},
		{data: 'start_date_time', name: 'start_date_time', width:"250px"},
		{data: 'completion_date_time', name: 'completion_date_time', width:"250px"},
		{data: 'assigend_by_name', name: 'assigend_by_name', width:"250px"},
		{data: 'notes', name: 'notes', width:"250px"},
		{data: 'status', name: 'status', width:"250px"},
		{data: 'actions', name: 'actions'}
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

	$(document).on("click", ".btn-change-status", function(event){
		event.preventDefault();
		var statuses 			= $('template').html();
		var statuses_arr		= {0:"Pending", 1:"In-process", 2:"Completed"};
		var status = $(this).attr("data-status");
		var id = $(this).attr("data-id");
		$.confirm({
			title : "Change Status",
			content:function(){
				var html = "";
				$.each(statuses_arr, function(index, value){
					if(index==status){
						html+="<label><input type='radio' name='status' value='"+index+"' checked> "+value+"</label><br>";
					}else{
						html+="<label><input type='radio' name='status' value='"+index+"'> "+value+"</label><br>";
					}
				});
				return html;
			},
			buttons:{
				ok:{
					text:"Save",
					btnClass:"btn btn-success confirmed",
					action:function(){
						var v = this.$content.find("input[type='radio']:checked").val();
						save_status(v, id);
						alert('Status has been updated successfully!');
						window.location.reload();
					}
				},
				no:{
					text:"Cancel"
				}
			}
		});
		return false;
	});	

	function save_status(status_id, job_id){

		$.ajax({
			url: "{{ route('admin.job.status_update') }}",
			type: "GET",
			data: {
				status_id: status_id,
				job_id: job_id
			},
			success: function(data) {

				data = JSON.parse(data);

				console.log(data.status);
				if(data.status == true){
					console.log(data.message);
					return data.message;
				}
			}
		});
	}
	$("#search-button").click(function (e) {
		e.preventDefault();
		table.ajax.reload();

	});

	$(document).on('click', '._deld', function(event){
		event.preventDefault();
		var f = window.confirm("Do you want to delete record?");
		if(f){
			window.location = $(this).attr("href");
		}
		return false;
	});
</script>
@endsection