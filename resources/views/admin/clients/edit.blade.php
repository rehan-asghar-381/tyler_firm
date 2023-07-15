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
            <form  method="POST" action="{{ route('admin.clients.update', $client->id) }}"  enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="upload__box">
                    <div class="upload__btn-box">
                      <label class="upload__btn">
                        <p>Click to Add attachments</p>
                        <input type="file" name="customer_doc[]" multiple="" data-max_length="20" class="upload__inputfile">
                    </label>
                </div>
                <div class="upload__img-wrap">
                  @if(count($client->ClientDoc) > 0)
                  @foreach($client->ClientDoc as $key=>$doc)
                  <div class='upload__img-box'>
                    <div style='background-image: url("{{asset($doc->doc)}}")' data-number='{{ $key }}' data-file='" + f.name + "' class='img-bg'>
                      <div class='upload__img-close' data-client-id='{{ $client->id }}' data-doc-id='{{ $doc->id }}'></div>
                  </div>
              </div>
              @endforeach
              @endif
          </div>
      </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label text-dark-gray" for="">Company Name</label>
        <input type="text" name="company_name" class="form-control font-12 form-control-lg" value="{{$client->company_name}}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label text-dark-gray" for="office_phone_number">Company Office Phone Number</label>
        <input type="text" name="office_phone_number" class="form-control font-12 form-control-lg require" value="{{$client->office_phone_number}}">

    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label text-dark-gray" for="">Company Website</label>
        <input type="text" name="website" class="form-control font-12 form-control-lg require" value="{{$client->website}}">

    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label text-dark-gray" for="">Billing Address</label>
        <input type="text" name="address" class="form-control font-12 form-control-lg" value="{{$client->address}}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label text-dark-gray" for="">Charge Tax</label>
        <select name="tax" id="tax" class="form-control search_test  basic-single"  >
            <option value=""> Select</option>
            <option value="Yes"  {{$client->tax ==  'Yes' ? 'Selected' : ''}}>Yes</option>
            <option value="No" {{$client->tax == 'No' ? 'Selected' : '' }} >No</option>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label text-dark-gray" for="">Resale Number</label>
        <input type="text" name="resale_number" class="form-control font-12 form-control-lg" value="{{$client->resale_number}}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label text-dark-gray" for="">Notes</label>
        <textarea name="notes"  class="form-control font-12 form-control-lg require" >{{$client->notes}}</textarea>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center">
    <div>
        <h6 class="fs-17 font-weight-600 mb-0">Sales Rep</h6>
    </div>
    <div class="text-right">
    </div>
</div>
<div class="main-row mb-3">
    @if(count($client->ClientSaleRep) > 0 )
    @foreach($client->ClientSaleRep as $saleRep) 
    <div class="row mt-3 clone_div">

     <div class="col-md-1 mb-3"></div>                
     <div class="col-md-2 mb-3">
        <label class="form-label text-dark-gray" for="">First name</label>
        <input type="text" name="first_name[]" class="form-control font-12 form-control-lg" value="{{$saleRep->first_name}}">
    </div>
    <div class="col-md-2 mb-3">
        <label class="form-label text-dark-gray" for="">Last Name</label>
        <input type="text" name="last_name[]" class="form-control font-12 form-control-lg" value="{{$saleRep->last_name}}">
    </div>
    <div class="col-md-2 mb-3">
        <label class="form-label text-dark-gray" for="">Email </label>
        <input type="email" name="email[]" class="form-control font-12 form-control-lg" value="{{$saleRep->email}}">
    </div>
    <div class="col-md-2 mb-3">
        <label class="form-label text-dark-gray" for="">Phone Number </label>
        <input type="phone" name="phone_number[]" class="form-control font-12 form-control-lg" value="{{$saleRep->phone_number}}">
    </div>
    <div class="col-md-2 float-right mt-4 " >
        <i type="submit" class="fas fa-plus add_row" style="color:green;cursor:pointer;"  style="max-width: 114px;max-height: 47px;margin-top: 25px;
        "></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i  id='remove_row' class="fas fa-minus" style="color:red;cursor:pointer;" style="max-width: 114px;max-height: 47px;margin-top: 25px;
        margin-left: 5px;"></i>
    </div>
