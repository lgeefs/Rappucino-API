<?php

    function get_all_rappers() {
        return get_rappers();
    }

    function get_rapper_from_id($id) {
        return get_rappers(" WHERE id='$id'");
    }

    function get_rapper_from_squad_id($squad_id) {
        return get_rappers(" WHERE id IN (SELECT rapper_id FROM squad_rappers WHERE squad_id='$squad_id')");
    }

    function get_rappers($conditions = "") {

        require('conn.php');

        $query = "SELECT * FROM rappers".$conditions;

        $rappers = array();

        if ($result = $conn->query($query)) {

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    $rapper = array();

                    foreach ($row as $key => $val) {
                        $rapper[$key] = $val;
                    }

                    $rappers[] = $rapper;

                }

            }

        }

        return json_encode(array("rappers" => $rappers));

    }
    
?>