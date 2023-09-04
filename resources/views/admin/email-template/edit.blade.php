@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.btn-d-none{
    display: none;
}
.has-error{
    border: 1px solid red;
}
</style>
<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Edit Brand</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <form  method="POST" action="{{ route('admin.email-template.update', $template->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label text-dark-gray" for="">Template Name</label>
                        <input type="text" name="name" class="form-control font-12 form-control-lg require" value="{{ $template->name }}">      
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label text-dark-gray" for="">Email Subject</label>
                        <input type="text" name="email_subject" class="form-control font-12 form-control-lg require" value="{{$template->email_subject}}">     
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-8 mb-3">
                    <label class="form-label text-dark-gray" for="">Description</label>
                    <textarea class="form-control" name="description" id="summernote" >{!! $template->description !!}</textarea>
                    <ul>
                        <li>Use <strong class="text-danger">{company_name}</strong> to autofill Company name</li>
                        <li>Use <strong class="text-danger">{sales_rep}</strong> to autofill Sales Rep Name</li>
                        <li>Use <strong class="text-danger">{job_name}</strong> to autofill Job name</li>
                        <li>Use <strong class="text-danger">{order_number}</strong> to autofill Purchase Order #</li>
                    </ul>
                  </div>
                </div> 
                <div class="col-md-3 mb-3">
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
