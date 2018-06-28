<?php

    require_once('conn.php');

    $rapper_id = uniqid('rapper');
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $handle = isset($_POST['handle']) ? $_POST['handle'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $picture_url = isset($_POST['picture_url']) ? $_POST['picture_url'] : '';

    $password = password_hash($password, PASSWORD_DEFAULT);

    $selectQuery = "SELECT * FROM `rappers` WHERE handle='$handle'";

    $success = false;
    $message = '';

    if ($selectResult = $conn->query($selectQuery)) {

        if ($selectResult->num_rows < 1) {

            $insertQuery = "INSERT INTO `rappers` (id, name, `handle`, password, picture_url)
            VALUES ('$rapper_id', '$name', '$handle', '$password', '$picture_url')";

            if ($insertResult = $conn->query($insertQuery)) {

                $success = true;

            } else {
                $message .= 'Could not register name:' . $name . ' handle: '. $handle . ' password ' . $password;
            }

        } else {
            $message .= 'This handle is already associated with another rapper';
        }

    } else {
        $message .= 'Could not connect to database';
    }

    print_r(
        json_encode(
            array(
                "success" => $success,
                "message" => $message,
                "rapper_id" => $rapper_id
            )
        )
    );

?>