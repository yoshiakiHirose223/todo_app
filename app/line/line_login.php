<?php
require_once(dirname(__FILE__) . '/../Service/security.php');
require_once(dirname(__FILE__) . '/../Service/session.php');

storeCodeVerifierInSession(generateCodeVerifier());
storeStateInSession(generateState());

$loginAuthUrl = getLineLoginAuthUrl();
header('Location:' . $loginAuthUrl);