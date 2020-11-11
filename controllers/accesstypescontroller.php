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
 * Filename accesstypescontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe accesstypescontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package accesstypescontroller
 * @subpackage tipusacces
 * @version 1.0.0
 */
final class accesstypescontroller extends controller {

    /**  @var string $model Conté el model */
    private $model;

    /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $concepte Conté l'objecte tipusacces */    
    public $tipusacces;
    
    /**  @var string $codi Codi del tipus d'acció */    
    private $codi;
    
    /** @var string $descripcio Descripció del tipsu d'accés */
    private $descripcio;
    
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
                    $this->editAccessType ( );
                break;
            case "New":
                    $this->newAccessType ( );
                break;
            case "Save":
                    $this->saveAccessType ( );
                break;
            case "Delete":
                    $this->deleteAccessType ( );
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
        
        /** crea l'objecte tipusaccess */
        $this->model = new tipusacces ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de tipus d'accés i la vista a mostrar.
      * @access private
      */
    private function viewList ( ) {
        
        /** crida al mètode que recupera la llista de tipus d'accés */
        $this->tipusacces = $this->model->getLlistaTipusAcces ( );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'accesstypesview.php';        
    }
    
    /** 
      * Prepara la vista de la fitxa del tipus d'accés.
      * @access private
      */    
    private function viewAccessType ( ) {

        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'accesstypeview.php';        
        
    }
    
    /** 
      * Estableix la vista per editar un tipus d'accés
      * @access private
      */
    private function editAccessType ( ) {

        if ( filter_has_var ( INPUT_POST , 'idModificar' ) ) {  /** si s'ha sel·leccionat un tipus d'accés */
            
            /** crida a la preparació la vista de la fitxa del tipus d'accés */
            $this->viewAccessType ( );
            
            /** crida al mètode que recupera el tipus d'accés indicat */
            $this->tipusacces = $this->model->getAccesTypeById ( filter_input ( INPUT_POST , 'idModificar' ) );
            
        }
    }
    
    /** 
      * Estableix la vista per crear un tipus d'accés.
      * @access private
      */
    private function newAccessType ( ) {
        
        /** crida a la preparació la vista de la fitxa del tipus d'accés */
        $this->viewAccessType ( );

    }
    
    /** 
      * Desa les dades de l'objecte.
      * @access private
      */
    private function saveAccessType ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );

        if ( ( filter_has_var ( INPUT_POST , 'idTipusAcces' ) ) && ( ( filter_input ( INPUT_POST , 'idTipusAcces' ) ) != "" ) ) { /** si s'ha sel·leccionat un tipus d'acció executa el mètode Update */
            
            
            $this->updateAccessType ( filter_input ( INPUT_POST , 'idTipusAcces' ) );
        
            
        } else { /** si no hi ha objecte sel·leccionat executa el mètode Insert */
            
            $this->insertAccessType ( );
        
        }        
    }
    
    /** Estableix el valors d'un tipus d'acció enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {

        $this->codi = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'codi' ) );
        $this->descripcio = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'descripcio' ) );

    }
    
    /** 
      * Inserta un tipus d'accés a la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function insertAccessType ( ) {
    
        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->codi . "','" . $this->descripcio . "'";

        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir un tipus d'accés nou */
            $this->tipusacces = $this->model->afegeixTipusAcces ( $fields );
            
        }                        
        
        /** crida al mètode que mostra la llista de tipus d'accés */
        $this->viewList ( );
    
    }
    
    /** 
      * Actualitza un tipus d'accés a la bbdd i estableix la vista a mostrar.
      * @access private
      * @param integer $idTipusAcces Valor del camp per la clàusula WHERE de SQL.
    */
    private function updateAccessType ( $idTipusAcces ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "codi='" . $this->codi . "', descripcio='" . $this->descripcio . "'";

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode per actualitzar un tipus d'accés */
            $this->tipusacces = $this->model->modificaTipusAcces ( $idTipusAcces , $fields );
        
        }

        /** crida al mètode que mostra la llista de tipus d'accés */
        $this->viewList ( );
        
    }
    
    /** 
      * Esborra un tipus d'accés de la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function deleteAccessType ( ) {
        
        if ( ( filter_has_var ( INPUT_POST , 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST , 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat un tipus d'accés crida al mètode per esborrar-lo */
            
            /** executa el mètode per esborrar un tipus d'accés */
            $this->tipusacces = $this->model->esborraTipusAcces( filter_input ( INPUT_POST , 'idEliminar' ) );
            
        }
        
        /** crida al mètode que mostra la llista de tipus d'accés */
        $this->viewList ( );
        
    }
}