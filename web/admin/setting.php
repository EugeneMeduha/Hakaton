<?php
if(!defined('WP_ADMIN')) header("Location: index.php");
$err_msg="";
if (isset($_POST['Submit'])){
	$arr = array('lng_contract_address','subject_for_hello_email','message_for_hello_email','host_for_hello_email','percent_ref','bitcoin_address','contract_address');
	$sql = "";
	foreach($_POST as $key=>$val){
		if(in_array($key,$arr))
			$sql.="Update public.ic_setting set value ='".pg_escape_string($val)."' where varibale='".$key."';";
	}
	if(!empty($sql))pg_query($link,$sql);
}
$result = pg_query($link,"Select * from public.ic_setting");
$array_name['subject_for_hello_email']=$lng_subject_for_hello_email;
$array_name['message_for_hello_email']=$lng_message_for_hello_email.$lng_comment_message_for_hello_email;
$array_name['host_for_hello_email']=$lng_host_for_hello_email;
$array_name['percent_ref']=$lng_percent_ref;
$array_name['contract_address']=$lng_contract_address;
$array_name['bitcoin_address']=$lng_bitcoin_address;

?>
<h2><?=$lng_title_setting?></h2>
<?=$err_msg; ?><br />
<form name="setting" method="post">
<div class="table">
  
<?php

while(($row = pg_fetch_assoc($result))!=null){
	?>
    <div class="row2"><div class="col1"><label for="<?=$row['varibale']?>"><?=$array_name[$row['varibale']]?></label></div><div class="col2"><input type="text" name="<?=$row['varibale']?>" value="<?=$row['value']?>"/></div></div>
    <?php
}
?>
<input class="ibutton" type="submit" name="Submit" value="<?=$lng_save?>" />
</div>
</form>