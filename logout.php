<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'cook_with_soumi');
define('DB_USER', 'root');
define('DB_PASS', '');

$GLOBALS['db_connection'] = null;

function getDB()
{
    if ($GLOBALS['db_connection'] === null) {

        $GLOBALS['db_connection'] = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );

        if ($GLOBALS['db_connection']->connect_error) {
            die('Erreur de connexion : ' .
                $GLOBALS['db_connection']->connect_error);
        }

        $GLOBALS['db_connection']->set_charset('utf8mb4');
    }

    return $GLOBALS['db_connection'];
}

function closeDB()
{
    if ($GLOBALS['db_connection'] !== null) {

        $GLOBALS['db_connection']->close();
        $GLOBALS['db_connection'] = null;
    }
}