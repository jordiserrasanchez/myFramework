<?php

/* 
 * 2019, Jordi Serra Sanchez.
 * 
 * NOTICE OF LICENSE
 * 
 * DISCLAIMER
 * 
 * Jordi Serra Sanhcez <jordi@serraperez.cat>
 * Copyright (c),  2019 Jordi Serra Sanchez
 * License url  http://www.serraperez/licenses/
 */
    
    function redirectToLoginPage() {
        header('Location: login.php');
        exit();
    }

    /**
     * Evita la cache del navegador 
     */	
    function ae_noCache() {
        header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }
    
    function myFrameworkSession(){
	session_name("MYFWSESSID");
	session_start();
        
    }