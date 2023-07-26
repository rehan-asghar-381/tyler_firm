<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderImgs;
use App\Models\Status;
use App\Models\Job;
use App\Models\Client;
use App\Models\OrderTransfer;
use App\Models\OrderMargin;
use App\Models\OrderSupply;
use App\Models\OrderType;
use App\Models\OrderAdditional;
use App\Models\ShopSize;
use App\Models\OrderTill;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Brand;
use App\Models\OrderOtherCharges;
use App\Models\OrderProductVariant;
use App\Models\PriceRange;
use App\Models\OrderContractPrintPrice;
use App\Models\OrderProduct;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use App\Models\DecorationPrice;
use App\Models\OrderPrice;
use App\Models\OrderColorPerLocation;
use App\Models\OrderFinalPriceProductVariants;
use App\Models\OrderPrintLocationColor;
use App\Models\SupplyInventoryItem;
use App\Models\ClientMeasurement;
use Yajra\DataTables\DataTables;
use App\Traits\NotificationTrait;

class OrderController extends Controller
{
    
    use NotificationTrait;

    public $fixedAdultSize;
    public $allAdultSizes;

    public $fixedBabySize;
    public $allBabySizes;
    function __construct()
    {
       $this->middleware('permission:orders-list|orders-edit', ['only' => ['index']]);
       $this->middleware('permission:orders-edit', ['only' => ['edit','update']]);
       $this->middleware('permission:orders-view', ['only' => ['show']]);
       $this->middleware('permission:orders-change-status', ['only' => ['status_update']]);
       $this->middleware('permission:orders-generate-invoice', ['only' => ['status_update']]);
       $this->fixedAdultSize        = [
                                        "XS",
                                        "S",
                                        "M",
                                        "L",
                                        "XL"
                                    ];
       $this->allAdultSizes        = [
                                        "2XL",
                                        "3XL",
                                        "4XL",
                                        "5XL",
                                        "6XL"
                                    ];
       $this->fixedBabySize        = [
                                        "OSFA",
                                        "New Born",
                                        "6M",
                                        "12M",
                                        "18M"
                                    ];
       $this->allBabySizes        = [
                                        "2T",
                                        "3T",
                                        "4T",
                                        "5T",
                                        "6T"
                                    ];
   }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $pageTitle                              = "Orders";
        // $statuses_arr                           = [];
        $statuses                               = Status::where('is_active', 'Y')->get(['id', 'name']);
        
        foreach($statuses as $key=>$status){

            $statuses_arr['"'.$key.'"']          = $status;
        }
        $clients        = Client::get();

