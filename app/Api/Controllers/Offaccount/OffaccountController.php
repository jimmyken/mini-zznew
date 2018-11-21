<?php

namespace App\Api\Controllers\Offaccount;

use App\Http\Controllers\Controller;
use App\Models\Offaccount;
use App\Http\Resources\OffaccountsResource;
use App\Http\Resources\OffaccountResource;
class OffaccountController extends Controller
{
    //公众号列表api
    public function offaccounts(){
        $offaccounts =Offaccount::orderBy('created_at', 'desc')->paginate(10);

       return api()->collection($offaccounts,OffaccountsResource::class);
    }

    //公众号详情api
    public function offaccount(Offaccount $offaccount){
        return api()->item($offaccount,OffaccountResource::class);
    }
}
