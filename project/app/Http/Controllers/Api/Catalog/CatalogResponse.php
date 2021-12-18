<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\JsonResponse;

class CatalogResponse extends JsonResponse
{
    public function __construct(array $records)
    {
        parent::__construct($this->makeRecords($records));
        return view('post', [
            'data' => $this->makeRecords($records)
        ]);
    }

    private function makeRecords(array $records): array
    {
        $result = [];
        foreach ($records as $record) {
            $result[] = [
                'id'          => $record->id,
                'title'       => $record->title,
                'description' => $record->description,
                'contact'     => $record->contacts,
            ];
        }
        return $result;

    }

}
