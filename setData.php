<?php
include "_db.php";
include "_file.php";

if($_POST['req'] == "setData"){	
	if($_POST['data']['options']['type'] == "project"){
		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['name'])){
			array_push($idx, 'project_name');
			array_push($values, $_POST['data']['options']['name']);
			set_data('project', 'project_id', $_POST['data']['id'], $idx, $values);
		}

		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['userId'])){
			array_push($idx, 'user_id');
			array_push($values, $_POST['data']['options']['userId']);
			set_data('work_on', 'project_id', $_POST['data']['id'], $idx, $values);
		}
	}
	if($_POST['data']['options']['type'] == "layer"){
		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['name'])){
			array_push($idx, 'layer_name');
			array_push($values, $_POST['data']['options']['name']);
		}
		if(isset($_POST['data']['options']['mapId'])){
			array_push($idx, 'map_id');
			array_push($values, $_POST['data']['options']['mapId']);
		}
		if(isset($_POST['data']['tileUrl'])){
			array_push($idx, 'tile_url');
			array_push($values, $_POST['data']['tileUrl']);
		}
		if(isset($_POST['data']['options']['minZoom'])){
			array_push($idx, 'min_zoom');
			array_push($values, $_POST['data']['options']['minZoom']);
		}
		if(isset($_POST['data']['options']['maxZoom'])){
			array_push($idx, 'max_zoom');
			array_push($values, $_POST['data']['options']['maxZoom']);
		}
		if(isset($_POST['data']['options']['tileImageType'])){
			array_push($idx, 'tile_image_type');
			array_push($values, $_POST['data']['options']['tileImageType']);
		}
		if(isset($_POST['data']['options']['mainView'])){
			if(isset($_POST['data']['options']['mainView']['latlng'])){
				if(isset($_POST['data']['options']['mainView']['latlng']['lat'])){
					array_push($idx, 'main_view_lat');
					array_push($values, $_POST['data']['options']['mainView']['latlng']['lat']);
				}
				if(isset($_POST['data']['options']['mainView']['latlng']['lng'])){
					array_push($idx, 'main_view_lng');
					array_push($values, $_POST['data']['options']['mainView']['latlng']['lng']);
				}				
			}
			if(isset($_POST['data']['options']['mainView']['zoom'])){
				array_push($idx, 'main_view_zoom');
				array_push($values, $_POST['data']['options']['mainView']['zoom']);
			}
		}
		if(isset($_POST['data']['options']['order'])){
			array_push($idx, 'orders');
			array_push($values, $_POST['data']['options']['order']);
		}

		if(isset($_POST['data']['options']['mainPvr'])){
			array_push($idx, 'main_pvr_id');
			array_push($values, $_POST['data']['options']['mainPvr']);
		}
		set_data('layer', 'layer_id', $_POST['data']['id'], $idx, $values);
	}
	if($_POST['data']['options']['type'] == "vtour"){
		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['name'])){
			array_push($idx, 'vtour_name');
			array_push($values, $_POST['data']['options']['name']);
		}
		if(isset($_POST['data']['options']['mainPvr'])){
			array_push($idx, 'main_pvr_id');
			array_push($values, $_POST['data']['options']['mainPvr']);
		}	
		if(isset($_POST['data']['options']['order'])){
			array_push($idx, 'orders');
			array_push($values, $_POST['data']['options']['order']);
		}
		if(isset($_POST['data']['xmlPath'])){
			array_push($idx, 'xml_path');
			array_push($values, $_POST['data']['xmlPath']);
		}
		if(isset($_POST['data']['locationAddress'])){
			array_push($idx, 'location_address');
			array_push($values, $_POST['data']['locationAddress']);
		}
		if(isset($_POST['data']['publicVtour'])){
			array_push($idx, 'public_vtour');
			array_push($values, $_POST['data']['publicVtour']);
		}
		set_data('vtour', 'vtour_id', $_POST['data']['id'], $idx, $values);

		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['layerId'])){
			array_push($idx, 'layer_id');
			array_push($values, $_POST['data']['options']['layerId']);
		}
		if(isset($_POST['data']['latlng'])){
			if(isset($_POST['data']['latlng']['lat'])){
				array_push($idx, 'lat');
				array_push($values, $_POST['data']['latlng']['lat']);
			}
			if(isset($_POST['data']['latlng']['lng'])){
				array_push($idx, 'lng');
				array_push($values, $_POST['data']['latlng']['lng']);
			}
		}
		if(isset($_POST['data']['zoom'])){
			array_push($idx, 'zoom');
			array_push($values, $_POST['data']['zoom']);
		}		

		set_data('area', 'area_id', $_POST['data']['id'], $idx, $values);
	}
	if($_POST['data']['options']['type'] == "pvr"){
		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['name'])){
			array_push($idx, 'pvr_name');
			array_push($values, $_POST['data']['options']['name']);
		}
		if(isset($_POST['data']['options']['vtourId'])){
			array_push($idx, 'vtour_id');
			array_push($values, $_POST['data']['options']['vtourId']);
		}
		if(isset($_POST['data']['options']['pvrPath'])){
			array_push($idx, 'pvr_path');
			array_push($values, $_POST['data']['options']['pvrPath']);
		}
		if(isset($_POST['data']['options']['initialAth'])){
			array_push($idx, 'hlookat');
			array_push($values, $_POST['data']['options']['initialAth']);
		}
		if(isset($_POST['data']['options']['initialAtv'])){
			array_push($idx, 'vlookat');
			array_push($values, $_POST['data']['options']['initialAtv']);
		}
		if(isset($_POST['data']['options']['initialFov'])){
			array_push($idx, 'fov');
			array_push($values, $_POST['data']['options']['initialFov']);
		}
		if(isset($_POST['data']['options']['order'])){
			array_push($idx, 'orders');
			array_push($values, $_POST['data']['options']['order']);
		}
		set_data('pvr', 'pvr_id', $_POST['data']['id'], $idx, $values);
	}
	if($_POST['data']['options']['type'] == "markerIcon"){
		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['projectId'])){
			array_push($idx, 'project_id');
			array_push($values, $_POST['data']['options']['projectId']);
		}
		if(isset($_POST['data']['options']['order'])){
			array_push($idx, 'orders');
			array_push($values, $_POST['data']['options']['order']);
		}
		if(isset($_POST['data']['options']['desc'])){
			array_push($idx, 'icon_description');
			array_push($values, $_POST['data']['options']['desc']);
		}
		if(isset($_POST['data']['options']['actionType'])){
			array_push($idx, 'action_type');
			array_push($values, $_POST['data']['options']['actionType']);
		}
		set_data('marker_icon', 'icon_id', $_POST['data']['id'], $idx, $values);
		echo $_POST['data']['id'];

		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['iconUrl'])){
			array_push($idx, 'img_url');
			array_push($values, $_POST['data']['options']['iconUrl']);
		}
		if(isset($_POST['data']['options']['size'])){
			if(isset($_POST['data']['options']['size']['x'])){
				array_push($idx, 'width');
				array_push($values, $_POST['data']['options']['size']['x']);
			}
			if(isset($_POST['data']['options']['size']['y'])){
				array_push($idx, 'height');
				array_push($values, $_POST['data']['options']['size']['y']);
			}			
		}
		
		set_data('marker_display', 'icon_id', $_POST['data']['id'], $idx, $values);		
	}
	if($_POST['data']['options']['type'] == "marker"){
		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['layerId'])){
			array_push($idx, 'layer_id');
			array_push($values, $_POST['data']['options']['layerId']);
		}
		if(isset($_POST['data']['options']['icon'])){
			array_push($idx, 'icon_id');
			array_push($values, $_POST['data']['options']['icon']);
		}
		if(isset($_POST['data']['latlng'])){
			if(isset($_POST['data']['latlng']['lat'])){
				array_push($idx, 'lat');
				array_push($values, $_POST['data']['latlng']['lat']);
			}
			if(isset($_POST['data']['latlng']['lng'])){
				array_push($idx, 'lng');
				array_push($values, $_POST['data']['latlng']['lng']);
			}
		}
		
		if(isset($_POST['data']['options']['minLevel'])){
			array_push($idx, 'min_zoom');
			array_push($values, $_POST['data']['options']['minLevel']);
		}
		if(isset($_POST['data']['options']['maxLevel'])){
			array_push($idx, 'max_zoom');
			array_push($values, $_POST['data']['options']['maxLevel']);
		}

		if(isset($_POST['data']['options']['actionType'])){
			array_push($idx, 'action_type');
			array_push($values, $_POST['data']['options']['actionType']);
		}
		set_data('marker', 'marker_id', $_POST['data']['id'], $idx, $values);

		if($_POST['data']['options']['actionType'] == "linkToPvr"){
			$idx = array();
			$values = array();
			if(isset($_POST['data']['options']['linkedPvr'])){
				array_push($idx, 'pvr_id');
				array_push($values, $_POST['data']['options']['linkedPvr']);
			}
			set_data('m_link_pvr', 'marker_id', $_POST['data']['id'], $idx, $values);

			$idx = array();
			$values = array();
			if(isset($_POST['data']['options']['informType'])){
				array_push($idx, 'inform_type');
				array_push($values, $_POST['data']['options']['informType']);
			}
			if(isset($_POST['data']['options']['informText'])){
				array_push($idx, 'inform_text');
				array_push($values, $_POST['data']['options']['informText']);
			}
			if(isset($_POST['data']['options']['informImgUrl'])){
				array_push($idx, 'inform_img_url');
				array_push($values, $_POST['data']['options']['informImgUrl']);
			}
			if(isset($_POST['data']['options']['informTitle'])){
				array_push($idx, 'inform_title');
				array_push($values, $_POST['data']['options']['informTitle']);
			}
			set_data('m_link_inform', 'marker_id', $_POST['data']['id'], $idx, $values);

			$idx = array();
			$values = array();
			if(isset($_POST['data']['options']['linkedUrl'])){
				array_push($idx, 'linked_url');
				array_push($values, $_POST['data']['options']['linkedUrl']);
			}
			set_data('m_link_url', 'marker_id', $_POST['data']['id'], $idx, $values);
		}

		if($_POST['data']['options']['actionType'] == "linkToVtour"){
			$idx = array();
			$values = array();
			if(isset($_POST['data']['options']['linkedVtour'])){
				array_push($idx, 'vtour_id');
				array_push($values, $_POST['data']['options']['linkedVtour']);
			}
			set_data('m_link_vtour', 'marker_id', $_POST['data']['id'], $idx, $values);
		}

		if($_POST['data']['options']['actionType'] == "showInform"){
			$idx = array();
			$values = array();
			if(isset($_POST['data']['options']['informType'])){
				array_push($idx, 'inform_type');
				array_push($values, $_POST['data']['options']['informType']);
			}
			if(isset($_POST['data']['options']['informText'])){
				array_push($idx, 'inform_text');
				array_push($values, $_POST['data']['options']['informText']);
			}
			if(isset($_POST['data']['options']['informImgUrl'])){
				array_push($idx, 'inform_img_url');
				array_push($values, $_POST['data']['options']['informImgUrl']);
			}
			if(isset($_POST['data']['options']['informTitle'])){
				array_push($idx, 'inform_title');
				array_push($values, $_POST['data']['options']['informTitle']);
			}
			set_data('m_link_inform', 'marker_id', $_POST['data']['id'], $idx, $values);

			$idx = array();
			$values = array();
			if(isset($_POST['data']['options']['linkedUrl'])){
				array_push($idx, 'linked_url');
				array_push($values, $_POST['data']['options']['linkedUrl']);
			}
			set_data('m_link_url', 'marker_id', $_POST['data']['id'], $idx, $values);
		}
	}
	if($_POST['data']['options']['type'] == "hotspotIcon"){
		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['projectId'])){
			array_push($idx, 'project_id');
			array_push($values, $_POST['data']['options']['projectId']);
		}
		if(isset($_POST['data']['options']['order'])){
			array_push($idx, 'orders');
			array_push($values, $_POST['data']['options']['order']);
		}
		if(isset($_POST['data']['options']['desc'])){
			array_push($idx, 'icon_description');
			array_push($values, $_POST['data']['options']['desc']);
		}
		if(isset($_POST['data']['options']['actionType'])){
			array_push($idx, 'action_type');
			array_push($values, $_POST['data']['options']['actionType']);
		}
		set_data('hotspot_icon', 'icon_id', $_POST['data']['id'], $idx, $values);

		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['iconUrl'])){
			array_push($idx, 'img_url');
			array_push($values, $_POST['data']['options']['iconUrl']);
		}
		if(isset($_POST['data']['options']['size'])){
			if(isset($_POST['data']['options']['size']['x'])){
				array_push($idx, 'width');
				array_push($values, $_POST['data']['options']['size']['x']);
			}
			if(isset($_POST['data']['options']['size']['y'])){
				array_push($idx, 'height');
				array_push($values, $_POST['data']['options']['size']['y']);
			}			
		}		
		set_data('hotspot_display', 'icon_id', $_POST['data']['id'], $idx, $values);
	}
	if($_POST['data']['options']['type'] == "hotspot"){
		$idx = array();
		$values = array();
		if(isset($_POST['data']['options']['sceneId'])){
			array_push($idx, 'pvr_id');
			array_push($values, $_POST['data']['options']['sceneId']);
		}
		if(isset($_POST['data']['options']['icon'])){
			array_push($idx, 'icon_id');
			array_push($values, $_POST['data']['options']['icon']);
		}
		if(isset($_POST['data']['ath'])){
			array_push($idx, 'ath');
			array_push($values, $_POST['data']['ath']);
		}
		if(isset($_POST['data']['atv'])){
			array_push($idx, 'atv');
			array_push($values, $_POST['data']['atv']);
		}
		
		if(isset($_POST['data']['options']['actionType'])){
			array_push($idx, 'action_type');
			array_push($values, $_POST['data']['options']['actionType']);
		}

		if(isset($_POST['data']['options']['sceneId'])){
			array_push($idx, 'pvr_id');
			array_push($values, $_POST['data']['options']['sceneId']);
		}
		set_data('hotspot', 'hotspot_id', $_POST['data']['id'], $idx, $values);

		$idx = array();
		$values = array();
		if($_POST['data']['options']['actionType'] == "linkToPvr"){			
			if(isset($_POST['data']['options']['linkedPvr'])){
				array_push($idx, 'pvr_id');
				array_push($values, $_POST['data']['options']['linkedPvr']);
			}
			set_data('h_link_pvr', 'hotspot_id', $_POST['data']['id'], $idx, $values);
		}
		else if($_POST['data']['options']['actionType'] == "showInform"){
			if(isset($_POST['data']['options']['textInfo'])){
				array_push($idx, 'html');
				array_push($values, $_POST['data']['options']['textInfo']);
			}
			set_data('h_link_inform', 'hotspot_id', $_POST['data']['id'], $idx, $values);
		}			
	}
	if($_POST['data']['options']['type'] == "projectMarker"){
		$idx = array();
		$values = array();
		if(isset($_POST['data']['latlng'])){
			if(isset($_POST['data']['latlng']['lat'])){
				array_push($idx, 'lat');
				array_push($values, $_POST['data']['latlng']['lat']);
			}
			if(isset($_POST['data']['latlng']['lng'])){
				array_push($idx, 'lng');
				array_push($values, $_POST['data']['latlng']['lng']);
			}
		}
		
		if(isset($_POST['data']['options']['minLevel'])){
			array_push($idx, 'min_zoom');
			array_push($values, $_POST['data']['options']['minLevel']);
		}
		if(isset($_POST['data']['options']['maxLevel'])){
			array_push($idx, 'max_zoom');
			array_push($values, $_POST['data']['options']['maxLevel']);
		}
		set_data('project_marker', 'project_id', $_POST['data']['id'], $idx, $values);					
	}	
}

