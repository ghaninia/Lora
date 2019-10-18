<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillables = [
        "key" ,
        "value" ,
        "default"
    ] ;

    public $timestamps = false;

    public static function get($key , $default = null ){
        $option  = self::where("key" , $key)->first() ;
        if( !! $option )
            return $option->value ?? ( $default ?? $option->default ) ;

        return false ;
    }


    public static function set($key , $value)
    {
        return Option::where("key" , $key)->update([
            "value" => is_array($value) ? json_encode($value): $value
        ]) > 0 ? true : false  ;
    }
}
