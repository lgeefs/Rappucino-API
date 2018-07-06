<?php

    require_once('conn.php');

    $rapper_id = $_GET['rapper_id'];

    $query = "SELECT * FROM `squads` WHERE id IN
    (SELECT squad_id FROM `squad_rappers` WHERE rapper_id = '$rapper_id')";

    $success = false;
    $message = '';
    $squads = [];
    $squad_invitations = [];

    //if query executes:
    if ($queryResult = $conn->query($query)) {

        //if query returns any results:
        if ($queryResult->num_rows > 0) {

            while ($row = $queryResult->fetch_assoc()) {

                $squad_id = $row['id'];
                $name = $row['name'];
                $picture_url = $row['picture_url'];

                $squad = array(
                    "id" => $squad_id,
                    "name" => $name,
                    "picture_url" => $picture_url
                );

                $squads[] = $squad;

            }
                
            $success = true;

        } else {

            $message = "Could not retreive any squads";

        }

    } else {

        $message = "shit! db is frigged";

    }

    $invitation_query = "SELECT * FROM `squad_invitations` WHERE to_rapper_id = '$rapper_id'";

    if ($result = $conn->query($invitation_query)) {

        while ($row = $result->fetch_assoc()) {

            $squad_invitations[] = $row;

        }

        $success = true;

    } else {
        $message .= "\nCould not retrieve squad_invitations";
    }

    print_r(
        json_encode(
            array(
                "squads" => $squads,
                "squad_invitations" => $squad_invitations,
                "success" => $success,
                "message" => $message
            )
        )
    );

?>