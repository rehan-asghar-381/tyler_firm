
	<!-- The Modal -->
	<div class="modal" id="action-log-modal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header" style="background-color:#041e42">
					<h6 class="modal-title text-white">Action Logs</h6>
					<button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
					<div class="table-responsive">
						@if (count($action_logs)>0)
						<table class="table table-striped" style="font-size:11px !important;">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Date</th>
									<th scope="col">Quote</th>
									<th scope="col">Assignee</th>
									<th scope="col">Send To</th>
									<th scope="col">From</th>
									<th scope="col">Quote/Comp</th>
									<th scope="col">Action</th>
									<th scope="col">Approval</th>
									<th scope="col">Remarks</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($action_logs as $key=>$action_log)
								<tr>
									<th scope="row">{{$key+1}}</th>
									<td>{{ date("m-d-Y h:i:s a", $action_log->time_id) }}</td>
									<td>{{$action_log->order_id}}</td>
									<td>{{$action_log->assignee_name}}</td>
									<td>{{$action_log->send_to}}</td>
									<td>{{$action_log->from}}</td>
									<td>
										@if($action_log->comp_id > 0)
											
											<a class="btn btn-success" href="{{route('admin.order.downloadCompFiles', $action_log->comp_id)}} " target="_blank" style="white-space: nowrap;"><i class="fas fa-download"></i> Comp</a>
										@elseif($action_log->invoice!="")
											<a class="btn btn-success" href="{{asset($action_log->invoice)}} " target="_blank" style="white-space: nowrap;">Quote Preview</a>
										@else
										{{"-"}}
										@endif
									</td>
									<td>{{($action_log->is_response == "Y")? "Received":"Sent"}}</td>
									<td>{{($action_log->is_response == "Y")? ($action_log->is_approved == 1 && $action_log->is_response == "Y")? "Yes":"No":"-"}}</td>
									<td>{!! $action_log->description !!}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						@else 

						<p style="font-size: 12px;color:red;width:100%;text-align:center;"> No Content Found!</p>
						@endif
						
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button class="btn btn-default close-modal" type="button">close</button>
				</div>
			</div>
		</div>
	</div>