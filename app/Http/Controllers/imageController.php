<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\food_result;
use App\Models\Result;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Process\Exceptions\ProcessFailedException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Process;
use Illuminate\Support\Str;

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
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg',
        ]);

        $userId = Auth::guard()->user()->id;
        $imageFile = $request->file('image');
        $uniqueImageName = Str::uuid() . '.' . $imageFile->getClientOriginalExtension();
        $publicPath = public_path('images/' . $userId);
        if (!File::exists($publicPath)) {
            File::makeDirectory($publicPath, 0777, true, true);
        }
        $imageFile->move($publicPath, $uniqueImageName);
        $imagePath = $publicPath . '/' . $uniqueImageName;

        $response = Http::attach(
            'image', file_get_contents($imagePath), $uniqueImageName
        )->post('http://127.0.0.1:5000/pyton_object_detection');
        $boundingBoxes = $response->json();

        $validBoxes = array_filter($boundingBoxes, function($box) {
            return $box['confidence'] >= 0.5;
        });
        if (empty($validBoxes)) {
            File::delete($imagePath);
            return back()->with('error', 'Tidak terdeteksi apapun di gambar.');
        }

        $img = imagecreatefromjpeg($imagePath);
        if (!$img) {
            $img = imagecreatefrompng($imagePath);
        }
        if (!$img) {
            File::delete($imagePath);
            return back()->with('error', 'Unsupported image format');
        }

        $color = imagecolorallocate($img, 0, 255, 0);
        $textColor = imagecolorallocate($img, 0, 255, 0);
        $foods = Food::all();
        $imageWidth = imagesx($img);
        $imageHeight = imagesy($img);

        // Mengatur ukuran font berdasarkan resolusi gambar
        $defaultFontSize = 5; // Ukuran font default
        if ($imageWidth > 480 || $imageHeight > 480) {
            $fontSize = $defaultFontSize * 2; // Jika resolusi lebih dari 480p, ukuran font dua kali lipat
        } else {
            $fontSize = $defaultFontSize; // Ukuran font default
        }

        foreach ($boundingBoxes as $box) {
            if ($box['confidence'] >= 0.5) {
                $food = $foods->find($box['class']);
                if ($food) {
                    $foodName = $food->nama;
                    $confidence = number_format($box['confidence'], 2);
                    $displayText = $foodName . ' (' . $confidence . ')';
                    $padding = 5;
                    $textWidth = imagefontwidth($fontSize) * strlen($displayText);
                    $textHeight = imagefontheight($fontSize);
                    for ($i = 0; $i < 3; $i++) {
                        imagerectangle(
                            $img,
                            $box['xmin'] - $i, $box['ymin'] - $i,
                            $box['xmax'] + $i, $box['ymax'] + $i,
                            $color
                        );
                    }
                    imagefilledrectangle(
                        $img,
                        $box['xmin'], $box['ymin'] - $textHeight - $padding,
                        $box['xmin'] + $textWidth + 2 * $padding, $box['ymin'],
                        imagecolorallocate($img, 0, 0, 0)
                    );
                    imagestring(
                        $img,
                        $fontSize,
                        $box['xmin'] + $padding, $box['ymin'] - $textHeight - $padding / 2,
                        $displayText,
                        $textColor
                    );
                }
            }
        }

        if (pathinfo($imagePath, PATHINFO_EXTENSION) == 'jpg' || pathinfo($imagePath, PATHINFO_EXTENSION) == 'jpeg') {
            imagejpeg($img, $imagePath);
        } elseif (pathinfo($imagePath, PATHINFO_EXTENSION) == 'png') {
            imagepng($img, $imagePath);
        }
        imagedestroy($img);

        $uniqueClasses = [];
        foreach ($boundingBoxes as $box) {
            if ($box['confidence'] >= 0.5 && !in_array($box['class'], $uniqueClasses)) {
                $uniqueClasses[] = $box['class'];
            }
        }
        $classArray = array_map(function($class) use ($boundingBoxes, $foods) {
            $confidence = 0;
            foreach ($boundingBoxes as $box) {
                if ($box['class'] == $class && $box['confidence'] > $confidence) {
                    $confidence = $box['confidence'];
                }
            }
            $food = $foods->find($class);
            return [
                'class' => $class,
                'nama' => $food ? $food->nama : 'Unknown',
                'confidence' => $confidence
            ];
        }, $uniqueClasses);

        return view('User.page_2.hasil', compact('uniqueImageName', 'classArray'));
    }

    public function deteksi(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'berat' => 'required|array',
            'berat.*' => 'required|numeric|min:1',
        ]);
        $image = $request->input('image');
        $weights = $request->input('berat');
        $nutritionTotals = [
            'karbohidrat' => 0,
            'energi' => 0,
            'protein' => 0,
            'lemak' => 0,
            'Vit_A' => 0,
            'Vit_B' => 0,
            'Vit_C' => 0,
            'Kalsium' => 0,
            'Zat_Besi' => 0,
            'Zink' => 0,
            'Tembaga' => 0,
            'serat' => 0,
            'fosfor' => 0,
            'air' => 0,
            'natrium' => 0,
            'kalium' => 0,
        ];
        foreach ($weights as $class => $weight) {
            $food = Food::with('nutrition')->find($class);
            if ($food && $food->nutrition->count() > 0) {
                $nutrition = $food->nutrition->first();
                $berat_nutrisi = $nutrition->berat;

                foreach ($nutritionTotals as $key => &$total) {
                    if (isset($nutrition->$key)) {
                        $total += ($weight / $berat_nutrisi) * $nutrition->$key;
                    }
                }
            }
        }
        $result = Result::create([
            'image' => $image,
            'id_user' => Auth::id(),
            'karbohidrat' => $nutritionTotals['karbohidrat'],
            'energi' => $nutritionTotals['energi'],
            'protein' => $nutritionTotals['protein'],
            'lemak' => $nutritionTotals['lemak'],
            'Vit_A' => $nutritionTotals['Vit_A'],
            'Vit_B' => $nutritionTotals['Vit_B'],
            'Vit_C' => $nutritionTotals['Vit_C'],
            'Kalsium' => $nutritionTotals['Kalsium'],
            'Zat_Besi' => $nutritionTotals['Zat_Besi'],
            'Zink' => $nutritionTotals['Zink'],
            'Tembaga' => $nutritionTotals['Tembaga'],
            'serat' => $nutritionTotals['serat'],
            'fosfor' => $nutritionTotals['fosfor'],
            'air' => $nutritionTotals['air'],
            'natrium' => $nutritionTotals['natrium'],
            'kalium' => $nutritionTotals['kalium'],
        ]);
        foreach ($weights as $class => $weight) {
            $food = Food::find($class);
            if ($food) {
                food_result::create([
                    'result_id' => $result->id,
                    'food_id' => $food->id,
                    'weight' => $weight,
                    'created_at' => now()
                ]);
            }
        }
        $foodResults = $result->hasil_makanan()->with('food')->get();
        return view('User.page_2.result', [
            'result' => $result,
            'foodResults' => $foodResults,
            'imageName' => $image,
        ]);
    }
}

