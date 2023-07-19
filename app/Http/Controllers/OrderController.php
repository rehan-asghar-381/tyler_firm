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
use App\Models\OrderFinalPriceProductVariants;
use App\Models\OrderPrintLocationColor;
use App\Models\SupplyInventoryItem;
use App\Models\ClientMeasurement;
use Yajra\DataTables\DataTables;
use App\Traits\NotificationTrait;

class OrderController extends Controller
{
    use NotificationTrait;
    function __construct()
    {
       $this->middleware('permission:orders-list|orders-edit', ['only' => ['index']]);
       $this->middleware('permission:orders-edit', ['only' => ['edit','update']]);
       $this->middleware('permission:orders-view', ['only' => ['show']]);
       $this->middleware('permission:orders-change-status', ['only' => ['status_update']]);
       $this->middleware('permission:orders-generate-invoice', ['only' => ['status_update']]);
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
        ->addColumn('reseller_number', function ($data) {
            if (isset($data->client->reseller_number) && $data->client->reseller_number != "")
                return $data->client->reseller_number;
            else
                return '-';
        })
        ->editColumn('first_name', function ($data) {
            if (isset($data->client->first_name) && $data->client->first_name != "")
                return $data->client->first_name;
            else
                return '-';
        })
        ->editColumn('last_name', function ($data) {
            if (isset($data->client->last_name) && $data->client->last_name != "")
                return $data->client->last_name;
            else
                return '-';
        })
        ->editColumn('email', function ($data) {
            if (isset($data->client->email) && $data->client->email != "")
                return $data->client->email;
            else
                return '-';
        })
        ->editColumn('phone_number', function ($data) {
            if (isset($data->client->phone_number) && $data->client->phone_number != "")
                return $data->client->phone_number;
            else
                return '-';
        })
        ->editColumn('country', function ($data) {
            if ($data->country != "")
                return $data->country;
            else
                return '-';
        })
        ->editColumn('title', function ($data) {
            if ($data->title != "")
                return $data->title;
            else
                return '-';
        })
        ->editColumn('job_name', function ($data) {
            if ($data->job_name != "")
                return $data->job_name;
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
        $order_type_id      = 1; 
        return view('admin.orders.create',compact('pageTitle','products', 'clients', 'brands'));

    } 

    public function store(Request $request)
    {  
        $user_id                    = Auth::user()->id;
        $user_name                  = Auth::user()->name;     
        $rData                      = $request->all();
  
        $order                      = new Order();
        $order->time_id             = date('U');
        $order->client_id           = $rData['client_id'];
        $order->job_name            = $rData['job_name'];
        $order->order_number        = $rData['order_number'];
        $order->status              = 1;
        $order->created_by_id       = $user_id;
        $order->created_by_name     = $user_name;
        $order->save();
        $orderID                    = $order->id;
        $product_ids                = $rData['product_ids'];
        $products_name              = $rData['products_name'];
        if (count($product_ids) > 0) {

            $this->save_order_products($product_ids,$products_name, $orderID);
        }

        $attribute_id                           = $rData['attribute_id'];
        $pieces                                 = $rData['pieces'];
        $prices                                 = $rData['price'];
        $total                                  = $rData['total'];

        if (count($attribute_id) > 0) {

            $this->save_product_attribute($attribute_id,$pieces,$prices,$total, $orderID);
        }
        $plsize                                     = $rData['plsize'];
        if (count($plsize) > 0) {

            $this->save_order_print_location_colors($rData, $orderID);
        }
        $location_charge                            = $rData['location_charge'];
        if (count($location_charge) > 0) {

            $this->save_order_contract_print_prices($rData, $orderID);
        }
        $fold_bag_tag_pieces                            = $rData['fold_bag_tag_pieces'];
        if (isset($location_charge)) {

            $this->save_order_other_charges($rData, $orderID);
        }
        $this->order_transfer($rData, $orderID);
        $margin_size                            = $rData['margin_size'];
        if (count($margin_size) > 0) {

            $this->order_margins($rData, $orderID);
        }
        $fp_attribute_id                                 = $rData['fp_attribute_id'];
        $fp_price                                        = $rData['fp_price'];
        if (count($fp_attribute_id) > 0) {
            $this->save_order_final_price_product_variants($fp_attribute_id,$fp_price, $orderID);
        }
        
        return redirect()->route("admin.order.create")->withSuccess('Order data has been saved successfully!');
    }
    public function order_transfer($rData, $order_id){

        $order                            = Order::find($order_id);
        $order_transfer                   = new OrderTransfer();
        $order_transfer->order_id         = $order_id;
        $order_transfer->transfers_pieces = $rData['transfers_pieces'];
        $order_transfer->transfers_pieces = $rData['transfers_pieces'];
        $order_transfer->transfers_prices = $rData['transfers_prices'];
        $order_transfer->ink_color_change_pieces = $rData['ink_color_change_pieces'];
        $order_transfer->art_discount_prices = $rData['art_discount_prices'];
        $order_transfer->save();

    }

    public function order_margins($rData, $order_id){
        $order                  = Order::find($order_id);
        $order_margin_arr = [];
        foreach ($rData['margin_size'] as $key => $label) {

            $order_margin                         = new OrderMargin();

            $order_margin->order_id               = $order_id;
            $order_margin->min_profit_margin      = $rData['min_profit_margin'];
            $order_margin->max_profit_margin      = $rData['max_profit_margin'];
            $order_margin->margin_size            = $rData['margin_size'][$key];
            $order_margin->min_margin             = $rData['min_margin'][$key];
            $order_margin->max_margin             = $rData['max_margin'][$key];
            // dd($order_margin);
            $order_margin_arr[]                   = $order_margin;
            $order->OrderMargin()->saveMany($order_margin_arr);
        }


    } 
    public function save_order_final_price_product_variants($attribute_id,$prices,$order_id){
        $order                  = Order::find($order_id);
        $order_product_variant_arr = [];
        foreach ($attribute_id as $product_id => $attr_ids) {
            foreach ($attr_ids as $at_id => $ids) {
                $order_product_var               = new OrderFinalPriceProductVariants();
                $order_product_var->order_id     = $order_id;
                $order_product_var->product_id        = $product_id;
                $product_variant = ProductVariant::find($at_id);
                $order_product_var->variant_id = $at_id;
                $order_product_var->variant_name = $product_variant->name;
                $product_variant_attribute = ProductVariantAttribute::find($ids[0]);
                $order_product_var->attribute_id = $ids[0];
                $order_product_var->attribute_name = $product_variant_attribute->name;
                $order_product_var->price = $prices[$product_id][0];
                $order_product_variant_arr[]  = $order_product_var;
                $order->OrderFinalPriceProductVariants()->saveMany($order_product_variant_arr);
            }
        }
    }
    public function save_order_other_charges($rData, $order_id){
        $order_other_charges                        = new OrderOtherCharges();
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
    public function save_order_contract_print_prices($rData, $order_id){
        $order                  = Order::find($order_id);
        $order_contract_print_price_arr = [];
        foreach ($rData['location_charge'] as $key => $label) {

            $order_contract_print_price               = new OrderContractPrintPrice();

            $order_contract_print_price->order_id               = $order_id;
            $order_contract_print_price->location_charge        = $label;
            $order_contract_print_price->location_charge_price  = $rData['location_charge_price'][$key];
            $order_contract_print_price->size                   = $rData['location'][$key];
            $order_contract_print_price->size_total_price       = $rData['location_color'][$key];
            $order_contract_print_price_arr[]                   = $order_contract_print_price;
            $order->OrderProducts()->saveMany($order_contract_print_price_arr);
        }
    } 
    public function save_order_print_location_colors($rData, $order_id){
        $order                  = Order::find($order_id);
        $order_print_price_location_arr = [];
        foreach ($rData['plsize'] as $key => $label) {

            $order_print_price_location               = new OrderPrintLocationColor();

            $order_print_price_location->order_id     = $order_id;
            $order_print_price_location->projected_units        = $rData['projected_units'];
            $order_print_price_location->quantity_break        = $rData['quantity_break'];
            $order_print_price_location->size        = $label;
            $order_print_price_location->size_price        = $rData['size_price'][$key];
            $order_print_price_location->location        = $rData['location'][$key];
            $order_print_price_location->location_color        = $rData['location_color'][$key];
            $order_print_price_location_arr[]  = $order_print_price_location;
            $order->OrderProducts()->saveMany($order_print_price_location_arr);

        }
    }

    public function save_product_attribute($attribute_id,$pieces,$prices,$total, $order_id){
        $order                  = Order::find($order_id);
        $order_product_variant_arr = [];
        foreach ($attribute_id as $product_id => $attr_ids) {
            foreach ($attr_ids as $at_id => $ids) {
                
                $order_product_var               = new OrderProductVariant();
                $order_product_var->order_id     = $order_id;
                $order_product_var->product_id        = $product_id;
                $product_variant = ProductVariant::find($at_id);
                $order_product_var->variant_id = $at_id;
                $order_product_var->variant_name = $product_variant->name;
                $product_variant_attribute = ProductVariantAttribute::find($ids[0]);
                $order_product_var->attribute_id = $ids[0];
                $order_product_var->attribute_name = $product_variant_attribute->name;
                $order_product_var->pieces = $pieces[$product_id][0];
                $order_product_var->price = $prices[$product_id][0];
                $order_product_var->total = $total[$product_id][0];
                $order_product_variant_arr[]  = $order_product_var;
                $order->OrderProductVariant()->saveMany($order_product_variant_arr);
            }
        }
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

        $order->OrderProducts()->saveMany($order_products_arr);
    }
    public function edit($id)
    {
        $pageTitle                  = "Orders";
        $errors                     = [];
        $order                      = Order::with([
            'OrderSupply', 
            'OrderImgs', 
            'AdditionalFields', 
            'Orderstatus',
            'OrderTill'
        ])->find($id);
        $order_types                = OrderType::where('is_active', 'Y')->get();
        $shop_sizes                 = ShopSize::where('is_active', 'Y')->get();
        $clients                    = Client::get();
        $payments_types             = PaymentType::where('is_active', 'Y')->get();
        $inventory_items            = SupplyInventoryItem::get();
        return view('admin.orders.edit',compact('pageTitle', 'order', 'order_types', 'shop_sizes', 'clients', 'errors', 'inventory_items', 'payments_types'));

    }

    public function update(Request $request, $id)
    {
        $user_id                        = Auth::user()->id;
        $user_name                      = Auth::user()->name;

        $rData                          = $request->all();
        $order_supplies_arr             = [];
        $order_images                   = [];
        $order_additional_fields_arr    = [];
        $order                          = Order::find($id);
        app('App\Http\Controllers\ClientController')->save_measurements($request, $order->client_id);
        $order->title                   = $rData['title'];
        $order->order_type              = $rData['order_type'];
        $order->measurement_type        = $rData['measurement_type'];
        $order->field1_hb               = $rData['field1_hb'];
        $order->field2_b                = $rData['field2_b'];
        $order->field3_w                = $rData['field3_w'];
        $order->field4_hh               = $rData['field4_hh'];
        $order->field5_h                = $rData['field5_h'];
        $order->field6_sh               = $rData['field6_sh'];
        $order->field7_half_sh          = $rData['field7_half_sh'];
        $order->field8_sh_w             = $rData['field8_sh_w'];
        $order->field9_sh_kn            = $rData['field9_sh_kn'];
        $order->field10_sh_g            = $rData['field10_sh_g'];
        $order->field11_w_kn            = $rData['field11_w_kn'];
        $order->field12_w_g             = $rData['field12_w_g'];
        $order->field13_arm             = $rData['field13_arm'];
        $order->field14_half_arm        = $rData['field14_half_arm'];
        $order->field15_arm_depth       = $rData['field15_arm_depth'];
        $order->field16_bicep           = $rData['field16_bicep'];
        $order->field17_wrist           = $rData['field17_wrist'];
        $order->field18_sh_w            = $rData['field18_sh_w'];
        $order->field19_tw              = $rData['field19_tw'];
        $order->field20_sh_hh           = $rData['field20_sh_hh'];
        $order->description             = $rData['description'];
        $order->order_date              = $rData['order_date'];
        $order->order_date_timestamp            = strtotime($rData['order_date']);
        $order->collection_date                 = $rData['collection_date'];
        $order->collection_date_timestamp       = strtotime($rData['collection_date']);
        $order->tailor_comments                 = $rData['tailor_comments'];
        $order->updated_by_id                   = $user_id;
        $order->updated_by_name                 = $user_name;
        $order->save();
        if($request->hasFile('filePhoto')){

            if(count($request->file('filePhoto')) > 0 ){
                foreach($request->file('filePhoto') as $file){

                    $original_name = $file->getClientOriginalName();
                    $file_name = time().rand(100,999).$original_name;
                    $destinationPath = public_path('/uploads/order/');
                    $file->move($destinationPath, $file_name);
                    $file_slug  = "/uploads/order/".$file_name;

                    $order_id                       = $order->id;
                    $order_img                      = new OrderImgs();

                    $order_img->order_id            = $order_id;
                    $order_img->image               = $file_slug;

                    $order_images[]                 = $order_img;
                }

                $order->OrderImgs()->saveMany($order_images);

            }
        }
        
        $fields                                 = $rData['fields'];
        $labels                                 = $rData['labels'];
        if (count($fields) > 0) {

            foreach ($fields as $key=>$field_value) {

                $order_id                       = $order->id;
                $additional_field               = new OrderAdditional();

                $additional_field->order_id     = $order_id;
                $additional_field->label        = $labels[$key];
                $additional_field->value        = $field_value;

                $order_additional_fields_arr[]  = $additional_field;
            }
            $order->AdditionalFields()->delete();
            $order->AdditionalFields()->saveMany($order_additional_fields_arr);
        }

        $supplies                   = $rData['suply_info'];
        $supply_quantities          = $rData['quantity'];

        if (count($supplies) > 0) {

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

                $order_id                       = $order->id;
                $order_supplies                 = new OrderSupply();

                $order_supplies->order_id       = $order_id;
                $order_supplies->item_slug      = $item_slug;
                $order_supplies->quantity       = $supply_quantities[$key];

                $order_supplies_arr[]           = $order_supplies;
            }

            $order->OrderSupply()->delete();
            $order->OrderSupply()->saveMany($order_supplies_arr);
        }

        $order_till                     = new OrderTill();
        $order_till->order_id           = $order->id;
        $order_till->client_id          = $order->client_id;
        $order_till->selling_price      = $rData['selling_price'];
        $order_till->deposit            = $rData['deposit'];
        $order_till->balance            = $rData['balance'];
        $order_till->payment_type       = $rData['payment_type'];
        $order_till->created_by_id      = $user_id;
        $order_till->created_by_name    = $user_name;

        $order->OrderTill()->delete();
        $order->OrderTill()->save($order_till);

        $body                           = $user_name." updated the Order ( <strong>#".$order->id."</strong> )";
        $data['idFK']                   = $order->id;
        $data['type']                   = 'orders';
        $data['added_by_id']            = $user_id;
        $data['added_by_name']          = $user_name;
        $data['body']                   = $body;
        $data['time_id']                = date('U');
        $this->add_notification($data);

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

        $product_id         = $request->product_id;
        // $payments_types     = PaymentType::where('is_active', 'Y')->get();
        $payments_types     = [];
        $product_detail     = Product::with( 'ProductVariant', 'ProductVariant.Atrributes')->where('id', $product_id)->first();
        return view('admin.orders.product', compact('product_detail', 'payments_types'));
        
    }
    public function print_nd_loations(Request $request){

        $product_id         = $request->product_id;
        $product_detail     = Product::with( 'ProductVariant', 'ProductVariant.Atrributes')->where('id', $product_id)->first();
        return view('admin.orders.print-locations', compact('product_detail'));
    }

    public function get_decoration_price(Request $request)
    {
        $number_of_colors       = $request->number_of_colors;
        $total_pieces           = $request->total_pieces;
        $range                  = 0;
        $price_ranges           = PriceRange::orderBy('range')->get();

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

        $price  = DecorationPrice::where(["number_of_colors"=>$number_of_colors, "range"=>$range])->first();
        // dd($price );
        return $price->value;
    }
    public function generateInvoice(Request $request)
    {
         $pageTitle                              = "Invoice";
        return view('admin.orders.generate-invoice',compact('pageTitle'));
    }
}