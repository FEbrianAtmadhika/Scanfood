<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login_submit(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credential)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Information is not correct!');
        }
    }

    public function register_submit(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'name'=> 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = new User();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->save();

            $credential = [
                'email' => $request->email,
                'password' => $request->password
            ];
            if(Auth::attempt($credential)) {
                return redirect()->route('dashboard')->with('message','Berhasil Membuat Akun');
            };
        } catch (\Throwable $th) {
        }

    }

    public function logout_submit(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboard(){
        $data = User::paginate(1);
        return view('User.page.dashboard');
    }
}
