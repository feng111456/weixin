<?php

namespace App\Http\Controllers\admin;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Area;
use App\Model\User;
class Admin extends Controller
{
    //展示
    public function index()
    {
        $account = request()->account;
        $province = request()->province;
        $city = request()->city;
        $district = request()->district;
        $where = [];
        if($account){
            $where[] = ['account','like',"%$account%"];
        }
        if(!empty($province)){
            $where[] = ['province','=',$province];
        }
        if(!empty($city)){
            $where[] = ['city','=',$city];
        }
        if(!empty($district)){
            $where[] = ['district','=',$district];
        }
        //实例化省市区model 
        $area_model = new Area;
        $provinceInfo =$this-> getArea(); 
        //实例化用户model 
        $user_model = new User;
        $userInfo = $user_model::where($where)->get();
        foreach($userInfo as $k=>$v){
            $userInfo[$k]->province = Area::where('id','=',$v->province)->value('name');
            $userInfo[$k]->city = Area::where('id','=',$v->city)->value('name');
            $userInfo[$k]->district = Area::where('id','=',$v->district)->value('name');
        }
        return view('admin.admin.index',['userInfo'=>$userInfo,'provinceInfo'=>$provinceInfo]);
    }
    /**获取下拉菜单的id */
    function getIdInfo(){
        $id = request()->_id;
        $info = $this->getArea($id);
        return $info;
    }
    //获取下拉菜单信息
    function getArea($p_id=0){
        //实例化省市区model 
        $area_model = new Area;
        $Info =$area_model::where('pid','=',$p_id)->get();
        return $Info;
    }
    function paixu()
    {
        $value = request()->_value;
        //-------------------------
        $account = request()->account;
        $province = request()->province;
        $city = request()->city;
        $district = request()->district;
        $where = [];
        if($account){
            $where[] = ['account','like',"%$account%"];
        }
        if(!empty($province)){
            $where[] = ['province','=',$province];
        }
        if(!empty($city)){
            $where[] = ['city','=',$city];
        }
        if(!empty($district)){
            $where[] = ['district','=',$district];
        }
        //实例化省市区model 
        $area_model = new Area;
        $provinceInfo =$this-> getArea(); 
        //实例化用户model 
        $user_model = new User;
        $userInfo = $user_model::where($where)->orderBy('add_time',$value)->get();
        foreach($userInfo as $k=>$v){
            $userInfo[$k]->province = Area::where('id','=',$v->province)->value('name');
            $userInfo[$k]->city = Area::where('id','=',$v->city)->value('name');
            $userInfo[$k]->district = Area::where('id','=',$v->district)->value('name');
        }
        return view('admin.admin.div',['userInfo'=>$userInfo,'provinceInfo'=>$provinceInfo]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
