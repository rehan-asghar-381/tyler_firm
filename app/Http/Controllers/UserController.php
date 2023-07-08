<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\UserType;
use App\Models\Hatchery;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;
use Auth;
class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
        $this->middleware('permission:users-list|users-create|users-edit|users-delete', ['only' => ['index','store']]);
        $this->middleware('permission:users-create', ['only' => ['create','store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:users-list', ['only' => ['index']]);
     }

    public function index(Request $request)
    {
        $pageTitle          = "Users";
        $data               = User::orderBy('id','DESC');
        return view('admin.users.index',compact('data', 'pageTitle'));
    }

    public function ajaxtData(Request $request){

        $rData = User::select('*');
        if(!auth()->user()->hasRole('Super Admin')){
            $rData = $rData->whereRaw('id not in
                                    (
                                        select model_id
                                        from model_has_roles
                                        where role_id in (1)
                                    )');
        }
        $rData = $rData->orderBy('id', 'DESC');

        return DataTables::of($rData->get())
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                if ($data->name != "")
                    return $data->name;
                else
                    return '-';
            })
            ->editColumn('email', function ($data) {
                if ($data->email != "")
                    return $data->email;
                else
                    return '-';
            })
            ->editColumn('user_name', function ($data) {
                if ($data->username != "")
                    return $data->username;
                else
                    return '-';
            })
            ->addColumn('user_role', function ($data) {

                $roles  = [];
                if(!empty($data->getRoleNames())){

                    foreach($data->getRoleNames() as $v){
                        
                        $roles[] = $v;
                    }
                    $role = '<span class="badge badge-green">'.implode(",", $roles).'</span>';
                }
                return $role;
            })
            ->addColumn('actions', function ($data) {

                $action_list    = '<div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti-more-alt"></i>
                </a>
            
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                if(auth()->user()->can('users-edit')){

                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.users.edit',$data->id).'"><i class="far fa-edit"></i> Edit</a>';
                }
                if(auth()->user()->can('users-delete')){
                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.users.destroy',$data->id).'"><i class="far fa-trash-alt"></i> Delete</a>';
                }
                $action_list    .= '</div>
                </div>';
                return  $action_list;
            })
            ->rawColumns(['actions', 'user_role'])
            ->make(TRUE);

    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle      = "Users";
        $roles          = Role::pluck('name','id')->all();
        return view('admin.users.create',compact('roles', 'pageTitle'));

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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        
        $input['password'] = bcrypt($input['password']);
        
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('admin.users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
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
        $user               = User::find($id);
        $roles              = Role::pluck('name','name')->all();
        $userRole           = $user->roles->pluck('name','name')->all();
        return view('admin.users.edit',compact('user','roles','userRole', 'pageTitle'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        
        $input = $request->all();

        if(!empty($input['password'])){ 
            $input['password'] = bcrypt($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('admin.users.index')
                        ->with('success','User updated successfully');
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
    
}