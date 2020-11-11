<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxtravelsdetcontroller.php' );    
    
    /** crea el objecte  */
    $myTraveldet = new ajaxtravelsdetcontroller ( );
    
    /** crida al mètode */    
    $result = $myTraveldet->render ( );
    
    /** mostra el resultat per pantalla */   
    echo $result;
?>    
      
        
            