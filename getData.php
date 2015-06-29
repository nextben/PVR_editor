<?php
include_once("_db.php");

if($_GET['req'] == "getNodeList"){
  echo json_encode(get_project_node_list($_GET['data']['projectId']), JSON_NUMERIC_CHECK);
}

if($_GET['req'] == "getNodeData"){
  if($_GET['data']['type'] == "map"){
    $data = array();

    $row = get_project_map_data($_GET['data']['id']);
    $data['id'] = $row['project_id'];
    $data['options'] = array();
    $data['options']['name'] = $row['project_name'];
    $data['options']['type'] = "map";

    $data['options']['layerList'] = array();
    $layer_list = get_layer_list_of_map($row['project_id']);
    for($i=0; $i<count($layer_list); $i++){
      $layer = array();
      $layer['name'] = $layer_list[$i]['layer_name'];
      $layer['id'] = $layer_list[$i]['layer_id'];
      array_push($data['options']['layerList'], $layer);
    }
  }
  if($_GET['data']['type'] == "layer"){
    $data = array();

    $row = get_layer_data($_GET['data']['id']);
    $data['id'] = $row['layer_id'];
    $data['tileUrl'] = $row['tile_url'];
    $data['options'] = array();
    $data['options']['name'] = $row['layer_name'];
    $data['options']['minZoom'] = $row['min_zoom'];
    $data['options']['maxZoom'] = $row['max_zoom'];
    $data['options']['mapId'] = $row['map_id'];
    $data['options']['order'] = $row['orders'];
    $data['options']['mainView'] = array();
    $data['options']['mainView']['latlng'] = array();
    $data['options']['mainView']['latlng']['lat'] = $row['main_view_lat'];
    $data['options']['mainView']['latlng']['lng'] = $row['main_view_lng'];
    $data['options']['mainView']['zoom'] = $row['main_view_zoom'];
    $data['options']['type'] = "layer";
    $data['options']['tileImageType'] = $row['tile_image_type'];
    $data['options']['mainPvr'] = $row['main_pvr_id'];

    $data['options']['vtourList'] = array();
    $vtour_list = get_vtour_list_of_layer($row['layer_id']);
    for($i=0; $i<count($vtour_list); $i++){
      $vtour = array();
      $vtour['name'] = $vtour_list[$i]['vtour_name'];
      $vtour['id'] = $vtour_list[$i]['vtour_id'];
      array_push($data['options']['vtourList'], $vtour);
    }
  }
  if($_GET['data']['type'] == "vtour"){
    $data = array();

    $row = get_vtour_area_data($_GET['data']['id']);
    $data['id'] = $row['vtour_id'];
    $data['latlng'] = array();
    $data['latlng']['lat'] = $row['lat'];
    $data['latlng']['lng'] = $row['lng'];
    $data['zoom'] = $row['zoom'];
    $data['xmlPath'] = $row['xml_path'];
    $data['options'] = array();
    $data['options']['layerId'] = $row['layer_id'];
    $data['options']['name'] = $row['vtour_name'];
    $data['options']['locationAddress'] = $row['location_address'];
    $data['options']['publicVtour'] = $row['public_vtour'];

    $data['options']['pvrList'] = array();
    $pvr_list = get_pvr_list_of_vtour($row['vtour_id']);
    for($i=0; $i<count($pvr_list); $i++){
      $pvr = array();
      $pvr['name'] = $pvr_list[$i]['pvr_name'];
      $pvr['id'] = $pvr_list[$i]['pvr_id'];
      array_push($data['options']['pvrList'], $pvr);
    }
    $data['options']['mainPvr'] = $row['main_pvr_id'];
    $data['options']['type'] = "vtour";
  }
  if($_GET['data']['type'] == "pvr"){
    $data = array();

    $row = get_pvr_data($_GET['data']['id']);
    $data['id'] = $row['pvr_id'];
    $data['options'] = array();
    $data['options']['vtourId'] = $row['vtour_id'];
    $data['options']['initialAth'] = $row['hlookat'];
    $data['options']['initialAtv'] = $row['vlookat'];
    $data['options']['initialFov'] = $row['fov'];
    $data['options']['name'] = $row['pvr_name'];
    $data['options']['pvrPath'] = $row['pvr_path'];
    $data['options']['type'] = "pvr";
  } 

  echo json_encode($data, JSON_NUMERIC_CHECK);
}

