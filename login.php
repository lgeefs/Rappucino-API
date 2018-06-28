<?php

    require_once('conn.php');

    $handle = $_POST['handle'];
    $password = $_POST['password'];

    $query = "SELECT * FROM `rappers` WHERE handle='$handle'";

    $success = false;
    $message = '';
    $rapper_id = null;

    //if query executes:
    if ($queryResult = $conn->query($query)) {

        //if query returns any results:
        if ($queryResult->num_rows > 0) {

            $row = $queryResult->fetch_assoc();

            //check if password is correct
            if (password_verify($password, $row['password'])) {
                
                $rapper_id = $row["id"];
                $success = true;

            } else {

                $message = "wrong";

            }

        } else {

            $message = "no account registered with handle ".$handle;

        }

    } else {

        $message = "shit! db is frigged";

    }

    print_r(
        json_encode(
            array(
                "rapper_id" => $rapper_id,
                "success" => $success,
                "message" => $message
            )
        )
    );

?>