<?php
    /** envia les capçaleres del tipus de contingut al navegador */
    header ( 'Content-Type: application/json' );
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxresetpasswordcontroller.php' );
    
    /** crea el objecte */
    $myObject = new ajaxresetpasswordcontroller ( );
    
    /** crida al mètode */
    $result = $myObject->recuperaPassword ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>