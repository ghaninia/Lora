<?php

namespace App\Enum;

class UserEnum
{
    const GENDER_FEMALE  = "female";
    const GENDER_MALE    = "male";

    const GENDER = [
        self::GENDER_MALE,
        self::GENDER_FEMALE,
    ];
}
