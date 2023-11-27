<div class="modal" id="add-task">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color:#041e42">
                <h6 class="modal-title text-white">Add Task</h6>
                <button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <form  method="POST" id="saveTask"  enctype="multipart/form-data">
                    <input type="hidden" id="task_id" value="{{ $task_id }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-dark-gray" for="description">Task Details</label>
                            <textarea class="form-control require" name="description">{{ $data->task_detail ?? "" }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" id="--saveTask">Submit</button>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button class="btn btn-default close-modal" type="button">close</button>
            </div>
        </div>
    </div>
</div>