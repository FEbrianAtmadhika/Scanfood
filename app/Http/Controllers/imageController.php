<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Process\Exceptions\ProcessFailedException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Process;

class imageController extends Controller
{
    public function result()
{
    $id = Auth::guard()->user()->id;

    $data = Result::where('id_user', $id)->get();

    return view('User.page.result', compact('data'));
}


    public function detail($id){
        $data = Result::all()->find($id);
        return view('User.page.detail', compact('data'));
    }

    public function confirm(Request $request){

    }
    public function upload(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $id = Auth::guard()->user()->id;
        $imageFile = $request->file('image');

    // Ambil nama file yang diinginkan dari input form
    $imageName = $imageFile->getClientOriginalName(); // Pastikan Anda menambahkan input field image_name pada form

    // Path untuk menyimpan file di dalam direktori public
    $publicPath = public_path('images/' . $id);

    // Pastikan direktori tujuan ada atau buat jika belum ada
    if (!File::exists($publicPath)) {
        File::makeDirectory($publicPath, 0777, true, true);
    }

    // Simpan file dengan nama kustom
    $imageFile->move($publicPath, $imageName);

    // Path lengkap file yang disimpan
    $imagePath = 'images/' . $request->input('id') . '/' . $imageName;

        $modelPath = public_path('/train8/weights/best.pt');
//         $service = new LaravelPython();
// $parameters = array($modelPath, $imagePath);
// $result = $service->run(public_path('deteksi.py'));

$pythonExecutable = base_path('venv/Scripts/python.exe');
$process = new Process([
    $pythonExecutable,
    public_path('deteksi.py'),
    $modelPath,
    $imagePath
], null, [
    'SYSTEMROOT' => getenv('SYSTEMROOT'),
    'PATH' => getenv("PATH"),
    'HOME' => "C:\\Users\\User", // Tambahkan HOME environment variable
    'USERPROFILE' => "C:\\Users\\User" // Tambahkan USERPROFILE environment variable
]);
$process->run();
        dd(collect($process));
    }

}
