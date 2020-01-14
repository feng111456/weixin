<?php

namespace App\Http\Controllers\admin;
use App\Tools\Curl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Tools\Wechat;

class Message extends Controller
{
    //发送消息视图
    function create()
    {
        return view('admin/message/create');
    }
    function store()
    {
        $content = request()->content;
        $access_token=Wechat::GetToken();//获取access_token
        $url ="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$access_token;
        //获取用户openid
        $openid = User::pluck('openid');
        //$openid = $openid->items;
        dd($openid);
        $json_data = [
            "touser"    => $openid,
            "msgtype"   => "text",
            "text"      => [
                "content"   => $content
            ]
        ];
        
        $res = Curl::Curl_post($url,$json_data);
        if($res['errcode'] > 0){
            echo '错误信息： ' . $response['errmsg'];
        }else{
            echo "发送成功";
        }

    }
}
