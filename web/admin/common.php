<?php
function checklogin()
{
if(!isset($_SESSION['adminok']))
	header("location: login.php");
}
