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
     * Constant per la separació de directoris Directory Separator
     */
    define( '_DS_' ,  '/' );
		
    /**
    *  Constant del directorio de la app
    */		
    define( '_APP_DIR_' , filter_input( INPUT_SERVER, 'DOCUMENT_ROOT' ) . '/myFramework/' );
