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
                        <h5>渠道管理</h5>
                       
                    </div>
                    <div class="ibox-content">
                        
                        <div class="table-responsive">
                                <h2 align='center'>渠道展示</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>渠道编号</th>
                                        <th>渠道名称</th>
                                        <th>渠道标识</th>
                                        <th>渠道二维码</th>    
                                        <th>关注人数</th>
                                        <th>添加时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($channelInfo as $v)
                                    <tr>
                                        <td>{{$v->c_id}}</td>
                                        <td>{{$v->c_name}}</td>
                                        <td>{{$v->n_iden}}</td>
                                        <td><img src="{{$v->ticket}}" width='80px'></td>
                                        <td>{{$v->man}}</td>
                                        <td>{{date('Y-m-d h:i:s',$v->add_time)}}</td>
                                        <td><a class="btn btn-danger btn-rounded" href="{{url('channel/destroy/'.$v->n_id)}}">删除</a>
                                        <a class="btn btn-info btn-rounded" href="{{url('channel/edit/'.$v->n_id)}}">修改</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>