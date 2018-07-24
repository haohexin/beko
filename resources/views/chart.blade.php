<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>冷干机改版图表</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/echarts/4.1.0.rc2/echarts.min.js"></script>
</head>

<body>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="width: 400px;height:400px;"></div>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    var colors = [];
    // 指定图表的配置项和数据
    var option = {
        color: colors,
        left: 'center',

        tooltip: {
            trigger: 'axis', //坐标轴触发
            axisPointer: {
                type: 'cross'
            }
        },
        grid: {
            right: '30%'
        },
        toolbox: {
            feature: {
                dataView: {
                    show: true,
                    readOnly: false
                },
                restore: {
                    show: true
                },
                saveAsImage: {
                    show: true
                }
            }
        },
        dataZoom: [{ // 这个dataZoom组件，默认控制x轴。
            type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
            start: 10, // 左边在 10% 的位置。
            end: 60 // 右边在 60% 的位置。
        },
            { // 这个dataZoom组件，也控制x轴。
                type: 'inside', // 这个 dataZoom 组件是 inside 型 dataZoom 组件
                start: 10, // 左边在 10% 的位置。
                end: 60 // 右边在 60% 的位置。
            }
        ],
        legend: {
            data: []
        },
        xAxis: [{
            type: 'category',
            axisTick: {
                alignWithLabel: true
            },
            data: []
        }],
        yAxis: [],
        series: []
    };


    $.ajax({
        type: "post",
        url: "http://106.14.34.94/?r=runtime/get-runtime-data",
        data: {
            start_time: 1529362800,
            end_time: 1529808884,
            device_id: 87
        },
        cache: false,
        async: false,
        dataType: 'json',
        success: function (data) {
            setData(data);
        },
        error: function (data) {
        }
    });

    function setData(data) {
        // legend
        var legend = data.legend;
        option.legend.data = legend;
        // series
        var series = data.series;
        for (var i = 0; i < series.length; i++) {
            option.series.push(series[i]);
        }
        // xais
        var xais = data.xAxis;
        option.xAxis[0].data = xais;
        // yaxis
        var yais = data.yAxis;
        // color
        colors = data.color;
        option.color = data.color;
        //right_per
        option.grid.right = data.right_per;
        for (var i = 0; i < yais.length; i++) {
            var item = {};
            item.type = 'value';
            item.position = (i == 0 ? 'left' : 'right');
            item.offset = (i == 0 ? 0 : i * 60);
            item.name = yais[i].title;
            item.min = parseInt(yais[i].min);
            item.max = parseInt(yais[i].max);
            item.axisLine = {
                lineStyle: {
                    color: colors[i]
                }
            };
            item.axisLabel = {
                formatter: '{value} ' + yais[i].unit
            };
            option.yAxis.push(item);
        }
        myChart.setOption(option);

        //用于使chart自适应高度和宽度
        window.onresize = function () {
            //重置容器高宽
            resizeWorldMapContainer();
            myChart.resize();
        };
    }
</script>
</body>

</html>
