<?php

namespace App\Admin\Controllers\Hear;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Category;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;
/**
 * @module 节目管理
 *
 * Class ProgramController
 * @package App\Admin\Controllers\Hear
 */
class ProgramController extends Controller
{
    /**
     * @permission 节目列表
     *
     *
     */
    public function index(){
        $categorys=Category::all();
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('title');
            $searcher->equal('category.title','category_title');
            $searcher->equal('category.label','category_label');
        });
        $data = request()->all();
        $header = '节目管理';
        $programs = (new Program())->search($searcher)->orderBy('created_at', 'desc')->paginate(10);

       return view('admin::program.programs',compact('programs','data','header','categorys'));
    }
    /**
     * @permission 新增节目-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categorys=Category::all();
        return view('admin::program.program-create',compact('categorys'));
    }

    /**
     * @permission 新增节目
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request){
        //验证

        $this->validate($request, [
            'title' => 'required|max:20',
            'created_at' => 'required',
            'image'=>'required',
            'content' => 'required',
            'lasttime'=>'required',
            'category_id'=>'required|integer',

        ]);
        //逻辑
        $program = new Program();
        $program->title=$request->get('title');
        $program->created_at=$request->get('created_at');
        $program->lasttime = $request->get('lasttime');
        $program->category_id = $request->get('category_id');



        //存入图片，视频

        $path = $request->file('image')->store('image', 'public');
        $program->image = getenv('APP_URL').'/app/public/'.$path;
//        $content = $request->file('content')->store('music','public');
        $filename = time().rand(10000,99999) . '.' .strtolower($request->file('content')->getClientOriginalExtension());
        $content =$request->file('content')->storeAs('music',$filename,'public');

//        $test_name = 'testafdasfsdafsda.'.strtolower($request->file('content')->getClientOriginalExtension());
//        file_put_contents('text.txt',var_export($test_name,1),FILE_APPEND);
        $program->content = getenv('APP_URL').'/app/public/'.$content;
        $program->category_id = $request->get('category_id');
        //
        $program->save();
        //渲染
        return redirect()->route('admin::programs.index');
    }

    /**
     * @permission 删除节目
     *
     * @param Program $program
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy(Program $program)
    {
        $program->delete();
        return response()->json(['status' => 1, 'message' => '成功']);
    }
    /**
     * @permission 编辑节目
     *
     * @param Program $program
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Program $program){
        $categorys=Category::all();
        return view('admin::program.program-edit',compact('categorys','program'));
    }

    /**
     * @permission 修改节目
     *
     * @param Program $program
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Program $program, Request $request)
    {
        //验证

        $this->validate($request, [
            'title' => 'required|max:20',
            'created_at' => 'required',
            'lasttime'=>'required',
            'category_id'=>'required|integer',

        ]);
        //逻辑
        $program->title=$request->get('title');
        $program->created_at=$request->get('created_at');
        $program->lasttime = $request->get('lasttime');
        $program->category_id = $request->get('category_id');


        //存入图片，音频

        if($request->file('image')) {
            $path = $request->file('image')->store('image', 'public');
            $program->image = getenv('APP_URL').'/app/public/'.$path;
        }
        if($request->file('content')) {
            $filename = time().rand(10000,99999) . '.' .strtolower($request->file('content')->getClientOriginalExtension());
            $content =$request->file('content')->storeAs('music',$filename,'public');
            $program->content = getenv('APP_URL').'/app/public/'.$content;
        }
        $program->category_id = $request->get('category_id');
        //
        $program->save();
        //渲染
        return redirect()->route('admin::programs.index');
    }
}
