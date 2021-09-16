<?php
require_once('line_connection.php');
require_once('connection.php');
require_once('session.php');

if ($_GET['state'] === getStateFromSession()) {
    $accessTokenJson = getAccessTokenWithJson();
    $checkedIdTokenJson = getCheckedIdTokenWithJson($accessTokenJson->id_token);
    registerUserIfNeeded($checkedIdTokenJson->aud);
    storeUserInfoInSession(
        $checkedIdTokenJson->aud,
        $accessTokenJson->access_token
    );
    header('Location: ./index.php');
}