<?php

namespace App\Models;

use App\Enum\PaymentEnum;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'discount_id',
        'amount',
        'ref_id',
        'tracking_code',
        'transaction_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'ref_id', 'ref_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return verta($value);
    // }

    /****************/
    /**** scopes ****/

    public function scopeSucceed($query)
    {
        $query->where("status", PaymentEnum::TRANSACTION_SUCCEED);
    }

    public function scopeInit($query)
    {
        $query->where("status", PaymentEnum::TRANSACTION_INIT);
    }

    public function scopeFailed($query)
    {
        $query->where("status", PaymentEnum::TRANSACTION_FAILED);
    }
}
