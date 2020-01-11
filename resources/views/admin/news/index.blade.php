<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 基础表格</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/static/admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/static/admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/static/admin/css/animate.css" rel="stylesheet">
    <!-- <link href="/static/admin/css/style.css?v=4.1.0" rel="stylesheet"> -->

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>素材管理</h5>
                       
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <form>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" placeholder="请输入标题关键词" class="input-sm form-control" name='n_title' value="{{request()->n_title}}">
                                        <input type="text" placeholder="请输入作者名称" class="input-sm form-control" name='n_author' value="{{request()->n_author}}">       
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> 
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                                <h2 align='center'>素材展示</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>新闻编号</th>
                                        <th>新闻标题</th>
                                        <th>新闻作者</th>
                                        <th>新闻内容</th>    
                                        <th>添加时间</th>
                                        <th>访问量</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($newsInfo as $v)
                                    <tr>
                                        <td>{{$v->n_id}}</td>
                                        <td>{{$v->n_title}}</td>
                                        <td>{{$v->n_author}}</td>
                                        <td>{{$v->n_content}}</td>
                                        <td>{{date('Y-m-d h:i:s',$v->add_time)}}</td>
                                        <td>{{$v->n_pv}}</td>
                                        <td><a class="btn btn-danger btn-rounded" href="{{url('news/destroy/'.$v->n_id)}}">删除</a>
                                        <a class="btn btn-info btn-rounded" href="{{url('news/edit/'.$v->n_id)}}">修改</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                            {{ $newsInfo->appends($query)->links()}}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>