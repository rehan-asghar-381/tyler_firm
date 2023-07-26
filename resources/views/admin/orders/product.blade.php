<div class="container-fluid mt-3" >
    <div class="row">
        <div class="col-md-9  product-detail product-detail-{{$product_detail->id}}" id="product-detail-{{$product_detail->id}}">
            <div class="card card_product_order mb-4 mt-4">
                <div class="card-header collapsed" data-toggle="collapse" href="#collapse-{{$product_detail->id}}" style="background-color: #eee;">
                    <a class="card-title">
                        {{$product_detail->name}} {{ " [".$product_detail->code."]" }}
                    </a>
                </div>
                <div id="collapse-{{$product_detail->id}}" class="card-body collapse" data-parent="#accordion" >
                    <input type="hidden" name="product_code[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2" id="product_code" placeholder=""value="{{$product_detail->code}}">
                    <input type="hidden" name="products_name[{{$product_detail->id}}]" class="form-control mb-2 mr-sm-2" id="products_name" placeholder=""value="{{$product_detail->name}}">

                    <div id="cloneDev">
                        @if(count($order_product_variants) > 0)
                        @foreach ($order_product_variants as $order_product_variant)
                        <div class="row ">
                            <div class="col-md-11">
                                <div class="form-row ">
                                    @if (count($product_detail->ProductVariant)>0)
                                        @foreach ($product_detail->ProductVariant as $ProductVariant)
                                            <div class="form-group col-md-3">
                                                <label>{{$ProductVariant->name}}</label>
                                                @php
                                                    if($ProductVariant->name == "Color"){
                                                        $name               = "attribute_color[$product_detail->id][$ProductVariant->id][]";
                                                        $order_attr_id      = $order_product_variant->attribute1_id;
                                                    }else{
                                                        $name               = "attribute_size[$product_detail->id][$ProductVariant->id][]";
                                                        $order_attr_id      = $order_product_variant->attribute2_id;
                                                    }
                                                    
                                                @endphp
                                                <select type="text" data-product_id="{{$product_detail->id}}" name="{{$name}}"
                                                class="form-control select-one attribute {{ ($ProductVariant->name == "Color") ? "v1_attr_id" : "v2_attr_id" }}" >
                                                    <option value="">Select</option>
                                                    @if (count($ProductVariant->Atrributes)>0)
                                                        @foreach ($ProductVariant->Atrributes as $Atrribute)
                                                        <option id="customRadioInline-{{$Atrribute->id}}"   value="{{$Atrribute->id}}" @if($order_attr_id == $Atrribute->id) {{"selected"}} @endif>{{$Atrribute->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class=" form-group col-md-2">
                                        <label class="mr-2" for="pieces">Pieces </label>
                                        <input type="number" name="pieces[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2 pieces" id="pieces" placeholder="Pieces" min="1" value="{{$order_product_variant->pieces}}">
                                    </div> 
                                    <div class="form-group col-md-2">
                                        <label class="mr-3" for="price">Price</label>
                                        <input type="hidden" class="form-control mb-2 mr-sm-2 inc-lusive-price"  value="{{$product_detail->inclusive_price}}">
                                        <input type="number" value="{{$order_product_variant->price}}"  name="price[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2 price" id="price" placeholder="Price">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="mr-3" for="total">Total </label>
                                        <input type="number" name="total[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2 total" id="total" readonly="" step="any" placeholder="Total" value="{{$order_product_variant->total}}" >
                                    </div>   
                                </div>
                            </div>
                            <div class="col-md-1 float-right" style="margin-top: 40px;">
                                <i type="submit" class="fas fa-plus add_product" style="color:green;cursor:pointer;" data-add_product="{{$product_detail->id}}" data-product_id="{{$product_detail->id}}" style="max-width: 114px;max-height: 47px;margin-top: 25px;
                                "></i>&nbsp;&nbsp;&nbsp;&nbsp;
                                <i  id='remove_product' class="fas fa-minus" style="color:red;cursor:pointer;" data-remove_product="{{$product_detail->id}}" data-product_id="{{$product_detail->id}}"style="max-width: 114px;max-height: 47px;margin-top: 25px;
                                margin-left: 5px;"></i>
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
                                                    $name   = "attribute_color[$product_detail->id][$ProductVariant->id][]";
                                                }else{
                                                    $name   = "attribute_size[$product_detail->id][$ProductVariant->id][]";
                                                }
                                                    
                                            @endphp
                                            <div class="form-group col-md-3">
                                                <label>{{$ProductVariant->name}}</label>
                                                <select type="text" data-product_id="{{$product_detail->id}}" name="{{$name}}"
                                                class="form-control select-one attribute {{ ($ProductVariant->name == "Color") ? "v1_attr_id" : "v2_attr_id" }}" >
                                                    <option value="">Select</option>
                                                    @if (count($ProductVariant->Atrributes)>0)
                                                        @foreach ($ProductVariant->Atrributes as $Atrribute)
                                                        <option id="customRadioInline-{{$Atrribute->id}}"   value="{{$Atrribute->id}}" >{{$Atrribute->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class=" form-group col-md-2">
                                        <label class="mr-2" for="pieces">Pieces </label>
                                        <input type="number" name="pieces[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2 pieces" id="pieces" placeholder="Pieces" min="1" value="">
                                    </div> 
                                    <div class="form-group col-md-2">
                                        <label class="mr-3" for="price">Price</label>
                                        <input type="hidden" class="form-control mb-2 mr-sm-2 inc-lusive-price"  value="{{$product_detail->inclusive_price}}">
                                        <input type="number" value=""  name="price[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2 price" id="price" placeholder="Price">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="mr-3" for="total">Total </label>
                                        <input type="number" name="total[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2 total" id="total" readonly="" step="any" placeholder="Total" value="" >
                                    </div>   
                                </div>
                            </div>
                            <div class="col-md-1 float-right" style="margin-top: 40px;">
                                <i type="submit" class="fas fa-plus add_product" style="color:green;cursor:pointer;" data-add_product="{{$product_detail->id}}" data-product_id="{{$product_detail->id}}" style="max-width: 114px;max-height: 47px;margin-top: 25px;
                                "></i>&nbsp;&nbsp;&nbsp;&nbsp;
                                <i  id='remove_product' class="fas fa-minus" style="color:red;cursor:pointer;" data-remove_product="{{$product_detail->id}}" data-product_id="{{$product_detail->id}}"style="max-width: 114px;max-height: 47px;margin-top: 25px;
                                margin-left: 5px;"></i>
                            </div>
                        </div>



                        @endif
                        
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
</div>
</div>
