<?php
include_once("getData.php");
include_once("file.php");


switch ($_GET['req']) {   
  case 'checkLoginPassword':
    $login = $_GET['login'];
    $password = $_GET['password'];
    $match = FALSE;

    $ret = get_user_data($login);
    if($ret['password'] == $password){
        $match = TRUE;
    }    
    // make a function that check if login and password match
    // $match = checkLoginPassword($login, $password);
    echo $match;
    break;
  case 'getUserProjects':
    $user = $_GET['user'];
    $projects = get_project_list($user);
    // make a function that returns all the projects of the user
    // I m now using this $page_url = url('http://localhost:8888/getData.php?req=getProjectList&data%5BuserId%5D='.$user);
    // $projects = getUserProjects($user);
    echo json_encode($projects, JSON_NUMERIC_CHECK);
    break;
  case 'getProjectEditIframe':
    $project = $_GET['project'];
    $iframe = "project_edit.php?project=$project";
    // make a function that returns an iframe of a project edition
    // maybe adding in parameters the login and password ?
    // $iframe = getEditIframe($project);
    echo $iframe;
    break;
  case 'getProjectDisplayIframe':
    $project = $_GET['project'];
    $iframe = "project_display.php?project=$project";
    // make a function that returns an iframe of a project display like in preview.html
    // $iframe = getDisplayIframe($project);
    echo $iframe;
    break;
  case 'deleteProject':
    $project = $_GET['project'];
    $result = delete_project($project);
    removeDir("project/{$_POST['data']['id']}");
    // make a function that delete project 
    // maybe adding in parameters the login and password ?
    // $result = deleteProject($project);
    echo $result;
    break;
}
?>