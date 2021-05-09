<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Profile\PasswordUpdate;
use App\Http\Requests\Profile\ProfileUpdate;
use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use App\Services\Auth\AuthService;

class ProfileController extends Controller
{
    protected $auth, $user;
    public function __construct(AuthService $auth, UserService $user)
    {
        $this->auth = $auth;
        $this->user = $user;
    }

    public function index()
    {
        return view("dashboard.profile.index", [
            "user" => $this->auth->user()
        ]);
    }

    public function update(ProfileUpdate $request)
    {
        $this->user->update(
            $this->auth->user(),
            $request
        );
        return $this->success([
            "msg" => trans("lora.message.success.profile.update")
        ]);
    }

    public function passwordUpdate(PasswordUpdate $request)
    {
        $this->user->updatePassword(
            $this->auth->user(),
            $request->all()
        );
        return $this->success([
            "msg" => trans("lora.message.success.profile.update"),
        ]);
    }
}
