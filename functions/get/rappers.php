<?php

    function get_all_rappers() {
        return get_rappers();
    }

    function get_rapper_from_id($id) {
        return get_rappers(" WHERE id='$id'");
    }

    function get_rapper_from_handle($handle) {
        return get_rappers(" WHERE handle='$handle'");
    }

    function get_rappers_from_squad_id($squad_id) {
        return get_rappers(" WHERE id IN (SELECT rapper_id FROM squad_rappers WHERE squad_id='$squad_id')");
    }

    function get_rappers_from_query($search_term, $rapper_id) {
        return get_rappers(" WHERE (name LIKE '%".$search_term."%' OR handle LIKE '%".$search_term."%') AND id != '$rapper_id'");
    }

    function get_rappers($conditions = "") {

        require('conn.php');

        $query = "SELECT * FROM rappers".$conditions;

        $rappers = array();
        $success = false;
        $message = null;

        if ($result = $conn->query($query)) {

            if ($result->num_rows > 0) {

                $success = true;

                while ($row = $result->fetch_assoc()) {

                    $rapper = array();

                    foreach ($row as $key => $val) {
                        $rapper[$key] = $val;
                    }

                    $rappers[] = $rapper;

                }

                $success = true;

            } else {
                $message = "No results returned";
            }

        } else {
            $message = "Query failed to execute";
        }

        return json_encode(array(
            "rappers" => $rappers,
            "success" => $success,
            "message" => $message
        ));

    }
    
?>