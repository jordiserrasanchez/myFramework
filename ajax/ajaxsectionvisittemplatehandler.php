<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxsectionvisittemplatecontroller.php' );    
    
    /** crea el objecte  */
    $mySectionVisitTemplate = new ajaxsectionvisittemplatecontroller ( );
    
    /** crida al mètode */    
    $result = $mySectionVisitTemplate->render ( );
    
    /** mostra el resultat per pantalla */   
    echo $result;
?>    
      
        
            