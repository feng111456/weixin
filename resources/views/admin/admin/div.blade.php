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