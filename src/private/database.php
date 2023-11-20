<?php
    function establishDbConnection() {
        try {
            return new PDO('mysql:host=database; dbname=lab1', 'root', getenv("MYSQL_ROOT_PASSWORD"));

        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            exit("Failed establish database connection");
        }
    }

    function addNewCheck(int $x, int $y, int $r, $time) {
        $db = establishDbConnection();

        # to avoid old PDO bag about passing bool values to db
        # see https://bugs.php.net/bug.php?id=49255
        $checkResult = (int) checkIfHit($x, $y, $r);

        try {
            $db->exec("
                INSERT INTO requests (x, y, r, is_correct, request_time) VALUES
                ($x, $y, $r, $checkResult, FROM_UNIXTIME($time))
            ");
        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            exit($e->getMessage());
        }
    }

    function getChecksList(int $howManyLines) {
        $db = establishDbConnection();

        try {
            $result =  $db->query("
                SELECT request_id, UNIX_TIMESTAMP(request_time) as request_time, 
                       x, y, r, is_correct as result
                  FROM requests
              ORDER BY request_id DESC
                 LIMIT $howManyLines
            ");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            exit($e->getMessage());
        }
    }

    