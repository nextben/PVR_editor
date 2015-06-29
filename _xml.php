<?php

/*
option:
	image:
		width:
		height
	action:
		type: [
			move_scene
			hyperlink
			show_inform
		]
		data: [scene_name
			link_dest_url
			content
		]
		*remove: bool
	tooltip:
		content: 
		*remove: bool
	alpha:

*/

/*function set_hotspot($xml, $scene_name, $id, $ath=NULL, $atv=NULL, $image_url=NULL, $option=[]){
	$dom = new DOMDocument();
	$dom->load($xml);

	//scene이 있으면 그 밑에 핫스팟이 추가되고 아니면 krpano자체에 추가된다.
	if($scene_name){
		$scene_list = $dom->getElementsByTagName('scene');
		for($i=0; $i<$scene_list->length; $i++){
			if($scene_list->item($i)->getAttribute('name') == $scene_name) 
				$scene =  $scene_list->item($i);
		}
	}
	else{
		$scene = $dom->getElementsByTagName('krpano')->item(0);		
	}

	//scene내에서 같은 id를 가지는 hotspot이 있는지 찾는다.
	$update_flag = false;
	foreach($scene->childNodes as $child){
		if($child->nodeType == 1 && $child->tagName == 'hotspot' 
		&& $child->getAttribute('name') == $id){
			$hotspot = $child;
			$update_flag = true;
			break;
		} 
	}

	//업데이트인 경우. 비어있는 값에 대해서는 따로 갱신하지 않는다.
	if($update_flag){
		if($ath !== NULL)
			$hotspot->setAttribute('ath', $ath);
		if($atv !== NULL)
			$hotspot->setAttribute('atv', $atv);
		if($image_url !== NULL)
			$hotspot->setAttribute('url', $image_url);
	}
	//새로 추가하는 경우 필수 값 중에 빈 값이 있다면, 진행을 중지한다.
	else {
		$hotspot = $dom->createElement('hotspot');
		if($id === NULL || $ath === NULL || $atv === NULL || $image_url === NULL) return false;
		$hotspot->setAttribute('name', $id);		
		$hotspot->setAttribute('ath', $ath);
		$hotspot->setAttribute('atv', $atv);
		$hotspot->setAttribute('url', $image_url);
	}
	//hotspot의 크기를 결정. ""값을 넘기면 초기 값으로 지정된다.
	if(isset($option['img']['width'])){
		$hotspot->setAttribute('width', $option['img']['width']);
	}
	if(isset($option['img']['height'])){
		$hotspot->setAttribute('height', $option['img']['height']);
	}

	//핫스팟을 클릭했을 때 반응. remove값을 설정하면 설정값 제거
	if(isset($option['action'])){
		if(isset($option['action']['remove']) && $option['action']['remove'])
			$hotspot->removeAttribute('onclick');
		else if(isset($option['action']['type']) && $option['action']['type'] == 'load_scene')
			$hotspot->setAttribute('onclick', "loadscene({$option['action']['data']['scene_name']})");
		else if(isset($option['action']['type']) && $option['action']['type'] == 'link_url')
			$hotspot->setAttribute('onclick', "openurl('{$option['action']['data']['page_url']}')");
	}
	

	//tooltip값. remove값을 설정하면 설정값
	if(isset($option['tooltip'])){
		if(isset($option['tooltip']['remove']) && $option['tooltip']['remove']){
			$hotspot->removeAttribute('onhover');
			$hotspot->removeAttribute('onout');
		}
		else if(isset($option['tooltip']['content'])){
			$hotspot->setAttribute('onhover', "set(layer[{$id}_tooltip].visible, true);".
				"set(layer[{$id}_tooltip].x, get(mouse.x));".
				"set(layer[{$id}_tooltip].y, get(mouse.y));".
				"sub(layer[{$id}_tooltip].y, 20);"
			);
			$hotspot->setAttribute('onout', "set(layer[{$id}_tooltip].visible, false)");
		}
	}
	$scene->appendChild($hotspot);
	$dom->save($xml);
	if(isset($option['tooltip'])){
		if(isset($option['tooltip']['remove']) && $option['tooltip']['remove']){
			remove_textfield($xml, $scene_name, "{$id}_tooltip");
		}
		else {
			set_textfield($xml, $scene_name, "{$id}_tooltip", $option['tooltip']['content'], 
				['align'=>'lefttop', 'x'=>'0', 'y'=>'0'], ['visible'=>'false', 'edge'=>'bottom']);
		}
	}
	return $id;
}*/

