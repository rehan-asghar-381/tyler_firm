<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Job;
use Yajra\DataTables\DataTables;
use App\Models\PaymentType;
use App\Traits\NotificationTrait;
class JobController extends Controller
{
    use NotificationTrait;

    function __construct()
    {
         $this->middleware('permission:jobs-list|jobs-edit', ['only' => ['index']]);
         $this->middleware('permission:jobs-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jobs-view', ['only' => ['show']]);
         $this->middleware('permission:jobs-delete', ['only' => ['destroy']]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $pageTitle                              = "Productions";
        return view('admin.jobs.index', compact('pageTitle'));
    } 

    public function ajaxtData(Request $request){
        
        $rData              = Job::where('id', '<>',0)
                            ->orderBy('completion_date_time', 'desc');

        if(!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('Admin')){

            // if(auth()->user()->hasRole('Production Manager')){

            //     $rData                     =$rData->where('created_by_id', auth()->user()->id);

            // }else
            if(auth()->user()->hasRole('Tailor')){

                $rData                     =$rData->where('tailor_id', auth()->user()->id);
            }

        }

        if($request->name != ""){

            $rData              = $rData->whereHas('User', function ($query) use($request) {
                $query->where('users.name','like', '%'.$request->name.'%');
            
            });
        }

        if($request->date_from != ""){
            
            $rData              = $rData->where('completion_date_time_timestamp', '>=', strtotime($request->date_from));
        }

        if($request->date_to != ""){

            $rData              = $rData->where('completion_date_time_timestamp', '<=', strtotime($request->date_to));
        }

        if($request->status_id != ""){

            $rData              = $rData->where('status', '=', $request->status_id);
        }
        return DataTables::of($rData->get())
        ->addIndexColumn()
            ->editColumn('order_id', function ($data) {
                if ($data->order_id != "")
                    return $data->order_id;
                else
                    return '-';
            })
            ->editColumn('tailor_id', function ($data) {
                if ($data->User->name != "")
                    return $data->User->name;
                else
                    return '-';
            })
            ->editColumn('status_id', function ($data) {
                if ($data->Status->name != "")
                    return $data->Status->name;
                else
                    return '-';
            })
            ->editColumn('start_date_time', function ($data) {
                if ($data->start_date_time != "")
                    return $data->start_date_time;
                else
                    return '-';
            })
            ->editColumn('completion_date_time', function ($data) {
                if ($data->completion_date_time != "")
                    return $data->completion_date_time;
                else
                    return '-';
            })
            ->editColumn('notes', function ($data) {
                if ($data->notes != "")
                    return $data->notes;
                else
                    return '-';
            })
            ->editColumn('assigend_by_name', function ($data) {
                if ($data->assigend_by_name != "")
                    return $data->assigend_by_name;
                else
                    return '-';
            })
            ->editColumn('status', function ($data) {
                    if($data->status == 0){

                        return "Pending";
                    }elseif($data->status == 1){

                        return "In-Process";
                    }elseif($data->status == 2){

                        return "Completed";
                    }else{
                    
                        return '-';
                    }
                
            })
            ->addColumn('actions', function ($data){

                $action_list    = '<div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-more-alt"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                if(auth()->user()->can('jobs-view')){
                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.job.detail', $data->id).'"><i class="far fa-eye"></i> Task Details</a>';
                }
                if(auth()->user()->can('jobs-change-status')){

                    $action_list    .= '<a class="dropdown-item btn-change-status" href="#" data-status="'.$data->status.'" data-id="'.$data->id.'"><i class="far fa fa-life-ring"></i> Change Status</a>';
                }
                if(auth()->user()->can('jobs-delete')){

                    $action_list    .= '<a class="dropdown-item _deld" href="'.route('admin.job.delete', $data->id).'" ><i class="far fa fa-trash-alt"></i> Delete Task</a>';
                }
                
                $action_list        .= '</div></div>';
                return  $action_list;
            })
            ->rawColumns(['actions'])
            ->make(TRUE);
    }

