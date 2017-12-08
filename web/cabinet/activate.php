<?php
include("nc.php");

$msg = "";
$key = isset($_GET['key'])?$_GET['key']:$_POST['key'];
$key = pg_escape_string($key);

if (isset($_POST['formtype']) || $key)
if($_POST['formtype']=="valid" || $key)
{
	$sql = "select * from public.ic_user where reflink like '".$key."'";
	$result = pg_query($link,$sql);
	
	if(pg_num_rows($result)>0)
	{
		$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$referal = sha1($row['name'].$key.$row['email']);
		$sql = "Update public.ic_user set active='t', reflink='".$referal."' where id=".$row['id'];
		$result = pg_query($link,$sql);
		header("Location: index.php");
	} else {
		$msg = $lng_not_valid_key;
	}
} else {
	$sql = "select email from public.ic_user where email like '".pg_escape_string($_POST['email'])."'";
	$result = pg_query($link,$sql);
	
	if(pg_num_rows($result)>0)
	{
		$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$email = $row['email'];
		$sql = "Select * from ic_setting where \"varibale\" like 'host_for_hello_email'";
		$result = pg_query($link,$sql);
		$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$host = $row['value'];
		
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = 'To: '.$name.' '.$lastname.' <'.$email.'>';
		$headers[] = 'From: noreply <noreply@'.$host.'>';
	
		$sql = "Select * from ic_setting where \"varibale\" like 'subject_for_hello_email'";
		$result = pg_query($link,$sql);
		$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$subj = $row['value'];
	
		$sql = "Select * from ic_setting where \"varibale\" like 'message_for_hello_email'";
		$result = pg_query($link,$sql);
		$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$message = $row['value'];
		@mail($email,$subj,$message,implode("\r\n",$headers));
		header("Location: active.php");
	} else {
		$msg = $lng_user_not_found;
	}
}

?><html>
<head>
<title><?=$lng_title_login?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="login-page">
  <div class="form">
  <?=$msg?>
    <form class="register-form" method="post">
      <input type="hidden" name="formtype" value="resend"/>
      <input type="text" name="email" placeholder="<?=$lng_enter_email?>"/>
      <button><?=$lng_enter?></button>
      <p class="message"><a href="#"><?=$check_key?></a></p>
    </form>
    <form class="login-form" method="post">
      <input type="hidden" name="formtype" value="valid"/>
      <input type="text" name="key" placeholder="<?=$lng_enter_key?>"/>
      <button><?=$lng_enter?></button>
      <p class="message"><a href="#"><?=$lng_repeat_send?></a></p>
    </form>
  </div>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script language="javascript">
$(function(){
	if(location.hash == "#register")
		$('form').animate({height: "toggle", opacity: "toggle"}, "fast");
});

$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
</script>
</body>
</html>