function add_hotspot($xml, $scene_id, $id, $ath, $atv, $icon_url, $options=[]){
	$dom = new DOMDocument();
	$dom->load($xml);

	$scene_list = $dom->getElementsByTagName('scene');
	for($i=0; $i<$scene_list->length; $i++){
		if($scene_list->item($i)->getAttribute('name') == $scene_id){ 
			$scene = $scene_list->item($i);
		}
	}

	$simple_id = str_replace("h", "", $id);
	$hotspot = $dom->createElement('hotspot');
	$hotspot->setAttribute('name', $id);		
	$hotspot->setAttribute('ath', $ath);
	$hotspot->setAttribute('atv', $atv);
	$hotspot->setAttribute('url', $icon_url);
	$hotspot->setAttribute('onclick', "js({$options['krpano_name']}.hotspotList[".$simple_id."].fire('click'))");
	$hotspot->setAttribute('ondown', "js({$options['krpano_name']}.hotspotList[".$simple_id."].fire('mousedown'))");
	$hotspot->setAttribute('onup', "js({$options['krpano_name']}.hotspotList[".$simple_id."].fire('mouseup'))");


	echo "js(\"{$options['krpano_name']}[".$simple_id."].fire('click')\")";
	
	//hotspot의 크기를 결정. ""값을 넘기면 초기 값으로 지정된다.
	if(isset($option['icon']['options']['size']['x'])){
		$hotspot->setAttribute('width', $options['icon']['options']['size']['x']);
	}
	if(isset($option['icon']['options']['size']['y'])){
		$hotspot->setAttribute('height', $options['icon']['options']['size']['y']);
	}

	//핫스팟을 클릭했을 때 반응. remove값을 설정하면 설정값 제거
	/*if(isset($option['action'])){
		if(isset($option['action']['remove']) && $option['action']['remove'])
			$hotspot->removeAttribute('onclick');
		else if(isset($option['action']['type']) && $option['action']['type'] == 'load_scene')
			$hotspot->setAttribute('onclick', "loadscene({$option['action']['data']['scene_name']})");
		else if(isset($option['action']['type']) && $option['action']['type'] == 'link_url')
			$hotspot->setAttribute('onclick', "openurl('{$option['action']['data']['page_url']}')");
	}*/
	

	//tooltip값. remove값을 설정하면 설정값
	/*if(isset($option['tooltip'])){
		if(isset($option['tooltip']['remove']) && $option['tooltip']['remove']){
			$hotspot->removeAttribute('onhover');
			$hotspot->removeAttribute('onout');
		}
		else if(isset($option['tooltip']['content'])){
			$hotspot->setAttribute('onhover', "set(layer[{$id}_tooltip].visible, true);".
				"set(layer[{$id}_tooltip].x, get(mouse.x));".
				"set(layer[{$id}_tooltip].y, get(mouse.y));".
				"sub(layer[{$id}_tooltip].y, 20);"
			);
			$hotspot->setAttribute('onout', "set(layer[{$id}_tooltip].visible, false)");
		}
	}*/
	$lastText = $scene->removeChild($scene->lastChild);
	$scene->appendChild($dom->createTextNode("\n\t\t"));
	$scene->appendChild($hotspot);
	$scene->appendChild($lastText);
	$dom->save($xml);
	/*if(isset($option['tooltip'])){
		if(isset($option['tooltip']['remove']) && $option['tooltip']['remove']){
			remove_textfield($xml, $scene_name, "{$id}_tooltip");
		}
		else {
			set_textfield($xml, $scene_name, "{$id}_tooltip", $option['tooltip']['content'], 
				['align'=>'lefttop', 'x'=>'0', 'y'=>'0'], ['visible'=>'false', 'edge'=>'bottom']);
		}
	}*/
	return $id;
}
function set_hotspot($xml, $scene_id, $id, $ath=NULL, $atv=NULL, $icon_url=NULL, $options=[]){
	$dom = new DOMDocument();
	$dom->load($xml);

	$scene_list = $dom->getElementsByTagName('scene');
	for($i=0; $i<$scene_list->length; $i++){
		if($scene_list->item($i)->getAttribute('name') == $scene_id){ 
			$scene = $scene_list->item($i);
		}
	}
	$hotspot_list = $dom->getElementsByTagName('hotspot');
	for($i=0; $i<$hotspot_list->length; $i++){
		if($hotspot_list->item($i)->getAttribute('name') == $id){ 
			$hotspot = $hotspot_list->item($i);
		}
	}

	$simple_id = str_replace("h", "", $id);

	if($ath!== NULL){
		$hotspot->setAttribute('ath', $ath);
	}
	if($atv!==NULL){
		$hotspot->setAttribute('atv', $atv);
	}
	if($icon_url!==NULL){
		$hotspot->setAttribute('url', $icon_url);
	}	
	if(isset($options['krpano_name'])){
		$hotspot->setAttribute('onclick', "js({$options['krpano_name']}.hotspotList[".$simple_id."].fire('click'))");
		$hotspot->setAttribute('ondown', "js({$options['krpano_name']}.hotspotList[".$simple_id."].fire('mousedown'))");
		$hotspot->setAttribute('onup', "js({$options['krpano_name']}.hotspotList[".$simple_id."].fire('mouseup'))");
	}
	
	//hotspot의 크기를 결정. ""값을 넘기면 초기 값으로 지정된다.
	if(isset($option['icon']['options']['size']['x'])){
		$hotspot->setAttribute('width', $options['icon']['options']['size']['x']);
	}
	if(isset($option['icon']['options']['size']['y'])){
		$hotspot->setAttribute('height', $options['icon']['options']['size']['y']);
	}

	$dom->save($xml);
	return $id;
}
function remove_hotspot($xml, $id){
	$dom = new DOMDocument();
	$dom->load($xml);

	$hotspot_list = $dom->getElementsByTagName('hotspot');
	for($i=0; $i<$hotspot_list->length; $i++){
		if($hotspot_list->item($i)->getAttribute('name') == $id){
			$hotspot = $hotspot_list->item($i);
			$hotspot->parentNode->removeChild($hotspot->previousSibling);
			$hotspot->parentNode->removeChild($hotspot);
		} 
	}
	$dom->save($xml);
	return $id;
}

