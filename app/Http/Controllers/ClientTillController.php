<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\OrderTill;
use Yajra\DataTables\DataTables;
use App\Models\Client;
class ClientTillController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
        $this->middleware('permission:view-clients-till-list|client-till-clearance', ['only' => ['index','clear_client_till']]);
        $this->middleware('permission:client-till-clearance', ['only' => ['clear_client_till']]);
     }

    public function index(Request $request, $client_id)
    {
        $pageTitle          = "Tills";
        return view('admin.tills.index',compact('client_id', 'pageTitle'));
    }

    public function ajaxtData(Request $request){

        $client_id          = $request->client_id;
        $rData              = OrderTill::select('*'); 
        if($request->date_from != ""){
        $rData          = $rData->whereHas('order',function ($query) use($request){
                            $query->where('time_id', '>=', strtotime($request->date_from));
                        });
        }
        if($request->date_from != ""){
            $rData      = $rData->orWhereHas('order',function ($query) use($request){
                                $query->where('time_id', '<=', strtotime($request->date_to));
                        });
        }
        $rData              = $rData->where('client_id', $client_id);
        $rData              = $rData->orderBy('id', 'DESC');
       
        return DataTables::of($rData->get())
            ->addIndexColumn()
            ->addColumn('client_name', function ($data) {
                if ($data->Client->first_name != "")
                    return $data->Client->first_name ." ". $data->Client->last_name;
                else
                    return '-';
            })
            ->addColumn('client_email', function ($data) {
                if ($data->Client->email != "")
                    return $data->Client->email;
                else
                    return '-';
            })
            ->editColumn('order_id', function ($data) {
                if ($data->order_id != "")
                    return $data->order_id;
                else
                    return '-';
            })
            ->editColumn('selling_price', function ($data) {
                if ($data->selling_price != "")
                    return $data->selling_price;
                else
                    return '-';
            })
            ->editColumn('deposit', function ($data) {
                if ($data->deposit != "")
                    return $data->deposit;
                else
                    return '-';
            })
            ->editColumn('balance', function ($data) {
                if ($data->balance != "")
                    return $data->balance;
                else
                    return '-';
            })
            ->editColumn('payment_type', function ($data) {
                if ($data->PaymentType->name != "")
                    return $data->PaymentType->name;
                else
                    return '-';
            })
            ->addColumn('status', function ($data) {
                if ($data->balance == 0){

                    return '<span class="badge badge-success">Cleared</span>';
                }elseif($data->balance < 0 ){

                    return '<span class="badge badge-danger">Debited</span>';
                }else{

                    return '<span class="badge badge-info">Credited</span>';
                }
                    
            })
            ->addColumn('order_date', function ($data) {
                
                if ($data->order->time_id != ""){

                    return date('Y-m-d h:i:s', $data->order->time_id);
                }else{

                    return '-';
                }
                    
            })
            ->addColumn('actions', function ($data) {

                $action_list    = '<div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti-more-alt"></i>
                </a>
            
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                if(auth()->user()->can('client-till-clearance')){

                    $action_list    .= '<a class="dropdown-item adjust-balance" data-order-id="'.$data->order_id.'" href="#"><i class="fas fa-money-check-alt"></i> Adjust Balance</a>';
                }
                $action_list    .= '</div>
                </div>';
                return  $action_list;
            })
            ->rawColumns(['actions', 'status', 'client_name', 'client_email'])
            ->make(TRUE);
    }

    
    public function update(Request $request, $id)
    {
        $till                           =  OrderTill::find($id);
        $till->selling_price            = $request->selling_price;
        $till->deposit                  = $request->deposit;
        $till->balance                  = $request->balance;
        $till->save();

        return redirect()->back()->with('success','Balance adjusted successfully');
    }
    public function get_balance_template(Request $request)
    {
        $order_id                               = $request->order_id;
        $till                                   = OrderTill::where(['order_id'=>$order_id])->first();
        
        return view('admin.tills.adjust-balance', compact('till'));
    }
 
}