if($_GET['req'] == "getNewId"){ 
  if($_GET['data']['type'] == "project")  echo alloc_new_project_id($_GET['data']['options']['userId']);
  if($_GET['data']['type'] == "layer")  echo alloc_new_layer_id();
  if($_GET['data']['type'] == "vtour")  echo alloc_new_vtour_id();
  if($_GET['data']['type'] == "pvr")    echo alloc_new_pvr_id();
  if($_GET['data']['type'] == "markerIcon")   echo alloc_new_marker_icon_id();
  if($_GET['data']['type'] == "marker")   echo alloc_new_marker_id();

  if($_GET['data']['type'] == "hotspotIcon")  echo alloc_new_hotspot_icon_id();
  if($_GET['data']['type'] == "hotspot")  echo alloc_new_hotspot_id();  
}

if($_GET['req'] == "getMarkerIconList"){
  $data = array();
  $main_data = get_marker_icon_list($_GET['data']['projectId']);

  for($i=0; $i<count($main_data); $i++){
    $data[$i] = array();
    $normal_display = null;

    $display_data = get_marker_display_list($main_data[$i]['icon_id']);
    for($j=0; $j<count($display_data); $j++){
      switch($display_data[$j]['type']){
        case 'normal':
        $normal_display = $display_data[$j]; break;
      }
    }

    $data[$i]['id'] = $main_data[$i]['icon_id'];
    $data[$i]['options'] = array();
    $data[$i]['options']['iconUrl']  = $normal_display['img_url'];
    $data[$i]['options']['actionType'] = $main_data[$i]['action_type'];
    $data[$i]['options']['desc'] = $main_data[$i]['icon_description'];
    $data[$i]['options']['size'] = array();
    $data[$i]['options']['size']['x'] = $normal_display['width'];
    $data[$i]['options']['size']['y'] = $normal_display['height'];
  }

  echo json_encode($data, JSON_NUMERIC_CHECK);  
}

else if($_GET['req'] == "getHotspotIconList"){
  $data = array();
  $main_data = get_hotspot_icon_list($_GET['data']['projectId']);

  for($i=0; $i<count($main_data); $i++){
    $data[$i] = array();
    $normal_display = null;

    $display_data = get_hotspot_display_list($main_data[$i]['icon_id']);
    for($j=0; $j<count($display_data); $j++){
      switch($display_data[$j]['type']){
        case 'normal':
        $normal_display = $display_data[$j]; break;
      }
    }

    $data[$i]['id'] = $main_data[$i]['icon_id'];
    $data[$i]['options'] = array();
    $data[$i]['options']['iconUrl']  = $normal_display['img_url'];
    $data[$i]['options']['actionType'] = $main_data[$i]['action_type'];
    $data[$i]['options']['desc'] = $main_data[$i]['icon_description'];
    $data[$i]['options']['size'] = array();
    $data[$i]['options']['size']['x'] = $normal_display['width'];
    $data[$i]['options']['size']['y'] = $normal_display['height'];
  }

  echo json_encode($data, JSON_NUMERIC_CHECK);  
}

