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
                        <h4>新闻管理</h4> 
                    </div>
                    <div class="ibox-content">
                            <h2 align='center'><b>新闻修改</b></h2>
                        <form method="post" class="form-horizontal" action="{{url('news/update/'.$newsInfo->n_id)}}" enctype='multipart/form-data'>
                            <div class="form-group">
                                @csrf
                                <label class="col-sm-2 control-label">新闻标题</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="n_title" value="{{$newsInfo->n_title}}">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">新闻作者</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="n_author" value="{{$newsInfo->n_author}}">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">新闻内容</label>

                                <div class="col-sm-10">
                                    <textarea name="n_content"  cols="140" rows="5">{{$newsInfo->n_content}}</textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    
                                </div>
                                    <button type="submit" class="btn btn-w-m btn-success">新闻修改</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    
    

</body>

</html>
