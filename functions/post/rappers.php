<?php

    function create_rapper($name, $handle, $password, $picture_url = '') {

        require('conn.php');
        require('functions/get/rappers.php');

        $rapper_id = uniqid('rapper');

        $success = false;
        $message = null;

        if (empty($name)
        || empty($handle)
        || empty($password)) {
            return json_encode(array(
                "success" => false,
                "message" => "Missing params!"
            ));
        }

        //query rappers with same handle to make sure it isn't taken
        $handle_available = count(json_decode(get_rapper_from_handle($handle), true)['rappers']) < 1;

        if ($handle_available) {

            //hash password
            $password = password_hash($password, PASSWORD_DEFAULT);

            //insert to db
            $query = "INSERT INTO `rappers` (id, `name`, `handle`, `password`, picture_url)
            VALUES ('$rapper_id', '$name', '$handle', '$password', '$picture_url')";

            if ($result = $conn->query($query)) {

                $success = true;

            } else {
                $message = "Query failed to execute";
            }
        } else {
            $message = "This handle is already associated with another rapper";
        }

        return json_encode(array(
            "success" => $success,
            "message" => $message,
            "rapper_id" => $rapper_id
        ));

    }
    
?>