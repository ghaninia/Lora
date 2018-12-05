<?php

namespace App\Models;
use Larabookir\Gateway\Enum;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        "status" ,
        "code" ,
        "number_of_use" ,
        "description" ,
        "expired_at" ,
        'percent' ,
        'amount'
    ] ;

    protected $dates = [
        'expired_at'
    ] ;

    public function scopeStatus($query , $status = true)
    {
        return $query->where( 'status' , $status );
    }

    public function payments()
    {
        return $this->hasMany(Payment::class) ;
    }

    public function getExpiredAtAttribute($value)
    {
        return verta($value) ;
    }

    public static function canUsage()
    {
        return self::select("*")
            ->status(true)
            ->withCount(['payments' => function($Query){
                $Query->whereStatus(Enum::TRANSACTION_SUCCEED) ;
            }])
            ->groupBy('id')
            ->havingRaw( "payments_count < number_of_use" ) ;
    }

    public function getRouteKeyName()
    {
        return 'code' ;
    }
}
