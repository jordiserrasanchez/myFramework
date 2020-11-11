<?php
    /** envia les capçaleres del tipus de contingut al navegador */
    header ( 'Content-Type: application/json' );
    
    /** requereix el fitxer amb la clase */
    require_once ( '../controllers/ajaxforgotpasswordcontroller.php' );
    
    /** crea el objecte */
    $myObject = new ajaxforgotpasswordcontroller ( );
    
    /** crida al mètode */
    $result = $myObject->sendmail ( );
    
    /** mostra el resultat per pantalla */
    echo $result;
?>