<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'content'=>$this->content
        ];
    }
}