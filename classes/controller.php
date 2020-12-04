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

    /** @var string $objecteModalWindow Conté l'objecte de la finestra modal */
    public $objecteModalWindow;
    
    /** @var boolean $showModal Indica si s'ha de mostrar la finestra modal */
    public $showModal;     
    
    /** 
      * Mostra la vista establerta.
      * @access public
      */        
    public function showView ( ) {
        require_once $this->view;
    }
    
    public function errorLOPD  ( ) {
        
                /** Recupera el número d'error */
            $errTitle = 'Error (0x0000002)';
            
            /** Recupera el missatge d'error */
            $errMessage = 'S\'ha produït un intent d\'accés il·legal a aquest contigut..';

            /** Crida a la función que la finestra modal amb l'error */
            $this->setError ( $errTitle, $errMessage );

            /** estableix la vista que s'ha de mostrar */
            $this->view = $_SESSION["viewPath"] . 'dashboardllarview.php';           
        
        //$this->view = $_SESSION["viewPath"] . 'nopermisview.php';        
    }
    
     /** 
      * Genera la finestra modal amb l'error.
      * @access private
      */    
    public function setError ( $errTitle, $errMessage ) {
        
        /** estableix la condició per mostrar la pantalla modal */
        $this->showModal = true;

        /** crea el objecte per mostrar la finestra modal */
        $this->objecteModalWindow = new modalwindow (  $errTitle, $errMessage );
        
    }   

}
?>