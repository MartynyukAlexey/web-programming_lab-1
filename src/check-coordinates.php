<?php
    include('./private/image.php');
    include('./private/database.php');
    include('./private/coordinates.php');

    if (!isset($_POST["x"]) or !isset($_POST["y"]) or !isset($_POST["r"]) or !isset($_POST["time"])) {
        http_response_code(400);
        exit();
    }

    $x = intval($_POST["x"]);
    $y = intval($_POST["y"]);
    $r = intval($_POST["r"]);
    // go from milliseconds to seconds in unix timestamp
    $time = ceil(intval($_POST["time"]) / 1000);

    addNewCheck($x, $y, $r, $time);
    
    $encodedImage = encodeImage(generateImage($x, $y, $r));

    header("Content-Type: application/json");

    echo json_encode(array('image'=>$encodedImage, 'result'=>checkIfHit($x, $y, $r)));
