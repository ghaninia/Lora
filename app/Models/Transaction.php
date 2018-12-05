<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions" ;


    public function log()
    {
        return $this->hasOne( TransactionLog::class );
    }
}
