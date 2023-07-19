
<style>
.rh-pointer{
    cursor: pointer;
}
</style>
<!-- The Modal -->
<div class="modal" id="variant-modal">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color:#41a942">
                <h6 class="modal-title text-white">Variants for {{ $product_code->name ." - ".$product_code->code}}</h6>
                <button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <form action="{{ route("admin.product.save-prices") }}" method="Post" class="form-inline" id="add-prices-form">
                <input type="hidden" name="product_id" value="{{$product_id}}">
                @csrf
                @foreach ($fixed_sizes_ids as $fixed_sizes_id)
                    <input type="hidden" name="fixed_sizes_ids[]" value="{{$fixed_sizes_id}}">
                @endforeach
                <div class="card mb-4">
                    <div class="card-body">
                     <div class="row mb-4 ">
                         @if (count($productVariantArr) > 0)
                         @foreach ($productVariantArr as $variant)
                         <div class="col-md-4">
                            <div class="form-group">
                                <div class="icon-addon input-right-icon">
                                    <input type="text" value="{{$variant}}" placeholder="Type variant" class="form-control text-center" name="" disabled>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="icon-addon input-right-icon">
                                    <input type="text" value="Price" placeholder="Type variant" class="form-control text-center"="8" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (isset($productVariantAtrributesArr) && count($productVariantAtrributesArr) > 0)
                        @foreach ($productVariantAtrributesArr  as $color => $variants)
                            @if (count($variants) > 0)
                            @php
                                $flag                                                       = 0;
                            @endphp
                                @foreach ($variants as $size)
                                    @php 
                                        [$colorVariantId,$colorAtrributesId ,$colorVariantName]     = explode('_', $color);
                                        [$sizeVariantId,$sizerAtrributesId , $sizeVariantName]      = explode('_', $size);
                                        @endphp

                                    @if (in_array($sizerAtrributesId, $fixed_sizes_ids) && $flag  == 0)
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <div class="icon-addon input-right-icon">
                                                    <input type="hidden" name="colorVariantIds[]" placeholder="Type attribute" value="{{$colorVariantId}}" class="form-control"  >
                                                    <input type="hidden" name="colorAtrributesIds[]" placeholder="Type attribute" value="{{$colorAtrributesId}}" class="form-control"  >
                                                    <input type="text" name="colorVariantNames[]" placeholder="Type attribute" value="{{$colorVariantName}}" class="form-control"  disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <div class="icon-addon input-right-icon">
                                                    <input type="hidden" placeholder="Type attribute" value="{{$sizeVariantId}}" class="form-control" name="sizeVariantIds[]" >
                                                    <input type="hidden" placeholder="Type attribute" value="{{$sizerAtrributesId}}" class="form-control" name="sizerAtrributesIds[]" >
                                                    <input type="text" placeholder="Type attribute" value="{{$sizeVariantName}}" class="form-control" name="sizeVariantNames[]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <div class="icon-addon input-right-icon">
                                                    <input type="text" placeholder="Type Price" value="{{ $product_prices_arr[$colorVariantId][$colorAtrributesId][$sizeVariantId][$sizerAtrributesId] ?? ""}}" class="form-control _price {{$sizeVariantName}}" data-selector="{{$sizeVariantName}}" name="prices[]" >
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    @php
                                        $flag                                                       = 1;
                                    @endphp
                                    @endif
                                    @if (!in_array($sizerAtrributesId, $fixed_sizes_ids))
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <div class="icon-addon input-right-icon">
                                                        <input type="hidden" name="colorVariantIds[]" placeholder="Type attribute" value="{{$colorVariantId}}" class="form-control"  >
                                                        <input type="hidden" name="colorAtrributesIds[]" placeholder="Type attribute" value="{{$colorAtrributesId}}" class="form-control"  >
                                                        <input type="text" name="colorVariantNames[]" placeholder="Type attribute" value="{{$colorVariantName}}" class="form-control"  disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <div class="icon-addon input-right-icon">
                                                        <input type="hidden" placeholder="Type attribute" value="{{$sizeVariantId}}" class="form-control" name="sizeVariantIds[]" >
                                                        <input type="hidden" placeholder="Type attribute" value="{{$sizerAtrributesId}}" class="form-control" name="sizerAtrributesIds[]" >
                                                        <input type="text" placeholder="Type attribute" value="{{$sizeVariantName}}" class="form-control" name="sizeVariantNames[]" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <div class="icon-addon input-right-icon">
                                                        <input type="text" placeholder="Type Price" value="{{ $product_prices_arr[$colorVariantId][$colorAtrributesId][$sizeVariantId][$sizerAtrributesId] ?? ""}}" class="form-control _price {{$sizeVariantName}}" data-selector="{{$sizeVariantName}}" name="prices[]" >
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                    @endif
                                    
                                @endforeach
                            @endif
                        @endforeach
                    @endif 
                    <button type="submit" class="btn btn-success mb-2" id="save-prices">Submit</button>
            </div>
        </div>
        <br>
    </form>
    </div>
    <!-- Modal footer -->
    <div class="modal-footer">
        <button class="btn btn-default close-modal" type="button">close</button>
    </div>
</div>
</div>
</div>