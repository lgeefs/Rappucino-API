<?php

	require_once("conn.php");
	require_once('functions/post/recordings.php');

	header('Content-Type: application/json');

	$name = isset($_POST['name']) ? $_POST['name'] : '';
	//$from_squad_id = isset($_POST['from_squad_id']) ? $_POST['from_squad_id'] : '';
	$to_squad_id = isset($_POST['to_squad_id']) ? $_POST['to_squad_id'] : '';
	$from_rapper_id = isset($_POST['from_rapper_id']) ? $_POST['from_rapper_id'] : '';
	$to_rapper_id = isset($_POST['to_rapper_id']) ? $_POST['to_rapper_id'] : '';
	$duration = isset($_POST['duration']) ? $_POST['duration'] : '';

	$success = false;
	$message = "";

	$target_dir = "recordings/".$from_rapper_id."/".date("Y-m-d");

	if (!file_exists($target_dir)) {

		mkdir($target_dir, 0777, true);

	}

	//$fi = new FilesystemIterator($target_dir, FilesystemIterator::SKIP_DOTS);

	$target_file = $target_dir ."/". basename($_FILES["audioFile"]["name"]);
	//$target_file = $target_dir ."/". iterator_count($fi) .".m4a";

	if (move_uploaded_file($_FILES["audioFile"]["tmp_name"], $target_file)) {
		$message = "The file ". basename( $_FILES["audioFile"]["name"]). " has been uploaded.\n";
		$success = true;
    } else {
    	$message = "The file ".basename( $_FILES["audioFile"]["name"]). " failed to upload";
	}
	
	if ($success) {

		print_r(create_recording($name, $to_squad_id, $from_squad_id, $target_file, $duration));

	}

?>