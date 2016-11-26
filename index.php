<?php
require_once 'authorize.php';

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>千金唯爱特种兵训练营</title>
    <link rel="stylesheet" href="css/nhfh.css">
    <link rel="stylesheet" href="css/jquery.jcrop.css">

</head>
<body>
<div id="login">
    <div id="login_container">
        <div id="login_form">
            <form action="generateFile.php" onsubmit="return go();" method="post">
                <label>*</label><input class="inp" type="text" maxlength="24" id="realname" name="realname"
                                       value="<?php echo isset($_GET['realname']) ? $_GET['realname'] : ''; ?>"
                                       placeholder="请输入您的姓名">
                <label>*</label><input class="inp" type="tel" maxlength="11" id="phone" name="phone"
                                       value="<?php echo isset($_GET['phone']) ? $_GET['phone'] : ''; ?>"
                                       placeholder="请输入您的电话号码">
                <input type="hidden" name="path" id="path"
                       value="<?php echo isset($_GET['path']) ? $_GET['path'] : ''; ?>"/>
                <input type="button" class="sub" onclick="modal();" value="上传头像" id="modaltoggle">
                <input type="submit"  class="sub" value="生成档案">
            </form>
        </div>
        <div id="login_img">
            <img src="<?php echo isset($_GET['path']) ? $_GET['path'] : 'img/tzb.jpg'; ?>" alt="">
        </div>
    </div>
</div>


</body>
<script src="js/jquery-1.11.3.js"></script>
<script src="js/avatarCutter.js"></script>
<script src="js/jquery.ajaxfileupload.js"></script>
<script src="js/jquery.jcrop.js"></script>
<script src="js/upload.js"></script>
<script src="js/validate.js"></script>

<script>
    $('body').css('height',screen.height);
    function modal() {
        var realname = $("#realname").val().trim();
        var phone = $("#phone").val().trim();

        window.location.href = 'modal.php?realname=' + realname + '&phone=' + phone;


    }
</script>
<!--<script>-->
<!--$('#modaltoggle').on('click',function(){-->
<!--$('#modal').css('display','block');-->
<!--})-->
<!--$('#btnCrop').on('click',function(){-->
<!--$('#modal').css('display','none');-->
<!--})-->
<!--</script>-->
</html>