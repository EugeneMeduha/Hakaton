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


?>