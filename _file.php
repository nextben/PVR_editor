<?php
function make_square($source, $dest, $ext){
	$source_size = getimagesize($source);

	if ( $source_size[0] > $source_size[1] ){
		$square_size = $source_size[0];
		$offX = 0;
		$offY = ( $source_size[0] - $source_size[1] ) / 2;
	}
	else {
		$square_size = $source_size[1];
		$offX = ( $source_size[1] - $source_size[0] ) / 2;
		$offY = 0;
	}
	if($ext == 'jpg' || $ext == 'jpeg')		$image = imagecreatefromjpeg( $source );
	if($ext == 'png')						$image = imagecreatefrompng( $source );

	$square = imagecreatetruecolor($square_size, $square_size);
	imagefill( $square, 0, 0, imagecolorallocate($square, 255, 255, 255) );
	imagecopyresampled($square, $image, $offX, $offY, 0, 0, $source_size[0], $source_size[1], $source_size[0], $source_size[1]);
	imagejpeg($square, $dest);
}
function cut_tile($source, $dest_path, $min, $max, $ext){
	$source_size = getimagesize($source);

	if ( $source_size[0] == 0 || $source_size[1] == 0 ) return false;

	//원본 사진을 정사각형으로 변형함.
	if ( $source_size[0] > $source_size[1] ){
		$square_size = $source_size[0];
		$offX = 0;
		$offY = ( $source_size[0] - $source_size[1] ) / 2;
	}
	else {
		$squre_size = $source_size[1];
		$offX = ( $source1Size[1] - $source1Size[0] ) / 2;
		$offY = 0;
	}
	if($ext == 'jpg' || $ext == 'jpeg')		$image = imagecreatefromjpeg( $source );
	if($ext == 'png')						$image = imagecreatefrompng( $source );

	$square = imagecreatetruecolor($square_size, $square_size);
	imagefill( $square, 0, 0, imagecolorallocate($square, 255, 255, 255) );
	imagecopyresampled($square, $image, $offX, $offY, 0, 0, $source_size[0], $source_size[1], $source_size[0], $source_size[1]);

	$num_of_tile = pow(2, $minZoom-1);
	for($j=$minZoom; $j<=$maxZoom; $j++){
		$num_of_tile *= 2;
		$tile_size = $square_size/$num_of_tile;
		for($k=0; $k<$num_of_tile; $k++){
			for($l=0; $l<$num_of_tile; $l++){
				$tile = imagecreatetruecolor(256, 256);				
				
				imagecopyresampled($tile, $square, 0, 0, $k*$tile_size, $l*$tile_size, 256, 256, $tile_size, $tile_size);
				imagejpeg($tile, "$dest_path/$j-$k-$l.jpg");
			}
		}
	}
}

function scale_img($url, $web_url, $standard_width, $standard_height){
	$size = getimagesize($url);
	$width = $size[0];
	$height = $size[1];

	$ratio = $height/$width;
	$standard_ratio = $standard_height/$standard_width;
	//$standard_ratio2 = 300/774;

	if($ratio>=$standard_ratio){
		$new_height = $standard_height;
		$new_width = $new_height/$ratio;
	}
	else{
		$new_width = $standard_width;
		$new_height = $ratio*$new_width;
	}
	
	$dest = imagecreatetruecolor($new_width, $new_height);
	$src = imagecreatefromjpeg($url);
	imagecopyresampled($dest, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	imagejpeg($dest, $web_url);
}

function copyDir($src, $dst){
  	if( is_dir($src) === true ){
    	$handle = opendir($src);
    	while( $entry = readdir($handle) ){
      		if( $entry === '.' || $entry === '..' ) continue;

      		if( is_dir("$src/$entry") )	mkdir("$dst/$entry");
      		copyDir("$src/$entry", "$dst/$entry");
    	}
    	closedir($handle);
  	}
  	else
    	copy($src, $dst);
}
function removeDir($src){
  	if( is_dir($src) === true ){
    	$handle = opendir($src);
    	while( $entry = readdir($handle) ){
      		if( $entry === '.' || $entry === '..' ) continue;
      		removeDir("$src/$entry");
    	}
    	rmdir($src);
    	closedir($handle);
  	}
  	else
    	unlink($src);
}
?>