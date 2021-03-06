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
        $openid = User::select('openid')->get()->toArray();
        $openid = array_column($openid,'openid');
        $json_data = [
            "touser"    => $openid,
            "msgtype"   => "text",
            "text"      => [
                "content"   => $content
            ]
        ];
        $json_data = json_encode($json_data,JSON_UNESCAPED_UNICODE);
        $res = Curl::Curl_post($url,$json_data);
        $res = json_decode($res,true);
        if($res['errcode'] > 0){
            echo '错误信息： ' . $response['errmsg'];
        }else{
            echo "发送成功";
        }

    }
}
