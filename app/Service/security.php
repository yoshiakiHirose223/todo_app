<?php

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