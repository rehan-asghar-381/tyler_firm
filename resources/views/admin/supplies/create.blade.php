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
                    <h6 class="fs-17 font-weight-600 mb-0">Add Inventory</h6>
                </div>
                <div class="text-right">
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            <form  method="POST" action="{{ route('admin.supply.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-dark-gray" for="">Item</label>
                        <input type="text" name="item" class="form-control font-12 form-control-lg require" value="{{old('item')}}"> 
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-dark-gray" for="">Quantity</label>
                        <input type="number" name="qty" class="form-control font-12 form-control-lg require" value="{{old('qty')}}">
                    </div>
                    <div class="col-md-4" style="margin-top: 30px;">
                        <button type="submit" class="btn btn-success btn-lg" id="save-button">Submit</button>
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

