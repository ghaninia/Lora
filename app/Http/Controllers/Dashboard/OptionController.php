<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller  ;
use App\Models\Option;
use App\Models\Role;
use App\Repositories\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class OptionController extends Controller
{
    public function index()
    {
        $information = [
            "title" => trans("dashboard.option.title") ,
            "desc" => trans("dashboard.option.desc") ,
            'breadcrumb' => [
                trans('dashboard.option.title') => null
            ]
        ] ;
        $roles = Role::select(["id" , "name"])->get() ;
        return view("dashboard.option.index" , compact("information" , "roles")) ;
    }

    public function store(Request $request)
    {

        $parameters = $request->only([
            "site_title" ,
            "site_email" ,
            "site_tellphone" ,
            "site_address" ,
            "site_description" ,
            "site_copyright" ,
            "keywords" ,
            "log_email" ,
            "min_credit" ,
            "max_credit" ,
            "paginate_size" ,
            "thumb_height" ,
            "thumb_width" ,
            "limit_buy_time" ,
            "user_default_role" ,
            "telegram_id" ,
            "instagram_id" ,
            "gmail_id" ,
            "yahoo_id" ,
        ]);

        foreach ( $parameters as $key => $value ){
            Option::set($key , $value);
        }

        if ( $request->hasFile('site_logo') ){
            Picture::delete( json_encode(option("site_logo")) ) ;
            Option::set( "site_logo" , Picture::create("site_logo")) ;
        }

        if ( $request->hasFile('site_favicon') ){
            Picture::delete( json_encode(option("site_favicon")) ) ;
            Option::set( "site_favicon" , Picture::create("site_favicon")) ;
        }

        if ( $request->hasFile('site_perview') ){
            Picture::delete( json_encode(option("site_perview")) ) ;
            Option::set( "site_perview" , Picture::create("site_perview")) ;
        }

        if ( $request->has("user_can_regsiter") )
            Option::set("user_can_regsiter" , $request->input("user_can_regsiter" , false )) ;

        Artisan::call("cache:clear") ;

        return redirect()
            ->route("dashboard.option.index" , ["index" => $request->input("index") ] )
            ->with([
                'status'   => true ,
                'message'  => "تنظیمات با موفقیت ثبت گردید"
            ]);
    }
}
