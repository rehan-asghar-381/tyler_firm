<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Traits\NotificationTrait;
class DashboardController extends Controller
{
    use NotificationTrait;
    function __construct()
    {
        $this->middleware('permission:dashboard-view', ['only' => ['index']]);
        $this->middleware('permission:orders-delete', ['only' => ['destroy']]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $pageTitle                  = "Dashboard";
        if(Auth::check()){
            return view('admin.dashboard.dashboard', compact('pageTitle'));
        }
        return redirect("admin")->with('error', 'Opps! You do not have access');
    }

    public function statusCounts(Request $request){

        $date_from                  = $request->get('date_from');
        $date_to                    = $request->get('date_to');
        $status_counts_arr          = [];
        $order_counts               = [];

        $orders                     = Order::groupBy('status')
                                    ->select('status', DB::raw('count(*) as total'));

        // if(!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('Admin')){

        //     // if(auth()->user()->hasRole('Production Manager')){

        //     //     $orders                     =$orders->where('created_by_id', auth()->user()->id);

        //     // }else
        //     if(auth()->user()->hasRole('Tailor')){

        //         $orders                     =$orders->where('created_by_id', auth()->user()->id);
        //     }

        // }
        if($date_from != ""){
            $orders                 = $orders->where("order_date_timestamp", ">=", strtotime($date_from));
        }
        if($date_to != ""){
            $orders                 = $orders->where("order_date_timestamp", "<=", strtotime($date_to));
        }
        $orders                     = $orders->get();                          
        $statuses                   = Status::get();
        foreach($orders as $id=>$order){

            $order_counts[$order->status]       = $order->total;
        }

        foreach($statuses as $id=>$status){

            $counts_arr                 = [];
            $counts_arr['status_id']    = $status->id;
            $counts_arr['status']       = $status->name;
            $counts_arr['total']        = (isset($order_counts[$status->id]))?$order_counts[$status->id]:0;
            $status_counts_arr[]        = $counts_arr;
        }

        $html       = $this->prepareHtml($status_counts_arr);
        return ['status_counts' => $html];
    }

    public function ajaxtData(Request $request){
        
        $date_from                  = $request->get('date_from');
        $date_to                    = $request->get('date_to');

        $rData                      = Order::where('id', '<>',0)->orderBy('collection_date_timestamp', 'desc');

        // if(!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('Admin')){

        //     // if(auth()->user()->hasRole('Production Manager')){

        //     //     $rData                     =$rData->where('created_by_id', auth()->user()->id);

        //     // }else
        //     if(auth()->user()->hasRole('Tailor')){

        //         $rData                     =$rData->where('created_by_id', auth()->user()->id);
        //     }

        // }

        if($date_from != ""){
            $rData                 = $rData->where("order_date_timestamp", ">=", strtotime($date_from));
        }
        if($date_to != ""){
            $rData                 = $rData->where("order_date_timestamp", "<=", strtotime($date_to));
        }
        
        if($request->get('status') != ""){

            $rData              = $rData->where('status', $request->get('status'));

        }
        return DataTables::of($rData->get())
            ->addIndexColumn()
            ->editColumn('first_name', function ($data) {
                if (isset($data->client->first_name) && $data->client->first_name != "")
                    return $data->client->first_name;
                else
                    return '-';
            })
            ->editColumn('last_name', function ($data) {
                if (isset($data->client->first_name) && $data->client->last_name != "")
                    return $data->client->last_name;
                else
                    return '-';
            })
            ->editColumn('email', function ($data) {
                if (isset($data->client->first_name) && $data->client->email != "")
                    return $data->client->email;
                else
                    return '-';
            })
            ->editColumn('phone_number', function ($data) {
                if (isset($data->client->first_name) && $data->client->phone_number != "")
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
            ->editColumn('status', function ($data) {
                
                if (isset($data->Orderstatus->name) && $data->Orderstatus->name != "")
                    return $data->Orderstatus->name;
                else
                    return '-';
            })
            ->editColumn('order_date', function ($data) {
                if ($data->order_date != "")
                    return $data->order_date;
                else
                    return '-';
            })
            ->editColumn('collection_date', function ($data) {
                if ($data->collection_date != "")
                    return $data->collection_date;
                else
                    return '-';
            })
            ->editColumn('description', function ($data) {
                if ($data->description != "")
                    return $data->description;
                else
                    return '-';
            })
            ->editColumn('tailor_comments', function ($data) {
                if ($data->tailor_comments != "")
                    return $data->tailor_comments;
                else
                    return '-';
            })
            ->addColumn('actions', function ($data){

                $action_list    = '<div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti-more-alt"></i>
                </a><div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
               
                if(auth()->user()->can('orders-view')){

                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.order.detail', $data->id).'"><i class="far fa-eye"></i> View Details</a>';
                }
                if(auth()->user()->can('orders-delete')){

                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.order.detail', $data->id).'"><i class="far fa-trash-alt"></i> Delete</a>';
                }
                if(auth()->user()->can('orders-view')){

                    $action_list    .= '<a class="dropdown-item btn-change-status" href="#" data-status="'.$data->status.'" data-id="'.$data->id.'"><i class="far fa fa-life-ring"></i> Change Status</a>';
                }
                $action_list    .='</div></div>';
                return  $action_list;
            })
            ->rawColumns(['actions'])
            ->make(TRUE);
    }

    public function prepareHtml($status_counts_arr){

        $html           = '';
        foreach ($status_counts_arr as $key=>$status_count){
            
          $html         .='<div class="col-md-3 col-sm-6 col-xs-12 count-widget" data-status="'.$status_count["status_id"].'"  data-status-name="'.$status_count["status"].'">
          <div class="mini-stat clearfix bg-'.$key.' rounded"><span class="mini-stat-icon"><i class="fas fa-chess-king bg-'.$key.'"></i></span><div class="mini-stat-info"><span>'.$status_count["total"].'</span>'.$status_count["status"].'</div></div></div>';
          
        }
        return  $html;

    }
    public function get_notifications(){

        $user_id        = Auth::user()->id;
        $html           = $this->notification_list($user_id);
        return $html;
    }

    public function all_notifications()
    {
        $pageTitle                  = "Notifications";
        return view('admin.notifications.index', compact('pageTitle'));
    }

    public function notificationAjaxData(){
        $user_id            = Auth::user()->id;
        $rData              = $this->all_notification_list($user_id);
  
        return DataTables::of($rData)
            ->addIndexColumn()
            ->editColumn('idFK', function ($data) {
                if ($data->idFK != "")
                    return $data->idFK;
                else
                    return '-';
            })
            ->editColumn('type', function ($data) {
                if ($data->type != "")
                    return ucfirst($data->type);
                else
                    return '-';
            })
            ->editColumn('added_by_name', function ($data) {
                if ($data->added_by_name != "")
                    return $data->added_by_name;
                else
                    return '-';
            })
            ->editColumn('body', function ($data) {
                if ($data->body != "")
                    return $data->body;
                else
                    return '-';
            })
            ->editColumn('time_id', function ($data) {
                if ($data->time_id != "")
                    return date('Y-m-d h:i:s', $data->time_id);
                else
                    return '-';
            })
            ->addColumn('hasSeen', function ($data) use ($user_id){
                if (isset($data->NotificationSeen->seen_by_id) && $data->NotificationSeen->seen_by_id == $user_id)
                    return '<i style="cursor: pointer;" data-nt-id="0" class="fas fa-envelope-open"></i>';
                else
                return '<i style="cursor: pointer;" data-nt-id="'.$data->id.'" class="fas fa-envelope list-all-nt"></i>';
            })
            ->rawColumns(['body', 'hasSeen'])
            ->make(TRUE);
    }
    public function notification_seeb_by(Request $request){
        $resp   = ["status"=>true];
        $nt_id                      = $request->nt_id;
        $seen_by_id                 = Auth::user()->id;

        if($this->notification_seen($nt_id, $seen_by_id)){
            return json_encode($resp);
        }else{
            return json_encode(["status"=>false]);
        }
    }

}