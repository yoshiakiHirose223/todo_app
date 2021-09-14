<?php
session_start();
require_once('line_connection.php');

if ($_GET['state'] === $_SESSION['state']) {
    $tokenJson = requestTokenJson();
    var_dump($tokenJson);
}


$accessToken = $tokenJson->access_token;
$idToken = $tokenJson->id_token;
$refreshToken = $tokenJson->refresh_token;

$getProfileUrl = 'https://api.line.me/oauth2/v2.1/verify';
$profileParam = [
    'id_token'  => $idToken,
    'client_id' => CLIENT_ID,
];

$profileCh = curl_init();
curl_setopt($profileCh, CURLOPT_URL, $getProfileUrl);
curl_setopt($profileCh, CURLOPT_POST, true);
curl_setopt($profileCh, CURLOPT_POSTFIELDS, http_build_query($profileParam));
curl_setopt($profileCh, CURLOPT_RETURNTRANSFER, true);
$profileResponse = curl_exec($profileCh);
curl_close($profileCh);

$profileJson = json_decode($profileResponse);