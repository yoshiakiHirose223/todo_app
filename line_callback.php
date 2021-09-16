<?php
session_start();
require_once('line_connection.php');
require_once('connection.php');

if ($_GET['state'] === $_SESSION['state']) {
    $tokenJson = requestTokenJson();
    $checkedIdTokenJson = checkIdToken($tokenJson->id_token);
    if (canCreateUser($checkedIdTokenJson->aud)) {
        createUser($checkedIdTokenJson->aud);
    }
    $_SESSION['user_id'] = getUserIdByAud($checkedIdTokenJson->aud);
    header('Location: ./index.php');
}