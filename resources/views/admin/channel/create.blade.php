<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 基本表单</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/static/admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/static/admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/static/admin/css/animate.css" rel="stylesheet">
    <link href="/static/admin/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h4>渠道管理</h4> 
                    </div>
                    <div class="ibox-content">
                            <h2 align='center'><b>渠道添加</b></h2>
                        <form method="post" class="form-horizontal" action="{{url('channel/store')}}" >
                            <div class="form-group">
                                @csrf
                                <label class="col-sm-2 control-label">渠道名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="c_name">
                                </div>
                            </div>
                            @csrf
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">渠道标识</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="c_iden">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    
                                </div>
                                    <button type="submit" class="btn btn-w-m btn-success">渠道添加</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    
    

</body>

</html>
