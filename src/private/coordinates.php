<?php 

    function checkIfIsVisible($x, $y, $r) {
        return (-$r * 3 <= $x and $x <= $r * 3) and (-$r * 3 <= $y and $y <= $r * 3);
    }
    
    function checkIfHitSquare($x, $y, $r) {
        return -$r * 2 <= $x and $x <= 0 and 0 <= $y  and $y <= $r * 2;
    }

    function checkIfHitCircle($x, $y, $r) {
        return $x >= 0 and $y >= 0 and pow($x, 2) + pow($y, 2) <= pow($r, 2);
    }

    function checkIfHitTriangle($x, $y, $r) {
        return $x >= 0 and $y <= 0 and $x + abs($y) <= $r * 2;
    }

    
    function checkIfHit($x, $y, $r) {
        return  checkIfHitSquare($x, $y, $r) or
                checkIfHitCircle($x, $y, $r) or
                checkIfHitTriangle($x, $y, $r);
    }