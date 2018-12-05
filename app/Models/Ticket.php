<?php
namespace App\Models ;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{

    protected $fillable = [
        'tracking_code' ,
        'status' ,
        'seen' ,
        'priority' ,
        'from_type' ,
        'from_id' ,
        'to_type' ,
        'to_id' ,
        'subject' ,
        'message'
    ];

    public function getTrackingCodeAttribute($value)
    {
        return $this->attributes['tracking_code'] = $value ;
    }

    public function getDifferenceAtAttribute()
    {
        return $this->created_at->formatDifference();
    }

    public function getCreatedAtAttribute($value)
    {
        return verta($value) ;
    }

    //*  تمام تیکت های ورودی کاربر *//
    // @Guard = گادر تیکت میتواند  , user باشد .
    public static function inbox($guard)
    {
        $user = Auth::guard($guard)->user() ;
        $role    = $user->role ;
        return Ticket::where(function ($query) use ($role , $user , $guard ){
            $query->where([
                'from_type'=> $guard  ,
                'from_id'=>$user->id
            ])->when($role,function ($q,$role){
                $q->orWhere([ 'from_type'=>'role' , 'from_id'=> $role->id ]) ;
            }) ;
        })->orWhere(function ($query) use ($role , $user , $guard){
            $query->where([
                'to_type'=> $guard ,
                'to_id'=>$user->id
            ])->when($role,function ($q,$role){
                $q->orWhere([ 'to_type' => 'role' , 'to_id'=> $role->id ]) ;
            }) ;
        })->get();
    }

    public static function access($guard = 'user')
    {
        return self::inbox($guard)->pluck('id') ;
    }

    public static function side($guard = 'user')
    {
        return static::inbox($guard)->groupBy('tracking_code')->map(function ($q){
            return $q->first();
        })->sortByDesc('created_at');
    }

    public static function content($trackingCode , $guard = 'user')
    {
        return self::inbox($guard)->where("tracking_code" , $trackingCode )->groupBy(function ($collection){
            return $collection->created_at->format("Y-m-d") ;
        });
    }

    public static function haveMe($ticket , $guard = 'user')
    {
        $user = Auth::guard($guard)->user() ;
        if (!! $ticket && !! $user )
            if (
                (
                    //* اگر فرستنده آیدی من و گارد من بود *//
                    ($ticket->from_id == $user->id ) && ($ticket->from_type == $guard)
                )
                OR
                (
                    //* اگر فرستنده نقش من بود و فرستنده هم من بودم *//
                    ($ticket->from_id == $user->role->id ) &&
                    ($ticket->from_type == "role" ) &&
                    ($ticket->from_type == $guard ) &&
                    ($ticket->from_id ==  $user->id  )
                )
                OR(
                    //* اگر فرستنده رول من بود . *//
                    ($ticket->from_id == $user->role->id ) &&
                    ($ticket->from_type == "role" )
                )
            ){
                return true  ;
            }else {
                //* در صورتی که اصلا پیام من نبود پس خب من میتونم این رو seen کنم *//
                //* اگر قبلا seen نشده بود پس seen میکنم *//
                if ( ! $ticket->seen)
                    $ticket->update([ 'seen' => true ]);
            }
        return false ;
    }


    public static function GetItem($model , $id)
    {
        $obj =  "\\App\\Models\\".ucfirst($model) ;
        $obj = new $obj ;
        $obj = $obj->find($id) ;
        return $obj ;
    }

    public static function information($model , $id)
    {

        $item = static::GetItem($model , $id) ;
        if (!!$item)
        {
            if( in_array( $model , ['user'] ) )
            {

                return [
                    'picture' => ( $model == 'user' ? avatar($item) : cpfile($item->picture) ) ,
                    'data' => [
                        'username' => $item->username ,
                        'name'     => $item->fullname ,
                        'mobile'   => $item->mobile ,
                        'email'    => $item->email ,
                    ]
                ] ;

            }
            elseif ($model == 'role')
            {

                return [
                    'picture' => picture($item) ,
                    'data' => [
                        'name' => $item->name ,
                        'desc' => $item->description
                    ]
                ];

            }
        }

        return [
            'picture' => config('dash.perview') ,
            'data' => [
                'name' => 'Deleted account'
            ]
        ] ;
    }

    public static function trackingCodeAccess($guard)
    {
        return Ticket::whereIn('id' , Ticket::access($guard) )
                    ->select('tracking_code')
                    ->distinct('tracking_code')
                    ->pluck('tracking_code')
                    ->toArray();
    }


    public function ScopeNotRead( $query , $guard = 'user')
    {
        $user = Auth::guard($guard)->user() ;
        $ticketNotIn = Ticket::where("from_id" , $user->id)->where('from_type' , $guard)->where('seen',false)->pluck('id')->toArray() ;

        return $query->where("seen" , false )
            ->where(function ($q) use ($user , $guard , $ticketNotIn) {
                $q->where(['to_type' => $guard , 'to_id' => $user->id ])
                    ->orWhere(function ($q) use ($user , $guard , $ticketNotIn) {
                        $q
                            ->where([
                                'to_type' => 'role' ,
                                'to_id'   => $user->role->id
                            ])
                            ->whereNotIn('id' , $ticketNotIn );
                    }) ;
            });
    }

}
