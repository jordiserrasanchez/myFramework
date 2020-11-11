<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxreportscontroller.php' );
    
    /** crea el objecte */
    $myReport = new ajaxreportscontroller ( );
    
    /** crida al mètode */
    $result = $myReport->render ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>