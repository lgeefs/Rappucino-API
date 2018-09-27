<?php

    function create_recording($name, $to_squad_id, $from_rapper_id, $to_rapper_id, $target_file) {

        require('conn.php');

        $errors = [];
        $private = false;

        if (empty($name)) {
            $errors[] = "Missing name parameter";
        }
        if (empty($to_squad_id) && empty($to_rapper_id)) {
            $private = true;
        }

        $insert_query = "INSERT INTO `recordings`
		(
			`name`,
			to_squad_id,
			from_rapper_id,
			to_rapper_id,
			recording_url,
            `private`
		) VALUES (
			'$name',
			'$to_squad_id',
			'$from_rapper_id',
			'$to_rapper_id',
			'http://127.0.0.1/rappucino/$target_file',
            '$private'
		)";

		if ($result = $conn->query($insert_query)) {

			$message .= "Recording successfully inserted into db\n";
			$success = true;

		} else {
			$message .= "Recording was not inserted into db\n";
			$success = false;
		}

		return json_encode(array(
            "success" => $success,
            "message" => $message
		));

    }

?>