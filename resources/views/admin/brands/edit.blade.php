@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.btn-d-none{
    display: none;
}
.has-error{
    border: 1px solid red;
}

  .upload__btn-box {
      margin-bottom: 10px;
  }
  .upload__btn {
      display: inline-block;
      font-weight: 600;
      color: #fff;
      text-align: center;
      min-width: 116px;
      /* padding: 5px; */
      transition: all 0.3s ease;
      cursor: pointer;
      border: 2px solid;
      background-color: #4045ba;
      border-color: #4045ba;
      border-radius: 10px;
      line-height: 26px;
      font-size: 14px;
  }
  .upload__inputfile {
      width: 0.1px;
      height: 0.1px;
      opacity: 0;
      overflow: hidden;
      position: absolute;
      z-index: -1;
  }
  .upload__img-wrap {
      display: flex;
      flex-wrap: wrap;
      margin: 0 -10px;
  }
  .upload__img-box {
        width: 150px;
        padding: 0 10px;
        margin-bottom: 12px;
      }
  
  element.style {
  }
  .upload__btn:hover {
      background-color: unset;
      color: #4045ba;
      transition: all 0.3s ease;
  }
  .upload__img-close {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background-color: rgba(0, 0, 0, 0.5);
      position: absolute;
      top: 10px;
      right: 10px;
      text-align: center;
      line-height: 24px;
      z-index: 1;
      cursor: pointer;
  }
  .upload__img-close:after {
      content: '\2716';
      font-size: 14px;
      color: white;
    }
  .img-bg {
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    position: relative;
    padding-bottom: 100%;
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
            <form  method="POST" action="{{ route('admin.brand.update', $brand->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="upload__box">
                    <div class="upload__btn-box">
                      <label class="upload__btn">
                        <p>Brand Logo</p>
                        <input type="file" name="filePhoto[]" multiple="" data-max_length="20" class="upload__inputfile">
                      </label>
                    </div>
                    <div class="upload__img-wrap">
                      @if(count($brand->BrandImg) > 0)
                      @foreach($brand->BrandImg as $key=>$BrandImg)
                      <div class='upload__img-box'>
                        <div style='background-image: url("{{asset($BrandImg->image)}}")' data-number='{{ $key }}' data-file='" + f.name + "' class='img-bg'>
                          <div class='upload__img-close' data-product-id='{{ $brand->id }}' data-img-id='{{ $BrandImg->id }}'></div>
                        </div>
                      </div>
                      @endforeach
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label text-dark-gray" for="">Brand Name</label>
                        <input type="text" name="name" class="form-control font-12 form-control-lg require" value="{{ $brand->name }}">      
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-8 mb-3">
                    <label class="form-label text-dark-gray" for="">Description</label>
                    <textarea class="form-control" name="description" id="summernote" >{{ $brand->description }}</textarea>
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
                      var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close' data-order-id='' data-img-id=''></div></div></div>";
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

            var product_id        = $(this).attr('data-product-id');
            var img_id          = $(this).attr('data-img-id');

            if(product_id != "" && img_id != ""){

              if(confirm("Are you sure?")){
                $.ajax({
                    url: "{{ route('admin.brand.delete-image') }}",
                    type: "GET",
                    data: {
                        brand_id: product_id,
                        img_id: img_id
                    },
                    success: function(data) {
                        console.log(data);
                    }
                })
              }
              
            }
          });
        }  
        ImgUpload();
    });
</script>

@endsection
