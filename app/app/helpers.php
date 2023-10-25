<?php

define("DB_HOST", "telenormadb");
define("DB_NAME", "telenorma");
define("DB_USER", "root");
define("DB_PASS", "r00tadmin");

include_once ('../app/inc.php');

include ('../app/Database.php');

Use App\Database;

function load_users()
{
    $sql = "SELECT * FROM users order by id asc";
    $res = Database::exec_query($sql);
    $rows = [];
    foreach ($res as $row) {
            $rows[] = $row;
    }
    return $rows;
}

function add_user($user)
{
    $sql = sprintf("insert into users (fname, lname, position) values ('%s', '%s', %d)", $user['fname'], $user['lname'], $user['position']);
    if(Database::exec_query($sql)) {
        return true;
    }
    return false;
}

function update_user($user)
{
    $sql = sprintf("update users set fname = '%s', lname = '%s', position = %d where id = %d", $user['fname'], $user['lname'], $user['position'], $user['id']);
    if(Database::exec_query($sql)) {
        return true;
    }
    return false;
}

function delete_user($id)
{
    $sql = sprintf("DELETE FROM users WHERE id = %d", $id);
    if(Database::exec_query($sql)) {
        return true;
    }
    return false;
}

function logmessage($message, $methhd, $email)
{
    $file_name = BASE_DIR.'logs/' . date('Y-m-d') . '.log';
    $log = fopen($file_name, 'a');
    $record = sprintf("%s %s %s %s\r\n", date('Y-m-d H:i:s'), $methhd, $email, $message);
    fwrite($log, $record);
    fclose($log);
}
