<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/static/admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/static/admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="/static/admin/css/animate.css" rel="stylesheet">
    <link href="/static/admin/css/style.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">h</h1>

            </div>
            <h3>欢迎使用 hAdmin</h3>

            <form class="m-t" role="form" action="{{url('admin/loginDo')}}" method='post' id='myform'>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="用户名" required="" name='email' id='email'>
                </div>
                @csrf
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="密码" required="" name='pwd' id="pwd">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="验证码" required="" name='code' id='code'>
                    <button type="button" id='getCode' class="btn btn-primary block full-width m-b">获取验证码</button>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登录</button>


                <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
                </p>

            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
</body>
</html>
<script src='/jq.js'></script>
<script>
    $(function(){
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $(document).on('submit','#myform',function(){
            return false;
        })
        $(document).on('click','#getCode',function(){
            var email = $("#email").val();
            var pwd = $("#pwd").val();
                $.ajax({
                    method:"POST",
                    data:{email:email,pwd:pwd},
                    url:"{{url('/admin/getCode')}}",
                }).done(function(res){
                    alert(res);
                })
        });

    })
</script>