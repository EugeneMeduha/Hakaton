<?php
if(!defined('WP_ADMIN')) define('WP_ADMIN',true);
include_once("nc.php");
include_once("common.php");
checklogin();
if(empty($_SESSION['adminname'])){
	$_SESSION['adminname']="";
}
if(empty($_SESSION['admin_type'])){
	$_SESSION['admin_type']=0;
}
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$lng_title_main?></title>
<link rel=stylesheet href="css/style.css" type="text/css">
<link type="text/css" href="css/cupertino/jquery-ui.css" rel="stylesheet" />


<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<script src="js/function.js" type="text/javascript"></script>
</head>

<body>
<div id="windowAlert" title="<?=$lng_attention?>">
   <div id="alertContent"></div>
   <center><div id="alertButtons"><input name="okButton" type="button" value="Ок" onClick='closeAlert();' style="margin-right:6px"></div></center>
</div>
<div class="header_panel"><h1 align="center"><?=$lng_title_main?> (<?=$_SESSION['adminname']?>)</h1></div>
<div>
<div class="left_panel"><table width="100%" border="0" cellpadding="2" cellspacing="2" bordercolor="#990000" bgcolor="#FFFFFF">
        <tr>
          <td><a class="button" href="main.i"><?=$lng_title_dashboard?></a></td>
        </tr>
        <tr>
          <td><a class="button" href="investor.i"><?=$lng_title_investor?></a></td>
        </tr>
        <tr>
          <td><a class="button" href="banners.i"><?=$lng_title_banners?></a></td>
        </tr>
        <tr>
          <td><a class="button" href="setting.i"><?=$lng_title_setting?></a></td>
        </tr>
	<tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><A class="button" href="change.i"><?=$lng_title_change_password?></A></td>
        </tr>
        <tr>
          <td><a class="button" href="logout.php"><?=$lng_exit?></a></td>
        </tr>
    </table></div>
<div class="main_panel">
	<?php if(isset($_GET['page'])){
			switch($_GET['page']){
				case 'main.i': include('main.php');
					break;
				case 'banners.i': include('banners.php');
					break;
				case 'editbanners.i': include('editbanners.php');
					break;
				case 'investor.i': include('investor.php');
					break;
				case 'setting.i': include('setting.php');
					break;
				case 'change.i': include('change.php');
					break;
			}
		}else include('main.php'); ?></div>
</div>
</body>
</html>