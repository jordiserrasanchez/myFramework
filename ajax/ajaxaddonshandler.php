<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxaddonscontroller.php' );    
    
    /** crea el objecte */
    $myAddOn = new ajaxaddonscontroller ( );
    
    /** crida al mètode */
    $result = $myAddOn->render ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>