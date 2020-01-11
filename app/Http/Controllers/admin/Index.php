<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Index extends Controller
{
    /**微信后台首页 */
    public function index()
    {
        return view('admin/index/index');
    }
    public function main()
    {
        return view('admin/index/main');
    }
    /**获取天气 */
    public function weather()
    {
        $str =request()->str;
        $url = "http://api.k780.com/?app=weather.future&weaid=".$str."&&appkey=47852&sign=39260a41c7bcbbcf2e808818e64684c7&format=json ";	
		$data = file_get_contents($url);
        $data = json_decode($data,true);

    
        $week = '';
        $temperature = "";

        $t1 = [];
        foreach($data['result'] as $k=>$v){
            $week .=$v['week'].",";
            $temperature .=$v['temp_low'].",".$v['temp_high']."|";
            $t1[$k][] = $v['temp_low'];
            $t1[$k][] = $v['temp_high'];
        }
        //dd($t1);
        $week = rtrim($week,',');
        $temperature = rtrim($temperature,'|');

       // echo json_encode([$week,$temperature,$str]);
        echo json_encode([$week,$t1,$str]);

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