if($_POST['req'] == "delData"){
	if($_POST['data']['options']['type'] == "project"){
		del_data('project', 'project_id', $_POST['data']['id']);
		removeDir("project/{$_POST['data']['id']}");
	}
	if($_POST['data']['options']['type'] == "layer"){
		del_data('layer', 'layer_id', $_POST['data']['id']);
	}
	if($_POST['data']['options']['type'] == "vtour"){
		del_data('vtour', 'vtour_id', $_POST['data']['id']);
	}
	if($_POST['data']['options']['type'] == "pvr"){
		del_data('pvr', 'pvr_id', $_POST['data']['id']);
	}
	if($_POST['data']['options']['type'] == "markerIcon"){
		del_data('marker_icon', 'icon_id', $_POST['data']['id']);
	}
	if($_POST['data']['options']['type'] == "marker"){
		del_data('marker', 'marker_id', $_POST['data']['id']);
	}
	if($_POST['data']['options']['type'] == "hotspotIcon"){
		del_data('hotspot_icon', 'icon_id', $_POST['data']['id']);
	}
	if($_POST['data']['options']['type'] == "hotspot"){
		del_data('hotspot', 'hotspot_id', $_POST['data']['id']);
	}
}

if($_POST['req'] == "setPreviewData"){
	session_start();
	$_SESSION['project_id'] = $_POST['data']['projectId'];
	session_write_close(); 
}

if($_POST['req'] == "clearPreviewData"){
	session_start();
	unset($_SESSION['project_id']); 
	session_write_close();
}
?>