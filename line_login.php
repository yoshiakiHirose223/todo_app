<?php
define('CLIENT_ID', '1656411743');
define('CLIENT_SECRET', '72480486de8939e6f13afec18338a2df');
define('REDIRECT_URL', 'http://localhost:8080/line_callback.php');
define('STATE', generateState());
define('SCOPE', 'profile%20openid%20email');
define('CODE_VERIFIER', generateCodeVerifier());
define('CODE_CHALLENGE', convertToCodeChallenge(CODE_VERIFIER));

define('LOGIN_URL', 'https://access.line.me/oauth2/v2.1/authorize?response_type=code' .
'&client_id='. CLIENT_ID
. '&redirect_uri=' . REDIRECT_URL
. '&state=' . STATE
. '&scope=' . SCOPE
);

function generateState()
{
    return bin2hex(openssl_random_pseudo_bytes(16));
}

function generateCodeVerifier()
{
    return generateRandomLength(generateRandomLength());
}

function convertToCodeChallenge($codeVerifier)
{
    return convertToEncrypted($codeVerifier);
}

function generateRandomLength()
{
    return range(43, 128);
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