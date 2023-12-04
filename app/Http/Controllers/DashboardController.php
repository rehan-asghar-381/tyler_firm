<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use App\Models\NotificationConfig;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Traits\NotificationTrait;
use App\Models\QuoteApproval;
use App\Models\CompStatus;
use App\Models\Blank;
use App\Models\orderCompFile;
use App\Models\Task;
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

        $orders                     = Order::groupBy('created_by_id')
                                    ->select('created_by_id', DB::raw('count(*) as total'));
        if($date_from != ""){
            $orders                 = $orders->where("order_date_timestamp", ">=", strtotime($date_from));
        }
        if($date_to != ""){
            $orders                 = $orders->where("order_date_timestamp", "<=", strtotime($date_to));
        }
        $orders                     = $orders->where("status", "!=", 5)->where("created_by_id", "!=", 6)->get();                          
        $users                   = User::where("id", "!=", 6)->get();
        foreach($orders as $id=>$order){

            $order_counts[$order->created_by_id]       = $order->total;
        }

        foreach($users as $id=>$user){

            $counts_arr                 = [];
            $counts_arr['status_id']    = $user->id;
            $counts_arr['status']       = $user->name;
            $counts_arr['total']        = (isset($order_counts[$user->id]))?$order_counts[$user->id]:0;
            $status_counts_arr[]        = $counts_arr;
        }

        $html       = $this->prepareHtml($status_counts_arr);
        return ['status_counts' => $html];
    }
    public function orderCounts(Request $request){
        $date_from                  = $request->get('date_from');
        $date_to                    = $request->get('date_to');
        $order_counts               = [];

        $orders                     = Order::where("status", "<>", 5)->groupBy('status')
                                    ->select('status', DB::raw('count(*) as total'));
        if($date_from != ""){
            $orders                 = $orders->where("order_date_timestamp", ">=", strtotime($date_from));
        }
        if($date_to != ""){
            $orders                 = $orders->where("order_date_timestamp", "<=", strtotime($date_to));
        }
        $orders                     = $orders->get();  
        $totalOrders                = Order::where("status", "<>", 5)->count();
        foreach($orders as $id=>$order){

            $order_counts[$order->Orderstatus->name]["filter_type"]     = 1;
            $order_counts[$order->Orderstatus->name]["total"]           = $order->total;
            $order_counts[$order->Orderstatus->name]["perc"]            = number_format(($order->total/$totalOrders)*100, 0);
        }

        $comps                                                          = Order::wherein("comp_approval", ["Changes Needed", "Need Approval", "In Art Room"])->get();
        $compstotal                                                     = $comps->count();
        $countByApproval                                                = $comps->countBy('comp_approval');

        foreach($countByApproval as $approvalStatus =>$count ){
            $order_counts[$approvalStatus]["filter_type"]               = 2;
            $order_counts[$approvalStatus]["total"]                     = $count;
            $order_counts[$approvalStatus]["perc"]                      = number_format(($count/$compstotal)*100, 0);
        }

        $html       = $this->prepareOrderCountHtml($order_counts);
        return ['order_counts' => $html];
    }

    

    public function ajaxtData(Request $request){
        $user_id            = Auth::user()->id;
        $statuses           = Status::where('is_active', 'Y')->get(['id', 'name']);
        $quote_approval     = QuoteApproval::where('is_active', 'Y')->get(['id', 'name']);
        $blanks             = Blank::where('is_active', 'Y')->get(['id', 'name']);
        $comp_statuses      = CompStatus::get();
        $rData              = Order::withCount("EmailLog")->with(["client", "ClientSaleRep","ActionSeen"=>function($q) use($user_id){
            $q->where('seen_by', '=', $user_id);
        
        }])->where('status','<>',5);
        
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
        if($request->user_id != ""){
            $rData              = $rData->where('created_by_id', '=', $request->user_id);
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
                        <button type="button" class="btn btn-'.$cls.' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="white-space: nowrap;width:140px;">'.$name.'</button>
                        <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -152px, 0px); top: 0px; left: 0px; will-change: transform;">';
            
            $html   .=    $inner_html;
            $html   .=    '</div></div>';

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
            
            $action_list        .= '</div></div>';
            return  $action_list;
        })
        ->rawColumns(['actions', 'status', 'notification', 'blank', 'quote_approval', 'comp_approval'])
        ->make(TRUE);
    }

    public function prepareHtml($status_counts_arr){

        $html           = '';
        foreach ($status_counts_arr as $key=>$status_count){
            
          $html         .='<div class="col-md-3 col-sm-6 col-xs-12 count-widget" data-status="'.$status_count["status_id"].'"  data-status-name="'.$status_count["status"].'">
          <div class="mini-stat clearfix bg-'.$key.' rounded"><span class="mini-stat-icon"><i class="fas fa-user bg-'.$key.'"></i></span><div class="mini-stat-info"><span>'.$status_count["total"].'</span>'.$status_count["status"].'</div></div></div>';
          
        }
        return  $html;

    }
    public function prepareOrderCountHtml($order_counts){

        $html           = '';
        foreach ($order_counts as $status=>$order_count){
            
            $filter_type        = $order_count["filter_type"] ?? "";
            $filter_value       = $status;
            $url                = route("admin.orders.index", ["filter_type"=>$filter_type, "filter_value"=>$filter_value]);
            // dd($url);

          $html         .='<a href="'.$url.'"><div class="row mb-3"><div class="col-9"><div class="progress-wrapper"><span class="progress-label text-muted">'.$status.'</span><div class="progress mt-1 mb-2" style="height: 5px;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$order_count["perc"].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$order_count["perc"].'%"></div></div></div></div><div class="col-3 align-self-end text-right"><span class="h6 mb-0">'.$order_count["total"].' <strong>('.$order_count["perc"].'%)</strong></span></div></div></a>';
          
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
                    return date('m-d-Y h:i:s', $data->time_id);
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
    public function destroy(Request $request){

        $user_id    = Auth::user()->id;
        NotificationConfig::updateOrCreate(['user_id' => $user_id], [ 
            'time_id' => date('U')
        ]);
        return redirect()->route('admin.dashboard.get_all_notifications')->with('success', 'Notifications has been deleted successfully.');
    }

    public function calanderEvents(Request $request){

        $orders                     = Order::where("due_date", "!=", "")->where("due_date", ">", 0)->where('status', '!=', 5)->get();
        // $r_default_date = Order::where("due_date", "!=", "")
        // ->where("due_date", ">", 0)
        // ->where('status', '!=', 5)
        // ->orderBy('due_date') // Order by due_date in ascending order
        // ->first();

        // if ($r_default_date) {
        //     $default_date = date("Y-m-d", $r_default_date->due_date);
        // } else {
            $default_date = date("Y-m-d");
        // }

        $_events_arr                = [];
        foreach($orders as $order){
            $event                      = [];
            $event["title"]             = $order->job_name;
            $event["start"]             = date('Y-m-d', $order->due_date);
            if($order->event == "Yes"){
                $event["color"]         = "#fb7979";
            }else{
                $event["color"]         = "#22e321";

            }
            $_events_arr[]              = $event;
        }


        return json_encode(["events"=> $_events_arr, "default_date"=> $default_date]);
    }

    public function task_popup(Request $request){
        $task_id        = $request->has('task_id') ? $request->get('task_id') :  0;
        $data           = Task::find($task_id);
        return view('admin.dashboard.popups.add-task-popup', compact('task_id', 'data'));
    }

    public function save_task(Request $request){
        $response                       = ["status" => "error", "data"=>""];
        $user_id                        = Auth::user()->id;
        $task_id                        = $request->has('task_id') ? $request->task_id :  0;
        $task_detail                    = ($request->has('description')) ? $request->description: '';
        if($task_detail == ""){
            $response["data"]           = "Task detail is required.";
        }else{
            if($task_id <= 0){
                $task                       = new Task();
                $task->user_id              = $user_id;
                $task->task_detail          = $task_detail;
                $task->user_id              = $user_id;
                $task->save();
            }else{
                $task                       = Task::find($task_id);
                $task->task_detail          = $task_detail;
                $task->save();
            }
            $response["status"]         = "success";
            $todo_list_data             = Task::where("user_id", $user_id)->get();
            $todolist                   = view('admin.dashboard.todolist', compact("todo_list_data"))->render();
            $response["data"]           = $todolist;

        }
        return json_encode($response);
    }

    public function get_task(Request $request){

        $response                   = ["status" => "success", "data"=>""];
        $user_id                    = Auth::user()->id;
        $todo_list_data             = Task::where("user_id", $user_id)->get();
        $todolist                   = view('admin.dashboard.todolist', compact("todo_list_data"))->render();
        $response["data"]           = $todolist;
        return json_encode($response);
    }

    public function delete_task(Request $request){
        $task_id                    = $request->has('task_id') ? $request->task_id :  0;
        Task::where("id", $task_id)->delete();
        $response                   = ["status" => "success", "data"=>""];
        $user_id                    = Auth::user()->id;
        $todo_list_data             = Task::where("user_id", $user_id)->get();
        $todolist                   = view('admin.dashboard.todolist', compact("todo_list_data"))->render();
        $response["data"]           = $todolist;
        return json_encode($response);
    }
    public function status_task(Request $request){
        $task_id                    = $request->has('task_id') ? $request->task_id :  0;
        $is_checked                 = $request->has('is_checked') ? $request->is_checked :  0;
        Task::where("id", $task_id)->update(["is_checked"=>$is_checked]);
        $response                   = ["status" => "success", "data"=>""];
        $user_id                    = Auth::user()->id;
        $todo_list_data             = Task::where("user_id", $user_id)->get();
        $todolist                   = view('admin.dashboard.todolist', compact("todo_list_data"))->render();
        $response["data"]           = $todolist;
        return json_encode($response);
    }
}