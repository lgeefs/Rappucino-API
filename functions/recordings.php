<?php

    function get_all_recordings() {
        return get_recordings();
    }

    function get_recordings_from_rapper_id($rapper_id) {
        return get_recordings(" WHERE from_rapper_id='$rapper_id'");
    }

    function get_recordings_from_squad_id($squad_id) {
        return get_recordings(" WHERE from_squad_id='$squad_id'");
    }

    function get_recordings_to_rapper_id($rapper_id) {
        return get_recordings(" WHERE to_rapper_id='$rapper_id'");
    }

    function get_recordings_to_squad_id($squad_id) {
        return get_recordings(" WHERE to_squad_id='$squad_id'");
    }

    /* main function */

    function get_recordings($conditions = "") {

        require('conn.php');

        $query = "SELECT * FROM recordings".$conditions;

        $recordings = array();

        if ($result = $conn->query($query)) {

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    $recording = array();

                    foreach ($row as $key => $val) {
                        $recording[$key] = $val;
                    }

                    $recordings[] = $recording;

                }

            }

        }

        return json_encode(array("recordings" => $recordings));

    }

    require_once('conn.php');

    $rapper_id = $_GET['rapper_id'] ?? "";

    $query = "SELECT * FROM `recordings`";
    $query .= !empty($rapper_id) ? "WHERE from_rapper_id='$rapper_id'" : "";

    $success = false;
    $message = '';
    $recordings = [];

    //if query executes:
    if ($queryResult = $conn->query($query)) {

        //if query returns any results:
        if ($queryResult->num_rows > 0) {

            while ($row = $queryResult->fetch_assoc()) {

                $recording_id = $row['id'];
                $to_squad_id = $row['to_squad_id'];
                $from_rapper_id = $row['from_rapper_id'];
                $to_rapper_id = $row['to_rapper_id'];
                $recording_url = $row['recording_url'];
                $date_uploaded = $row['date_uploaded'];

                $recording = array(
                    "recording_id" => $recording_id,
                    "to_squad_id" => $to_squad_id,
                    "from_rapper_id" => $from_rapper_id,
                    "to_rapper_id" => $to_rapper_id,
                    "recording_url" => $recording_url,
                    "creation_date" => $date_uploaded
                );

                $recordings[] = $recording;

            }
                
            $success = true;

        } else {

            $message = "Could not retrieve any recordings";

        }

    } else {

        $message = "shit! db is frigged";

    }

    print_r(
        json_encode(
            array(
                "recordings" => $recordings,
                "success" => $success,
                "message" => $message
            )
        )
    );

?>