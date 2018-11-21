<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramsResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title'=>$this->title,
            'image'=>$this->image,
            'created_at'=>date('Y-m-d',strtotime($this->created_at)),
            'content'=>$this->content,
            'lasttime'=>$this->lasttime,
            'payvolume'=>$this->payvolume,
            'rn'=>$this->rn
        ];
    }
}