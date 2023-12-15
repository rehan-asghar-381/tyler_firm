<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
    Brand,
    ProductPrice
};
use App\Models\ProductSizeType;
use App\Models\Product;
use App\Models\ProductImg;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use Yajra\DataTables\DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    public $fixedAdultSize;
    public $fixedBabySize;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        ini_set('max_input_vars', 10000);
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','store']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-list', ['only' => ['index']]);

        $this->fixedAdultSize        = [
            "XS",
            "S",
            "M",
            "L",
            "XL"
        ];

        $this->fixedBabySize        = [
            "OSFA",
            "New Born",
            "6M",
            "12M",
            "18M"
        ];
    }

    public function index(Request $request)
    {
        $pageTitle          = "Products";
        $brands             = Brand::orderBy('name', 'asc')->get();
        return view('admin.products.index',compact('pageTitle', 'brands'));
    }

    public function ajaxtData(Request $request){

        $rData = Product::with('Brand')->select('*');
        $rData = $rData->orderBy('id', 'DESC');
        if($request->brand_id != ""){
            $rData              = $rData->where('brand_id', $request->brand_id);
        }
        if($request->date_from != ""){
            $rData              = $rData->where('time_id', '>=', strtotime($request->date_from));
        }
        if($request->date_to != ""){
            $rData              = $rData->where('time_id', '<=', strtotime($request->date_to));
        }
        return DataTables::of($rData->get())
        ->addIndexColumn()
        ->editColumn('name', function ($data) {
            if ($data->name != "")
                return $data->name;
            else
                return '-';
        })
        ->editColumn('code', function ($data) {
            if ($data->code != "")
                return $data->code;
            else
                return '-';
        })
        ->editColumn('description', function ($data) {
            if ($data->description != "")
                return $data->description;
            else
                return '-';
        })
        ->editColumn('brand_id', function ($data) {
            if (isset($data->Brand->name) && $data->Brand->name != "")
                return $data->Brand->name;
            else
                return '-';
        })
        ->editColumn('quantity', function ($data) {
            if ($data->quantity != "")
                return $data->quantity;
            else
                return '-';
        })
        ->editColumn('cost', function ($data) {
            if ($data->cost != "")
                return $data->cost;
            else
                return '-';
        })
        ->editColumn('inclusive_price', function ($data) {
            if ($data->inclusive_price != "")
                return $data->inclusive_price;
            else
                return '-';
        })
        ->editColumn('gross_profit', function ($data) {
            if ($data->gross_profit != "")
                return $data->gross_profit;
            else
                return '-';
        })
        ->editColumn('gross_profit_percentatge', function ($data) {
            if ($data->gross_profit_percentatge != "")
                return $data->gross_profit_percentatge;
            else
                return '-';
        })
        ->editColumn('time_id', function ($data) {
            if ($data->time_id != "")
                return date('m-d-Y h:i:s', $data->time_id);
            else
                return '-';
        })
        ->addColumn('active', function ($data){

            $action_list    = "";
            $is_active      = ($data->is_active == 'Y')? "checked": "";
            
            $action_list    .= '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input active-inactive" id="customSwitch'.$data->id.'" data-id="'.$data->id.'" '.$is_active.' ><label class="custom-control-label" for="customSwitch'.$data->id.'"  style="cursor:pointer;"></label></div>';

            return  $action_list;
        })
        ->addColumn('actions', function ($data) {

            $action_list    = '<div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti-more-alt"></i>
            </a>
            
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            if(auth()->user()->can('product-variant')){

                $action_list    .= '<a class="dropdown-item add-p-variant" data-product-id="'.$data->id.'" href="#"><i class="fas fa-plus"></i></i> Add Variants</a>';
            }
            if(auth()->user()->can('product-price')){

                $action_list    .= '<a class="dropdown-item add-p-price" data-product-id="'.$data->id.'" href="#"><i class="fas fa-plus"></i></i> Add Prices</a>';
            }
            if(auth()->user()->can('product-view')){

                $action_list    .= '<a class="dropdown-item" href="'.route('admin.product.detail',$data->id).'"><i class="fas fa fa-eye"></i> View</a>';
            }

            if(auth()->user()->can('product-edit')){

                $action_list    .= '<a class="dropdown-item" href="'.route('admin.product.edit',$data->id).'"><i class="far fa-edit"></i> Edit</a>';
            }
            $action_list    .= '</div>
            </div>';
            return  $action_list;
        })
        ->rawColumns(['actions', 'active'])
        ->make(TRUE);

    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $errors                     = [];
        $pageTitle                  = "Product";
        $brands                     = Brand::where('is_active', 'Y')->orderBy('name', 'asc')->get();
        $product_size_type          = ProductSizeType::select('type')->groupby('type')->get();
        
        return view('admin.products.create',compact('pageTitle', 'brands','product_size_type'));

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rData                      = $request->all();
        $user_id                    = Auth::user()->id;
        $user_name                  = Auth::user()->name;
        $rules = [
            'code' => 'unique:products,code'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
        $product                    = new Product();
        $product->time_id           = date('U');
        $product->name              = $rData['name'];
        $product->code              = $rData['code'];
        $product->description       = $rData['description'];
        $product->size_for          = $rData['size_for'];
        $product->brand_id          = $rData['brand_id'];
        $product->created_by_id                     = $user_id;
        $product->created_by_name                   = $user_name;
        $product->save();
        $productID                                  = $product->id;

        if($request->hasFile('filePhoto')){

            $this->save_product_imgs($request->file('filePhoto'), $productID);
        }
        if(isset($rData['size_for'])  ){

            $this->set_default_product_variants_attributes($rData['size_for'], $productID);
        }
        return redirect()->route('admin.product.index')
        ->with('success','Product added successfully');
    }

    public function set_default_product_variants_attributes($size_for,$productID){

        $this->set_default_product_variants('Color',$productID);
        $variant_id             = $this->set_default_product_variants(ucfirst($size_for).' '.'Size'  ,$productID);
        $variant                = ProductVariant::find($variant_id);
        $product_sizes          = ProductSizeType::where('type',$size_for)->get();
        $variant_attributeArr   = [];
        foreach ($product_sizes as $key => $size) {
           $variant_attribute                   = new ProductVariantAttribute();

           $variant_attribute->variant_id       = $variant_id;
           $variant_attribute->name             = $size->name;
           $variant_attribute->created_by_id    = Auth::user()->id;
           $variant_attribute->created_by_name  = Auth::user()->name;
           $variant_attributeArr[]              = $variant_attribute;
       }

       $variant->Atrributes()->saveMany($variant_attributeArr);

   }
   public function set_default_product_variants($variant_name,$productID){

    $product_variant            = new ProductVariant();

    $product_variant->product_id        = $productID;
    $product_variant->name              = $variant_name;
    $product_variant->created_by_id     = Auth::user()->id;
    $product_variant->created_by_name   = Auth::user()->name;
    $product_variant->save();
    $product_variant                    = $product_variant->id;
    return $product_variant;
}
public function save_product_imgs($files_arr=[], $product_id){
    $product                  = Product::find($product_id);
    foreach($files_arr as $file){             
        if(is_file($file)){
            $original_name = $file->getClientOriginalName();
            $file_name = time().rand(100,999).$original_name;
            $destinationPath = public_path('/uploads/product/');
            $file->move($destinationPath, $file_name);
            $file_slug  = "/uploads/product/".$file_name;

            $product_img                    = new ProductImg();
            $product_img->product_id        = $product_id;
            $product_img->image             = $file_slug;
            $product_images[]               = $product_img;
        }

    }
    $product->ProductImg()->saveMany($product_images);
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productDetail(Request $request, $id)
    {
        $pageTitle      = "Product";
        $product        = Product::with('Brand', 'ProductImg','ProductVariant', 'ProductVariant.Atrributes')->find($id);
        return view('admin.products.show',compact('pageTitle', 'product'));

    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands         = Brand::where('is_active', 'Y')->orderBy('name', 'asc')->get();
        $pageTitle      = "Product";
        $product        = Product::with('ProductImg')->find($id);
        $product_size_type          = ProductSizeType::select('type')->groupby('type')->get();
        return view('admin.products.edit',compact('pageTitle', 'product','brands', 'product_size_type'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rData                      = $request->all();
        $user_id                    = Auth::user()->id;
        $user_name                  = Auth::user()->name;
        $rules = [
            'code' => 'unique:products,code,'.$id
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            // dd($validator);
            return redirect()->back()->withInput($request->input())->withErrors($validator);

        }
        $product                    = Product::find($id);
        $product->time_id           = date('U');
        $product->name              = $rData['name'];
        $product->code              = $rData['code'];
        $product->description       = $rData['description'];
        // $product->size_for          = $rData['size_for'];
        $product->brand_id          = $rData['brand_id'];
        $product->updated_by_id     = $user_id;
        $product->updated_by_name   = $user_name;
        $product->save();
        $productID                  = $product->id;

        if($request->hasFile('filePhoto')){

            $this->save_product_imgs($request->file('filePhoto'), $productID);
        }
        return redirect()->route('admin.product.index')
        ->with('success','Product updated successfully');
    }

    public function delete_image(Request $request)
    {

        $product_id             = $request->product_id;
        $img_id                 = $request->img_id;
        ProductImg::where(['product_id'=> $product_id, 'id'=>$img_id])->delete();
        return json_encode(array("status"=>true));

    }
    
    public function variants(Request $request){

        $product_id         = $request->product_id;
        $product_code       = Product::where('id', $product_id)->select('code', 'name')->first();
        $variants           = ProductVariant::with('Atrributes')->where("product_id", $product_id)->get();
        // dd($variants);
        return view('admin.products.add-product-variants', compact('variants', 'product_id', 'product_code'));

    } 
    public function prices(Request $request){
        $type                       = "";
        $postfix                    = "";
        $productColorVariantArr     = [];
        $productSizeVariantArr      = [];
        $productVariantArr          = [];
        $product_prices_arr         = [];
        $product_id                 = $request->product_id;
        $product_prices             = ProductPrice::where("product_id", $product_id)->get();
        
        foreach($product_prices as $price){

            $product_prices_arr[$price->v1_id][$price->v1_attr_id][$price->v2_id][$price->v2_attr_id]   = $price->price;
        }
        $variants                   = ProductVariant::with('Atrributes')
                                        ->where("product_id", $product_id)
                                        ->get();
        
        foreach($variants as $variant){
            if($variant->name == "Baby_sizes Size"){
                $type               = "Baby Size";
                break;
            }
        }
        if($type == "Baby Size"){

            $fixed_sizes            = $this->fixedBabySize;
            $postfix                = "_OSFA-18M";
        }else{
            $fixed_sizes            = $this->fixedAdultSize;
            $postfix                = "_XS-XL";
        }
        $fixed_sizes_ids            = [];                                
        foreach ($variants as $key => $variant) {
            $productVariantArr[$variant->id] = $variant->name;

            foreach ($variant->Atrributes as $key => $atrributes) {
                if ($variant->name != "Color" ) {
                    if (in_array($atrributes->name, $fixed_sizes)) {
                        if (!in_array( $variant->id.'_'.$atrributes->id.$postfix, $productSizeVariantArr)) {
                            $productSizeVariantArr[]    = $variant->id.'_'.$atrributes->id.$postfix ;
                            $fixed_sizes_ids[]          = $atrributes->id;
                        }
                    }else{
                        $productSizeVariantArr[] = $variant->id.'_'.$atrributes->id.'_'.$atrributes->name ;
                    }
                } 
            }
        } 
        foreach ($variants as $key => $variant) {

           foreach ($variant->Atrributes as $key => $atrributes) {
            if ($variant->name == "Color" ) {
                $productColorVariantArr[$variant->id .'_'.   $atrributes->id .'_'.$atrributes->name] = $productSizeVariantArr;
            } 

        }

    }  
    $productVariantAtrributesArr = $productColorVariantArr;
    $product_code       = Product::where('id', $product_id)->select('code', 'name')->first();
    return view('admin.products.add-product-prices', compact('productVariantArr','productVariantAtrributesArr' ,'product_id', 'product_code', 'fixed_sizes_ids', 'product_prices_arr'));

} 
public function savePrices(Request $request){
    
    $fixed_sizes_ids            = $request->fixed_sizes_ids;

    $user_id                    = Auth::user()->id;
    $user_name                  = Auth::user()->name;
    $product                    = Product::find($request->product_id);
    $productPriceArr            = [];
    foreach ($request->colorVariantIds as $key => $value) {
       
        if(isset($request->sizerAtrributesIds[$key]) && in_array($request->sizerAtrributesIds[$key], $fixed_sizes_ids)){
            foreach($fixed_sizes_ids as $fixed_sizes_id){
                $productPrice                   = new ProductPrice();
                $productPrice->product_id       = $request->product_id;
                $productPrice->v1_id            = $request->colorVariantIds[$key]; 
                $productPrice->v1_attr_id       = $request->colorAtrributesIds[$key]; 
                $productPrice->v2_id            = $request->sizeVariantIds[$key]; 
                $productPrice->v2_attr_id       = $fixed_sizes_id; 
                $productPrice->price            = $request->prices[$key]; 
                $productPrice->created_by_id    = $user_id;
                $productPrice->created_by_name  = $user_name;
                $productPriceArr[]              = $productPrice;
            }
        }else{
            $productPrice                   = new ProductPrice();
            $productPrice->product_id       = $request->product_id;
            $productPrice->v1_id            = $request->colorVariantIds[$key]; 
            $productPrice->v1_attr_id       = $request->colorAtrributesIds[$key]; 
            $productPrice->v2_id            = $request->sizeVariantIds[$key]; 
            $productPrice->v2_attr_id       = $request->sizerAtrributesIds[$key]; 
            $productPrice->price            = $request->prices[$key]; 
            $productPrice->created_by_id    = $user_id;
            $productPrice->created_by_name  = $user_name;
            $productPriceArr[]              = $productPrice;
        }
        
    }
    $product->ProductPrice()->delete();
    $product->ProductPrice()->saveMany($productPriceArr);
    return redirect()->route('admin.product.index')
        ->with('success','Prices added successfully');
} 
public function add_variant(Request $request){
    $user_id                    = Auth::user()->id;
    $user_name                  = Auth::user()->name;

    $product_id                 = $request->product_id;
    $variant_name               = $request->variant_name;
    $product_variant            = new ProductVariant();

    $product_variant->product_id        = $product_id;
    $product_variant->name              = $variant_name;
    $product_variant->created_by_id     = $user_id;
    $product_variant->created_by_name     = $user_name;
    $product_variant->save();

    return json_encode(array("status"=>true, "message"=>"Variant added successfully"));

} 
public function delete_variant(Request $request){

    $variant_id                 = $request->variant_id;
    $product_variant            = ProductVariant::find($variant_id);

    $product_variant->delete();
    return json_encode(array("status"=>true, "message"=>"Variant deleted successfully"));

} 
public function add_attribute(Request $request){
    $user_id                    = Auth::user()->id;
    $user_name                  = Auth::user()->name;

    $variant_id                 = $request->variant_id;
    $attribute_name             = $request->attribute_name;
    $variant_attribute          = new ProductVariantAttribute();

    $variant_attribute->variant_id          = $variant_id;
    $variant_attribute->name                = $attribute_name;
    $variant_attribute->created_by_id       = $user_id;
    $variant_attribute->created_by_name     = $user_name;
    $variant_attribute->save();

    return json_encode(array("status"=>true, "message"=>"Attribute added successfully"));
} 

public function delete_attribute(Request $request){
    $attribute_id                 = $request->attribute_id;
    $variant_attribute            = ProductVariantAttribute::find($attribute_id);
    $variant_attribute->delete();
    return json_encode(array("status"=>true, "message"=>"Attribute deleted successfully"));

}

public function get_product_by_brand(Request $request){
    $products = Product::where('id',$request->brand)->get();
    $html = '';
    foreach ($products as $key => $product) {
        $html .="<option value=".$product->id.">".$product->name .' ['.$product->code.']</option>';
    }
    return $html;
}

public function get_price(Request $request){

    $product_id             = $request->product_id;
    $v1_attr_id             = $request->v1_attr_id;
    $v2_attr_id             = $request->v2_attr_id;
    $product                = ProductPrice::with("v2AttrName")
                                    ->where([
                                        "product_id"=>$product_id, 
                                        "v1_attr_id"=>$v1_attr_id, 
                                        "v2_attr_id"=>$v2_attr_id
                                        ])
                                    ->first();
    $reponse                = array("price"=>$product->price??0, "name"=>$product->v2AttrName->name);
    return json_encode($reponse);
}

public function activeInactive(Request $request){

    $id                             = $request->get('id');
    $is_active                      = $request->get('is_active');
    $financial_year                 = Product::find($id);
    $financial_year->is_active      = $is_active;
    $financial_year->save();

}

}