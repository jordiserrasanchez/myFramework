<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxvisitdayhourscontroller.php' );    
    
    /** crea el objecte  */
    $myVisitDayHours = new ajaxvisitdayhourscontroller ( );
    
    /** crida al mètode */    
    $result = $myVisitDayHours->render ( );
    
    /** mostra el resultat per pantalla */   
    echo $result;
?>    
      
        
            