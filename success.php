<?php

$ids = trim($_GET['ids'] , "|");

$idsArr = explode('|' , $ids);

$id = array();
for($i=0; $i<count($idsArr) ; $i++){
  $elArr = explode('-' , $idsArr[$i] );
  $id[] = $elArr[2];
}

// 构造协程环境，将数据保存到redis
http_post($id,'http://IP:Port');

function http_post($data,$url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $res = curl_exec($ch);
  curl_close($ch);
  return $res;
}

?>
<!DOCTYPE html>
<html>
 <head> 
  <meta charset="utf-8" /> 
  <meta name="viewport" content="width=device-width; initial-scale=1.0" /> 
  <title>订单支付完成</title> 
  <meta name="keywords" content="jQuery,选座" /> 
  <link href="css/style.css" rel="stylesheet" type="text/css" /> 
 </head> 
 <body> 
  <div id="main"> 

    <a href="index.php?status=success">订单支付完成，订票成功，点击返回首页</a>
  </div> 

</script>  
 </body>
</html>