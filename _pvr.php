<?php
$psexec_path = "c:\users\kimingyu\desktop\pstools\psexec.exe";
$ptgui_path = "c:/program files/ptgui/ptgui";
$host_path = "C:\\Program Files (x86)\\Apache Software Foundation\\Apache2.2\\htdocs\\pvr_editor";

$pts_path = "{$host_path}\\pano_compose\\pano.pts";
$pts4_path = "{$host_path}\\pano_compose\\pano_4.pts";
$krpano_path = "c:\\program files\\krpano\\krpanotools64.exe";
$krconfig_path = "{$host_path}\\pvr_compose\\mysettings.config";
$src_for_pts_path = "pano_compose";

function make_panorama($src, $dest, $num_of_image){
	global $psexec_path, $src_for_pts_path, $ptgui_path, $pts_path, $pts4_path, $src_for_pts_path;

	for($i=0; $i<count($src); $i++){
		copy($src[$i], "$src_for_pts_path/source$i.jpg");
	}	
	if($num_of_image == 3){
		exec("\"$psexec_path\" \\\\localhost -i 1 \"$ptgui_path\" -batch \"$pts_path\" -x");
	}
	else if($num_of_image == 4){
		exec("\"$psexec_path\" \\\\localhost -i 1 \"$ptgui_path\" -batch \"$pts4_path\" -x");
	}
	
	copy("$src_for_pts_path/pano.jpg", $dest);
}

function make_pvr($src){
	global $host_path, $psexec_path, $krpano_path, $krconfig_path;

	exec("\"$krpano_path\" makepano -config=\"$krconfig_path\" \"$host_path\\$src\"");
}

?>