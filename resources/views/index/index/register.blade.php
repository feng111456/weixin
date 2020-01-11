<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
        <h2>用户注册</h2>
            <form action="{{url('index/registerDo')}}" method='post'>
                <table>
                    用户名：<input type="text" name='account' id='account'><br>
                    密码 ：<input type="password" name='pwd'><br>
                        @csrf
                    省份：<select name="province" class='set'>
                            <option value="">--请选择--</option>
                            @foreach($provinceInfo as $v)
                            <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    市：<select name="city" class='set'>
                            <option value="">--请选择--</option>            
                        </select>
                    区/县：<select name="district" class='set'>
                            <option value="">--请选择--</option>
                        </select><br>
                        <input type="submit" value='注册'>
                </table>
            </form>
</body>
</html>
<script src='/jq.js'></script>
<script>
        $(function(){
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            /** 账号栏失去焦点 */
            $(document).on('blur','#account',function(){
                var account =$('#account').val();
                if(account==''){
                    alert('账号必填');
                }else{
                    $.post(
                        "{{url('index/checkAccount')}}",
                        {account:account},
                        function(res){
                            if(res==1){
                                alert('账号已存在')
                            }
                        }   
                    )  
                }
            })
            /**下拉菜单绑定内容改变 */
            $(document).on('change','.set',function(){
                var _this = $(this);
                var _id = _this.val();
                $.post(
                    "{{url('index/getIdInfo')}}",
                    {_id:_id},
                    function(res){
                        //console.log(res);
                        var _option = "<option value=''>--请选择--</option> ";
                        for(var i in res){
                          _option+="<option value='"+res[i].id+"'>"+res[i].name+"</option>";
                        }
                        //console.log(_option);
                        _this.next('select').html(_option);       
                    }
                ) 
            })
        })
        
   
</script>