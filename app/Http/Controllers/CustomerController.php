<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }

    public function index(Request $request)
    {
        $customers = Customer::when($request->input('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('nik', 'like', '%' . $request->input('search') . '%')
                ->orWhere('address', 'like', '%' . $request->input('search') . '%');
        })
            ->when($request->input('sort'), function ($query) use ($request) {
                $query->orderBy($request->input('sort'), $request->input('direction', 'asc'));
            })
            ->get();
        // ->paginate(10);

        return view('backend.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('backend.customer.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug' => $request->name]);
            $this->customer->create($request->all());
            DB::commit();
            return redirect()->route('customer.index')->with('success', 'Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        return view('backend.customer.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('backend.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug' => $request->name]);
            $this->customer->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('customer.index')->with('success', 'Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (Customer::destroy($id)) {
            return redirect()->route('customer.index')
                ->with('success', 'Customer berhasil dihapus!');
        }

        return redirect()->route('customer.index')
            ->with('error', 'Terjadi kesalahan saat menghapus data.');
    }

    public function getCustomer(Request $request)
    {
        $search = $request->input('search');
        $customers = Customer::where('name', 'like', "%{$search}%")
            ->orWhere('nik', 'like', "%{$search}%")
            ->orWhere('phone_number', 'like', "%{$search}%")
            ->get();

        $results = [];
        foreach ($customers as $customer) {
            $results[] = [
                'id' => $customer->id,
                'name' => $customer->name,
                'nik' => $customer->nik,
                'phone_number' => $customer->phone_number,
            ];
        }

        return response()->json($results);
    }
}
