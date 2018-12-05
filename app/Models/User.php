<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "users" ;

    protected $fillable = [
        'firstname' ,
        'lastname' ,
        'picture' ,
		'username', 
		'email',
        'mobile' ,
		'password',
		'role_id' ,
        'gender' ,
        'theme' ,
        'status',
        'credit'
    ];

    protected $casts = [
        "picture" => "array"
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class) ;
    }

    public function scopeStatus($q , $value = true )
    {
        return $q->whereStatus($value) ;
    }

    public function role()
    {
        return $this->belongsTo(Role::class) ;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token , $this->email ));
    }

    public function access($items , $typo = "OR")
    {
        $typo = trim(strtolower($typo)) ;
        $role = $this->role ;
        if (!is_null($role))
        {
            $permissions = $role->permissions()->pluck("name")->toArray() ;
            if (is_array($permissions) && !empty($permissions))
            {
                if (is_string($items))
                {
                    return in_array($items , $permissions) ;
                }
                elseif ( (is_array($items) || is_object($items)) && $typo == "or")
                {
                    // yeni agar yeki doorost bod true ra bargdon
                    foreach ($items as $item){
                        if (in_array($item , $permissions))
                            return true ;
                    }
                }
                elseif ( (is_array($items) || is_object($items)) && $typo == "and"){
                    if( is_object($items) ) $items = $items->toArray() ;
                    $result =  array_diff($items , $permissions) ;
                    if(empty($result))
                        return true ;
                }
            }
        }
        return false ;
    }

    public function getRouteKeyName()
    {
        return 'username' ;
    }

    public function getCreatedAtAttribute($value)
    {
        if(!! $value )
            return verta($value) ;
        return null ;
    }

    public function getFullNameAttribute()
    {
        $fullname =  sprintf("%s %s" , $this->attributes['firstname'] , $this->attributes['lastname'])  ;
        if(!! trim($fullname))
            return $fullname ;
        return $this->attributes['username'] ;
    }
}