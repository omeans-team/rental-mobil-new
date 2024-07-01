@extends('backend.print')
{{-- @section('title',$transaction->invoice_no) --}}
@section('contents')
<div class="header">
    <table class="table table-borderless">
        <tbody>
            <tr>
                <td>
                    {{App\Models\Setting::where('slug','nama-toko')->get()->first()->description}}
                    <br>
                    {{App\Models\Setting::where('slug','alamat')->get()->first()->description}}
                    <br>
                    {{App\Models\Setting::where('slug','nomer-telepon')->get()->first()->description}} -
                    {{App\Models\Setting::where('slug','email')->get()->first()->description}}
                    <br>

                </td>
                <td style="text-align:left;">
                    Invoice &nbsp;: {{$transaction->invoice_no}}
                    <br>
                    Tanggal : {{Carbon\Carbon::parse($transaction->return_date)->format('d-m-Y')}}
                    <br>
                    Kepada &nbsp;: {{Str::title($transaction->customer->name)}}

                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="main">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Mobil</th>
                <th>Tanggal Sewa</th>
                <th>Tanggal kembali</th>
                <th>Tanggal kembalikan</th>
                <th>Harga Sewa</th>
                <th>Denda</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{$transaction->car->name}}</td>
                <td>{{Carbon\Carbon::parse($transaction->rent_date)->format('d-m-Y')}}</td>
                <td>{{Carbon\Carbon::parse($transaction->back_date)->format('d-m-Y')}}</td>
                <td>{{Carbon\Carbon::parse($transaction->return_date)->format('d-m-Y')}}</td>
                <td>{{number_format($transaction->price,0,',','.')}}</td>
                <td>{{number_format($transaction->penalty,0,',','.')}}</td>
                <td>{{number_format($transaction->amount,0,',','.')}}</td>
            </tr>
            <tr>
                <td colspan="7">
                    <strong>
                        Grand Total
                    </strong>
                </td>
                <td>
                    <strong>
                        {{number_format($transaction->amount,0,',','.')}}
                    </strong>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="footer">
    <em>
        Terimakasi Atas Kunjungannya
    </em>
</div>
@endsection



