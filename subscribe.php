<?php
// curl封装 http get 请求
function curlGet($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 这个是重点 请求https。
    $data = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($data, true);
    return $data;
}

//whether subscribe this wechat!
function attention($openid)
{
    $appid = 'wx06608e028585cb9c';
    $appsecret = 'ff1425e77e6062442a9c579c6d850fd1';
    $access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
    $access_msg=curlGet($access_token);



    $token = $access_msg['access_token'];
    $subscribe_msg = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$token}&openid={$openid}";
    $subscribe = curlGet($subscribe_msg);
    $attention = $subscribe['subscribe'];


    $jump=($attention === 1)?true:false;
    return $jump;

   /* header("Location:http://mp.weixin.qq.com/s?__biz=MzA3NDE1Njc1OQ==&mid=209398002&idx=1&sn=e5db499b5f5c56a939d675de103901a2#rd");*/


}


