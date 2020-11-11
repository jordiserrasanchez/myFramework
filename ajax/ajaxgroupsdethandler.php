<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxgroupsdetcontroller.php' );    
    
    /** crea el objecte  */
    $myGroupdet = new ajaxgroupsdetcontroller ( );
    
    /** crida al mètode */    
    $result = $myGroupdet->render ( );
    
    /** mostra el resultat per pantalla */   
    echo $result;
?>    
      
        
            