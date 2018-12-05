<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email' ,
            "captcha" => 'required|captcha'
        ]);
    }
    protected function sendResetLinkResponse($response)
    {
        return back()->with('status', trans($response , ['email' => request()->input("email")]));
    }
}
