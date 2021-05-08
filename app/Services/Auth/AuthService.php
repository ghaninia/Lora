<?php

namespace App\Services\Auth;

use App\Classes\Picture;
use App\Enum\UserEnum;
use App\Models\User;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    protected $forUser;

    public function user(): ?User
    {
        return Auth::user();
    }

    public function forUser(User $user)
    {
        $this->forUser = $user;
        return $this;
    }

    private function getUser()
    {
        return $this->forUser ?? $this->user();
    }

    public function logout()
    {
        return Auth::logout();
    }

    public function login(array $credinal, bool $remember = false): bool
    {
        return Auth::attempt($credinal, $remember);
    }


    public function id(): ?int
    {
        return optional($this->getUser())->id;
    }

    public function username(): ?string
    {
        return optional($this->getUser())->username;
    }

    public function theme(): string
    {
        return optional($this->getUser())->theme ?? config("lora.theme");
    }

    /*
    ** check user is male
    ** @return Boolean
    */
    private function isGenderMale()
    {
        return $this->getUser()->gender === UserEnum::GENDER_MALE;
    }

    public function avatar(string $size = "thumb"): string
    {
        $user = $this->getUser();

        if (is_null($user->picture))
            $picture = $this->isGenderMale() ? maleDefaultPicture() : femaleDefaultPicture();
        else
            $picture = Picture::get($user->picture, $size);

        return $picture;
    }
}
