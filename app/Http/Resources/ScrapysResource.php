<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScrapysResource extends JsonResource
{

    public function toArray($request)
    {
        return [
          'id' => $this->id,
            'label'=>$this->gettime($this->label),
            'title'=>$this->title,
            'content' =>$this->content,
            'image' =>$this->image
        ];
    }
    public function gettime($str){
        preg_match_all('/(\d{4}-\d{2}-\d{2})/', $str, $time);
        if($time)
            return $time[0][0];
        return '';
    }
}