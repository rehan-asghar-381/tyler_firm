
	<!-- The Modal -->
	<div class="modal" id="send-email-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header" style="background-color:#041e42">
					<h6 class="modal-title text-white">Send Email</h6>
					<button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
					<form  method="POST" id="sendEmail"  enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="comp_id" id="comp_id" value="{{$comp_id}}">
						<input type="hidden" name="order_number" id="order_number" value="{{$order_id}}">
						<input type="hidden" name="clientId" id="clientId" value="{{$client_id}}">
						<input type="hidden" name="saleRepName" id="saleRepName" value="{{$sale_rep_name}}">
						<input type="hidden" name="compantName" id="compantName" value="{{$company_name}}">
						<input type="hidden" name="jobName" id="jobName" value="{{$job_name}}">
						<input type="hidden" name="orderNumber" id="orderNumber" value="{{$order_number}}">

						<div class="row">
							<div class="col-md-12 mb-3">
								<button class="btn btn-info copy-to-clipboard" data-link="{{route('order.quote',  ['order_id' => $order_id, 'email' => $encrypted_email])}}">Copy Link</button>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label text-dark-gray" for="email">Sent to Email</label>
								<input type="email" id="clientEmail" name="email" class="form-control font-12 form-control-lg" value="{{$email}}">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label text-dark-gray" for="subject">Subject</label>
								<input type="text" name="subject" class="form-control font-12 form-control-lg require" value="{{$selected_template->email_subject??""}}">
							</div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email Template</label>
                                    <select name="template" id="template" class="form-control template">
                                        <option value="">Select</option>
                                        @foreach ($email_templates as $email_template)
                                            <option value="{{ $email_template->id }}" @if($template_id == $email_template->id) {{ "selected" }} @endif> {{$email_template->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
							{{-- <div class="col-md-6 mb-3">
								<label class="form-label text-dark-gray" for="subject">Attachment</label>
								<input type="file" name="attachment" id="attachment" class="form-control font-12 form-control-lg require" value="">

							</div> --}}
							<div class="col-md-12 mb-3">
								<label class="form-label text-dark-gray" for="description">Message</label>
                                <textarea class="form-control require" name="description" id="summernote" > {!! isset($selected_template->description) ? str_replace(array("{company_name}", "{sales_rep}", "{job_name}", "{order_number}"), array($company_name, $sale_rep_name, $job_name, $order_number) , $selected_template->description): "" !!}</textarea>
							</div>
						</div>
						<button type="submit" class="btn btn-success" id="--sendEmail">Submit</button>
					</form>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button class="btn btn-default close-modal" type="button">close</button>
				</div>
			</div>
		</div>
	</div>