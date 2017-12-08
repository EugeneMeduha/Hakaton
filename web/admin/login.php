<?php
include("nc.php");

$msg = "";

if($_POST['formtype']=="login")
{
	$username = pg_escape_string($_POST['username']);
	$password = $_POST['password'];
	
	$sql = "select * from public.icadm where login='".$username."'";
	$result = pg_query($link,$sql);

	if(pg_num_rows($result)>0)
	{
		$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		if(md5($password.$key) == $row["password"])
		{
			$_SESSION['adminok'] = "ok";
			$_SESSION['adminname'] = $row["login"];
			$_SESSION['user_id'] = $row["id"];
			$_SESSION['admin_type'] = $row["admin_type"];
			$_SESSION['username'] = "username";
			$_SESSION['password'] = "password";
    		header("Location: index.php");

		}
		else{
			$msg = $lng_password_incorrect;
		}
	}
	else {
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
    <form class="login-form" method="post">
      <input type="hidden" name="formtype" value="login"/>
      <input type="text" name="username" placeholder="<?=$lng_enter?>"/>
      <input type="password" name="password" placeholder="<?=$lng_password?>"/>
      <button><?=$lng_enter?></button>
    </form>
  </div>
</div>
</body>
</html>
