<?php

namespace App\Api\Controllers\Hear;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use App\Models\Category;
use App\Models\Program;
use App\Http\Resources\CarouselsResource;
use App\Http\Resources\CategorysResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProgramsResource;
use Illuminate\Http\Request;
class HearController extends Controller
{
    //轮播图列表api
    public function carousels()
    {
        $carousels =Carousel::orderBy('sort', 'desc')->orderBy('created_at','desc')->paginate(10);
        return api()->collection($carousels,CarouselsResource::class );
    }
    //栏目列表api
    public function categorys(){

        $categorys =Category::orderBy('sort', 'desc')->orderBy('created_at','desc')->paginate(10);
        return api()->collection($categorys,CategorysResource::class );
    }
    //栏目详情
    public function category(Category $category){
        return api()->item($category,CategoryResource::class);
    }

    //某个栏目下的节目列表
    public function programs($id,Request $request){
        $order = 'desc';
        if($request->get('sort') == 'desc'){
            $order = 'desc';
        }
        else{
            $order = 'asc';
        }
        $programs = Program::where('category_id','=',$id)->orderBy('created_at', $order)->paginate(10);
        return api()->collection($programs,ProgramsResource::class);
    }



    //点击节目增加播放量
    public function addpayvolume(Program $program){
        $program->payvolume+=1;
        $program->save();
        $date=[
            'msg'=>'增加成功'
        ];
        return response()->json($date);
    }

}
