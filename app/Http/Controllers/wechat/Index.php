<?php

namespace App\Http\Controllers\wechat;
use App\Tools\Wechat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Material;
use App\Tools\Curl;
use App\Model\Chandel;
use App\Model\User;
class Index extends Controller
{
    public $array = ['张一','张二','张三','张四','张武'];
    function index(){
        // $echostr =request()->echostr;
        // if(!empty($echostr)){
        //     echo $echostr;die;
        // }
        $xml=file_get_contents('php://input');
        file_put_contents('check.txt',"\n".$xml,FILE_APPEND);
        $xmlOpj = simplexml_load_string($xml);
        //dump($xmlOpj);
        //判断是文本 还是事件
        if($xmlOpj->MsgType=='event' && $xmlOpj->Event=='subscribe'){
            //关注事件
            $userInfo =Wechat::GetUser($xmlOpj->FromUserName);//获取用户信息
            //先判断用户是否已经关注
            $userData = User::where('openid','=',$userInfo['openid'])->first();
            if($userData){
                $eventKey = $xmlOpj->EventKey;
                $eventKey = ltrim($eventKey,'qrscene_');
                $nickname = $userInfo['nickname'];
                $sex = '';
                if($userInfo['sex']==1){
                    $sex = "先生";
                }else{
                    $sex = "女士"; 
                }
                Chandel::where('c_iden','=',$eventKey)->increment('man');
                User::where('openid','=',$userData->openid)->update(['is_del'=>1,'c_iden'=>$eventKey]);
                $str = "欢迎".$nickname.$sex."回归公众号!输入1获取全班人姓名,输入2获取本班最帅的人姓名,地区名加天气 获取该地区一礼拜天气情况";
                Wechat::replyText($xmlOpj,$str);
                
            }
            //在判断是普通关注事件还是渠道关注事件
            $eventKey = $xmlOpj->EventKey;
            if(!empty($eventKey)){
                $eventKey = ltrim($eventKey,'qrscene_');
                $data = [];
                $data['openid']=$userInfo['openid'];
                $data['nickname'] = $userInfo['nickname'];
                $data['sex'] = $userInfo['sex'];
                $data['city'] = $userInfo['city'];
                $data['province'] = $userInfo['province'];
                $data['country'] = $userInfo['country'];
                $data['c_iden'] = $eventKey;
                User::create($data);
                Chandel::where('c_iden','=',$eventKey)->increment('man');
            }

            $nickname = $userInfo['nickname'];
            $sex = '';
            if($userInfo['sex']==1){
                $sex = "先生";
            }else{
                $sex = "女士"; 
            }
            $str = "欢迎".$nickname.$sex."关注张攀峰公众号!输入1获取全班人姓名,输入2获取本班最帅的人姓名,地区名加天气 获取该地区一礼拜天气情况";
            Wechat::replyText($xmlOpj,$str);
        }elseif($xmlOpj->MsgType=='event' && $xmlOpj->Event=='unsubscribe'){
            
            $userInfo =Wechat::GetUser($xmlOpj->FromUserName);//获取用户信息
            //获取渠道标识
            $data = User::where('openid','=',$userInfo['openid'])->first('c_iden');
            User::where('openid','=',$userInfo['openid'])->update(['is_del'=>2]);
            Chandel::where('c_iden','=',$data['c_iden'])->decrement('man');
        }elseif($xmlOpj->MsgType=='text'){
            $values =trim($xmlOpj->Content);
            //发送文本
            if($values=='1'){
                //回复全班名称
                $str = implode(',',$this->array);
                Wechat::replyText($xmlOpj,$str);
            }elseif($values=='2'){
                //随机全班最帅的一个
                $k=array_rand($this->array,1);
                Wechat::replyText($xmlOpj,$this->array[$k]);
            }elseif(strpos($values,'天气')!==false){
            //回复天气有关数据
                $str2=substr($values,0,-6);
                if(empty($str2)){
                    $str2 = '北京';
                }
                $str =Wechat::GetWeather($str2);
                Wechat::replyText($xmlOpj,$str);
            }
        }elseif($xmlOpj->MsgType=='image'){
            //说明用户发了一个图片
            $WmaterialInfo = Material::select('Wmaterial_id')->orderBy(\DB::raw('RAND()'))
            ->take(1)
            ->first()->toArray();
            $Wmaterial_id=$WmaterialInfo['Wmaterial_id'];
            Wechat::replyImg($xmlOpj,$Wmaterial_id);
            $type = "image";    
            $media_id = $xmlOpj->MediaId; //获取mediaId
            Wechat::downloadImg($media_id,$type);
        }else if($xmlOpj->MsgType=="video"){
            $type = "video";    
            $media_id = $xmlOpj->MediaId; //获取mediaId
            Wechat::downloadImg($media_id,$type);
        }
    }
    /*
      array:16 [
        "subscribe" => 1
        "openid" => "om-z3we2J1YzOuQGjj1MIGu6OzOo"
        "nickname" => "攀峰"
        "sex" => 1
        "language" => "zh_CN"
        "city" => "张家口"
        "province" => "河北"
        "country" => "中国"
        "headimgurl" => "http://thirdwx.qlogo.cn/mmopen/uDnTunlpyEukgKsia1yR6MMEOibtYeCQNoPqFu5Yj3WBsgFfibibwXqwk7michibMa8T8t8hOuVJqOTu3vpmwwE3I2YB1EdYv4Rdua/132"
        "subscribe_time" => 1578381304
        "remark" => ""
        "groupid" => 0
        "tagid_list" => []
        "subscribe_scene" => "ADD_SCENE_QR_CODE"
        "qr_scene" => 0
        "qr_scene_str" => ""
        ] */ 
        /*
        <xml><ToUserName><![CDATA[gh_868ca46e0392]]></ToUserName>
        <FromUserName><![CDATA[om-z3we2J1YzOuQGjj1MIGu6OzOo]]></FromUserName>
        <CreateTime>1578381304</CreateTime>
        <MsgType><![CDATA[event]]></MsgType>
        <Event><![CDATA[subscribe]]></Event>
        <EventKey><![CDATA[]]></EventKey>
        </xml>
        */
        /*
        <xml><ToUserName><![CDATA[gh_868ca46e0392]]></ToUserName>
        <FromUserName><![CDATA[om-z3we2J1YzOuQGjj1MIGu6OzOo]]></FromUserName>
        <CreateTime>1578382238</CreateTime>
        <MsgType><![CDATA[event]]></MsgType>
        <Event><![CDATA[subscribe]]></Event>
        <EventKey><![CDATA[qrscene_11011]]></EventKey>
        <Ticket><![CDATA[gQGd7zwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyQ25IV1Y2cklmVDExN3lKdHh1Y1EAAgRiMxReAwSAOgkA]]></Ticket>
    </xml>
        */
}
