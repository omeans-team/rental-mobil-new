<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
// use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Transaction;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    private $car;
    private $customer;
    private $transaction;

    public function __construct()
    {
        $this->car = new Car();
        $this->customer = new Customer();
        $this->transaction = new Transaction();
    }

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        // return view('backend.component.login');
        return view('backend.auth.login');
    }

    public function dashboard(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $car = $this->car;
        $customer = $this->customer;
        $transaction  = $this->transaction;
        $transaction_data = [];
        $customer_data = [];


        $customers = Customer::when($request->input('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('nik', 'like', '%' . $request->input('search') . '%')
                ->orWhere('address', 'like', '%' . $request->input('search') . '%');
        })
            ->when($request->input('sort'), function ($query) use ($request) {
                $query->orderBy($request->input('sort'), $request->input('direction', 'asc'));
            })
            ->get();

        for ($i = 1; $i <= 12; $i++) {
            $lul = $this->transaction->whereMonth('created_at', sprintf('%02s', $i))->whereYear('created_at', date('Y'))->get()->count();
            $transaction_data[] = $lul;
        }
        for ($i = 1; $i <= 12; $i++) {
            $lul = $this->customer->whereMonth('created_at', sprintf('%02s', $i))->whereYear('created_at', date('Y'))->get()->count();
            $customer_data[] = $lul;
        }

        $data = [
            'labels' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            'data' =>  $transaction_data,
        ];
        $data_line = [
            'labels' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            'data' =>  $customer_data,
        ];

        return view('backend.dashboard.index', compact(['car', 'customer', 'transaction', 'data','data_line','customers']));
    }
}
