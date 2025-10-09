<?php
/**
 * @throws Exception
 */
function connect(): mysqli
{
    $host = 'mysql';
    $dbname = 'yeti_cave_db';
    $username = 'root';
    $password = 'root';

    try {
        $con = mysqli_connect($host, $username, $password, $dbname);
        if (!$con) {
            throw new Exception('Ошибка подключения к базе данных: ' . mysqli_connect_error());
        }
        mysqli_set_charset($con, 'utf8');
    } catch (Exception $e) {
        throw new Exception('Ошибка: ' . $e->getMessage());
    }

    return $con;
}
