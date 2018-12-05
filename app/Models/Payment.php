<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Larabookir\Gateway\Enum;

class Payment extends Model
{
    protected $fillable = [
        'user_id' ,
        'discount_id' ,
        'amount' ,
        'ref_id' ,
        'tracking_code' ,
        'transaction_id' ,
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class) ;
    }

    public function transaction()
    {
        return $this->hasOne( Transaction::class , 'ref_id' , 'ref_id') ;
    }

    public function discount()
    {
        return $this->belongsTo( Discount::class ) ;
    }

    public function getCreatedAtAttribute($value)
    {
        return verta($value) ;
    }

}