        return view('admin.orders.index', compact('pageTitle', 'statuses_arr', 'clients'));
    } 

    public function previousOrder(Request $request,$id){
        $pageTitle          = "Client  Previous Order";
        $statuses           = Status::where('id', 5)->get(['id', 'name']);
        
        foreach($statuses as $key=>$status){

            $statuses_arr['"'.$key.'"']          = $status;
        }
        $clients        = Client::get();

        $clients               = Client::where('id',$id)->orderBy('id','DESC')->get();
        return view('admin.orders.previous-order', compact('pageTitle', 'statuses_arr', 'clients'));
    }
    public function ajaxtData(Request $request){

        $rData              = Order::with(["client"]);
        if($request->client_id != ""){

            $rData              = $rData->where('client_id', $request->client_id);
        }

        if($request->date_from != ""){

            $rData              = $rData->where('time_id', '>=', strtotime($request->date_from));
        }

        if($request->date_to != ""){

            $rData              = $rData->where('time_id', '<=', strtotime($request->date_to));
        }

        if($request->status_id != ""){

            $rData              = $rData->where('status', '=', $request->status_id);
        }
        
        return DataTables::of($rData->get())
        ->addIndexColumn()
        ->editColumn('id', function ($data) {
            if (isset($data->id) && $data->id != "")
                return $data->id;
            else
                return '-';
        })
        ->addColumn('company_name', function ($data) {
            if (isset($data->client->company_name) && $data->client->company_name != "")
                return $data->client->company_name;
            else
                return '-';
        })
        ->editColumn('job_name', function ($data) {
            if ($data->job_name != "")
                return $data->job_name;
            else
                return '-';
        })
        ->editColumn('projected_units', function ($data) {
            if ($data->projected_units != "")
                return $data->projected_units;
            else
                return '-';
        })
        ->editColumn('due_date', function ($data) {
            if ($data->due_date != "")
                return date("Y-m-d h:i", $data->due_date);
            else
                return '-';
        })
        ->editColumn('event', function ($data) {
            if ($data->event != "")
                return $data->event;
            else
                return '-';
        })
        ->editColumn('order_number', function ($data) {
            if ($data->order_number != "")
                return $data->order_number;
            else
                return '-';
        })
        ->editColumn('status', function ($data) {

            if (isset($data->Orderstatus->name) && $data->Orderstatus->name != "")
                return $data->Orderstatus->name;
            else
                return '-';
        })
        ->editColumn('order_date', function ($data) {
            if ($data->time_id > 0 )
                return date('Y-m-d',$data->time_id);
            else
                return '-';
        })
        ->addColumn('actions', function ($data){

            $action_list    = '<div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti-more-alt"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            if(auth()->user()->can('orders-view')){
                $action_list    .= '<a class="dropdown-item" href="'.route('admin.order.view', $data->id).'"><i class="far fa-eye"></i> View Details</a>';
            }
            if(auth()->user()->can('orders-edit')){
                $action_list    .= '<a class="dropdown-item" href="'.route('admin.order.edit', $data->id).'"><i class="far fa-edit"></i> Edit</a>';
            }
            if(auth()->user()->can('orders-generate-invoice')){
                $action_list    .= '<a class="dropdown-item "  href="'.route('admin.order.generateInvoice') .'" data-status="'.$data->status.'" data-id="'.$data->id.'"><i class="far fa fa-print"></i> Generate Invoice</a>';
            }
            if(auth()->user()->can('orders-change-status')){
                $action_list    .= '<a class="dropdown-item btn-change-status" href="#" data-status="'.$data->status.'" data-id="'.$data->id.'"><i class="far fa fa-life-ring"></i> Change Status</a>';
            }
            $action_list        .= '</div></div>';
            return  $action_list;
        })
        ->rawColumns(['actions'])
        ->make(TRUE);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create()
    {
        $pageTitle          = "Orders";
        $clients            = Client::get();
        $clients            = Client::get();
        $products           = Product::get();
        $brands             = Brand::get();
        $errors             = [];
        $fixed_sizes        = $this->fixedAdultSize;
        $all_adult_sizes    = $this->allAdultSizes;
        $fixed_baby_sizes   = $this->fixedBabySize;
        $all_baby_sizes     = $this->allBabySizes;
        return view('admin.orders.create',compact('pageTitle','products', 'clients', 'brands', 'fixed_sizes', 'all_adult_sizes', 'fixed_baby_sizes', 'all_baby_sizes'));

    } 

    public function store(Request $request)
    { 
        $user_id                    = Auth::user()->id;
        $user_name                  = Auth::user()->name;     
        $rData                      = $request->all();
        $order                      = new Order();
        $order->time_id             = date('U');
        $order->client_id           = $rData['client_id'];
        $order->sales_rep           = $rData['sales_rep'];
        $order->due_date            = (isset($rData['due_date']) && $rData['due_date'] != "")?strtotime($rData['due_date']):0;
        $order->event               = $rData['event'];
        $order->shipping_address    = $rData['shipping_address'];
        $order->job_name            = $rData['job_name'];
        $order->order_number        = $rData['order_number'];
        $order->projected_units     = $rData['projected_units'];
        $order->status              = 1;
        $order->created_by_id       = $user_id;
        $order->created_by_name     = $user_name;
        $order->save();
        $orderID                    = $order->id;
        $product_ids                = $rData['product_ids'];
        $products_name              = $rData['products_name'];
        if(count($product_ids) > 0){
            $this->save_order_prices($orderID, $rData);
        }
        if (count($product_ids) > 0) {
            $this->save_order_products($product_ids,$products_name, $orderID);
        }
        $attribute_color                        = $rData['attribute_color'];
        $attribute_size                         = $rData['attribute_size'];
        $pieces                                 = $rData['pieces'];
        $prices                                 = $rData['price'];
        $total                                  = $rData['total'];
        if (count($attribute_color) > 0 ) {
           
            $this->save_product_attribute($product_ids, $attribute_color,$attribute_size,$pieces,$prices,$total, $orderID);
        }
        $fold_bag_tag_pieces                            = $rData['fold_bag_tag_pieces'];
        if (isset($fold_bag_tag_pieces)) {
            $this->save_order_other_charges($rData, $orderID);
        }
        $this->order_transfer($rData, $orderID);
        return redirect()->route("admin.order.create")->withSuccess('Order data has been saved successfully!');
    }
    public function save_order_prices($order_id, $rData){
        $order                          = Order::find($order_id);
        $product_ids                    = $rData['product_ids'];
        $product_sizes                  = $rData['product_size'];
        $wholesale_price                = $rData['wholesale_price'];
        $print_price                    = $rData['print_price'];
        $profit_margin                  = $rData['profit_margin'];
        $profit_margin_percentage       = $rData['profit_margin_percentage'];
        $total_price                    = $rData['total_price'];
        $final_price                    = $rData['final_price'];
        $color_per_location             = $rData['color_per_location'];
        $order_price_arr                = [];
        $order_color_perlocation_arr    = [];
        foreach($product_ids as $key=> $product_id){
    
            foreach($product_sizes[$product_id] as $p_key=>$product_size){
     
                $order_price                    = new OrderPrice();
                $order_price->product_id        = $product_id;
                $order_price->product_size      = $product_size;
                $order_price->wholesale_price   = $wholesale_price[$product_id][$p_key];
                $order_price->print_price       = $print_price[$product_id][$p_key];
                $order_price->total_price       = $total_price[$product_id][$p_key];
                $order_price->profit_margin     = $profit_margin[$product_id][$p_key];
                $order_price->profit_margin_percentage     = $profit_margin_percentage[$product_id][0];
                $order_price->final_price       = $final_price[$product_id][$p_key];
                $order_price_arr[]              = $order_price;
                
            }
            foreach($color_per_location[$product_id] as $key=>$color){
             
                $order_color_perlocation                        = new OrderColorPerLocation();
                $order_color_perlocation->product_id            = $product_id;
                $order_color_perlocation->color_per_location    = $color;
                $order_color_perlocation->location_number       = $key+1;
                $order_color_perlocation_arr[]                  = $order_color_perlocation;
                
            }
            
        }
       $order->OrderPrice()->delete();
       $order->OrderPrice()->saveMany($order_price_arr);
       $order->OrderColorPerLocation()->delete();
       $order->OrderColorPerLocation()->saveMany($order_color_perlocation_arr);
    }
    public function order_transfer($rData, $order_id){

        $order_transfer                             = OrderTransfer::firstOrNew(['order_id'=>$order_id]);
        $order_transfer->order_id                   = $order_id;
        $order_transfer->transfers_pieces           = $rData['transfers_pieces'];
        $order_transfer->transfers_pieces           = $rData['transfers_pieces'];
        $order_transfer->transfers_prices           = $rData['transfers_prices'];
        $order_transfer->ink_color_change_pieces    = $rData['ink_color_change_pieces'];
        $order_transfer->art_fee                    = $rData['art_fee'];
        $order_transfer->art_discount_prices        = $rData['art_discount_prices'];
        $order_transfer->shipping_charges           = $rData['shipping_charges'];
        $order_transfer->save();
    }
    public function save_order_other_charges($rData, $order_id){
        $order_other_charges                        = OrderOtherCharges::firstOrNew(['order_id'=>$order_id]);
        $order_other_charges->order_id              = $order_id;
        $order_other_charges->fold_bag_tag_pieces   = $rData['fold_bag_tag_pieces'];
        $order_other_charges->fold_bag_tag_prices   = $rData['fold_bag_tag_prices'];;
        $order_other_charges->hang_tag_pieces       = $rData['hang_tag_pieces'];
        $order_other_charges->hang_tag_prices       = $rData['hang_tag_prices'];
        $order_other_charges->art_fee               = $rData['art_fee'];
        $order_other_charges->art_discount          = $rData['art_discount'];
        $order_other_charges->art_time              = $rData['art_time'];
        $order_other_charges->tax                   = $rData['tax'];
        $order_other_charges->save();
    } 

    public function save_product_attribute($product_ids, $attribute_color,$attribute_size,$pieces,$prices,$total, $order_id){
        
        $order                          = Order::find($order_id);
        $order_product_variant_arr      = [];
        foreach ($product_ids as $product_id) {
            
            foreach($attribute_color[$product_id] as $variant_id=>$attr_arr){
                $variant1_id            = $variant_id;
                $product_variant        = ProductVariant::find($variant_id);
                $variant1_name          = $product_variant->name;
                $color_attr_arr         = $attr_arr;
            }
            foreach($attribute_size[$product_id] as $variant_id=>$attr_arr){
                $variant2_id            = $variant_id;
                $product_variant        = ProductVariant::find($variant_id);
                $variant2_name          = $product_variant->name;
                $size_attr_arr          = $attr_arr;
            }
            foreach($color_attr_arr as $key=>$attr_id){

                $order_product_var                      = new OrderProductVariant();
                $order_product_var->order_id            = $order_id;
                $order_product_var->product_id          = $product_id;
                $order_product_var->variant1_id         = $variant1_id;
                $order_product_var->variant1_name       = $variant1_name ;
                $order_product_var->variant2_id         = $variant2_id;
                $order_product_var->variant2_name       = $variant2_name;
                $order_product_var->attribute1_id       = $attr_id;
                $product_variant_attribute              = ProductVariantAttribute::find($attr_id);
                $order_product_var->attribute1_name     = $product_variant_attribute->name;
                $order_product_var->attribute2_id       = $size_attr_arr[$key];
                $product_variant_attribute              = ProductVariantAttribute::find($size_attr_arr[$key]);
                $order_product_var->attribute2_name     = $product_variant_attribute->name;
                $order_product_var->pieces              = $pieces[$product_id][$key];
                $order_product_var->price               = $prices[$product_id][$key];
                $order_product_var->total               = $total[$product_id][$key];
                $order_product_variant_arr[]            = $order_product_var;

            }     
        }

        $order->OrderProductVariant()->delete();
        $order->OrderProductVariant()->saveMany($order_product_variant_arr);
    }

    public function save_order_products($product_ids,$products_name, $order_id){
        
        $order                  = Order::find($order_id);
        $order_products_arr     = [];
        
        foreach ($product_ids as $key=>$product) {
            $order_products               = new OrderProduct();
            $order_products->order_id     = $order_id;
            $order_products->product_id        = $product;
            $order_products->product_name        = $products_name[$product];
            $order_products_arr[]  = $order_products;
        }

        $order->OrderProducts()->delete();
        $order->OrderProducts()->saveMany($order_products_arr);
    }
    public function edit($id)
    {
        $pageTitle                  = "Orders";
        $order                      = Order::with([
            'OrderPrice', 
            'OrderColorPerLocation', 
            'OrderProducts', 
            'Orderstatus',
            'OrderProductVariant',
            'OrderTransfer',
            'OrderOtherCharges'
        ])->find($id);
        $order_product_ids_arr      = [];
        $clients                    = Client::get();
        $products                   = Product::get();
        $fixed_sizes                = $this->fixedAdultSize;
        $all_adult_sizes            = $this->allAdultSizes;
        $fixed_baby_sizes           = $this->fixedBabySize;
        $all_baby_sizes             = $this->allBabySizes;
        if(count($order->OrderProducts) > 0){

            foreach($order->OrderProducts as $orderProduct){

                $order_product_ids_arr[]    = $orderProduct->product_id;
            }
        }
        return view('admin.orders.edit',compact('pageTitle', 'order', 'clients', 'products', 'fixed_sizes', 'all_adult_sizes', 'fixed_baby_sizes', 'all_baby_sizes', 'order_product_ids_arr'));

    }

    public function update(Request $request, $id)
    {
        $user_id                    = Auth::user()->id;
        $user_name                  = Auth::user()->name;     
        $rData                      = $request->all();
        $order                      = Order::find($id);
        $order->client_id           = $rData['client_id'];
        $order->sales_rep           = $rData['sales_rep'];
        $order->due_date            = (isset($rData['due_date']) && $rData['due_date'] != "")?strtotime($rData['due_date']):0;
        $order->event               = $rData['event'];
        $order->shipping_address    = $rData['shipping_address'];
        $order->job_name            = $rData['job_name'];
        $order->order_number        = $rData['order_number'];
        $order->projected_units     = $rData['projected_units'];
        $order->updated_by_id       = $user_id;
        $order->updated_by_name     = $user_name;
        $order->save();
        $orderID                    = $order->id;
        $product_ids                = $rData['product_ids'];
        $products_name              = $rData['products_name'];
        if(count($product_ids) > 0){
            $this->save_order_prices($orderID, $rData);
        }
        if (count($product_ids) > 0) {
            $this->save_order_products($product_ids,$products_name, $orderID);
        }
        $attribute_color                        = $rData['attribute_color'];
        $attribute_size                         = $rData['attribute_size'];
        $pieces                                 = $rData['pieces'];
        $prices                                 = $rData['price'];
        $total                                  = $rData['total'];
        if (count($attribute_color) > 0 ) {
            $this->save_product_attribute($product_ids, $attribute_color,$attribute_size,$pieces,$prices,$total, $orderID);
        }
        $fold_bag_tag_pieces                            = $rData['fold_bag_tag_pieces'];
        if (isset($fold_bag_tag_pieces)) {
            $this->save_order_other_charges($rData, $orderID);
        }
        $this->order_transfer($rData, $orderID);

        return redirect()->route("admin.order.index")->withSuccess('Order data has been updated successfully!');
    }

    public function orderView(Request $request, $id)
    {

        $order_detail               = Order::with([
            // 'OrderSupply', 
            // 'OrderImgs', 
            // 'AdditionalFields', 
            'Orderstatus',
            // 'OrderJobs',
            // 'OrderType',
            'client',
            // 'OrderSupply.SupplyInventoryItem',
            // 'OrderTill'
        ])->find($id);
        $inventory_items            = [];
        $payments_types             = [];
        $pageTitle                  = "Order Detail ";
        return view('admin.orders.order-detail', compact('pageTitle', 'order_detail', 'inventory_items', 'payments_types'));

    }

    public function status_update(Request $request)
    {

        $user_id                = Auth::user()->id;
        $user_name              = Auth::user()->name;

        $order_id               = $request->get('order_id');
        $status                 = $request->get('status_id');

        $order                  = Order::find($order_id);
        $order->status          = $status;
        $order->save();

        // $body                           = $user_name." set Status to <strong>".$order->Orderstatus->name."</strong> for Order ( <strong>#".$order->id."</strong> )";
        // $data['idFK']                   = $order->id;
        // $data['type']                   = 'orders';
        // $data['added_by_id']            = $user_id;
        // $data['added_by_name']          = $user_name;
        // $data['body']                   = $body;
        // $data['time_id']                = date('U');
        // $this->add_notification($data);

        return json_encode(array("status"=>true, "message"=>"Status has been updated successfully!"));

    }

    public function delete_image(Request $request)
    {
        $order_id               = $request->order_id;
        $img_id                 = $request->img_id;
        OrderImgs::where(['order_id'=> $order_id, 'id'=>$img_id])->delete();
        return json_encode(array("status"=>true));

    }

    public function get_job_template(Request $request)
    {
        $order_id                               = $request->order_id;
        $statuses_arr                           = [];
        $jobs_arr                               = [];

        $tailors = User::with(['roles' => function($q) {
            $q->where('name', '=', 'Tailor');
        }])->where('id', '<>', 1)->get();

        $statuses                               = Status::where(['is_active'=>'Y', 'is_job'=>'Y'])->where('name', '!=', 'New')->orderBy('priority', 'asc')->get(['id', 'name']);
        foreach($statuses as $status){

            $statuses_arr[$status->id]          = $status->name;
        }

        $jobs                                   = Job::where(['order_id'=>$order_id])->get();

        foreach($jobs as $job){
            $job_status_id                      = $job->status_id;
            
            $jobs_arr[$job_status_id]['order_id']                   = $job->order_id;
            $jobs_arr[$job_status_id]['status_id']                  = $job->status_id;
            $jobs_arr[$job_status_id]['tailor_id'][]                 = $job->tailor_id;
            $jobs_arr[$job_status_id]['start_date_time']            = $job->start_date_time;
            $jobs_arr[$job_status_id]['completion_date_time']       = $job->completion_date_time;
            $jobs_arr[$job_status_id]['notes']                      = $job->notes;


        }
        
        return view('admin.orders.assign-jobs', compact('tailors', 'statuses_arr', 'order_id', 'jobs_arr'));

    }

    public function destroy(Request $request, $id)
    {

        $order                  = Order::find($id);
        $order->AdditionalFields()->delete();
        $order->OrderImgs()->delete();
        $order->OrderSupply()->delete();
        $order->OrderJobs()->delete();

        $order->delete();

        return redirect()->route("admin.order.index")->withSuccess('Order data has been deleted successfully!');

    }

    public function get_client_recent_order(Request $request)
    {
        $client_id              = $request->client_id;
        $order_measurements     = [];
        // $order                  = ClientMeasurement::where('client_id', $client_id)->first();
        $order                  = [];

        $order_measurements['field1_hb']            = $order->field1_hb ?? "";
        $order_measurements['field2_b']             = $order->field2_b ?? "";
        $order_measurements['field3_w']             = $order->field3_w ?? "";
        $order_measurements['field4_hh']            = $order->field4_hh ?? "";
        $order_measurements['field5_h']             = $order->field5_h ?? "";
        $order_measurements['field6_sh']            = $order->field6_sh ?? "";
        $order_measurements['field7_half_sh']       = $order->field7_half_sh ?? "";
        $order_measurements['field8_sh_w']          = $order->field8_sh_w ?? "";
        $order_measurements['field9_sh_kn']         = $order->field9_sh_kn ?? "";
        $order_measurements['field10_sh_g']         = $order->field10_sh_g ?? "";
        $order_measurements['field11_w_kn']         = $order->field11_w_kn ?? "";
        $order_measurements['field12_w_g']          = $order->field12_w_g ?? "";
        $order_measurements['field13_arm']          = $order->field13_arm ?? "";
        $order_measurements['field14_half_arm']     = $order->field14_half_arm ?? "";
        $order_measurements['field15_arm_depth']    = $order->field15_arm_depth ?? "";
        $order_measurements['field16_bicep']        = $order->field16_bicep ?? "";
        $order_measurements['field17_wrist']        = $order->field17_wrist ?? "";
        $order_measurements['field18_sh_w']         = $order->field18_sh_w ?? "";
        $order_measurements['field19_tw']           = $order->field19_tw ?? "";
        $order_measurements['field20_sh_hh']        = $order->field20_sh_hh ?? "";
        $order_measurements['measurement_type']     = $order->measurement_type ?? "";
        $order_measurements['title']                = $order->title ?? "";
        

        return json_encode(["status"=>true, "data"=>$order_measurements]);
        

    }

    public function save_order_imgs($files_arr=[], $order_id){
        $order                  = Order::find($order_id);
        foreach($files_arr as $file){             
            if(is_file($file)){
                $original_name = $file->getClientOriginalName();
                $file_name = time().rand(100,999).$original_name;
                $destinationPath = public_path('/uploads/order/');
                $file->move($destinationPath, $file_name);
                $file_slug  = "/uploads/order/".$file_name;

                $order_img                      = new OrderImgs();
                $order_img->order_id            = $order_id;
                $order_img->image               = $file_slug;
                $order_images[]                 = $order_img;
            }
            
        }
        $order->OrderImgs()->saveMany($order_images);
    }
    public function save_additional_fields($fields=[], $labels=[], $order_id){

        $order                  = Order::find($order_id);
        foreach ($fields as $key=>$field_value) {

            $additional_field               = new OrderAdditional();

            $additional_field->order_id     = $order_id;
            $additional_field->label        = $labels[$key];
            $additional_field->value        = $field_value;

            $order_additional_fields_arr[]  = $additional_field;
        }

        $order->AdditionalFields()->saveMany($order_additional_fields_arr);
    }
    public function save_order_supplies($supplies=[], $supply_quantities=[], $order_id){
        $user_id                = Auth::user()->id;
        $user_name              = Auth::user()->name;
        $order                  = Order::find($order_id);
        foreach ($supplies as $key=>$supply) {

            $item_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $supply)));

            $supply_iventorty_item                      = SupplyInventoryItem::firstOrNew(["item_slug"=>$item_slug]);

            $supply_iventorty_item->item                = ($supply_iventorty_item->item != "") 
            ? $supply_iventorty_item->item
            : $supply;
            $supply_iventorty_item->item_slug           = $item_slug;
            $supply_iventorty_item->created_by_id       = $user_id;
            $supply_iventorty_item->created_by_name     = $user_name;
            $supply_iventorty_item->save();

            $order_supplies                 = new OrderSupply();

            $order_supplies->order_id       = $order_id;
            $order_supplies->item_slug      = $item_slug;
            $order_supplies->quantity       = $supply_quantities[$key];

            $order_supplies_arr[]           = $order_supplies;
        }

        $order->OrderSupply()->saveMany($order_supplies_arr);
    }
    public function product_form(Request $request){
        $order_product_variants     = [];
        $product_id         = $request->product_id;
        $order_id           = (isset($request->order_id) && $request->order_id != "")? $request->order_id: 0;

        if($order_id  > 0){
            $order_product_variants         = OrderProductVariant::where(['order_id'=> $order_id, 'product_id'=> $product_id])->get();
        }
        
        // dd( $order_product_variants);
        $product_detail     = Product::with( 'ProductVariant', 'ProductVariant.Atrributes')->where('id', $product_id)->first();
        return view('admin.orders.product', compact('product_detail', 'order_product_variants'));
        
    }
    public function print_nd_loations(Request $request){
       
        $type                       = "";  
        $order_price                = []; 
        $order_color_location      = []; 
        $product_id         = $request->product_id;
        $order_id           = (isset($request->order_id) && $request->order_id != "")?$request->order_id:0;
        $product_detail     = Product::with('ProductVariant', 'ProductVariant.Atrributes')->where('id', $product_id)->first();


        if($order_id > 0){
            $order_prices    = OrderPrice::where(["order_id"=>$order_id, "product_id"=>$product_id])->get();
            
            foreach($order_prices as $key=>$price){
                $order_price['whole_sale'][]        = $price->wholesale_price;
                $order_price['print_price'][]       = $price->print_price;
                $order_price['total_price'][]       = $price->total_price;
                $order_price['profit_margin'][]     = $price->profit_margin;
                $order_price['final_price'][]       = $price->final_price;
                $order_price['profit_margin_percentage'][]       = $price->profit_margin_percentage;
            }
            $order_color_locations    = OrderColorPerLocation::where(["order_id"=>$order_id, "product_id"=>$product_id])->get();

            foreach($order_color_locations as $key=>$location){
                $order_color_location[]        = $location->color_per_location;
            }
        }
        foreach($product_detail->ProductVariant as $productVariant){
            
            if($productVariant->name == "Baby Size"){
                $type       = "Baby Size";
                break;
            }
        }
        return view('admin.orders.print-locations', compact('product_detail', 'type', 'order_price', 'order_color_location'));
    }

    public function get_decoration_price(Request $request)
    {
  
        $number_of_colors       = $request->number_of_colors;
        $total_pieces           = $request->total_pieces;
        $range                  = 0;
        $price_ranges           = PriceRange::orderBy('range')->get();
        $price                  = 0;

        if($total_pieces <= 12){
            $range          = 12;
        }else{
            foreach($price_ranges as $price_range){
                if($price_range->range == $total_pieces ){
                    $range          = $total_pieces;
                    break;
                }else{
                    if($price_range->range < $total_pieces){
                        $range          = $price_range->range;
                    }
                }
            }
        }
        foreach($number_of_colors as $key=>$number_of_color){
            $prices         = DecorationPrice::where(["number_of_colors"=>$number_of_color, "range"=>$range])->first('value');
            $price          = $price+$prices->value;
        }
        
        $price      = number_format($price,2);
        return $price;
    }
    public function generateInvoice(Request $request)
    {
         $pageTitle                              = "Invoice";
        return view('admin.orders.generate-invoice',compact('pageTitle'));
    }
}