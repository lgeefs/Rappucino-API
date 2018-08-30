<?php

    require_once('functions/recordings.php');

    $function = isset($_GET['function']) ? $_GET['function'] : '';

    $rapper_id = $_GET['rapper_id'] ?? "";
    $squad_id = $_GET['squad_id'] ?? "";

    // Error function to start; variable is updated upon successful response
    $response = json_encode(array(
        "recordings" => [],
        "success" => false,
        "message" => "Missing param!"
    ));

    if ( $function == "from_rapper_id" ) {

        if ( !empty($rapper_id) ) {
            $response = get_recordings_from_rapper_id($rapper_id);
        }

    } else if ( $function == "to_rapper_id" ) {

        if ( !empty($rapper_id) ) {
            $response = get_recordings_to_rapper_id($rapper_id);
        }

    } else if ( $function == "from_squad_id" ) {

        if ( !empty($squad_id) ) {
            $response = get_recordings_from_squad_id($squad_id);
        }

    } else if ( $function == "to_squad_id" ) {

        if ( !empty($squad_id) ) {
            $response = get_recordings_to_squad_id($squad_id);
        }

    } else if ( $function == "all" ) {

        $response = get_all_recordings();

    }

    print_r($response);

?>