<?php
namespace App\Tools;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Tools\Curl;
class Wechat
{
	const appid ="wxff7f4f8c33328445";
	const secret = "ac636f8bea398c79823344cec41e4cb2";
    //获取天气函数
	public static function GetWeather($str2){
		$url = "http://api.k780.com/?app=weather.future&weaid=".$str2."&&appkey=47852&sign=39260a41c7bcbbcf2e808818e64684c7&format=json ";	
			$data = file_get_contents($url);
			$data = json_decode($data,true);
			$str = '';
			foreach($data['result'] as $v){
				$str.=$v['days'].",".$v['week'].",".$v['citynm'].", ".$v['temperature'].",".$v['weather']."\n";
			}
		return $str;
	}
	//被动回复函数
	public static function replyText($xmlOpj,$values){
		echo"<xml>
			  <ToUserName><![CDATA[".$xmlOpj->FromUserName."]]></ToUserName>
			  <FromUserName><![CDATA[".$xmlOpj->ToUserName."]]></FromUserName>
			  <CreateTime>".time()."</CreateTime>
			  <MsgType><![CDATA[text]]></MsgType>
			  <Content><![CDATA[".$values."]]></Content>
			</xml>";die;
	}
	//被动回复图片
	public static function replyImg($xmlOpj,$Wmaterial_id)
	{
		echo "<xml>
                    <ToUserName><![CDATA[".$xmlOpj->FromUserName."]]></ToUserName>
                    <FromUserName><![CDATA[".$xmlOpj->ToUserName."]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>
                    <Image>
                        <MediaId><![CDATA[".$Wmaterial_id."]]></MediaId>
                    </Image>
                </xml>";
	}
	//获取token
	public static function GetToken(){
		//判断有没有token 或者token已经过期
		$access_token =Cache::get('access_token');
		if(empty($access_token)){
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::appid."&secret=".self::secret;
			$url =file_get_contents($url);
			$access_token = json_decode($url,true);
			Cache::put('access_token',$access_token['access_token'],3600);
		}

		return $access_token;
	}
	//获取用户信息
	public static function GetUser($openid){
		$access_token=self::GetToken();
		$userInfo = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		$userInfo =file_get_contents($userInfo);
		$userInfo = json_decode($userInfo,true);
		return $userInfo;
	}
	//获取media_id
	public static function getMediaId($data,$pach)
	{
		$token = self::GetToken();//获取token凭证
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$token."&type=".$data['material_format'];
        //处理图片路径
		$filePach = new \CURLFile(public_path()."/".$pach);
		$postData = ['media'=>$filePach];
		$res = Curl::Curl_post($url,$postData);
		$res = json_decode($res,true);
		return $res;
	}
	//获取ticket
	public static function getTicket($iden)
	{
		$access_token=self::GetToken();
        //获取临时二维码借口
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
        //临时二维码参数
		//$info = '{"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$iden.'"}}}';
		$info = [
			'expire_seconds'=>604800,
			'action_name'=>"QR_STR_SCENE",
			'action_info'=>[
				'scene'=>[
					'scene_str'=>$iden,
				]
			],
		];
		$info = json_encode($info);
        //调用curl方法传参
        $res = Curl::Curl_post($url,$info);
        $res = json_decode($res,true);
        $ticket= UrlEncode($res['ticket']);
        $ticket = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
        return $ticket;
	}
}
