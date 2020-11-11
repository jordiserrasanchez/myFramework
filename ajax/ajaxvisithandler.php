<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxvisitcontroller.php' );    
    
    /** crea el objecte  */
    $myVisit = new ajaxvisitcontroller ( );
    
    /** crida al mètode */    
    $result = $myVisit->render ( );
    
    /** mostra el resultat per pantalla */   
    echo $result;
?>    
      
        
            