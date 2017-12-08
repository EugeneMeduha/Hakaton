<?php
if(!defined('WP_ADMIN')) header("Location: index.php");
$err_msg="";

if (isset($_SESSION['per_page_investor'])) $per_page=$_SESSION['per_page_investor'];
else $per_page=50;
if (isset($_SESSION['offset_investor'])) $offset=$_SESSION['offset_investor'];
else $offset=1;

if (isset($_GET['offset'])) {
        $offset=$_GET['offset'];
        $_SESSION['offset_investor']=$offset;
}
if (isset($_GET['results_per_page'])){
        $per_page=$_GET['results_per_page'];
        $_SESSION['per_page_investor']=$per_page;
}

$Lfrom=($offset-1)*$per_page;
$Lto=$per_page;

$sql = "Select count(id) as cc from public.ic_user where true";

if (isset($sort)) $sql .=' order by '.$sort.' '.$type;
$result = pg_query($link,$sql);
$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
$colrow=$row['cc'];

?>
<h2><?=$lng_your_investors?></h2>
<?php echo $err_msg; ?><br />
<div>
  <div class="row3 rowhead"><div class="col1"><?=$lng_name_investors?></div>
    <div class="col2"><?=$lng_supply_investors?></div>
    <div class="col3"><?=$lng_referral_investors?></div>
  </div>
<?php
$sql = "Select (usr.name || ' ' || usr.lastname) as name,totalsupply, count(ref.*) as refer from public.ic_user as usr
LEFT JOIN public.ic_referrals as ref on usr.id=ref.id_user
group by usr.name,usr.totalsupply,usr.lastname";
$sql .=" limit ".$per_page." offset ".$Lfrom;

$resultRef = pg_query($link,$sql);
while(($rowRef = pg_fetch_array($resultRef, NULL, PGSQL_ASSOC))!=NULL){
?>
<div class="row3"><div class="col1"><?=$rowRef['name']?></div>
    <div class="col2"><?=$rowRef['totalsupply']?></div>
    <div class="col3"><?=$rowRef['refer']?></div>
  </div>
<?	
}
?><br class="clear" /><br />

<?php
$allpage=$colrow/$per_page;
$allpage=ceil($allpage);
if ($allpage>1){
		if ($offset!=1) echo '<a href="investor.i?offset=1">'.$lng_pagination_first.' | </a><a href="investor.i?offset='.($offset-1).'">'.$lng_pagination_prev.' | </a>';
		for ($i=0;$i<$allpage;$i++) echo '<a href="investor.i?offset='.($i+1).'">'.($i+1).' | </a>';
		if ($offset<$allpage) echo '<a href="investor.i?offset='.($offset+1).'">'.$lng_pagination_next.' | </a><a href="investor.i?offset='.$allpage.'">'.$lng_pagination_last.'</a>';
}
?>

</div>
