<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nickname'=>$this->nickname,
            'gender'=>$this->gender,
            'language'=>$this->language,
            'city'=>$this->city,
            'province'=>$this->province,
            'country'=>$this->country,
            'avatarurl' =>$this->avatarurl,
            'birthday' =>$this->birthday,
            'mobile' =>$this->mobile
        ];
    }
}