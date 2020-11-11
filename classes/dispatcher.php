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
 * Filename dispatcher.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe dispatcher.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category clases
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package dispatcher
 * @subpackage dispatcher
 * @version 1.0.0
 */

class dispatcher {
    /**  @static $instance Conté la instacia de l'objecte */
    public static $instance = null;
    
    /**  @var string $controllerName Conté el nom del controlador */
    public $controllerName;
    
    /**  @var object $controller Conté l'objecte del controlador */
    public $controller;
    
    
    /** 
      * Recupera la instacia. 
      * @access public
      */
    public static function getInstance ( ) {
        if ( !self::$instance ) {
            self::$instance = new dispatcher ( );
        }
        return self::$instance;        
    }
    
    /** 
      * Inicialitza l'objecte
      * @access public
      */
    public function __construct ( ) {
       $_SESSION["controllerPath"] = _APP_DIR_ . "controllers/";
       $_SESSION["viewPath"] = _APP_DIR_ . "views/";
       $_SESSION["assetsPath"] = _APP_DIR_ . "assets/";
    }
    
     /** 
      * Fa l'enviament cap al controlador
      * @access public
      */
   public function dispatch ( ) {
        //si hubiese un controlador diferente para la parte de adminsitracion aqui se podria seleccionar
        require_once $_SESSION["controllerPath"] . 'frontcontroller.php';
        $controller = new frontcontroller;
    }
}
