<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    private $setting;

    public function __construct()
    {
        $this->setting = new Setting();
    }

    public function index(Request $request)
    {
        $data = $this->setting->get();
        return view('backend.setting.index', compact(['data']));
    }


    public function change(Request $request)
    {
        $id = $request->id;
        $ids = $request->id;
        $edit_file = $request->edit_file;
        $files = $request->file('description');
        $input = $request->input('description');
        $url = '';

        $settingIds = [];
        $slug = [];

        foreach ($ids as $i => $settingId) {
            $setting = $this->setting->find($settingId);
            $slug[] = $setting->slug;
            $settingIds[] = $settingId;
        }

        if (isset($files)) {
            $file = $files[0];
            $fileName = Str::uuid();
            $url = 'storage/image/setting/' . $fileName . '.' . $file->extension();
            $file->storeAs(
                'public/image/setting',
                $fileName . '.' . $file->extension()
            );
        }
        foreach ($id as $i => $settingId) {
            $setting = $this->setting->find($settingId);

            if ($setting->slug === 'logo-depan') {
                $settingsaa = $this->setting->find($settingId);
                if ($url === '' && $edit_file === $settingsaa->description) {
                } else {
                    $this->setting->find($settingId)->update([
                        'description' => $url
                    ]);
                }
            } else {
                $key = $settingId - 1;
                $this->setting->find($settingId)->update([
                    'description' => $input[$key]
                ]);
            }
        }
        return redirect()->back()->with('success', 'Data Berhasil Dirubah');
    }


    public function create()
    {
        return view('backend.setting.create');
    }

    public function store(Request $request)
    {
        if ($this->setting->where('slug', Str::slug($request->name))->exists()) {
            return redirect()->route('setting.index')->with('error', 'Gagal Menyimpan. Data ' . $request->name . ' sudah ada, edit data yang ada');
        } else {
            $this->setting->create($request->all());
            return redirect()->route('setting.index')->with('success', 'Data telah disimpan');
        }
    }

    public function show($id)
    {
        $setting = Setting::find($id);
        return view('backend.setting.show', compact('setting'));
    }

    public function edit($id)
    {
        $setting = Setting::find($id);
        return view('backend.setting.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $name = $this->setting->find($id)->name;
        if ($this->setting->where('name', $request->name)->exists()) {
            if ($request->name == $name) {
                $this->setting->find($id)->update($request->all());
                return redirect()->route('setting.index')->with('success', 'Data telah dirubah');
            } else {
                return redirect()->route('setting.index')->with('error', 'Gagal Merubah. Data ' . $request->name . ' sudah ada, edit data yang ada');
            }
        } else {
            $this->setting->find($id)->update($request->all());
            return redirect()->route('setting.index')->with('success', 'Data telah dirubah');
        }
    }

    public function destroy($id)
    {
        if (Setting::destroy($id)) {
            return redirect()->route('setting.index')
                ->with('success', 'Setting berhasil dihapus!');
        }

        return redirect()->route('setting.index')
            ->with('error', 'Terjadi kesalahan saat menghapus data.');
    }

    public function getSetting(Request $request)
    {
        if ($request->has('search')) {
            $cari = $request->search;
            $data = $this->setting->where('name', 'LIKE', '%' . $cari . '%')->get();
            return response()->json($data);
        }
    }
}
