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
 * Filename controller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe controller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @abstract 
 * @license http://www.serraperez/licenses/
 * @package controller
 * @subpackage controller
 * @version 1.0.0
 */
abstract class controller {
    
    /**  @var string $view Conté la vista */
    public $view;
    
    /** @var string $menu Conté el menú */
    public $menu;

    /** 
      * Mostra la vista establerta.
      * @access public
      */        
    public function showView ( ) {
        require_once $this->view;
    }
    
    public function errorLOPD  ( ) {
        
        $this->view = $_SESSION["viewPath"] . 'nopermisview.php';        
    

    }

}
?>