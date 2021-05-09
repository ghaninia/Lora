<?php

namespace App\Enum;

class UserEnum
{
    const GENDER_FEMALE  = "female";
    const GENDER_MALE    = "male";

    const GENDERS = [
        self::GENDER_MALE,
        self::GENDER_FEMALE,
    ];

    const THEME_GREEN = "green";
    const THEME_RED = "red";
    const THEME_YELLOW = "yellow";
    const THEME_BLUE = "blue";

    const THEMES = [
        SELF::THEME_GREEN,
        SELF::THEME_RED,
        SELF::THEME_YELLOW,
        SELF::THEME_BLUE,
    ];
}
