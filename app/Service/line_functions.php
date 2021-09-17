<?php
require_once(dirname(__FILE__) . '/../Model/connection.php');
require_once(dirname(__FILE__) . '/./session.php');
require_once(dirname(__FILE__) . '/../Model/line_connection.php');

function canGetAccessToken()
{
    if (isset($_GET['code'])) {
        return true;
    } else {
        storeLoginErrorInSession('user authorization denied');
        return false;
    }
}

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

function hasError($responseJson)
{
    if (isset($responseJson->error)) {
        storeLoginErrorInSession($responseJson->error);
        return true;
    } else {
        return false;
    }
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