<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxvisittemplatescontroller.php' );    
    
    /** crea el objecte  */
    $myVisitTemplate = new ajaxvisittemplatescontroller ( );
    
    /** crida al mètode */    
    $result = $myVisitTemplate->render ( );
    
    /** mostra el resultat per pantalla */   
    echo $result;
?>    
      
        
            