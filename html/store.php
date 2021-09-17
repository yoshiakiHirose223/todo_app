<?php
require_once(dirname(__FILE__) . '/../app/Service/functions.php');

savePostedData($_POST);
header('Location: ./index.php');