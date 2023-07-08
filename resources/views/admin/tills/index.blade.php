@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
  .dropdown-toggle::after {
      border: none !important;
  }
</style>
<div class="body-content">
  <form action="" id="reportForm">
		<div class="row mb-4">
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
		  <div class="col-md-2 mb-3">
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
							<h6 class="fs-17 font-weight-600 mb-0">Cient Till Report</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
          <div class="col-md-12">
            @if (Session::has('success'))
              <div class="alert alert-success">
                {{ Session::get('success') }}
              </div>
            @endif
          </div>
					<div class="table-responsive">
            <input type="hidden" name="client_id" value="{{$client_id}}">
						<table class="table table-borderless">
							<thead>
								<tr>
                  <th>Sr.</th>
                  <th>Client Name</th>
                  <th>Client Email</th>
                  <th>Order ID</th>
                  <th>Selling Price</th>
                  <th>Deposit</th>
                  <th>Balance</th>
                  <th>Payment Type</th>
                  <th>Status</th>
                  <th>Order Date</th>
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
	</div>
</div>
<div class="balance-template">
  
</div>

@endsection
@section('footer-script')
<script src="{{ asset('js/chosen.jquery.min.js') }}"></script>
<script type="text/javascript">
$('select').select2();
  function confirmDeleteOperation() {
    if (confirm('Are you sure you want to delete this user?'))
      return true;
    else
      return false;
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
      processing: false,
      serverSide: true,
      searching: false,
      stateSave: false,
      pagingType: "full_numbers",
      pageLength: 5,
      //order: [[ "2" , "DESC" ]],
      dom: 'Bfrtip',
      buttons: [
      {
          extend: 'csvHtml5',
          text: '<i class="fa fa-file-text-o"></i>&nbsp; CSV',
          title: 'InventoryReport-' + getDateTime(),
          action: newexportaction
      },
      {
      extend: 'excelHtml5',
      text: '<i class="fa fa-file-excel-o"></i>&nbsp; Excel',
      title: 'InventoryReport-' + getDateTime(),
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
          'url': '{!! route('admin.tills.ajax_data') !!}',
          'data': function (d) {
            d.client_id = $("input[name='client_id']").val();
            d.date_from = $("input[name='date_from']").val();
            d.date_to   = $("input[name='date_to']").val();
            return d;
          }
      },
      columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},
      {data: 'client_name', name: 'client_name', orderable: false},
      {data: 'client_email', name: 'client_email', orderable: false},
      {data: 'order_id', name: 'order_id', orderable: false},
      {data: 'selling_price', name: 'selling_price', orderable: false},
      {data: 'deposit', name: 'deposit', orderable: false},
      {data: 'balance', name: 'balance', orderable: false},
      {data: 'payment_type', name: 'payment_type', orderable: false},
      {data: 'status', name: 'status', orderable: false},
      {data: 'order_date', name: 'order_date', orderable: false},
      {data: 'actions', name: 'actions', className:'d-flex', orderable: false}
      ],
     columnDefs: [ {
        'orderable': false, /* true or false */
     }]
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


  $(document).on('click', '.adjust-balance', function(e){
    e.preventDefault();
    $('.balance-template').empty();
    var order_id 				= $(this).attr('data-order-id');
    $.ajax({
      url: '{{ route("admin.tills.balance_template") }}',
      type: "GET",
      data: {
        order_id: order_id
      },
      success: function(data) {
        
        $('.balance-template').html(data);
        $('#balance-modal').show();

      }
    });
  });
  $(document).on('change', '.selling_price, .deposit', function(){

    var selling_price               = parseInt($('.selling_price').val());
    var deposit                     = parseInt($('.deposit').val());
    var balance                     = 0;

    balance                         = deposit-selling_price;

    $('.balance').val(balance);

  });
  $(document).on('click', '#save-form', function(){

    $('form#form-submit').submit();

  });
  $("#search-button").click(function (e) {
		e.preventDefault();
		table.ajax.reload();

	});
</script>
@endsection

