<?php
/*      Because of the specifics of the task (drawing an image from graphic primitives, working with coordinates)
   the functions in this file are huge and consist of a routine code whitch may be difficult to read.
   Thus a lot of comments are written.
        The image rendering is divided into several functions only to facilitate code support. 
   Only generateImage() and encodeImage() functions should be used outside of this file. */

$width = 500;           # result image width (in pixels)
$height = 500;          # result image height (in pixels)
$betweenStrokes = 10;   # the distance between two strokes on the axis (in pixels)
$strokeLength = 3;      # the distance between axis and the end of the stroke (in pixels). Is equal to half of the stroke length.
$font = 5;

function generateDefaultPlaneImage(int $r) {
    /* returns GdImage with a standart mathematical coordinate plane */

    global $width, $height, $betweenStrokes, $strokeLength, $font;

    $image = imagecreatetruecolor($width, $height);

    # Solid colors 
    $white = imagecolorallocate($image, 255, 255, 255);
    $gray = imagecolorallocate($image, 34, 42, 49);

    imagefill($image, 0, 0, $white);

    # y axis line
    imageline($image, $width / 2, 0, $width / 2, $height, $gray);
    # x axis line
    imageline($image, 0, $height / 2, $width, $height / 2, $gray);
    # print origin
    imagestring($image, $font, $width / 2 - 10, $height / 2 + 1, "0", $gray);

    # strokes on the x-axis
    for ($x = $width / 2 + $betweenStrokes, $cnt = 1; $x < $width; $x += +$betweenStrokes, $cnt++) {
        # positive direction
        imageline($image, $x, $height / 2 - $strokeLength, $x, $height / 2 + $strokeLength, $gray);
        if (!($cnt == 1)) {
            # negative direction (skip first stroke because of "0" symbol)
            imageline($image, $width - $x, $height / 2 - $strokeLength, $width - $x, $height / 2 + $strokeLength, $gray);
        }
        # each 10th stroke should be extra high
        if ($cnt % 10 == 0) {
            imageline($image, $x, $height / 2 - $strokeLength * 3, $x, $height / 2 + $strokeLength * 3, $gray);
            imageline($image, $width - $x, $height / 2 - $strokeLength * 3, $width - $x, $height / 2 + $strokeLength * 3, $gray);
            # add signature
            imagestring($image, $font, $x - 2, $height / 2 + 6, $r * ($cnt / 10), $gray);
            imagestring($image, $font, $width - $x - 2, $height / 2 + 6, -$r * ($cnt / 10), $gray);
        }
    }

    # strokes on the y-axis
    for ($y = $height / 2 + $betweenStrokes, $cnt = 1; $y < $height; $y += $betweenStrokes, $cnt++) {
        # positive direction
        imageline($image, $width / 2 - $strokeLength, $height - $y, $width / 2 + $strokeLength, $height - $y, $gray);
        if (!($cnt == 1)) {
            # negative direction (skip first stroke because of "0" symbol)
            imageline($image, $width / 2 - $strokeLength, $y, $width / 2 + $strokeLength, $y, $gray);
        }
        # each 10th stroke should be extra high
        if ($cnt % 10 == 0) {
            imageline($image, $width / 2 - $strokeLength * 3, $y, $width / 2 + $strokeLength * 3, $y, $gray);
            imageline($image, $width / 2 - $strokeLength * 3, $height - $y, $width / 2 + $strokeLength * 3, $height - $y, $gray);
            # add signature
            imagestring($image, $font, $width / 2 - $strokeLength * 5, $y - 8, -$r * ($cnt / 10), $gray);
            imagestring($image, $font, $width / 2 - 20, $height - $y - 8, $r * ($cnt / 10), $gray);
        }
    }

    return $image;
}

function applyColorfulArea(GdImage $image) {
    /* Takes GdImage object and adds colorful half-transparent areas: 
       square, trinagle and circle's section */

    global $width, $height, $betweenStrokes, $strokeLength, $font;

    # Half-transparent colors (alpha-parameter is specified). 
    # Used to draw areas over the existing image and keep everythin underneath visible.
    $blue = imagecolorallocatealpha($image, 44, 120, 184, 30);
    $red = imagecolorallocatealpha($image, 228, 29, 35, 30);
    $green = imagecolorallocatealpha($image, 76, 175, 80, 30);

    # rectangle (-2R, 2R) (0, 0)
    imagefilledrectangle($image, $width / 2, $height / 2, $width / 2 - $betweenStrokes * 20, $height / 2 - $betweenStrokes * 20, $blue);

    # section - part of circle ((0, 0), R) 
    # only in the plane quareter (x > 0 and y > 0)
    imagefilledarc($image, $width / 2, $height / 2, $betweenStrokes * 20, $betweenStrokes * 20, -90, 0, $red, IMG_ARC_PIE);

    # triangle (0, 0) (2R, 0) (0, -2R)
    imagefilledarc($image, $width / 2, $height / 2, $betweenStrokes * 20 * 2, $betweenStrokes * 20 * 2, 0, 90, $green, IMG_ARC_CHORD);

    return $image;
}

function applyCursor(GdImage $image, int $x, int $y, int $r) {
    /* Takse GdImage object and adds pointer to the (x, y) point if it fits into the scale 
       (or does nothing otherwise). */

    $yellow = imagecolorallocate($image, 253, 216, 22);
    $gray = imagecolorallocate($image, 34, 42, 49);

    $width = imagesx($image);
    $height = imagesy($image);

    # bind coordinates to choosen scale
    $density = ($r / 100);
    $x = round($x / $density);
    $y = round($y / $density);

    # move origin from the left upper corner to the center of the image
    $x += $width / 2;
    $y = -$y + $height / 2;

    imagefilledellipse($image, $x, $y, 10, 10, $yellow);

    # draw cursor
    imageellipse($image, $x, $y, 3, 3, $gray);

    imageline($image, $x + 5, $y + 5, $x + 10, $y + 10, $gray);
    imageline($image, $x - 5, $y - 5, $x - 10, $y - 10, $gray);
    imageline($image, $x - 5, $y + 5, $x - 10, $y + 10, $gray);
    imageline($image, $x + 5, $y - 5, $x + 10, $y - 10, $gray);

    imageline($image, $x + 5, $y, $x + 15, $y, $gray);
    imageline($image, $x - 5, $y, $x - 15, $y, $gray);
    imageline($image, $x, $y + 5, $x, $y + 15, $gray);
    imageline($image, $x, $y - 5, $x, $y - 15, $gray);

    return $image;
}

function generateImage(int $x, int $y, int $r) {
    /* Returns completed image as a GdImage object. */

    $image = generateDefaultPlaneImage($r);
    $image = applyColorfulArea($image);
    $image = applyCursor($image, $x, $y, $r);

    return $image;
}

function encodeImage(GdImage $image) {
    /* Returns string representations of an image. */

    ob_start();
    imagejpeg($image);
    $outputBuffer = ob_get_clean();
    return base64_encode($outputBuffer);
}
?>