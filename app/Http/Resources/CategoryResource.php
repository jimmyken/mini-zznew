<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title'=>$this->title,
            'label'=>$this->label,
            'image'=>$this->image,
             'host'=>$this->host,
            'is_sub'=>$this->is_user()?1:0,
            'created_at'=>date('Y-m-d',strtotime($this->created_at))
        ];
    }
}