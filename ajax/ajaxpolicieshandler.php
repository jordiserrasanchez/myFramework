<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxpoliciescontroller.php' );

    /** crea el objecte */    
    $myPolicy = new ajaxpoliciescontroller ( );

    /** crida al mètode */    
    $result = $myPolicy->render ( );

    /** mostra el resultat per pantalla */    
    echo $result;
?>