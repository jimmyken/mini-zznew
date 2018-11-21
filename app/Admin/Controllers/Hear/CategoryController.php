<?php

namespace App\Admin\Controllers\Hear;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Category;
/**
 * @module 栏目管理
 *
 * Class    CategoryController
 * @package App\Admin\Controllers\Hear
 */
class CategoryController extends Controller
{
    /**
     * @permission 栏目列表
     *
     *
     */
    public function index(){

        $header = '栏目管理';
        $categorys = (new Category())->orderBy('sort', 'desc')->orderBy('created_at','desc')->paginate(10);
        $data = request()->all();
        return view('admin::category.categorys',compact('categorys','data','header'));
       //
    }
    /**
     * @permission 新增栏目-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('admin::category.category-create');
    }
    /**
     * @permission 新增栏目
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request){
        //验证
        $this->validate($request, [
            'title' => 'required|max:20',
            'label' => 'required|max:20',
            'sort' => 'required|integer',
            'image'=>'required',

        ]);
        //逻辑
        $category = new Category();
        $category->title=$request->get('title');
        $category->label=$request->get('label');
        $category->sort = $request->get('sort');
        $path = $request->file('image')->store('image', 'public');
        $category->image = getenv('APP_URL').'/app/public/'.$path;
        $category->save();

            /**
             * @var $file UploadedFile
             */

        //渲染
        return redirect()->route('admin::categorys.index');
    }

    /**
     * @permission 删除栏目
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy(Category $category)
    {
        $category->delete();
        $category->programs()->delete();
        $category->carousel()->delete();
        return response()->json(['status' => 1, 'message' => '成功']);
    }

    /**
     * @permission 修改栏目-页面
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('admin::category.category-edit', compact('category'));
    }

    /**
     * @permission 修改栏目
     *
     * @param Category $category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Category $category, Request $request)
    {
        //验证
        $this->validate($request, [
            'title' => 'required|max:20',
            'label' => 'required|max:20',
            'sort' => 'required|integer',

        ]);
        //逻辑
        $category->title=$request->get('title');
        $category->label=$request->get('label');
        $category->sort = $request->get('sort');
        if($request->file('image')) {
            $path = $request->file('image')->store('image', 'public');
            $category->image =getenv('APP_URL').'/app/public/'.$path;
        }
        $category->save();
        return redirect()->route('admin::categorys.index');
    }

}
