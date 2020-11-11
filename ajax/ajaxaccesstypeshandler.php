<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxaccesstypescontroller.php' );    
    
    /** crea el objecte */
    $myAccessType = new ajaxaccesstypescontroller ( );
    
    /** crida al mètode */
    $result = $myAccessType->render ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>