<?php

namespace App\Dtos;

class BaseDto
{
    public function __construct()
    {
        
    }

    public function bindToDto($request)
    {
        foreach ($request->all() as $name => $value) {
            if (is_array($value)) {
                $this->{$name} = json_encode($value, JSON_UNESCAPED_UNICODE);
            } else {
                $this->{$name} = $value;
            }
        }
    }
}
