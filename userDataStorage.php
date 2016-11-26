<?php
class UserDataStorage{
    const HOST='127.0.0.1';
    const SLAVE='r.rdc.sae.sina.com.cn';
    const USER='root';
    const PASSWORD='EJnMMWd23LLXYX8S';
    const DATABASE='app_nhfh';
    const PORT=3306;

function sqlConnect($host=self::HOST,$user=self::USER,$password=self::PASSWORD,$database=self::DATABASE,$port=self::PORT){
    $link=mysqli_connect($host,$user,$password,$database,$port);
    if (!$link) {
        die("连接失败" . mysqli_connect_error());
    } else {



    }

    return $link;





}

//存储用户数据，如头像，性别，省份，城市等
function storeUserData(array $data){

    $exist=$this->findUser($data['openid']);

    $link=$this->sqlConnect();
    mysqli_query($link,'set names utf8');
    $updated=time();
	
	//可能有特殊字符存不进去 ，乱码问题
	//$nickname=json_encode($data['nickname']);
	$nickname=$data['nickname'];
	
    if($exist){

        $sql="UPDATE `user` SET nickname='".$nickname."',sex='".$data['sex']."',province='".$data['province']."',city='".$data['city']."',country='".$data['country']."',headimgurl='".$data['headimgurl']."',updated='".$updated."' where openid='".$data['openid']."';";
    }else{
        $sql="insert into `user`(openid,nickname,sex,province,city,country,headimgurl,updated) VALUES ('".$data['openid']."','".$data['nickname']."','".$data['sex']."','".$data['province']."','".$data['city']."','".$data['country']."','".$data['headimgurl']."','".$updated."')";
    }

    $res=mysqli_query($link,$sql);
    mysqli_close($link);
    return $res;

}

//查询微信用户表里是否已经授权过
function findUser($openid){
    $link=$this->sqlConnect();
    mysqli_query($link,'set names utf8');
    $sql="select openid from `user` WHERE openid='{$openid}'";
    $res=mysqli_query($link,$sql);

    mysqli_close($link);
    if($res->num_rows){

        return true;
    }

    return false;


}

//

}




































