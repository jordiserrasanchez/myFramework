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
    if ( !function_exists ( 'classAutoLoader' ) ){ /** si la funcion nok existeix */

        /** 
          * Inclou el fitxer de la clase
          * @param string $class nom de la clase a carregar
          * @access public
          */        
        function classAutoLoader ( $class ) {
            
            $class = strtolower ( $class );
            
            $classFile = _APP_DIR_ . 'classes/' . $class . '.php';
            
            if ( is_file ( $classFile ) && !class_exists ( $class ) ) { /** si es un arxiu i la clase no existeix */
                
                /** inclou el fitxer */
                include $classFile;
                
            }
        }
    }
    
    /* crida al mètode que registra la funció d'autocarrgega */
    spl_autoload_register('classAutoLoader');
