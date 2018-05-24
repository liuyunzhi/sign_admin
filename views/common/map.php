<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>鼠标拾取地图坐标</title>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
    <script type="text/javascript"
            src="http://webapi.amap.com/maps?v=1.4.6&key=66d76ee515740eb05b17dcc40cbcce83&plugin=AMap.Autocomplete"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
</head>
<body>
<div id="container"></div>
<script type="text/javascript">
    var map = new AMap.Map("container", {
        resizeEnable: true,
        center: [104.147231,30.675778],
        zoom: 15
    });
    map.setDefaultCursor("crosshair");
    AMap.plugin(['AMap.ToolBar','AMap.Scale','AMap.OverView'],function(){
        map.addControl(new AMap.ToolBar());
        map.addControl(new AMap.Scale());
        map.addControl(new AMap.OverView({isOpen:true}));
    });
    //为地图注册click事件获取鼠标点击出的经纬度坐标
    var clickEventListener = map.on('click', function(e) {
        selected(e.lnglat.getLng(), e.lnglat.getLat());
    });
    //给父页面传值
    function selected(longitude, latitude){
        var index = parent.layer.getFrameIndex(window.name);
        parent.$('#longitude').val(longitude);
        parent.$('#latitude').val(latitude);
        parent.layer.close(index);
    }
</script>
</body>
</html>