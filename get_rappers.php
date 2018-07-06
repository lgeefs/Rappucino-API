<?php

    require_once('conn.php');

    $rapper_id = $_GET['rapper_id'];
    $search_term = isset($_GET['query']) ? $_GET['query'] : '';

    $search_query = !empty($search_term) ? " WHERE (name LIKE '%".$search_term."%' OR handle LIKE '%".$search_term."%') AND id != '$rapper_id'" : '';

    $query = "SELECT * FROM `rappers`".$search_query;

    $success = false;
    $message = '';
    $rappers = [];

    //if query executes:
    if ($queryResult = $conn->query($query)) {

        //if query returns any results:
        if ($queryResult->num_rows > 0) {

            while ($row = $queryResult->fetch_assoc()) {

                $rapper_id = $row['id'];
                $name = $row['name'];
                $handle = $row['handle'];
                $picture_url = $row['picture_url'];

                $rapper = array(
                    "id" => $rapper_id,
                    "name" => $name,
                    "handle" => $handle,
                    "picture_url" => $picture_url
                );

                $rappers[] = $rapper;

            }
                
            $success = true;

        } else {

            $message = "Could not retreive any rappers";

        }

    } else {

        $message = "shit! db is frigged";

    }

    print_r(
        json_encode(
            array(
                "rappers" => $rappers,
                "success" => $success,
                "message" => $message
            )
        )
    );

?>