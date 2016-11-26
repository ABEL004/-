<?php
if(empty($_COOKIE['openid'])){
    if(!empty($_GET['code'])){
        require_once 'userInfo.php';
        require_once 'userDataStorage.php';


        $code=$_GET['code'] ;
        $data=UserInfo::getAccessTokenToUserInfo($code);
        $userDataStorage=new UserDataStorage();
        $userDataStorage->storeUserData($data);
        setcookie('openid',$data['openid'],time()+720000);
        require_once 'db/db.php';
        //cookie已经存在
		
		//cookie已经存在,但是还不能得到，须刷新跳转一次才能获得

   
        //查询是否已经生成过特种兵档案
        $shareId=$data['openid'];
        $db=new DB();
        $exist=$db->checkOpenid($shareId);

        if($exist){
            //直接跳转到给自己送子弹页面
            header("Location:giveMeBullets.php?shareId=".$shareId);
        }

    } else {
        require_once 'userInfo.php';

        UserInfo::getCode();

    }


}else{
    
    //cookie已经存在
	
		
		require_once 'db/db.php';

    //查询是否已经生成过特种兵档案
    $shareId=$_COOKIE['openid'];
    $db=new DB();
    $exist=$db->checkOpenid($shareId);
    if($exist){
        //直接跳转到给自己送子弹页面
        header("Location:giveMeBullets.php?shareId=".$shareId);
    }



}
