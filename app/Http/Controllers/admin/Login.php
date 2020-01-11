<?php

namespace App\Http\Controllers\admin;
use App\Model\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Login extends Controller
{
    //登录视图
    function login(){
        return view('admin/index/login');
    }
    /** 登录执行页面 */
    function loginDo(){
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
}
