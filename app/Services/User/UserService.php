<?php

namespace App\Services\User;

use App\Services\User\UserServiceInterface;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Classes\Picture;
use App\Models\User;

class UserService implements UserServiceInterface
{
    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function updatePassword(User $user, array $data): bool
    {
        return $user->update([
            "password" => Hash::make($data["password"])
        ]);
    }

    public function update(User $user, Request $request): bool
    {
        if ($request->hasFile("picture")) {
            Picture::delete($user->picture);
            $request->merge([
                "picture" => Picture::create("picture")
            ]);
        }

        return
            $user->update(
                $request->only([
                    "firstname",
                    "lastname",
                    "username",
                    "email",
                    "mobile",
                    "gender",
                    "theme",
                    "picture",
                ])
            );
    }
}
