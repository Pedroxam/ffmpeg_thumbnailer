<?php
/*=====================
* File Upload Handler
* By Pedram Asbaghi
/*=====================*/

require 'config.php';

$store = dirname(__FILE__)  . STORAGE;

// Set Allowed Videos format
$allowFormats = array( 'mp4', 'mkv', '3gp' );

// check exists folder
if(!file_exists($store)) {
	@mkdir($store);
	@chmod($store, 0777) ;
}

// no time limit
set_time_limit(0);

// json header
header('Content-type:application/json;charset=utf-8');

try {
    if (
        !isset($_FILES['file']['error']) ||
        is_array($_FILES['file']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    switch ($_FILES['file']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    $filepath = sprintf('%s_%s', uniqid(), $_FILES['file']['name']);
	
	// check extension
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	
	if(!in_array($extension, $allowFormats))
	{
		exit(json_encode(['status' => 'Not Allowed To Upload This File !']));
	}
	else {
		if (!move_uploaded_file(
			$_FILES['file']['tmp_name'],
			$store . $filepath
		)) {
			throw new RuntimeException('Failed to move uploaded file.');
		}
	}
	
    exit(json_encode(['status' => true, 'file' => '.' . STORAGE . $filepath]));

} catch (RuntimeException $e) {
	http_response_code(400);

    exit(json_encode(['status' => $e->getMessage()]));
}
