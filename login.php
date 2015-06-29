<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

    <style>
      @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
      html {margin:0; padding:0; font-family:"Nanum Gothic"; width:100%; height:100%}
      body {margin:0; padding:0; width:100%; height:100%}
      #table_wrapper {display:table; text-align:center;width:100%; height:100%;}
      #row_wrapper {display:table-row;}
      #main_container {display:table-cell; vertical-align:middle; }
      #login_container {width:300px; height:200px; display:inline-block; font-size:20px;}
      #login_container input{font-size:19px;}
      .login_button {background-color:#3FBFBF; width:254px; height:46px; color:white; font-weight:bold; line-height:220%; cursor:pointer; margin:0px;}
      #login_state {height:20px; width:254px; font-size:14px; color:red;}
      .login_comp {width:250px; height:40px; margin-bottom:10px; display:inline-block;}
      #login_from {width:300px; height:200px;}
      .text_box {font-size: 15px; margin-bottom:10px;}
    </style>
  </head>
  <body>
    <div id="table_wrapper">
      <div id="row_wrapper">
				<div id="main_container">
		      <div id="login_container">
            <form id="login_form">
              <div id="login_state" class="login_comp"></div>
              <input id="id_input" name="id" type="text" class="login_comp" value=" 아이디">
              <input id="password_input" name="password" type="text" class="login_comp" value=" 비밀번호">
              <div id="login_button" class="login_comp login_button">로그인</div>
            </from>				      
		      </div>
		    </div>
		  </div>
		</div>
    <script type="text/javascript">
      $(document).ready(function (){
        $.post('member.php', {
          req: 'checkLoginAndType'
        }, function (data){
          if(data.result == "logout") return;
          if(data.type == 'real_estate') location.replace('real_estate.html');
          else if(data.type == 'viewer') location.replace('viewer.html');
          else location.replace('index.html')
        },'json');
      });


      $('#id_input').blur(function(){
        if(!this.value) this.value=' 아이디';
      })
      $('#id_input').focus(function(){
        if(this.value === ' 아이디') this.value='';
      })
      $('#password_input').blur(function(){
        if(!this.value){
          this.type = 'text';
          this.value= ' 비밀번호';
        } 
      })
      $('#password_input').focus(function(){
        this.type = 'password';
        if(this.value === ' 비밀번호') this.value='';
      })

      //로그인 버튼 클릭시 입력한 정보로 로그인 처리
      $('#login_button').click(function(){
        $.post("member.php", 
          {
          	req 		:'login',
            id      :$('#id_input').val(),
            password:$('#password_input').val()
          }, 
          function(result){
            if(result=="success_real_estate"){
              location.replace('real_estate.html')
            }
            else if(result=="success"){
            	location.replace('index.html');
            }
            else if(result=="success_viewer"){
              location.replace('viewer.html');
            }
            else if(result=="wrong_id"){
              $("#login_state").css('display', 'none');
              $("#login_state").html("존재하지 않는 아이디입니다.");
              $("#login_state").fadeIn(100);
            }
            else if(result=="wrong_password"){
              $("#login_state").css('display', 'none');
              $("#login_state").html("잘못된 비밀번호입니다.");
              $("#login_state").fadeIn(100);
            }
          }
        );
      })
      //로그인 폼에서 엔터키 입력시 로그인 처리 
      $('#login_form input').keypress(function (ev){
        if(ev.keyCode == 13){
          $('#login_button').click();
        }
      });

      //로그아웃 버튼 클릭시 로그아웃 처리
      $('#logout_button').click(function(){
        $.post("_log.php", 
          {
          	req		: 'logout', 
          }, 
          function(result){
          	location.replace('login.php');
          }
        );
      })
    </script>   
  </body>
</html>