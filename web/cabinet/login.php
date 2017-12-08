<?php
include("nc.php");

$msg = "";

if (isset($_POST['formtype']))
if($_POST['formtype']=="login")
{
	$username = pg_escape_string($_POST['username']);
	$password = $_POST['password'];
	
	$sql = "select * from public.ic_user where email='".$username."'";
	$result = pg_query($link,$sql);

	if(pg_num_rows($result)>0)
	{
		$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		if($row["active"] == 'f')
		{
			$msg = "Account not active. Check your email.";
		} else if(md5($password.$key) == $row["password"])
		{
			$_SESSION['investok'] = "ok";
			$_SESSION['investname'] = $row["name"]." ".$row["lastname"];
			$_SESSION['email'] = $row["email"];
			$_SESSION['user_id'] = $row["id"];
			//$_SESSION['invest_type'] = $row["invest_type"];
			$_SESSION['username'] = "username";
			$_SESSION['password'] = "password";
			$sql = "UPDATE public.ic_user SET lastvisit=NOW() WHERE id = '".$_SESSION['user_id']."'";
			$resultA = pg_query($link,$sql);
    		header("Location: index.php");

		}
		else{
			$msg = $lng_password_incorrect;
		}
	}
	else {
		$msg = $lng_user_not_found;
    }
} else if ($_POST['formtype']=="register"){
    $name = pg_escape_string($_POST['name']);
    $lastname = pg_escape_string($_POST['lastname']);
    $email = pg_escape_string($_POST['email']);
    $password = pg_escape_string(md5($_POST['password'].$key));
    $referal = sha1($name.$key.$email);
	$country = intval($_POST['country']);
    $active = 'f';
	if ($_POST['password']!=$_POST['repassword']) $msg = $lng_password_no_equal;
	if (empty($email)) $msg = $lng_enter_email;
	if (empty($name)) $msg = $lng_enter_name;
	if (empty($lastname)) $msg = $lng_enter_lastname;
	if (empty($country)) $msg = $lng_choose_country;
	
	if(empty($msg)){
		$sql ="Insert into public.ic_user (name, lastname,email,password,reflink,active,country_id) values ('".$name."','".$lastname."','".$email."','".$password."','".$referal."','".$active."',".$country.") RETURNING id";
		$result = pg_query($link,$sql);
		$data = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		
		if(!empty($_SESSION['ref'])){
			$sql = "Select id from public.ic_user where reflink='".pg_escape_string($_SESSION['ref'])."'";
			$result = pg_query($link,$sql);
			$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			$id_user = $row['id'];
			$sql = "Select * from ic_setting where \"varibale\" like 'percent_ref'";
			$result = pg_query($link,$sql);
			$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			$percent = $row['value'];
			$sql ="Insert into public.ic_referrals (id_user, id_refer, date_refer, percent)	VALUES (".$id_user.", ".$data['id'].", now(), ".$percent.")";
			$result = pg_query($link,$sql);
		}

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
	
		
		$message = str_replace('#link#',$host.'/investor/activate.php?key='.$referal,$message);
	
		@mail($email,$subj,$message,implode("\r\n",$headers));
		$msg=$lng_check_email;
	} else {
		
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
      <input type="hidden" name="formtype" value="register"/>
      <input type="text" name="name" placeholder="<?=$lng_name?>" required/>
      <input type="text" name="lastname" placeholder="<?=$lng_lastname?>"  required/>
      <select name="country">
      <option value="" required><?=$lng_choose_country?></option>
<?php
	$sql = "Select country_id,title_".$lng." as title from _countries order by title_".$lng." asc";
	$result = pg_query($link,$sql);
	while (($row = pg_fetch_array($result, NULL, PGSQL_ASSOC))!=NULL){
		echo '<option value="'.$row['country_id'].'">'.$row['title'].'</option>';
	}
?>
      </select>
      <input type="text" name="email" placeholder="<?=$lng_email?>" required/>
      <input type="password" name="password" placeholder="<?=$lng_password?>" required/>
      <input type="password" name="repassword" placeholder="<?=$lng_repeat_password?>" required/>
      <button><?=$lng_create_account?></button>
      <p class="message"><?=$lng_registered?> <a href="#login"><?=$lng_enter?></a></p>
    </form>
    <form class="login-form" method="post">
      <input type="hidden" name="formtype" value="login"/>
      <input type="text" name="username" placeholder="<?=$lng_email?>"/>
      <input type="password" name="password" placeholder="<?=$lng_password?>"/>
      <button><?=$lng_enter?></button>
      <p class="message"><?=$lng_not_registered?> <a href="#register"><?=$lng_create_account?></a></p>
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
