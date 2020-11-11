<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxtravelscontroller.php' );    
    
    /** crea el objecte  */
    $myTravel = new ajaxtravelscontroller ( );
    
    /** crida al mètode */    
    $result = $myTravel->render ( );
    
    /** mostra el resultat per pantalla */   
    echo $result;
?>    
      
        
            