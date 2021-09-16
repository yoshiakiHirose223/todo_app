<?php
session_start();

function unsetAllSession()
{
    $_SESSION = array();
}

function storeCodeVerifierInSession($codeVerifier)
{
    $_SESSION['code_verifier'] = $codeVerifier;
}

function getCodeVerifierFromSession()
{
    return $_SESSION['code_verifier'];
}

function storeStateInSession($state)
{
    $_SESSION['state'] = $state;
}

function getStateFromSession()
{
    return $_SESSION['state'];
}

function storeUserIdInSession($userId)
{
    $_SESSION['user_id'] = $userId;
}

function getUserIdFromSession()
{
    return $_SESSION['user_id'];
}

function storeAccessTokenInSession($accessToken)
{
    $_SESSION['access_token'] = $accessToken;
}

function getAccessTokenFromSession()
{
    return $_SESSION['access_token'];
}