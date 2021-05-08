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
        $p_title = "";
        $user = $request->user();
        if ($request->input("index", "edit") == "edit") {
            $information = [
                'title' => trans("lora.profile.edit.text"),
                'desc'  => trans("lora.profile.edit.desc"),
                'breadcrumb' => [
                    trans("lora.profile.edit.text") => null
                ]
            ];
        } else {
            $information = [
                'title' => trans("lora.profile.changepassword.text"),
                'desc'  => trans("lora.profile.changepassword.desc"),
                'breadcrumb' => [
                    trans("lora.profile.changepassword.text") => null
                ]
            ];
        }
        return view("dashboard.profile.index", compact("information", 'user'));
    }

    public function store(ProfileUpdate $request)
    {

        $list = [
            "firstname" => $request->input('firstname'),
            "lastname"  => $request->input('lastname'),
            "username"  => $request->input('username'),
            "email"     => $request->input('email'),
            "mobile"    => $request->input('mobile'),
            "gender"    => $request->input('gender'),
            "theme"     => $request->input("theme"),
        ];

        if ($request->hasFile('picture')) {
            Picture::delete(Auth::user()->picture);
            $list["picture"]   = Picture::create("picture");
        }

        Auth::user()->update(
            $request->input("password") ? [
                "password"  => bcrypt($request->input("password"))
            ] : $list
        );
        return RepMessage(trans("lora.messages.success.profile.update"));
    }
}
