<?php
ini_set('memory_limit', '-1');

include "_file.php";
include "_pvr.php";
include "_xml.php";
include_once "decode_map_json.php";


if($_POST['req'] == 'uploadTileImage'){
  switch($_FILES['tileImageFile']['type']){
    case 'image/jpeg':
    $ext = 'jpg'; break;
    case 'image/png':
    $ext = 'png'; break;
  }   
  
  if(!file_exists("project/{$_POST['data']['projectId']}/tile/{$_POST['data']['id']}"))
    mkdir("project/{$_POST['data']['projectId']}/tile/{$_POST['data']['id']}", "0777", true);
  $temp = "project/{$_POST['data']['projectId']}/tile/{$_POST['data']['id']}/temp.$ext";
  $dest = "project/{$_POST['data']['projectId']}/tile/{$_POST['data']['id']}/0-0-0.$ext";
  move_uploaded_file($_FILES['tileImageFile']['tmp_name'], $temp);
  make_square($temp, $dest, $ext);

  echo "project/{$_POST['data']['projectId']}/tile/{$_POST['data']['id']}/{z}-{x}-{y}.$ext";
}

if($_POST['req'] == 'uploadPvrImage'){
  $path = "project/{$_POST['data']['projectId']}/pvr/{$_POST['data']['id']}";
  if (!file_exists($path)) mkdir($path, "0777", true);

  //var_dump($_FILES);

  make_panorama($_FILES['pvrImageFile']['tmp_name'], "$path/pano.jpg", $_POST['data']['numOfImage']);
  make_pvr("$path/pano.jpg");

  scale_img("$path/pano.jpg", "$path/pano_thumb.jpg", 169, 85);

  echo $path; 
}

if($_POST['req'] == 'uploadPvrPano'){
  $path = "project/{$_POST['data']['projectId']}/pvr/{$_POST['data']['id']}";
  if (!file_exists($path)) mkdir($path, "0777", true);

  //var_dump($_FILES);
  move_uploaded_file($_FILES['pvrPanoFile']['tmp_name'], "$path/pano.jpg");
  make_pvr("$path/pano.jpg");

  scale_img("$path/pano.jpg", "$path/pano_thumb.jpg", 169, 85);

  echo $path; 
}

if($_POST['req'] == 'uploadIconImage'){
  $data = $_POST['data'];
  $ret = array();

  for($i=0; $i<count($_FILES['iconImageFile']['type']); $i++){
    switch($_FILES['iconImageFile']['type'][$i]){
      case 'image/jpeg':
      $ext = 'jpg'; break;
      case 'image/png':
      $ext = 'png'; break;
      case 'image/gif':
      $ext = 'gif'; break;
    }
    $dest = "project/{$data['projectId']}/{$data['type']}/{$data['id'][$i]}.$ext";

    if(!file_exists("project/{$data['projectId']}/{$data['type']}"))
      mkdir("project/{$data['projectId']}/{$data['type']}", '0777', true);

    move_uploaded_file($_FILES['iconImageFile']['tmp_name'][$i], $dest);
    $size = getimagesize($dest);

    $ret[$i] = array();
    $ret[$i]['options'] = array();
    $ret[$i]['options']['iconUrl'] = $dest;
    $ret[$i]['options']['size'] = array();
    $ret[$i]['options']['size']['x'] = $size[0];
    $ret[$i]['options']['size']['y'] = $size[1];
  }

  echo json_encode($ret, JSON_NUMERIC_CHECK);
}

if($_POST['req'] == 'setNewProject'){
  if(!file_exists("project/{$_POST['data']['projectId']}"))
    mkdir("project/{$_POST['data']['projectId']}", "0777", true);
  copyDir("template", "project/{$_POST['data']['projectId']}");
}