if($_GET['req'] == "getMarkerList"){
  $data = array();
  $main_data = get_marker_list($_GET['data']['projectId']);

  for($i=0; $i<count($main_data); $i++){
    $data[$i] = array();
    
    $data[$i]['id'] = $main_data[$i]['marker_id'];
    $data[$i]['latlng'] = array();
    $data[$i]['latlng']['lat'] = $main_data[$i]['lat'];
    $data[$i]['latlng']['lng'] = $main_data[$i]['lng'];
    $data[$i]['options'] = array();
    $data[$i]['options']['layerId'] = $main_data[$i]['layer_id'];
    $data[$i]['options']['icon'] = $main_data[$i]['icon_id'];
    $data[$i]['options']['minLevel'] = $main_data[$i]['min_zoom'];
    $data[$i]['options']['maxLevel'] = $main_data[$i]['max_zoom'];
    $data[$i]['options']['actionType'] = $main_data[$i]['action_type'];
    $data[$i]['options']['type'] = 'marker';
    
    if($main_data[$i]['action_type'] == 'linkToPvr'){
      $data[$i]['options']['linkedPvr'] = $main_data[$i]['pvr_id'];
      $data[$i]['options']['informText'] = $main_data[$i]['inform_text'];
      $data[$i]['options']['informImgUrl'] = $main_data[$i]['inform_img_url'];
      $data[$i]['options']['informType'] = $main_data[$i]['inform_type'];
      $data[$i]['options']['linkedUrl'] = $main_data[$i]['linked_url'];
      $data[$i]['options']['informTitle'] = $main_data[$i]['inform_title'];
    }
    if($main_data[$i]['action_type'] == 'linkToVtour'){
      $data[$i]['options']['linkedVtour'] = $main_data[$i]['vtour_id'];
    }
    /*if($main_data[$i]['action_type'] == 'linkToUrl'){
      $data[$i]['options']['linkedUrl'] = $main_data[$i]['linked_url'];
    }*/
    if($main_data[$i]['action_type'] == 'showInform'){
      $data[$i]['options']['informTitle'] = $main_data[$i]['inform_title'];
      $data[$i]['options']['informText'] = $main_data[$i]['inform_text'];
      $data[$i]['options']['informImgUrl'] = $main_data[$i]['inform_img_url'];
      $data[$i]['options']['informType'] = $main_data[$i]['inform_type'];
      $data[$i]['options']['linkedUrl'] = $main_data[$i]['linked_url'];
    }
  }

  echo json_encode($data, JSON_NUMERIC_CHECK);  
}

if($_GET['req'] == "getHotspotList"){
  $data = array();
  $main_data = get_hotspot_list($_GET['data']['projectId']);

  for($i=0; $i<count($main_data); $i++){
    $data[$i] = array();
    
    $data[$i]['id'] = $main_data[$i]['hotspot_id'];
    $data[$i]['ath'] = $main_data[$i]['ath'];
    $data[$i]['atv'] = $main_data[$i]['atv'];
    $data[$i]['options'] = array();
    $data[$i]['options']['sceneId'] = $main_data[$i]['pvr_id'];
    $data[$i]['options']['icon'] = $main_data[$i]['icon_id'];
    $data[$i]['options']['actionType'] = $main_data[$i]['action_type'];
    $data[$i]['options']['type'] = 'hotspot';
    if($main_data[$i]['action_type'] == 'linkToPvr'){
      $data[$i]['options']['linkedPvr'] = $main_data[$i]['linked_pvr_id'];
    }
    else if($main_data[$i]['action_type'] == 'showInform'){
      $data[$i]['options']['textInfo'] = $main_data[$i]['html'];
    }
  }

  echo json_encode($data, JSON_NUMERIC_CHECK);  
}

if($_GET['req'] == "getProjectList"){
  $data = array();

  $user = get_user_data($_GET['data']['userId']);
  if($user['user_type'] != "viewer")
    $ret = get_project_list($_GET['data']['userId']);
  else
    $ret = get_all_projects_of_real_estate();
  
  for($i=0; $i<count($ret); $i++){
    $project = array();
    $project['id'] = $ret[$i]['project_id'];
    $project['name'] = $ret[$i]['project_name'];
    array_push($data, $project);
  }

  echo json_encode($data, JSON_NUMERIC_CHECK);
}

