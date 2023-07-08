@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
  .dropdown-toggle::after {
      border: none !important;
  }
  </style>
<div class="body-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Notifications List</h6>
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
					<div class="table-responsive">
						<table class="table table-borderless">
							<thead>
								<tr>
                  <th width="50px">Sr.</th>
                  <th width="400px">ID</th>
                  <th width="400px">Type</th>
                  <th width="400px">Message</th>
                  <th width="400px">Added By</th>
                  <th width="400px">Created At</th>
                  <th width="400px">Is Seen</th>
								</tr>
							</thead>
							<tbody>
									
							</tbody>
						</table>
					</div>
				</div>
			</div>
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
          extend: 'csvHtml5',
          text: '<i class="fa fa-file-text-o"></i>&nbsp; CSV',
          title: 'RolesReport-' + getDateTime(),
          action: newexportaction
      },
      {
      extend: 'excelHtml5',
      text: '<i class="fa fa-file-excel-o"></i>&nbsp; Excel',
      title: 'RolesReport-' + getDateTime(),
      action: newexportaction,
      exportOptions: {
        modifier: {
            // DataTables core
            order: 'index',  // 'current', 'applied', 'index',  'original'
            page: 'all',      // 'all',    'current'
            search: 'applied'     // 'none',    'applied', 'removed'
          }
        }
      }
      ],
      ajax: {
          'url': '{!! route('admin.dashboard.notificationAjaxData') !!}',
         
      },
      columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},
      {data: 'idFK', name: 'idFK', orderable: false},
      {data: 'type', name: 'type', orderable: false},
      {data: 'body', name: 'body', orderable: false},
      {data: 'time_id', name: 'time_id', orderable: false},
      {data: 'added_by_name', name: 'added_by_name', orderable: false},
      {data: 'hasSeen', name: 'hasSeen', orderable: false}
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
</script>
@endsection
