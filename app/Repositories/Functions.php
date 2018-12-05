<?php
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\Picture;
/**************/
/*** avatar ***/
/**************/
function avatar($user = null , $size = "thumb" , $guard = "user" )
{
    if(is_null($user)){
        $user = auth()->guard($guard)->user() ;
        if(empty($user->picture)){
            return ($user->gender == 'male' ? asset(config('dash.male_pic_default')) : asset(config('dash.female_pic_default')) ) ;
        }else{
            return Picture::get( $user->picture , $size) ;
        }
    }
    else
    {
        if (!! $user){
            if(empty($user->picture)){
                return ($user->gender == 'male' ? asset(config('dash.male_pic_default')) : asset(config('dash.female_pic_default')) ) ;
            }else{
                return Picture::get( $user->picture , $size) ;
            }
        }
    }
    return ;
}
/****************/
/*** username ***/
/****************/
function username($user = null, $guard = "user" )
{
    if(is_null($user)){
        return auth()->guard($guard)->user()->username ;
    }else{
        return $user->username ;
    }
}
/**************/
/*** theme ***/
/**************/
function theme($default = 'blue'){
    if (auth()->check())
        return auth()->user()->theme ;
    return $default ;
}
/**********************/
/*** redirect back with response success***/
/*********************/
function RepMessage( $string , $status = true , $routeName = null )
{
    $request = request() ;
    $message["status"] = $status ;
    $message['message'] = $string ;

    if(!! $routeName)
        $message['url'] = route($routeName) ;

    if ($request->ajax())
        return response()->json($message) ;

    if(is_null($routeName))
        return back()->with($message) ;

    return redirect()->route($routeName)->with($message) ;
}
/*********************************/
/*** hightlight with routename ***/
/*********************************/
function Hightlight( $routeName , $createClass = true , $activeCode = "active" )
{
    if(is_null($activeCode))
        $activeCode = "navigation__active" ;

    if(is_string($routeName))
    {
        if( \Route::currentRouteName() == $routeName ){
            if( $createClass == true ){
                return " class={$activeCode} " ;
            }else{
                return " {$activeCode} " ;
            }
        }
    }
    if(is_array($routeName))
    {
        if( in_array( \Route::currentRouteName() , $routeName ) )
        {
            if( $createClass == true ){
                return " class={$activeCode}" ;
            }else{
                return " {$activeCode} " ;
            }
        }
    }
    return null ;
}
/********************************/
/*** return CreateTime format ***/
/********************************/
function CreateTime($item , $create_column = "created_at"){
    return $item->$create_column->format(config("dash.format_date"));
}
/*****************************/
/*** sort table dashboard  ***/
/*****************************/
function comperGet($get , $value){
    if( Request::has([$get]) ){
        return Request::input($get) === $value ;
    }
    return false ;
}
function setGet($arrs){
    $result = [] ;
    if(count($arrs) > 0 && is_array($arrs) ){
        foreach ($arrs as $arr ){
            $result[] = Request::has([$arr]) ;
        }
        return !in_array( FALSE , $result ) ;
    }
    return false ;
}
function SortBy($name , $justLink = false ){
    $requests = Request::except(["order" , "orderBy"]) ;
    if (count($requests) > 0) {
        $appends = http_build_query($requests)."&" ;
    }else{
        $appends = null ;
    }
    if(setGet(["orderBy" , "order" ])){
        if (comperGet("orderBy",$name)){
            if (comperGet("order","asc")) {
                if($justLink)
                    return sprintf("?%sorderBy=%s&order=desc" , $appends , $name ) ;
                printf('<a href = "?%sorderBy=%s&order=desc" class="icon-material-outline-arrow-drop-up">
                        </a >' , $appends , $name) ;
            }else{
                if($justLink)
                    return sprintf("?%sorderBy=%s&order=asc" , $appends , $name ) ;
                printf('<a href="?%sorderBy=%s&order=asc" class="icon-material-outline-arrow-drop-down">
                        </a>',$appends , $name) ;
            }
        }else{
            if($justLink)
                return sprintf("?%sorderBy=%s&order=asc" , $appends , $name ) ;
            printf('<a href="?%sorderBy=%s&order=asc"  class="icon-material-outline-arrow-drop-up">
                    </a>',$appends , $name) ;
        }
    }else{
        if($justLink)
            return sprintf("?%sorderBy=%s&order=asc" , $appends , $name ) ;
        printf('<a href="?%sorderBy=%s&order=asc" class="icon-material-outline-arrow-drop-up">
                </a>' , $appends ,$name );
    }
}


/*****************************/
/*** dashboard headerQuery ***/
/*****************************/
function QueryBuilderHeader($name , $val = false ){
    $httpQuery = request()->except($name) ;
    $httpQuery[$name] = $val ;
    return  "?".http_build_query($httpQuery) ;
}
/*******************/
/*** time search ***/
/*******************/
function PeriodDate($justKey = true , $createColumn = 'created_at' ){
    $dates =  [
        'all' => [] ,
        'today' => [
            [ $createColumn , ">=" , today() ] ,
        ] ,
        'yesterday' => [
            [ $createColumn , "<" , today() ] ,
            [ $createColumn , ">=" , today()->subDay(1) ]
        ],
        '1week' => [
            [ $createColumn , ">=" , today()->subWeek(1)]
        ],
        '2week' => [
            [ $createColumn , "<=" , today()->subWeek(1) ] ,
            [ $createColumn , ">=" , today()->subWeek(2) ]
        ],
        '3week' => [
            [ $createColumn , "<=" , today()->subWeek(2) ] ,
            [ $createColumn , ">=" , today()->subWeek(3) ]
        ],
        '1month' => [
            [ $createColumn , "<=" , today() ] ,
            [ $createColumn , ">=" , today()->subMonth(1) ]
        ],
        '2month' => [
            [ $createColumn , "<=" , today()->subMonth(1) ] ,
            [ $createColumn , ">=" , today()->subMonth(2) ]
        ],
        '3month' => [
            [ $createColumn , "<=" , today()->subMonth(2) ] ,
            [ $createColumn , ">=" , today()->subMonth(3) ]
        ],
        '6month' => [
            [ $createColumn , "<=" , today()->subMonth(5) ] ,
            [ $createColumn , ">=" , today()->subMonth(6) ]
        ],
        '1year' => [
            [ $createColumn , ">=" , today()->subYear(1) ]
        ],
    ];
    if ($justKey){
        return array_keys($dates) ;
    }else{
        if (request()->has('period_time'))
        {
            if(array_key_exists( request()->input('period_time') , $dates ))
            {
                return $dates[ request()->input('period_time') ] ;
            }
        }
        return [] ;
    }
}
/*************/
/*** order ***/
/*************/
function orders(){
    return [
        'desc' ,
        'asc'
    ] ;
}
/***************/
/*** picture ***/
/***************/
function picture($item , $size = 'thumb')
{
    if (isset($item->picture))
    {
        return Picture::get( $item->picture , $size) ;
    }
    return asset(config('dash.perview'));
}
/*****************/
/*** str slice ***/
/*****************/
function str_slice($text , $length){
    if( mb_strlen($text)  > $length ){
        return mb_substr($text,0,$length) . " ... "  ;
    }else{
        return $text ;
    }
}

/*******************/
/*** create slug ***/
/*******************/
function slug($name){
    $lettersNumbersSpacesHyphens = '/[^\-\s\pN\pL]+/u';
    $spacesDuplicateHypens = '/[\-\s]+/';
    $slug = preg_replace($lettersNumbersSpacesHyphens, null , $name );
    $slug = preg_replace($spacesDuplicateHypens, '-', $slug);
    $slug = trim($slug, '+');
    if($slug[strlen($slug)-1] == "-"){
        $slug = substr($slug , 0 , strlen($slug)-1) ;
    }
    return $slug ;
}

/***************/
/*** authTag ***/
/***************/
function authTag(){
    $user = request()->user("users")->load("role.tags") ;
    $tags = $user->role->tags->pluck('id')->toArray() ;
    return $tags ;
}
/**************/
/*** gender ***/
/**************/
function genders()
{
    return ['male','female'] ;
}
/****************/
/*** currency ***/
/****************/
function currency ($currency , $numberFormat = false )
{
    //*  قیمت دیفالت سیستم  *//
    $format = strtolower( config('dash.currency') ) ;

    if ( $format == 'rial' )
        return [
            'currency' => $numberFormat ?  number_format($currency) : $currency  ,
            'type' => trans('dash.currency.rial')
        ] ;
    elseif ($format == 'toman')
        return [
            'currency' => $numberFormat ?  number_format( round($currency / 10 , 2) ) : round($currency / 10 , 2) ,
            'type' => trans('dash.currency.toman')
        ];
    elseif ($format == 'thousandtoman')
        return [
            'currency' => $numberFormat ?  number_format( round($currency / 10000 , 2) ) : round($currency / 10000 , 2),
            'type' => trans('dash.currency.thousandtoman')
        ];
    elseif ($format == 'thousandrial')
        return [
            'currency' => $numberFormat ? number_format( round($currency / 1000 , 2) ) :round($currency / 1000 , 2),
            'type' => trans('dash.currency.thousandrial')
        ];

}

function changeCurrency($currency , $changeTo = 'rial')
{
    $format = strtolower( config('dash.currency') ) ;
    $changing   =
    [
        //*  *//
        'rial' => [
            'rial'   => 1 ,
            'toman'  => .1 ,
            'thousandtoman' => .0001 ,
            'thousandrial'  => .001 ,
        ],

        'toman' => [
            'rial'   => 10 ,
            'toman'  => 1 ,
            'thousandtoman' => .001 ,
            'thousandrial'  => .01 ,
        ],

        'thousandtoman' => [
            'rial'   => 10000 ,
            'toman'  => 1000 ,
            'thousandtoman' => 1 ,
            'thousandrial'  => 10 ,
        ],

        'thousandrial' => [
            'rial'   => 1000 ,
            'toman'  => 100 ,
            'thousandtoman' => .1 ,
            'thousandrial'  => 1 ,
        ],
    ];

    return $changing[$format][$changeTo] * $currency ;
}


function stepCurrency(){
    switch ( config('dash.currency') )
    {
        case "rial"  :
            $step = 10000 ;
            break ;
        case "toman"  :
            $step = 1000 ;
            break ;
        case "thousandtoman"  :
            $step = 1 ;
            break ;
        case "thousandrial"  :
            $step = 10 ;
            break ;
    }

    return $step ;
}

function me()
{
    $guards = config("auth.guards") ;
    $currentGuard = null ;
    foreach ($guards as $guard => $value )
        if  ( \Auth::guard($guard)->check() )
            $currentGuard = $guard ;

    return \Auth::guard($currentGuard)->user() ;
}

function statusTransaction($status)
{
    switch ($status)
    {
        case "SUCCEED" :
            return trans('dash.status.succeed') ;
        case "FAILED" :
            return trans('dash.status.failed') ;
        case "INIT" :
            return trans('dash.status.init') ;
    }
}
