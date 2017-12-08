<?php
function checklogin()
{
if(!isset($_SESSION['investok']))
	header("location: login.php");
}
