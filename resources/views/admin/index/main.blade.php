<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"><link rel="icon" href="https://jscdn.com.cn/highcharts/images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            
            
        </style>
        <link href="/static/admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
        <link href="/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="/static/admin/css/animate.css" rel="stylesheet">
        <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
        <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
        <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
        <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
    </head>
    <body>
        <form>
            城市：<input type="text" id='str' placeholder='请输入查询城市' class="input-sm form-control">
            <input type="button" id='btn' value='筛选' class="btn btn-sm btn-primary">
        </form>
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        
        <script>
      
        </script>
    </body>
</html>
<script src="/jq.js"></script>
<script>
    $(function(){
        var str = $("#str").val();
            if(str==''){
                str="北京";
            }
            $.get(
                "{{url('admin/weather')}}",
                {str:str},
                function(res){ 
                    var week = res[0].split(',');
                    var temperature = res[1];
                        $.each(temperature,function(i,v){
                        temperature[i][0] = parseInt(v[0])
                        temperature[i][1] = parseInt(v[1])
                      })
                    var atr = res[2]
                    getWeather(week,temperature,atr)    
                },'json'
            )    
        
        $(document).on('click','#btn',function(){
            var str = $("#str").val();
            if(str==''){
                str="北京";
            }
            $.get(
                "{{url('admin/weather')}}",
                {str:str},
                function(res){
                    var temperature = res[1];
                      $.each(temperature,function(i,v){
                        temperature[i][0] = parseInt(v[0])
                        temperature[i][1] = parseInt(v[1])
                      })
                    var week = res[0].split(',');
                    var atr = res[2]
                    //getWeather(week,newArray,atr)    
                    getWeather(week,temperature,atr)    
                },'json'
            )
        });
        function getWeather(week,temperature,atr)
        {
                
            var chart = Highcharts.chart('container', {
                    chart: {
                        type: 'columnrange', // columnrange 依赖 highcharts-more.js
                        inverted: true
                    },
                    title: {
                        text: '每天温度变化范围'
                    },
                    subtitle: {
                        text: atr
                    },
                    xAxis: {
                        categories: week
                    },
                    yAxis: {
                        title: {
                            text: '温度 ( °C )'
                        }
                    },
                    tooltip: {
                        valueSuffix: '°C'
                    },
                    plotOptions: {
                        columnrange: {
                            dataLabels: {
                                enabled: true,
                                formatter: function () {
                                    return this.y + '°C';
                                }
                            }
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: '温度',
                        //data: [ [-4,6],[-7,2],[-6,3],[-6,2],[-9,1],[-6,3],[-5,0]]
                        data: temperature
                    }]
            });
        } 
    })
</script>