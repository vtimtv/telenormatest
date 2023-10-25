<?php
define('BASE_DIR', str_replace(DIRECTORY_SEPARATOR,'/', dirname(__FILE__)).'/');

include ('../app/helpers.php');


$users_path = './data/users.csv';
$users = load_users();
$allow_methods = ['userslist', 'user', 'userdelete'];
$method = $_GET['method'];
$fields = ['id', 'fname', 'lname', 'position'];
if(!in_array($method, $allow_methods)){
    exit(404);
}
//ob_start();
switch($method){
    case 'userslist':
        echo json_encode($users);
        break;
    case 'user':
        $user = array();
        foreach($fields as $field){
            $user[$field] = $_REQUEST[$field];
        }
        $user['position'] = intval($user['position']);

        if($user['position'] < 1 || $user['position'] > 3){
            echo json_encode(['errors'=>['position'=> 'Select position!']]);
            logmessage('Select position!', $method, $user['position']);
            exit();
        }
        if(empty($user['fname'])){
            echo json_encode(['errors'=>['fname'=> 'Enter first name']]);
            logmessage('Enter first name!', $method, $user['fname']);
            exit();
        }
        if(empty($user['lname'])){
            echo json_encode(['errors'=>['lname'=> 'Enter last name']]);
            logmessage('Enter last name!', $method, $user['lname']);
            exit();
        }

        if(empty($user['id'])) {
            add_user($user);
        } else {
            update_user($user);
        }
        $users = load_users();
        echo json_encode($users);
        break;
    case 'userdelete':
        $user_id = $_POST['id'];
        delete_user($user_id);
        break;
}
//ob_end_flush();
