<?php
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxdepartmentscontroller.php' );    
    
    /** crea el objecte */
    $myDepartment = new ajaxdepartmentscontroller ( );
    
    /** crida al mètode */
    $result = $myDepartment->render ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>