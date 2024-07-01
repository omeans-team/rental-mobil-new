<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;

    protected $table = 'cars';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','manufacture_id','license_number','color','year','status','price','penalty'];

    public function manufacture()
    {
        return $this->belongsTo('App\Models\Manufacture')->withTrashed();
    }
}
