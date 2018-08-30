<?php

    require_once('functions/rappers.php');

    $function = isset($_GET['function']) ? $_GET['function'] : '';

    $rapper_id = $_GET['rapper_id'] ?? "";
    $squad_id = $_GET['squad_id'] ?? "";
    $search_term = $_GET['search_term'] ?? "";

    // Error function to start; variable is updated upon successful response
    $response = json_encode(array(
        "rappers" => [],
        "success" => false,
        "message" => "Missing param!"
    ));

    if ( $function == "from_id" ) {

        if ( !empty($rapper_id) ) {
            $response = get_rapper_from_id($rapper_id);
        }

    } else if ( $function == "from_squad_id" ) {

        if ( !empty($squad_id) ) {
            $response = get_rappers_from_squad_id($squad_id);
        }

    } else if ( $function == "from_query" ) {

        if ( !empty($rapper_id) && !empty($search_term) ) {
            $response = get_rappers_from_query($search_term, $rapper_id);
        }

    } else if ( $function == "all" ) {

        $response = get_all_rappers();

    }

    print_r($response);

?>