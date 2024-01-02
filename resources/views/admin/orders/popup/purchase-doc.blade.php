<style>
    .art_btn {
        display: inline-block;
        font-weight: 600;
        color: #fff;
        text-align: center;
        padding: 2px;
        min-width: 116px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid;
        background-color: #041e42;
        border-color: #041e42;
        border-radius: 10px;
        line-height: 26px;
        font-size: 14px;
    }
    .upload__btn {
        display: inline-block;
        font-weight: 600;
        color: #fff;
        text-align: center;
        min-width: 116px;
        padding: 5px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid;
        background-color: #4045ba;
        border-color: #4045ba;
        border-radius: 10px;
        line-height: 26px;
        font-size: 14px;
    }
    .upload__inputfile {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
</style>
<!-- The Modal -->
	<div class="modal" id="doc-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header" style="background-color:#041e42">
					<h6 class="modal-title text-white">Purchase DOCs</h6>
					<button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                    <form id="uploadForm" method="POST"  action="#" enctype="multipart/form-data">
                        <input type="hidden" name="order_id" value="{{ $order_id }}">
                        <div class="col-md-12 mb-3 d-flex justify-content-center">
                            <label class="art_btn">
                                <p style="margin: 0px;">Upload Doc</p>
                                <input type="file" class="docFile upload__inputfile" name="document" data-max_length="20">
                            </label>
                        </div>
                    </form>
					<div class="table-responsive">
						@if (count($purchase_docs)>0)
						@php
							$preview_comps 	= "";
						@endphp
						<table class="table table-striped" style="font-size:11px !important;">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Quote#</th>
									<th scope="col">Purchase Doc</th>
									<th scope="col">Uploaded At</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($purchase_docs as $key=>$purchase_doc)
								<tr>
									<th scope="row">{{$key+1}}</th>
									<td>{{$purchase_doc->order_id}}</td>
									<td><a href="{{route("admin.order.downloadPurchaseDocFile", $purchase_doc->id)}}" class="btn btn-purple btn-circle mb-2 mr-1" style="width: 130px !important;"><i class="fas fa-download"></i> Purchase Doc {{$key+1}}</a></td>
									<td>{{ date('d-m-Y h:i:s', $purchase_doc->time_id) }}</td>
                                    <td><i class="far fa-trash-alt fa-2x --delete-doc-file" style="cursor: pointer;" data-file-id="{{$purchase_doc->id}}"></i></td>
								</tr>
                                @endforeach
							</tbody>
						</table>
						@else 
						{{-- <p style="font-size: 12px;color:red;width:100%;text-align:center;"> No Content Found!</p> --}}
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