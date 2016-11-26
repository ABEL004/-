$(function () {

    function getFileSize(fileName) {
        var byteSize = 0;
        //console.log($("#" + fileName).val());
        if($("#" + fileName)[0].files) {
            var byteSize  = $("#" + fileName)[0].files[0].size;
        }else {
            //var file = document.getElementById(fileName);
            //var img = new Image();
            //file.select();
            //alert(document.selection.createRange().text);
            //img.src = file.value;
            //img.style.display="none";

            //alert(img.readyState);return 0;
            //if(img.readyState=="complete"){//已经load完毕，直接打印文件大小
            //	alert(img.fileSize);//ie获取文件大小
            //}else {
            //	img.onreadystatechange=function(){
            //		if(img.readyState=='complete')//当图片load完毕
            //			alert(img.fileSize);//ie获取文件大小
            //	}
            //}
            //byteSize = img.fileSize;
            //byteSize = img.fileSize;
        }
        //alert(byteSize);
        byteSize = Math.ceil(byteSize / 1024) //KB
        return byteSize;//KB
    }
    $("#btnUpload").click(function () {
        $('#picture_auto').css('display','none');
        var allowImgageType = ['jpg', 'jpeg', 'png', 'gif'];
        var file = $("#file1").val();
        //获取大小
        var byteSize = getFileSize('file1');
        //获取后缀
        if (file.length > 0) {
            if(byteSize > 2048) {
                alert("上传的附件文件不能超过2M");
                return;
            }
            var pos = file.lastIndexOf(".");
            //截取点之后的字符串
            var ext = file.substring(pos + 1).toLowerCase();
            //console.log(ext);
            if($.inArray(ext, allowImgageType) != -1) {
                ajaxFileUpload();
            }else {
                alert("请选择jpg,jpeg,png,gif类型的图片");
            }
        }
        else {
            alert("请选择jpg,jpeg,png,gif类型的图片");
        }
    });
    function ajaxFileUpload() {
        $.ajaxFileUpload({
            url: 'action.php', //用于文件上传的服务器端请求地址
            secureuri: false, //一般设置为false
            fileElementId: 'file1', //文件上传空间的id属性  <input type="file" id="file" name="file" />
            dataType: 'json', //返回值类型 一般设置为json
            success: function (data, status)  //服务器成功响应处理函数
            {
                //var json = eval('(' + data + ')');
                //alert(data);
                $("#picture_original>img").attr({src: data.src, width: data.width, height: data.height});
                $('#imgsrc').val(data.path);

//                        $('#path').attr('value',data.path);
                alert(data.msg);
                // alert(data.path);
                // $('#path').attr('value',data.path);
                var realname=$("#realname").val().trim();
                var phone = $("#phone").val().trim();
                window.location.href='index.php?realname='+realname+'&phone='+phone+'&path='+data.path;


            },
            error: function (data, status, e)//服务器响应失败处理函数
            {
                alert(e);
            }
        })
        return false;
    }
    
});