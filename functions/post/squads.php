<?php

    // @param string $name
    // @param string $rapper_id
    // @param array $rappers

    function create_squad($name, $rapper_id, $rappers = []) {

        require('conn.php');

        $squad_id = uniqid('squad');

        $success = false;
        $message = null;

        if (empty($name)
        || empty($rapper_id)
        || count($rappers) < 1) {
            return json_encode(array(
                "success" => false,
                "message" => "Missing params!"
            ));
        }

        //query rappers with same handle to make sure it isn't taken
        $handle_available = count(json_decode(get_squad_from_name($name), true)['squads']) < 1;

        if ($handle_available) {

            //create squad, only continue if returns success
            $squad_created = json_decode(insert_squad($squad_id), true)['success'];

            if ($squad_created) {

                $success = true;
                $message = "Squad was created successfully";

                // send out squad invitations. If this fails, do not create the squad
                $squad_invitation_created = json_decode(insert_squad_invitation($rappers), true)['success'];

                if (!$squad_invitation_created) {

                    $message .= "\nFailed to send squad invitations";

                }

            }
            
        } else {
            $message = "This name is already associated with another squad";
        }

        return json_encode(array(
            "success" => $success,
            "message" => $message,
            "squad_id" => $squad_id
        ));

    }

    // @param string $squad_id
    // @param string $name
    function insert_squad($squad_id, $name) {

        if (empty($squad_id)
        || empty($name)) {
            return json_encode(array(
                "success" => false,
                "message" => "Missing param!"
            ));
        }

        require('conn.php');

        $query = "INSERT INTO squads (id, name, picture_url)
        VALUES ('$squad_id', '$name', '')";

        $success = false;
        $message = null;

        if ($result = $conn->query($query)) {
            $success = true;
        } else {
            $message = "Could not execute query.";
        }

        return json_encode(array(
            "success" => $success,
            "message" => $message
        ));

    }

    // @param string $squad_id
    // @param string $rapper_id
    function insert_squad_rapper($squad_id, $rapper_id) {

        if (empty($squad_id)
        || empty($rapper_id)) {
            return json_encode(array(
                "success" => false,
                "message" => "Missing params!"
            ));
        }

        require('conn.php');

        $query = "INSERT INTO `squad_rappers` (squad_id, rapper_id) VALUES";

        for ($i = 0; $i < count($rappers); $i++) {
            $r = $rappers[$i];
            $query .= ($i == 0) ? "" : ", ";
            $query .= "('$squad_id', '$rapper_id')";
        }

        $success = false;
        $message = null;

        if ($result = $conn->query($query)) {

            $success = true;

        } else {
            $message = "Could not insert into squad_rappers";
        }

        return json_encode(array(
            "success" => $success,
            "message" => $message
        ));

    }

    // @param array $rappers;
    function insert_squad_invitation($rappers = []) {

        if (count($rappers) < 1) {
            return json_encode(array(
                "success" => false,
                "message" => "No rappers to invite."
            ));
        }

        require('conn.php');

        $query = "INSERT INTO `squad_invitations`
        (squad_id, from_rapper_id, to_rapper_id) VALUES ";
        
        for ($i = 0; $i < count($rappers); $i++) {
            $r = $rappers[$i];
            $query .= ($i == 0) ? "" : ", ";
            $query .= "('$squad_id', '$rapper_id', '$r')";
        }

        $success = false;
        $message = null;

        if ($result = $conn->query($query)) {
                
            $success = true;

        } else {
            $message = "Query failed to execute";
        }

        return json_encode(array(
            "success" => $success,
            "message" => $message
        ));

    }
    
?>