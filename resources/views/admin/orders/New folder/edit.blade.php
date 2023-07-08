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
      padding: 40px;
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
@php
    $measurement_text       = ($order->measurement == 'cms')? 'cms': 'Inches'; 
@endphp
<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Edit Order {{$order->order_tag ? "[".$order->order_tag."]" : ""}}</h6>
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
            <form  method="POST" action="{{ route('admin.order.update', $order->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="upload__box">
                    <div class="upload__btn-box">
                      <label class="upload__btn">
                        <p>Upload images</p>
                        <input type="file" name="filePhoto[]" multiple="" data-max_length="20" class="upload__inputfile">
                      </label>
                    </div>
                    <div class="upload__img-wrap">
                      @if(count($order->OrderImgs) > 0)
                      @foreach($order->OrderImgs as $key=>$OrderImg)
                      <div class='upload__img-box'>
                        <div style='background-image: url("{{asset($OrderImg->image)}}")' data-number='{{ $key }}' data-file='" + f.name + "' class='img-bg'>
                          <div class='upload__img-close' data-order-id='{{ $order->id }}' data-img-id='{{ $OrderImg->id }}'></div>
                        </div>
                      </div>
                      @endforeach
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Order Type</label>
                        <select type="text" name="order_type" id="order_type" class="form-control require" value="" required="">
                            <option value="">--select--</option>
                            @foreach ($order_types as $order_type)
                                <option value="{{ $order_type->id }}" @if($order->order_type == $order_type->id) {{ "selected" }} @endif>{{ $order_type->name }}</option>
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
                                            <input class="form-check-input  shadow-none" type="radio" name="measurement_type" value="Inches" @if($order->measurement_type == 'Inches') {{ "checked" }} @endif >
                                            <span class="checkmark"></span>
                                            <label class="" for="">
                                                Inches
                                            </label>
                                        </div>
                                    </div>
                                                                        
                                                                                                                                                            <div class="col-md-6">
                                        <div class="form-check mb-3 hover-text">
                                            <input class="form-check-input  shadow-none" type="radio" name="measurement_type" value="cms" @if($order->measurement_type == 'cms') {{ "checked" }} @endif>
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
                        <textarea class="form-control require" name="description" id="" required="">{{ $order->description }}</textarea>
                    </div>
                    
                </div>
                <h3 class="" style="margin-top:20px;">Body Measurements</h3>
                <div class="row">
                    
                    <div class="col-md-3">
                        <label>Shop size</label>
                        <select type="text" name="title" id="title" class="form-control require" value="">
                            <option value="">--select--</option>
                            @foreach ($shop_sizes as $shop_size)
                                <option value="{{ $shop_size->name }}"  @if($order->title == $shop_size->name) {{ "selected" }} @endif>{{ $shop_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>High Bust</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field1_hb" class="form-control require" value="{{ $order->field1_hb }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Bust/Chest</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field2_b" class="form-control require required-online" value="{{ $order->field2_b }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Waist</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field3_w" class="form-control require required-online" value="{{ $order->field3_w }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>High Hip</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field4_hh" class="form-control require" value="{{ $order->field4_hh }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Hip </label>
                        <div class="input-group">
                        <input type="number" step="any" name="field5_h" class="form-control require required-online" value="{{ $order->field5_h }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field6_sh" class="form-control require" value="{{ $order->field6_sh }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>1/2 Shoulder</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field7_half_sh" class="form-control require" value="{{ $order->field7_half_sh }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Waist </label>
                        <div class="input-group">
                        <input type="number" step="any" name="field8_sh_w" class="form-control require" value="{{ $order->field8_sh_w }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - High Hip </label>
                        <div class="input-group">
                        <input type="number" step="any" name="field20_sh_hh" class="form-control require" value="{{ $order->field20_sh_hh }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Knee</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field9_sh_kn" class="form-control require" value="{{ $order->field9_sh_kn }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Ground</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field10_sh_g" class="form-control require" value="{{ $order->field10_sh_g }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Waist - Knee</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field11_w_kn" class="form-control require" value="{{ $order->field11_w_kn }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Waist - Ground</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field12_w_g" class="form-control require" value="{{ $order->field12_w_g }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Arm</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field13_arm" class="form-control require" value="{{ $order->field13_arm }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>1/2Arm</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field14_half_arm" class="form-control require" value="{{ $order->field14_half_arm }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Armhole Depth</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field15_arm_depth" class="form-control require" value="{{ $order->field15_arm_depth }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Bicep</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field16_bicep" class="form-control require" value="{{ $order->field16_bicep }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Wrist</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field17_wrist" class="form-control require" value="{{ $order->field17_wrist }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Waist (front)</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field18_sh_w" class="form-control require" value="{{ $order->field18_sh_w }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Thigh</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field19_tw" class="form-control require" value="{{ $order->field19_tw }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="mb-4 down-line">Additional Fields</h3>
                @if(count($order->AdditionalFields) > 0)
                  @foreach($order->AdditionalFields as $additional_field)

                    <div class="field-p">
                      <div class="row field-info">
                          <div class="col-md-3">
                              <label>Label</label>
                              <input type="text" name="labels[]" class="form-control require" value="{{ $additional_field->label }}" required="">
                          </div>
                          <div class="col-md-3">
                            <label>Value</label>
                            <input type="number" step="any" name="fields[]" class="form-control require" value="{{ $additional_field->value }}" required="">
                        </div>
                          <div class="col-md-4" style="margin-top: 2rem!important;">
                              <button type="button" class="btn btn-success mb-3 add-field-row">Add more</button>
                              <button type="button" class="btn btn-danger mb-3 remove-field-row">Remove</button>
                          </div>
                      </div>
                    </div>
                  @endforeach
                @else
                <div class="field-p">
                  <div class="row field-info">
                      <div class="col-md-3">
                          <label>Label</label>
                          <input type="text" name="labels[]" class="form-control require" value="" required="">
                      </div>
                      <div class="col-md-3">
                        <label>Value</label>
                        <input type="number" step="any" name="fields[]" class="form-control require" value="" required="">
                    </div>
                      <div class="col-md-4" style="margin-top: 2rem!important;">
                          <button type="button" class="btn btn-success mb-3 add-field-row">Add more</button>
                          <button type="button" class="btn btn-danger mb-3 remove-field-row">Remove</button>
                      </div>
                  </div>
                </div>
                @endif
                
                <h3 class="mb-4 down-line">Supplies</h3>
                @if(count($order->OrderSupply) > 0)
                <div class="supply-p">
                  @foreach($order->OrderSupply as $OrderSupply)
                      <div class="row supply-info">
                          <div class="col-md-3">
                              <label>Item</label>
                              <select type="text" name="suply_info[]" id="title" class="form-control require select-supply" value="">
                                <option value="">--select--</option>
                                @foreach ($inventory_items as $inventory_item)
                                    <option value="{{$inventory_item->item_slug }}" @if($OrderSupply->SupplyInventoryItem->item_slug == $inventory_item->item_slug) {{ "selected" }} @endif>{{ $inventory_item->item }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="col-md-2">
                            <label>Available Quantity</label>
                            <input type="number" class="form-control available_quantity" value="" readonly>
                        </div>
                          <div class="col-md-3">
                            <label>Quantity</label>
                            <input type="number" name="quantity[]" class="form-control require" value="{{ $OrderSupply->quantity }}" required="">
                          </div>
                          <div class="col-md-4" style="margin-top: 2rem!important;">
                              <button type="button" class="btn btn-success mb-3 add-supply-row">Add more</button>
                              <button type="button" class="btn btn-danger mb-3 remove-supply-row">Remove</button>
                          </div>
                      </div>
                    
                  @endforeach
                </div>
                @else
                <div class="supply-p">
                    <div class="row supply-info">
                        <div class="col-md-6">
                            <label>Item</label>
                            <select type="text" name="suply_info[]" id="title" class="form-control require select-supply" value="">
                            <option value="">--select--</option>
                            @foreach ($inventory_items as $inventory_item)
                                <option value="{{$inventory_item->item_slug }}" @if($OrderSupply->SupplyInventoryItem->item_slug == $inventory_item->item_slug) {{ "selected" }} @endif>{{ $inventory_item->item }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="col-md-2">
                            <label>Available Quantity</label>
                            <input type="number" class="form-control available_quantity" value="" readonly>
                        </div>
                        <div class="col-md-2">
                            <label>Quantity</label>
                            <input type="number" name="quantity[]" class="form-control require" value="" required="">
                        </div>
                        <div class="col-md-4" style="margin-top: 2rem!important;">
                            <button type="button" class="btn btn-success mb-3 add-supply-row">Add more</button>
                            <button type="button" class="btn btn-danger mb-3 remove-supply-row">Remove</button>
                        </div>
                    </div>
                </div>
                @endif
                <h3 class="mb-4 down-line">Schedule</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Order Date: </label>&nbsp;&nbsp;&nbsp;
                            <div class="input-group date">
                              <input type="text" name="order_date" class="form-control require flatpickr" value="{{ $order->order_date }}" required="">
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
                                <input type="text" name="collection_date" class="form-control require flatpickr" value="{{ $order->collection_date }}" required="">
                                <div class="input-group-addon input-group-append">
									<div class="input-group-text">
										<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="mb-4 down-line">Till</h3>
                <div class="row">
                    <div class="col-md-2">
                        <label>Selling Price</label>
                        <input type="number" name="selling_price" class="form-control require selling_price" value="{{ $order->OrderTill->selling_price ?? "" }}">
                    </div>
                    <div class="col-md-2">
                        <label>Deposit</label>
                        <input type="number" name="deposit" class="form-control require deposit" value="{{ $order->OrderTill->deposit ?? "" }}">
                    </div>
                    <div class="col-md-2">
                        <label>Balance</label>
                        <input type="number" name="balance" class="form-control require balance" value="{{ $order->OrderTill->balance ?? "" }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label>Payment Type</label>
                        <select type="text" name="payment_type" id="payment_type" class="form-control require" value="" >
                            <option value="">--select--</option>
                            @foreach ($payments_types as $payments_type)
                                <option value="{{ $payments_type->id }}" @if($payments_type->id == (isset($order->OrderTill->payment_type)) ?$order->OrderTill->payment_type:"") {{ "selected" }} @endif>{{ $payments_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <h3 class="mb-4 down-line">Additional Info</h3>
                <div class="form-row">
                    <div class="col-md-9">
                        <label>Comments</label>
                        <textarea class="form-control require" name="tailor_comments" id="" required="">{{ $order->tailor_comments }}</textarea>
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
        var init_supply                 = 1;
        var supply_info_template         = $(".supply-info:first").clone();
        var supply_info_parent           = $(".supply-p");

        $(document).on('click', '.add-supply-row', function(event) {
            supply_info_template.find("span.select2").remove();
            var new_supply_info_template = supply_info_template.clone();
            event.preventDefault();
            new_supply_info_template.find("select").select2({
                tags: true
            });
            supply_info_parent.append(new_supply_info_template);
            new_supply_info_template.find('input').val(null);
            new_supply_info_template.find('select').val(null);
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
        var field_template         = $(".field-info").clone();
        var field_parent           = $(".field-p");

        $(document).on('click', '.add-field-row', function(event) {
            var new_field_template = field_template.clone()
            event.preventDefault();

            field_parent.append(new_field_template);
            new_field_template.find('select').val(null);
            new_field_template.find('input').val(null);
            init_field++;
        });
        $(document).on('click', '.remove-field-row', function(e) {

            e.preventDefault();
            if(init_field > 1){
                $(this).closest('.field-info').remove();
                init_field--; //Decrement field counter
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

            var order_id        = $(this).attr('data-order-id');
            var img_id          = $(this).attr('data-img-id');

            if(order_id != "" && img_id != ""){

              if(confirm("Are you sure?")){
                $.ajax({
                    url: "{{ route('admin.order.delete-image') }}",
                    type: "GET",
                    data: {
                        order_id: order_id,
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

        $('.supply-info').each(function(){

            var item        = $(this).find('.select-supply').val();
            var available_quantity  = _get_available_quantity(item);
            $(this).find('.available_quantity').val(available_quantity);
        });
        function _get_available_quantity(item){
            var available_quantity      = 0;
            $.ajax({
            async:false,
            url: "{{ route('admin.supply.get_available_qty') }}",
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
            return available_quantity;
        }
        $(document).on('change', '.select-supply', function(){

            var item            = $(this).val();
            var available_quantity  = _get_available_quantity(item);
            $(this).closest('.supply-info').find('.available_quantity').val(available_quantity);

        });
        $(document).on('change', '.selling_price, .deposit', function(){

            var selling_price               = parseInt($('.selling_price').val());
            var deposit                     = parseInt($('.deposit').val());
            var balance                     = 0;

            balance                         = deposit-selling_price;

            $('.balance').val(balance);

        });
    });
</script>

@endsection
