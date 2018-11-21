<?php

namespace App\Admin\Controllers\Compre;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\About;
/**
 * @module 关于我们
 *
 * Class    AboutController
 * @package App\Admin\Controllers\Compre
 */
class AboutController extends Controller
{
    /**
     * @permission 关于我们图文内容
     *
     *
     */
    public function index(){

        $header = '关于我们';
        $about =About::first();


        return view('admin::about.about',compact('about'));
    }
    /**
     * @permission 更新关于我们图文内容
     *
     *
     */
    public function update(About $about,Request $request){
              $about->content = $request->get('content');
              $about->save();
        return view('admin::about.about',compact('about'));
    }


}
