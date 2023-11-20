<?php 
    include('./private/database.php');

    header("Content-Type: application/json");
    echo json_encode(getChecksList(6));
