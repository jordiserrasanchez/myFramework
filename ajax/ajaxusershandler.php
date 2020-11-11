<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxuserscontroller.php' );
    
    /** crea el objecte */    
    $myUser = new ajaxuserscontroller ( );
    
    /** crida al mètode */ 
    $result = $myUser->render ( );
    
    /** mostra el resultat per pantalla */  
    echo $result;
?>