</div>
@endforeach
@else
<div class="row mt-3 clone_div">

 <div class="col-md-1 mb-3"></div>                
 <div class="col-md-2 mb-3">
    <label class="form-label text-dark-gray" for="">First name</label>
    <input type="text" name="first_name[]" class="form-control font-12 form-control-lg" value="{{$client->first_name}}">
</div>
<div class="col-md-2 mb-3">
    <label class="form-label text-dark-gray" for="">Last Name</label>
    <input type="text" name="last_name[]" class="form-control font-12 form-control-lg" value="{{$client->last_name}}">
</div>
<div class="col-md-2 mb-3">
    <label class="form-label text-dark-gray" for="">Email </label>
    <input type="email" name="email[]" class="form-control font-12 form-control-lg" value="{{$client->email}}">
</div>
<div class="col-md-2 mb-3">
    <label class="form-label text-dark-gray" for="">Phone Number </label>
    <input type="phone" name="phone_number[]" class="form-control font-12 form-control-lg" value="{{$client->phone_number}}">
</div>
<div class="col-md-2 float-right mt-4 " >
    <i type="submit" class="fas fa-plus add_row" style="color:green;cursor:pointer;"  style="max-width: 114px;max-height: 47px;margin-top: 25px;
    "></i>&nbsp;&nbsp;&nbsp;&nbsp;
    <i  id='remove_row' class="fas fa-minus" style="color:red;cursor:pointer;" style="max-width: 114px;max-height: 47px;margin-top: 25px;
    margin-left: 5px;"></i>
</div>
</div>
@endif
</div>
    <button type="submit" class="btn btn-success" id="save-button">Submit</button>

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
        function ImgUpload() {
          var imgWrap = "";
          var imgArray = [];

          $('.upload__inputfile').each(function () {
            $(this).on('change', function (e) {
              imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
              var maxLength = $(this).attr('data-max_length');

              var files = e.target.files;
              var filesArr = Array.prototype.slice.call(files);
              var iterator = 0;
              filesArr.forEach(function (f, index) {

                if (!f.type.match('image.*')) {
                  return;
              }

              if (imgArray.length > maxLength) {
                  return false
              } else {
                  var len = 0;
                  for (var i = 0; i < imgArray.length; i++) {
                    if (imgArray[i] !== undefined) {
                      len++;
                  }
              }
              if (len > maxLength) {
                return false;
            } else {
                imgArray.push(f);

                var reader = new FileReader();
                reader.onload = function (e) {
                  var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close' data-order-id='' data-doc-id=''></div></div></div>";
                  imgWrap.append(html);
                  iterator++;
              }
              reader.readAsDataURL(f);
          }
      }
  });
          });
        });

          $('body').on('click', ".upload__img-close", function (e) {
            var file = $(this).parent().data("file");
            for (var i = 0; i < imgArray.length; i++) {
              if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }
        $(this).parent().parent().remove();

        var client_id        = $(this).attr('data-client-id');
        var doc_id          = $(this).attr('data-doc-id');

        if(client_id != "" && doc_id != ""){

          if(confirm("Are you sure?")){
            $.ajax({
                url: "{{ route('admin.clients.delete-doc') }}",
                type: "GET",
                data: {
                    client_id: client_id,
                    doc_id: doc_id
                },
                success: function(data) {
                    // console.log(data);
                }
            })
        }

    }
});
      }  
      ImgUpload();
  });
    var init = {{count($client->ClientSaleRep)}};
    // console.log('init: ' +init); 
    $(document).on('click', '.add_row', function(event) {
        event.preventDefault();
        // console.log(init);

        var row_add             = $(this).parent().parent().clone();
        var append_parent           = $(this).parent().parent().parent().last();
        // console.log(append_parent);
        var new_row_add         = row_add.clone().find("input").val("").end();

        append_parent.append(new_row_add);
        init++;
    });
    $(document).on('click', '#remove_row', function(e) {
        e.preventDefault();
        // console.log(init);

        if(init > 1){
            $(this).parent().parent().remove();
            var id  = $(this).attr('data-remove_row');

            $(".clone-product-"+id).remove();
                init--; //Decrement field counter
            }
        });
    </script>

    @endsection

