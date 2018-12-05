<?php
namespace App\Models ;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permissions" ;
    public $timestamps = false ;
    protected $fillable = [
    	"name" , 
    	"description",
        "default"
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class) ;
    }
}
