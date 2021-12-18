<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function rules(): array
    {
        return [];
    }
}
