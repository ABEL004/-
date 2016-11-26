<?php

class DB
{
    const HOST='127.0.0.1';
    const SLAVE='r.rdc.sae.sina.com.cn';
    const USER='root';
    const PASSWORD='EJnMMWd23LLXYX8S';
    const DATABASE='app_nhfh';
    const PORT=3306;

    function sqlConnect($host = self::HOST, $user = self::USER, $password = self::PASSWORD, $database = self::DATABASE, $port = self::PORT)
    {
        $link = mysqli_connect($host, $user, $password, $database, $port);
        if (!$link) {
            die("连接失败" . mysqli_connect_error());
        } else {

            return $link;

        }

    }

    //生成用户档案
    function generateFile($openid, $realname, $phone, $alias, $avatar)
    {
        $link = $this->sqlConnect();
        mysqli_query($link, 'set names utf8');
        $updated = time();
        $sql = "insert into `bullets`(openid,realname,phone,alias,avatar,updated) VALUES ('" . $openid . "','" . $realname . "','" . $phone . "','" . $alias . "','" . $avatar . "','" . $updated . "')";
        $res = mysqli_query($link, $sql);
        mysqli_close($link);
        return $res;

    }

    //给自己送子弹
    function giveMeBullet($openid)
    {
        if (!$this->checkOpenid($openid)) {
            return false;
        }
        $link = $this->sqlConnect();
        mysqli_query($link, 'set names utf8');
        $updated = time();
        $sql = "UPDATE `bullets` set bullet_me=bullet_me+10,bullets_sum=bullets_sum+10,me_updated={$updated},updated={$updated} WHERE openid='{$openid}'";
        $result = mysqli_query($link, $sql);
        mysqli_close($link);
        return $result;

    }

    //查询openid是否存在于bullets表中
    function checkOpenid($openid)
    {
        $link = $this->sqlConnect();
        mysqli_query($link, 'set names utf8');
        $sql = "select openid from `bullets` where openid='{$openid}'";
        $result = mysqli_query($link, $sql);
        mysqli_close($link);
        $res = $result->num_rows;
        return $res;

    }

    //查询子弹数目，用户档案
    function checkBullets($openid)
    {
        if (!$this->checkOpenid($openid)) {
            return false;
        }


        $link = $this->sqlConnect();
        mysqli_query($link, 'set names utf8');
        $sql = "select * from `bullets` WHERE openid='{$openid}' limit 1";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);


        mysqli_close($link);
        return $row;


    }

    //给她送子弹
    function giveHerBullets($myOpenid, $herOpenid)
    {
        if (!$this->checkOpenid($herOpenid)) {
            return false;
        }
        /*$link=$this->sqlConnect();
        mysqli_query($link,'set names utf8');*/

        $updated = time();
        $sql1 = "update `bullets` set bullets_sum=bullets_sum+10,updated={$updated} WHERE openid='{$herOpenid}';";

        //查询送子弹表里有无记录
        $record = $this->findRecord($myOpenid, $herOpenid);
        if ($record) {
            $sql2 = "update `give_bullets` set frequency=frequency+1,updated={$updated} WHERE openid='{$myOpenid}' AND to_openid='{$herOpenid}';";
        } else {
            $sql2 = "insert into `give_bullets`(`openid`,`to_openid`,`frequency`,`updated`) VALUES ('" . $myOpenid . "','" . $herOpenid . "','1','" . $updated . "');";
        }

        //启动事务
        $link = new mysqli(self::HOST, self::USER, self::PASSWORD, self::DATABASE);
        $link->query("set names utf8");
        $link->autocommit(FALSE);

        $res1 = $link->query($sql1);
        $res2 = $link->query($sql2);

        if ($res1 && $res2) {
            $link->commit();
            return true;
        } else {
            $link->rollback();
            return false;
        }


    }

    //查询送子弹表里有无记录
    function findRecord($myOpenid, $herOpenid)
    {
        $link = $this->sqlConnect();
        mysqli_query($link, 'set names utf8');

        $sql = "select openid from `give_bullets` WHERE openid='{$myOpenid}' AND to_openid='{$herOpenid}'";
        $res = mysqli_query($link, $sql);

        if (!$res->num_rows) {
            return false;
        }

        return true;
    }


    //查询能不能给自己送子弹
    function sendMeBullets($openid)
    {
        $link = $this->sqlConnect();
        mysqli_query($link, 'set names utf8');

        $sql = "select me_updated from `bullets` WHERE openid='{$openid}' limit 1";
        $res = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($res);
        mysqli_close($link);
        $sendMe = date("Y-m-d", $row['me_updated']);
        $today = date("Y-m-d");
        if ($sendMe == $today) {
            return false;
        }

        return true;


    }

    //查询能不能给她送子弹
    function sendHerBullets($myOpenid, $shareId)
    {
        if ($myOpenid == $shareId) {
            return false;
        }
        $link = $this->sqlConnect();
        mysqli_query($link, 'set names utf8');
        $sql = "select updated from `give_bullets` WHERE openid='{$myOpenid}' AND to_openid='{$shareId}' limit 1";
        $res = mysqli_query($link, $sql);
        mysqli_close($link);
        if (!$res->num_rows) {
            return true;
        }
        $row = mysqli_fetch_assoc($res);

        $sendHer = date("Y-m-d", $row['updated']);
        $today = date("Y-m-d");
        if ($sendHer == $today) {
            return false;
        }

        return true;


    }

    //查询最近送过子弹的人
    function whoSendMe($myOpenid)
    {
        $link = $this->sqlConnect();
        mysqli_query($link, 'set names utf8');
        $sql = "select openid from `give_bullets` WHERE to_openid='{$myOpenid}' ORDER BY `updated` DESC limit 6";
        $result = mysqli_query($link, $sql);
        mysqli_close($link);

        if (!$result->num_rows) {
            return false;
        }

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row['openid'];
        }

        return $rows;


    }

    function findNickname($rows)
    {
        $link = $this->sqlConnect();
        mysqli_query($link, 'set names utf8');

        $n = count($rows);
        $nicknames = array();

        for ($i = 0; $i < $n; $i++) {
            $sql = "select nickname from `user` WHERE openid='{$rows[$i]}' limit 1";
            $res = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($res);
            $nicknames[] = $row['nickname'];
        }

        mysqli_close($link);
        return $nicknames;


    }


}