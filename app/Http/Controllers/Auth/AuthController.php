<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use DB;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('admin.login');
    }  

    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function registration()
    // {
    //     return view('auth.registration');
    // }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect('/admin')->with('error', 'Oppes! You have entered invalid credentials');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function postRegistration(Request $request)
    // {  
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:6',
    //     ]);

    //     $data = $request->all();
    //     $check = $this->create($data);

    //     return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    // }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
    ]);
  }
  public function forgetPassword()
  {
      return view('admin.forget_password');
  }
  function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
public function passwordReset(Request $request)
{

    try{
        $userEmail = $request->input('email');
        $newPassword = $this->generateRandomString();

        $user = User::where('email', $userEmail)->first();
        if ($user !== null ) {
            $userUpdate = User::where('email', $userEmail)->update(['password' => Hash::make($newPassword)]);
            $newData = [];
            $newData = [
                'title'  => 'Reset Password',
                'newPassword'  => $newPassword,
                'name'          => $user->name,
                'email'          => $user->email,
            ];
            \Mail::send('admin.users.resetEmail', compact('newData') , function($message)use($newData) {
                $message->to($newData["email"])
                ->subject($newData["title"]);           
            });
            if(count(\Mail::failures()) > 0){

                return redirect()->route('login')->with('error', 'Something went wrong.');

            }else{

                return redirect()->route('login')->with('success', 'New password has been sent on your Email.');
            }

        }else{
            return redirect()->back()->with('error', 'Record Not Found.');
        }
    }catch(\Exception $e){
        return redirect()->back()->with('error','Error.Something went wrong');
    }
}
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect('admin');
    }
    public function changePassword()
{
        # code...
    try{
         $pageTitle = "Change Password";
        return view('admin.users.changePassword',compact('pageTitle'));
    }catch(\Exception $e){
        return redirect()->back()->with('error','Error.Something went Wrong');
    }
}

public function changePasswordSave(Request $request)
{
      $validator = Validator::make($request->all(), [
        'currentPassword' => ['required'],
        // 'newPassword' => ['required',
        //     'regex:/[a-z]/',      // must contain at least one lowercase letter
        //     'regex:/[A-Z]/',      // must contain at least one uppercase letter
        //     'regex:/[0-9]/',      // must contain at least one digit
        //     'regex:/[@$!%*#?&]/', // must contain a special character

        // ],
        'newPassword' => 'required',
        'newPasswordConfirm' => ['same:newPassword'],

    ],[
       'newPasswordConfirm.same' => 'The new and Confirm Password must match.',

   ]);


    $errors = $validator->errors();
    if($validator->fails())
    {
        $message = '';
        foreach ($validator->messages()->getMessages() as $field_name => $messages)
        {
                   $message = $messages[0] ;// messages are retrieved (publicly)
               }
               return redirect('admin/change-password')->withInput()->with('error',$message );

           }

        try{
           DB::beginTransaction();
           if (!(Hash::check($request->get('currentPassword'), Auth::user()->password))) {
            // The passwords matches
            // return redirect()->back()->with("error","Your current password does not matches with the password.");
            return redirect()->back()->with("error","Your Current Password is not correct.");
        }

        User::find(Auth::user()->id)->update(['password'=> Hash::make($request->newPassword)]);
        DB::commit();
        return redirect('admin/change-password')->with('success', 'Password Changed Successfully');

    }catch(\Exception $e){
        DB::rollBack();
        return redirect('/supervisor/change-password')->with('error', 'Error.Something went Wrong');
    }
    }
}