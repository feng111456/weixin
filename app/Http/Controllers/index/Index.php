<?php

namespace App\Http\Controllers\index;
use App\Model\Area;
use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Index extends Controller
{
    /**用户列表展示 */
    function index()
    {

    }
    /**用户注册 */
    function register()
    {
        //查询所有省分信息
        //实例化省市区model 
        $area_model = new Area;
        $provinceInfo =$this-> getArea(); 
        return view('index/index/register',['provinceInfo'=>$provinceInfo]);
    }
    /**用户注册执行 */
    function registerDo()
    {
        //接收数据
        $data = request()->except('_token');
        $data['add_time']=time();
        //实例化用户model 
        $user_model = new User;
        $res = $user_model::create($data);
        if($res){
            echo "<script>alert('成功');location.href='/admin/index'</script>";
        }else{
            echo "<script>alert('失败');location.href='index/register'</script>";
        }
    }
    /**获取下拉菜单的id */
    function getIdInfo(){
        $id = request()->_id;
        $info = $this->getArea($id);
        return $info;
    }
    //获取下拉菜单信息
    function getArea($p_id=0)
    {
        //实例化省市区model 
        $area_model = new Area;
        $Info =$area_model::where('pid','=',$p_id)->get();
        return $Info;
    }
    function checkAccount()
    {
        //实例化用户model 
        $user_model = new User;
        $account = request()->account;
        $count  = $user_model::where('account','=',$account)->count();
        if($count>0){
            echo 1;
        }else{
            echo 2;
        }
    }
    function paixu()
    {

    }
}
