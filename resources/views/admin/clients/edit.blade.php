@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
    .has-error{
        border: 1px solid red;
    }

</style>
<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Edit Client</h6>
                </div>
                <div class="text-right">
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            <form  method="POST" action="{{ route('admin.clients.update', $client->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-dark-gray" for="">Company Name</label>
                        <input type="text" name="company_name" class="form-control font-12 form-control-lg" value="{{$client->company_name }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-dark-gray" for="">First Name</label>
                        <input type="text" name="first_name" class="form-control font-12 form-control-lg require" value="{{ $client->first_name }}">
                        
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-dark-gray" for="">Last Name</label>
                        <input type="text" name="last_name" class="form-control font-12 form-control-lg require" value="{{ $client->last_name }}">
                        
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-dark-gray" for="">Email</label>
                        <input type="email" name="email" class="form-control font-12 form-control-lg" value="{{ $client->email }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-dark-gray" for="">Phone_number</label>
                        <input type="text" name="phone_number" class="form-control font-12 form-control-lg require" value="{{ $client->phone_number }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-dark-gray" for="">Reseller Number</label>
                        <input type="text" name="reseller_number" class="form-control font-12 form-control-lg" value="{{ $client->reseller_number }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-dark-gray" for="">Tax Exampt</label>
                        <select name="tax_examp" id="tax_examp" class="form-control search_test  basic-single"  >
                            <option value=""> Select</option>
                            <option value="Yes" @if($client->tax_examp == "Yes") {{ "selected" }} @endif>Yes</option>
                            <option value="No" @if($client->tax_examp == "No") {{ "selected" }} @endif>No</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mt-4">
                        <button type="submit" class="btn btn-success" id="save-button">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('footer-script')
<script>
    $(document).ready(function(){
        function required(){

            let validated       = true;
            var alertMessages       = "";
            var alertValidated      = false;

            $(".error-details").empty();

            $(".require").each(function(key, value){
                
                var value       = $(this).val();
                
                if(value == "" || value == null){
                        
                    $(this).addClass('has-error');
                    validated   = false;
                }else{
                    $(this).removeClass('has-error');   
                }
            });
            if(alertValidated){
                alert(alertMessages);
            }
            return validated;
        }
        $(document).on("click", "#save-button", function(event) {
           
            var validate = required();

            if (validate) {
                return true;
            }else{
                event.preventDefault();
            }

        });
    });
</script>

@endsection

