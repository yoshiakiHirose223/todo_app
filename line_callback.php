<?php
require_once('line_login.php');

$getTokenUrl = 'https://api.line.me/oauth2/v2.1/token';
$param = [
    'grant_type'    => 'authorization_code',
    'code'          => $_GET['code'],
    'redirect_uri'  => REDIRECT_URL,
    'client_id'     => CLIENT_ID,
    'client_secret' => CLIENT_SECRET,
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $getTokenUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$json = json_decode($response);
var_dump($json);