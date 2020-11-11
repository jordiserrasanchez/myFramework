<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxlopdcontroller.php' );    
    
    /** crea el objecte */
    $myLopd = new ajaxlopdcontroller ( );
    
    /** crida al mètode */
    $result = $myLopd->render ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>