if($_GET['req'] == "getPvrListOfProject"){
  session_start();

  $data = array();

  $row = get_pvrs_of_project($_GET['data']['projectId']);

  for($i=0; $i<count($row); $i++){
    $data[$i] = array();
    $data[$i]['id'] = $row[$i]['pvr_id'];
    $data[$i]['options'] = array();
    $data[$i]['options']['vtourId'] = $row[$i]['vtour_id'];
    $data[$i]['options']['initialAth'] = $row[$i]['hlookat'];
    $data[$i]['options']['initialAtv'] = $row[$i]['vlookat'];
    $data[$i]['options']['initialFov'] = $row[$i]['fov'];
    $data[$i]['options']['name'] = $row[$i]['pvr_name'];
    $data[$i]['options']['pvrPath'] = $row[$i]['pvr_path'];
    $data[$i]['options']['type'] = "pvr";
  }
  
  echo json_encode($data, JSON_NUMERIC_CHECK);
}

if($_GET['req'] == "getPreviewData"){
  session_start();

  $data = array();
  if(isset($_SESSION['project_id'])){   
    $data['setForPreview'] = 1; 
    $data['projectId'] = $_SESSION['project_id'];   
    
  }
  else{
    $data['setForPreview'] = 0;
  }
  session_write_close();

  echo json_encode($data, JSON_NUMERIC_CHECK);
}

if($_GET['req'] == "getDataForRealEstimate"){
  session_start();

  $data = array();

  $layer_list = get_layer_list_of_map($_GET['data']['projectId']);
  $data['layerId'] = $layer_list[0]['layer_id'];

  $vtour_list =get_vtour_list_of_layer($data['layerId']);
  $data['vtourId'] = $vtour_list[0]['vtour_id'];


  echo json_encode($data, JSON_NUMERIC_CHECK);
}

if($_GET['req'] == "getLatLngFromAddress"){
  $data = array();

  $address = $_GET['data']['address'];
  $address = str_replace(" ", "+", $address);
   
  $address_url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $address_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  $response = curl_exec($ch);
  curl_close($ch);   
  $response_a = json_decode($response); 
   
  //echo $formatted_address = $response_a->results[0]->formatted_address.'<br />';
  $data['lat'] = $response_a->results[0]->geometry->location->lat;
  $data['lng'] = $response_a->results[0]->geometry->location->lng;

  echo json_encode($data, JSON_NUMERIC_CHECK);
}

if($_GET['req'] == "getMarkersOfAllUsers"){
  session_start();
  $marker_data = array();
  if($_SESSION['id']){
    $user_data = get_user_data($_SESSION['id']);
    if($user_data['user_type'] == 'viewer'){
      $main_data = get_all_project_markers();
      $data = array();
      for($i=0; $i<count($main_data); $i++){
        $data[$i] = array();
        
        //$data[$i]['id'] = $main_data[$i]['marker_id'];
        $data[$i]['latlng'] = array();
        $data[$i]['latlng']['lat'] = $main_data[$i]['lat'];
        $data[$i]['latlng']['lng'] = $main_data[$i]['lng'];
        $data[$i]['options'] = array();
        //$data[$i]['options']['layerId'] = $main_data[$i]['layer_id'];
        //$data[$i]['options']['icon'] = $main_data[$i]['icon_id'];
        $data[$i]['options']['minLevel'] = $main_data[$i]['min_zoom'];
        $data[$i]['options']['maxLevel'] = $main_data[$i]['max_zoom'];
        $data[$i]['options']['actionType'] = $main_data[$i]['action_type'];
        //$data[$i]['options']['informText'] = $main_data[$i]['inform_text'];
        //$data[$i]['options']['informImgUrl'] = $main_data[$i]['inform_img_url'];

        $data[$i]['options']['type'] = 'marker';
        if($main_data[$i]['action_type'] == 'linkToPvr'){
          $data[$i]['options']['linkedPvr'] = $main_data[$i]['pvr_id'];
        }
        if($main_data[$i]['action_type'] == 'linkToVtour'){
          $data[$i]['options']['linkedVtour'] = $main_data[$i]['vtour_id'];
        }
        if($main_data[$i]['action_type'] == 'linkToProject'){
          $data[$i]['options']['linkedProject'] = $main_data[$i]['project_id'];
        }
      }
      $marker_data['markers'] = $data;
    }
    else {
      $marker_data['error'] = 'permission denied';
    }
  }
  else {
    $marker_data['error'] = 'permission denied';
  }

  echo json_encode($marker_data, JSON_NUMERIC_CHECK);
}

