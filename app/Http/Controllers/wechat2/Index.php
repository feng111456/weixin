<?php

namespace App\Http\Controllers\wechat2;
use App\Model\News as news_model;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
class Index extends Controller
{
    function index(){
        //echo  $echostr =request()->echostr;//配置微信号
        $xml=file_get_contents('php://input');
        file_put_contents('check.txt',"\n".$xml,FILE_APPEND);
        $xmlOpj = simplexml_load_string($xml);
        //判断是关注事件还是文本事件
        if($xmlOpj->MsgType=="event" && $xmlOpj->Event=="subscribe"){
            //说明是关注事件
            $userInfo =Wechat::GetUser($xmlOpj->FromUserName);
            if($userInfo['sex']==1){
                $sex = "先生";
            }else{
                $sex = "女士";
            }
            $value = "欢迎".$userInfo['nickname'].$sex."关注本公众号。
                        发送最新新闻,可查看最新新闻内容
                        发送新闻+新闻关键字，可查询新闻内容";
            Wechat::fudu($xmlOpj,$value);
        }elseif($xmlOpj->MsgType=="text"){
            $values =trim($xmlOpj->Content);
            if($values =="最新新闻"){    
                $newsInfo  = news_model::orderBy('add_time','desc')->limit(1)->first();
                $value = "新闻标题:".$newsInfo->n_title."新闻作者:".$newsInfo->n_author."新闻内容:".$newsInfo->n_content;
                Wechat::fudu($xmlOpj,$value);
            }else if(strpos($values,'新闻+')!==false){
                $n_title = mb_substr($values,3); 
                $newsInfo  = news_model::where('n_title','like',"%$n_title%")->first();
                if($newsInfo){
                    news_model::where('n_title','=',$newsInfo->n_id)->increment('n_pv',1);
                    $value = "新闻标题:".$newsInfo->n_title."新闻作者:".$newsInfo->n_author."新闻内容:".$newsInfo->n_content;
                    Wechat::fudu($xmlOpj,$value);
                }else{
                    $value = "暂无相关新闻";
                    Wechat::fudu($xmlOpj,$value); 
                }
            }else{
                    $value = "请按照搜索规范查询";
                    Wechat::fudu($xmlOpj,$value); 
            }
        }
        
    }

}
