<form  method="Post" id='form-submit' action="{{ route('admin.till.update', $till->id) }}" >
@csrf
<div class="modal" id="balance-modal">
	<div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Adjust Balance</h4>
            <button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Selling Price</label>
                            <input type="number" name="selling_price" class="form-control require selling_price" value="{{ $till->selling_price ?? "" }}">
                        </div>
                        <div class="col-md-4">
                            <label>Deposit</label>
                            <input type="number" name="deposit" class="form-control require deposit" value="{{ $till->deposit ?? "" }}">
                        </div>
                        <div class="col-md-4">
                            <label>Balance</label>
                            <input type="number" name="balance" class="form-control require balance" value="{{ $till->balance ?? "" }}" readonly>
                        </div>
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" type="submit" class="btn btn-success" id="save-form">Submit</button>
            </div>
        </div>
	</div>
</div>
</form>