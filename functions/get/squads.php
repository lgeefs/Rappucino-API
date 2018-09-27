<?php

    function get_all_squads() {
        return get_squads();
    }

    function get_squad_from_id($id) {
        return get_squads(" WHERE id='$id'", true);
    }

    function get_squad_from_rapper_id($rapper_id) {
        return get_squads(" WHERE id IN (SELECT squad_id FROM squad_rappers WHERE rapper_id='$rapper_id')");
    }

    function get_squad_from_name($name) {
        return get_squads(" WHERE name='$name'");
    }

    function get_squads_from_query($search_term) {
        return get_squads(" WHERE name LIKE '%".$search_term."%'");
    }

    function get_squads($conditions = "", $with_rappers = false) {

        require('conn.php');
        require('rappers.php');

        $query = "SELECT * FROM squads".$conditions;

        $squads = array();
        $success = true;
        $message = null;

        if ($result = $conn->query($query)) {

            if ($result->num_rows > 0) {

                $success = true;

                while ($row = $result->fetch_assoc()) {

                    $squad = array();

                    foreach ($row as $key => $val) {
                        $squad[$key] = $val;
                    }

                    if ($with_rappers)
                        $squad['rappers'] = json_decode(get_rappers_from_squad_id($squad['id']))->rappers;

                    $squads[] = $squad;

                }

            } else {
                $message = "No results returned";
            }

        } else {
            $message = "Query failed to execute";
        }

        return json_encode(array(
            "squads" => $squads,
            "success" => $success,
            "message" => $message
        ));

    }
    
?>