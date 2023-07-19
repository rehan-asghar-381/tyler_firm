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
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>S-XL</th>
                                    <th>2XL</th>
                                    <th>3XL</th>
                                    <th>4XL</th>
                                    <th>5XL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
</div>
</div>
