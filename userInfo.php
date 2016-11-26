<?php

class UserInfo
{


// curl封装 http get 请求
    public static function curlGet($url)
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

// 获取access_token、open_id、用户信息
    public static function getAccessTokenToUserInfo($code)
    {
        $appid='wx06608e028585cb9c';
        $appsecret = 'ff1425e77e6062442a9c579c6d850fd1';

        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
        $data = self::curlGet($url);

        $user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$data['access_token']}&openid={$data['openid']}&lang=zh_CN";
        $user_info = self::curlGet($user_info_url);

        return array_merge($data, $user_info);

    }

    //用户同意授权，获取code，跳转到首页
    public static function getCode(){
        $appid='wx06608e028585cb9c';
        $redirectUri = urlencode('http://wx.aaysf.com/nhfh/index.php');
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirectUri}&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";

        header('location:' . $url);
    }


    //用户同意授权，获取code,跳转到分享者页面
    public static function getHerCode($shareId){
        $appid='wx06608e028585cb9c';
        $redirectUri = urlencode('http://wx.aaysf.com/nhfh/giveHerBullets.php?shareId='.$shareId);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirectUri}&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";

        header('location:' . $url);
    }


}