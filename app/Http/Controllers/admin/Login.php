<?php

namespace App\Http\Controllers\admin;
use App\Model\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
class Login extends Controller
{
    //登录视图
    function login()
    {
        return view('admin/index/login');
    }
    /** 登录执行页面 */
    function loginDo()
    {
        $email = request()->email;
        $pwd  = request()->pwd;
        $adminInfo = Admin::where('email','=',$email)->first();
       //dd(time()-$adminInfo->last_time>=600); die;
        if($adminInfo){
            //账号正确
            if($pwd==$adminInfo['pwd']){
                //密码正确
                if($adminInfo->degree>=3&&time()-$adminInfo->last_time<3600){
                    die ("<script>alert('账号已锁定！请与".(60-ceil((time()-$adminInfo->last_time)/60))."分钟后登录！');location.href='/admin/login';</script>");
                }
                Admin::where('email','=',$email)->update(['degree'=>0,'last_time'=>null]);
                echo "<script>alert('登录成功');location.href='/admin/indexs'</script>";
            }else{
                //密码错误
                if(time()-$adminInfo->last_time>=3600){
                    $res = Admin::where('email','=',$email)->update(['degree'=>1,'last_time'=>time()]);
                    if($res){
                        die ( "<script>alert('账号或密码有误,还有2次机会');location.href='/admin/login';</script>");
                    }
                }
                if($adminInfo->degree>=3){
                    die ("<script>alert('账号已锁定！请与".(60-ceil((time()-$adminInfo->last_time)/60))."分钟后登录！');location.href='/admin/login';</script>");
                }else{
                    
                    $res = Admin::where('email','=',$email)->update(['degree'=>$adminInfo->degree+1,'last_time'=>time()]);
                    if($adminInfo->degree+1>=3){
                        
                        die ("<script>alert('账号或密码有误!已锁定请与1小时候登录');location.href='/admin/login';</script>");
                    }else{
    
                        die ("<script>alert('账号或密码有误，还有".(3-($adminInfo->degree+1))."次机会！');location.href='/admin/login';</script>");
                    }
                }    
            }
        }else{
            //账号错误
            echo "<script>alert('账号或密码有误');location.href='/admin/login';</script>";
        }
    }
    /**获取验证码 */
    function getCode()
    {
        $email = request()->email;
        $pwd = request()->pwd;
        //根据账号查询表中对应的openid
        $where = [
            'email'=>$email,
            'pwd'=>$pwd,
        ];
        $adminInfo = Admin::select('openid')->where($where)->first()->toArray();
        $openid = $adminInfo['openid'];
        $code = rand(100000,999999);
        $this->sendCode($openid,$email,$code);
    }
    public function sendCode($openid,$email,$code)
    {   
        //获取token 
        $access_token =Wechat::GetToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token ;
        $array = [
            'touser'=>$openid,
            'template_id'=>"mloYmqhnAXpKqvBuRRv5vjVAISibFz-5xE04Hsr8QNs",
            'data'=>[
                'email'=>[
                        "value"=>$email,
                        "color"=>"#173177"
                ],
                'code'=>[
                        "value"=>$code,
                        "color"=>"#173177"
                ],
            ],
        ];
        $array = json_encode($array,JSON_UNESCAPED_UNICODE);
        $res=Curl::Curl_post($url,$array);
        $res = json_decode($res,true);
        if($res['errcode']==0){
            echo "发送成功";
        }else{
            echo '发送失败';
        }
    }
}
