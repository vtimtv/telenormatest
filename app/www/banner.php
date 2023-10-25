<?php

ob_start();
define("DB_HOST", "bannerdb");
define("DB_NAME", "banner");
define("DB_USER", "root");
define("DB_PASS", "r00tadmin");

include("../app/Database.php");

$ip = $_SERVER['REMOTE_ADDR'] ?? "";
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? "";
$page_url = $_SERVER['HTTP_REFERER'] ?? "";
$view_date = date('Y-m-d') ?? "";
print_r($page_url);
$sql =  sprintf("SELECT * from banners where ip = '%s' and view_date = '%s' and user_agent = '%s' and page_url = '%s' ", addcslashes($ip, '"\\'), addcslashes($view_date, '"\\'), addcslashes($user_agent, '"\\'), addcslashes($page_url, '"\\'));
$res = \App\Database::exec_query($sql);
$banner = $res->fetch();
$views_count = 1;
$sql =  sprintf("INSERT INTO banners (ip, view_date, user_agent, page_url, views_count) VALUES ('%s', '%s', '%s', '%s', %d)", addcslashes($ip, '"\\'), addcslashes($view_date, '"\\'), addcslashes($user_agent, '"\\'), addcslashes($page_url, '"\\'), $views_count);
if(isset($banner) && !empty($banner) && intval($banner['views_count']) > 0) {
    $views_count = intval($banner['views_count']) + 1;
    $sql = sprintf("UPDATE banners SET views_count = %d where id = %d", $views_count, $banner['id']);
}
\App\Database::exec_query($sql);
ob_end_clean();
$fn = $_GET['fn'] ?? null;
$path = !empty($fn)? './assets/'.$fn : '';
if(file_exists($path)) {
    $img = file_get_contents($path);
    header('Content-Type: image/jpeg');
    header("Content-Length: " . strlen($img));
    echo $img;
}else {
    header("HTTP/1.0 404 Not Found");
    die("Error 404 - sorry");
}
