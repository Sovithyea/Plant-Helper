<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CropCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            'headers' => [
                [ 'text' => 'No', 'sortable' => false, 'value' => 'no'],
                [ 'text' => 'Avatar', 'sortable' => false, 'value' => 'avatar'],
                [ 'text' => 'Name', 'sortable' => false, 'value' => 'name'],
                [ 'text' => 'Harvest', 'sortable' => false, 'value' => 'harvest'],
                [ 'text' => 'Expire', 'sortable' => false, 'value' => 'expire'],
                [ 'text' => 'Category', 'sortable' => false, 'value' => 'category.name'],
                // [ 'text' => 'Detail', 'sortable' => false, 'value' => 'detail'],
                [ 'text' => 'Actions', 'sortable' => false, 'value' => 'actions'],
            ]
        ];
    }
}
