
<div class="col-md-3">
    <label>First name</label>
    <input type="hidden" id="client_return_id" value="{{$rData['id'] ?? ""}}">
    <input type="hidden" id="error_return" value="@if(is_array($errors) && count($errors) > 0) {{ "true" }} @endif">
    <input type="text" name="first_name" class="form-control require" value="{{ $rData['first_name'] ?? "" }}">
    @if(is_array($errors) && isset($errors['first_name']))
    <p class="text-danger">{{$errors['first_name'][0]}}</p>
    @endif
</div>
<div class="col-md-3">
    <label>Last name</label>
    <input type="text" name="last_name" class="form-control require" value="{{ $rData['last_name'] ?? "" }}">
    @if(is_array($errors) && isset($errors['last_name']))
    <p class="text-danger">{{$errors['last_name'][0]}}</p>
    @endif
</div>
<div class="col-md-3">
    <label>Email Address</label>
    <input type="email" name="email" class="form-control" value="{{ $rData['email'] ?? "" }}">
    @if(is_array($errors) && isset($errors['email']))
    <p class="text-danger">{{$errors['email'][0]}}</p>
    @endif
</div>
<div class="col-md-3 mb-3">
    <label>Phone Number</label>
    <input type="text" name="phone_number" class="form-control require" value="{{ $rData['phone_number'] ?? "" }}">
    @if(is_array($errors) && isset($errors['phone_number']))
    <p class="text-danger">{{$errors['phone_number'][0]}}</p>
    @endif
</div>
<div class="col-md-12 form-check">
    <button class="btn btn-success mb-3 @if(is_array($errors) && count($errors) == 0) {{ "btn-d-none" }} @endif" id="add-client">Add Client</button>
</div>