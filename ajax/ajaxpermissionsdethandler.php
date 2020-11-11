<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxpermissionsdetcontroller.php' );    
    
    /** crea el objecte  */
    $myPermissiondet = new ajaxpermissionsdetcontroller ( );
    
    /** crida al mètode */    
    $result = $myPermissiondet->render ( );
    
    /** mostra el resultat per pantalla */   
    echo $result;
?>    
      
        
            