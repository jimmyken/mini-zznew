<?php

namespace App\Api\Controllers\About;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Http\Resources\AboutResource;
class AboutController extends Controller
{
    //关于我们api
    public function show(){
        $about =About::first();

        return api()->item($about,AboutResource::class);
    }
}
