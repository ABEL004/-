function go() {

    var realname=$("#realname").val().trim();
    if(realname.length<2){
        alert('姓名至少两个字！');
        return false;
    }

    var phone = $("#phone").val().trim();
    if (!(/^1[3|4|5|7|8][0-9]\d{8}$/.test(phone))) {
        alert('请输入11位手机号码');
// 			prompt(2,'请输入11位手机号码');
        return false;
    }
    var path=$("#path").val();
    if(path=='' || path==null){
        alert('请先上传图片!');
        return false;
    }else{
      return true;
    }


    



}
