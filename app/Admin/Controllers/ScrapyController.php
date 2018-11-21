<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/2/002
 * Time: 11:46
 */

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Scrapy;
use App\Http\Resources\ScrapyResource;
use App\Http\Resources\ScrapysResource;
use Illuminate\Http\Request;

/**
 * @module 新闻数据管理
 *
 * Class    CategoryController
 * @package App\Admin\Controllers\Hear
 */
class ScrapyController extends  Controller
{
    public function index(){
        $day = '-'.getenv('SCRAPY_DAY').'day';
        $passtime = date("Y-m-d H:i:s", strtotime($day));
        Scrapy::where('created_at','<',$passtime)->delete();
        $url = "http://www.zznews.cn/";
        //如果出现中文乱码使用下面代码
        //$getcontent = iconv("gb2312", "utf-8",$html);
      //  $html = new \simple_html_dom();
        // 新建一个Dom实例
        $html = new  \simple_html_dom();
       // 从url中加载
        $html->load_file($url);
        $ul = $html->find('#pic_list',0);
        $lis = $ul->find('li');
        foreach ($lis as $li){
            $newurl = $li->find('a',0)->href;
            $image = $li->find('img',0);
            $this->getNews($newurl,Scrapy::LBT,$image);
        }
        $taihaiurl = "http://www.zznews.cn/taihai/";
        $newsurl = "http://www.zznews.cn/news/";
        $zzurl = "http://www.zznews.cn/news/zzyw/";
        $xyurl = "http://www.zznews.cn/home/xqztc/index.shtml";
        $this->getCategoryNews($newsurl,Scrapy::XINWEN);
        $this->getCategoryNews($taihaiurl,Scrapy::TAIHAI);
        $this->getCategoryNews($zzurl,Scrapy::ZZ);
        $this->getCategoryNews($xyurl,Scrapy::XY);

        return response()->json(['status' => 1, 'message' => '获取成功']);
    }
    public function getCategoryNews($url,$type){
        $html = new  \simple_html_dom();
        // 从url中加载
        $html->load_file($url);
        $ul = $html->find('.n-main-l',0);
        $lis = $ul->find('li');
        $lis = array_reverse($lis);

        foreach ($lis as $li){
            $newurl = $li->find('a',0)->href;
            $this->getNews($newurl,$type);
        }
        return  '爬取栏目新闻完毕';
    }
    public function getNews($url,$type,$image =null){
        $html = new  \simple_html_dom();
        $scrapy = new Scrapy();
        $html->load_file($url);
        $head = $html->find('.n-cont-top',0);
        if($head) {
            $title = $head->find('h1', 0);
            $label = $head->find('span', 0);
            $count = (new Scrapy())->where('title','=',html_entity_decode($title))->where('type',$type)->count();
            if($count>0){
                return 0;
            }
            $scrapy->title =html_entity_decode($title);
            $scrapy->label = html_entity_decode($label);
            $content = $html->find('table',0);
            $scrapy->image =html_entity_decode($image);
            $scrapy->content = html_entity_decode($content);
            $scrapy->type = $type;
            $scrapy->save();
        }
        else{
            $content = $html->find('table',0);
            $scrapy->image =html_entity_decode($image);
            $count = (new Scrapy())->where('image','=',$image)->where('type','=',$type)->count();
            if($count>0 || html_entity_decode($content) ==null ||$image ==null){
                return 0;
            }
            $scrapy->content = html_entity_decode($content);
            $scrapy->type = $type;
            $scrapy->save();
        }
        return 1;
    }

    public function scrapys($type){
        $news = (new Scrapy())->where('type','=',$type)->orderBy('created_at','desc')->paginate(10);
        return api()->collection($news, ScrapysResource::class);
    }

    public function banners(){
        $news = (new Scrapy())->where('type','=',Scrapy::LBT)->orderBy('created_at','desc')->limit(4)->get();
        return api()->collection($news, ScrapyResource::class);
    }

    public function show($id){
        $scrapy = (new Scrapy())->where('id','=',$id)->get();


        return api()->collection($scrapy,ScrapyResource::class);
    }
    /**
     * @permission 新闻获取时间设置/每天
     *
     *
     */
    public function scrapytime(){
        return view('admin::scrapy.scrapy');
    }

    public function store(Request $request){
        $time = $request->get('time');
        $day = $request->get('day');
        $hour =  $request->get('hour');
        if( $request->file('image')) {
            $path = $request->file('image')->store('image', 'public');
            edit_env(['BANNER_URL'=>getenv('APP_URL').'/app/public/'.$path]);
        }
        edit_env(['SCRAPY_TIME' => $time,'SCRAPY_DAY'=>$day,'SCRAPY_HOUR'=>$hour]);

        return redirect()->route('admin::scrapy.time');
    }

    public function banner(){
        return response()->json(getenv('BANNER_URL'));
    }

}