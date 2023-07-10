@php
    // dd($product_detail->ProductVariant);
@endphp
<div class="">
    <div class="row ">
        <div class="col-md-8 offset-md-2 product-detail product-detail-{{$product_detail->id}}" id="product-detail-{{$product_detail->id}}">
            <div class="card card_product_order mb-4 mt-4">
                <div class="card-header collapsed" data-toggle="collapse" href="#collapse-{{$product_detail->id}}" style="background-color: #eee;">
                    <a class="card-title">
                        {{$product_detail->name}} {{ " [".$product_detail->code."]" }}
                    </a>
                </div>
                <div id="collapse-{{$product_detail->id}}" class="card-body collapse" data-parent="#accordion" >
                    <input type="hidden" name="product_code[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2" id="product_code" placeholder=""value="{{$product_detail->code}}">
                    <div id="cloneDev-{{$product_detail->id}}">
                        <div class="row clone-product-{{$product_detail->id}}">
                            <div class="col-md-12" >
                                <div class="form-row ">
                                    @if (count($product_detail->ProductVariant)>0)
                                    @foreach ($product_detail->ProductVariant as $ProductVariant)
                                    <div class="form-group col-md-4">
                                        <label>{{$ProductVariant->name}}</label>
                                        <select type="text" name="fp_attribute_id[{{$product_detail->id}}][{{$ProductVariant->id}}][]"
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
                                <div class="form-group col-md-4">
                                    <label class="mr-3" for="price">Price</label>
                                    <input type="hidden" class="form-control mb-2 mr-sm-2 inc-lusive-price"  value="{{$product_detail->inclusive_price}}">
                                    <input type="number" name="fp_price[{{$product_detail->id}}][]" class="form-control mb-2 mr-sm-2 " id="" placeholder="Enter Price" value="" 
                                     {{-- value="{{$product_detail->inclusive_price}}"  --}}
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    </div>
</div>
