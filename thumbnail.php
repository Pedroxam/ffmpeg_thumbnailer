<?php
/*=====================
* FFmpeg Tile Thumbnailer
* By Pedram Asbaghi
/*=====================*/

error_reporting(E_ALL);

if(isset($_POST['video']) && !empty($_POST['video'])) {
	
	//Set 0 Limit Time
	set_time_limit(0);

	//Set FFmpeg installation Path
	if (substr(php_uname(), 0, 7) == "Windows")
	{
		 //windows
		$ffmpeg_path  = dirname(__FILE__) . '/ffmpeg.exe';
	}
	else {
		 //linux or others ( if the conversion operation did not work, edit this path )
		$ffmpeg_path  = '/usr/bin/ffmpeg';
	}
	
	//========== Next Step =========>
	
	//Get Video File
	$inputVideo = trim( $_POST['video'] );
	
	//Set Output Image directory with name
	$newName = './store/' . rand() . '.jpg';
	
	//Set Tile Mode
	$tile_1 = trim($_POST['tile_1']);
	$tile_1 = intval($tile_1);
	
	$tile_2 = trim($_POST['tile_2']);
	$tile_2 = intval($tile_2);
	
	$tile = $tile_1 . 'x' . $tile_2;
	
	//Set Each Thumb Size
	$size_1 = trim($_POST['size_1']);
	$size_1 = intval($size_1);
	
	$size_2 = trim($_POST['size_2']);
	$size_2 = intval($size_2);
	
	$size = $size_1 . 'x' . $size_2;
	
	//Set Make Capture Every Below Time (4 seconds)
	$time = '00:00:04';
	
	//Generate FFmpeg Command
	$command = "$ffmpeg_path -ss $time -i $inputVideo -vf select=not(mod(n\,1000)),scale=$size,tile=$tile $newName";
	
	//Excute FFmpeg Command
	$exec = shell_exec($command);
	
	// var_dump($exec);
	
	//Response
    exit(json_encode(['status' => true, 'image' => $newName]));
}

else exit(json_encode(['status' => 'Nothing Found Posted Video !']));