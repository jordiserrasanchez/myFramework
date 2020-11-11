<?php
    session_start();
 
    require_once 'include/autoload.php';
    include_once 'include/const.inc.php';
    dispatcher::getInstance()->dispatch();
?>