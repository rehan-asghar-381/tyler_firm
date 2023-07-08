@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.btn-d-none{
    display: none;
}
.has-error{
    border: 1px solid red;
}
.upload__box {
    padding: 20px 0px;
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
    padding: 5px;
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
      width: 200px;
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
                    <h6 class="fs-17 font-weight-600 mb-0">Create Order</h6>
                </div>
                <div class="text-right">
                    
                </div>
            </div>
        </div>
        <div class="card-body">
           
            @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <form  method="POST" action="{{ route('admin.order.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Client</label>
                        <select type="text" name="client_id" id="client_id" class="form-control require required-online" value="" >
                            <option value="">--select--</option>
                            <option value="new">Add New Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->first_name." ".$client->last_name." (".$client->email.")" }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Order Item</label>
                        <select type="text" name="order_tags[]" multiple id="order_tags" class="form-control require required-online" value="" >

                        </select>
                    </div>
                </div>
                <div class="row client-form btn-d-none">
                    @include('admin.clients.add-client', ['errors'=>$errors])
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Order Type</label>
                        <select type="text" name="order_type" id="order_type" class="form-control require required-online" value="" >
                            <option value="">--select--</option>
                            @foreach ($order_types as $order_type)
                                <option value="{{ $order_type->id }}">{{ $order_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col">
                        <div class="form-group">
                            <div class="roles_titles mt-4">Measurement Type</div>
                            <div class="water-check-boxs">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-3 hover-text">
                                            <input class="form-check-input  shadow-none" type="radio" name="measurement_type" value="Inches" checked>
                                            <span class="checkmark"></span>
                                            <label class="" for="">
                                                Inches
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-3 hover-text">
                                            <input class="form-check-input  shadow-none" type="radio" name="measurement_type" value="cms">
                                            <span class="checkmark"></span>
                                            <label class="" for="">
                                                cms
                                            </label>
                                        </div>
                                    </div>                                     
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea class="form-control require" name="description" id="" ></textarea>
                    </div>
                    
                </div>
                <h3 class="" style="margin-top:20px;">Body Measurements</h3>
                <div class="row">
                    
                    <div class="col-md-3">
                        <label>Shop size</label>
                        <select type="text" name="title" id="title" class="form-control" value="">
                            <option value="">--select--</option>
                            @foreach ($shop_sizes as $shop_size)
                                <option value="{{ $shop_size->name }}">{{ $shop_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        
                        <label>High Bust</label>
                        <div class="input-group">
                            <input type="number" step="any" name="field1_hb" id="high_bust" class="form-control require" value="" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    Inches
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Bust/Chest</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field2_b" id="bust" class="form-control require required-online" value="" >
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Waist</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field3_w" id="waist" class="form-control require required-online" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>High Hip</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field4_hh" id="high_hip" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Hip </label>
                        <div class="input-group">
                        <input type="number" step="any" name="field5_h" id="hip" class="form-control require required-online" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field6_sh" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>1/2 Shoulder</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field7_half_sh" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Waist </label>
                        <div class="input-group">
                        <input type="number" step="any" name="field8_sh_w" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - High Hip </label>
                        <div class="input-group">
                        <input type="number" step="any" name="field20_sh_hh" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Knee</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field9_sh_kn" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Ground</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field10_sh_g" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Waist - Knee</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field11_w_kn" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Waist - Ground</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field12_w_g" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Arm</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field13_arm" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>1/2Arm</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field14_half_arm" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Armhole Depth</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field15_arm_depth" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Bicep</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field16_bicep" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Wrist</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field17_wrist" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Waist (front)</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field18_sh_w" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Thigh</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field19_tw" class="form-control require" value="" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                Inches
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="order-box-p">
                    <div class="order-box rh-0">
                        <div class="card mb-4 mt-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-4 down-line box-heading">Order box 1</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="upload__box">
                                    <div class="upload__btn-box">
                                        <label class="upload__btn">
                                        <p>Upload images</p>
                                        <input type="file" name="filePhoto[0][]" multiple="" data-max_length="20" class="upload__inputfile rh-filePhoto">
                                        </label>
                                    </div>
                                    <div class="upload__img-wrap"></div>
                                    </div>
                                </div>
                                <h6 class="mb-4 down-line">Additional Fields</h6>
                                <div class="field-p">
                                    <div class="row field-info">
                                        <div class="col-md-3">
                                            <label>Label</label>
                                            <input type="text" name="labels[0][]" class="form-control bg-light rh-label-name" value="" >
                                        </div>
                                        <div class="col-md-3">
                                        <label>Value</label>
                                        <input type="number" step="any" name="fields[0][]" class="form-control bg-light rh-fields" value="" >
                                    </div>
                                        <div class="col-md-4" style="margin-top: 2rem!important;">
                                            <button type="button" class="btn btn-success mb-3 add-field-row">Add more</button>
                                            <button type="button" class="btn btn-danger mb-3 remove-field-row">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="mb-4 down-line">Supplies</h6>
                                <div class="supply-p">
                                    <div class="row supply-info">
                                        <div class="col-md-3">
                                            <label>Item</label>
                                            <select type="text" name="suply_info[0][]" id="title" class="form-control require select-supply rh-suply-info" value="">
                                                <option value="">--select--</option>
                                                @foreach ($inventory_items as $inventory_item)
                                                    <option value="{{$inventory_item->item_slug }}">{{ $inventory_item->item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Available Quantity</label>
                                            <input type="number" class="form-control available_quantity" value="" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Quantity</label>
                                            <input type="number" name="quantity[0][]" class="form-control require rh-quantity" value="" required="">
                                        </div>
                                        <div class="col-md-3" style="margin-top: 2rem!important;">
                                            <button type="button" class="btn btn-success mb-3 add-supply-row">Add more</button>
                                            <button type="button" class="btn btn-danger mb-3 remove-supply-row">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="mb-4 down-line">Till</h6>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Selling Price</label>
                                        <input type="number" name="selling_price[0][]" class="form-control require selling_price rh-selling-price" value="">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Deposit</label>
                                        <input type="number" name="deposit[0][]" class="form-control require deposit rh-deposit" value="">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Balance</label>
                                        <input type="number" name="balance[0][]" class="form-control require balance rh-balance" value="" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Payment Type</label>
                                        <select type="text" name="payment_type[0][]" id="payment_type" class="form-control require rh-payment-type" value="" >
                                            <option value="">--select--</option>
                                            @foreach ($payments_types as $payments_type)
                                                <option value="{{ $payments_type->id }}">{{ $payments_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="mb-4 down-line">Schedule</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Order Date: </label>&nbsp;&nbsp;&nbsp;
                            <div class="input-group date">
                              <input type="text" name="order_date" class="form-control bg-light flatpickr require" value="" >
                              <div class="input-group-addon input-group-append">
                                <div class="input-group-text">
                                  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Collection Date: </label>&nbsp;&nbsp;&nbsp;
                            <div class="input-group date">
                                <input type="text" name="collection_date" class="form-control bg-light flatpickr require" value="" >
                                <div class="input-group-addon input-group-append">
									<div class="input-group-text">
										<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="mb-4 down-line">Additional Info</h3>
                <div class="form-row">
                    <div class="col-md-9">
                        <label>Comments</label>
                        <textarea class="form-control bg-light" name="tailor_comments" id="" ></textarea>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12 form-check">
                        <button type="submit" class="btn btn-primary mb-3" id="submit-form">Submit</button>
                    </div>
                </div
            </form>
        </div>
    </div>
</div>
@endsection
@section('footer-script')
<script>
    $(document).ready(function(){
        $('select').select2();
        $(".select-supply").select2({
            tags: true
        });
        $("#order_tags").select2({
            tags: true
        });
        var order_box_template         = $(".order-box").clone();
        var order_box_parent           = $(".order-box-p");
        $(document).on("change", "#order_tags", function(){

            var tags                = $(this).val();
            let heading             = "Details of "+tags[(tags.length)-1];
            if(tags.length == 1){
                $('.rh-0').find('.box-heading').text(heading);
                $('.rh-0').show();
                return  false;
            }else if(tags.length == 0){
                $('.rh-0').find('.box-heading').text('');
                $('.rh-0').hide();
                return  false;
            }

            let box_heading         = "Details of "+tags[(tags.length)-1];
            let filePhoto           = 'filePhoto['+((tags.length)-1)+'][]';
            let label_name          = 'labels['+((tags.length)-1)+'][]';
            let fields              = 'fields['+((tags.length)-1)+'][]';
            let suply_info          = 'suply_info['+((tags.length)-1)+'][]';
            let quantity            = 'quantity['+((tags.length)-1)+'][]';
            let selling_price       = 'selling_price['+((tags.length)-1)+'][]';
            let deposit             = 'deposit['+((tags.length)-1)+'][]';
            let balance             = 'balance['+((tags.length)-1)+'][]';
            let payment_type        = 'payment_type['+((tags.length)-1)+'][]';

            order_box_template.find("span.select2").remove();
            order_box_template.removeClass('rh-0');
            order_box_template.addClass('rh-'+((tags.length)-1));

            order_box_template.find('.box-heading').text(box_heading);
            order_box_template.find('.rh-filePhoto').attr('name', filePhoto);
            order_box_template.find('.rh-label-name').attr('name', label_name);
            order_box_template.find('.rh-fields').attr('name', fields);
            order_box_template.find('.rh-suply-info').attr('name', suply_info);
            order_box_template.find('.rh-quantity').attr('name', quantity);
            order_box_template.find('.rh-selling-price').attr('name', selling_price);
            order_box_template.find('.rh-deposit').attr('name', deposit);
            order_box_template.find('.rh-balance').attr('name', balance);
            order_box_template.find('.rh-payment-type').attr('name', payment_type);

            var new_order_box_template = order_box_template.clone()
            event.preventDefault();
            new_order_box_template.find("select").select2({
                tags: true
            });
            order_box_parent.append(new_order_box_template);
            ImgUpload('.rh-'+((tags.length)-1));

        });
        function required(seletor=""){

            let validated           = true;

            var order_type          = $('#order_type').val();
            if(order_type == ""){

                alert('Please select Order Type fisrt.');
                $('#order_type').addClass('has-error');
                validated   = false;

            }else{
                $('#order_type').removeClass('has-error');
                if(order_type == 2){

                    $(".require").each(function(key, value){
                        $(this).removeClass('has-error');
                    });

                    $(".required-online").each(function(key, value){
        
                        var value       = $(this).val();
                        if(value == "" || value == null){
                            
                            $(this).addClass('has-error');
                            validated   = false;

                        }else{

                            $(this).removeClass('has-error');
                            
                        }
                    });

                }else{
                    $(".require").each(function(key, value){
        
                        var value       = $(this).val();
                        if(value == "" || value == null){
                            
                            $(this).addClass('has-error');
                            validated   = false;
    
                        }else{
    
                            $(this).removeClass('has-error');
                            
                        }
                    });
                }
            }
            return validated;
        }

        $('#submit-form').click(function(event) {

            var validate = required();
            if (validate) {
                return true;
            }else{
                event.preventDefault();
            }

        });
        var init_supply                     = 1;
        

        $(document).on('click', '.add-supply-row', function(event) {
            var supply_info_template         = $(this).closest('.order-box').find(".supply-info").first().clone();
            var supply_info_parent           = $(this).closest('.order-box').find(".supply-p");
            
            supply_info_template.find("span.select2").remove();
            var new_supply_info_template = supply_info_template.clone();
            event.preventDefault();
            new_supply_info_template.find("select").select2({
                tags: true
            });
            supply_info_parent.append(new_supply_info_template);
            new_supply_info_template.find('input').val(null);
            init_supply++;
        });
        $(document).on('click', '.remove-supply-row', function(e) {

            e.preventDefault();
            if(init_supply > 1){
                $(this).closest('.supply-info').remove();
                init_supply--; //Decrement field counter
            }
            
        });

        var init_field                 = 1;
        $(document).on('click', '.add-field-row', function(event) {
            var field_template         = $(this).closest('.order-box').find(".field-info").first().clone();
            var field_parent           = $(this).closest('.order-box').find(".field-p");
            var new_field_template = field_template.clone()
            event.preventDefault();

            field_parent.append(new_field_template);
            init_field++;
        });
        $(document).on('click', '.remove-field-row', function(e) {

            e.preventDefault();
            if(init_field > 1){
                $(this).closest('.field-info').remove();
                init_field--; //Decrement field counter
            }
            
        });

        function ImgUpload(selector) {
          var imgWrap = "";
          var imgArray = [];

          $(selector+' .upload__inputfile').each(function () {
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
                      var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
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
          });
      }  

      ImgUpload('.rh-0');
      
      $(document).on('change', 'input[name=measurement_type]', function(){

          if($(this).is(':checked')){

            var measurement_type        = $(this).val();
            $('.rh-m-text').each(function(index, value){

                if(measurement_type == 'Inches'){

                    $(this).text('Inches');
                }else if(measurement_type == 'cms'){

                    $(this).text('cms');
                }
            });

        }
      });
      
      $(document).on('change', '#client_id', function(){
        var client_id       = $(this).val();

        if(client_id != 'new'){
            $('.client-form').addClass('btn-d-none');
            $.ajax({
                {{-- url: "{{ route('admin.client.get_detail') }}", --}}
                type: "GET",
                data: {
                    client_id: client_id
                },
                success: function(data) {

                    $('input[name=first_name]').val(data.first_name);
                    $('input[name=last_name]').val(data.last_name);
                    $('input[name=phone_number]').val(data.phone_number);
                    $('input[name=email]').val(data.email);   

                    $('input[name=first_name]').attr('readonly', true);
                    $('input[name=last_name]').attr('readonly', true);
                    $('input[name=phone_number]').attr('readonly', true);
                    $('input[name=email]').attr('readonly', true);
                    $('#add-client').addClass('btn-d-none');

                    get_client_recent_order(client_id);
                }
            });
            
        }else if(client_id == 'new'){

            $('.client-form').removeClass('btn-d-none');
            $('input[name=first_name]').val('');
            $('input[name=last_name]').val('');
            $('input[name=phone_number]').val('');
            $('input[name=email]').val('');

            read_only(true);
        }
      });
      function read_only(readonly=false){
        if(readonly){
            $('input[name=first_name]').attr('readonly', false);
            $('input[name=last_name]').attr('readonly', false);
            $('input[name=phone_number]').attr('readonly', false);
            $('input[name=email]').attr('readonly', false);

            $('#add-client').removeClass('btn-d-none');
        }else{
            $('input[name=first_name]').attr('readonly', true);
            $('input[name=last_name]').attr('readonly', true);
            $('input[name=phone_number]').attr('readonly', true);
            $('input[name=email]').attr('readonly', true);

            $('#add-client').addClass('btn-d-none');
        }
      }
      $(document).on("click", "#add-client", function(event){

        event.preventDefault();

        var first_name          = $('input[name=first_name]').val();
        var last_name           = $('input[name=last_name]').val();
        var phone_number        = $('input[name=phone_number]').val();
        var email               = $('input[name=email]').val();
          
        $.ajax({
                {{-- url: "{{ route('admin.client.add_client') }}", --}}
                type: "GET",
                data: {
                    first_name      : first_name,
                    last_name       : last_name,
                    phone_number    : phone_number,
                    email           : email
                },
                success: function(data) {
                    $('.client-form').html('');
                    $('.client-form').html(data);

                   if($('#client_return_id').val() != ""){

                       get_clients($('#client_return_id').val());
                   }
                    if($('#error_return').val() == ""){
                        setTimeout(function(){
                            console.log($('#client_return_id').val());
                            $('#client_id').val($('#client_return_id').val()).trigger("change");
                        }, 1000);
                    }
                }
            });
      });
      read_only();

      function get_clients(client_id){

        $.ajax({
            {{-- url: "{{ route('admin.client.get_client') }}", --}}
            type: "GET",
            data: {
                client_id      : client_id
            },
            success: function(data) {
                $('select[name=client_id]').html('');
                $('select[name=client_id]').html(data);
            }
        });

      }

      function get_client_recent_order(client_id){
        $.ajax({
            {{-- url: "{{ route('admin.order.get_client_recent_order') }}", --}}
            type: "GET",
            data: {
                client_id      : client_id
            },
            success: function(result) {
                result          = JSON.parse(result);
                if(result.status){
                    data        = result.data;
                    $.each(data, function(key, val){

                        if(key == 'measurement_type'){
                            $.each($('input[name='+key+']'), function(){
                                if($(this).val() == val){
                                    $(this).prop("checked", true);
                                    $(this).trigger('change');
                                }
                            });
                        }else if(key == 'title'){

                            $('#title').val(val).trigger('change');
                            
                        }else{

                            $('input[name='+key+']').val(val);
                        }
                    });
                    
                }
            }
        });
      }
      $(document).on('change', '.select-supply', function(){

            var item            = $(this).val();
            var available_quantity      = 0;
            $.ajax({
            async:false,
            {{-- url: "{{ route('admin.supply.get_available_qty') }}", --}}
            type: "GET",
            data: {
                item      : item
            },
            success: function(result) {
                result          = JSON.parse(result);
                console.log(result);
                if(result.status){
                   
                    available_quantity = result.available_qty;
                    
                }
            }
        });
        $(this).closest('.supply-info').find('.available_quantity').val(available_quantity);

        });
        $(document).on('change', '.selling_price, .deposit', function(){

            var selling_price               = parseInt($(this).closest('.order-box').find('.selling_price').val());
            var deposit                     = parseInt($(this).closest('.order-box').find('.deposit').val());
            var balance                     = 0;
           
            balance                         = deposit-selling_price;

            $(this).closest('.order-box').find('.balance').val(balance);

        });

        $('.rh-0').hide();
    });
    
</script>

@endsection
