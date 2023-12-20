
	<!-- The Modal -->
	<div class="modal" id="comp-preview-modal-{{$comp_id}}">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header" style="background-color:#041e42">
					<h6 class="modal-title text-white">Comp Action</h6>
					<button type="button" class="close close-modal-comp-preview" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
					<div class="col-md-6 offset-md-3">
						<a href="{{$comp_preview}}" class="btn btn-pink w-100p mb-2 mr-1" target="_blank"><i class="fas fa-eye"></i> Preview &nbsp;&nbsp;</a>
					</div>
					<div class="col-md-6 offset-md-3">
						<a href="{{$download_url}}" class="btn btn-purple w-100p mb-2 mr-1"><i class="fas fa-download"></i> Download</a>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button class="btn btn-default close-modal-comp-preview" type="button">close</button>
				</div>
			</div>
		</div>
	</div>