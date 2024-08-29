<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function login(){
        return view('FrontPage.page.login');
    }

    public function register(){
        return view('FrontPage.page.register');
    }

    public function history()
    {

        $results = Result::where('id_user', Auth::id())->get();

        return view('User.page.history', compact('results'));
    }

    public function detail($id){
         $result = Result::with('hasil_makanan.food')->findOrFail($id);

         return view('User.page.detail', [
             'result' => $result,
             'foodResults' => $result->hasil_makanan,
         ]);
    }

    public function destroy($id)
    {
        try {
            $result = Result::with('hasil_makanan')->findOrFail($id);

            foreach ($result->hasil_makanan as $foodResult) {
                $foodResult->delete();
            }

            $imagePath = public_path('images/' . $result->user->id . '/' . $result->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            } else {
                return redirect()->route('history')->with('error', 'Gambar tidak ditemukan.');
            }

            $result->delete();

            return redirect()->route('history')->with('success', 'Hasil deteksi berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus hasil deteksi.');
        }
    }


}
