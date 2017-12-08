<?php
include_once('conf.php');
if(!session_id()) {
session_name($session_name);
session_start();
}

//featured choose language
include("n18/rus.php");
$lng = "ru";

$link = pg_connect("host=".$dsn['db_host']." dbname=".$dsn['db_name']." user=".$dsn['db_user']." password=".$dsn['db_pass']) or die("Could not connect");

if (!empty($_COOKIE['user_set'])) {

	$result = pg_query($link,"Select * from ic_user where id='".$_COOKIE['user_set']."'");
	$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);

	$_SESSION['user_ok'] = "ok";
	$_SESSION['investname'] = $username;
	$_SESSION['user_id'] = $row['id'];
	$_SESSION['password'] = "password";
	$_SESSION['email'] = $row['email'];
	$sql = "UPDATE ic_user SET lastvisit=".time()." WHERE id = '".$_SESSION['user_id']."'";

	$resultA = pg_query($link,$sql);
}
?>