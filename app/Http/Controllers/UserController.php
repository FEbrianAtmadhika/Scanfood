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

    public function update(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'berat' => 'required|numeric|between:0,99999.99',
            'tinggi' => 'required|numeric|between:0,99999.99',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = User::find(Auth::guard()->user()->id);

        $data->berat = $request->berat;
        $data->tinggi = $request->tinggi;

        $baseWeight = 13;
        $data->karbohidrat = ($data->berat / $baseWeight) * 215;
        $data->energi = ($data->berat / $baseWeight) * 1350;
        $data->protein = ($data->berat / $baseWeight) * 20;
        $data->lemak = ($data->berat / $baseWeight) * 45;
        $data->Vit_A = ($data->berat / $baseWeight) * 400;
        $data->Vit_B = ($data->berat / $baseWeight) * 7;
        $data->Vit_C = ($data->berat / $baseWeight) * 40;
        $data->Kalsium = ($data->berat / $baseWeight) * 650;
        $data->Zat_Besi = ($data->berat / $baseWeight) * 7;
        $data->Zink = ($data->berat / $baseWeight) * 3;
        $data->Tembaga = ($data->berat / $baseWeight) * 340;
        $data->serat = ($data->berat / $baseWeight) * 19;
        $data->fosfor = ($data->berat / $baseWeight) * 460;
        $data->air = ($data->berat / $baseWeight) * 1150;
        $data->natrium = ($data->berat / $baseWeight) * 800;
        $data->kalium = ($data->berat / $baseWeight) * 2600;

        $updated = $data->update();

        if ($updated) {
            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
}


    public function logout_submit(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboard(){
        return view('user.page_2.dashboard');
    }
    public function scan(){
        return view('User.page_2.upload');
    }
}
