<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxcomponentscontroller.php' );    
    
    /** crea el objecte */
    $myComponent = new ajaxcomponentscontroller ( );
    
    /** crida al mètode */
    $result = $myComponent->render ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>