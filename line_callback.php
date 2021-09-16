<?php
require_once('line_connection.php');
require_once('connection.php');
require_once('session.php');

if ($_GET['state'] === getStateFromSession()) {
    $tokenJson = requestTokenJson();
    $checkedIdTokenJson = checkIdToken($tokenJson->id_token);
    if (canCreateUser($checkedIdTokenJson->aud)) {
        createUser($checkedIdTokenJson->aud);
    }
    storeUserIdInSession(getUserIdByAud($checkedIdTokenJson->aud));
    header('Location: ./index.php');
}