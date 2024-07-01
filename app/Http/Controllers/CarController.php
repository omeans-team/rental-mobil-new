<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\CarImage;
use Illuminate\Support\Str;

class CarController extends Controller
{
    private $car;
    private $image;

    public function __construct()
    {
        $this->car = new Car();
        $this->image = new CarImage();
    }

    public function index(Request $request)
    {
        $cars = Car::when($request->input('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        })
            ->when($request->input('sort'), function ($query) use ($request) {
                $query->orderBy($request->input('sort'), $request->input('direction', 'asc'));
            })
            ->get();
        // ->paginate(10);

        return view('backend.car.index', compact('cars'));
    }

    public function create()
    {
        return view('backend.car.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug' => Str::slug($request->name), 'status' => 'tersedia']);
            $car = $this->car->create($request->all());
            foreach ($request->image as $row) {
                $fileName = Str::uuid();
                $file = $row->storeAs(
                    'public/image/car', $fileName . '.' . $row->extension()
                );
                $this->image->create([
                    'car_id' => $car->id,
                    'image' => 'storage/image/car/' . $fileName . '.' . $row->extension()
                ]);
            }
            DB::commit();
            return redirect()->route('car.index')->with('success', 'Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $car = Car::with('manufacture')->find($id);
        return response()->json($car);
    }

    public function edit($id)
    {
        $car = Car::find($id);
        return view('backend.car.edit', compact('car'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug' => Str::slug($request->name)]);
            if ($request->has('image')) {
                foreach ($request->image as $row) {
                    $fileName = Str::uuid();
                    $file = $row->storeAs(
                        'public/image/car', $fileName . '.' . $row->extension()
                    );
                    $this->image->create([
                        'car_id' => $id,
                        'image' => 'storage/image/car/' . $fileName . '.' . $row->extension()
                    ]);
                }
            }
            $this->car->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('car.index')->with('success', 'Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (Car::destroy($id)) {
            return redirect()->route('car.index')
                ->with('success', 'Car berhasil dihapus!');
        }

        return redirect()->route('car.index')
            ->with('error', 'Terjadi kesalahan saat menghapus data.');
    }

    public function getImage($id)
    {
        return $this->image->where('car_id', $id)->get();
    }

    public function destroyImage($id)
    {
        $this->image->destroy($id);
    }
}