//scene을 수정하는 함수
function set_scene($xml, $id, $img=NULL, $options=[]){
	$dom = new DOMDocument();
	$dom->load($xml);

	$krpano = $dom->getElementsByTagName('krpano')->item(0);

	foreach($krpano->childNodes as $child){
		if($child->nodeType == 1 && $child->tagName == 'scene' && $child->getAttribute('name') == $id){
			$scene = $child;
			break;
		}
	}

	if($img!==NULL){
		$newId = str_replace("s", "", $id);
		$scene->setAttribute('thumburl', "pvr/$newId/pano.tiles/thumb.jpg");
		foreach($scene->childNodes as $child){
			if($child->nodeType == 1 && $child->tagName == 'image'){
				$prev = $child->previousSibling;
				$next = $child->nextSibling;

				$scene->removeChild($prev);
				$scene->removeChild($child);
			} 
		}

		$image = $dom->createElement('image');
		$image->setAttribute('type', 'CUBE');
		$image->setAttribute('multires', 'true');
		$image->setAttribute('tilesize', '512');
		$image->setAttribute('progressive', 'true');

		for($i=0; $i<count($img); $i++){
			$level = $dom->createElement('level');
			$level->setAttribute('tiledimagewidth', $img[$i]['size']);
			$level->setAttribute('tiledimageheight', $img[$i]['size']);


			$cube = $dom->createElement('cube');
			$cube->setAttribute('url', $img[$i]['url']);

			$level->appendChild($dom->createTextNode("\n\t\t\t\t"));
			$level->appendChild($cube);			
			$level->appendChild($dom->createTextNode("\n\t\t\t"));

			$image->appendChild($dom->createTextNode("\n\t\t\t"));
			$image->appendChild($level);				
		}
		$image->appendChild($dom->createTextNode("\n\t\t"));

		$lastText = $scene->removeChild($scene->lastChild);
		$scene->appendChild($dom->createTextNode("\n\t\t"));
		$scene->appendChild($image);
		$scene->appendChild($lastText);
	}

	foreach($scene->childNodes as $child){
		if($child->nodeType == 1 && $child->tagName == 'view'){
			$view = $child;
		}
	}
	if(isset($options['name'])){
		$scene->setAttribute('title', $options['name']);
	}
	if(isset($options['initialAth'])){
		$view->setAttribute('hlookat', $options['initialAth']);
	}
	if(isset($options['initialAtv'])){
		$view->setAttribute('vlookat', $options['initialAtv']);
	}
	if(isset($options['initialFov'])){
		$view->setAttribute('fov', $options['initialFov']);
	}

	$dom->save($xml);
	return $id;
}
function add_scene($xml, $id, $img=NULL, $option=[]){
	$dom = new DOMDocument();
	$dom->load($xml);

	$krpano = $dom->getElementsByTagName('krpano')->item(0);
	$scene = $dom->createElement('scene');

	foreach($krpano->childNodes as $child){
		if($child->nodeType == 1 && $child->tagName == 'scene' && $child->getAttribute('name') == $id){
			return;
		}
	}

	if(!$id) return false;
	$scene->setAttribute('name', $id);
	$scene->setAttribute('title', $option['name']);	
	$scene->setAttribute('thumburl', '%HTMLPATH%/source/blank.png');
	
	if($img){
		$image = $dom->createElement('image');
		$image->setAttribute('type', 'CUBE');
		$image->setAttribute('multires', 'true');
		$image->setAttribute('tilesize', '512');
		$image->setAttribute('progressive', 'true');

		for($i=0; $i<count($img); $i++){
			$level = $dom->createElement('level');
			$level->setAttribute('tiledimagewidth', $img[$i]['size']);
			$level->setAttribute('tiledimageheight', $img[$i]['size']);

			$cube = $dom->createElement('cube');
			$cube->setAttribute('url', $img[$i]['url']);

			$level->appendChild($cube);
			$image->appendChild($level);
		}
		$scene->appendChild($image);
	}
	else {
		$image = $dom->createElement('image');
		$image->setAttribute('type', 'CUBE');
		$image->setAttribute('multires', 'true');
		$image->setAttribute('tilesize', '512');
		
		$level = $dom->createElement('level');
		$level->setAttribute('tiledimagewidth', 10);
		$level->setAttribute('tiledimageheight', 10);

		$cube = $dom->createElement('cube');
		$cube->setAttribute('url', '%HTMLPATH%/source/blank.png');

		$level->appendChild($dom->createTextNode("\n\t\t\t\t"));
		$level->appendChild($cube);
		$level->appendChild($dom->createTextNode("\n\t\t\t"));
		
		$image->appendChild($dom->createTextNode("\n\t\t\t"));
		$image->appendChild($level);
		$image->appendChild($dom->createTextNode("\n\t\t"));

		$scene->appendChild($dom->createTextNode("\n\t\t"));
		$scene->appendChild($image);	
	}

	$view = $dom->createElement('view');
	$view->setAttribute('maxpixelzoom', '1.0');
	$view->setAttribute('fovmax', '140');
	if(isset($option['initialAth']) || isset($option['initialAtv']) ||isset($option['initialFov'])){
		if(isset($option['initialAth'])) 	$view->setAttribute('vlookat', $option['initialAth']);
		if(isset($option['initialAtv'])) 	$view->setAttribute('hlookat', $option['initialAtv']);
		if(isset($option['initialFov'])) 	$view->setAttribute('fov', $option['initialFov']);
	}
	$scene->appendChild($dom->createTextNode("\n\t\t"));
	$scene->appendChild($view);

	if(isset($option['preview_url'])){
		$preview = $dom->createElement('preview');
		$preview->setAttribute('url', $option['preview_url']);
		$scene->appendChild($dom->createTextNode("\n\t\t"));
		$scene->appendChild($preview);		
	}

	$scene->appendChild($dom->createTextNode("\n\t"));

	$lastText = $krpano->removeChild($krpano->lastChild);
	$krpano->appendChild($dom->createTextNode("\n\t"));
	$krpano->appendChild($scene);
	$krpano->appendChild($lastText);
	$dom->save($xml);
	return $id;
}

