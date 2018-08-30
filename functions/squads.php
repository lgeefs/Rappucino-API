<?php

    function get_all_squads() {
        return get_squads();
    }

    function get_squad_from_id($id) {
        return get_squads(" WHERE id='$id'");
    }

    function get_squad_from_rapper_id($rapper_id) {
        return get_squads(" WHERE id IN (SELECT squad_id FROM squad_rappers WHERE rapper_id='$rapper_id')");
    }

    function get_squads($conditions = "") {

        require('conn.php');

        $query = "SELECT * FROM squads".$conditions;

        $squads = array();

        if ($result = $conn->query($query)) {

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    $squad = array();

                    foreach ($row as $key => $val) {
                        $squad[$key] = $val;
                    }

                    $squads[] = $squad;

                }

            }

        }

        return json_encode(array("squads" => $squads));

    }
    
?>