<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileUpdate;
use App\Repositories\Picture;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $p_title = ""  ;
        $user = $request->user("user") ;
        if ($request->input("index" , "edit" ) == "edit")
        {
            $information = [
                'title' => trans("dashboard.profile.edit.text") ,
                'desc'  => trans("dashboard.profile.edit.desc") ,
                'breadcrumb' => [
                    trans("dashboard.profile.edit.text") => null
                ]
            ] ;
        }
        else
        {
            $information = [
                'title' => trans("dashboard.profile.changepassword.text") ,
                'desc'  => trans("dashboard.profile.changepassword.desc") ,
                'breadcrumb' => [
                    trans("dashboard.profile.changepassword.text") => null
                ]
            ] ;
        }
        return view("dashboard.profile.index" , compact("information" , 'user') ) ;
    }

    public function store(ProfileUpdate $request)
    {

        $list = [
            "firstname" => $request->input('firstname') ,
            "lastname"  => $request->input('lastname') ,
            "username"  => $request->input('username') ,
            "email"     => $request->input('email') ,
            "mobile"    => $request->input('mobile') ,
            "gender"    => $request->input('gender') ,
            "theme"     => $request->input("theme") ,
        ];

        if ($request->hasFile('picture')){
            Picture::delete(Auth::guard("user")->user()->picture) ;
            $list["picture"]   = Picture::create("picture") ;
        }

        Auth::guard("user")->user()->update(
            $request->input("password") ? [
                "password"  => bcrypt($request->input("password"))
            ] : $list
        );
        return RepMessage(trans("dashboard.messages.success.profile.update")) ;
    }
}
