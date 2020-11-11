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
 * Filename dashboardcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe dashboardcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package dashboardcontroller
 * @subpackage dashboard
 * @version 1.0.0
 */
final class dashboardcontroller extends controller {
    
    /**  @var string $action Conté l'acció a realitzar */
    private $action;
     
    /** 
      * Inicialitza l'objecte.
      * @access public
      */    
    public function __construct ( ) {
         
        if ( filter_has_var( INPUT_GET, 'action' ) ) {  /** si hi ha establerta una acció */

            /** recupera la acció */
            $this->action = filter_input( INPUT_GET, 'action' );

            /** executa l'acció recuperada */
            $this->doAction ( );

        }
 
        /** realiza la sortida */
        $this->output ( );

    }
    
    /** 
      * Encamina l'acció. 
      * @access private
      */
    private function doAction ( ) {

        switch ( $this->action ) {

            case "ViewList":

                $this->viewList ( );
                break;    

        }        

    } 
    
    /** 
     * Mostra la vista. 
     * @access public
     */     
    public function output ( ) {

        $this->showView ( );

    }
    
     
    /** 
      * Estableix la vista a mostrar.
      * @access private
      */ 
    private function viewList ( ) {

        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"].'dashboardview.php';        

    } 
    
}
?>