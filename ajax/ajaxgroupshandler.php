<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxgroupscontroller.php' );    
    
    /** crea el objecte  */
    $myGroup = new ajaxgroupscontroller ( );
    
    /** crida al mètode */    
    $result = $myGroup->render ( );
    
    /** mostra el resultat per pantalla */   
    echo $result;
?>    
      
        
            