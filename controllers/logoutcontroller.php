<?php
    /** destrueix la sessió */
    session_destroy();
    
    /** envia les capceleres al navegador per redirigir la pàgina al index.php */
    header('Location: index.php');
?>