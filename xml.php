<?php
include "_db.php";
include "_xml.php";

if($_GET['req'] == 'addHotspot'){
	$data = $_GET['data'];
	$data['options']['krpano_name'] = $data['krpanoName'];

	return add_hotspot($data['xmlUrl'], $data['scene'], $data['id'], $data['ath'], $data['atv'], $data['iconUrl'], $data['options']);
}

else if($_GET['req'] == 'setHotspot'){
	$data = $_GET['data'];
	$data['options']['krpano_name'] = $data['krpanoName'];

	if(!isset($data['scene'])) 	$data['scene'] = NULL;
	if(!isset($data['ath'])) 	$data['ath'] = NULL;
	if(!isset($data['atv'])) 	$data['scene'] = NULL;
	if(!isset($data['iconUrl']))	$data['iconUrl'] = NULL;
	if(!isset($data['krpanoName']))	$data['krpanoName'] = NULL;

	return set_hotspot($data['xmlUrl'], $data['scene'], $data['id'], $data['ath'], $data['atv'], $data['iconUrl'], $data['options']);
}

if($_GET['req'] == 'delHotspot'){
	$data = $_GET['data'];	

	return remove_hotspot($data['xmlUrl'], $data['id']);
}

if($_GET['req'] == 'addScene'){
	$data = $_GET['data'];
	$image_data = null;
	if(isset($data['options']['pvrPath'])){
		$new_id = str_replace("s","",$data['id']);
		$image_data = extract_image_data($data['options']['pvrPath'].'/pano.xml', "pvr/$new_id/");
	}
	add_scene($data['xmlUrl'], $data['id'], $image_data, $data['options']);
	return;
}
if($_GET['req'] == 'setScene'){
	$data = $_GET['data'];
	if($data['key'] == 'pvrPath'){
		$new_id = str_replace("s","",$data['id']);
		$image_data = extract_image_data($data['val'].'/pano.xml', "pvr/$new_id/");
		set_scene($data['xmlUrl'], $data['id'], $image_data);
	}
	else{
		set_scene($data['xmlUrl'], $data['id'], null, array($data['key']=>$data['val']));
	}
}
if($_GET['req'] == 'delScene'){
	$data = $_GET['data'];	
	return remove_scene($data['xmlUrl'], $data['id']);
}

if($_GET['req'] == 'addTextfield'){
	$data = $_GET['data'];
	return add_textfield($data['xmlUrl'], $data['name'], $data['sceneName'], $data['hotspotName'], $data['options']);
}
if($_GET['req'] == 'setTextfield'){
	$data = $_GET['data'];
	return set_textfield($data['xmlUrl'], $data['name'], $data['sceneName'], $data['hotspotName'], $data['options']);
}
?>