<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use DB;
use Illuminate\Support\Facades\Auth;
class RoleController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:roles-list|roles-create|roles-edit|roles-delete', ['only' => ['index','store']]);
         $this->middleware('permission:roles-create', ['only' => ['create','store']]);
         $this->middleware('permission:roles-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:roles-delete', ['only' => ['destroy']]);

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageTitle          = "Roles";
        $roles = Role::orderBy('id','DESC');
        return view('admin.roles.index',compact('roles', 'pageTitle'));
    }

    public function ajaxtData(Request $request){

        
        $rData              = Role::with('permissions')->where('name', '!=', 'Super-Admin')->orderBy('id','ASC');
        return DataTables::of($rData->get())
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                if ($data->name != "")
                    return $data->name;
                else
                    return '-';
            })
            ->editColumn('created_at', function ($data) {
                if ($data->created_at != "")
                    return $data->created_at;
                else
                    return '-';
            })
            ->addColumn('actions', function ($data){
                $action_list    = '<div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti-more-alt"></i>
                </a>
            
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                if(auth()->user()->can('roles-edit')){

                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.roles.edit',$data->id).'"><i class="far fa-edit"></i> Edit</a>';
                }
                // if(auth()->user()->can('roles-delete')){
                //     $action_list    .= '<a class="dropdown-item" href="'.route('admin.roles.destroy',$data->id).'"><i class="far fa-trash-alt"></i> Delete</a>';
                // }
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
        $pageTitle   = "Roles";
        $permissions = Permission::get()->groupBy('modules');

        return view('admin.roles.create',compact('permissions', 'pageTitle'));
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('admin.roles.index')
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();
        
        return view('roles.show',compact('role','rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $key_roles          = ["Super Admin", "Tailor", "Admin", "Production Manager"];
        $pageTitle          = "Roles";
        $role               = Role::find($id);
        $permissions        = Permission::get()->groupBy('modules');
        $rolePermissions    = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.edit',compact('role','permissions','rolePermissions', 'pageTitle', 'key_roles'));
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
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('admin.roles.index')
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('admin.roles.index')
                        ->with('success','Role deleted successfully');
    }
}