<?php
    /** envia les capçaleres del tipus de contingut al navegador */
    header ( 'Content-Type: application/json' );
    
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxdashboardcontroller.php' );    
    
    /** crea el objecte */
    $mydashboard = new ajaxdashboardcontroller ( );
    
    /** crida al mètode */ 
    $result = $mydashboard->render ( );
    
    /** mostra el resultat per pantalla */  
    echo $result;
?>