
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
                @if (count($variants) > 0)
                    @foreach ($variants as $variant)
                    @php
                        if($variant->name     == "Adult_sizes Size"){
                            $variant->name    = "Adult Size";
                        }
                        if($variant->name     == "Baby_sizes Size"){
                            $variant->name    = "Baby Size";
                        }
                    @endphp
                    <div class="row">
                        <div class="col-md-4 offset-4 ">
                            <div class="form-group">
                                <div class="icon-addon input-right-icon">
                                    <input type="text" value="{{$variant->name}}" placeholder="Type variant" class="form-control text-center" id="8" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                @if (count($variant->Atrributes) > 0)
                                    @foreach ($variant->Atrributes as $attribute)
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <div class="icon-addon input-right-icon">
                                                <input type="text" placeholder="Type attribute" value="{{$attribute->name}}" class="form-control" id="8" disabled>
                                                @if($variant->name == "Color")
                                                <label class="fa fa-trash rh-pointer attr-del" data-id="{{$attribute->id}}"></label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                
                                @endif
                                @if($variant->name == "Color")
                                <div class="col-md-4">
                                    <a href="#" class="btn btn-light btn-favourite btn-block popup-add-attribute" data-variant-id="{{$variant->id}}"><label class="fa fa-plus"></label></a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @endforeach
                @endif
                <br>
               {{--  <div class="row">
                    <div class="col-md-4 offset-4 text-center">
                        <button class="btn btn-outline-violet w-100p mb-2 mr-1 popup-add-variant">New Attribute</button> 
                    </div>
                </div> --}}
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button class="btn btn-default close-modal" type="button">close</button>
            </div>
        </div>
	</div>
</div>
<!-- The Modal -->
<div class="modal" id="add-variant-modal" style="margin-top: 115px;">
	<div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header"  style="background-color:#41a942">
            <h6 class="modal-title text-white">Add Variant</h6>
            <button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <form class="form-inline" id="add-variant-form">
                    <input type="hidden" class="form-control mb-2 mr-sm-2" id="product_id" name="product_id" value="{{ $product_id }}">
                    <input type="text" class="form-control mb-2 mr-sm-2" id="variant_name" name="variant_name" placeholder="Type variant">
                    <button class="btn btn-success mb-2" id="save-variant">Submit</button>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button class="btn btn-default close-modal" type="button">close</button>
            </div>
        </div>
	</div>
</div>
<!-- The Modal -->
<div class="modal" id="add-attribute-modal" style="margin-top: 115px;">
	<div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header"  style="background-color:#41a942">
            <h6 class="modal-title text-white">Add Attribute</h6>
            <button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <form class="form-inline" id="add-variant-form">
                    <input type="hidden" class="form-control mb-2 mr-sm-2" placeholder="Type attribute" id="variant_id" name="variant_id" value="">
                    <input type="text" id="attribute_name" class="form-control mb-2 mr-sm-2" name="name" placeholder="">
                    <button class="btn btn-success mb-2" id="save-attribute">Submit</button>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button class="btn btn-default close-modal" type="button">close</button>
            </div>
        </div>
	</div>
</div>