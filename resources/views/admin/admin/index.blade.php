<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/status/css/bootstrap.min.css">  
	<script src="/status/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
    <h2>用户列表展示</h2>
    <form action="">
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
                    <input type="text" name='k_time' value='开始时间'>--<input type="text" name='j_time' value='结束时间'>
                    <input type="text" name='account'>  <input type="submit" value='搜索'>
    </form>
        <div id='list'>
        <table border='1'  id='table' class="table table-striped">
            <tr>
                <td>序号</td>
                <td>用户名</td>
                <td>省份</td>
                <td>市</td>
                <td>区</td>
                <td>注册时间</td>
            </tr>
            @foreach($userInfo as $v)
            <tr>
                <td>{{$v->user_id}}</td>
                <td>{{$v->account}}</td>
                <td>{{$v->province}}</td>
                <td>{{$v->city}}</td>
                <td>{{$v->district}}</td>
                <td>{{date('Y-m-d h:i:s',$v->add_time)}}</td>
            </tr>
            @endforeach
        </table>
        </div>
        排序：<input type="button" value='↑' id='paixu'>
</body>
</html>
<script src='/jq.js'></script>
<script>
    $(function(){
        
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
            /**给排序按钮绑定点击事件 */
            $(document).on('click','#paixu',function(){
                var _this = $(this);
                var fuhao = _this.val();
                    if(fuhao=='↓'){
                        fuhao = '↑'
                        _value = 'asc'
                    }else{
                        fuhao = '↓'
                        _value = 'desc'
                    }
                    $.post(
                        "{{url('admin/paixu')}}",
                        {_value:_value},
                        function(res){
                            $("#list").html(res);
                            _this.val(fuhao);
                        }
                    )
            })
           
    })
</script>