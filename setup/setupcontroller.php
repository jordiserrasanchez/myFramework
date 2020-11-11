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
 * Filename setupcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe setupcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package setupcontroller
 * @subpackage security
 * @version 1.0.0
 */
final class setupcontroller  {

    /**  @var string $model Conté el model */
    private $model;

    /**  @var string $step Conté el pas a realitzar */
    private $step;
    
    private $host;  
    private $username;  
    private $password;  
    private $dbname;  
    private $tablesprefix;
    
    /**  @var string $view Conté la vista */
    public $view;    
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */     
    public function __construct() {
        

        if ( filter_has_var( INPUT_GET, 'step' ) ) { /** si hi ha establert un pas */

            /** estableix els valors inicials */
            $this->setInitValues ( );
            
            /** recupera el pas */
            $this->step = filter_input( INPUT_GET, 'step' );

             /** procesa el pas recuperat */
            $this->doStep ( );
        
        } else { 

            $this->step= '0';
            $this->view = 'setupview.php';                 
        }

        
        
        /** realiza la sortida */
        $this->output ( );
    }


    /** 
      * Inicialitza els valors necessaris. 
      * @access private
      */
    private function setInitValues ( ) {
        
        /** crea l'objecte setup */
        $this->model = new setup ( );
        

    }
    
    /** 
      * Realiza el pas. 
      * @access private
      */
    private function doStep ( ) {
        
        switch ( $this->step ) {

            case "1":
                
                /** crida al mètode que exectua el pas */
                $this->desarParametresBBDD ( );
                break;

        }
    
    }
    
    private function desarParametresBBDD ( ) {
        
        if ( ( filter_has_var ( INPUT_POST , 'host' ) ) && ( filter_has_var ( INPUT_POST , 'username' ) ) && ( filter_has_var ( INPUT_POST , 'password' ) ) && ( filter_has_var ( INPUT_POST , 'dbname' ) ) && ( filter_has_var ( INPUT_POST , 'tablesprefix' ) ) ) {

            $this->host = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'host' ) );  
            $this->username = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'username' ) );  
            $this->password = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'password' ) );  
            $this->dbname = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'dbname' ) );  
            $this->tablesprefix = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'tablesprefix' ) );  

            $fields = array ();
            $fields[0]['parametre'] = '_DB_HOST_';
            $fields[0]['valor'] = $this->host;
            
            $fields[1]['parametre'] = '_DB_USER_';
            $fields[1]['valor'] = $this->username;

            $fields[2]['parametre'] = '_DB_PASSWORD_';
            $fields[2]['valor'] = $this->password;

            $fields[3]['parametre'] = '_DB_NAME_';
            $fields[3]['valor'] = $this->dbname;

            $fields[4]['parametre'] = '_DB_PREFIX_';
            $fields[4]['valor'] = $this->tablesprefix;

            $ret = $this->model->desaConfiguracioBBDD ( $fields );
        }
        
        
        
    }
    
    /** 
      * Mostra la vista. 
      * @access public
      */            
    public function output ( ) {

        /** mostra la vista que hi ha establerta*/ 
        $this->showView ( );
    
    }
    
    
    /** 
      * Mostra la vista establerta.
      * @access public
      */        
    public function showView ( ) {
        require_once $this->view;
    }
}