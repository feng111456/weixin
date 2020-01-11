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
                            <div class="col-sm-5 m-b-xs">
                                <select class="input-sm form-control input-s-sm inline">
                                    <option value="0">请选择</option>
                                    <option value="1">选项1</option>
                                    <option value="2">选项2</option>
                                    <option value="3">选项3</option>
                                </select>
                            </div>
                            <div class="col-sm-4 m-b-xs">
                                <div data-toggle="buttons" class="btn-group">
                                    <label class="btn btn-sm btn-white">
                                        <input type="radio" id="option1" name="options">天</label>
                                    <label class="btn btn-sm btn-white active">
                                        <input type="radio" id="option2" name="options">周</label>
                                    <label class="btn btn-sm btn-white">
                                        <input type="radio" id="option3" name="options">月</label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入关键词" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                                <h2 align='center'>素材展示</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>素材编号</th>
                                        <th>素材名称</th>
                                        <th>素材格式</th>
                                        <th>素材展示</th>
                                        <th>media</th>
                                        <th>添加时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materialInfo as $v)
                                    <tr>
                                        <td>{{$v->material_id}}</td>
                                        <td>{{$v->material_name}}</td>
                                        <td>{{$v->material_type==1?'临时':'永久'}}</td>
                                        <td>
                                            @if($v->material_format=='image')
                                            <img src="\{{$v->file_url}}" width='120px'>
                                            @elseif($v->material_format=='voice')
                                            <audio src="\{{$v->file_url}}" width='120' controls="controls"></audio>
                                            @elseif($v->material_format=='video')
                                            <video src="\{{$v->file_url}}" width="200px" controls="controls"></video>
                                            @endif
                                        </td>
                                        <td>{{$v->Wmaterial_id}}</td>
                                        <td>{{date('y-m-d h:i:s',$v->add_time)}}</td>        
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