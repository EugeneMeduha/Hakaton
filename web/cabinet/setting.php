<?php
if(!defined('WP_ADMIN')) header("Location: index.php");
$err_msg="";
$result = pg_query($link,"Select id,reflink from public.ic_user where email='".$_SESSION['email']."'");
$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
$reflink = $row['reflink'];
?>
<h2><?=$lng_title_setting?></h2>
<?=$err_msg; ?><br />