@php
    // dd($product_detail->ProductVariant);
@endphp
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
                        <div class="row ">
                            <div class="col-md-9" >
                                <div class="form-row ">
                                    @if (count($product_detail->ProductVariant)>0)
                                    @foreach ($product_detail->ProductVariant as $ProductVariant)
                                    <div class="form-group col-md-3">
                                        <label>{{$ProductVariant->name}}</label>
                                        <select type="text" name="attribute_id[{{$product_detail->id}}][{{$ProductVariant->id}}][]"
                                          class="form-control " >
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
                                    <input type="number" onkeyup="setTotal(this);" onchange="setTotal(this);" name="pieces[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2 pieces" id="pieces" placeholder="Pieces" min="1" value="1">
                                </div> 
                                <div class="form-group col-md-2">
                                    <label class="mr-3" for="price">Price</label>
                                    <input type="hidden" class="form-control mb-2 mr-sm-2 inc-lusive-price"  value="{{$product_detail->inclusive_price}}">
                                    <input type="number" name="price[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2 price" id="price" placeholder="Price" onchange="setTotal(this);"  onkeyup="setTotal(this);" value="" 
                                    {{-- value="{{$product_detail->inclusive_price}}"  --}}
                                    >
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="mr-3" for="total">Total </label>
                                    <input type="number" name="total[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2 total" id="total" readonly="" placeholder="Total" value="" >
                                </div>   
                            </div>
                        </div>
                        <div class="col-md-3 float-right">
                            <button type="submit" id='add_product' class="btn btn-success mb-3 " data-add_product="{{$product_detail->id}}" style="max-width: 114px;max-height: 47px;margin-top: 25px;
                            "> Add more</button>
                            <button type="submit" id='remove_product' class="btn btn-primary mb-3 " data-remove_product="{{$product_detail->id}}" style="max-width: 114px;max-height: 47px;margin-top: 25px;
                            margin-left: 5px;"> Remove</button>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    </div>
</div>