    public function store(Request $request)
    {
        $user_id                        = Auth::user()->id;
        $user_name                      = Auth::user()->name;
        $order_id                       = $request->order_id;
        $status_id_arr                  = $request->status_id;
        $start_date_time_arr            = $request->start_date_time;
        $completion_date_time_arr       = $request->completion_date_time;
        $tailor_id_arr                  = $request->tailor_id;
        $notes_arr                      = $request->notes;
        $flag                           = 0;

        foreach($status_id_arr as $key=>$status_id){

            $data                       = [];

            $data['order_id']                           = $order_id;
            $data['status_id']                          = $status_id;
            $data['tailor_id']                          = $tailor_id_arr[$key];
            $data['start_date_time']                    = $start_date_time_arr[$key];
            $data['start_date_time_timestamp']          = 
            $data['completion_date_time']               = $completion_date_time_arr[$key];
            $data['completion_date_time_timestamp']     = ($completion_date_time_arr[$key] != "") ? strtotime($completion_date_time_arr[$key]): "";
            $data['assigend_by_id']                     = $user_id;
            $data['assigend_by_name']                   = $user_name;


            if($data['start_date_time'] != "" && $data['completion_date_time'] != "" && $data['tailor_id'] != ""){

                $job                                    = Job::firstOrNew(['status_id' => $status_id, 'order_id' => $order_id]);
                
                $job->tailor_id                         = $tailor_id_arr[$key];
                $job->start_date_time                   = $start_date_time_arr[$key];
                $job->start_date_time                   = $start_date_time_arr[$key];
                $job->start_date_time_timestamp         = ($start_date_time_arr[$key] != "") 
                                                        ? strtotime($start_date_time_arr[$key])
                                                        : "";
                $job->completion_date_time              = $completion_date_time_arr[$key];
                $job->completion_date_time_timestamp    = ($completion_date_time_arr[$key] != "") 
                                                        ? strtotime($completion_date_time_arr[$key])
                                                        : "";
                $job->notes                             = $notes_arr[$key];
                $job->assigend_by_id                    = $user_id;
                $job->assigend_by_name                  = $user_name;
                $job->save();

                $flag                                   = 1;
            }

        }

        if($flag){

            return json_encode(array("status"=>true, "message"=>"Data has been saved successfully!"));
        }else{

            return json_encode(array("status"=>true, "message"=>"Not found any change in assigning Tasks!"));
        }
    }

    public function jobDetail(Request $request, $id)
    {
        
        $job_detail                 = Job::find($id);
        // $order_detail               = Order::find($job_detail->order_id);
        $order_detail               = Order::with([
            'OrderSupply', 
            'OrderImgs', 
            'AdditionalFields', 
            'Orderstatus',
            'OrderJobs',
            'OrderType',
            'client',
            'OrderSupply.SupplyInventoryItem',
            'OrderTill'
        ])->find($job_detail->order_id);
        $pageTitle                  = "Production Detail";
        $payments_types             = PaymentType::where('is_active', 'Y')->get();
        // dd($order_detail->OrderImgs);
        return view('admin.jobs.job-detail', compact('pageTitle', 'job_detail', 'order_detail', 'payments_types'));

    }

    public function status_update(Request $request)
    {
        $status_name            = ""; 
        $job_id                 = $request->get('job_id');
        $status                 = $request->get('status_id');

        $job                    = Job::find($job_id);
        $job->status            = $status;
        $job->save();
        $user_id                        = Auth::user()->id;
        $user_name                      = Auth::user()->name;
        if($status == 0){

            $status_name     = "Pending";
        }elseif($status == 1){

            $status_name     = "In progress";
        }elseif($status == 2){
            $status_name     = "Completed";
        }
        $body                           = $user_name." set Status to <strong>".$status_name."</strong> for Task ( <strong>#".$job->id."</strong> )";
        $data['idFK']                   = $job->id;
        $data['type']                   = 'tasks';
        $data['added_by_id']            = $user_id;
        $data['added_by_name']          = $user_name;
        $data['body']                   = $body;
        $data['time_id']                = date('U');
        $this->add_notification($data);
        return json_encode(array("status"=>true, "message"=>"Status has been updated successfully!"));

    }