if($_POST['req'] == 'uploadInformImage'){
  $data = $_POST['data'];
  switch($_FILES['informImgFile']['type']){
    case 'image/jpeg':
    $ext = 'jpg'; break;
    case 'image/png':
    $ext = 'png'; break;
    case 'image/gif':
    $ext = 'gif'; break;
  }
  $dest = "project/{$data['projectId']}/inform_img/{$data['id']}.$ext";

  if(!file_exists("project/{$data['projectId']}/inform_img")){
    mkdir("project/{$data['projectId']}/inform_img", "0777", true);
  }
  move_uploaded_file($_FILES['informImgFile']['tmp_name'], $dest);  
  echo $dest;
}

if($_POST['req'] == 'delPvr'){
  removeDir("project/{$_POST['data']['projectId']}/pvr/{$_POST['data']['id']}");
}

if($_POST['req'] == 'addVtourXml'){
  copy("template/krpano.xml", "project/{$_POST['data']['projectId']}/{$_POST['data']['vtourId']}.xml");
  echo "project/{$_POST['data']['projectId']}/{$_POST['data']['vtourId']}.xml";
}

if($_POST['req'] == 'delVtourXml'){
  unlink("project/{$_POST['data']['projectId']}/{$_POST['data']['vtourId']}.xml");
}

