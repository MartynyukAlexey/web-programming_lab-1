<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../coordinates.php';

class CoordinatesTest extends TestCase
{
    public function testCheckIfHitSquare()
    {
        $testTable = [
            [ 1,  1,  1, false],
            [-1,  1,  1, true],
            [ 1, -1,  1, false], 
            [-1, -1,  1, false],
            [ 0,  0,  1, true],
        ];

        foreach ($testTable as [$x, $y, $r, $expected]) {
            $this->assertEquals($expected, checkIfHitSquare($x, $y, $r));
        }
    }

    public function testCheckIfHitCircle()
    {
        $testTable = [
            [ 1,  1,  1, false],
            [ 1,  1,  5, true],
            [-1,  1,  1, false],
            [ 1, -1,  1, false], 
            [-1, -1,  1, false],
            [ 0,  0,  1, true],
        ];

        foreach ($testTable as [$x, $y, $r, $expected]) {
            $this->assertEquals($expected, checkIfHitCircle($x, $y, $r));
        }
    }

    public function testCheckIfHitTriangle()
    {
        $testTable = [
            [ 1,  1,  1, false],
            [-1,  1,  1, false],
            [ 1, -1,  1, true], 
            [-1, -1,  1, false],
            [ 1, -1,  2, true],
            [ 2, -2,  1, false],
            [ 0,  0,  1, true],
        ];

        foreach ($testTable as [$x, $y, $r, $expected]) {
            $this->assertEquals($expected, checkIfHitTriangle($x, $y, $r));
        }
    }

    public function testCheckIfHit() {
        $testTable = [
            [-1,  1,  1, true],
            [ 0,  0,  1, true],
            [ 1,  1,  5, true],
            [ 0,  0,  1, true],
            [ 1, -1,  1, true],
            [ 1, -1,  2, true],
            [ 0,  0,  1, true],
            [ 2,  2,  1, false],
            [-2, -2,  1, false],
        ];

        foreach ($testTable as [$x, $y, $r, $expected]) {
            $this->assertEquals($expected, checkIfHit($x, $y, $r));
        }
    }

    public function testCheckIfVisible() {
        $testTable = [
            [ 1,  1,  1, true],
            [-1,  1,  1, true],
            [ 1, -1,  1, true], 
            [-1, -1,  1, true],
            [ 0,  0,  1, true],
            [10,  1,  1, false],
            [-1, 10,  1, false],
            [ 5,  5,  1, false], 
        ];

        foreach ($testTable as [$x, $y, $r, $expected]) {
            $this->assertEquals($expected, checkIfIsVisible($x, $y, $r));
        }
    }
}