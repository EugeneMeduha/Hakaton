<?php
if(!defined('WP_ADMIN')) header("Location: index.php");
if(empty($_SESSION['email'])) exit;
$err_msg="";
$result = pg_query($link,"Select * from public.ic_user where email='".$_SESSION['email']."'");
$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
$totalsupply = $row['totalsupply'];
?>
<h2><?=$lng_title_dashboard?></h2>
<?=$err_msg; ?><br />
<?=$lng_supply.":".$totalsupply?><br />