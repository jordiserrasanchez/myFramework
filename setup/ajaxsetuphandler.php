<?php
    /** requereix el fitxer amb la clase */
    require_once ( 'ajaxsetup.php' );    
    
    /** crea el objecte */
    $mySetup = new ajaxsetup ( );
    
    /** crida al mètode */
    $result = $mySetup->render ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>