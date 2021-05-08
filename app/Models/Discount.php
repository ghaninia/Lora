<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        "status",
        "code",
        "number_of_use",
        "description",
        "expired_at",
        'percent',
        'amount'
    ];

    protected $dates = [
        'expired_at'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // public function getExpiredAtAttribute($value)
    // {
    //     return verta($value) ;
    // }

    public function getRouteKeyName()
    {
        return 'code';
    }

    /****************/
    /**** scopes ****/
    public function scopePublished($query)
    {
        return $query->where("status", true);
    }

    public function scopeDisabled($query)
    {
        return $query->where("status", false);
    }
}
