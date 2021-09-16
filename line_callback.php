<?php
require_once('line_functions.php');
require_once('session.php');

if ($_GET['state'] === getStateFromSession()) {
    if (isset($_GET['code'])) {
        $accessTokenJson = getAccessTokenJson();
        $checkedIdTokenJson = getCheckedIdTokenJson($accessTokenJson->id_token);
        registerUserIfNeeded($checkedIdTokenJson->aud);
        storeUserInfoInSession(
            $checkedIdTokenJson->aud,
            $accessTokenJson->access_token
        );
        header('Location: ./index.php');
    } else {
        storeLoginErrorInSession($_GET['error']);
    }
} else {
    storeLoginErrorInSession('invalid state');
}

if (!is_null(getLoginErrorFromSession())) {
    header('Location: ./login_error.php');
}