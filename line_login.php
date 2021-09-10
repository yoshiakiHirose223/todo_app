<?php
define('CLIENT_ID', '1656411743');
define('REDIRECT_URL', 'http://localhost:8080');
define('STATE', getState());
define('SCOPE', 'profile%20openid%20email');

define('LOGIN_URL', 'https://access.line.me/oauth2/v2.1/authorize?response_type=code' .
'&client_id='. CLIENT_ID
'&redirect_uri=' . REDIRECT_URL
'&state=' . STATE
'&scope=' . SCOPE
);

function getState()
{
    return bin2hex(openssl_random_pseudo_bytes(16));
}