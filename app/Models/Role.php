<?php
namespace App\Models ;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles" ;
    public $timestamps = false ;
    protected $fillable = [
    	"name" ,
    	"description" ,
        'picture' ,
        "default"
    ];

    protected $casts = [
        'picture' => 'json'
    ];

    public function users()
    {
        return $this->hasMany(User::class , "role_id" , "id") ;
    }

    public function permissions()
    {
        return $this->belongsToMany( Permission::class) ;
    }

    // event before delete role
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($query){
            $query->permissions()->detach() ;
        });
    }

}
