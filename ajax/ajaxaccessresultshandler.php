<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxaccessresultscontroller.php' );    
    
    /** crea el objecte */
    $myResultAccess = new ajaxaccessresultscontroller ( );
    
    /** crida al mètode */
    $result = $myResultAccess->render ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>