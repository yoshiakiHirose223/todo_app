<?php
require_once(dirname(__FILE__) . '/../Service/line_functions.php');
require_once(dirname(__FILE__) . '/../Service/session.php');

if ($_GET['state'] === getStateFromSession()) {
    if (canGetAccessToken()) {
        $accessTokenJson = getAccessTokenJson();
        $checkedIdTokenJson = getCheckedIdTokenJson($accessTokenJson->id_token);

        if (!hasError($checkedIdTokenJson)) {
            registerUserIfNeeded($checkedIdTokenJson->aud);
            storeUserInfoInSession(
                $checkedIdTokenJson->aud,
                $accessTokenJson->access_token
            );
            header('Location: ./index.php');
        }
    }
}

if (sessionHasLoginError()) {
    header('Location: login_error.php');
}