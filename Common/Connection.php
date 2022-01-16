<?php
if (!isset($_SESSION)) {
    session_start();
}
$Host = "localhost";
$Database = "FormCMS";
$username = "root";
$password = "";
$setName = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8");

$connect = new PDO("mysql:host=$Host;dbname=$Database;", $username, $password, $setName);
$tbl_users = "user";
$tbl_log = "log";

$view_sql = "INSERT INTO `$tbl_log` SET `status`= ?";
$send = $connect->prepare($view_sql);
$send->bindValue(1 , 1);
$send->execute();
