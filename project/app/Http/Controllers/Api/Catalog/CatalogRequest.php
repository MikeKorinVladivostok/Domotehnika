<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\Request;

class CatalogRequest extends Request
{
    public function getCategoryId(): int
    {
        return (int)$this->get('category_id');
    }

    public function getPage(): int
    {
        return max(0, $this->get('page', 1) - 1);
    }
}
