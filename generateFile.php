<?php
/**
 * 生成档案  给自己送子弹
 */
if (!empty($_POST)) {
    require_once 'docs/alias.php';
    require_once 'docs/rank.php';
    require_once 'db/db.php';

    $openid = $_COOKIE['openid'];
    $realname = $_POST['realname'];
    $phone = $_POST['phone'];
    $avatar = $_POST['path'];
//    $avatar='upload/001.jpg';
    $key = mt_rand(0, 399);
    $alias = $names[$key];
    $bullets = 0;
    $rank = rank($bullets);
    $skill = skill($bullets);
    $depart = depart($bullets);

    $db = new DB();
    $db->generateFile($openid, $realname, $phone, $alias, $avatar);

} else {
    header("Location:index.php");
}

//微信分享页面

require_once "wechat/jssdk.php";
$appid = 'wx06608e028585cb9c';
$appsecret = 'ff1425e77e6062442a9c579c6d850fd1';
$jssdk = new JSSDK($appid, $appsecret);
$signPackage = $jssdk->GetSignPackage();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>千金唯爱特种兵训练营</title>
    <link rel="stylesheet" href="css/nhfh.css">

</head>
<body>
<div id="file">
    <div id="file_container">
        <div id="file_img">
            <img src="<?php echo $avatar; ?>"/>
        </div>
        <div id="file_form">
            <div>
                <label>姓名：</label><span><?php echo $realname; ?></span>
            </div>
            <div>
                <label>代号：</label><span><?php echo $alias; ?></span>
            </div>
            <div>
                <label>ID：</label><span><?php echo $phone; ?></span>
            </div>
            <div>
                <label>等级：</label><span><?php echo $rank; ?></span>
                <button id="jsff">晋升方法</button>
            </div>
            <div>
                <label>擅长：</label><span><?php echo $skill; ?></span>
            </div>
            <div>
                <label>所属部门：</label><span><?php echo $depart; ?></span>
            </div>
            <div>
                <label>战绩：</label><span>缴获<b id="bullets"><?php echo $bullets; ?></b>颗子弹</span>
            </div>
        </div>
        <div id="file_btn">
            <button id="give">给自己送子弹</button>
            <button id="shareFile" onclick="shaiId();">晒一晒我的特种兵档案</button>
        </div>
    </div>
</div>

<div id="promote">
    <div id="promote_container">
        <button id="fhda">返回档案</button>
    </div>
</div>

</body>
<script src="js/jquery-1.11.3.js"></script>
<script>
    $(document).ready(function () {
        $("#give").click(function () {

            var x = parseInt($("#bullets").text());
            x += 10;
            $("#bullets").text(x);
            $("#give").attr("disabled", "disabled");
            $.post("wechat/saveMe.php", {'openid': '<?php echo $_COOKIE['openid']; ?>'}, function (data, status) {


            });


        });
    });
</script>

<script>
    function shaiId() {
        var openid = '<?php echo $openid;?>';
        window.location.href = 'shareFriends.php?shareId=' + openid;
    }
</script>
<script>
    $('body').css('height', screen.height);
    $('#jsff').on('click', function () {
        $('#file').css('display', 'none');
        $('#promote').css('display', 'block');
    })
    $('#fhda').on('click', function () {
        $('#promote').css('display', 'none');
        $('#file').css('display', 'block');
    })
</script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    /*
     * 注意：
     * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
     * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
     * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
     *
     * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
     * 邮箱地址：weixin-open@qq.com
     * 邮件主题：【微信JS-SDK反馈】具体问题
     * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
     */

    var shareId = '<?php echo $openid;?>';
	var avatar='<?php echo $avatar; ?>';

    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'checkJsApi',
            'onMenuShareAppMessage',
            'onMenuShareTimeline',
        ]
    });
    wx.ready(function () {
        // 在这里调用 API
        //分享到朋友圈
        wx.onMenuShareTimeline({
            title: '怒火凤凰特种兵,小伙伴快来加子弹', // 分享标题
            desc: '怒火凤凰，硝烟四起，烽火连天！请领好你的装备！我们出发！', // 分享描述
            link: 'http://wx.aaysf.com/nhfh/giveHerBullets.php?shareId=' + shareId,
            imgUrl: 'http://wx.aaysf.com/nhfh/'+avatar, // 分享图标// 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
//                alert('yes share success');
            }
        });


        //分享给朋友
        wx.onMenuShareAppMessage({
            title: '怒火凤凰特种兵,小伙伴快来加子弹', // 分享标题
            desc: '怒火凤凰，硝烟四起，烽火连天！请领好你的装备！我们出发！', // 分享描述
            link: 'http://wx.aaysf.com/nhfh/giveHerBullets.php?shareId=' + shareId,
            imgUrl: 'http://wx.aaysf.com/nhfh/'+avatar,
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });


    });


</script>


</html>