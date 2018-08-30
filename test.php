<?php

    require_once('functions/squads.php');
    require_once('functions/rappers.php');
    require_once('functions/recordings.php');

    print_r("test responses:<br/>");

    echo "<br />";

    print_r(get_all_squads());

    echo "<br />";

    print_r(get_all_rappers());

    echo "<br />";

    print_r(get_all_recordings());

    echo "<br />";

?>