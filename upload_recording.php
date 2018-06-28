<?php

	require_once("conn.php");

	header('Content-Type: application/json');

	$to_squad_id = isset($_POST['to_squad_id']) ? $_POST['to_squad_id'] : '';
	$from_rapper_id = isset($_POST['from_rapper_id']) ? $_POST['from_rapper_id'] : '';
	$to_rapper_id = isset($_POST['to_rapper_id']) ? $_POST['to_rapper_id'] : '';

	$success = false;
	$message = "";

	$target_dir = "/Applications/MAMP/htdocs/rappucino/recordings/".$from_rapper_id."/".date("Y-m-d");

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

		$insert_query = "INSERT INTO `recordings`
		(
			to_squad_id,
			from_rapper_id,
			to_rapper_id,
			recording_url
		) VALUES (
			'$to_squad_id',
			'$from_rapper_id',
			'$to_rapper_id',
			'$target_file'
		)";

		if ($result = $conn->query($insert_query)) {

			$message .= "Recording successfully inserted into db\n";
			$success = true;

		} else {
			$message .= "Recording was not inserted into db\n";
			$success = false;
		}

		print_r(
			json_encode(
				array(
					"success" => $success,
					"message" => $message
				)
			)
		);

	}

?>