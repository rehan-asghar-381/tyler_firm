<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderImgs;
use App\Models\orderArtFile;
use App\Models\orderCompFile;
use App\Models\OrderArtDetail;
use App\Models\OrderCompDetail;
use App\Models\Status;
use App\Models\Client;
use App\Models\OrderTransfer;
use App\Models\PrintLocation;
use App\Models\Product;
use App\Models\Brand;
use App\Models\QuoteApproval;
use App\Models\Blank;
use App\Models\OrderOtherCharges;
use App\Models\OrderProductVariant;
use App\Models\PriceRange;
use App\Models\OrderProduct;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use App\Models\DecorationPrice;
use App\Models\OrderPrice;
use App\Models\OrderColorPerLocation;
use App\Models\OrderDYellow;
use App\Models\ClientSaleRep;
use App\Models\DYellowInkColor;
use Yajra\DataTables\DataTables;
use App\Traits\NotificationTrait;
use App\Models\EmailLog;
use App\Models\CompStatus;
use App\Models\EmailTemplate;
use PDF;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ActionSeen;
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
       $this->middleware('permission:orders-generate-invoice', ['only' => ['generateInvoice']]);
       $this->middleware('permission:orders-recreate', ['only' => ['recreate']]);

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
    public function index(Request $request)
    {

        
        $pageTitle                              = "Orders";
        $statuses_arr                           = [];
        $status_filter                          = "";
        $comp_filter                            = "";
        $filter_type                            = $request->has('filter_type') ? $request->filter_type: 0;
        $filter_value                           = $request->has('filter_value') ? $request->filter_value: "";
        if($filter_type == 1 && $filter_value != "" ){
            $status_filter_ob                   = Status::where('name', $filter_value)->first();
            $status_filter                      = $status_filter_ob->id;
        }elseif($filter_type == 2 && $filter_value != ""){
            $comp_filter                        = $filter_value;
        }
        $statuses                               = Status::where('is_active', 'Y')->get(['id', 'name']);
        $comp_statuses                          = CompStatus::get();
        foreach($statuses as $key=>$status){

            $statuses_arr['"'.$key.'"']          = $status;
        }
// 
        $blank_arr                           = [];
        $blank                               = Blank::where('is_active', 'Y')->get(['id', 'name']);
        
        foreach($blank as $key=>$status){

            $blank_arr['"'.$key.'"']          = $status;
        }

        $quote_approval_arr                           = [];
        $quote_approval                               = QuoteApproval::where('is_active', 'Y')->get(['id', 'name']);
        
        foreach($quote_approval as $key=>$status){

            $quote_approval_arr['"'.$key.'"']          = $status;
        }
        
        $clients        = Client::get();

        return view('admin.orders.index', compact('pageTitle', 'statuses_arr', 'blank_arr','quote_approval_arr','clients', 'comp_statuses', 'status_filter', 'comp_filter'));
    } 

    public function ajaxtData(Request $request){
        $user_id            = Auth::user()->id;
        $statuses           = Status::where('is_active', 'Y')->get(['id', 'name']);
        $comp_statuses      = CompStatus::get();
        $quote_approval     = QuoteApproval::where('is_active', 'Y')->get(['id', 'name']);
        $blanks             = Blank::where('is_active', 'Y')->get(['id', 'name']);
        $rData              = Order::withCount("EmailLog")->with(["client", "ClientSaleRep","ActionSeen"=>function($q) use($user_id){
            $q->where('seen_by', '=', $user_id);
        
        }])->where('status','<>',5);
        
        if($request->client_id != ""){
            $rData              = $rData->where('client_id', $request->client_id);
        }
        
        if($request->comp_status != ""){
            $rData              = $rData->where('comp_approval', $request->comp_status);
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
        // ->addIndexColumn()
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
                return date("m-d-Y", $data->due_date);
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
        ->editColumn('status', function ($data) use($statuses){

            if (isset($data->Orderstatus->name) && $data->Orderstatus->name != ""){
                $cls        = 'light';
                if($data->status == 1){
                    
                    $cls        = 'light';
                }
                if($data->status == 2){
                    $cls        = 'warning';
                }
                if($data->status == 3){
                    $cls        = 'pink';
                }
                if($data->status == 4){
                    $cls        = 'violet';
                }
                if($data->status == 5){
                    $cls        = 'sucess-custom';
                }
                if($data->status == 6){
                    $cls        = 'primary';
                }
                $html   = '<div class="btn-group mb-2 mr-1">
                            <button type="button" class="btn btn-'.$cls.' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="white-space: nowrap;width:110px;">'.$data->Orderstatus->name.'</button>
                            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -152px, 0px); top: 0px; left: 0px; will-change: transform;">';
                foreach($statuses as $status){
                    $html   .= '<a class="dropdown-item btn-change-status" href="#" data-status-id="'.$status->id.'" data-order-id="'.$data->id.'">'.$status->name.'</a>';
                }
                $html   .=    '</div></div>';

                return $html;
            
            }else{

                return '-';
            }
        })
        ->editColumn('comp_approval', function ($data) use($comp_statuses){
            $cls            = "";
            $inner_html     = "";
            $name           = ($data->comp_approval != "") ? $data->comp_approval: "--select";
            foreach($comp_statuses as $status){
                if($data->comp_approval == $status->name){

                    $cls            = $status->class;
                }
                $inner_html   .= '<a class="dropdown-item btn-change-comp-status" href="#" data-status-id="'.$status->name.'" data-order-id="'.$data->id.'">'.$status->name.'</a>';
            }

            $html   = '<div class="btn-group mb-2 mr-1">
                        <button type="button" class="btn btn-'.$cls.'" style="white-space: nowrap;width:140px;">'.$name.'</button>';
            
            // $html   .=    $inner_html;
            $html   .=    '</div>';

            return $html;
            
           
        })
        ->editColumn('quote_approval', function ($data) use($quote_approval){
            if(isset($data->QuoteApproval->name)){
                $name   = $data->QuoteApproval->name;
            }else{
                $name   = "--select";
            }
            $cls        = 'light';
            if($data->quote_approval == 1){
                
                $cls        = 'sucess-custom';
            }
            if($data->quote_approval == 2){
                $cls        = 'danger';
            }
            $html   = '<div class="btn-group mb-2 mr-1">
            <button type="button" class="btn btn-'.$cls.' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="white-space: nowrap;width:110px;">'.$name.'</button>
            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -152px, 0px); top: 0px; left: 0px; will-change: transform;">';
            foreach($quote_approval as $quote){
                $html   .= '<a class="dropdown-item btn-change-quote_approval" href="#" data-status-id="'.$quote->id.'" data-order-id="'.$data->id.'">'.$quote->name.'</a>';
            }
            $html   .=    '</div></div>';

            return $html;
                
        })
        ->editColumn('blank', function ($data) use($blanks){
            if(isset($data->Blank->name)){
                $name   = $data->Blank->name;
            }else{
                $name   = "--select";
            }
            $cls        = 'light';
            if($data->blank == 2){
                
                $cls        = 'sucess-custom';
            }
            if($data->blank == 1){
                $cls        = 'danger';
            }
            $html   = '<div class="btn-group mb-2 mr-1">
            <button type="button" class="btn btn-'.$cls.' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="white-space: nowrap;width:110px;">'.$name.'</button>
            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -152px, 0px); top: 0px; left: 0px; will-change: transform;">';
            foreach($blanks as $blank){
                $html   .= '<a class="dropdown-item btn-change-blank" href="#" data-status-id="'.$blank->id.'" data-order-id="'.$data->id.'">'.$blank->name.'</a>';
            }
            $html   .=    '</div></div>';
            return $html;
        })
        ->editColumn('order_date', function ($data) {
            if ($data->time_id > 0 )
                return date('m-d-Y',$data->time_id);
            else
                return '-';
        })
        ->addColumn('notification', function ($data) use($user_id){
            if($data->email_log_count == 1){

                return '<span class="badge badge-light action-logs" data-id="'.$data->id.'" style="cursor:pointer;">Email Sent</span>';
            }elseif (count($data->ActionSeen) == $data->email_log_count ){

                return '<span class="badge badge-primary action-logs" data-id="'.$data->id.'" style="cursor:pointer;">Activity Seen</span>';
            }else{

                return '<span class="badge badge-info blinking" data-id="'.$data->id.'" data-user-id="'.$user_id.'">View Activity</span>';
            }
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
            if(auth()->user()->can('orders-delete')){
                $action_list    .= '<a class="dropdown-item del" href="'.route('admin.order.delete', $data->id).'"><i class="far fa-trash-alt"></i> Delete</a>';
            }
            if(auth()->user()->can('orders-replicate')){
            
            $action_list    .= '<a class="dropdown-item" href="'.route('admin.order.recreate', $data->id).'"><i class="far fa fa-retweet"></i> Re-Order</a>';
            }
            if(auth()->user()->can('orders-generate-d-yellow')){
            $action_list    .= '<a class="dropdown-item" href="'.route('admin.order.DYellow', $data->id).'"><i class="far fa fa-file"></i> Create Yellow</a>';
        }
            $url  = route('admin.order.edit', $data->id).'?comp_tab=true';
            $action_list    .= '<a class="dropdown-item" href="'.$url.'"><i class="far fa fa-file"></i> Comps View </a>';
            if(auth()->user()->can('orders-generate-invoice')){
                $action_list    .= '<a class="dropdown-item "  href="'.route('admin.order.generateInvoice', $data->id) .'" data-status="'.$data->status.'" data-id="'.$data->id.'"><i class="far fa fa-print"></i> Generate Invoice</a>';
            }
            // if(auth()->user()->can('orders-change-status')){
            //     $action_list    .= '<a class="dropdown-item btn-change-status" href="#" data-status="'.$data->status.'" data-id="'.$data->id.'"><i class="far fa fa-life-ring"></i> Change Status</a>';
            // }
            //  if(auth()->user()->can('orders-approve-quote')){
            //     $action_list    .= '<a class="dropdown-item btn-change-quote_approval" href="#" data-quote_approval="'.$data->quote_approval.'" data-id="'.$data->id.'"><i class="hvr-buzz-out fab fa-galactic-republic"></i> Quote Approval</a>';
            // }
            // if(auth()->user()->can('orders-blank')){
            //     $action_list    .= '<a class="dropdown-item btn-change-blank" href="#" data-blank="'.$data->blank.'" data-id="'.$data->id.'"><i class="hvr-buzz-out fab fa-hornbill"></i> Blanks</a>';
            // }
            if(auth()->user()->can('orders-action-log')){
                $action_list    .= '<a class="dropdown-item action-logs" href="#" data-id="'.$data->id.'"><i class="hvr-buzz-out far fa fa-history"></i> Action Log</a>';
            }
            if(auth()->user()->can('orders-send-email')){
                $action_list    .= '<a class="dropdown-item  send-email-modal" href="#" data-client_id="'.$data->client_id.'" data-id="'.$data->id.'" data-email="'.($data->ClientSaleRep->email ?? '').'"  data-sale_rep_name="'.($data->ClientSaleRep->first_name ?? '')." ".($data->ClientSaleRep->last_name ?? '').'" data-company_name="'.($data->client->company_name ?? '').'" data-job_name="'.($data->job_name ?? '').'" data-order_number="'.($data->order_number ?? '').'"><i class="hvr-buzz-out far fa-envelope"></i> Send Email</a>';
            }
            
            $action_list        .= '</div></div>';
            return  $action_list;
        })
        ->rawColumns(['actions', 'status', 'notification', 'blank', 'quote_approval', 'comp_approval'])
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
        $clients            = Client::orderBy("company_name", "asc")->get();
        $products           = Product::orderBy("name", "asc")->get();
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

        $due_date                   = explode("-", $rData['due_date']);
        $due_date                   = (count($due_date)>0  && $due_date[0])? $due_date[2]."-".$due_date[0]."-".$due_date[1]:"";
        $ship_date                   = explode("-", $rData['ship_date']);
        $ship_date                   = (count($ship_date)>0 && $ship_date[0])? $ship_date[2]."-".$ship_date[0]."-".$ship_date[1]:"";
        DB::beginTransaction();
        try {
            $order                      = new Order();
            $order->time_id             = date('U');
            $order->client_id           = $rData['client_id'];
            $order->sales_rep           = $rData['sales_rep'] ?? 0;
            $order->due_date            = (isset($due_date) && $due_date != "")?strtotime($due_date):0;
            $order->event               = $rData['event'];
            $order->shipping_address    = $rData['shipping_address'];
            $order->ship_method         = $rData['ship_method'];
            $order->ship_date           = (isset($ship_date) && $ship_date != "")?strtotime($ship_date):0;
            $order->shipping_address    = $rData['shipping_address'];
            $order->notes               = $rData['notes'];
            $order->internal_notes      = $rData['internal_notes'];
            $order->job_name            = $rData['job_name'];
            $order->order_number        = $rData['order_number'];
            $order->projected_units     = $rData['projected_units'];
            $order->status              = 1;
            $order->created_by_id       = $user_id;
            $order->created_by_name     = $user_name;
            $order->save();
            $orderID                    = $order->id;
            $selector_references_arr    = [];
            $selector_references        = $rData['product_size'] ?? [];
            if(count($selector_references) > 0){

                foreach($selector_references as $p_d=>$selector_reference){
                    foreach($selector_reference as $ref_id=>$ref_size){
                        $selector_references_arr[$p_d][] = $ref_id;
                    }
                }
            }
            
            $product_ids                = $rData['product_ids'] ?? [];
            $products_name              = $rData['products_name'] ?? [];
            if($request->hasFile('filePhoto')){
                if(count($request->file('filePhoto')) > 0 ){
                    $this->save_order_imgs($request->file('filePhoto'), $orderID);
                }
            }
            if(count($product_ids) > 0){
                $this->save_order_prices($orderID, $rData);
            }
            if (count($product_ids) > 0) {
                $this->save_order_products($product_ids,$products_name, $orderID, $selector_references_arr);
            }
            $attribute_color                        = $rData['attribute_color'] ?? [];
            $attribute_size                         = $rData['attribute_size'] ?? [];
            $pieces                                 = $rData['pieces'] ?? [];
            $prices                                 = $rData['price'] ?? [];
            // $total                                  = $rData['total'];
            $total                                  = [];
            if (count($attribute_color) > 0 ) {
                $this->save_product_attribute($product_ids, $attribute_color,$attribute_size,$pieces,$prices,$total, $orderID);
            }
            $this->save_order_other_charges($rData, $orderID);
            $this->order_transfer($rData, $orderID);
            if($request->hasFile('artFile')){
                if(count($request->file('artFile')) > 0 ){
                    $this->save_art_files($request->file('artFile'), $orderID);
                }
            }
            if($request->has('art_details') && $request->art_details != ""){

                $art_details        = $request->art_details;
                $this->save_art_details($art_details, $orderID);
            }
            if($request->hasFile('compFile')){
                $this->save_comp_files($request->file('compFile'), $orderID);
            }
            if($request->has('comp_details') && $request->comp_details != ""){
                $comp_details           = $request->comp_details;
                $this->save_comp_details($comp_details, $orderID);
            }

            $body                           = $user_name." created a <strong>New Order</strong> ( <strong>#".$order->id."</strong> )";
            $data['idFK']                   = $orderID;
            $data['type']                   = 'orders';
            $data['added_by_id']            = $user_id;
            $data['added_by_name']          = $user_name;
            $data['body']                   = $body;
            $data['time_id']                = date('U');
            // $this->add_notification($data);
            DB::commit();
            return redirect()->route('admin.order.edit', $orderID)->withSuccess('Order data has been saved successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            // $errorMessage = $e->getMessage();
            // $errorDetails = [
            //     'message' => $errorMessage,
            //     'code' => $e->getCode(),
            //     'file' => $e->getFile(),
            //     'line' => $e->getLine(),
            //     // 'trace' => $e->getTraceAsString(),
            // ];
        
            // // Now you can use $errorDetails as needed
            // dd($errorDetails);
        }
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
   public function save_art_files($files_arr=[], $order_id){
        $order                  = Order::find($order_id);
        
        $art_files              = [];
        foreach($files_arr as $file){             
            if(is_file($file)){
                $destinationPath        = public_path('/uploads/artfiles-'.$order_id.'/');
                $original_name = $file->getClientOriginalName();
                $file_name = time().rand(100,999).$original_name;
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $file->move($destinationPath, $file_name);
                $file_slug  = '/uploads/artfiles-'.$order_id.'/'.$file_name;
                $art_file                       = new orderArtFile();
                $art_file->order_id             = $order_id;
                $art_file->file                 = $file_slug;
                $art_files[]                    = $art_file;
            }
        }
        $order->OrderArtFiles()->saveMany($art_files);
        $order->comp_approval="In Art Room";
        $order->save();
        $user_name                      = Auth::user()->name;
        $user_id                        = Auth::user()->id;
        $body                           = $user_name." uploaded <strong>Art Files</strong> for <strong>".$order->job_name." </strong> ( <strong>#".$order->id."</strong> )";
        $data['idFK']                   = $order_id;
        $data['type']                   = 'arts';
        $data['added_by_id']            = $user_id;
        $data['added_by_name']          = $user_name;
        $data['body']                   = $body;
        $data['time_id']                = date('U');
        $this->add_notification($data);
    }
   public function save_comp_files($file, $order_id){
        $order                  = Order::find($order_id);
        $art_files              = [];           
        if(is_file($file)){
            $destinationPath        = public_path('/uploads/compfiles-'.$order_id.'/');
            $original_name = $file->getClientOriginalName();
            $file_name = time().rand(100,999).$original_name;
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777);
            }
            $file->move($destinationPath, $file_name);
            $file_slug  = '/uploads/compfiles-'.$order_id.'/'.$file_name;
            $art_file                       = new orderCompFile();
            $art_file->order_id             = $order_id;
            $art_file->file                 = $file_slug;
            $art_files[]                    = $art_file;
        }
        $order->orderCompFiles()->saveMany($art_files);
        $user_name                      = Auth::user()->name;
        $user_id                        = Auth::user()->id;
        $body                           = "Comp for <strong>".$order->job_name." is Ready! ( <strong>#".$order->id."</strong> )";
        $data['idFK']                   = $order_id;
        $data['type']                   = 'comps';
        $data['added_by_id']            = $user_id;
        $data['added_by_name']          = $user_name;
        $data['body']                   = $body;
        $data['time_id']                = date('U');
        $this->add_notification($data);
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
        $location_number                = $rData['location_number'];
        $color_per_location             = $rData['color_per_location'];
        $order_price_arr                = [];
        $order_color_perlocation_arr    = [];
        foreach($product_ids as $key=> $product_id){
            foreach($product_sizes[$product_id] as $selector_ref=>$_product_size){
                foreach($_product_size as $p_key=>$product_size){

                    $order_price                    = new OrderPrice();
                    $order_price->product_id        = $product_id;
                    $order_price->selector_ref      = $selector_ref;
                    $order_price->product_size      = $product_size;
                    $order_price->wholesale_price   = $wholesale_price[$product_id][$selector_ref][$p_key];
                    $order_price->print_price       = $print_price[$product_id][$selector_ref][$p_key];
                    $order_price->total_price       = $total_price[$product_id][$selector_ref][$p_key];
                    $order_price->profit_margin     = $profit_margin[$product_id][$selector_ref][$p_key];
                    $order_price->profit_margin_percentage     = $profit_margin_percentage[$product_id][$selector_ref][0];
                    $order_price->final_price       = $final_price[$product_id][$selector_ref][$p_key];
                    $order_price_arr[]              = $order_price;
                }
            }
            foreach($color_per_location[$product_id] as $_selector_ref=>$_color){
                foreach($_color as $key=>$color){
                    $order_color_perlocation                        = new OrderColorPerLocation();
                    $order_color_perlocation->product_id            = $product_id;
                    $order_color_perlocation->selector_ref          = $_selector_ref;
                    $order_color_perlocation->color_per_location    = $color;
                    $order_color_perlocation->location_number       = $location_number[$product_id][$_selector_ref][$key];
                    $order_color_perlocation_arr[]                  = $order_color_perlocation;
                    
                }   
            }   
        }
       $order->OrderPrice()->delete();
       $order->OrderPrice()->saveMany($order_price_arr);
       $order->OrderColorPerLocation()->delete();
       $order->OrderColorPerLocation()->saveMany($order_color_perlocation_arr);
    }
    public function order_transfer($rData, $order_id){
        OrderTransfer::where("order_id", $order_id)->delete();
        $order_transfer                             = OrderTransfer::firstOrNew(['order_id'=>$order_id]);
        $order_transfer->order_id                   = $order_id;
        $order_transfer->transfers_pieces           = $rData['transfers_pieces'];
        $order_transfer->transfers_pieces           = $rData['transfers_pieces'];
        $order_transfer->transfers_prices           = $rData['transfers_prices'];
        $order_transfer->ink_color_change_pieces    = $rData['ink_color_change_pieces'];
        $order_transfer->ink_color_change_prices    = $rData['ink_color_change_prices'];
        $order_transfer->art_fee                    = $rData['art_fee'];
        $order_transfer->shipping_pieces            = $rData['shipping_pieces'];
        $order_transfer->shipping_charges           = $rData['shipping_charges'];
        $order_transfer->save();
    }
    public function save_order_other_charges($rData, $order_id){

        OrderOtherCharges::where("order_id", $order_id)->delete();
        $order_other_charges                            = OrderOtherCharges::firstOrNew(['order_id'=>$order_id]);
        $order_other_charges->order_id                  = $order_id;
        $order_other_charges->fold_bag_tag_pieces       = $rData['fold_bag_tag_pieces'];
        $order_other_charges->fold_bag_tag_prices       = $rData['fold_bag_tag_prices'];;
        $order_other_charges->hang_tag_pieces           = $rData['hang_tag_pieces'];
        $order_other_charges->hang_tag_prices           = $rData['hang_tag_prices'];
        $order_other_charges->label_pieces              = $rData['label_pieces'];
        $order_other_charges->label_prices              = $rData['label_prices'];
        $order_other_charges->fold_pieces               = $rData['fold_pieces'];
        $order_other_charges->fold_prices               = $rData['fold_prices'];
        $order_other_charges->foil_pieces               = $rData['foil_pieces'];
        $order_other_charges->foil_prices               = $rData['foil_prices'];
        $order_other_charges->fold_bag_pieces           = $rData['fold_bag_pieces'];
        $order_other_charges->fold_bag_prices           = $rData['fold_bag_prices'];
        $order_other_charges->palletizing_pieces        = $rData['palletizing_pieces'];
        $order_other_charges->palletizing_prices        = $rData['palletizing_prices'];
        $order_other_charges->remove_packaging_pieces   = $rData['remove_packaging_pieces'];
        $order_other_charges->remove_packaging_prices   = $rData['remove_packaging_prices'];
        $order_other_charges->art_fee                   = $rData['art_fee'];
        $order_other_charges->art_discount              = $rData['art_discount'];
        $order_other_charges->art_time                  = $rData['art_time'];
        $order_other_charges->tax                       = $rData['tax'];
        $order_other_charges->save();
    } 

    public function save_product_attribute($product_ids, $attribute_color,$attribute_size,$pieces,$prices,$total, $order_id){
       
        $order                          = Order::find($order_id);
        $order_product_variant_arr      = [];
        
        foreach ($product_ids as $product_id) {
            
            foreach($attribute_color[$product_id] as $selector_ref=>$_attr_arr){
                foreach($_attr_arr as $variant_id=>$attr_arr){
                    $variant1_id                    = $variant_id;
                    $product_variant                = ProductVariant::find($variant_id);
                    $variant1_name                  = $product_variant->name;
                    $color_attr_arr[$selector_ref]  = $attr_arr;
                }
            }
            foreach($attribute_size[$product_id] as $selector_ref=>$_attr_arr){
                foreach($_attr_arr as $variant_id=>$attr_arr){
                    $variant2_id                            = $variant_id;
                    $product_variant                        = ProductVariant::find($variant_id);
                    $variant2_name                          = $product_variant->name;
                    $size_attr_arr[$selector_ref]           = $attr_arr;
                }
            }
            foreach($color_attr_arr as $selector_ref=>$_color_attr_arr){
                $color_count            = count($_color_attr_arr);
                $size_count             = count($size_attr_arr[$selector_ref]);

                $chunk_size             = $size_count/$color_count;
                $chunked_size_arr       = array_chunk($size_attr_arr[$selector_ref], $chunk_size );
                $chunked_pieces_arr     = array_chunk($pieces[$product_id][$selector_ref], $chunk_size);
                $chunked_prices_arr     = array_chunk($prices[$product_id][$selector_ref], $chunk_size);

                foreach($_color_attr_arr as $key=>$attr_id){
                    foreach($chunked_size_arr[$key] as $chunk_arr_key=>$attribute2_id){
                        $order_product_var                      = new OrderProductVariant();
                        $order_product_var->order_id            = $order_id;
                        $order_product_var->product_id          = $product_id;
                        $order_product_var->selector_ref        = $selector_ref;
                        $order_product_var->variant1_id         = $variant1_id;
                        $order_product_var->variant1_name       = $variant1_name ;
                        $order_product_var->variant2_id         = $variant2_id;
                        $order_product_var->variant2_name       = $variant2_name;
                        $order_product_var->attribute1_id       = $attr_id ?? 0;
                        $product_variant_attribute              = ProductVariantAttribute::find($attr_id);
                        $order_product_var->attribute1_name     = $product_variant_attribute->name ??"";
                        $order_product_var->attribute2_id       = $attribute2_id;
                        $product_variant_attribute              = ProductVariantAttribute::find($attribute2_id);
                        $order_product_var->attribute2_name     = $product_variant_attribute->name??"";
                        $order_product_var->pieces              = $chunked_pieces_arr[$key][$chunk_arr_key]??0;
                        $order_product_var->price               = $chunked_prices_arr[$key][$chunk_arr_key]??0;
                        // $order_product_var->total               = $total[$product_id][$selector_ref][$key]??0;
                        $order_product_variant_arr[]            = $order_product_var;

                    }
                }     
            }     
        }
       
        $order->OrderProductVariant()->delete();
        $order->OrderProductVariant()->saveMany($order_product_variant_arr);
    }
    public function save_order_products($product_ids,$products_name, $order_id, $selector_references_arr=[]){
        $order                  = Order::find($order_id);
        $order_products_arr     = [];
        foreach ($product_ids as $key=>$product) {
            foreach ($selector_references_arr[$product] as $selector_reference) {
                    $order_products                 = new OrderProduct();
                    $order_products->order_id       = $order_id;
                    $order_products->product_id     = $product;
                    $order_products->selector_ref   = $selector_reference;
                    $order_products->product_name   = $products_name[$product];
                    $order_products_arr[]  = $order_products;
            }
        }
        $order->OrderProducts()->delete();
        $order->OrderProducts()->saveMany($order_products_arr);
    }
    public function edit(Request $request, $id)
    {
       
        $pageTitle                  = "Orders";
        $order                      = Order::with([
            'OrderPrice', 
            'OrderImgs', 
            'OrderColorPerLocation', 
            'OrderProducts', 
            'Orderstatus',
            'OrderProductVariant',
            'OrderTransfer',
            'OrderOtherCharges',
            'OrderArtFiles',
            'OrderArtDetail',
            'orderCompFiles',
            'OrderCompDetail'
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
                $order_product_ids_arr[$orderProduct->product_id][$orderProduct->selector_ref]    = $orderProduct->product_id;
            }
        }
        $active_art_room            = false;
        $active_comp                = false;
        if(session('art_room')){
            $active_art_room        = true;
        }elseif(session('comp_tab') || ( $request->has('comp_tab') && $request->comp_tab == true) ){
            $active_comp            = true;
        }
        $comp_statuses      = CompStatus::get();
        return view('admin.orders.edit',compact('pageTitle', 'order', 'clients', 'products', 'fixed_sizes', 'all_adult_sizes', 'fixed_baby_sizes', 'all_baby_sizes', 'order_product_ids_arr', 'active_art_room', 'active_comp', 'comp_statuses'));
    }
    public function save_comp_details($comp_comment, $id){
        $user_id                = Auth::user()->id;
        $userRole               = (Auth::user()->hasRole('Artist'))?'Artist':'Assignee';
        $order_comp_detail      = new OrderCompDetail();
        $order_comp_detail->order_id        = $id;
        $order_comp_detail->comp_detail     = $comp_comment;
        $order_comp_detail->added_by        = $user_id;
        $order_comp_detail->added_by_role   = $userRole ;
        $order_comp_detail->save();
    }
    public function save_art_details($art_details, $id){
    
        $order_art_detail = OrderArtDetail::updateOrCreate(['order_id' => $id], [
            'art_detail' => $art_details
        ]);
    }
    public function update(Request $request, $id)
    {
        $user_id                    = Auth::user()->id;
        $user_name                  = Auth::user()->name; 
        DB::beginTransaction();
        try {
            if($request->has('is_art_submit') && $request->is_art_submit == 1){
                if($request->hasFile('artFile')){
                    if(count($request->file('artFile')) > 0 ){
                        $this->save_art_files($request->file('artFile'), $id);
                    }
                }
                if($request->has('art_details') && $request->art_details != ""){

                    $art_details        = $request->art_details;
                    $this->save_art_details($art_details, $id);
                }
                return redirect()->route("admin.order.edit", $id)->withSuccess('Art Room Data saved successfully!')->with('art_room', true);
            }
            if($request->has('is_comps_submit') && $request->is_comps_submit == 1){

                if($request->hasFile('compFile')){
                    $this->save_comp_files($request->file('compFile'), $id);
                }
                if($request->has('comp_details') && $request->comp_details != ""){
                    $comp_details           = $request->comp_details;
                    $this->save_comp_details($comp_details, $id);
                }
                return redirect()->route("admin.order.edit", $id)->withSuccess('Comp Details saved successfully!')->with('comp_tab', true);
            }
                
            $rData                      = $request->all();
            $due_date                   = explode("-", $rData['due_date']);
            $due_date                   = (count($due_date)>0  && $due_date[0])? $due_date[2]."-".$due_date[0]."-".$due_date[1]:"";
            $ship_date                   = explode("-", $rData['ship_date']);
            $ship_date                   = (count($ship_date)>0 && $ship_date[0])? $ship_date[2]."-".$ship_date[0]."-".$ship_date[1]:"";

            $order                      = Order::find($id);
            $order->client_id           = $rData['client_id'];
            $order->sales_rep           = $rData['sales_rep'];
            $order->due_date            = (isset($due_date) && $due_date != "")?strtotime($due_date):0;
            $order->ship_date           = (isset($ship_date) && $ship_date != "")?strtotime($ship_date):0;
            $order->event               = $rData['event'];
            $order->shipping_address    = $rData['shipping_address'];
            $order->ship_method         = $rData['ship_method'];
            $order->notes               = $rData['notes'];
            $order->internal_notes      = $rData['internal_notes'];
            $order->job_name            = $rData['job_name'];
            $order->order_number        = $rData['order_number'];
            $order->projected_units     = $rData['projected_units'];
            $order->updated_by_id       = $user_id;
            $order->updated_by_name     = $user_name;
            $order->save();
            $orderID                    = $order->id;
            $selector_references_arr    = [];
            $selector_references        = $rData['product_size'] ?? [];

            if(count($selector_references) > 0){

                foreach($selector_references as $p_d=>$selector_reference){
                    foreach($selector_reference as $ref_id=>$ref_size){
                        $selector_references_arr[$p_d][] = $ref_id;
                    }
                }
            }
            $product_ids                = $rData['product_ids'] ?? [];
            $products_name              = $rData['products_name'] ?? [];
            if(count($product_ids) > 0){
                $this->save_order_prices($orderID, $rData);
            }
    
            if (count($product_ids) > 0) {
                $this->save_order_products($product_ids,$products_name, $orderID, $selector_references_arr);
            }
            if($request->hasFile('filePhoto')){
                if(count($request->file('filePhoto')) > 0 ){
                    $this->save_order_imgs($request->file('filePhoto'), $orderID);
                }
            }
            $attribute_color                        = $rData['attribute_color'] ?? [];
            $attribute_size                         = $rData['attribute_size'] ?? [];
            $pieces                                 = $rData['pieces'] ?? [];
            $prices                                 = $rData['price'] ?? [];
            // $total                                  = $rData['total'];
            $total                                  = [];
            if (count($attribute_color) > 0 ) {
                $this->save_product_attribute($product_ids, $attribute_color,$attribute_size,$pieces,$prices,$total, $orderID);
            }
            $this->save_order_other_charges($rData, $orderID);
            $this->order_transfer($rData, $orderID);

            DB::commit();
            return redirect()->route("admin.order.edit", $orderID)->withSuccess('Order data has been updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function orderView(Request $request, $id)
    {
        $pageTitle                  = "Order Detail";
        $order                      = Order::with([
            'OrderProducts', 
            'OrderColorPerLocation', 
            'OrderPrice.OrderColorPerLocation', 
            'OrderProducts.OrderProductVariant'=>function($q) use($id){
                $q->where('order_id', '=', $id);
            },
            'Orderstatus',
            'OrderTransfer',
            'OrderOtherCharges'
        ])->find($id);
        $order_product_ids_arr      = [];
        $sales_rep                  = ClientSaleRep::find($order->sales_rep);
        $sales_rep_first            = $sales_rep->first_name ?? "";
        $sales_rep_last             = $sales_rep->last_name ?? "";
        $sales_rep_name             = $sales_rep_first . " " .$sales_rep_last;
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
        return view('admin.orders.order-detail',compact('pageTitle', 'order', 'sales_rep', 'products', 'fixed_sizes', 'all_adult_sizes', 'fixed_baby_sizes', 'all_baby_sizes', 'order_product_ids_arr', 'sales_rep_name'));
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
        $body                           = $user_name." set Status to <strong>".$order->Orderstatus->name."</strong> for Order ( <strong>#".$order->id."</strong> )";
        $data['idFK']                   = $order->id;
        $data['type']                   = 'orders';
        $data['added_by_id']            = $user_id;
        $data['added_by_name']          = $user_name;
        $data['body']                   = $body;
        $data['time_id']                = date('U');
        $this->add_notification($data);
        return json_encode(array("status"=>true, "message"=>"Status has been updated successfully!"));
    }
    public function quote_update(Request $request)
    {
        $user_id                = Auth::user()->id;
        $user_name              = Auth::user()->name;
        $order_id               = $request->get('order_id');
        $status                 = $request->get('status_id');
        $order                  = Order::find($order_id);
        $order->quote_approval  = $status;
        $order->save();
        return json_encode(array("status"=>true, "message"=>"Status has been updated successfully!"));
    }
    public function comp_status_update(Request $request)
    {
        $order_id               = $request->get('order_id');
        $status                 = $request->get('status_id');
        $comp_id                = $request->get('comp_id');
        $is_checked             = $request->get('is_checked');
        
        if($is_checked){
            $order                  = Order::find($order_id);
            $order->comp_approval   = $status;
            $order->save();
        }
        $comp                   = orderCompFile::where(["order_id"=>$order_id, "is_reflected"=>1])->first();
        if($comp){
            $comp->is_reflected   = 0;
            $comp->save();
        }
        $upComp                 = orderCompFile::find($comp_id);
        if($is_checked){
            $upComp->is_reflected   = 1;
        }
        $upComp->is_approved    = $status;
        $upComp->save();
        return json_encode(array("status"=>true, "message"=>"Comp Status has been updated successfully!"));
    }
    public function blank_update(Request $request)
    {
        $user_id                = Auth::user()->id;
        $user_name              = Auth::user()->name;
        $order_id               = $request->get('order_id');
        $status                 = $request->get('status_id');
        $order                  = Order::find($order_id);
        $order->blank          = $status;
        $order->save();
        return json_encode(array("status"=>true, "message"=>"Status has been updated successfully!"));
    }
    public function delete_image(Request $request)
    {
        $order_id               = $request->order_id;
        $img_id                 = $request->img_id;
        OrderImgs::where(['order_id'=> $order_id, 'id'=>$img_id])->delete();
        return json_encode(array("status"=>true));

    }
    public function compApprove(Request $request)
    {
        $id                 = $request->id;
        $order_id           = $request->order_id;
        $order              = Order::find($order_id);
        $approve            = $request->approve;
        orderCompFile::where(['id'=> $id])->update(['is_approved'=>$approve]);
        $user_id                        = Auth::user()->id;
        $user_name                      = Auth::user()->name;
        $body                           = "Comp ".$approve." for <strong>".$order->job_name."</strong> ( <strong>#".$order_id."</strong> )";
        $data['idFK']                   = $order_id;
        $data['type']                   = 'comp feedback';
        $data['added_by_id']            = $user_id;
        $data['added_by_name']          = $user_name;
        $data['body']                   = $body;
        $data['time_id']                = date('U');
        $this->add_notification($data);

        return json_encode(array("status"=>true));

    }
    
    public function product_form(Request $request)
    {
        $order_product_variants     = [];
        $product_id             = $request->product_id;
        $selector_number        = $request->has('selector_number')?$request->selector_number:'';
        if($selector_number != ""){
            $selector_terminator    = explode("-", $selector_number);
            $terminator             = $selector_terminator[1]; 
        }
        
        $order_id               = (isset($request->order_id) && $request->order_id != "")? $request->order_id: 0;

        if($order_id  > 0){
            $order_product_variants         = OrderProductVariant::where(['order_id'=> $order_id, 'product_id'=> $product_id, "selector_ref"=>$terminator])->get()->chunk(10);
        }
        
        $product_detail     = Product::with( 'ProductVariant', 'ProductVariant.Atrributes')->where('id', $product_id)->first();
   
        return view('admin.orders.product', compact('product_detail', 'order_product_variants', 'selector_number', 'terminator'));
        
    }
    public function print_nd_loations(Request $request)
    {
        $type                           = "";  
        $order_price                    = []; 
        $order_color_location           = []; 
        $order_color_location_number    = []; 
        $print_locations                = PrintLocation::where("is_active", "Y")->orderBy('priority', 'asc')->get();
        
        $product_id             = $request->product_id;
        $selector_number        = $request->selector_number;
        $selector_terminator    = explode("-", $selector_number);
        $terminator             = $selector_terminator[1];
        $order_id               = (isset($request->order_id) && $request->order_id != "")?$request->order_id:0;
        $product_detail         = Product::with('ProductVariant', 'ProductVariant.Atrributes')->where('id', $product_id)->first();
        if($order_id > 0){
            $order_prices       = OrderPrice::where(["order_id"=>$order_id, "product_id"=>$product_id, "selector_ref"=>$terminator])->get();
            foreach($order_prices as $key=>$price){
                $order_price['whole_sale'][]        = $price->wholesale_price;
                $order_price['print_price'][]       = $price->print_price;
                $order_price['total_price'][]       = $price->total_price;
                $order_price['profit_margin'][]     = $price->profit_margin;
                $order_price['final_price'][]       = $price->final_price;
                $order_price['profit_margin_percentage'][]       = $price->profit_margin_percentage;
            }
            $order_color_locations    = OrderColorPerLocation::where(["order_id"=>$order_id, "product_id"=>$product_id, "selector_ref"=>$terminator])->get();

            foreach($order_color_locations as $key=>$location){
                $order_color_location[]         = $location->color_per_location;
                $order_color_location_number[]  = $location->location_number;
            }
        }
        foreach($product_detail->ProductVariant as $productVariant){
            if($productVariant->name == "Baby_sizes Size"){
                $type       = "Baby Size";
                break;
            }
        }
        return view('admin.orders.print-locations', compact('product_detail', 'type', 'order_price', 'order_color_location', 'print_locations', 'order_color_location_number', 'selector_number', 'terminator'));
    }
    public function print_nd_loations_view(Request $request)
    {
       
        $type                           = "";  
        $order_price                    = []; 
        $order_color_location           = []; 
        $order_color_location_number    = []; 
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
                $order_color_location_number[]  = $location->location_number;
            }
        }
        foreach($product_detail->ProductVariant as $productVariant){
            
            if($productVariant->name == "Baby Size"){
                $type       = "Baby Size";
                break;
            }
        }
        $pageTitle = '';
        return view('admin.orders.print-locations_view', compact('product_detail', 'pageTitle','type', 'order_price', 'order_color_location', 'order_color_location_number'));
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
    public function generateInvoice(Request $request, $id)
    {
        $pageTitle  = "Invoice";
        $order      = Order::with([
            'client', 
            'ClientSaleRep', 
            'OrderPrice', 
            'OrderImgs', 
            'OrderColorPerLocation', 
            'OrderColorPerLocation.Product', 
            'OrderProducts', 
            'OrderProducts.Product', 
            'OrderProducts.OrderProductVariant'=>function($query) use($id){
                $query->where("order_id", "=", $id);
            },
            'OrderTransfer',
            'OrderOtherCharges'
        ])->find($id);
        $order_images           = $order->OrderImgs;
        $extra_details          = [];
        $client_details         = [];
        $order_prices           = [];
        $invoice_details        = [];
        $color_per_locations    = [];
        foreach($order->OrderColorPerLocation as $colorPerLocation){
          
            $product_name       = $colorPerLocation->Product->name;
            $selector_ref       = $colorPerLocation->selector_ref;
            $color_per_locations[$product_name][$selector_ref]["location_number"][]        = $colorPerLocation->location_number;
            $color_per_locations[$product_name][$selector_ref]["color_per_location"][]     = $colorPerLocation->color_per_location;
        }
        foreach($order->OrderPrice as $OrderPrice){
            $rh_product_id      = $OrderPrice->product_id;
            $selector_ref       = $OrderPrice->selector_ref;
            $order_prices[$rh_product_id][$selector_ref][$OrderPrice->product_size]    = $OrderPrice->final_price;
        }
       
        foreach($order->OrderProducts as $OrderProduct){
            foreach($OrderProduct->OrderProductVariant as $product_count=>$order_product_variant){
              
                $rh_product_id  = $order_product_variant->product_id;
                $selector_ref   = $order_product_variant->selector_ref;
                $size_for       = $OrderProduct->Product->size_for;
                $product_n      = $OrderProduct->product_name;
                $attr1_name     = $order_product_variant->attribute1_name;
                $attr2_name     = $order_product_variant->attribute2_name;
                $invoice_details[$size_for][$product_n][$selector_ref][$attr1_name][$attr2_name]["pieces"]  = $order_product_variant->pieces;
                if($size_for == "adult_sizes"){

                    if(in_array($attr2_name,$this->fixedAdultSize)){
                        $invoice_details[$size_for][$product_n][$selector_ref][$attr1_name][$attr2_name]["price"] = $order_prices[$rh_product_id][$selector_ref]["XS-XL"];
                    }else{
                        $price_for_NF   = (isset($order_prices[$rh_product_id][$selector_ref][$attr2_name])) ? $order_prices[$rh_product_id][$selector_ref][$attr2_name]: 0;

                        $invoice_details[$size_for][$product_n][$selector_ref][$attr1_name][$attr2_name]["price"] = $price_for_NF;
                    }
                    
                }
                if($size_for == "baby_sizes"){
                    
                    if(in_array($attr2_name,$this->fixedBabySize)){
                        $invoice_details[$size_for][$product_n][$selector_ref][$attr1_name][$attr2_name]["price"] = $order_prices[$rh_product_id][$selector_ref]["OSFA-18M"];
                    }else{
                        $price_for_NF   = (isset($order_prices[$rh_product_id][$selector_ref][$attr2_name])) ? $order_prices[$rh_product_id][$selector_ref][$attr2_name]: 0;

                        $invoice_details[$size_for][$product_n][$selector_ref][$attr1_name][$attr2_name]["price"] = $price_for_NF;
                    }
                }
            }
        }
  
        $client_details["date"]                     = date("m/d/Y", $order->time_id);
        $client_details["company_name"]             = $order->client->company_name??"";
        $client_details["job_name"]                 = $order->job_name;
        $client_details["order_number"]             = $order->order_number;
        $client_details["email"]                    = $order->client->email??"";
        $client_details["invoice_number"]           = $order->id;
        $client_details["projected_units"]          = $order->projected_units;
        $extra_details["label_pieces"]              = $order->OrderOtherCharges->label_pieces ?? 0;
        $extra_details["label_prices"]              = $order->OrderOtherCharges->label_prices ?? 0;
        $extra_details["fold_pieces"]               = $order->OrderOtherCharges->fold_pieces ?? 0;
        $extra_details["fold_prices"]               = $order->OrderOtherCharges->fold_prices ?? 0;
        $extra_details["fold_bag_pieces"]           = $order->OrderOtherCharges->fold_bag_pieces ?? 0;
        $extra_details["fold_bag_prices"]           = $order->OrderOtherCharges->fold_bag_prices ?? 0;
        $extra_details["foil_pieces"]               = $order->OrderOtherCharges->foil_pieces ?? 0;
        $extra_details["foil_prices"]               = $order->OrderOtherCharges->foil_prices ?? 0;
        $extra_details["palletizing_pieces"]        = $order->OrderOtherCharges->palletizing_pieces ?? 0;
        $extra_details["palletizing_prices"]        = $order->OrderOtherCharges->palletizing_prices ?? 0;
        $extra_details["remove_packaging_pieces"]   = $order->OrderOtherCharges->remove_packaging_pieces ?? 0;
        $extra_details["remove_packaging_prices"]   = $order->OrderOtherCharges->remove_packaging_prices ?? 0;
        $extra_details["fold_bag_tag_pieces"]       = $order->OrderOtherCharges->fold_bag_tag_pieces ?? 0;
        $extra_details["fold_bag_tag_prices"]       = $order->OrderOtherCharges->fold_bag_tag_prices ?? 0;
        $extra_details["hang_tag_pieces"]           = $order->OrderOtherCharges->hang_tag_pieces ?? 0;
        $extra_details["hang_tag_prices"]           = $order->OrderOtherCharges->hang_tag_prices ?? 0;
        $extra_details["art_fee"]                   = $order->OrderOtherCharges->art_fee ?? 0;
        $extra_details["art_discount"]              = $order->OrderOtherCharges->art_discount ?? 0;
        $extra_details["art_time"]                  = $order->OrderOtherCharges->art_time ?? 0;
        $extra_details["tax"]                       = $order->OrderOtherCharges->tax ?? 0;
        $extra_details["transfers_pieces"]          = $order->OrderTransfer->transfers_pieces ?? 0;
        $extra_details["transfers_prices"]          = $order->OrderTransfer->transfers_prices ?? 0;
        $extra_details["ink_color_change_pieces"]   = $order->OrderTransfer->ink_color_change_pieces ?? 0;
        $extra_details["ink_color_change_prices"]   = $order->OrderTransfer->ink_color_change_prices ?? 0;
        $extra_details["shipping_pieces"]           = $order->OrderTransfer->shipping_pieces ?? 0;
        $extra_details["shipping_charges"]          = $order->OrderTransfer->shipping_charges ?? 0;
        $extra_details["order_id"]                  = $order->id;
        $fixed_adult_sizes                          = $this->fixedAdultSize;
        $fixed_baby_sizes                           = $this->fixedBabySize;
        // dd($extra_details);
      
        if($request->has('download_invoice') && $request->download_invoice==true){
            // return view('admin.orders.download-invoice',compact('pageTitle', 'invoice_details', 'client_details', 'fixed_adult_sizes', 'fixed_baby_sizes', 'extra_details', 'color_per_locations', 'order_images'));
            
            $customPaper = array(0,0,1000,1000);
            $pdf    = PDF::loadView('admin.orders.download-invoice',compact('pageTitle', 'invoice_details', 'client_details', 'fixed_adult_sizes', 'fixed_baby_sizes', 'extra_details', 'color_per_locations', 'order_images'))->setOptions(['isRemoteEnabled' => true])->setPaper($customPaper, 'portrait');
            if($request->has('save_invoice') && $request->save_invoice==true){
                $path = public_path('/uploads/order/invoices-'.$order->id.'/');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                } 
                $file_name = time().rand(100,999).'invoice.pdf';
                $pdf->save($path.$file_name);
                $file_url       = 'uploads/order/invoices-'.$order->id.'/'.$file_name;
                return $file_url;
            }
            return $pdf->download('Quote.pdf');
        }   
    
        return view('admin.orders.generate-invoice',compact('pageTitle', 'invoice_details', 'client_details', 'fixed_adult_sizes', 'fixed_baby_sizes', 'extra_details', 'color_per_locations', 'order_images', 'order'));
    }
    public function recreate(Request $request, $id)
    {
        
        $order                  = Order::with([
            'OrderImgs', 
            'OrderPrice', 
            'OrderColorPerLocation', 
            'OrderProducts',
            'OrderProductVariant',
            'OrderTransfer',
            'OrderOtherCharges',
            'OrderArtFiles',
            'OrderArtDetail',
            'orderCompFiles',
            'OrderCompDetail'
        ])->find($id);
        $user_id                        = Auth::user()->id;
        $user_name                      = Auth::user()->name;     
        $new_order                      = new Order();
        $new_order->time_id             = date('U');
        $new_order->client_id           = $order->client_id;
        $new_order->sales_rep           = $order->sales_rep;
        $new_order->due_date            = $order->due_date;
        $new_order->event               = $order->event;
        $new_order->shipping_address    = $order->shipping_address;
        $new_order->job_name            = $order->job_name;
        $new_order->order_number        = $order->order_number;
        $new_order->projected_units     = $order->projected_units;
        $new_order->created_by_id       = $user_id;
        $new_order->created_by_name     = $user_name;
        $new_order->updated_by_id       = $user_id;
        $new_order->updated_by_name     = $user_name;
        $new_order->save();
        $order_id                       = $new_order->id;
        $order_price_arr                = [];
        $order_product_variant_arr      = [];
        $order_color_perlocation_arr    = [];
        $order_products_arr             = [];
        $order_products_arr             = [];
        $order_images                   = [];
        $art_files                      = [];
        $comp_files                     = [];
        $order_comp_detail_arr          = [];
        if(count($order->OrderArtFiles)>0){
            foreach($order->OrderArtFiles as $OrderArtFile)
            {   
                $art_file                       = new orderArtFile();
                $art_file->order_id             = $order_id;
                $art_file->file                 = $OrderArtFile->file;
                $art_files[]                    = $art_file;
            }
            $new_order->OrderArtFiles()->saveMany($art_files);
        }
        if($order->OrderArtDetail){
            $order_art_detail                   = new OrderArtDetail();
            $order_art_detail->order_id         = $order_id;
            $order_art_detail->art_detail       = $order->OrderArtDetail->art_detail;
            $order_art_detail->save();
        }
        if(count($order->orderCompFiles)>0){
            foreach($order->orderCompFiles as $orderCompFile)
            {   
                $comp_file                      = new orderCompFile();
                $comp_file->order_id            = $order_id;
                $comp_file->file                = $orderCompFile->file;
                $comp_file->is_approved         = $orderCompFile->is_approved;
                $comp_files[]                   = $comp_file;
            }
            $new_order->orderCompFiles()->saveMany($comp_files);
        }
    
        if(count($order->OrderCompDetail)>0){
            foreach($order->OrderCompDetail as $compDetail){
                $user_id                            = Auth::user()->id;
                $userRole                           = (Auth::user()->hasRole('Artist'))?'Artist':'Assignee';
                $order_comp_detail                  = new OrderCompDetail();
                $order_comp_detail->order_id        = $order_id;
                $order_comp_detail->comp_detail     = $compDetail->comp_detail;
                $order_comp_detail->added_by        = $user_id;
                $order_comp_detail->added_by_role   = $userRole ;
                $order_comp_detail_arr[]            = $order_comp_detail;
            }
            $new_order->OrderCompDetail()->saveMany($order_comp_detail_arr);
        }
        
        foreach($order->OrderImgs as $OrderImg)
        {   
            $order_img                      = new OrderImgs();
            $order_img->order_id            = $order_id;
            $order_img->image               = $OrderImg->image;
            $order_images[]                 = $order_img;
        }
        $new_order->OrderImgs()->saveMany($order_images);
        foreach($order->OrderPrice as $_OrderPrice)
        {   
            $or_price                   = new OrderPrice();
            $or_price->product_id       = $_OrderPrice->product_id;
            $or_price->selector_ref     = $_OrderPrice->selector_ref;
            $or_price->product_size     = $_OrderPrice->product_size;
            $or_price->wholesale_price  = $_OrderPrice->wholesale_price;
            $or_price->print_price      = $_OrderPrice->print_price ;
            $or_price->total_price      = $_OrderPrice->total_price ;
            $or_price->profit_margin    = $_OrderPrice->profit_margin;
            $or_price->profit_margin_percentage     = $_OrderPrice->profit_margin_percentage;
            $or_price->final_price      = $_OrderPrice->final_price;
            $order_price_arr[]          = $or_price; 
        }
        $new_order->OrderPrice()->saveMany($order_price_arr);

        foreach($order->OrderColorPerLocation as $_OrderColorPerLocation)
        {
            $order_color_perlocation                        = new OrderColorPerLocation();
            $order_color_perlocation->product_id            = $_OrderColorPerLocation->product_id;
            $order_color_perlocation->selector_ref          = $_OrderColorPerLocation->selector_ref;
            $order_color_perlocation->color_per_location    = $_OrderColorPerLocation->color_per_location;
            $order_color_perlocation->location_number       = $_OrderColorPerLocation->location_number;
            $order_color_perlocation_arr[]                  = $order_color_perlocation; 
        }
        $new_order->OrderColorPerLocation()->saveMany($order_color_perlocation_arr);

        foreach($order->OrderProductVariant as $_OrderProductVariant)
        {
            $order_product_var                          = new OrderProductVariant();
                $order_product_var->product_id          = $_OrderProductVariant->product_id;
                $order_product_var->selector_ref        = $_OrderProductVariant->selector_ref;
                $order_product_var->variant1_id         = $_OrderProductVariant->variant1_id;
                $order_product_var->variant1_name       = $_OrderProductVariant->variant1_name ;
                $order_product_var->variant2_id         = $_OrderProductVariant->variant2_id;
                $order_product_var->variant2_name       = $_OrderProductVariant->variant2_name;
                $order_product_var->attribute1_id       = $_OrderProductVariant->attribute1_id;
                $order_product_var->attribute1_name     = $_OrderProductVariant->attribute1_name;
                $order_product_var->attribute2_id       = $_OrderProductVariant->attribute2_id;
                $order_product_var->attribute2_name     = $_OrderProductVariant->attribute2_name ;
                $order_product_var->pieces              = $_OrderProductVariant->pieces;
                $order_product_var->price               = $_OrderProductVariant->price;
                $order_product_var->total               = $_OrderProductVariant->total;
                $order_product_variant_arr[]            = $order_product_var;
            
           
        }
        $new_order->OrderProductVariant()->saveMany($order_product_variant_arr);

        foreach($order->OrderProducts as $_OrderProducts)
        {
            $order_products                 = new OrderProduct();
            $order_products->product_id     = $_OrderProducts->product_id;
            $order_products->selector_ref   = $_OrderProducts->selector_ref;
            $order_products->product_name   = $_OrderProducts->product_name;

            $order_products_arr[]  = $order_products;
        }
        $new_order->OrderProducts()->saveMany($order_products_arr);

       
        $new_order->OrderProducts()->saveMany($order_products_arr);

        $or_other                                   = $order->OrderOtherCharges;
        $order_other_charges                        = new OrderOtherCharges();
        $order_other_charges->order_id              = $order_id;
        $order_other_charges->fold_bag_tag_pieces   = $or_other->fold_bag_tag_pieces;
        $order_other_charges->fold_bag_tag_prices   = $or_other->fold_bag_tag_prices;
        $order_other_charges->hang_tag_pieces       = $or_other->hang_tag_pieces;
        $order_other_charges->hang_tag_prices       = $or_other->hang_tag_prices;
        $order_other_charges->art_fee               = $or_other->art_fee;
        $order_other_charges->art_discount          = $or_other->art_discount;
        $order_other_charges->art_time              = $or_other->art_time;
        $order_other_charges->tax                   = $or_other->tax;
        $order_other_charges->save();

        $or_transfer                                = $order->OrderTransfer; 
        $order_transfer                             = new OrderTransfer();
        $order_transfer->order_id                   = $order_id;
        $order_transfer->transfers_pieces           = $or_transfer->transfers_pieces;
        $order_transfer->transfers_prices           = $or_transfer->transfers_prices;
        $order_transfer->ink_color_change_pieces    = $or_transfer->ink_color_change_pieces;
        $order_transfer->art_fee                    = $or_transfer->art_fee;
        $order_transfer->ink_color_change_prices    = $or_transfer->ink_color_change_prices;
        $order_transfer->shipping_charges           = $or_transfer->shipping_charges;
        $order_transfer->save();

        
        $order_d_yellow                             = OrderDYellow::where("order_id", $id)->first();
        if(isset($order_d_yellow->id) && $order_d_yellow->id > 0){
            $order_d_yellow_new                         = new OrderDYellow();
            $order_d_yellow_new->order_id               = $order_id;
            $order_d_yellow_new->time_id                = date('U');
            $order_d_yellow_new->print_crew             = $order_d_yellow->print_crew;
            $order_d_yellow_new->film_number            = $order_d_yellow->film_number;
            $order_d_yellow_new->goods_rec              = $order_d_yellow->goods_rec;
            $order_d_yellow_new->boxes                  = $order_d_yellow->boxes;
            $order_d_yellow_new->production_sample      = $order_d_yellow->production_sample;
            $order_d_yellow_new->palletize              = $order_d_yellow->palletize;
            $order_d_yellow_new->palletize_opt          = $order_d_yellow->palletize_opt;
            // $order_d_yellow_new->in_hands               = $order_d_yellow->in_hands;
            // $order_d_yellow_new->design                 = $order_d_yellow->design;
            $order_d_yellow_new->ship                   = $order_d_yellow->ship;
            $order_d_yellow_new->acct                   = $order_d_yellow->acct;
            $order_d_yellow_new->alpha                  = $order_d_yellow->alpha;
            $order_d_yellow_new->s_and_s                = $order_d_yellow->s_and_s;
            $order_d_yellow_new->sanmar                 = $order_d_yellow->sanmar;
            $order_d_yellow_new->is_rejected            = $order_d_yellow->is_rejected;
            $order_d_yellow_new->notes                  = $order_d_yellow->notes;
            $order_d_yellow_new->save();
        }
        $order_d_yellow_inks            = DYellowInkColor::where("order_id", $id)->get();
        if(count($order_d_yellow_inks)>0){
            foreach ($order_d_yellow_inks as $key => $d_yellow_ink) {
                $d_yellow_inks_new                      = new DYellowInkColor();
                $d_yellow_inks_new->order_id            = $order_id;
                $d_yellow_inks_new->time_id             = date('U');
                $d_yellow_inks_new->key                 = $d_yellow_ink->key;
                $d_yellow_inks_new->location_number     = $d_yellow_ink->location_number;
                $d_yellow_inks_new->color_per_location  = $d_yellow_ink->color_per_location;
                $d_yellow_inks_new->ink_colors          = $d_yellow_ink->ink_colors;
                $d_yellow_inks_new->save();
            }
        }

        return redirect()->route("admin.orders.index")->withSuccess('Order has been replicated successfully!');
        
    }
    public function DYellow(Request $request, $id)
    {
       
        $pageTitle  = "D Yellow";
        $order      = Order::with([
            'client', 
            'client.ClientSaleRep', 
            'OrderPrice', 
            'OrderImgs',
            'OrderColorPerLocation', 
            'OrderColorPerLocation.Product', 
            'OrderProducts', 
            'OrderProducts.Product', 
            'OrderProducts.OrderProductVariant'=>function($query) use($id){
                $query->where("order_id", "=", $id);
            },
            'OrderTransfer',
            'OrderOtherCharges'
        ])->find($id);
       
        $print_locations        = PrintLocation::where("is_active", "Y")->orderBy('priority', 'asc')->get();
        $extra_details          = [];
        $client_details         = [];
        $order_prices           = [];
        $invoice_details        = [];
        $color_per_locations    = [];
        foreach($order->OrderColorPerLocation as $colorPerLocation){
            $product_name       = $colorPerLocation->Product->name;
            $color_per_locations[$product_name]["location_number"][]        = $colorPerLocation->location_number;
            $color_per_locations[$product_name]["color_per_location"][]     = $colorPerLocation->color_per_location;
        }
        foreach($order->OrderPrice as $OrderPrice){
            $rh_product_id      = $OrderPrice->product_id;
            $selector_ref       = $OrderPrice->selector_ref;
            $order_prices[$rh_product_id][$selector_ref][$OrderPrice->product_size]    = $OrderPrice->final_price;
        }
        
        foreach($order->OrderProducts as $OrderProduct){
            foreach($OrderProduct->OrderProductVariant as $product_count=>$order_product_variant){
              
                $rh_product_id  = $order_product_variant->product_id;
                $selector_ref   = $order_product_variant->selector_ref;
                $size_for       = $OrderProduct->Product->size_for;
                $product_n      = $OrderProduct->product_name;
                $attr1_name     = $order_product_variant->attribute1_name;
                $attr2_name     = $order_product_variant->attribute2_name;
                $invoice_details[$size_for][$product_n][$selector_ref][$attr1_name][$attr2_name]["pieces"]  = $order_product_variant->pieces;

                if($size_for == "adult_sizes"){
                    if(in_array($attr2_name,$this->fixedAdultSize)){
                        $invoice_details[$size_for][$product_n][$selector_ref][$attr1_name][$attr2_name]["price"] = $order_prices[$rh_product_id][$selector_ref]["XS-XL"];
                    }else{
                        $price_for_NF   = (isset($order_prices[$rh_product_id][$selector_ref][$attr2_name])) ? $order_prices[$rh_product_id][$selector_ref][$attr2_name]: 0;

                        $invoice_details[$size_for][$product_n][$selector_ref][$attr1_name][$attr2_name]["price"] = $price_for_NF;
                    }
                }
                if($size_for == "baby_sizes"){ 
                    if(in_array($attr2_name,$this->fixedBabySize)){
                        $invoice_details[$size_for][$product_n][$selector_ref][$attr1_name][$attr2_name]["price"] = $order_prices[$rh_product_id][$selector_ref]["OSFA-18M"];
                    }else{
                        $price_for_NF   = (isset($order_prices[$rh_product_id][$selector_ref][$attr2_name])) ? $order_prices[$rh_product_id][$selector_ref][$attr2_name]: 0;

                        $invoice_details[$size_for][$product_n][$selector_ref][$attr1_name][$attr2_name]["price"] = $price_for_NF;
                    }
                }
            }
        }
        $sales_rep                                  = (isset($order->sales_rep) && $order->sales_rep!=0)?$order->client->ClientSaleRep->where("id", $order->sales_rep)->first():"";
  
        $client_details["date"]                     = date("m/d/Y", $order->time_id);
        $client_details["company_name"]             = $order->client->company_name??"";
        $client_details["company_name"]             = $order->client->company_name??"";
        $client_details["job_name"]                 = $order->job_name;
        $client_details["order_number"]             = $order->order_number;
        $client_details["address"]                  = $order->client->address??"";
        $client_details["email"]                    = $order->client->email??"";
        $first_name                                 = $sales_rep->first_name??"";
        $last_name                                  = $sales_rep->last_name??"";
        $client_details["sales_rep"]                = $first_name." ".$last_name;
        $client_details["invoice_number"]           = $order->id;
        $client_details["projected_units"]          = $order->projected_units;
    
        $extra_details["label_pieces"]              = ($order->OrderOtherCharges->label_pieces > 0) ? "Inside Labels": "";
        $extra_details["fold_pieces"]               = ($order->OrderOtherCharges->fold_pieces > 0) ? "Fold Only": "";
        $extra_details["fold_bag_pieces"]           = ($order->OrderOtherCharges->fold_bag_pieces > 0) ? "Fold Bag Only": "";
        $extra_details["foil_pieces"]               = ($order->OrderOtherCharges->foil_pieces > 0) ? "Foil": "";
        $extra_details["palletizing_pieces"]        = ($order->OrderOtherCharges->palletizing_pieces > 0) ? "Palletizing": "";
        $extra_details["remove_packaging_pieces"]   = ($order->OrderOtherCharges->remove_packaging_pieces > 0) ? "Remove Packaging": "";
        $extra_details["fold_bag_tag_pieces"]       = ($order->OrderOtherCharges->fold_bag_tag_pieces > 0) ? "FOLD/BAG/TAG": "";
        $extra_details["hang_tag_pieces"]           = ($order->OrderOtherCharges->hang_tag_pieces > 0) ? "Hang Tag": "";
        $extra_details["transfers_pieces"]          = ($order->OrderTransfer->transfers_pieces > 0) ? "Transfers": "";
        $extra_details["ink_color_change_pieces"]   = ($order->OrderTransfer->ink_color_change_pieces > 0) ? "Ink Color Change": "";
        $extra_details["shipping_pieces"]           = ($order->OrderTransfer->shipping_pieces > 0) ? "Shipping Charges": "";
        $extra_details["order_id"]                  = $order->id;
        $fixed_adult_sizes                          = $this->fixedAdultSize;
        $fixed_baby_sizes                           = $this->fixedBabySize; 
        $order_d_yellow                             = OrderDYellow::where("order_id", $id)->first();
        $order_d_yellow_inks                        = DYellowInkColor::where("order_id", $id)->get();
        $max_key                                    = DYellowInkColor::where("order_id", $id)->max('key');
        return view('admin.orders.d-yellow',compact('pageTitle', 'invoice_details', 'client_details', 'fixed_adult_sizes', 'fixed_baby_sizes', 'extra_details', 'color_per_locations', 'print_locations', 'order', 'order_d_yellow', 'order_d_yellow_inks', 'max_key'));
    }

    public function storeDYellow(Request $request){
       
        $rData                                  = $request->all();
        $order_id                               =(isset($rData["order_id"]))?$rData["order_id"]:0;
        $order_d_yellow                         = OrderDYellow::firstOrNew(["order_id"=>$order_id]);
        $order_d_yellow->order_id               = $order_id;
        $order_d_yellow->time_id                = date("U");
        $order_d_yellow->print_crew             = $rData["print_crew"];
        $order_d_yellow->film_number            = $rData["film_number"];
        $order_d_yellow->goods_rec              = $rData["goods_rec"];
        $order_d_yellow->boxes                  = $rData["boxes"];
        $order_d_yellow->production_sample      = $rData["production_sample"];
        $order_d_yellow->palletize_opt          = $rData["palletize_opt"];
        // $order_d_yellow->in_hands               = $rData["in_hands"];
        // $order_d_yellow->design                 = $rData["design"];
        // $order_d_yellow->ship                   = $rData["ship"];
        $order_d_yellow->acct                   = $rData["acct"];
        $order_d_yellow->alpha                  = $rData["alpha"];
        $order_d_yellow->s_and_s                = $rData["s_and_s"];
        $order_d_yellow->sanmar                 = $rData["sanmar"];
        $order_d_yellow->is_rejected            = $rData["is_rejected"];
        $order_d_yellow->notes                  = $rData["notes"];
        $order_d_yellow->save();

        $order                                  = Order::find($order_id);
        $location_number                        = $rData["location_number"];
        $color_per_location                     = $rData["color_per_location"];
        $ink_color                              = $rData["ink_color"];
        $ink_colors_arr                         = [];
        foreach($location_number as $key=>$location){
            $json_arr                       = [];
            foreach($ink_color[$key] as $k=>$value) {
                $json_arr['"'.$k.'"']     = $value;
            }
            $new_ink_color                      = new DYellowInkColor();
            $new_ink_color->key                 = $key+1;
            $new_ink_color->time_id             = date("U");
            $new_ink_color->location_number     = $location[0];
            $new_ink_color->color_per_location  = $color_per_location[$key][0];
            $new_ink_color->ink_colors          = json_encode($json_arr);
            $ink_colors_arr[]                   = $new_ink_color;
        }
        $order->DYellowInkColors()->delete();
        $order->DYellowInkColors()->saveMany($ink_colors_arr);
        return redirect()->back();
    }
    public function sendEmail(Request $request)
    {
        $order                      = Order::find($request->order_number);
        $user_id                    = $order->created_by_id;
        $user                       = User::find($user_id);
        $assignee_email             = $user->email;
        $assignee_name              = $user->name;
        $email                      = new EmailLog();
        $email->time_id             = time();
        $email->order_id            = $request->order_number;
        $email->client_id           = $request->client_id;
        $email->from                = $assignee_email;
        $email->assignee_name       = $assignee_name;
        $email->send_to             = $request->email;
        $email->subject             = $request->subject;
        $email->description         = $request->description;
        $email->is_sent             = "Y";
        $email->created_by_id       = Auth::user()->id;
        $data["email"]              = $request->email ;
        $data["title"]              = $request->subject;
        $data["description"]        = $request->description;
        $attachmentPath             = "";
        if((isset($request->send_comp_attachment) && $request->send_comp_attachment) && (isset($request->comp_id) && $request->comp_id!="")){
            $comp_file          = orderCompFile::find($request->comp_id);
            $attachmentPath     = public_path($comp_file->file);
            $email->comp_id     = $request->comp_id;
        }else{
           // do nothing
        }
        \Mail::send('admin.orders.email', $data, function($message)use($data, $attachmentPath) {
                $message->to($data["email"])
                ->subject($data["title"]);   
                if($attachmentPath != ""){

                    $message->attach($attachmentPath);      
                }
        });
        if(count(\Mail::failures()) > 0){
            return 'Something went wrong.';
        }else{
            $request->merge(["download_invoice"=> true, "save_invoice"=> true]);
            $file                       = $this->generateInvoice($request, $order->id);
            $email->invoice             = $file;
            $email->save();
            return "Mail send successfully !!";
        }
    }
    public function destroy(Request $request, $id)
    {
        $order      = Order::find($id);
        $order->OrderImgs()->delete();
        $order->OrderPrice()->delete();
        $order->OrderColorPerLocation()->delete();
        $order->OrderProducts()->delete();
        $order->OrderProductVariant()->delete();
        $order->OrderTransfer()->delete();
        $order->OrderOtherCharges()->delete();
        $order->OrderArtFiles()->delete();
        $order->OrderArtDetail()->delete();
        $order->orderCompFiles()->delete();
        $order->OrderCompDetail()->delete();
        OrderDYellow::where("order_id", $id)->delete();
        DYellowInkColor::where("order_id", $id)->delete();
        $order->delete();
        return redirect()->route("admin.orders.index")->withSuccess('Order data has been deleted successfully!');
    }
    public function email_popup(Request $request){
        $selected_template  = "";
        $comp_id            = $request->comp_id??'';
        $order_id           = $request->order_id;
        $client_id          = $request->client_id;
        $email              = $request->email;
        $encrypted_email    = Crypt::encrypt($request->email);
        $sale_rep_name      = $request->sale_rep_name;
        $company_name       = $request->company_name;
        $job_name           = $request->job_name;
        $order_number       = $request->order_number;
        $template_id        = $request->has('template_id') ? $request->template_id: "";
        if($template_id != ""){
            $selected_template      = EmailTemplate::find($template_id);
        }
        $email_templates            = EmailTemplate::get();
        $link_url                   = route('order.quote',  ['order_id' => Crypt::encrypt($order_id), 'email' => $encrypted_email]);
        if($request->has('comp_id') && $request->comp_id != ''){
            $link_url               = route('order.comp',  ['comp_id' => Crypt::encrypt($comp_id), 'email' => $encrypted_email]);
        }
        $link_anchor_tag            = '<a href="'.$link_url.'" >Click here</a>';
        
        return view('admin.orders.popup.send-email', compact('order_id', 'client_id', 'email', 'email_templates', 'selected_template', 'template_id', 'sale_rep_name', 'company_name', 'job_name', 'order_number', 'encrypted_email', 'comp_id', 'link_url', 'link_anchor_tag'));
    }
    public function action_log_popup(Request $request){
 
        $order_id           = $request->order_id;
        $action_logs        = EmailLog::where("order_id", $order_id)->orderBy("id", "desc")->get();
        return view('admin.orders.popup.action-log', compact('action_logs'));
    }
    public function action_log_seen(Request $request){
        $order_id               = $request->order_id;
        $seen_by                = $request->user_id;
        $action_logs            = EmailLog::where("order_id", $order_id)->orderBy("id", "desc")->get();
        if(count($action_logs)>0){
            foreach($action_logs as $k=>$action_log){
         
                $action_seen            = ActionSeen::firstOrNew(["email_log_id"=>$action_log->id, "order_id"=>$order_id, "seen_by"=>$seen_by]);
                $action_seen->email_log_id      = $action_log->id;
                $action_seen->order_id          = $order_id;
                $action_seen->seen_by           = $seen_by;
                $action_seen->save();
            }
        }
        return view('admin.orders.popup.action-log', compact('action_logs'));
    }

    public function downloadArtFiles($file_id){
        $art_file       = orderArtFile::find($file_id);
        if($art_file){
            $path       = public_path($art_file->file);
            if (file_exists($path)) {
                return response()->download($path);
            } else {
                abort(404, 'File not found');
            }
        }else{
            abort(404, 'File not found');
        }
    }
    public function downloadCompFiles($file_id){
        $comp_file       = orderCompFile::find($file_id);
        if($comp_file){
            $path       = public_path($comp_file->file);
            if (file_exists($path)) {
                return response()->download($path);
            } else {
                abort(404, 'File not found');
            }
        }else{
            abort(404, 'File not found');
        }
    }
}