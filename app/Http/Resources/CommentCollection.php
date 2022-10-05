<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
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
                ['text' => 'No', 'sortable' => false, 'value' => 'no'],
                ['text' => 'Email', 'sortable' => false, 'value' => 'email'],
                ['text' => 'Title', 'sortable' => false, 'value' => 'title'],
                ['text' => 'Comment', 'sortable' => false, 'value' => 'description'],
                // ['text' => 'Image', 'sortable' => false, 'value' => 'avatar'],
                ['text' => 'Actions', 'sortable' => false, 'value' => 'actions'],
            ]
        ];
    }
}
