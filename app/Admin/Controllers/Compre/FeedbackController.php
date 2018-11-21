<?php

namespace App\Admin\Controllers\Compre;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Feedback;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;

/**
 * @module 意见反馈
 *
 * Class    FeedbackController
 * @package App\Admin\Controllers\Compre
 */
class FeedbackController extends Controller
{
    /**
     * @permission 意见反馈列表
     *
     *
     */
    public function index(){

        $header = '意见反馈管理';
        $data = request()->all();
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('name');
            $searcher->equal('state');
            $searcher->like('created_at');
        });
        $feedbacks = (new Feedback())->search($searcher)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin::feedback.feedbacks',compact('feedbacks','data','header'));
    }

    /**
     * @permission 删除意见反馈
     *
     * @param Feedback $feedback
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy(Feedback $feedback){
        $feedback->delete();
        return response()->json(['status' => 1, 'message' => '成功']);
    }

    /**
     * @permission 查看意见反馈
     *
     * @param Feedback $feedback
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Feedback $feedback){
        $feedback->state = 1;
        $feedback->save();
        return view('admin::feedback.feedback-show',compact('feedback'));
    }

}
