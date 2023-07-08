<style>
    .accordion .card-header:after {
        font-family: "Font Awesome 5 Free";
        content: "\f106";
        font-weight: 900; 
        float: right; 
    }
    .accordion .card-header.collapsed:after {
        font-family: "Font Awesome 5 Free";
        content: "\f107"; 
        font-weight: 900;
        float: right;
    }
</style>
{{-- <div class="row">
    <div class="col-md-6">
        <label>Products</label>
        <select name="product_ids[]" multiple id="product_ids" class="form-control require">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    <option value="{{$product->id}}">{{$product->code}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div> --}}
<div id="accordion" class="accordion">
</div>
{{-- <h3 class="mb-4 down-line">Schedule</h3>
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
    @if ($order_type_id == 4)
    <div class="col-md-4">
        <div class="form-group">
            <label>Return Date: </label>&nbsp;&nbsp;&nbsp;
            <div class="input-group date">
                <input type="text" name="return_date" class="form-control bg-light flatpickr require" value="" >
                <div class="input-group-addon input-group-append">
                    <div class="input-group-text">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<h3 class="mb-4 down-line">Additional Info</h3>
<div class="form-row">
    <div class="col-md-9">
        <label>Comments</label>
        <textarea class="form-control bg-light" name="tailor_comments" id="" ></textarea>
    </div>
</div> --}}
{{-- F:\laragon\www\work\tyler-firm\resources\views\admin\orders\rental-form-script.blade.php --}}
{{-- @include('admin.orders.rental-form-script') --}}