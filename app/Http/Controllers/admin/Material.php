<?php

namespace App\Http\Controllers\admin;
use App\Model\Material as ma_model;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
class Material extends Controller
{
    /**素材展示*/
    public function index()
    {
        //查询表中数据
        $materialInfo = ma_model::get();
        return view('admin/material/index',['materialInfo'=>$materialInfo]); 
    }

    /**素材添加视图*/
    public function create()
    {
        return view('admin/material/create');
    }

    /**素材添加执行 */
    public function store(Request $request)
    {
        //接收表单数据
        $data  = $request->except('_token');
        //文件上传
        $file_url =$request->file('file_url');
        $ext=$file_url->getClientOriginalExtension();//获取文件后缀
        $fileName = MD5(uniqid()).".".$ext;
        $pach = $file_url->storeAs('img',$fileName);
        // $token = Wechat::GetToken();//获取token凭证
        // $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$token."&type=".$data['material_format'];
        // //处理图片路径
        // $filePach = new \CURLFile(public_path()."/".$pach);
        // $postData = ['media'=>$filePach];
        // $res = Curl::Curl_post($url,$postData);
        // $res = json_decode($res,true);
        $res = Wechat::getMediaId($data,$pach);
        $data['file_url']=$pach;
        $data['Wmaterial_id']=$res['media_id'];
        $data['add_time']=time();
        $res = ma_model::create($data);
        
        if($res){
            echo "<script>alert('成功');location.href='/material/index'</script>";
        }else{
            echo "<script>alert('失败');location.href='/material/create'</script>";
        }
    }
    /**添加菜单 */
    public function addMenu()
    {
        //获取token
        $token =Wechat::GetToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
        $menu = [
            "button"    => [
                [
                    "type"  => "click",
                    "name"  => "点我获取",
                    "key"   => "click_get"
                ],[
                    "name"=>"摄像头",
                    "sub_button"=>[
                        [  "type"=>"view",
                            "name"=>"百度一下啊",
                            "url"=>"http://www.baidu.com/"
                        ],[
                            "type"=> "scancode_push", 
                            "name"=> "扫一扫", 
                            "key"=>"Ewm", 
                        ],[
                        "type"=>"pic_sysphoto", 
                        "name"=>"拍照", 
                        "key"=>"photo", 
                        ]
                    ]
                ],[
                    "name"=> "分享位置", 
                    "type"=> "location_select", 
                    "key"=>"location" 
                ]
            ] 
        ];
       
        $json = json_encode($menu,JSON_UNESCAPED_UNICODE);
        $res =Curl::Curl_post($url,$json);
        dd($res);
    }
    // public function test()
    // {
    //     $appid = Wechat::appid;
    //     $redirect_uri = "urlEncode(1906zhangpanfeng.zsjshaojie.top/admin/getAuth)";
    //     $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect ";
    //     echo $url;die;
    //     $jsonInfo  = file_get_contents($url);
    //     $arr_jsonInfo = json_decode($jsonInfo);
    //     dd($arr_jsonInfo);
    // }
    //获取用户授权
    // public function getAuth()
    // {

    // }
    //加载保存用户发的文件
    // public function tiLoad()
    // {
    //     // $data = file_get_contents("php://input");
    // }
}
