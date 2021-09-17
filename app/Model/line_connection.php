<?php
require_once(dirname(__FILE__) . '/../../config/line_config.php');
require_once(dirname(__FILE__) . '/../Service/session.php');

function getLineLoginAuthUrl()
{
    $lineLoginAuthUrl = 'https://access.line.me/oauth2/v2.1/authorize';
    $param = [
        'response_type'         => 'code',
        'client_id'             => CLIENT_ID,
        'redirect_uri'          => REDIRECT_URL,
        'state'                 => getStateFromSession(),
        'scope'                 => 'profile%20openid%20email'
        'code_challenge'        => convertToCodeChallenge(getCodeVerifierFromSession()),
        'code_challenge_method' => 'S256',
    ];
    var_dump($lineLoginAuthUrl . http_build_query($param));
    return $lineLoginAuthUrl . http_build_query($param);
}

function requestAccessToken()
{
    $requestTokenUrl = 'https://api.line.me/oauth2/v2.1/token';
    $param = [
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code'],
        'redirect_uri'  => REDIRECT_URL,
        'client_id'     => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'code_verifier' => getCodeVerifierFromSession(),
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $requestTokenUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $tokenResponse = curl_exec($ch);
    curl_close($ch);

    return $tokenResponse;
}

function requestCheckIdToken($idToken)
{
    $checkIdTokenUrl = 'https://api.line.me/oauth2/v2.1/verify';
    $param = [
        'id_token' => $idToken,
        'client_id' => CLIENT_ID,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $checkIdTokenUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $tokenResponse = curl_exec($ch);
    curl_close($ch);

    return $tokenResponse;
}

function destroyAccessToken()
{
    $logoutUrl = 'https://api.line.me/oauth2/v2.1/revoke';
    $param = [
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'access_token' => getAccessTokenFromSession(),
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $logoutUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
    $logoutResponse = curl_exec($ch);
}