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
        $success = false;
        $message = null;

        if ($result = $conn->query($query)) {

            if ($result->num_rows > 0) {

                $success = true;

                while ($row = $result->fetch_assoc()) {

                    $recording = array();

                    foreach ($row as $key => $val) {
                        $recording[$key] = $val;
                    }

                    $recordings[] = $recording;

                }

            } else {
                $message = "No results returned";
            }

        } else {
            $message = "Query failed to execute";
        }

        return json_encode(array(
            "recordings" => $recordings,
            "success" => $success,
            "message" => $message
        ));

    }

?>