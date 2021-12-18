<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\JsonResponse;

class GetAdvertResponse extends JsonResponse
{
    public function __construct(object $advert)
    {
        parent::__construct([
            'id'          => $advert->id,
            'title'       => $advert->title,
            'description' => $advert->description,
            'contact'     => $advert->contacts,
            'category'    => $advert->category,
        ]);

        return view('post', [
            'data' => $this
        ]);
    }
}