    public function assign_jobs(Request $request)
    {
        
        $user_id                        = Auth::user()->id;
        $user_name                      = Auth::user()->name;
        $order_id                       = $request->order_id;
        $status_id_arr                  = $request->status_id;
        $start_date_time_arr            = $request->start_date_time;
        $completion_date_time_arr       = $request->completion_date_time;
        $tailor_id_arr                  = $request->tailor_id;
        $notes_arr                      = $request->notes;
        $flag                           = 0;
        
        foreach($status_id_arr as $key=>$status_id){
            
            $data                       = [];

            $data['order_id']                           = $order_id;
            $data['status_id']                          = $status_id;
            $data['tailor_id']                          = isset($tailor_id_arr[$key]) ?  $tailor_id_arr[$key]: [];
            
            $data['start_date_time']                    = $start_date_time_arr[$key];
            $data['start_date_time_timestamp']          = ($start_date_time_arr[$key] != "") 
                                                        ? strtotime($start_date_time_arr[$key])
                                                        : "";
            $data['completion_date_time']               = $completion_date_time_arr[$key];
            $data['completion_date_time_timestamp']     = ($completion_date_time_arr[$key] != "") 
                                                        ? strtotime($completion_date_time_arr[$key])
                                                        : "";
            $data['notes']                              = $notes_arr[$key];
            $data['assigend_by_id']                     = $user_id;
            $data['assigend_by_name']                   = $user_name;

            
            if($data['start_date_time'] != "" && $data['completion_date_time'] != "" && count($data['tailor_id']) > 0){
                
                foreach($data['tailor_id'] as $tailor_id){
                    
                    $job                                    = Job::firstOrNew(['status_id' => $status_id, 'order_id' => $order_id, "tailor_id"=>$tailor_id]);
                    $newOrFirst     = $job;  
                    $job->tailor_id                         = $tailor_id;
                    $job->start_date_time                   = $start_date_time_arr[$key];
                    $job->start_date_time_timestamp         = ($start_date_time_arr[$key] != "") 
                                                            ? strtotime($start_date_time_arr[$key])
                                                            : "";
                    $job->completion_date_time              = $completion_date_time_arr[$key];
                    $job->completion_date_time_timestamp    = ($completion_date_time_arr[$key] != "") 
                                                            ? strtotime($completion_date_time_arr[$key])
                                                            : "";
                    $job->notes                             = $notes_arr[$key];
                    $job->assigend_by_id                    = $user_id;
                    $job->assigend_by_name                  = $user_name;

                    $job->save();

                    if ($newOrFirst->exists) {
                        $body                           = $user_name." created a new Task ( <strong>#".$job->id."</strong> )";
                        $data['idFK']                   = $job->id;
                        $data['type']                   = 'tasks';
                        $data['added_by_id']            = $user_id;
                        $data['added_by_name']          = $user_name;
                        $data['body']                   = $body;
                        $data['time_id']                = date('U');
                        $this->add_notification($data);
                    } else {
                       // do nothing
                    }
                }
                $flag                                   = 1;
            }

        }

        if($flag){

            return json_encode(array("status"=>true, "message"=>"Data has been saved successfully!"));
        }else{

            return json_encode(array("status"=>true, "message"=>"Not found any change in assigning Tasks!"));
        }

    }

    public function destroy(Request $request, $id)
    {
        $user_id                        = Auth::user()->id;
        $user_name                      = Auth::user()->name;
        $job        = Job::find($id);
        $job->delete();
        $body                           = $user_name." deleted a Task ( <strong>#".$job->id."</strong> )";
        $data['idFK']                   = $job->id;
        $data['type']                   = 'tasks';
        $data['added_by_id']            = $user_id;
        $data['added_by_name']          = $user_name;
        $data['body']                   = $body;
        $data['time_id']                = date('U');
        $this->add_notification($data);
        return redirect()->route("admin.job.index")->withSuccess('Job data has been deleted successfully!');

    }

    
}