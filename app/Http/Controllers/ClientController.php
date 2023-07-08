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

    public function create_measurement_sheet(Request $request, $client_id){
        $pageTitle              = "Clients";
        $measurmement           = ClientMeasurement::where(['client_id'=>$client_id])->first();
        $shop_sizes             = ShopSize::where('is_active', 'Y')->get();
        return view('admin.clients.measurement-sheet', compact('measurmement', 'shop_sizes', 'pageTitle', 'client_id'));
    }
    public function store_measurement_sheet(Request $request, $client_id){
        $this->save_measurements($request, $client_id);
        return redirect()->route('admin.clients.index')
                        ->with('success','Client measurement saved successfully');
    }

    public function save_measurements($request, $client_id){
       
        $user_id                            = Auth::user()->id;
        $user_name                          = Auth::user()->name;
        $rData                              = $request->all();
        $measurement                        = ClientMeasurement::firstOrNew(['client_id' => $client_id]); 
        $measurement->client_id             = $client_id;
        $measurement->title                 = $rData['title'];
        $measurement->measurement_type      = $rData['measurement_type'];
        $measurement->field1_hb             = $rData['field1_hb'];
        $measurement->field2_b              = $rData['field2_b'];
        $measurement->field3_w              = $rData['field3_w'];
        $measurement->field4_hh             = $rData['field4_hh'];
        $measurement->field5_h              = $rData['field5_h'];
        $measurement->field6_sh             = $rData['field6_sh'];
        $measurement->field7_half_sh        = $rData['field7_half_sh'];
        $measurement->field8_sh_w           = $rData['field8_sh_w'];
        $measurement->field9_sh_kn          = $rData['field9_sh_kn'];
        $measurement->field10_sh_g          = $rData['field10_sh_g'];
        $measurement->field11_w_kn          = $rData['field11_w_kn'];
        $measurement->field12_w_g           = $rData['field12_w_g'];
        $measurement->field13_arm           = $rData['field13_arm'];
        $measurement->field14_half_arm      = $rData['field14_half_arm'];
        $measurement->field15_arm_depth     = $rData['field15_arm_depth'];
        $measurement->field16_bicep         = $rData['field16_bicep'];
        $measurement->field17_wrist         = $rData['field17_wrist'];
        $measurement->field18_sh_w          = $rData['field18_sh_w'];
        $measurement->field19_tw            = $rData['field19_tw'];
        $measurement->field20_sh_hh         = $rData['field20_sh_hh'];
        $measurement->created_by_id         = $user_id;
        $measurement->created_by_name       = $user_name;
      
        $measurement->save();

        return true;
    }


    
}