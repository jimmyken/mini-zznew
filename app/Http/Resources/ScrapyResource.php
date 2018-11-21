<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScrapyResource extends JsonResource
{

    public function toArray($request)
    {
        return [
          'id' => $this->id,
            'label'=>$this->label,
            'title'=>$this->title,
            'content' =>$this->content,
            'image' =>$this->image
        ];
    }
}