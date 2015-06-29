<?php
include_once("_db.php");

/**
 * decode_pano_video_json
 * decode pano video json to array for map_editor
 * 
 * @param json_path 
 *  json_file_path
 */
function decode_pano_video_json($json_path) {
  $json_string = file_get_contents($json_path);
  $json_string = str_replace('var data = ', '', $json_string);

  $pano_video_json = json_decode($json_string, TRUE);

  $google_map_tile_url = 'https//mts1.google.com/vt/lyrs=m@231000000&hl=ko&gl=KR&src=app&x={x}&y={y}&z={z}&s={s}';

  $items = array();
  if(array_key_exists('floorList', $pano_video_json) 
    && array_key_exists('tileList', $pano_video_json)) {
    $floor_list = $pano_video_json['floorList'];
    $tile_list = $pano_video_json['tileList'];
    
    $items['layer'] = array();
    for($i=0; $i<count($floor_list); $i++) {
      $floor = $floor_list[$i];
      for($j=0; $j<count($tile_list); $j++) {
        if($floor['tile'] == $tile_list[$j]['id']){
          $tile = $tile_list[$j];
          break;
        }
      }

      $items['layer'][] = array(
        'layer_id' => $floor['id'],
        'layer_name' => $floor['name'],
        'tile_url' => $tile['url'],
        'min_zoom' => $tile['minZoom'],
        'max_zoom' => $tile['maxZoom'],
        'main_view_lat' => $floor['lastLatLng'][0],
        'main_view_lng' => $floor['lastLatLng'][1],
        'main_view_zoom' => $floor['lastZoom'],
        'tile_image_type' => $tile['url'] == $google_map_tile_url? 'presetMap': 'userMap',
      );
    }
  }

  if(array_key_exists('iconList', $pano_video_json)) {
    $icon_list = $pano_video_json['iconList'];
    
    $items['marker_icon'] = array();
    $items['marker_display'] = array();
    for($i=0; $i<count($icon_list); $i++) {
      $icon = $icon_list[$i];
      //project_id, order 정보는 추후에 넣어야함
      $items['marker_icon'][] = array(
        'icon_id' => $icon['id'],
        'action_type' => 'none',
      );
      $items['marker_display'][] = array(
        'icon_id' => $icon['id'],
        'img_url' => $icon['url'],
        'width' => $icon['width'],
        'height' => $icon['height'],
        'type' => 'normal',
      );
    }
  }

  if(array_key_exists('markerList', $pano_video_json)) {
    $marker_list = $pano_video_json['markerList'];

    $items['marker'] = array();
    $items['m_link_inform'] = array();
    $items['m_link_url'] = array();
    for($i=0; $i<count($marker_list); $i++) {
      $marker = $marker_list[$i];
      
      $items['marker'][] = array(
        'marker_id' => $marker['id'],
        'layer_id' => $marker['floor'],
        'min_zoom' => $marker['levelBound']['min'],
        'max_zoom' => $marker['levelBound']['max'],
        'lat' => $marker['latlng']['lat'],
        'lng' => $marker['latlng']['lng'],
        'icon_id' => $marker['icon'],
        'action_type' => 'showInform'
      );

      $items['m_link_inform'][] = array(
        'marker_id' => $marker['id'],
        'inform_title' => $marker['label'],
        'inform_text' => $marker['popup'],
        'inform_type' => $marker['url']? 'url': 'text',
      );

      $items['m_link_url'][] = array(
        'marker_id' => $marker['id'],
        'linked_url' => $marker['url'],
      );
    }
  }

  if(array_key_exists('videoList', $pano_video_json)) {
    $video_list = $pano_video_json['videoList'];

    $items['video'] = array();
    for($i=0; $i<count($video_list); $i++) {
      $video = $video_list[$i];

      $items['video'][] = array(
        'video_id' => $video['id'],
        'name' => $video['name'],
        'url' => $video['url'],
      );
    }
  }

  if(array_key_exists('polylineList', $pano_video_json)) {
    $polyline_list = $pano_video_json['polylineList'];

    $items['polyline'] = array();
    $items['timeline'] = array();
    for($i=0; $i<count($polyline_list); $i++) {
      $polyline = $polyline_list[$i];

      $items['polyline'][] = array(
        'polyline_id' => $polyline['id'],
        'layer_id' => $polyline['floor'],
        'min_zoom' => $polyline['levelBound']['min'],
        'max_zoom' => $polyline['levelBound']['max'],
        'video_id' => $polyline['video'],
      );

      for($j=0; $j<count($polyline['timelineList']); $j++) {
        $timeline = $polyline['timelineList'][$j];

        //make latlngs data to string for db
        $latlngs = 'Linestring(';
        for($k=0; $k<count($timeline['latlngs'])-1; $k++) {
          $latlngs .= "{$timeline['latlngs'][$k]['lat']} {$timeline['latlngs'][$k]['lng']},";
        }
        $latlngs .= "{$timeline['latlngs'][$k]['lat']} {$timeline['latlngs'][$k]['lng']})";

        $items['timeline'][] = array(
          'polyline_id' => $polyline['id'],
          'order' => $j,
          'per_at_start' => $timeline['perAtStart'],
          'per_at_end' => $timeline['perAtEnd'],
          'latlngs' => $latlngs,
        );
      }
    }
  }

  return $items;
}
