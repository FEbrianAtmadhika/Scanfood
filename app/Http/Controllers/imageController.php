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
        // Validate the image upload
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Retrieve user ID
        $userId = Auth::guard()->user()->id;

        // Handle the uploaded image
        $imageFile = $request->file('image');

        // Generate a unique name for the image
        $uniqueImageName = str::uuid() . '.' . $imageFile->getClientOriginalExtension();

        // Define the public path to save the image
        $publicPath = public_path('images/' . $userId);

        // Create directory if it doesn't exist
        if (!File::exists($publicPath)) {
            File::makeDirectory($publicPath, 0777, true, true);
        }

        // Move the uploaded image to the public directory with the unique name
        $imageFile->move($publicPath, $uniqueImageName);

        // Define the full path to the image
        $imagePath = $publicPath . '/' . $uniqueImageName;

        // Send the image to the object detection service
        $response = Http::attach(
            'image', file_get_contents($imagePath), $uniqueImageName
        )->post('http://127.0.0.1:5000/pyton_object_detection');

        $boundingBoxes = $response->json();
        $validBoxes = array_filter($boundingBoxes, function($box) {
            return $box['confidence'] >= 0.5;
        });

        if (empty($validBoxes)) {
            // Delete the uploaded image
            File::delete($imagePath);
            return back()->with('error', 'Tidak terdeteksi apapun di gambar.');
        }
        // Create or open image resource
        $img = imagecreatefromjpeg($imagePath);
        if (!$img) {
            $img = imagecreatefrompng($imagePath);
        }
        if (!$img) {
            return back()->with('error', 'Unsupported image format');
        }

        $color = imagecolorallocate($img, 0, 255, 0);
        $textColor = imagecolorallocate($img, 0, 255, 0);

        $foods = Food::all();

        // Draw bounding boxes and labels
        foreach ($boundingBoxes as $box) {
            if ($box['confidence'] >= 0.5) {
                $food = $foods->find($box['class']);
                if ($food) {
                    $foodName = $food->nama;

                    // Define font size and padding
                    $fontSize = 5;
                    $padding = 5;

                    // Calculate text dimensions
                    $textWidth = imagefontwidth($fontSize) * strlen($foodName);
                    $textHeight = imagefontheight($fontSize);

                    // Draw bounding box
                    for ($i = 0; $i < 3; $i++) {
                        imagerectangle(
                            $img,
                            $box['xmin'] - $i, $box['ymin'] - $i,
                            $box['xmax'] + $i, $box['ymax'] + $i,
                            $color
                        );
                    }

                    // Draw background rectangle for text
                    imagefilledrectangle(
                        $img,
                        $box['xmin'], $box['ymin'] - $textHeight - $padding,
                        $box['xmin'] + $textWidth + 2 * $padding, $box['ymin'],
                        imagecolorallocate($img, 0, 0, 0)
                    );

                    // Draw the text above the bounding box
                    imagestring(
                        $img,
                        $fontSize,
                        $box['xmin'] + $padding, $box['ymin'] - $textHeight - $padding / 2,
                        $foodName,
                        $textColor
                    );
                }
            }
        }

        // Save the modified image
        if (pathinfo($imagePath, PATHINFO_EXTENSION) == 'jpg' || pathinfo($imagePath, PATHINFO_EXTENSION) == 'jpeg') {
            imagejpeg($img, $imagePath);
        } elseif (pathinfo($imagePath, PATHINFO_EXTENSION) == 'png') {
            imagepng($img, $imagePath);
        }

        // Clean up
        imagedestroy($img);

        // Extract unique classes
        $uniqueClasses = [];
        foreach ($boundingBoxes as $box) {
            if ($box['confidence'] >= 0.5 && !in_array($box['class'], $uniqueClasses)) {
                $uniqueClasses[] = $box['class'];
            }
        }

        // Pemetaan kelas ke nama makanan
        $classArray = array_map(function($class) use ($boundingBoxes, $foods) {
            // Ambil bounding box dengan confidence lebih dari 0.5 untuk kelas ini
            $confidence = 0;
            foreach ($boundingBoxes as $box) {
                if ($box['class'] == $class && $box['confidence'] > $confidence) {
                    $confidence = $box['confidence'];
                }
            }

            // Mengembalikan nama makanan jika confidence cukup
            $food = $foods->find($class);
            return [
                'class' => $class,
                'nama' => $food ? $food->nama : 'Unknown',
                'confidence' => $confidence
            ];
        }, $uniqueClasses);

        // Return view with image name and class array
        return view('User.page.hasil', compact('uniqueImageName', 'classArray'));
    }

    public function deteksi(Request $request)
    {
        // Validate the input
        $request->validate([
            'image' => 'required|string',
            'berat' => 'required|array',
            'berat.*' => 'required|numeric|min:1',
        ]);

        // Retrieve the validated input data
        $image = $request->input('image');
        $weights = $request->input('berat');

        // Initialize nutritional totals
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

        // Create a new result record
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

        // Create food result records
        foreach ($weights as $class => $weight) {
            $food = Food::find($class);
            if ($food) {
                food_result::create([
                    'result_id' => $result->id,
                    'food_id' => $food->id,
                    'weight' => $weight,
                ]);
            }
        }

        // Retrieve the associated food results for the newly created result
        $foodResults = $result->hasil_makanan()->with('food')->get();

        // Return the view with the result data and associated food results
        return view('User.page.result', [
            'result' => $result,
            'foodResults' => $foodResults,
            'imageName' => $image,
        ]);
    }
}