function remove_scene($xml, $id){
	$dom = new DOMDocument();
	$dom->load($xml);

	var_dump($id);

	$krpano = $dom->getElementsByTagName('krpano')->item(0);
	foreach($krpano->childNodes as $child){		
		if($child->nodeType == 1 && $child->tagName == 'scene' 
		&& $child->getAttribute('name') == $id){
			$krpano->removeChild($child->previousSibling);
			$krpano->removeChild($child);
			$dom->save($xml);
			return $id;
		} 
	}
	return false;
}

/*
option
	edge
	visible
*/

function add_textfield($xml, $name, $scene_name, $hotspot_name, $options){
	if(!$xml || !$name) return false;

	$dom = new DOMDocument();
	$dom->load($xml);

	$scenes = $dom->getElementsByTagName('scene');
	for($i=0; $i<$scenes->length; $i++){
		if($scenes->item($i)->getAttribute('name') == $scene_name){
			$scene =  $scenes->item($i);
		}
	}


	$layer = $dom->createElement('layer');
	if(isset($options['text']) && $options['text']){
		$text = str_replace("\n", "<br>", $options['text']);
		$html_contents = "<div style='display:inline-block;position:relative;'>".
			"<div style='display:inline-block; width:auto; position:relative; left:-50%; background-color:white;". 
			"padding:2px; border:2px solid black; border-radius:4px; white-space:pre; word-break:break-word; max-width:300px;'>$text</div></div>";
	}
	else{
		$layer->setAttribute('visible', 'false');	
	}	
	$layer->setAttribute('url', 'textfield.swf');
	$layer->setAttribute('html', $html_contents);

	$layer->setAttribute('name', $name);
	$layer->setAttribute('parent', "hotspot[$hotspot_name]");
	$layer->setAttribute('align', 'top');
	$layer->setAttribute('edge', 'bottom');
	$layer->setAttribute('x', '0');
	$layer->setAttribute('y', '-10');
	$layer->setAttribute('width', '0');
	$layer->setAttribute('autoheight', 'true'); 

	$layer->setAttribute('css', 'overflow:visible; pointer-events:none;'); 
	$layer->setAttribute('bgalpha', '0'); 

	$lastText = $scene->removeChild($scene->lastChild);
	$scene->appendChild($dom->createTextNode("\n\t\t"));
	$scene->appendChild($layer);
	$scene->appendChild($lastText);
	$dom->save($xml);
	return true;
}

