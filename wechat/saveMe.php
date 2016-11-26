<?php
require_once '../db/db.php';

$openid=$_POST['openid'];
//$openid='test001';
$db=new DB();
$db->giveMeBullet($openid);