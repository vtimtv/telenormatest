<?php

namespace App;

use PDO;

class Database
{
    protected static $pdo;

    public function __call($method, $args)
    {
        //var_dump($method);
        call_user_func_array(array(self::$pdo, $method), $args);
    }

    public static function get_connection()
    {
        if (self::$pdo) return self::$pdo;

        self::$pdo = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS);
        self::$pdo->query("SET NAMES 'utf8'");
        return self::$pdo;
    }

    public static function close_connection()
    {
        if (self::$pdo) {
            self::$pdo = null;
        }
    }

    private static function check_db_result($dbres, $abort_on_err = true)
    {
        //todo change echp to normal response with error
        if (!$dbres && $abort_on_err) echo self::$pdo->errorInfo()[2];
    }

    final public static function exec_query($sql, $abort_on_err = true)
    {
        //todo change echp to normal response with error
        if (trim($sql) == '') echo 'Empty db-query';
        $dbconn = self::get_connection();
        $dbres = $dbconn->query($sql);
        self::check_db_result($dbres, $abort_on_err);
        return $dbres;
    }
}