if($_GET['req'] == "getProjectMarkers"){
  session_start();
  $marker_data = array();
  if($_SESSION['id']){
    $user_data = get_user_data($_SESSION['id']);
    if($user_data['user_type'] == 'editor'){
      $main_data = get_project_markers($_GET['data']['projectId']);

      $data = array();
      for($i=0; $i<count($main_data); $i++){
        $data[$i] = array();
        
        $data[$i]['id'] = $main_data[$i]['project_id'];
        $data[$i]['latlng'] = array();
        $data[$i]['latlng']['lat'] = $main_data[$i]['lat'];
        $data[$i]['latlng']['lng'] = $main_data[$i]['lng'];
        $data[$i]['options'] = array();
        $data[$i]['options']['minLevel'] = $main_data[$i]['min_zoom'];
        $data[$i]['options']['maxLevel'] = $main_data[$i]['max_zoom'];
        $data[$i]['options']['type'] = 'projectMarker';
        $data[$i]['options']['actionType'] = "linkToProject";

      }
      $marker_data['markers'] = $data;
    }
    else {
      $marker_data['error'] = 'permission denied';
    }
  }
  else {
    $marker_data['error'] = 'permission denied';
  }
  echo json_encode($marker_data, JSON_NUMERIC_CHECK);
}

//get videos of a project
if($_GET['req'] == "getVideos") {
  $project_id = $_GET['data']['projectId'];

  $video_rows = get_videos($project_id);

  //chage data form for client side
  $videos = array();
  for($i=0; $i<count($video_rows); $i++) {
    $video = $video_rows[$i];
    $videos[] = array(
      'id' => $video['video_id'],
      'url' => $video['url'],
      'name' => $video['name']
    );
  }
  echo json_encode($videos, JSON_NUMERIC_CHECK);
}

if($_GET['req'] == "getPolylines") {
  $project_id = $_GET['data']['projectId'];

  $polyline_rows = get_polylines($project_id);


  //get polylines of a project
  $polylines = array();
  for($i=0; $i<count($polyline_rows); $i++) {
    $polyline = $polyline_rows[$i]; 
    $timeline_rows = get_timelines($polyline['polyline_id']);

    //get timelines of a polyline
    $timelines = array();
    for($j=0; $j<count($timeline_rows); $j++) {
      $timeline = $timeline_rows[$j]; 

      $latlng_str = as_text($timeline['latlngs']);

      //remove the part in front of first '('
      strtok($latlng_str,"(");      
      //read string and divide it properly
      $token = strtok(",");
      $latlngs = array();
      while($token){
        sscanf($token,"%f %f", $lat, $lng);
        $latlngs[] = array(
          "lat"=>$lat, 
          "lng"=>$lng
        );
        $token = strtok(",");
      }

      $timelines[] = array(
        'perAtStart' => $timeline['per_at_start'],
        'perAtEnd' => $timeline['per_at_end'],
        'latlng' => $latlngs,
      );
    }

    //chage data form for client side
    $polylines[] = array(
      'id' => $polyline['polyline_id'],
      'layerId' => $polyline['layer_id'],
      'options' => array(
        'levelBound' => array(
          'min' => $polyline['min_zoom'],
          'max' => $polyline['max_zoom'],
        ),
        'videoId' => $polyline['video_id'],
        'timelineList' => $timelines,
      )
    );
  }
  echo json_encode($polylines, JSON_NUMERIC_CHECK);
}
?>