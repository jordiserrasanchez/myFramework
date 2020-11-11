<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxconceptscontroller.php' );    
    
    /** crea el objecte */
    $myConcept = new ajaxconceptscontroller ( );
    
    /** crida al mètode */
    $result = $myConcept->render ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>