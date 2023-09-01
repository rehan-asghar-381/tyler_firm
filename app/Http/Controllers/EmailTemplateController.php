<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\BrandImg;
use Yajra\DataTables\DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;
class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
        $this->middleware('permission:email-template-list|email-template-create|email-template-edit|email-template-delete', ['only' => ['index','store']]);
        $this->middleware('permission:email-template-create', ['only' => ['create','store']]);
        $this->middleware('permission:email-template-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:email-template-list', ['only' => ['index']]);
     }

    public function index(Request $request)
    {
        $pageTitle          = "Email Template";
        return view('admin.email-template.index',compact('pageTitle'));
    }

    public function ajaxtData(Request $request){

        $rData = EmailTemplate::select('*');
        $rData = $rData->orderBy('id', 'DESC');
      
        return DataTables::of($rData->get())
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                if ($data->name != "")
                    return $data->name;
                else
                    return '-';
            })
            ->editColumn('description', function ($data) {
                if ($data->description != "")
                    return $data->description;
                else
                    return '-';
            })
            ->editColumn('time_id', function ($data) {
                if ($data->time_id != "")
                    return date('m-d-Y h:i:s', $data->time_id);
                else
                    return '-';
            })
            ->addColumn('actions', function ($data) {

                $action_list    = '<div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti-more-alt"></i>
                </a>
            
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                
                if(auth()->user()->can('email-template-show')){

                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.email-template.show',$data->id).'"><i class="far fa-eye"></i> View Detail</a>';
                }
                if(auth()->user()->can('email-template-edit')){

                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.email-template.edit',$data->id).'"><i class="far fa-edit"></i> Edit</a>';
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
        $pageTitle      = "Email Template";
        return view('admin.email-template.create',compact('pageTitle'));

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rData                      = $request->all();
        $user_id                    = Auth::user()->id;
        $user_name                  = Auth::user()->name;
        // $rules = [
        //     'code' => 'unique:brands,name'
        // ];
        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails())
        // {
        //     return redirect()->back()->withInput($request->input())->withErrors($validator);
        // }
        $brand                    = new EmailTemplate();
        $brand->time_id           = date('U');
        $brand->name              = $rData['name'];
        $brand->description       = $rData['description'];
        $brand->created_by_id                     = $user_id;
        $brand->created_by_name                   = $user_name;
        $brand->save();
        return redirect()->route('admin.email-template.index')
                        ->with('success','Template added successfully');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle      = "Email Template";
        $template          = EmailTemplate::find($id);
        return view('admin.email-template.edit',compact('pageTitle', 'template'));
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
        $rData                      = $request->all();
        $user_id                    = Auth::user()->id;
        $user_name                  = Auth::user()->name;
        // $rules = [
        //     'code' => 'unique:brands,name,'.$id
        // ];
        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails())
        // {
        //     // dd($validator);
        //     return redirect()->back()->withInput($request->input())->withErrors($validator);
      
        // }
        $brand                    = EmailTemplate::find($id);
        $brand->time_id           = date('U');
        $brand->name              = $rData['name'];
        $brand->description       = $rData['description'];
        $brand->updated_by_id     = $user_id;
        $brand->updated_by_name   = $user_name;
        $brand->save();
       
        return redirect()->route('admin.email-template.index')
                        ->with('success','Template updated successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle      = "Email Template";
        $template          = EmailTemplate::find($id);
        return view('admin.email-template.show',compact('pageTitle', 'template'));
    }
}