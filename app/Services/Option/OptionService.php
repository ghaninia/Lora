<?php

namespace App\Services\Option;

use App\Repositories\Option\OptionRepository;
use App\Services\Option\OptionServiceInterface;

class OptionService implements OptionServiceInterface
{
    public $option;
    public function __construct(OptionRepository $option)
    {
        $this->option = $option;
    }

    public function get(string $key, string $default = null)
    {
        $option = $this->option->where("key", $key)->first();
        $value  = $option->value ?? $option->default  ?? $default ;
        return !!$option ? $value : false;
    }

    public function set(string $key, ?string $value): bool
    {
        return
            $this->option
            ->query()
            ->where("key", $key)
            ->update([
                "value" => $value
            ]);
    }
}
