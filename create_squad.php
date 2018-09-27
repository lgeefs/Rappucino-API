<?php

    require_once('conn.php');
    require_once('functions/post/squads.php');

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $rapper_id = isset($_POST['rapper_id']) ? $_POST['rapper_id'] : '';
    $rappers = isset($_POST['rappers']) ? $_POST['rappers'] : '';

    $rappers = explode(",", $rappers);

    $response = create_squad($name, $rapper_id, $rappers);

    print_r($response);

?>