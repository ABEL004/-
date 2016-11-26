<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>千金唯爱特种兵训练营</title>
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/jquery.jcrop.css">

</head>
<body>
<div id="modal">
    <p class="_box">
        <input type="file" id="file1" name="file1"/>选择图片
    </p>
    <input type="button" value="上传" id="btnUpload"/>
    <div id="picture_auto"><img alt="" src="img/tzb.jpg"/></div>
    <div style="display:none;overflow:hidden" id="div_avatar">
        <div id="picture_original"><img alt="" src=""/></div>
        <div id="picture_200" style="margin:30px auto"></div>
        <input type="hidden" id="x1" name="x1" value="0"/>
        <input type="hidden" id="y1" name="y1" value="0"/>
        <input type="hidden" id="cw" name="cw" value="0"/>
        <input type="hidden" id="ch" name="ch" value="0"/>
        <input type="hidden" id="imgsrc" name="imgsrc"/>
    </div>
    <div>
        <input type="hidden" id="realname" name="realname"
               value="<?php echo isset($_GET['realname']) ? $_GET['realname'] : null; ?>"/>
        <input type="hidden" id="phone" name="phone"
               value="<?php echo isset($_GET['phone']) ? $_GET['phone'] : null; ?>"/>
    </div>
</div>


</body>
<script src="js/jquery-1.11.3.js"></script>
<script src="js/avatarCutter.js"></script>
<script src="js/jquery.ajaxfileupload.js"></script>
<script src="js/jquery.jcrop.js"></script>
<script src="js/upload.js"></script>
<script>
    $('body').css('height', screen.height);
</script>
</html>