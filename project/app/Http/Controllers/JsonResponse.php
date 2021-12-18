<?php

namespace App\Http\Controllers;

abstract class JsonResponse extends \Illuminate\Http\JsonResponse
{
    public function __construct($data = null)
    {
        parent::__construct(
            data: $data,
            options: JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | self::DEFAULT_ENCODING_OPTIONS
        );
    }
}