function set_textfield($xml, $id, $scene_id, $hotspot_id, $options){
//function set_textfield($xml, $scene_name, $id, $content=NULL, $position=NULL, $option=NULL){
	if(!$xml || !$id) return false;

	$dom = new DOMDocument();
	$dom->load($xml);

	$scenes = $dom->getElementsByTagName('scene');
	for($i=0; $i<$scenes->length; $i++){
		if($scenes->item($i)->getAttribute('name') == $scene_id){
			$scene =  $scenes->item($i);
		}
	}

	//id값으로 이미 있는 text_filed인지 확인한다.
	$update_flag = false;
	foreach($scene->childNodes as $child){
		if($child->nodeType == 1 && $child->tagName == 'layer' && $child->getAttribute('name') == $id){
			$layer = $child;
			$update_flag = true;
			break;
		}
	}	

	if($update_flag){
		if(isset($options['text'])){
			if($options['text']){
				$text = str_replace("\n", "<br>", $options['text']);
				$html_contents = "<div style='display:inline-block;position:relative;'>".
				"<div style='display:inline-block; width:auto; position:relative; left:-50%; background-color:white;". 
				"padding:2px; border:2px solid black; border-radius:4px; word-wrap:break-word; white-space:pre; max-width:300px;'>$text</div></div>";
				$layer->setAttribute('html', $html_contents);
				$layer->setAttribute('visible', 'true');
			}
			else{
				$layer->setAttribute('visible', 'false');
			}			
		}
	}
	$dom->save($xml);
	return $id;
}

function remove_textfield($xml, $scene_name, $id){
	if(!$xml || !$id) return false;

	$dom = new DOMDocument();
	$dom->load($xml);

	//scene값이 있는 경우 해당 scene을 찾는다. 
	if($scene_name){
		$krpano = $dom->getElementsByTagName('krpano')->item(0);
		foreach($krpano->childNodes as $child){
			if($child->nodeType == 1 && $child->tagName == 'scene' && $child->getAttribute('name') == $scene_name){
				$scene = $child;
				break;
			} 
		}
	}
	//scene값이 없으면 krpano 밑에서 작업을 수행한다. 
	else{
		$scene = $krpano;
	}

	//id값으로 이미 있는 text_filed인지 확인한다.
	foreach($scene->childNodes as $child){
		if($child->nodeType == 1 && $child->tagNmae == 'layer' && $child->getAttribute('name') == $id){
			$scene->removeChild($child);
			$dom->save($xml);
			return $id;
		}
	}
	return false;
}

function extract_image_data($xml, $path){
	$dom = new DOMDocument();
	if(!$dom->load($xml)) return;

	$data = array();

	$image = $dom->getElementsByTagName('image')->item(0);
	foreach($image->childNodes as $child){
		if($child->nodeType != 1 || $child->tagName !='level') continue;

		$level = array();
		$level['size'] = $child->getAttribute('tiledimagewidth');
		$level['url'] = "$path";

		foreach($child->childNodes as $grandchild){
			if($grandchild->nodeType != 1 || $grandchild->tagName != 'cube') continue;
			$level['url'] .= $grandchild->getAttribute('url');
			$level['url'] .= "?".time();
		}			
		array_push($data, $level);
	}
	return $data;
}
?>