if($_POST['req'] == 'uploadPanoVideoZip') {
  $user_id = $_POST['data']['userId'];
  $project_id = $_POST['data']['projectId'];

  $tmp_zip_path = $_FILES['panoVideoZip']['tmp_name'];
  $zip_folder_path = "project/{$_POST['data']['projectId']}/temp/";
  $zip_path = "$zip_folder_path/temp.zip";

  //move the uplaoded zip file
  if(file_exists($zip_folder_path)){
    removeDir($zip_folder_path);
  }
  mkdir($zip_folder_path, 0777, true); 
  if(!move_uploaded_file($tmp_zip_path, $zip_path)) {
    exit("ERROR: move_uploaded_file error!");
  }

  //unzip project file
  $zip = new ZipArchive;
  if(!$zip->open($zip_path)) {
    exit("ERROR: zip open_error");
  }
  $zip->extractTo($zip_folder_path);
  $zip->close();

  //decode json file
  if(!file_exists("$zip_folder_path/data.json")) {
    exit("ERROR: no data json file");
  }
  $pano_video_data = decode_pano_video_json("$zip_folder_path/data.json");

  //trans_id_table contain old id as key and new id as value
  $trans_id_table = array(); 

  //save data to DB and move files to proper location
  //Allocating new Id has to be treated in order, so don't use 'foreach' iteration
  if(array_key_exists('layer', $pano_video_data)) {
    $trans_id_table['layer'] = array();
    for($i=0; $i<count($pano_video_data['layer']); $i++) {
      $layer = $pano_video_data['layer'][$i];

      //save old_id and new_id
      $old_id = $layer['layer_id'];
      $new_id = alloc_new_layer_id();
      
      $trans_id_table['layer'][$old_id] = $new_id;

      //get order for new layer
      $new_order = get_new_order('layer', 'map_id', $project_id);
      $layer['orders'] = $new_order;

      //transform old data into new data
      $layer['map_id'] = $project_id;

      // if tile url is local, move tile images to project
      if(!preg_match("/^https?:\/\//", $layer['tile_url'])){
        //move files from temp diectory to proper location
        $old_tile_path = $layer['tile_url'];
        $new_tile_path = preg_replace("/tile\/[0-9]*\//", "project/$project_id/tile/$new_id/", $old_tile_path);
        $layer['tile_url'] = $new_tile_path;

        $old_tile_folder_path = preg_replace("/[a-zA-Z.{}-]*$/", "", $old_tile_path);
        $new_tile_folder_path = preg_replace("/[a-zA-Z.{}-]*$/", "", $new_tile_path);

        //if there hasn't been tile folder, make tile folder
        if(!file_exists("project/$project_id/tile")) {
          mkdir("project/$project_id/tile", 0666, true);
        }
        if(file_exists($new_tile_folder_path)) {
          removeDir($new_tile_folder_path);
        }

        rename("$zip_folder_path$old_tile_folder_path", $new_tile_folder_path);
      }      

      //delete id from array to save data correctly
      unset($layer['layer_id']);

      //save data to DB
      $fields = array();
      $values = array();
      foreach($layer as $field => $value) {
        $fields[] = $field;
        $values[] = $value;
      }
      set_data('layer', 'layer_id', $new_id, $fields, $values);
    }
  }
  if(array_key_exists('marker_icon', $pano_video_data)) {
    $trans_id_table['marker_icon'] = array();
    for($i=0; $i<count($pano_video_data['marker_icon']); $i++) {
      $marker_icon = $pano_video_data['marker_icon'][$i];

      //save old_id and new_id
      $old_id = $marker_icon['icon_id'];
      $new_id = alloc_new_marker_icon_id();
      
      $trans_id_table['marker_icon'][$old_id] = $new_id;

      //get order for new marker_icon
      $new_order = get_new_order('marker_icon', 'project_id', $project_id);
      $marker_icon['orders'] = $new_order;
      $marker_icon['project_id'] = $project_id;

      //delete id from array to save data correctly
      unset($marker_icon['icon_id']);

      //save data to DB
      $fields = array();
      $values = array();
      foreach($marker_icon as $field => $value) {
        $fields[] = $field;
        $values[] = $value;
      }
      set_data('marker_icon', 'icon_id', $new_id, $fields, $values);
    }
  }
  if(array_key_exists('marker_display', $pano_video_data)) {
    for($i=0; $i<count($pano_video_data['marker_display']); $i++) {
      $marker_display = $pano_video_data['marker_display'][$i];

      $old_id = $marker_display['icon_id'];
      $new_id = $trans_id_table['marker_icon'][$marker_display['icon_id']];

      //move files from temp diectory to proper location
      $old_icon_path = $marker_display['img_url'];
      $new_icon_path = preg_replace("/icon\/[0-9]*/", "project/$project_id/markerIcon/$new_id", $old_icon_path);
      $marker_display['img_url'] = $new_icon_path;

      //if there hasn't been marker icon folder, make marker icon folder
      if(!file_exists("project/$project_id/marker_icon")) {
        mkdir("project/$project_id/marker_icon", 0666, true);
      }
      rename("$zip_folder_path$old_icon_path", $new_icon_path);

      //delete keys from field array 
      $keys = array();      
      $keys['icon_id'] = $new_id;
      unset($marker_display['icon_id']);
      $keys['type'] = $marker_display['type'];
      unset($marker_display['type']);

      //save data to DB
      set_data_with_comp_pk('marker_display', $keys, $marker_display);
    }
  }
  if(array_key_exists('marker', $pano_video_data)) {
    $trans_id_table['marker'] = array();
    for($i=0; $i<count($pano_video_data['marker']); $i++) {
      $marker = $pano_video_data['marker'][$i];

      //save old_id and new_id
      $old_id = $marker['marker_id'];
      $new_id = alloc_new_marker_id();
      
      $trans_id_table['marker'][$old_id] = $new_id;

      //transform old data into new data
      $marker['layer_id'] = $trans_id_table['layer'][$marker['layer_id']];
      $marker['icon_id'] = $trans_id_table['marker_icon'][$marker['icon_id']];

      //delete id from array to save data correctly
      unset($marker['marker_id']);

      //save data to DB
      $fields = array();
      $values = array();
      foreach($marker as $field => $value) {
        $fields[] = $field;
        $values[] = $value;
      }
      set_data('marker', 'marker_id', $new_id, $fields, $values);
    }
  }
  if(array_key_exists('m_link_inform', $pano_video_data)) {
    for($i=0; $i<count($pano_video_data['m_link_inform']); $i++) {
      $m_link_inform = $pano_video_data['m_link_inform'][$i];

      $old_id = $m_link_inform['marker_id'];
      $new_id = $trans_id_table['marker'][$m_link_inform['marker_id']];

      //delete keys from field array 
      $keys = array();
      $keys['marker_id'] = $new_id;
      unset($m_link_inform['marker_id']);

      //save data to DB
      set_data_with_comp_pk('m_link_inform', $keys, $m_link_inform);
    }
  }
  if(array_key_exists('m_link_url', $pano_video_data)) {
    for($i=0; $i<count($pano_video_data['m_link_url']); $i++) {
      $m_link_url = $pano_video_data['m_link_url'][$i];

      $old_id = $m_link_url['marker_id'];
      $new_id = $trans_id_table['marker'][$m_link_url['marker_id']];

      //delete keys from field array 
      $keys = array();
      $keys['marker_id'] = $new_id;
      unset($m_link_url['marker_id']);

      //save data to DB
      set_data_with_comp_pk('m_link_url', $keys, $m_link_url);
    }
  }
  if(array_key_exists('video', $pano_video_data)) {
    $trans_id_table['video'] = array();
    for($i=0; $i<count($pano_video_data['video']); $i++) {
      $video = $pano_video_data['video'][$i];

      //save old_id and new_id
      $old_id = $video['video_id'];
      $new_id = alloc_new_id('video', 'video_id');      
      $trans_id_table['video'][$old_id] = $new_id;

      $video['project_id'] = $project_id;

      //video path in json doesn't match to real video path
      $orig_old_video_path = $video['url'];
      $old_video_path = $new_tile_path = preg_replace("/.*\/video\//", "", $orig_old_video_path);
      strtok($old_video_path, '/');
      $old_video_file_name = strtok('/');

      $old_video_path = "video/$old_video_file_name";
      $new_video_path = "project/$project_id/video/$new_id.mp4";
      $video['url'] = $new_video_path;

      //if there hasn't been video folder, make video folder
      if(!file_exists("project/$project_id/video")) {
        mkdir("project/$project_id/video", 0666, true);
      }
      rename("$zip_folder_path$old_video_path", $new_video_path);
 
      //delete id from array to save data correctly
      $keys = array();
      $keys['video_id'] = $new_id;
      unset($video['video_id']);

      //save data to DB
      set_data_with_comp_pk('video', $keys, $video);
    }
  }
  if(array_key_exists('polyline', $pano_video_data)) {
    $trans_id_table['polyline'] = array();
    for($i=0; $i<count($pano_video_data['polyline']); $i++) {
      $polyline = $pano_video_data['polyline'][$i];

      //save old_id and new_id
      $old_id = $polyline['polyline_id'];
      $new_id = alloc_new_id('polyline', 'polyline_id');      
      $trans_id_table['polyline'][$old_id] = $new_id;

      $polyline['layer_id'] = $trans_id_table['layer'][$polyline['layer_id']];
      $polyline['video_id'] = $trans_id_table['video'][$polyline['video_id']];

      //delete id from array to save data correctly
      $keys = array();
      $keys['polyline_id'] = $new_id;
      unset($polyline['polyline_id']);

      //save data to DB
      set_data_with_comp_pk('polyline', $keys, $polyline);
    }
  }  
  if(array_key_exists('timeline', $pano_video_data)) {
    $trans_id_table['timeline'] = array();
    for($i=0; $i<count($pano_video_data['timeline']); $i++) {
      $timeline = $pano_video_data['timeline'][$i];

      //alloc new id
      $new_id = alloc_new_id('timeline', 'timeline_id');      

      //transform old data into new data
      $timeline['polyline_id'] = $trans_id_table['polyline'][$timeline['polyline_id']];
      $timeline['orders'] = $timeline['order'];
      //encode from text to geom data
      $timeline['latlngs'] = geom_from_text($timeline['latlngs']);

      unset($timeline['order']);

      //delete id from array to save data correctly
      $keys = array();
      $keys['timeline_id'] = $new_id;

      //save data to DB
      set_data_with_comp_pk('timeline', $keys, $timeline);
    }
  }

  // remove the temp zip folder
  removeDir($zip_folder_path);
}
?>