<?php

use App\Classes\Picture;
use App\Services\Auth\AuthService;
use App\Services\Option\OptionService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

function authunticate()
{
    return app(AuthService::class);
}

function maleDefaultPicture()
{
    return asset(config('lora.default_male'));
}

function femaleDefaultPicture()
{
    return asset(config('lora.default_female'));
}

function sidebarClassName(?array $routeName, bool $createClassAttr = true, string $activeCode = "active")
{
    $currentRouteName = Route::currentRouteName();

    $activeCode = $activeCode ?? "navigation__active";

    if (
        is_string($routeName) ?
        $routeName === $currentRouteName :
        in_array($currentRouteName, $routeName)
    ) {
        return sprintf(" %s ", $createClassAttr ? "class={$activeCode}" : $activeCode);
    }

}


function RepMessage($string, $status = true, $routeName = null)
{
    $request = request();
    $message["status"] = $status;
    $message['message'] = $string;

    if (!!$routeName)
        $message['url'] = route($routeName);

    if ($request->ajax())
        return response()->json($message);

    if (is_null($routeName))
        return back()->with($message);

    return redirect()->route($routeName)->with($message);
}

/********************************/
/*** return CreateTime format ***/
/********************************/
function CreateTime($item, $create_column = "created_at")
{
    return $item->$create_column->format(config("lora.format_date"));
}
/*****************************/
/*** sort table dashboard  ***/
/*****************************/
function comperGet($get, $value)
{
    if (Request::has([$get])) {
        return Request::input($get) === $value;
    }
    return false;
}
function setGet($arrs)
{
    $result = [];
    if (count($arrs) > 0 && is_array($arrs)) {
        foreach ($arrs as $arr) {
            $result[] = Request::has([$arr]);
        }
        return !in_array(FALSE, $result);
    }
    return false;
}
function SortBy($name, $justLink = false)
{
    $requests = Request::except(["order", "orderBy"]);
    if (count($requests) > 0) {
        $appends = http_build_query($requests) . "&";
    } else {
        $appends = null;
    }
    if (setGet(["orderBy", "order"])) {
        if (comperGet("orderBy", $name)) {
            if (comperGet("order", "asc")) {
                if ($justLink)
                    return sprintf("?%sorderBy=%s&order=desc", $appends, $name);
                printf('<a href = "?%sorderBy=%s&order=desc" class="icon-material-outline-arrow-drop-up">
                        </a >', $appends, $name);
            } else {
                if ($justLink)
                    return sprintf("?%sorderBy=%s&order=asc", $appends, $name);
                printf('<a href="?%sorderBy=%s&order=asc" class="icon-material-outline-arrow-drop-down">
                        </a>', $appends, $name);
            }
        } else {
            if ($justLink)
                return sprintf("?%sorderBy=%s&order=asc", $appends, $name);
            printf('<a href="?%sorderBy=%s&order=asc"  class="icon-material-outline-arrow-drop-up">
                    </a>', $appends, $name);
        }
    } else {
        if ($justLink)
            return sprintf("?%sorderBy=%s&order=asc", $appends, $name);
        printf('<a href="?%sorderBy=%s&order=asc" class="icon-material-outline-arrow-drop-up">
                </a>', $appends, $name);
    }
}


/*****************************/
/*** dashboard headerQuery ***/
/*****************************/
function QueryBuilderHeader($name, $val = false)
{
    $httpQuery = request()->except($name);
    $httpQuery[$name] = $val;
    return  "?" . http_build_query($httpQuery);
}
/*******************/
/*** time search ***/
/*******************/
function PeriodDate($justKey = true, $createColumn = 'created_at')
{
    $dates =  [
        'all' => [],
        'today' => [
            [$createColumn, ">=", today()],
        ],
        'yesterday' => [
            [$createColumn, "<", today()],
            [$createColumn, ">=", today()->subDay(1)]
        ],
        '1week' => [
            [$createColumn, ">=", today()->subWeek(1)]
        ],
        '2week' => [
            [$createColumn, "<=", today()->subWeek(1)],
            [$createColumn, ">=", today()->subWeek(2)]
        ],
        '3week' => [
            [$createColumn, "<=", today()->subWeek(2)],
            [$createColumn, ">=", today()->subWeek(3)]
        ],
        '1month' => [
            [$createColumn, "<=", today()],
            [$createColumn, ">=", today()->subMonth(1)]
        ],
        '2month' => [
            [$createColumn, "<=", today()->subMonth(1)],
            [$createColumn, ">=", today()->subMonth(2)]
        ],
        '3month' => [
            [$createColumn, "<=", today()->subMonth(2)],
            [$createColumn, ">=", today()->subMonth(3)]
        ],
        '6month' => [
            [$createColumn, "<=", today()->subMonth(5)],
            [$createColumn, ">=", today()->subMonth(6)]
        ],
        '1year' => [
            [$createColumn, ">=", today()->subYear(1)]
        ],
    ];
    if ($justKey) {
        return array_keys($dates);
    } else {
        if (request()->has('period_time')) {
            if (array_key_exists(request()->input('period_time'), $dates)) {
                return $dates[request()->input('period_time')];
            }
        }
        return [];
    }
}
/*************/
/*** order ***/
/*************/
function orders()
{
    return [
        'desc',
        'asc'
    ];
}
/***************/
/*** picture ***/
/***************/
function picture($item, $size = 'thumb')
{
    if (isset($item->picture)) {
        return Picture::get($item->picture, $size);
    }
    return asset(config('lora.perview'));
}
/*****************/
/*** str slice ***/
/*****************/
function str_slice($text, $length)
{
    if (mb_strlen($text)  > $length) {
        return mb_substr($text, 0, $length) . " ... ";
    } else {
        return $text;
    }
}

/*******************/
/*** create slug ***/
/*******************/
function slug($name)
{
    $lettersNumbersSpacesHyphens = '/[^\-\s\pN\pL]+/u';
    $spacesDuplicateHypens = '/[\-\s]+/';
    $slug = preg_replace($lettersNumbersSpacesHyphens, null, $name);
    $slug = preg_replace($spacesDuplicateHypens, '-', $slug);
    $slug = trim($slug, '+');
    if ($slug[strlen($slug) - 1] == "-") {
        $slug = substr($slug, 0, strlen($slug) - 1);
    }
    return $slug;
}

/***************/
/*** authTag ***/
/***************/
function authTag()
{
    $user = request()->user("users")->load("role.tags");
    $tags = $user->role->tags->pluck('id')->toArray();
    return $tags;
}
/**************/
/*** gender ***/
/**************/
function genders()
{
    return ['male', 'female'];
}
/****************/
/*** currency ***/
/****************/
function currency($currency, $numberFormat = false)
{
    //*  قیمت دیفالت سیستم  *//
    $format = strtolower(config('lora.currency'));

    if ($format == 'rial')
        return [
            'currency' => $numberFormat ?  number_format($currency) : $currency,
            'type' => trans('lora.currency.rial')
        ];
    elseif ($format == 'toman')
        return [
            'currency' => $numberFormat ?  number_format(round($currency / 10, 2)) : round($currency / 10, 2),
            'type' => trans('lora.currency.toman')
        ];
    elseif ($format == 'thousandtoman')
        return [
            'currency' => $numberFormat ?  number_format(round($currency / 10000, 2)) : round($currency / 10000, 2),
            'type' => trans('lora.currency.thousandtoman')
        ];
    elseif ($format == 'thousandrial')
        return [
            'currency' => $numberFormat ? number_format(round($currency / 1000, 2)) : round($currency / 1000, 2),
            'type' => trans('lora.currency.thousandrial')
        ];
}

function changeCurrency($currency, $changeTo = 'rial')
{
    $format = strtolower(config('lora.currency'));
    $changing   =
        [
            //*  *//
            'rial' => [
                'rial'   => 1,
                'toman'  => .1,
                'thousandtoman' => .0001,
                'thousandrial'  => .001,
            ],

            'toman' => [
                'rial'   => 10,
                'toman'  => 1,
                'thousandtoman' => .001,
                'thousandrial'  => .01,
            ],

            'thousandtoman' => [
                'rial'   => 10000,
                'toman'  => 1000,
                'thousandtoman' => 1,
                'thousandrial'  => 10,
            ],

            'thousandrial' => [
                'rial'   => 1000,
                'toman'  => 100,
                'thousandtoman' => .1,
                'thousandrial'  => 1,
            ],
        ];

    return $changing[$format][$changeTo] * $currency;
}


function stepCurrency()
{
    switch (config('lora.currency')) {
        case "rial":
            $step = 10000;
            break;
        case "toman":
            $step = 1000;
            break;
    }
    return $step;
}

function me()
{
    $guards = config("auth.guards");
    $currentGuard = null;
    foreach ($guards as $guard => $value)
        if (\Auth::guard($guard)->check())
            $currentGuard = $guard;

    return \Auth::guard($currentGuard)->user();
}

function statusTransaction($status)
{
    switch ($status) {
        case "SUCCEED":
            return trans('lora.status.succeed');
        case "FAILED":
            return trans('lora.status.failed');
        case "INIT":
            return trans('lora.status.init');
    }
}

/*** option ***/
function option($key, $default = null)
{
    $option = app(OptionService::class);
    return $option->get($key, $default);
}

/*** get logo ***/
function logo($size = "thumb")
{

    $picture = option("site_logo");
    if (!!$picture) {
        $picture = json_decode($picture, true);
        return asset($picture[$size]);
    }

    return asset(config("lora.perview"));
}
/*** get favicon ***/
function favicon($size = "thumb")
{
    $picture = option("site_favicon");
    if (!!$picture)
        return asset($picture);
    return asset(config("lora.perview"));
}
/*** preview not image ***/
function preview($size = "thumb")
{
    $picture = option("site_perview");
    if (!!$picture) {
        $picture = json_decode($picture, true);
        return asset($picture[$size]);
    }

    return asset(config("lora.perview"));
}
/*** keywords site ***/
function keywords()
{
    return json_decode(option("keywords"))  ?? config("dash.keywords");
}
/*
* $name = مقدار درخواست index می باشد به صورت قراردادی هر درخواست رو بر اساس index بررسی میکنم
* $createClass = مقدار بولین دریافت میکند ایا کلاس بسازد یا خیر
* $activeCode = درصورتی گه میخواهیم متن بازگشتی active را تغییر بدهیم باید به این مقدار استرینگ بدهیم
* $ifNotExistsActving = در صورتی که درخواست ما درست نبود شما ACTIVE کن
* $boolean = در صورتی که ما میخواهیم بولین برگرداند میتوانیم از این استفاده نماییم
*/
function requested($name, $createClass = false, $ifNotExistsActving = false, $boolean = false,  $activeCode = null)
{
    $request = request();
    if (is_null($activeCode))
        $activeCode = "active";

    if ($request->has("index")) {
        $index = $request->input("index");
        if (is_string($index) && is_string($name)) {
            if ($index == $name) {
                if ($boolean == true)
                    return true;

                if ($createClass == true) {
                    return " class={$activeCode}";
                } else {
                    return " {$activeCode} ";
                }
            }
        }
        if ($boolean == true)
            return false;
        return;
    }

    if ($ifNotExistsActving) {
        if ($boolean == true)
            return true;
        if ($createClass == true) {
            return " class={$activeCode}";
        } else {
            return " {$activeCode} ";
        }
    }
    if ($boolean == true)
        return false;
    return;
}

if (!function_exists("array_random")) {
    function array_random(array $array)
    {
        return \Illuminate\Support\Arr::random($array);
    }
}
if (!function_exists('camel_case')) {
    function camel_case($value)
    {
        return Str::camel($value);
    }
}
if (!function_exists("str_random")) {
    function str_random(int $length)
    {
        return Str::random($length);
    }
}
if (!function_exists("str_slug")) {
    function str_slug(string $name)
    {
        return Str::slug($name);
    }
}
