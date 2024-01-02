
	<!-- The Modal -->
	<div class="modal" id="comp-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header" style="background-color:#041e42">
					<h6 class="modal-title text-white">Order Comps</h6>
					<button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
					<div class="table-responsive">
						@if (count($comps)>0)
						@php
							$preview_comps 	= "";
						@endphp
						<table class="table table-striped" style="font-size:11px !important;">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Quote#</th>
									<th scope="col">Comp File</th>
									<th scope="col">Comp Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($comps as $key=>$comp)
								<tr>
									<th scope="row">{{$key+1}}</th>
									<td>{{$comp->order_id}}</td>
									<td><button data-popup-id="comp-preview-modal-{{$comp->id}}" class="btn btn-purple btn-circle mb-2 mr-1 --comp-preview" style="width: 100px !important;"><i class="fas fa-eye"></i> Comp {{$key+1}}</button></td>
									<td>{{$comp->is_approved}}</td>
								</tr>
								@php
									$path                   = explode("/", $comp->file);
                                    $filename               = end($path);
                                    $encodedFilename        = rawurlencode($filename);
                                    $path[count($path) - 1] = $encodedFilename;
                                    $encodedPath            = implode("/", $path);
								@endphp
								@include('admin.orders.popup.comp-preview', ["download_url"=>route('admin.order.downloadCompFiles', $comp->id), "comp_preview"=>asset($encodedPath), "comp_id"=>$comp->id])
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