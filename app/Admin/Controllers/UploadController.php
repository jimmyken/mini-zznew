<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/14
 * Time: 16:02
 * Function:
 */

namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * 上传编辑器图片
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function image(Request $request)
    {
        $url = [];
        foreach ($request->file('imgs') as $file) {
            /**
             * @var $file UploadedFile
             */
            $path = getenv('APP_URL').'/app/public/'.$file->store('imgs', 'public');
            $url[] = $path;
        }

        return response()->json([
            'errno' => 0,
            'data' => $url
        ]);
    }



}