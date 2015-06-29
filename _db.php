<?php
$con = mysqli_connect("localhost", "root", "1234");
mysqli_select_db($con, "nextaeon_pvr_editor");

mysqli_set_charset($con, "utf8");

function alloc_new_id($table_name, $key_field_name) {
	global $con;

	$ret = mysqli_query($con,	
		"SELECT $key_field_name
		FROM $table_name
		ORDER BY $key_field_name DESC 
		LIMIT 1");

	$new_id = 0;
	if(!$ret) {
		mysqli_query($con,
			"INSERT INTO $table_name($key_field_name)
			VALUES ('1')");
	}
	else {
		$row = mysqli_fetch_assoc($ret);
		$new_id = $row[$key_field_name] + 1;
		mysqli_query($con,
			"INSERT INTO $table_name($key_field_name)
			VALUES ('$new_id')");
	}
	return $new_id;
}

function alloc_new_project_id($user_id){
	global $con;

	$ret = mysqli_query($con,	"SELECT project_id 
								FROM project
								ORDER BY project_id DESC 
								LIMIT 1");

	date_default_timezone_set('Asia/Seoul');
	$date = date('Y/m/d H:i:s', time());

	if(!$ret){		
		mysqli_query($con,	"INSERT INTO project(project_id, create_time)
							VALUES ('0', '$date')");
		mysqli_query($con,	"INSERT INTO map(project_id)
							VALUES ('0')");
		mysqli_query($con,	"INSERT INTO work_on(project_id)
							VALUES ('0')");
		return 0;	
	} 
	else {
		$row = mysqli_fetch_assoc($ret);
		mysqli_query($con,	"INSERT INTO project(project_id, create_time)
							VALUES ('".($row['project_id']+1)."', '$date')");
		mysqli_query($con,	"INSERT INTO map(project_id)
							VALUES ('".($row['project_id']+1)."')");
		mysqli_query($con,	"INSERT INTO work_on(project_id, user_id)
							VALUES ('".($row['project_id']+1)."', '$user_id')");
		echo mysqli_error($con);
		return $row['project_id']+1;	
	}	
}

function alloc_new_layer_id(){
	global $con;

	$ret = mysqli_query($con,	"SELECT layer_id 
								FROM layer
								ORDER BY layer_id DESC 
								LIMIT 1");
	if(!$ret){		
		mysqli_query($con,	"INSERT INTO layer(layer_id)
							VALUES ('0')");
		return 0;	
	} 
	else {
		$row = mysqli_fetch_assoc($ret);
		mysqli_query($con,	"INSERT INTO layer(layer_id)
							VALUES ('".($row['layer_id']+1)."')");
		echo mysqli_error($con);
		return $row['layer_id']+1;	
	}	
}

function alloc_new_vtour_id(){
	global $con;

	$ret = mysqli_query($con,	"SELECT vtour_id 
								FROM vtour
								ORDER BY vtour_id DESC 
								LIMIT 1");
	if(!$ret){		
		mysqli_query($con,	"INSERT INTO area(area_id)
							VALUES ('0')");
		mysqli_query($con,	"INSERT INTO vtour(area_id, vtour_id)
							VALUES ('0', '0')");
		return 0;	
	} 
	else {
		$row = mysqli_fetch_assoc($ret);
		mysqli_query($con,	"INSERT INTO area(area_id)
							VALUES ('".($row['vtour_id']+1)."')");
		mysqli_query($con,	"INSERT INTO vtour(area_id, vtour_id)
							VALUES ('".($row['vtour_id']+1)."', '".($row['vtour_id']+1)."')");
		echo mysqli_error($con);
		return $row['vtour_id']+1;	
	}	
}

function alloc_new_pvr_id(){
	global $con;

	$ret = mysqli_query($con,	"SELECT pvr_id 
								FROM pvr
								ORDER BY pvr_id DESC 
								LIMIT 1");
	if(!$ret){		
		mysqli_query($con,	"INSERT INTO pvr(pvr_id)
							VALUES ('0')");
		return 0;	
	} 
	else {
		$row = mysqli_fetch_assoc($ret);
		mysqli_query($con,	"INSERT INTO pvr(pvr_id)
							VALUES ('".($row['pvr_id']+1)."')");
		echo mysqli_error($con);
		return $row['pvr_id']+1;	
	}	
}

function alloc_new_marker_icon_id(){
	global $con;

	$ret = mysqli_query($con,	"SELECT icon_id 
								FROM marker_icon
								ORDER BY icon_id DESC 
								LIMIT 1");
	if(!$ret){		
		mysqli_query($con,	"INSERT INTO marker_icon(icon_id)
							VALUES ('0')");
		mysqli_query($con,	"INSERT INTO marker_display(icon_id)
							VALUES ('0')");
		echo mysqli_error($con);
		return 0;	
	} 
	else {
		$row = mysqli_fetch_assoc($ret);
		mysqli_query($con,	"INSERT INTO marker_icon(icon_id)
							VALUES ('".($row['icon_id']+1)."')");
		mysqli_query($con,	"INSERT INTO marker_display(icon_id)
							VALUES ('".($row['icon_id']+1)."')");
		echo mysqli_error($con);
		return $row['icon_id']+1;	
	}	
}
function alloc_new_hotspot_icon_id(){
	global $con;

	$ret = mysqli_query($con,	"SELECT icon_id 
								FROM hotspot_icon
								ORDER BY icon_id DESC 
								LIMIT 1");
	if(!$ret){		
		mysqli_query($con,	"INSERT INTO hotspot_icon(icon_id)
							VALUES ('0')");
		mysqli_query($con,	"INSERT INTO hotspot_display(icon_id)
							VALUES ('0')");
		echo mysqli_error($con);
		return 0;	
	} 
	else {
		$row = mysqli_fetch_assoc($ret);
		mysqli_query($con,	"INSERT INTO hotspot_icon(icon_id)
							VALUES ('".($row['icon_id']+1)."')");
		mysqli_query($con,	"INSERT INTO hotspot_display(icon_id)
							VALUES ('".($row['icon_id']+1)."')");
		echo mysqli_error($con);
		return $row['icon_id']+1;	
	}	
}

function alloc_new_marker_id(){
	global $con;

	$ret = mysqli_query($con,	"SELECT marker_id
								FROM marker
								ORDER BY marker_id DESC 
								LIMIT 1");
	if(!$ret){		
		mysqli_query($con,	"INSERT INTO marker(marker_id)
							VALUES ('0')");
		mysqli_query($con,	"INSERT INTO m_link_pvr(marker_id)
							VALUES ('0')");
		mysqli_query($con,	"INSERT INTO m_link_vtour(marker_id)
							VALUES ('0')");
		mysqli_query($con,	"INSERT INTO m_link_url(marker_id)
							VALUES ('0')");
		mysqli_query($con,	"INSERT INTO m_link_inform(marker_id)
							VALUES ('0')");
		echo mysqli_error($con);
		return 0;	
	} 
	else {
		$row = mysqli_fetch_assoc($ret);
		mysqli_query($con,	"INSERT INTO marker(marker_id)
							VALUES ('".($row['marker_id']+1)."')");
		mysqli_query($con,	"INSERT INTO m_link_pvr(marker_id)
							VALUES ('".($row['marker_id']+1)."')");
		mysqli_query($con,	"INSERT INTO m_link_vtour(marker_id)
							VALUES ('".($row['marker_id']+1)."')");
		mysqli_query($con,	"INSERT INTO m_link_url(marker_id)
							VALUES ('".($row['marker_id']+1)."')");
		mysqli_query($con,	"INSERT INTO m_link_inform(marker_id)
							VALUES ('".($row['marker_id']+1)."')");
		echo mysqli_error($con);
		return $row['marker_id']+1;	
	}
}

function alloc_new_hotspot_id(){
	global $con;

	$ret = mysqli_query($con,	"SELECT hotspot_id
								FROM hotspot
								ORDER BY hotspot_id DESC 
								LIMIT 1");
	if(!$ret){		
		mysqli_query($con,	"INSERT INTO hotspot(hotspot_id)
							VALUES ('0')");
		mysqli_query($con,	"INSERT INTO h_link_pvr(hotspot_id)
							VALUES ('0')");
		echo mysqli_error($con);
		return 0;	
	} 
	else {
		$row = mysqli_fetch_assoc($ret);
		mysqli_query($con,	"INSERT INTO hotspot(hotspot_id)
							VALUES ('".($row['hotspot_id']+1)."')");
		mysqli_query($con,	"INSERT INTO h_link_pvr(hotspot_id)
							VALUES ('".($row['hotspot_id']+1)."')");
		mysqli_query($con,	"INSERT INTO h_link_inform(hotspot_id)
							VALUES ('".($row['hotspot_id']+1)."')");
		echo mysqli_error($con);
		return $row['hotspot_id']+1;	
	}
}

function set_data($type, $id_idx, $id, $idx, $values){
	global $con;

	$ret = mysqli_query($con, 	"SELECT *
								FROM $type
								WHERE $id_idx='$id'");
	if(mysqli_fetch_assoc($ret)){
		if(!count($idx)) return;
		$set_word = "";
		if(count($idx))	$set_word = "{$idx[0]}='{$values[0]}'";
		for($i=1; $i<count($idx); $i++){
			$set_word.=", {$idx[$i]}='{$values[$i]}'";
		}

		mysqli_query($con, 	"UPDATE $type
							SET $set_word
							WHERE $id_idx='$id'");
		echo mysqli_error($con);
	}
	else{
		$idx_word = "";
		$value_word = "";
		if(count($idx)){
			$idx_word = "{$id_idx}";
			$value_word = "{$id}";
		}
		for($i=0; $i<count($idx); $i++){
			$idx_word.=", {$idx[$i]}";
			$value_word.=", '{$values[$i]}'";
		}
		mysqli_query($con, 	"INSERT INTO $type($idx_word)
							VALUES ($value_word)");
		echo mysqli_error($con);
	}	
}

function set_data_with_comp_pk($type, $key_arr, $field_arr){
	global $con;

	//make where clause for composite primary key
	$where_clause = '';
	foreach($key_arr as $field=>$value){
		$where_clause .= "$field='$value' AND ";
	}
	$where_clause = substr($where_clause, 0, -5);


	$ret = mysqli_query($con, 	"SELECT *
								FROM $type
								WHERE $where_clause");
	
	if(mysqli_fetch_assoc($ret)){
		if(!count($field_arr)) return;
		
		$set_word = "";
		foreach($field_arr as $field=>$value){
			$set_word.="$field='$value', ";
		}
		$set_word = substr($set_word, 0, -2);

		mysqli_query($con, 	
			"UPDATE $type
			SET $set_word
			WHERE $where_clause");

		echo mysqli_error($con);
	}
	else{
		$field_word = "";
		$value_word = "";

		foreach($key_arr as $field=>$value){
			$field_word .= "$field, ";
			$value_word .= "'$value', ";
		}
		foreach($field_arr as $field=>$value){
			$field_word .= "$field, ";
			$value_word .= "'$value', ";
		}
		$field_word = substr($field_word, 0, -2);
		$value_word = substr($value_word, 0, -2);

		mysqli_query($con,
			"INSERT INTO $type($field_word)
			VALUES ($value_word)");

		echo mysqli_error($con);
	}	
}

function del_data($type, $id_idx, $id){
	global $con;

	mysqli_query($con, 	"DELETE FROM $type
						WHERE $id_idx='$id'");
	echo mysqli_error($con);
}

//del_data와 합쳐야 
function delete_project($id){
	global $con;

	$ret = mysqli_query($con, 	"SELECT project_id
								FROM project
								WHERE project_id='$id'");
	$row = mysqli_fetch_assoc($ret);
	if(!isset($row['project_id']))	return false;

	if(!mysqli_query($con, 	"DELETE FROM project
						WHERE project_id='$id'")){
		var_dump("Error: ".mysqli_error($con));
		return false;
	}
	return true;
}

function get_project_node_list($project_id){
	global $con;
	$data = array();

	$ret = mysqli_query($con,	"SELECT project_name
								FROM project
								WHERE project_id='$project_id'");
	$row = mysqli_fetch_assoc($ret);
	$data['data'] = $row['project_name'];
	$data['type'] = 'map';
	$data['id'] = "m$project_id";

	$ret = mysqli_query($con,	"SELECT layer_id, layer_name
								FROM layer
								WHERE map_id='$project_id'
								ORDER BY orders ASC");
	$layer_list = array();
	for($i=0; $row=mysqli_fetch_assoc($ret); $i++){
		$layer_data = array();
		$layer_data['data'] = $row['layer_name'];
		$layer_data['type'] = 'layer';
		$layer_data['id'] = "l{$row['layer_id']}";

		$vtour_ret = mysqli_query($con,	"SELECT vtour_id, vtour_name
										FROM area, vtour
										WHERE area.layer_id='{$row['layer_id']}' AND 
											area.area_id = vtour.area_id
										ORDER BY orders ASC");
		$vtour_list = array();
		for($j=0; $vtour_row=mysqli_fetch_assoc($vtour_ret); $j++){
			$vtour_data = array();
			$vtour_data['data'] = $vtour_row['vtour_name'];
			$vtour_data['type'] = 'vtour';
			$vtour_data['id'] = "vt{$vtour_row['vtour_id']}";

			$pvr_ret = mysqli_query($con,	"SELECT pvr_id, pvr_name
											FROM pvr
											WHERE vtour_id='{$vtour_row['vtour_id']}'
											ORDER BY orders ASC");
			$pvr_list = array();
			for($k=0; $pvr_row=mysqli_fetch_assoc($pvr_ret); $k++){
				$pvr_data = array();
				$pvr_data['data'] = $pvr_row['pvr_name'];
				$pvr_data['type'] = 'pvr';
				$pvr_data['id'] = "pvr{$pvr_row['pvr_id']}";

				array_push($pvr_list, $pvr_data);
			}
			$vtour_data['subdir'] = $pvr_list;
			array_push($vtour_list, $vtour_data);
		}
		$layer_data['subdir'] = $vtour_list;
		array_push($layer_list, $layer_data);
	}
	$data['subdir'] = $layer_list;

	return $data;
}

function get_user_data($id){
	global $con;
	$ret = mysqli_query($con,	"SELECT *
								FROM user
								WHERE user_id='$id'");
	$row = mysqli_fetch_assoc($ret);
	return $row;
}

function get_layer_data($id){
	global $con;
	$ret = mysqli_query($con,	"SELECT *
								FROM layer
								WHERE layer_id='$id'");
	$row = mysqli_fetch_assoc($ret);
	return $row;
}

function get_vtour_area_data($id){
	global $con;
	$ret = mysqli_query($con,	"SELECT *
								FROM area, vtour
								WHERE vtour.vtour_id = '$id' AND
									area.area_id = vtour.area_id");
	$row = mysqli_fetch_assoc($ret);
	return $row;
}

function get_pvr_data($id){
	global $con;
	$ret = mysqli_query($con,	"SELECT *
								FROM pvr
								WHERE pvr_id='$id'");
	$row = mysqli_fetch_assoc($ret);
	return $row;
}

function get_project_map_data($id){
	global $con;
	$ret = mysqli_query($con,	"SELECT *
								FROM project, map
								WHERE project.project_id = map.project_id AND 
									map.project_id='$id'");
	$row = mysqli_fetch_assoc($ret);
	return $row;
}

function get_layer_list_of_map($id){
	global $con;
	$data = array();
	$ret = mysqli_query($con,	"SELECT layer_id, layer_name
								FROM layer
								WHERE map_id='$id'
								ORDER BY orders ASC");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}

function get_pvr_list_of_vtour($id){
	global $con;
	$data = array();
	$ret = mysqli_query($con,	"SELECT pvr_id, pvr_name
								FROM pvr
								WHERE vtour_id='$id'
								ORDER BY orders ASC");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}

function get_vtour_list_of_layer($id){
	global $con;
	$data = array();
	$ret = mysqli_query($con,	"SELECT vtour_id, vtour_name
								FROM vtour, area
								WHERE area.layer_id='$id' AND 
									area.area_id = vtour.area_id
								ORDER BY orders ASC");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}

function get_marker_icon_list($project_id){
	global $con;
	$data = array();
	$ret = mysqli_query($con, 	"SELECT *
								FROM marker_icon
								WHERE project_id='$project_id'
								ORDER BY orders ASC");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}

function get_hotspot_icon_list($project_id){
	global $con;
	$data = array();
	$ret = mysqli_query($con, 	"SELECT *
								FROM hotspot_icon
								WHERE project_id='$project_id'
								ORDER BY orders ASC");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}

function get_marker_list($project_id){
	global $con;
	$data = array();
	$ret = mysqli_query($con, 	"SELECT layer_id
								FROM layer
								WHERE map_id='$project_id'");

	while($row = mysqli_fetch_assoc($ret)){
		$inret = mysqli_query($con, "SELECT *
									FROM marker
									WHERE layer_id='{$row['layer_id']}'");
		while($inrow = mysqli_fetch_assoc($inret)){
			if($inrow['action_type'] == 'linkToPvr'){
				$pvr_col = mysqli_query($con, "SELECT *
											FROM m_link_pvr
											WHERE marker_id='{$inrow['marker_id']}'");
				echo mysqli_error($con);
				$inrow['pvr_id'] =  mysqli_fetch_assoc($pvr_col)['pvr_id'];

				$pvr_col = mysqli_query($con, "SELECT *
											FROM m_link_inform
											WHERE marker_id='{$inrow['marker_id']}'");
				echo mysqli_error($con);
				$inform_row = mysqli_fetch_assoc($pvr_col);
				$inrow['inform_text'] = $inform_row['inform_text'];
				$inrow['inform_img_url'] = $inform_row['inform_img_url'];
				$inrow['inform_type'] = $inform_row['inform_type'];
				$inrow['inform_title'] = $inform_row['inform_title'];

				$pvr_col = mysqli_query($con, "SELECT *
											FROM m_link_url
											WHERE marker_id='{$inrow['marker_id']}'");
				echo mysqli_error($con);
				$inrow['linked_url'] = mysqli_fetch_assoc($pvr_col)['linked_url'];
			}
			else if($inrow['action_type'] == 'linkToVtour'){
				$pvr_col = mysqli_query($con, "SELECT *
											FROM m_link_vtour
											WHERE marker_id='{$inrow['marker_id']}'");
				echo mysqli_error($con);
				$inrow['vtour_id'] = mysqli_fetch_assoc($pvr_col)['vtour_id'];
			}
			else if($inrow['action_type'] == 'showInform'){
				$pvr_col = mysqli_query($con, "SELECT *
											FROM m_link_inform
											WHERE marker_id='{$inrow['marker_id']}'");
				echo mysqli_error($con);
				$inform_row = mysqli_fetch_assoc($pvr_col);
				$inrow['inform_title'] = $inform_row['inform_title'];
				$inrow['inform_text'] = $inform_row['inform_text'];
				$inrow['inform_img_url'] = $inform_row['inform_img_url'];
				$inrow['inform_type'] = $inform_row['inform_type'];

				$pvr_col = mysqli_query($con, "SELECT *
											FROM m_link_url
											WHERE marker_id='{$inrow['marker_id']}'");
				echo mysqli_error($con);
				$inrow['linked_url'] = mysqli_fetch_assoc($pvr_col)['linked_url'];
			}
			array_push($data, $inrow);
		}
	}
	return $data;
}

function get_hotspot_list($project_id){
	global $con;
	$data = array();
	$ret = mysqli_query($con, 	"SELECT hotspot.*
								FROM layer, area, vtour, pvr, hotspot
								WHERE map_id='$project_id' AND
									area.layer_id = layer.layer_id AND
									area.area_id = vtour.area_id AND
									vtour.vtour_id = pvr.vtour_id AND
									pvr.pvr_id = hotspot.pvr_id");

	while($row = mysqli_fetch_assoc($ret)){
		if($row['action_type'] == 'linkToPvr'){
			$pvr_col = mysqli_query($con, "SELECT *
										FROM h_link_pvr
										WHERE hotspot_id='{$row['hotspot_id']}'");
			echo mysqli_error($con);
			$row['linked_pvr_id'] =  mysqli_fetch_assoc($pvr_col)['pvr_id'];
		}
		else if($row['action_type'] == 'showInform'){
			$pvr_col = mysqli_query($con, "SELECT *
										FROM h_link_inform
										WHERE hotspot_id='{$row['hotspot_id']}'");
			echo mysqli_error($con);
			$row['html'] =  mysqli_fetch_assoc($pvr_col)['html'];
		}
		array_push($data, $row);
	}
	return $data;
}

function get_marker_display_list($id){
	global $con;
	$data = array();
	$ret = mysqli_query($con, 	"SELECT *
								FROM marker_display
								WHERE icon_id='$id'");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}
function get_hotspot_display_list($id){
	global $con;
	$data = array();
	$ret = mysqli_query($con, 	"SELECT *
								FROM hotspot_display
								WHERE icon_id='$id'");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}

function login($id, $password){
	global $con;

	if(session_status() == PHP_SESSION_NONE)	session_start();

	$res = mysqli_query($con,
		"select *
		from 	user
		where	user_id='$id'"
	);
	$row = mysqli_fetch_assoc($res);
	
	if(!$row){
		return 'wrong_id';
	}
	else {
		$res = mysqli_query($con, 
			"select *
			from 	user
			where	user_id='$id' and password='$password'"
		);
		$row = mysqli_fetch_assoc($res);
		if(!$row){
			return 'wrong_password';
		}	
		
		if($row['user_type']=="real_estate"){
			$_SESSION['id'] = $id;
			return "success_real_estate";
		}
		else if($row['user_type']=="viewer"){
			$_SESSION['id'] = $id;
			return "success_viewer";
		}
		else {
			$_SESSION['id'] = $id;
			return "success";
		}
		
	}
}

//logout - 로그아웃을 처리하는 함수
//$id - 로그아웃할 아이디 
function logout($id){
	if(session_status() == PHP_SESSION_NONE)	session_start();
	if(isset($_SESSION['id']) && $_SESSION['id'] == $id){
		session_destroy();
	}
}

function get_project_list($id){
	global $con;
	$data = array();
	$ret = mysqli_query($con, 	"SELECT project.project_id, project_name
								FROM work_on, project
								WHERE '$id'=user_id AND work_on.project_id=project.project_id
								ORDER BY create_time DESC");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}

function get_all_projects_of_real_estate(){
	global $con;
	$data = array();
	$ret = mysqli_query($con, 	"SELECT p.project_id, project_name
								FROM user as u, work_on as w, project as p
								WHERE u.user_type = 'real_estate' AND 
									u.user_id = w.user_id AND
									w.project_id = p.project_id");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}

function get_pvrs_of_project($project_id){
	global $con;
	$data = array();

	$ret = mysqli_query($con, 	"SELECT pvr.pvr_id, pvr.vtour_id, pvr.pvr_name, pvr.hlookat, pvr.vlookat, pvr.fov, pvr.pvr_path, pvr.orders
								FROM project as p, layer as l, area as a, vtour as v, pvr
								WHERE p.project_id = '$project_id' AND 
									p.project_id = l.map_id AND
									l.layer_id = a.layer_id AND
									a.area_id = v.area_id AND
									v.vtour_id = pvr.vtour_id");

	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}

function get_all_project_markers(){
	global $con;
	$data = array();
	$ret = mysqli_query($con, 	"SELECT m.*, mp.pvr_id, mv.vtour_id
								FROM user as u, work_on as w, layer as l, 
									marker as m, m_link_pvr as mp, m_link_vtour as mv
								WHERE u.user_type = 'real_estate' AND 
									u.user_id = w.user_id AND
									w.project_id = l.map_id AND
									l.layer_id = m.layer_id AND
									m.marker_id = mp.marker_id AND
									m.marker_id = mv.marker_id");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}

	$ret = mysqli_query($con, 	"SELECT pm.*
								FROM user as u, work_on as w, project_marker as pm
								WHERE u.user_type = 'editor' AND 
									u.user_id = w.user_id AND
									w.project_id = pm.project_id");
	while($row = mysqli_fetch_assoc($ret)){
		$row['action_type'] = "linkToProject";
		array_push($data, $row);
	}

	return $data;
}

function get_project_markers($project_id){
	global $con;
	$data = array();
	$ret = mysqli_query($con, 	"SELECT *
								FROM project_marker
								WHERE project_id='$project_id'");
	while($row = mysqli_fetch_assoc($ret)){
		array_push($data, $row);
	}
	return $data;
}

function get_new_order($table, $group_id_idx, $group_id) {
	global $con;
	$data = array();
	$ret = mysqli_query($con, 
		"SELECT orders
		FROM $table
		WHERE $group_id_idx = '$group_id'
		ORDER BY orders DESC
		LIMIT 1");
	
	if($err_msg = mysqli_error($con)) {
		return $err_msg;
	}

	$row = mysqli_fetch_assoc($ret);
	return $row['orders']+1;
}

/**
 * geom_from_text
 * This function is used for use mysql function, GeomFromText 
 *
 * @param $text
 *  stirng having geom data
 */
function geom_from_text($text) {
	global $con;
	
	$ret = mysqli_query($con, 
		"SELECT GeomFromText('$text') as geom");
	$row = mysqli_fetch_assoc($ret);
	return $row["geom"];
}

/**
 * as_text
 * This function is used for use mysql function, AsText
 *
 * @param $geom
 *  geom data
 */
function as_text($geom) {
	global $con;

	$ret = mysqli_query($con, 
		"SELECT AsText('$geom') as line_string");

	$row = mysqli_fetch_assoc($ret);
	return $row["line_string"];
}

/**
 * get_videos
 *  get all videos contained in a project
 *
 * @param $project_id
 */
function get_videos($project_id) {
	global $con;

	$ret = mysqli_query($con,
		"SELECT *
		FROM video
		WHERE project_id='$project_id'");

	$video_rows = array();
	while($row = mysqli_fetch_assoc($ret)) {
		$video_rows[] = $row;
	}

	return $video_rows;
}

/**
 * get_polylines
 *  get all polylines contained in a project
 *
 * @param $project_id
 */
function get_polylines($project_id) {
	global $con;

	$ret = mysqli_query($con,
		"SELECT 
			p.*
		FROM 
			polyline as p, 
			layer as l, 
			map as m
		WHERE 
			m.project_id = '$project_id' AND
			m.project_id = l.map_id AND
			l.layer_id = p.layer_id"
	);

	$polyline_rows = array();
	while($row = mysqli_fetch_assoc($ret)) {
		$polyline_rows[] = $row;
	};

	return $polyline_rows;
}

/**
 * get_timelines
 *  get all timelines contained in a project
 *
 * @param $project_id
 */
function get_timelines($polyline_id) {
	global $con;

	$ret = mysqli_query($con,
		"SELECT 
			*
		FROM 
			timeline
		WHERE 
			timeline.polyline_id = $polyline_id"
	);

	$timeline_rows = array();
	while($row = mysqli_fetch_assoc($ret)) {
		$timeline_rows[] = $row;
	};

	return $timeline_rows;
}
?>