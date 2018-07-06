<?php

    require_once('conn.php');

    $rapper_id = $_POST['rapper_id'];
    $squad_invitation_id = $_POST['squad_invitation_id'];

    $query = "SELECT * FROM `squad_invitations` WHERE id='$squad_invitation_id' AND to_rapper_id='$rapper_id'";

    $success = false;
    $message = '';

    //if query executes:
    if ($queryResult = $conn->query($query)) {

        //if query returns any results:
        if ($queryResult->num_rows > 0) {
            //theoretically, we have an open invitation, and we can now accept it

            if ($row = $queryResult->fetch_assoc()) {

                $squad_id = $row['squad_id'];

                $insert_query = "INSERT INTO `squad_rappers` (squad_id, rapper_id) VALUES
                ('$squad_id', '$rapper_id')";

                if ($insertResult = $conn->query($insert_query)) {

                    $delete_query = "DELETE FROM squad_invitations
                    WHERE id='$squad_invitation_id'
                    AND to_rapper_id='$rapper_id'";

                    if ($deleteResult = $conn->query($delete_query)) {
                        $success = true;
                    } else {
                        $message .= "\nCould not delete from squad_invitations";
                    }

                } else {
                    $message .= "\nCould not insert into squad_rappers";
                }

            } else {
                $message .= "\nCould not retrieve any squad invitations";
            }


        } else {

            $message = "Could not connect to db";

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
                "success" => $success,
                "message" => $message
            )
        )
    );

?>