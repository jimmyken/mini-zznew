<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategorysResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title'=>$this->title,
            'label'=>$this->label,
            'image'=>$this->image,
             'host'=>$this->host,
            'created_at'=>date('Y-m-d',strtotime($this->created_at)),
        ];
    }
}