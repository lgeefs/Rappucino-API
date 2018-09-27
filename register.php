<?php

    require_once('conn.php');
    require_once('functions/post/rappers.php');

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $handle = isset($_POST['handle']) ? $_POST['handle'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $picture_url = isset($_POST['picture_url']) ? $_POST['picture_url'] : '';

    $response = create_rapper($name, $handle, $password, $picture_url);
    
    print_r($response);

?>