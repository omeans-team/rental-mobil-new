<?php

namespace App\Http\Controllers;

use App\Models\Manufacture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManufactureController extends Controller
{
    private $manufacture;

    public function __construct()
    {
        $this->manufacture = new Manufacture();
    }

    public function index(Request $request)
    {
        $manufactures = Manufacture::when($request->input('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%'. $request->input('search'). '%');
        })
            ->when($request->input('sort'), function ($query) use ($request) {
                $query->orderBy($request->input('sort'), $request->input('direction', 'asc'));
            })
            ->get();
        // ->paginate(10);

        return view('backend.manufacture.index', compact('manufactures'));
    }

    public function create()
    {
        return view('backend.manufacture.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug' => $request->name]);
            $this->manufacture->create($request->all());
            DB::commit();
            return redirect()->route('manufacture.index')->with('success', 'Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $manufacture = Manufacture::find($id);
        return view('backend.manufacture.show', compact('manufacture'));
    }

    public function edit($id)
    {
        $manufacture = Manufacture::find($id);
        return view('backend.manufacture.edit', compact('manufacture'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug' => $request->name]);
            $this->manufacture->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('manufacture.index')->with('success', 'Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (Manufacture::destroy($id)) {
            return redirect()->route('manufacture.index')
                ->with('success', 'Manufacture berhasil dihapus!');
        }

        return redirect()->route('manufacture.index')
            ->with('error', 'Terjadi kesalahan saat menghapus data.');
    }

    public function getManufacture(Request $request)
    {
        if ($request->has('search')) {
            $cari = $request->search;
            $data = $this->manufacture->where('name', 'LIKE', '%'. $cari. '%')->get();
            return response()->json($data);
        }
    }

    public function find($id)
    {
        return $this->manufacture->find($id);
    }
}
