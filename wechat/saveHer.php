<?php
require_once '../db/db.php';

$myOpenid=$_POST['myOpenid'];
$herOpenid=$_POST['herOpenid'];

//$openid='test001';
$db=new DB();
$db->giveHerBullets($myOpenid,$herOpenid);