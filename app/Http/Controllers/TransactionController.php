<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Car;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
// use PDF;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    private $transaction;
    private $customer;
    private $car;

    public function __construct()
    {
        $this->transaction = new Transaction();
        $this->customer = new Customer();
        $this->car = new Car();
    }

    public function index(Request $request)
    {
        $transactions = Transaction::when($request->input('search'), function ($query) use ($request) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%'. $request->input('search'). '%');
            });
        })
            ->when($request->input('sort'), function ($query) use ($request) {
                $query->orderBy($request->input('sort'), $request->input('direction', 'asc'));
            })
            ->get();

        return view('backend.transaction.index', compact('transactions'));
    }
    public function history(Request $request){
        $transactions = Transaction::when($request->input('search'), function ($query) use ($request) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%'. $request->input('search'). '%');
            });
        })
            ->when($request->input('sort'), function ($query) use ($request) {
                $query->orderBy($request->input('sort'), $request->input('direction', 'asc'));
            })
            ->get();
        return view('backend.transaction.history', compact('transactions'));
    }

    public function create()
    {
        return view('backend.transaction.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->merge(['slug' => Str::slug($request->name)]);
            if ($request->has('customer_id')) {
                $customer_id = $request->customer_id;
            } else {
                $customer = $this->customer->create($request->all());
                $customer_id = $customer->id;
            }

            $car = $this->car->find($request->car_id);
            $data_transaction = [
                'invoice_no' => $this->generateInvoice(date('Y-m-d')),
                'car_id' => $car->id,
                'customer_id' => $customer_id,
                'rent_date' => $request->rent_date,
                'back_date' => $request->back_date,
                'price' => $car->price,
                'amount' => Carbon::parse($request->rent_date)->diffInDays($request->back_date) * $car->price,
                'status' => 'proses',
            ];

            $transaction = $this->transaction->create($data_transaction);
            $car->update(['status' => 'terpakai']);
            DB::commit();
            return redirect()->route('transaction.index')->with('success', 'Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);
        return view('backend.transaction.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::find($id);
        return view('backend.transaction.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->merge(['slug' => Str::slug($request->name)]);
            $this->transaction->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('transaction.index')->with('success', 'Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (Transaction::destroy($id)) {
            return redirect()->route('transaction.index')
                ->with('success', 'Transaction berhasil dihapus!');
        }

        return redirect()->route('transaction.index')
            ->with('error', 'Terjadi kesalahan saat menghapus data.');
    }

    public function print($id)
    {
        $transaction = Transaction::find($id);
        $pdf = PDF::loadView('backend.transaction.cetak', compact('transaction'));
        return $pdf->stream($transaction->invoice_no. '.pdf');
    }

    public function complete(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $transaction->update([
            'return_date' => $request->return_date,
            'status' => 'selesai',
            'penalty' => Carbon::parse($transaction->back_date)->diffInDays($request->return_date) * $transaction->car->penalty,
            'amount' => Carbon::parse($transaction->back_date)->diffInDays($request->return_date) * $transaction->car->penalty + $transaction->amount
        ]);
        $this->car->find($transaction->car_id)->update(['status' => 'tersedia']);
        return redirect()->route('transaction.index')->with('success', 'Data telah disimpan');

    }

    private function generateInvoice($date)
    {
        $tanggal = substr($date, 8, 2);
        $bulan = substr($date, 5, 2);
        $tahun = substr($date, 2, 2);
        $transaction = Transaction::whereDate('created_at', $date)->get();
        $no = 'TRX-'. $tanggal. $bulan. $tahun. '-'. sprintf('%05s', $transaction->count() + 1);
        return $no;
    }

    public function export(Request $request)
    {
        $transaction = new TransactionExport();
        $transaction->setDate($request->from, $request->to);
        return Excel::download($transaction, 'laporan_trx_'. $request->from. '_'. $request->to. '.xlsx');
    }
}
