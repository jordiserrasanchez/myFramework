<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxvisitdayscontroller.php' );    
    
    /** crea el objecte  */
    $myVisitDays = new ajaxvisitdayscontroller ( );
    
    /** crida al mètode */    
    $result = $myVisitDays->render ( );
    
    /** mostra el resultat per pantalla */   
    echo $result;
?>    
      
        
            