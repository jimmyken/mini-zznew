<?php

namespace App\Admin\Controllers\Compre;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Offaccount;


/**
 * @module 公众号
 *
 * Class    OffaccountController
 * @package App\Admin\Controllers\Compre
 */
class OffaccountController extends Controller
{
    /**
     * @permission 公众号列表
     *
     *
     */
    public function index(){

        $header = '公众号管理';
        $data = request()->all();
        $offaccounts = (new Offaccount())->orderBy('created_at', 'desc')->paginate(10);
       return view('admin::offaccount.offaccounts',compact('offaccounts','data','header'));
    }
    /**
     * @permission 新增公众号-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
       return view('admin::offaccount.offaccount-create');
    }


    /**
     * @permission 删除公众号
     *
     * @param Offaccount $offaccount
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy(Offaccount $offaccount){
        $offaccount->delete();
        return response()->json(['status' => 1, 'message' => '成功']);
    }
    /**
     * @permission 新增公众号
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request){
        //验证

        $this->validate($request, [
            'title' => 'required|max:20',
            'description' => 'required',
            'image'=>'required',
            'qrcode' => 'required',
        ]);

        //逻辑
        $offaccount = new Offaccount();
        $offaccount->qrcode= $request->get('qrcode');
        $offaccount->title=$request->get('title');
        $offaccount->description=$request->get('description');
        //存入图片，视频

        $path = $request->file('image')->store('image', 'public');
        $offaccount->image = getenv('APP_URL').'/app/public/'.$path;
        //
        $offaccount->save();
        //渲染
        return redirect()->route('admin::offaccounts.index');

    }

    public function edit(Offaccount $offaccount){
        return view('admin::offaccount.offaccount-edit',compact('offaccount'));
    }
    /**
     * @permission 修改公众号
     *
     * @param Offaccount $offaccount
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Offaccount $offaccount, Request $request){


        $this->validate($request, [
            'title' => 'required|max:20',
            'description' => 'required',
            'qrcode' => 'required',
        ]);
        $offaccount->qrcode= $request->get('qrcode');
        $offaccount->title=$request->get('title');
        $offaccount->description=$request->get('description');
        //存入图片，视频
        if( $request->file('image')) {
            $path = $request->file('image')->store('image', 'public');
            $offaccount->image = getenv('APP_URL').'/app/public/' . $path;
        }
        //
        $offaccount->save();
        //渲染
        return redirect()->route('admin::offaccounts.index');
    }


}
