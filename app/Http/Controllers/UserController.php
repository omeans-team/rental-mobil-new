<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $user; // Add this line
    private $role; // Add this line


    public function __construct()
    {
        $this->user = new User();
        $this->role = new Role();
    }

    public function index(Request $request)
    {
        $users = User::when($request->input('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        })
            ->when($request->input('sort'), function ($query) use ($request) {
                $query->orderBy($request->input('sort'), $request->input('direction', 'asc'));
            })
            ->get();
        // ->paginate(10);

        return view('backend.user.index', compact('users'));
    }

    public function create()
    {
        $role = $this->role;
        return view('backend.user.create', compact('role'));
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['password' => Hash::make($request->password)]);
            $user = $this->user->create($request->all());
            DB::commit();
            return redirect()->route('user.index')->with('success', 'Data telah disimpan');
        } catch (\Exception $e) {
            dd($e);
            die;
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('backend.user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $role = $this->role;
        return view('backend.user.edit', compact('user', 'role'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['password' => Hash::make($request->password)]);
            $this->user->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('user.index', $request->menu_id)->with('success', 'Data telah dirubah');
        } catch (\Exception $e) {
            dd($e);
            die;
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (User::destroy($id)) {
            return redirect()->route('user.index')
                ->with('success', 'User berhasil dihapus!');
        }

        return redirect()->route('user.index')
            ->with('error', 'Terjadi kesalahan saat menghapus data.');
    }

    public function change()
    {
        return view('backend.user.change');
    }

    public function updatePassword(Request $request)
    {
        $currentPassword = Auth::user()->password;
        if (!Hash::check($request->old_password, $currentPassword)) {
            return redirect()->back()->with("error", "Maaf password lama tidak cocok dengan password yang tersimpan di database");
        } elseif ($request->new_password != $request->confirm_password) {
            return redirect()->back()->with("error", "Maaf konfirmasi password salah");
        } else {
            $user = User::find(Auth::id()); // Get the User model instance
            $user->password = bcrypt($request->new_password);
            $user->save(); // Call save on the User model instance
            return redirect()->back()->with("success", "Password Berhasil Diganti");
        }
    }
}
