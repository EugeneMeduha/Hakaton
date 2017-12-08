<?php
if(!defined('WP_ADMIN')) header("Location: index.php");
$err_msg="";
if (isset($_POST['Submit'])){
	$result = pg_query($link,"Select * from public.ic_user where email='".$_SESSION['email']."'");
	$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);;
	if ($row['password']==md5($_POST['old_pass'].$key))
		if ($_POST['pass']==$_POST['con_pass']){
			$pass=md5($_POST['pass'].$key);
			pg_query("Update public.ic_user set password ='".$pass."' where email='".$_SESSION['email']."'");
		}
		else $err_msg= '<br /><b>'.$lng_password_no_equal.'</b><br />';
	else  $err_msg= '<br /><b>'.$lng_password_incorrect.'</b><br />';
	pg_close($link);
}

?>
  <h2><?=$lng_title_chage_password?></h2>
<?php echo $err_msg; ?><BR>
<FORM action=change.i method=post>
<div class="table">
  <div class="row2"><div class="col1"><?=$lng_old_password?>:</div>
    <div class="col2"><input name="old_pass" type="password" value="" size="50" /></div>
  </div>
<br />
  <div class="row2"><div class="col1"><?=$lng_new_password?>:</div>
    <div class="col2"><input name="pass" type="password" value="" size="50" /></div>
  </div>
  <div class="row2"><div class="col1"><?=$lng_repeat_password?>:</div>
    <div class="col2"><input name="con_pass" type="password" value="" size="50" /></div>
  </div>
</div>
<p>
<input class="ibutton" type="submit" name="Submit" value="<?=$lng_save?>" />
 </p>
</FORM>