<?php
require_once('connection.php');
require_once('line_connection.php');

function getAccessTokenWithJson()
{
    $accessToken = requestAccessToken();
    return json_decode($accessToken);
}

function getCheckedIdTokenWithJson($idToken)
{
    $checkedIdToken = requestCheckIdToken($idToken);
    return json_decode($checkedIdToken);
}

function registerUserIfNeeded($aud)
{
    $canRegister = canRegisterUser($aud);
    if ($canRegister) {
        registerUser($aud);
    }
}
