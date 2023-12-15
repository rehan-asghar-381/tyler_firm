<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandImg;
use Yajra\DataTables\DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
        $this->middleware('permission:brand-list|brand-create|brand-edit|brand-delete', ['only' => ['index','store']]);
        $this->middleware('permission:brand-create', ['only' => ['create','store']]);
        $this->middleware('permission:brand-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:brand-list', ['only' => ['index']]);
     }

    public function index(Request $request)
    {
        // dd(auth()->user()->getAllPermissions()  );
        $pageTitle          = "Brands";
        return view('admin.brands.index',compact('pageTitle'));
    }

    public function ajaxtData(Request $request){

        $rData = Brand::select('*');
        $rData = $rData->orderBy('id', 'DESC');
      
        return DataTables::of($rData->get())
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                if ($data->name != "")
                    return $data->name;
                else
                    return '-';
            })
            ->editColumn('description', function ($data) {
                if ($data->description != "")
                    return $data->description;
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

                if(auth()->user()->can('brand-view')){

                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.brand.detail',$data->id).'"><i class="fas fa fa-eye"></i> View</a>';
                }

                if(auth()->user()->can('brand-edit')){

                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.brand.edit',$data->id).'"><i class="far fa-edit"></i> Edit</a>';
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
        $errors         = [];
        $pageTitle      = "Brand";
        return view('admin.brands.create',compact('pageTitle'));

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
            'code' => 'unique:brands,name'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
        $brand                    = new Brand();
        $brand->time_id           = date('U');
        $brand->name              = $rData['name'];
        $brand->description       = $rData['description'];
        $brand->created_by_id                     = $user_id;
        $brand->created_by_name                   = $user_name;
        $brand->save();
        $brandID                                  = $brand->id;
       
        if($request->hasFile('filePhoto')){

            $this->save_brand_imgs($request->file('filePhoto'), $brandID);
        }
        return redirect()->route('admin.brand.index')
                        ->with('success','Brand added successfully');
    }

    public function save_brand_imgs($files_arr=[], $brand_id){
        $brand                  = Brand::find($brand_id);
        foreach($files_arr as $file){             
            if(is_file($file)){
                $original_name = $file->getClientOriginalName();
                $file_name = time().rand(100,999).$original_name;
                $destinationPath = public_path('/uploads/product/');
                $file->move($destinationPath, $file_name);
                $file_slug  = "/uploads/product/".$file_name;

                $brand_img                    = new BrandImg();
                $brand_img->brand_id        = $brand_id;
                $brand_img->image             = $file_slug;
                $brand_images[]               = $brand_img;
            }
            
        }
        $brand->BrandImg()->saveMany($brand_images);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function brandDetail(Request $request, $id)
    {
        $pageTitle      = "Brand";
        $brand        = Brand::with('BrandImg')->find($id);
        return view('admin.brands.show',compact('pageTitle', 'brand'));
      
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle      = "Brand";
        $brand          = Brand::with('BrandImg')->find($id);
        return view('admin.brands.edit',compact('pageTitle', 'brand'));
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
            'code' => 'unique:brands,name,'.$id
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            // dd($validator);
            return redirect()->back()->withInput($request->input())->withErrors($validator);
      
        }
        $brand                    = Brand::find($id);
        $brand->time_id           = date('U');
        $brand->name              = $rData['name'];
        $brand->description       = $rData['description'];
        $brand->updated_by_id     = $user_id;
        $brand->updated_by_name   = $user_name;
        $brand->save();
        $brandID                  = $brand->id;
       
        if($request->hasFile('filePhoto')){

            $this->save_brand_imgs($request->file('filePhoto'), $brandID);
        }
        return redirect()->route('admin.brand.index')
                        ->with('success','Brand updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     User::find($id)->delete();
    //     return redirect()->route('admin.users.index')
    //                     ->with('success','User deleted successfully');
    // }

    public function delete_image(Request $request)
    {
        
        $brand_id             = $request->brand_id;
        $img_id                 = $request->img_id;
        BrandImg::where(['brand_id'=> $brand_id, 'id'=>$img_id])->delete();
        return json_encode(array("status"=>true));

    }
    
    public function variants(Request $request){

        $product_id         = $request->product_id;
        $product_code       = Product::where('id', $product_id)->select('code')->first();
        $variants           = ProductVariant::with('Atrributes')->where("product_id", $product_id)->get();
       
        return view('admin.products.add-product-variants', compact('variants', 'product_id', 'product_code'));

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

    public function activeInactive(Request $request){

        $id                             = $request->get('id');
        $is_active                      = $request->get('is_active');
        $financial_year                 = Brand::find($id);
        $financial_year->is_active      = $is_active;
        $financial_year->save();
    
    }
}