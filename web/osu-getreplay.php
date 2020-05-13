<?php

    header("Content-Transfer-Encoding: binary");
    header("Content-Disposition: attachment; filename=replay.osr");

    echo @file_get_contents("replays/" . intval($_GET["c"]));
?>