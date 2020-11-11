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
 * Filename addonscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe addonscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package addonscontroller
 * @subpackage moduls
 * @version 1.0.0
 */
final class addonscontroller extends controller {

    /**  @var string $model Conté el model */
    private $model;

    /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $concepte Conté l'objecte mòdul */    
    public $modul;
    
    /**  @var string $nomModul Nom del mòdul */    
    private $nomModul;
    
    /**  @var string $controlador Nom del controlador del mòdul */    
    private $controlador;
    
    /**  @var string $icona Icona del mòdul */    
    private $icona;
    
    /**  @var string $sistema Mòdul de sistema */    
    private $sistema;
    
    /**  @var string $actiu Mòdul actiu */    
    private $actiu;    
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */    
    public function __construct ( ) {
        
        /** estableix els valors inicials */
        $this->setInitValues ( );
        
        if ( filter_has_var( INPUT_GET , 'action' ) ) {  /** si hi ha establerta una acció */
            
            /** recupera la acció */
            $this->action = filter_input( INPUT_GET , 'action' );
            
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
            case "Edit":
                    $this->editAddon ( );
                break;
            case "New":
                    $this->newAddon ( );
                break;
            case "Save":
                    $this->saveAddon ( );
                break;
            case "Delete":
                    $this->deleteAddon ( );
                break;
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
      * Inicialitza els valors necessaris. 
      * @access private
      */
    private function setInitValues ( ) {
        
        /** crea l'objecte mòdul */
        $this->model = new modul ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de mòduls i la vista a mostrar.
      * @access private
      */
    private function viewList ( ) {
        
        /** crida al mètode que recupera la llista de mòduls */
        $this->modul = $this->model->getLlistaModuls ( );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'addonsview.php';     
        
         /** carrega el menú */
        $_SESSION["menu"] = menu::getMenu();       
        
    }
    
    /** 
      * Prepara la vista de la fitxa del mòdul.
      * @access private
      */    
    private function viewAddon ( ) {

        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'addonview.php';        
        
    }
    
    /** 
      * Estableix la vista per editar un mòdul
      * @access private
      */
    private function editAddon ( ) {

        if ( filter_has_var ( INPUT_POST , 'idModificar' ) ) {  /** si s'ha sel·leccionat mòdul */
            
            /** crida a la preparació la vista de la fitxa del mòdul */
            $this->viewAddon ( );
            
            /** crida al mètode que recupera el mòdul indicat */
            $this->modul = $this->model->getAddonById ( filter_input ( INPUT_POST , 'idModificar' ) );
            
        }
    }
    
    /** 
      * Estableix la vista per crear un mòdul.
      * @access private
      */
    private function newAddon ( ) {
        
        /** crida a la preparació la vista de la fitxa del mòdul */
        $this->viewAddon ( );

    }
    
    /** 
      * Desa les dades del mòdul.
      * @access private
      */
    private function saveAddon ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );

        if ( ( filter_has_var ( INPUT_POST , 'idModul' ) ) && ( ( filter_input ( INPUT_POST , 'idModul' ) ) != "" ) ) { /** si s'ha sel·leccionat mòdul executa el mètode Update */
            
            
            $this->updateAddon ( filter_input ( INPUT_POST , 'idModul' ) );
        
            
        } else { /** si no hi ha mòdul sel·leccionat executa el mètode Insert */
            
            $this->insertAddon ( );
        
        }        
    }
    
    /** Estableix el valors d'un mòdul enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {

        $this->nomModul = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'modul' ) );
        $this->controlador = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'controlador' ) );
        $this->icona = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'icona' ) );
        $this->sistema = ( $this->model->link->real_escape_string( filter_has_var ( INPUT_POST, 'sistema' ) ) ) ? 1 : 0;
        $this->actiu = ( $this->model->link->real_escape_string( filter_has_var ( INPUT_POST, 'actiu' ) ) ) ? 1 : 0;             

    }
    
    /** 
      * Inserta un mòdul a la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function insertAddon ( ) {
    
        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->nomModul . "','" . $this->controlador . "','" . $this->icona . "'," . $this->sistema . "," . $this->actiu;

        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir un concepte nou */
            $this->modul = $this->model->afegeixModul( $fields );
            
        }                        
        
        /** crida al mètode que mostra la llista de mòduls */
        $this->viewList ( );
    
    }
    
    /** 
      * Actualitza un mòdul a la bbdd i estableix la vista a mostrar.
      * @access private
      * @param integer $idModul Valor del camp per la clàusula WHERE de SQL.
    */
    private function updateAddon ( $idModul ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "modul='" . $this->nomModul . "', controlador='" . $this->controlador . "', icona='" . $this->icona . "', sistema=" . $this->sistema . ", actiu=" . $this->actiu;

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode per actualitzar un mòdul */
            $this->modul = $this->model->modificaModul ( $idModul , $fields );
        
        }

        /** crida al mètode que mostra la llista de mòduls */
        $this->viewList ( );
        
    }
    
    /** 
      * Esborra un mòdul de la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function deleteAddon ( ) {
        
        if ( ( filter_has_var ( INPUT_POST , 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST , 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat mòdul crida al mètode per esborrar-lo */
            
            /** executa el mètode per esborrar un mòdul */
            $this->modul = $this->model->esborraModul ( filter_input ( INPUT_POST , 'idEliminar' ) );
            
        }
        
        /** crida al mètode que mostra la llista de mòduls */
        $this->viewList ( );
        
    }
}