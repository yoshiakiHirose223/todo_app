<?php
require_once('session.php');
require_once('line_config.php');

storeCodeVerifierInSession(generateCodeVerifier());
storeStateInSession(generateState());
define('LOGIN_URL', 'https://access.line.me/oauth2/v2.1/authorize?response_type=code' .
'&client_id='. CLIENT_ID
. '&redirect_uri=' . REDIRECT_URL
. '&state=' . getStateFromSession()
. '&scope=profile%20openid%20email'
. '&code_challenge=' . convertToCodeChallenge(getCodeVerifierFromSession())
. '&code_challenge_method=S256'
);

function generateState()
{
    return bin2hex(openssl_random_pseudo_bytes(16));
}

function generateCodeVerifier()
{
    return generateRandomStr(generateRandomLength());
}

function convertToCodeChallenge($codeVerifier)
{
    return base64url_encode(
        hash(
            'sha256',
            $codeVerifier,
            true
        )
    );
}

function generateRandomLength()
{
    return rand(43, 128);
}

function generateRandomStr($length)
{
    $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'), array('-', '.', '_', '~'));
    $r_str = null;
    for ($i = 0; $i < $length; $i++) {
        $r_str .= $str[rand(0, count($str) - 1)];
    }
    return $r_str;
}

function base64url_encode($encrypted)
{
    return str_replace(
        ['=','+', '/'],
        ['', '-', '_'],
        base64_encode($encrypted)
    );
}