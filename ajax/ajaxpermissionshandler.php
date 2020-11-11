<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxpermissionscontroller.php' );
    
    /** crea el objecte */    
    $myPermission = new ajaxpermissionscontroller ( );
    
    /** crida al mètode */ 
    $result = $myPermission->render ( );
    
    /** mostra el resultat per pantalla */  
    echo $result;
?>