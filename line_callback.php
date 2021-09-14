<?php
require_once('line_login.php');

$getTokenUrl = 'https://api.line.me/oauth2/v2.1/token';
$tokenParam = [
    'grant_type'    => 'authorization_code',
    'code'          => $_GET['code'],
    'redirect_uri'  => REDIRECT_URL,
    'client_id'     => CLIENT_ID,
    'client_secret' => CLIENT_SECRET,
];

$tokenCh = curl_init();
curl_setopt($tokenCh, CURLOPT_URL, $getTokenUrl);
curl_setopt($tokenCh, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($tokenCh, CURLOPT_POST, true);
curl_setopt($tokenCh, CURLOPT_POSTFIELDS, http_build_query($tokenParam));
curl_setopt($tokenCh, CURLOPT_RETURNTRANSFER, true);
$tokenResponse = curl_exec($tokenCh);
curl_close($tokenCh);

$tokenJson = json_decode($tokenResponse);
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