<!-- The Modal -->
<div class="modal" id="job-modal">
	<div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Assign Tasks</h4>
            <button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
          
                <form  method="GET" action="#" id="job-form" enctype="multipart/form-data">
                    {{-- @csrf --}}
                    @php
                        $key        = 0; 
                    @endphp 
                    @foreach ($statuses_arr as $id=>$status)

                        @php
                        
                            $tailor_id              = (isset($jobs_arr[$id]['tailor_id']))
                                                    ? $jobs_arr[$id]['tailor_id']
                                                    : [];
                            $start_date_time        = (isset($jobs_arr[$id]['start_date_time']))
                                                    ? $jobs_arr[$id]['start_date_time']
                                                    : "";
                            $completion_date_time   = (isset($jobs_arr[$id]['completion_date_time']))
                                                    ? $jobs_arr[$id]['completion_date_time']
                                                    : "";
                            $notes                  = (isset($jobs_arr[$id]['notes']))
                                                    ? $jobs_arr[$id]['notes']
                                                    : "";
                            
                            
                        @endphp
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <input type="hidden" id="order_id" name="order_id" value="{{ $order_id }}">
                                <input type="hidden" id="status_id" name="status_id[]" value="{{ $id }}">
                                <input type="text" name="status_id" class="form-control require" value="{{ $status }}" disabled>
                            </div>
                            <div class="col-md-2">
                                <select type="text" name="tailor_id[{{$key++}}][]" id="tailor_id" multiple class="form-control require select-tailor" value="" >
                                    <option value="">Select Tailor</option>
                                    @foreach ($tailors as $tailor)
                                        <option value="{{ $tailor->id }}" @if(in_array($tailor->id, $tailor_id)) {{ "selected" }} @endif>{{ $tailor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <input type="text" id="start_date_time" name="start_date_time[]" class="form-control bg-light flatpickr-jobs require startdate" value="{{ $start_date_time }}" placeholder="Start Date">
                                        <div class="input-group-addon input-group-append">
                                            <div class="input-group-text">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <input type="text" id="completion_date_time" name="completion_date_time[]" class="form-control bg-light flatpickr-jobs require enddate" value="{{ $completion_date_time }}" placeholder="Completion Date">
                                        <div class="input-group-addon input-group-append">
                                            <div class="input-group-text">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <textarea type="text" name="notes[]" class="form-control require">{{ $notes }}</textarea>
                            </div>
                        </div>
                    @endforeach
                    
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" type="submit" class="btn btn-success" id="save-form">Submit</button>
            </div>
        </div>
	</div>
</div>