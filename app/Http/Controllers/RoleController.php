<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    private $role;

    public function __construct()
    {
        $this->role = new Role();
    }

    public function index(Request $request)
    {
        $roles = Role::when($request->input('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        })
            ->when($request->input('sort'), function ($query) use ($request) {
                $query->orderBy($request->input('sort'), $request->input('direction', 'asc'));
            })
            ->get();

        return view('backend.role.index', compact('roles'));
    }

    public function create()
    {
        return view('backend.role.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug' => $request->name]);
            $this->role->create($request->all());
            DB::commit();
            return redirect()->route('role.index')->with('success', 'Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $role = Role::find($id);
        return view('backend.role.show', compact('role'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view('backend.role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug' => $request->name]);
            $this->role->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('role.index')->with('success', 'Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (Role::destroy($id)) {
            return redirect()->route('role.index')
                ->with('success', 'Role berhasil dihapus!');
        }

        return redirect()->route('role.index')
            ->with('error', 'Terjadi kesalahan saat menghapus data.');
    }
}
