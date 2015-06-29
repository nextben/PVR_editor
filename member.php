<?php
include_once("_db.php");

if($_POST){
	session_start();

	if($_POST['req']=='login'){
		//id, password로 로그인 
		$_SESSION['started'] = time();
		echo login($_POST['id'], $_POST['password']);
	}	
	else if($_POST['req']=='logout'){
		//로그 아웃 
		logout($_SESSION['id']);
	}
	else if($_POST['req'] == 'checkLogin'){
		if (isSet($_SESSION['started'])){
		    if(time() - 60*30*1 > $_SESSION['started']){
		    	if($_SESSION['id']) logout($_SESSION['id']);
		    	echo 'logout';
		        //Logout, destroy session, etc.
		    }
		    else{
		    	echo $_SESSION['id'];
		    }
		}
		else {
			if(isSet($_SESSION['id']))	echo $_SESSION['id'];
			else echo 'logout';	    
		}
	}
	else if($_POST['req'] == 'checkLoginAndType'){
		$data = array();

		if (isSet($_SESSION['started'])){
		    if(time() - 60*30*1 > $_SESSION['started']){
		    	if(isset($_SESSION['id'])) logout($_SESSION['id']);		    	
		    	$data['result'] = 'logout';
		    }
		    else{		    	
		    	$ret = get_user_data($_SESSION['id']);
		    	$data['result'] = 'login';
		    	$data['id'] = $_SESSION['id'];
		    	$data['type'] = $ret['user_type'];		    	
		    }
		}
		else {
			if(isSet($_SESSION['id'])){
				$ret = get_user_data($_SESSION['id']);
				$data['result'] = 'login';
				$data['id'] = $_SESSION['id'];
				$data['type'] = $ret['user_type'];
			}	
			else 
				$data['result'] = 'logout';
		}
		echo json_encode($data);		
	}
}
?>