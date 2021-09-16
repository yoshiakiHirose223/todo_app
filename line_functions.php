<?php
require_once('connection.php');
require_once('session.php');
require_once('line_connection.php');

function getAccessTokenJson()
{
    $accessToken = requestAccessToken();
    return json_decode($accessToken);
}

function getCheckedIdTokenJson($idToken)
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

function logout()
{
    destroyAccessToken();
    unsetAllSession();
}