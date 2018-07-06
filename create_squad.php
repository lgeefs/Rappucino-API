<?php

    require_once('conn.php');

    $squad_id = uniqid('squad');
    $rapper_id = $_POST['rapper_id'];
    $rappers = $_POST['rappers'];

    $rappers = explode(",", $rappers);

    $success = false;
    $message = '';

    $insert_query = "INSERT INTO `squad_invitations`
    (squad_id, from_rapper_id, to_rapper_id) VALUES ";
    
    for ($i = 0; $i < count($rappers); $i++) {
        $r = $rappers[$i];
        $insert_query .= ($i == 0) ? "" : ", ";
        $insert_query .= "('$squad_id', '$rapper_id', '$r')";
    }

    //if query executes:
    if ($result = $conn->query($insert_query)) {
                
        $create_squad_query = "INSERT INTO squads (id, name, picture_url)
        VALUES ('$squad_id', '', '')";

        if ($create_result = $conn->query($create_squad_query)) {

            $insert_squad_rapper_query = "INSERT INTO `squad_rappers` (squad_id, rapper_id) VALUES
            ('$squad_id', '$rapper_id')";

            if ($insert_squad_rapper_result = $conn->query($insert_squad_rapper_query)) {

                $success = true;

            } else {
                $message .= "\nCould not insert into squad_rapper";
            }

        } else {
            $message .= "\nCould not create squad";
        }

    } else {

        $message = "Could not invite to squad\nMay have invited too many rappers";

    }

    print_r(
        json_encode(
            array(
                "success" => $success,
                "message" => $message
            )
        )
    );

?>