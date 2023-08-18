<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientDoc;
use App\Models\Status;
use App\Models\ClientSaleRep;
use App\Models\Order;
use Yajra\DataTables\DataTables;
use Validator;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:clients-list|clients-create|clients-edit|clients-delete', ['only' => ['index','store']]);
        $this->middleware('permission:clients-create', ['only' => ['create','store']]);
        $this->middleware('permission:clients-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:clients-list', ['only' => ['index']]);
    }

    
    public function index(Request $request)
    {
        // dd(auth()->user()->getAllPermissions()  );
        $pageTitle          = "Clients";
        $data               = Client::orderBy('id','DESC');
        return view('admin.clients.index',compact('data', 'pageTitle'));
    }

    public function ajaxtData(Request $request){

        $rData = Client::select('*');
        $rData = $rData->orderBy('id', 'DESC');
        
        return DataTables::of($rData->get())
        ->addIndexColumn()
        ->editColumn('company_name', function ($data) {
            if ($data->company_name != "")
                return $data->company_name;
            else
                return '-';
        })
        ->editColumn('first_name', function ($data) {
            if ($data->first_name != "")
                return $data->first_name;
            else
                return '-';
        })
        ->editColumn('last_name', function ($data) {
            if ($data->last_name != "")
                return $data->last_name;
            else
                return '-';
        })
        ->editColumn('email', function ($data) {
            if ($data->email != "")
                return $data->email;
            else
                return '-';
        })
        ->editColumn('phone_number', function ($data) {
            if ($data->phone_number != "")
                return $data->phone_number;
            else
                return '-';
        })
        ->editColumn('reseller_number', function ($data) {
            if ($data->reseller_number != "")
                return $data->reseller_number;
            else
                return '-';
        })
        ->editColumn('tax_examp', function ($data) {
            if ($data->tax_examp != "")
                return $data->tax_examp;
            else
                return '-';
        })
        ->addColumn('actions', function ($data) {

            $action_list    = '<div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti-more-alt"></i>
            </a>
            
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

            if(auth()->user()->can('clients-edit')){

                $action_list    .= '<a class="dropdown-item" href="'.route('admin.clients.edit',$data->id).'"><i class="far fa-edit"></i> Edit</a>';
            }
            if(auth()->user()->can('clients-view')){

                $action_list    .= '<a class="dropdown-item" href="'.route('admin.client.detail',$data->id).'"><i class="far fa-eye"></i> View</a>';
            }
            if(auth()->user()->can('clients-Previous-Order')){

                $action_list    .= '<a class="dropdown-item" href="'.route('admin.client.previousOrder',$data->id).'"><i class="fa fa-arrow-left"></i> Orders History</a>';
            }

            $action_list    .= '</div>
            </div>';
            return  $action_list;
        })
        ->rawColumns(['actions'])
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
        $pageTitle      = "Clients";
        return view('admin.clients.create',compact('pageTitle', 'errors'));

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'office_phone_number' => 'required',
            'website' => 'required',
            'address' => 'required',
            'notes' => 'required',
            'tax' => 'required',
            'resale_number' => 'required',
        ]);
        $client = new Client();


        $client->company_name = $request->company_name;
        $client->office_phone_number = $request->office_phone_number;
        $client->website = $request->website;
        $client->address = $request->address;
        $client->notes = $request->notes;
        $client->tax = $request->tax;
        $client->resale_number = $request->resale_number;
        $client->save();
        $clientID                                  = $client->id;
        
        if (isset($request->customer_doc) && count($request->customer_doc) > 0) {
            // dd($request->customer_doc);
            $this->save_client_docs($request->file('customer_doc'), $clientID);
        }
        if (count($request->first_name) > 0) {
            $this->save_client_sales_rep($request, $clientID);
        }

        return redirect()->route('admin.clients.index')
        ->with('success','Client created successfully');
    }
    public function save_client_docs($files_arr=[], $client_id){
        $client                  = Client::find($client_id);
        $client_docs = [];
        if(isset($files_arr)){
            foreach($files_arr as $file){             
                if(is_file($file)){
                    $original_name = $file->getClientOriginalName();
                    $file_name = time().rand(100,999).$original_name;
                    $destinationPath = public_path('/uploads/cleint/docs/');
                    $file->move($destinationPath, $file_name);
                    $file_slug  = "/uploads/cleint/docs/".$file_name;

                    $clientdoc                    = new ClientDoc();
                    $clientdoc->client_id         = $client_id;
                    $clientdoc->doc             = $file_slug;
                    $client_docs[]             = $clientdoc;
                }

            }
            $client->ClientDoc()->delete();
            $client->ClientDoc()->saveMany($client_docs);
        }
    }
    public function save_client_sales_rep($request, $client_id){
        $client                  = Client::find($client_id);
        $clientSalesRepArr = [];
        foreach($request->first_name as $key=>$rr){                         
            $client_sales_rep                    = new ClientSaleRep();
            $client_sales_rep->client_id         = $client_id;
            $client_sales_rep->first_name        = $request->first_name[$key];
            $client_sales_rep->last_name         = $request->last_name[$key];
            $client_sales_rep->email             = $request->email[$key];
            $client_sales_rep->phone_number      = $request->phone_number[$key];
            $clientSalesRepArr[]                 = $client_sales_rep;
            
            
        }
        $client->ClientSaleRep()->delete();
        $client->ClientSaleRep()->saveMany($clientSalesRepArr);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id             = $request->client_id;
        $client         = Client::find($id);
        return $client;
    }
    public function clientDetail(Request $request,$id)
    {

        $pageTitle          = "Client Vliew";
        $client             = Client::with('ClientSaleRep','ClientDoc')->get()->find($id);
        return view('admin.clients.show',compact('client', 'pageTitle'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle          = "Client Edit";
        $client             = Client::with('ClientSaleRep','ClientDoc')->get()->find($id);
        return view('admin.clients.edit',compact('client', 'pageTitle'));
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
      $this->validate($request, [
        'company_name' => 'required',
        'office_phone_number' => 'required',
        'website' => 'required',
        'address' => 'required',
        'notes' => 'required',
        'tax' => 'required',
        'resale_number' => 'required',
    ]);


      $client = Client::find($id);
      $client->company_name = $request->company_name;
      $client->office_phone_number = $request->office_phone_number;
      $client->website = $request->website;
      $client->address = $request->address;
      $client->notes = $request->notes;
      $client->tax = $request->tax;
      $client->resale_number = $request->resale_number;
      $client->update();

      if ( isset($request->customer_doc) && count($request->customer_doc) > 0) {
        $this->save_client_docs($request->file('customer_doc'), $id);
    }
    if (isset($request->first_name) && count($request->first_name) > 0) {
        $this->save_client_sales_rep($request, $id);
    }
    return redirect()->route('admin.clients.index')
    ->with('success','Client Update successfully');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('admin.users.index')
        ->with('success','User deleted successfully');
    }

    public function add_client(Request $request)
    {
        $rData          = $request->all(); 
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:clients,email',
            'phone_number' => 'required'
        ];
        $errors             = [];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $errors         = $validator->getMessageBag()->toArray();
            // dd($errors);
            return view('admin.clients.add-client', compact('rData', 'errors'));
        }
        
        $client                     = new Client();
        $client->first_name         = $request->first_name;
        $client->last_name          = $request->last_name;
        $client->email              = $request->email;
        $client->phone_number       = $request->phone_number;
        $client->save();

        $rData                     = $client->toArray();

        return view('admin.clients.add-client', compact('rData', 'errors'));
    }

    public function get_client(Request $request)
    {

        $client_id                  = ($request->client_id != "") ? $request->client_id: "";
        $clients                    = Client::get();
        $options                    = '<option value="">--select--</option>';

        foreach ($clients as $key => $client) {
            $selected       = ($client->id == $client_id) ? "selected": "";
            $options        .= '<option value="'.$client->id.'" '.$selected.'>'.$client->first_name.' '.$client->last_name.'</option>';
        }

        $options        .= '<option value="new">Add New Client</option>';

        return $options;


    }
    public function delete_doc(Request $request)
    {

        $client_id             = $request->client_id;
        $doc_id                 = $request->doc_id;
        ClientDoc::where(['client_id'=> $client_id, 'id'=>$doc_id])->delete();
        return json_encode(array("status"=>true));

    }

    public function get_sales_rep(Request $request){
        
        $client_id          = $request->client_id;
        $sales_rep          = ClientSaleRep::where('client_id', $client_id)->get();
        return response()->json([
            'sales_rep' => $sales_rep
        ]);

    }

    public function previousOrder(Request $request,$id){
    
        $pageTitle          = "Client  Previous Order";
        $statuses           = Status::where('id', 5)->get(['id', 'name']);
        
        foreach($statuses as $key=>$status){

            $statuses_arr['"'.$key.'"']          = $status;
        }

        $client_id          = $id;
        return view('admin.orders.previous-order', compact('pageTitle', 'statuses_arr', 'client_id'));
    }

    public function ajaxClientsOrderHistory(Request $request){
        
        $rData          = Order::where('client_id', $request->client_id);
        if($request->date_from != ""){
            $rData      = $rData->where('time_id', '>=', strtotime($request->date_from));
        }
        if($request->date_to != ""){
            $rData      = $rData->where('time_id', '<=', strtotime($request->date_to));
        }
        if($request->status_id != ""){
            $rData      = $rData->where('status', '=', $request->status_id);
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
            $action_list    .= '<a class="dropdown-item" href="'.route('admin.order.recreate', $data->id).'"><i class="far fa fa-retweet"></i> Replicate-Order</a>';
            if(auth()->user()->can('orders-generate-invoice')){
                $action_list    .= '<a class="dropdown-item "  href="'.route('admin.order.generateInvoice', $data->id) .'" data-status="'.$data->status.'" data-id="'.$data->id.'"><i class="far fa fa-print"></i> Generate Invoice</a>';
            }
            $action_list        .= '</div></div>';
            return  $action_list;
        })
        ->rawColumns(['actions'])
        ->make(TRUE);
    }
}