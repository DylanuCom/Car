<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

use Illuminate\Support\Facades\File;



class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        return view('cars.create');
    }


    public function store(Request $request)
    {
        // التحقق من البيانات المدخلة
        $validatedData = $request->validate([
            'images.*' => 'required|image|max:2048',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'specifications.*.name' => 'nullable|string|max:255',
            'specifications.*.description' => 'nullable|string|max:255',
            'specifications.*.icon' => 'nullable|string|max:255',
        ]);

        // إنشاء سيارة جديدة
        $car = new Car;
        $car->title = $request->title;
        $car->price = $request->price;
        $car->video = $request->video;

        // تحويل المواصفات إلى JSON وحفظها
        $car->specifications = json_encode($request->specifications);

        $car->save();

        // نقل كل صورة إلى مجلد في الفولدر الرئيسي للتطبيق وتخزين المسارات في قاعدة البيانات
        $imagePaths = [];
        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension(); // إعادة تسمية الصورة مع الاحتفاظ بالامتداد
            $image->move(public_path('upload/cars'), $imageName); // رفع الصورة إلى المجلد المحدد
            $imagePath = 'upload/cars/' . $imageName; // تخزين المسار النسبي للصورة في قاعدة البيانات
            $imagePaths[] = $imagePath;
        }
        $car->images = $imagePaths; // تعيين المسارات كقيمة لحقل 'images' في النموذج
        $car->save();

        return redirect()->route('cars.index')->with('success', 'Car added successfully');
    }





    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }


    public function edit($id)
    {
        $car = Car::findOrFail($id);


       // dd($car);
        return view('cars.edit', compact('car'));
    }




    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'specifications.*.name' => 'nullable|string|max:255',
            'specifications.*.description' => 'nullable|string|max:255',
            'specifications.*.icon' => 'nullable|string|max:255',
        ]);

        $car = Car::findOrFail($id);
        $car->title = $request->title;
        $car->price = $request->price;
        $car->video = $request->video;

        // Convert the specifications array to JSON before saving
        $car->specifications = json_encode($request->specifications);

        $car->save();

        return redirect()->route('cars.index')->with('success', 'Car updated successfully');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        // Delete car images
        if (!empty($car->images)) {
            foreach ($car->images as $image) {
                $imagePath = public_path($image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath); // Delete image from public folder
                }
            }
        }

        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Car deleted successfully');
    }

}
