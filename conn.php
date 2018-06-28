<?php

    $ini = parse_ini_file("../config/rappucino.ini");

    $host = $ini['host'];
    $user = $ini['user'];
    $pass = $ini['pass'];
    $db = $ini['db'];

    $conn = new mysqli($host, $user, $pass, $db);

    if (!$conn) {
        echo "Error establishing connecting to db :(";
        echo mysqli_error($conn);
    }

?>