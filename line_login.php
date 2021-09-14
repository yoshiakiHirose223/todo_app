<?php
session_start();
$_SESSION['code_verifier'] = generateCodeVerifier();
$_SESSION['state'] = generateState();
define('CLIENT_ID', '1656411743');
define('CLIENT_SECRET', '72480486de8939e6f13afec18338a2df');
define('REDIRECT_URL', 'http://localhost:8080/line_callback.php');
define('STATE', $_SESSION['state']);
define('SCOPE', 'profile%20openid%20email');
define('LOGIN_URL', 'https://access.line.me/oauth2/v2.1/authorize?response_type=code' .
'&client_id='. CLIENT_ID
. '&redirect_uri=' . REDIRECT_URL
. '&state=' . STATE
. '&scope=' . SCOPE
. '&code_challenge=' . convertToCodeChallenge($_SESSION['code_verifier'])
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
    $encryptedCodeChallenge = convertToEncrypted($codeVerifier);
    return filterForParam($encryptedCodeChallenge);
}

function generateRandomLength()
{
    return rand(43, 128);
}

function generateRandomStr($length)
{
    $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
    $r_str = null;
    for ($i = 0; $i < $length; $i++) {
        $r_str .= $str[rand(0, count($str) - 1)];
    }
    return $r_str;
}

function convertToEncrypted($codeVerifier)
{
    $hashedStr = hash(
        'sha256',
        $codeVerifier
    );
    return base64_encode($hashedStr);
}

function filterForParam($encrypted)
{
    return str_replace(
        ['=','+', '/'],
        ['', '-', '_'],
        $encrypted
    );
}