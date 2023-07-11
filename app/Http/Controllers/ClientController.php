<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ShopSize;
use App\Models\ClientMeasurement;
use Yajra\DataTables\DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;
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
            ->addColumn('actions', function ($data) {

                $action_list    = '<div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti-more-alt"></i>
                </a>
            
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if(auth()->user()->can('clients-edit')){

                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.clients.edit',$data->id).'"><i class="far fa-edit"></i> Edit</a>';
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required'
        ]);
        $client = new Client();

        $client->first_name         = $request->first_name;
        $client->last_name          = $request->last_name;
        $client->email              = $request->email;
        $client->phone_number       = $request->phone_number;
        $client->save();

        return redirect()->route('admin.clients.index')
                        ->with('success','Client created successfully');
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
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle          = "Users";
        $client             = Client::find($id);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required'
        ]);
        $client = Client::find($id);

        $client->first_name         = $request->first_name;
        $client->last_name          = $request->last_name;
        $client->email              = $request->email;
        $client->phone_number       = $request->phone_number;
        $client->save();
    
        return redirect()->route('admin.clients.index')
                        ->with('success','Client updated successfully');
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
}