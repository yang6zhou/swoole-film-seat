<?php

$server = new Swoole\WebSocket\Server('0.0.0.0' , 8888);


// 多端口监听，http服务，提供协程环境
$http = $server->listen('0.0.0.0' , 9999 , SWOOLE_SOCK_TCP);

// 协程环境，将数据保存到redis
$http->on("request" , function($request , $response){

    $data = $request->post;
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1' , 6379);
    
    foreach($data as $v){
        $redis->lpush("cjh" , $v);
    }

});



$server->on("open" , function($serv , $request){
    // $serv->push( $request->fd , "欢迎购票！");
});

$server->on("message" , function($serv , $frame){
    $data = $frame->data;
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1' , 6379);
    $resdata = $redis->lrange("cjh" , 0 , -1);
    // 如果是支付完成，给所有连接发送数据
    if($data == "success"){
        // 发送消息，通知所有客户端
        foreach($serv->connections as $fd){
            $serv->push($fd , json_encode($resdata));
        }
    }else{
        // 否则，只发送给当前连接
        $serv->push($frame->fd , json_encode($resdata));
    }
});

$server->start();

?>