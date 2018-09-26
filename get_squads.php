<?php

    require_once('functions/get/squads.php');

    $function = isset($_GET['function']) ? $_GET['function'] : '';

    $rapper_id = $_GET['rapper_id'] ?? "";
    $squad_id = $_GET['squad_id'] ?? "";
    $search_term = $_GET['search_term'] ?? "";

    // Error function to start; variable is updated upon successful response
    $response = json_encode(array(
        "squads" => [],
        "success" => false,
        "message" => "Missing param!"
    ));

    if ( $function == "from_id" ) {

        if ( !empty($squad_id) ) {
            $response = get_squad_from_id($squad_id);
        }

    } else if ( $function == "from_rapper_id" ) {

        if ( !empty($rapper_id) ) {
            $response = get_squad_from_rapper_id($rapper_id);
        }

    } else if ( $function == "from_query" ) {

        if ( !empty($search_term) ) {
            $response = get_squads_from_query($search_term);
        }

    } else if ( $function == "all" ) {

        $response = get_all_squads();

    }

    print_r($response);

?>