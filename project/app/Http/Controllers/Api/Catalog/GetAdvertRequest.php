<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\Request;

class GetAdvertRequest extends Request
{
    public function getId(): int
    {
        return (int)$this->route('id');
    }
}
