<div class="container-fluid mt-3" >
    <div class="row --product-row">
        <div class="col-md-11 product-detail product-detail-{{$product_detail->id}} slector-number-{{$selector_number}}" id="product-detail-{{$product_detail->id}}">
            <div class="card card_product_order mb-1 mt-1">
                <div class="card-header collapsed collapse-href" data-toggle="collapse" href="#collapse-{{$selector_number}}" style="background-color: #eee;">
                    <a class="card-title">
                        {{$product_detail->name}}
                    </a>
                </div>
                <div id="collapse-{{$selector_number}}" class="card-body collapse collapse-id" data-parent="#accordion" >
                    <input type="hidden" name="product_code[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2" id="product_code" placeholder=""value="{{$product_detail->code}}">
                    <input type="hidden" name="products_name[{{$product_detail->id}}]" class="form-control mb-2 mr-sm-2" id="products_name" placeholder=""value="{{$product_detail->name}}">
                    <div id="cloneDev">
                        @if(count($order_product_variants) > 0)
                        @foreach ($order_product_variants as $chunk_order_product_variant)
                            @php
                               $order_sizes_arr         = [];
                               $order_clrs_arr          = [];
                            @endphp
                            @foreach ($chunk_order_product_variant as $order_product_variant)
                                @php
                                    $chunk_attr2_id                                  = $order_product_variant->attribute2_id;
                                    $chunk_attr1_id                                  = $order_product_variant->attribute1_id;
                                    if($chunk_attr2_id != ""){
                                        $order_sizes_arr["sizes"][$chunk_attr2_id]   = $chunk_attr2_id;
                                        $order_sizes_arr["pieces"][$chunk_attr2_id]  = $order_product_variant->pieces;
                                        $order_sizes_arr["prices"][$chunk_attr2_id]  = $order_product_variant->price;
                                    }
                                    if($chunk_attr1_id != ""){
                                        $order_clrs_arr["colors"][$chunk_attr1_id]   = $chunk_attr1_id;
                                    }
                                @endphp
                            @endforeach
                            <div class="row ">
                                <div class="col-md-11">
                                    <div class="form-row ">
                                        @if (count($product_detail->ProductVariant)>0)
                                            @foreach ($product_detail->ProductVariant as $ProductVariant)
                                            @php
                                                if($ProductVariant->name == "Color"){
                                                    $name   = "attribute_color[$product_detail->id][$terminator][$ProductVariant->id][]";
                                                }elseif($ProductVariant->name == "Adult_sizes Size"){
                                                    $name   = "attribute_size[$product_detail->id][$terminator][$ProductVariant->id][]";
                                                }
                                            @endphp
                                                @if ($ProductVariant->name == "Color")
                                                    <div class="form-group col-md-2">
                                                        {{-- <label>@if($ProductVariant->name != "Color") {{ "Youth-Adult Size" }} @else {{ $ProductVariant->name }} @endif</label> --}}
                                                        <select type="text" data-product_id="{{$product_detail->id}}" name="{{$name}}"
                                                        class="form-control select-one --update-name attribute {{ ($ProductVariant->name == "Color") ? "v1_attr_id" : "v2_attr_id" }}" data-selector="{{$terminator}}">
                                                            <option value="">Color</option>
                                                            @if (count($ProductVariant->Atrributes)>0)
                                                                @foreach ($ProductVariant->Atrributes->sortBy('name')->values() as $Atrribute)
                                                                <option id="customRadioInline-{{$Atrribute->id}}"   value="{{$Atrribute->id}}" @if(in_array($Atrribute->id, $order_clrs_arr["colors"])) {{ "selected" }} @endif>{{$Atrribute->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                @else
                                                @if (count($ProductVariant->Atrributes)>0)
                                                @php
                                                    $name   = "attribute_size[$product_detail->id][$terminator][$ProductVariant->id][]";
                                                @endphp
                                                        @foreach ($ProductVariant->Atrributes as $Atrribute)
                                                        @php
                                                            $attr_size_v    = "";
                                                            $attr_piece_v   = "";
                                                            if(in_array($Atrribute->id, $order_sizes_arr["sizes"])){
                                                                $attr_size_v        = $Atrribute->id;
                                                                $attr_piece_v       = $order_sizes_arr["pieces"][$Atrribute->id];
                                                            }
                                                            
                                                        @endphp
                                                        <div class=" form-group col-md-1">
                                                            <input type="hidden" class="form-control mb-2 mr-sm-2 --new-size-attr" name="{{$name}}"  value="{{$attr_size_v}}">
                                                            <input type="text" data-product_id="{{$product_detail->id}}" name="pieces[{{$product_detail->id}}][{{$terminator}}][]" class="form-control select-one --update-name attribute pieces {{ ($ProductVariant->name == "Color") ? "v1_attr_id" : "v2_attr_id" }}" data-selector="{{$terminator}}" placeholder="{{$Atrribute->name}}" data-attr-id="{{$Atrribute->id}}" value="{{$attr_piece_v}}">
                                                        </div> 
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-1 float-right" style="margin-top: 10px;">
                                    <i type="submit" class="fas fa-plus add_product" style="color:green;cursor:pointer;" data-add_product="{{$product_detail->id}}" data-product_id="{{$product_detail->id}}" style="max-width: 114px;max-height: 47px;margin-top: 25px;
                                    "></i>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <i  id='remove_product' class="fas fa-minus" style="color:red;cursor:pointer;" data-remove_product="{{$product_detail->id}}" data-product_id="{{$product_detail->id}}"style="max-width: 114px;max-height: 47px;margin-top: 25px;
                                    margin-left: 5px;"></i>
                                </div>
                                <div class="col-md-11">
                                    <div class="form-row ">
                                        @if (count($product_detail->ProductVariant)>0)
                                            @foreach ($product_detail->ProductVariant as $ProductVariant)
                                                @if ($ProductVariant->name == "Color")
                                                
                                            
                                                    @php
                                                        if($ProductVariant->name == "Color"){
                                                            $name   = "attribute_color[$product_detail->id][$terminator][$ProductVariant->id][]";
                                                        }elseif($ProductVariant->name == "Adult_sizes Size"){
                                                            $name   = "attribute_size[$product_detail->id][$terminator][$ProductVariant->id][]";
                                                        }
                                                            
                                                    @endphp
                                                    <div class="form-group col-md-2">
                                                        
                                                    </div>
                                                @else
                                                @if (count($ProductVariant->Atrributes)>0)
                                                        @foreach ($ProductVariant->Atrributes as $Atrribute)
                                                        @php
                                                            $attr_price_v   = "";
                                                            if(in_array($Atrribute->id, $order_sizes_arr["sizes"])){
                                                                $attr_price_v       = $order_sizes_arr["prices"][$Atrribute->id];
                                                            }
                                                        @endphp
                                                        <div class="form-group col-md-1">
                                                            <input type="text" value="{{ $attr_price_v }}"  name="price[{{$product_detail->id}}][{{$terminator}}][]" class="form-control mb-2 mr-sm-2 price-{{$Atrribute->id}} price --update-name" id="price" placeholder="Price">
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                        <div class="row ">
                            <div class="col-md-11">
                                <div class="form-row ">
                                    @if (count($product_detail->ProductVariant)>0)
                                        @foreach ($product_detail->ProductVariant as $ProductVariant)
                                        @php
                                            if($ProductVariant->name == "Color"){
                                                $name   = "attribute_color[$product_detail->id][$terminator][$ProductVariant->id][]";
                                            }elseif($ProductVariant->name == "Adult_sizes Size"){
                                                $name   = "attribute_size[$product_detail->id][$terminator][$ProductVariant->id][]";
                                            }
                                        @endphp
                                            @if ($ProductVariant->name == "Color")
                                                <div class="form-group col-md-2">
                                                    {{-- <label>@if($ProductVariant->name != "Color") {{ "Youth-Adult Size" }} @else {{ $ProductVariant->name }} @endif</label> --}}
                                                    <select type="text" data-product_id="{{$product_detail->id}}" name="{{$name}}"
                                                    class="form-control select-one --update-name attribute {{ ($ProductVariant->name == "Color") ? "v1_attr_id" : "v2_attr_id" }}" data-selector="{{$terminator}}">
                                                        <option value="">Color</option>
                                                        @if (count($ProductVariant->Atrributes)>0)
                                                            @foreach ($ProductVariant->Atrributes->sortBy('name')->values() as $Atrribute)
                                                            <option id="customRadioInline-{{$Atrribute->id}}"   value="{{$Atrribute->id}}" >{{$Atrribute->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            @else
                                            @if (count($ProductVariant->Atrributes)>0)
                                            @php
                                                $name   = "attribute_size[$product_detail->id][$terminator][$ProductVariant->id][]";
                                            @endphp
                                                    @foreach ($ProductVariant->Atrributes as $Atrribute)
                                                    <div class=" form-group col-md-1">
                                                        <input type="hidden" class="form-control mb-2 mr-sm-2 --new-size-attr" name="{{$name}}"  value="">
                                                        <input type="text" data-product_id="{{$product_detail->id}}" name="pieces[{{$product_detail->id}}][{{$terminator}}][]" class="form-control select-one --update-name attribute pieces {{ ($ProductVariant->name == "Color") ? "v1_attr_id" : "v2_attr_id" }}" data-selector="{{$terminator}}" placeholder="{{$Atrribute->name}}" data-attr-id="{{$Atrribute->id}}">
                                                    </div> 
                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-1 float-right" style="margin-top: 10px;">
                                <i type="submit" class="fas fa-plus add_product" style="color:green;cursor:pointer;" data-add_product="{{$product_detail->id}}" data-product_id="{{$product_detail->id}}" style="max-width: 114px;max-height: 47px;margin-top: 25px;
                                "></i>&nbsp;&nbsp;&nbsp;&nbsp;
                                <i  id='remove_product' class="fas fa-minus" style="color:red;cursor:pointer;" data-remove_product="{{$product_detail->id}}" data-product_id="{{$product_detail->id}}"style="max-width: 114px;max-height: 47px;margin-top: 25px;
                                margin-left: 5px;"></i>
                            </div>
                            <div class="col-md-11">
                                <div class="form-row ">
                                    @if (count($product_detail->ProductVariant)>0)
                                        @foreach ($product_detail->ProductVariant as $ProductVariant)
                                            @if ($ProductVariant->name == "Color")
                                            
                                        
                                                @php
                                                    if($ProductVariant->name == "Color"){
                                                        $name   = "attribute_color[$product_detail->id][$terminator][$ProductVariant->id][]";
                                                    }elseif($ProductVariant->name == "Adult_sizes Size"){
                                                        $name   = "attribute_size[$product_detail->id][$terminator][$ProductVariant->id][]";
                                                    }
                                                        
                                                @endphp
                                                <div class="form-group col-md-2">
                                                    
                                                </div>
                                            @else
                                            @if (count($ProductVariant->Atrributes)>0)
                                                    @foreach ($ProductVariant->Atrributes as $Atrribute)
                                                    <div class="form-group col-md-1">
                                                        <input type="text" value=""  name="price[{{$product_detail->id}}][{{$terminator}}][]" class="form-control mb-2 mr-sm-2 price-{{$Atrribute->id}} price --update-name" id="price" placeholder="Price">
                                                    </div>
                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1">
            <i type="submit" class="fas fa-plus mt-4 --add-product" style="color:green;cursor:pointer;"  style="max-width: 114px;max-height: 47px;margin-top: 25px;" data-id="{{$product_detail->id}}" data-selector="{{$terminator}}"></i>
            <i  class="fas fa-minus mt-4 --remove-product" style="color:red;cursor:pointer;" style="max-width: 114px;max-height: 47px;margin-top: 25px; margin-left: 5px;" data-id="{{$product_detail->id}}" data-selector="{{$terminator}}"></i>
        </div>
    </div>
<div class="row">
</div>
</div>
