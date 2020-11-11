<?php
/**
 * 2020, Jordi Serra Sanchez.
 * 
 * NOTICE OF LICENSE
 * 
 * DISCLAIMER
 * 
 * Jordi Serra Sanhcez <jordi@serraperez.cat>
 * Copyright (c),  2020 Jordi Serra Sanchez
 * License url  http://www.serraperez/licenses/
 */
/**
 * Create at 30-ene-2020 12:54:55
 * Project name myFramework
 * Project DisplayName myFramework
 * Filename frontcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe frontcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package frontcontroller
 * @subpackage frontcontroller
 * @version 1.0.0
 */
final class frontcontroller extends controller{
    
    /**  @var string $controllerName Conté el nom del controlador */
    public $controllerName;
    /**  @var string $controller Conté el contrtolador */
    public $controller;
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */   
    public function __construct ( ) {
        
        if ( !isset( $_SESSION["usuari"] ) ) { /** si no hi ha usuari validat */
            
            $this->controllerName = "logincontroller";

            /** si la petició va cap aquest destí la deixa pasar */
            if ( ( ( filter_has_var( INPUT_GET, 'controlador' ) ) && ( strtolower ( filter_input( INPUT_GET, 'controlador' ) ) == 'visit' ) ) && ( ( ( filter_has_var( INPUT_GET, 'action' ) ) && ( strtolower ( filter_input( INPUT_GET, 'action' ) ) == 'schedule' ) )  or ( ( filter_has_var( INPUT_GET, 'action' ) ) && ( strtolower ( filter_input( INPUT_GET, 'action' ) ) == 'save' ) ) ) ) {

                $this->controllerName = strtolower ( filter_input( INPUT_GET, 'controlador' ) ) . 'controller';
                $_SESSION["usuariAnonim"] = true;
                
            }

            
        } else { /** si hi ha usuari validat */

            if ( filter_has_var( INPUT_GET, 'controlador' ) ) { /** Muntem el nom del controlador o en el seu defecte prenem el logincontroller */

                 $this->controllerName = strtolower ( filter_input( INPUT_GET, 'controlador' ) ) . 'controller';

            } else  {

                $this->controllerName = "logincontroller";

            }

        }        

        /** requereix el fitxer del controlador */
        require_once $_SESSION["controllerPath"] . $this->controllerName . '.php';        

        /** crea un nou objecte amb el controlador */
        $this->controller = new $this->controllerName;

    }
    

    /** 
     * Mostra la vista. 
     * @access public
     */   
    public function output ( ) {

        $this->showView ( );

    }

}