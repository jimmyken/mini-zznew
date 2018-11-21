<?php

namespace App\Admin\Controllers\Hear;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Carousel;
use App\Models\Category;
/**
 * @module 轮播图管理
 *
 * Class    CategoryController
 * @package App\Admin\Controllers\Hear
 */
class CarouselController extends Controller
{
    /**
     * @permission 轮播图列表
     *
     *
     */
    public function index(){

        $header = '轮播图管理';
        $carousels= (new Carousel())->orderBy('sort', 'desc')->orderBy('created_at','desc')->paginate(10);
        $data = request()->all();
        return view('admin::carousel.carousels',compact('carousels','data','header'));
        //
    }
    /**
     * @permission 新增轮播图-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $categorys=Category::all();
        return view('admin::carousel.carousel-create',compact('categorys'));
    }
    /**
     * @permission 删除轮播图
     *
     * @param Carousel $carousel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy(Carousel $carousel){
        $carousel->delete();
        return response()->json(['status' => 1, 'message' => '成功']);

    }
    /**
     * @permission 编辑轮播图
     *
     * @param Carousel $carousel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Carousel $carousel){
        $categorys=Category::all();
        return view('admin::carousel.carousel-edit',compact('categorys','carousel'));
    }
    /**
     * @permission 新增轮播图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request){
        //验证
        $this->validate($request, [
            'title' => 'required|max:20',
            'image'=>'required',
            'sort' => 'required|integer',
            'category_id'=>'required|integer',
        ]);
        //逻辑
        $carousel = new Carousel();
        $carousel->title = $request->get('title');
        $carousel->sort = $request->get('sort');
        $carousel->category_id = $request->get('category_id');

        //图片存储
        $path = $request->file('image')->store('image', 'public');
        $carousel->image = getenv('APP_URL').'/app/public/'.$path;
        $carousel->save();

        //渲染
        return redirect()->route('admin::carousels.index');

    }

    /**
     * @permission 修改轮播图
     *
     * @param Carousel $carousel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Carousel $carousel,Request $request){

        //验证
        $this->validate($request, [
            'title' => 'required|max:20',
            'sort' => 'required|integer',
            'category_id'=>'required|integer',
        ]);
        //逻辑
        $carousel->title = $request->get('title');
        $carousel->sort = $request->get('sort');
        $carousel->category_id = $request->get('category_id');

        //图片存储
        if($request->file('image')) {
            $path = $request->file('image')->store('image', 'public');
            $carousel->image =getenv('APP_URL').'/app/public/' . $path;
        }
        $carousel->save();

        //渲染
        return redirect()->route('admin::carousels.index');
    }


}
