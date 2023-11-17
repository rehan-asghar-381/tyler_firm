@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.text-smaller{
	font-size: 12px !important;
}
.btn-sucess-custom{
	background-color: #28a745;
	color: #fff;
}
.dropdown-toggle::after {
	/* border: none !important; */
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
.col-md-3.col-sm-6.col-xs-12.count-widget {
    cursor: pointer;
}
.mini-stat {
  padding: 15px;
  margin-bottom: 20px;
}

.mini-stat-icon {
  width: 60px;
  height: 60px;
  display: inline-block;
  line-height: 60px;
  text-align: center;
  font-size: 30px;
  background: none repeat scroll 0% 0% #EEE;
  border-radius: 100%;
  float: left;
  margin-right: 10px;
  color: #FFF;
}

.mini-stat-info {
  font-size: 12px;
  padding-top: 2px;
}

.count-widget span, p {
  color: white;
}

.mini-stat-info span {
  display: block;
  font-size: 30px;
  font-weight: 600;
  margin-bottom: 5px;
  margin-top: 7px;
}

/* ================ colors =====================*/
.bg-0 {
  background-color: #004f5b !important;
  border: 1px solid #004f5b;
  color: white;
}

.fg-0 {
  color: #004f5b !important;
}

.bg-1 {
  background-color: #3b5998 !important;
  border: 1px solid #3b5998;
  color: white;
}

.fg-1 {
  color: #3b5998 !important;
}


.bg-5 {
  background-color: #00a0d1 !important;
  border: 1px solid #00a0d1;
  color: white;
}

.fg-5 {
  color: #00a0d1 !important;
}


.bg-4 {
  background-color: #db4a39 !important;
  border: 1px solid #db4a39;
  color: white;
}

.fg-4 {
  color: #db4a39 !important;
}


.bg-3 {
  background-color: #40ff00 !important;
  border: 1px solid #40ff00;
  color: white;
}

.fg-3 {
  color: #40ff00 !important;
}

.bg-2 {
  background-color: #4e2182 !important;
  border: 1px solid #4e2182;
  color: white;
}

.fg-2 {
  color: #4e2182 !important;
}

.bg-6 {
  background-color: #218226 !important;
  border: 1px solid #218226;
  color: white;
}

.fg-6 {
  color: #218226 !important;
}

.bg-7 {
  background-color: #738221 !important;
  border: 1px solid #738221;
  color: white;
}

.fg-7 {
  color: #738221 !important;
}

.bg-8 {
  background-color: #217282 !important;
  border: 1px solid #217282;
  color: white;
}

.fg-8 {
  color: #217282 !important;
}

.bg-9 {
  background-color: #8b0086 !important;
  border: 1px solid #8b0086;
  color: white;
}

.fg-9 {
  color: #8b0086 !important;
}


.bg-10 {
  background-color: #bf2df4 !important;
  border: 1px solid #bf2df4;
  color: white;
}

.fg-10 {
  color: #bf2df4 !important;
}

.bg-11 {
  background-color: #3c221d !important;
  border: 1px solid #3c221d;
  color: white;
}

.fg-11 {
  color: #3c221d !important;
}

.bg-12 {
  background-color: #823121 !important;
  border: 1px solid #823121;
  color: white;
}

.fg-12 {
  color: #823121 !important;
}

.bg-13 {
  background-color: #c88c80 !important;
  border: 1px solid #c88c80;
  color: white;
}

.fg-13 {
  color: #607e51 !important;
}
.bg-14 {
  background-color: #a2f43e !important;
  border: 1px solid #a2f43e;
  color: white;
}

.fg-14 {
  color: #fca6ff !important;
}
</style>
@php
    // dd($status_counts);
@endphp
<div class="main-content">

  <!--/.Content Header (Page header)--> 
  <div class="body-content">
      <div class="row">
          <div class="col-lg-12 col-xl-12">
              <div class="card">
                  <div class="card-body">
                      <!-- calender -->
                      <div id='calendar'></div>
                  </div>
              </div>
          </div>
      </div>
  </div><!--/.body content-->
  <div class="bootstrap snippets bootdey">
    <div class="row" id="status-counts" style="padding: 0px 30px">
      
    </div>
  </div>
  <div class="row order-listing" style="display: none; padding:0px 30px;">
    <input type="hidden" id="status" value="">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0 listing-heading"></h6>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
						<table class="table table-borderless table-striped --DT">
							<thead style="background-color: #6aa4e6;color: #ffffff;">
								<tr>
									{{-- <th width="250px">Sr.</th> --}}
									<th width="250px">Action Log</th>
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
  <div class="action-log-popup">

  </div>
</div><!--/.main content-->
@endsection

@section('footer-script')
  <script src="{{asset('b//plugins/fullcalendar/packages/core/main.min.js') }}"></script>
  <script src="{{asset('b/plugins/fullcalendar/packages/interaction/main.min.js') }}"></script>
	<script src="{{asset('b/plugins/fullcalendar/packages/daygrid/main.min.js') }}"></script>
	<script src="{{asset('b/plugins/fullcalendar/packages/timegrid/main.min.js') }}"></script>
	<script src="{{asset('b/plugins/fullcalendar/packages/list/main.min.js') }}"></script>
  <script>
    $(document).ready(function(){

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
      function loadCounts(){
        $form = $("#reportForm").serialize();
        $("#status-counts").html("");
        $.ajax({
            url: "{{ route('admin.dashboard.status_counts') }}",
            data: $form,
            dataType: 'json',
            success: function (result) {
                $("#status-counts").append(result.status_counts);
            },
            error: function (e) {
            }
        });
      }

      function calanderEvents(){
        $.ajax({
            url: "{{ route('admin.dashboard.calanderEvents') }}",
            data: {},
            dataType: 'json',
            success: function (result) {

              _load_calander(result.events, result.default_date);
                
            },
            error: function (e) {
            }
        });
      }
      $(document).on("click", ".count-widget", function(e){
        $('.listing-heading').text('');
        $('.order-listing').show();
        var status              = $(this).attr('data-status');
        var status_name         = $(this).attr('data-status-name');
        var heading             = status_name+' Orders';
        $('.listing-heading').text(heading);
        $("#status").val(status);
        _getData();
      });

      function _getData(){
        
        $('.--DT').DataTable().destroy();
        $('.--DT').DataTable({
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
            'url': '{!! route('admin.dashboard.ajaxtData') !!}',
            'data': function (d) {
                d.user_id          = $("#status").val();
                d.date_from       = $("#date_from").val();
                d.date_to         = $("#date_to").val();
                return d;
            }
          },
          columns: [
          {data: 'notification', name: 'notification', width:"250px", className: 'text-smaller'},
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
          {data: 'actions', name: 'actions'}
          ]
        });
        
      }
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
      $(document).on("click", ".btn-change-status", function(event){
        event.preventDefault();
        let url 			= "{{ route('admin.order.status_update') }}";
        var status_id 		= $(this).attr("data-status-id");
        var order_id 		= $(this).attr("data-order-id");

        var _confirm 		= true;
        if(status_id 	== 5){
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
              _getData();
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
            _getData();
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
            _getData();
          },
          beforeSend: function() {
              $('.page-loader-wrapper').show();
          },
          complete: function(){
            $('.page-loader-wrapper').hide();
          },
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
      $(document).on('click', '.close-modal', function(e){
        $(this).closest('.modal').hide();
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
      $(document).on('click', '.close-modal', function(e){
        $('#job-modal').hide();
      });
      function _load_calander(data, default_date){
        var Calendar = FullCalendar.Calendar;
        /* initialize the calendar
        -----------------------------------------------------------------*/
        var calendarEl = document.getElementById('calendar');
        var calendar = new Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            defaultDate: default_date,
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            events: data,
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar
            drop: function (arg) {
                // is the "remove after drop" checkbox checked?
                if (document.getElementById('drop-remove').checked) {
                    // if so, remove the element from the "Draggable Events" list
                    arg.draggedEl.parentNode.removeChild(arg.draggedEl);
                }
            }
        });
        calendar.render();
      }
      calanderEvents();
      loadCounts();
    });
  </script>
@endsection