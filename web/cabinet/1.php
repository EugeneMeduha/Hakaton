<?php
include("vendor/autoload.php");

$api = new Admitad\Api\Api();
$clientId='b4c41f573af593e668debd784a3483';
$clientSecret='73dcabb17dbadd2e7c77f2a7f95775';
$base64Header='YjRjNDFmNTczYWY1OTNlNjY4ZGViZDc4NGEzNDgzOjczZGNhYmIxN2RiYWRkMmU3Yzc3ZjJhN2Y5NTc3NQ==';
$redirectUri='http://mediukha.com/investor/1.php';
$scope='';
if(empty($_GET['code'] && !isset($_COOKIE['code__aid']){
$authorizeUrl = $api->getAuthorizeUrl($clientId, $redirectUri, $scope);
header("Location: ".$authorizeUrl);
}
if (isset($_GET['code'])) {
$days = 90;
setcookie('code__aid', $_GET['code'], time() + 60 * 60 * 24 * $days, '/');
}

$code = $_COOKIE['code__aid'];

$response = $api->requestAccessToken($clientId, $clientSecret, $code, $redirectUri);
var_dump($response);
$result = $response->getResult();

var_dump($result);
