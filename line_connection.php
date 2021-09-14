<?php
session_start();
require_once('line_config.php');

function requestTokenJson()
{
    $requestTokenUrl = 'https://api.line.me/oauth2/v2.1/token';
    $tokenParam = [
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code'],
        'redirect_uri'  => REDIRECT_URL,
        'client_id'     => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'code_verifier' => $_SESSION['code_verifier'],
    ];

    $tokenCh = curl_init();
    curl_setopt($tokenCh, CURLOPT_URL, $requestTokenUrl);
    curl_setopt($tokenCh, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($tokenCh, CURLOPT_POST, true);
    curl_setopt($tokenCh, CURLOPT_POSTFIELDS, http_build_query($tokenParam));
    curl_setopt($tokenCh, CURLOPT_RETURNTRANSFER, true);
    $tokenResponse = curl_exec($tokenCh);
    var_dump($_SESSION['code_verifier']);
    curl_close($tokenCh);

    return json_decode($tokenResponse);
}
