<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transactions';
    protected $dates = ['deleted_at'];
    protected $fillable = ['car_id','customer_id','invoice_no','rent_date','back_date','return_date','price','amount','penalty','status'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
        // return $this->belongsTo('App\Models\Customer')->withTrashed();
    }

    public function car()
    {
        return $this->belongsTo('App\Models\Car');
        // return $this->belongsTo('App\Models\Car')->withTrashed();
    }
}
