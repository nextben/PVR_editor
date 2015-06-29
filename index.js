function checkLogin(){
  $.ajax({
    async: false,
    type: 'get',
    url: 'getData.php',
    data: {
      req: 'checkLogin'
    },
    dataType: 'json',
    success: function (ret){
      if(ret == 'logout') location.replace('login.php');
      userId = ret;
    }
  });
}