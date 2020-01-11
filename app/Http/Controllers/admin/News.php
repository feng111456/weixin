<?php

namespace App\Http\Controllers\admin;
use App\Model\News as news_model;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class News extends Controller
{
    /**新闻展示页面 */
    public function index()
    {
        //接收表单值写where条件
        $n_title = request()->n_title;
        $n_author= request()->n_author;
        $where = [];
        if(!empty($n_title)){
            $where[] =[
                'n_title','like',"%$n_title%"
            ]; 
        }
        if(!empty($n_author)||$n_author=='0'){
            $where[] =[
                'n_author','=',$n_author
            ]; 
        }

        //查询表中所有数据展示
        $newsInfo = news_model::where($where)->paginate(5);
        $query = request()->all();
        return view('admin/news/index',['newsInfo'=>$newsInfo,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *  新闻添加页面视图
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/news/create');
    }

    /**
     * Store a newly created resource in storage.
     *  新闻添加执行
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //接收表单值
        $data  = $request->except('_token');
        $data['add_time'] = time();
        $res = news_model::create($data);
        if($res){
            echo "<script>alert('成功');location.href='/news/index'</script>";
        }else{
            echo "<script>alert('失败');location.href='/news/create'</script>";
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
        //查询表中所有数据展示
        $newsInfo = news_model::find($id);
        return view('admin/news/edit',['newsInfo'=>$newsInfo]);
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
        //接收表单值
        $data  = $request->except('_token');
        $data['add_time'] = time();
        $res = news_model::where('n_id','=',$id)->update($data);
        if($res!==false){
            echo "<script>alert('成功');location.href='/news/index'</script>";
        }else{
            echo "<script>alert('失败');location.href='/news/edit/'"+$id+"</script>";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = news_model::destroy($id);
        if($res){
            echo "<script>alert('成功');location.href='/news/index'</script>";
        }else{
            echo "<script>alert('失败');location.href='/news/index'</script>";
        }
    }
}
