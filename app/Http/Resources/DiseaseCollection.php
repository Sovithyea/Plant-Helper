<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DiseaseCollection extends ResourceCollection
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
                [ 'text' => 'diagnosis', 'sortable' => false, 'value' => 'diagnosis'],
                [ 'text' => 'Crop', 'sortable' => false, 'value' => 'crop.name'],
                [ 'text' => 'Actions', 'sortable' => false, 'value' => 'actions'],
            ],
        ];
    }
}