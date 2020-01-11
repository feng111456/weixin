<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Model\Chandel as ch_model;
class Channel extends Controller
{
    /**
     * Display a listing of the resource.
     * 渠道展示列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channelInfo  = ch_model::get();
        return view('admin/channel/index',['channelInfo'=>$channelInfo]);
    }
    /**渠道图标 */
    public function icon(){
        $channelInfo  = ch_model::select('c_name','man')->get();
        $c_name = '';
        $man  = '';
        foreach($channelInfo as $v){
            $c_name .="'".$v->c_name."',"; 
            $man  .=$v->man.',';
        }
        $c_name = substr($c_name,0,-1);
        $man = substr($man,0,-1);

        return view('admin/channel/icon',['c_name'=>$c_name,'man'=>$man]);   
    }
    /**
     * Show the form for creating a new resource.
     *    展示渠道添加视图
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/channel/create');
    }

    /**
     * Store a newly created resource in storage.
     * 渠道添加执行
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $ticket = Wechat::getTicket($data['c_iden']);
        $data['ticket'] = $ticket;
        $data['add_time']=time();
        //dd($data);
        $res= ch_model::create($data);
        if($res){
            echo "<script>alert('成功');location.href='/channel/index'</script>";
        }else{
            echo "<script>alert('失败');location.href='/channel/create'</script>";
        }
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
