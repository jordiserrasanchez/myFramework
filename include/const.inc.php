<?php
/* 
 * 2019, Jordi Serra Sanchez.
 * 
 * NOTICE OF LICENSE
 * 
 * DISCLAIMER
 * 
 * Jordi Serra Sanhcez <jordi@serraperez.cat>
 * Copyright (c),  2019 Jordi Serra Sanchez
 * License url  http://www.serraperez/licenses/
 */

    /**
     * Constant per determinar si està activat el mode depuració
     */
    define( '_MYFW_DEGUB_' , true );

    if ( _MYFW_DEGUB_ ) { /** si esta activat el mode depuració */
        
        error_reporting ( E_ALL );
        ini_set ( "display_errors" , 1 );
    }
    
    define( '_MYFW_LOG_' , true );

    /**
     * Constant per determinar personalitzacions
     */
    define( '_MYFW_ORG_' , 'llar' );
    
    
    /** requereix les constants per els fitxers */
    require_once( 'files.inc.php' );

    /** requereix les constants per la BBDD */
    require_once( 'db.inc.php' );

    /** requereix les constants per les taules i paginació */
    require_once( 'tables.inc.php' );

    /** requereix les constants per el correu electrònic */
    require_once( 'mail.inc.php' );

    /** requereix les constants per la lopd */
    require_once( 'lopd.inc.php' );
    