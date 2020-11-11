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
 * Filename lopdcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe lopdcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package lopdcontroller
 * @subpackage lopd
 * @version 1.0.0
 */
final class lopdcontroller extends controller {

    /**  @var string $model Conté el model */
    private $model;

    /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $concepte Conté l'objecte lopd */    
    public $lopd;
    
    /**  @var string $nomComponent Nom del component */    
    private $nomComponent;
    
    /**  @var integer $idModul Identificador del mòdul associat */    
    private $idModul;
    
    /**  @var string $modul Conté el el nom del mòdul que afecta al component */
    public $modul;
    
    /**  @var array $llistaModuls Conté una matriu associativa amb la llista de mòduls existents a la bbdd */
    public $llistaModuls;    
    
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
                
                    $this->editComponent ( );
                break;
            
            case "New":
                
                    $this->newComponent ( );
                break;
            
            case "Save":
                
                    $this->saveComponent ( );
                break;
            
            case "Delete":
                    $this->deleteComponent ( );
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
        
        /** crea l'objecte lopd */
        $this->model = new lopd ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de components i la vista a mostrar.
      * @access private
      */
    private function viewList ( ) {
        
        /** crida al mètode que recupera la llista de components */

        $this->lopd = $this->model->getLlistaRegistres ( );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'lopdview.php';        
    }
    
    /** 
      * Prepara la vista de la fitxa del component.
      * @access private
      */    
    private function viewComponent ( ) {

        /** crea un nou objecte mòdul */
        $modul = new modul ( );
        
        $order = 'modul asc';
        
        /** crida al mètode que recupera la llista de mòduls */
        $this->llistaModuls = $modul->getLlistaModuls ( null , $order);
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'componentview.php';        
        
    }
    
    /** 
      * Estableix la vista per editar un component
      * @access private
      */
    private function editComponent ( ) {

        if ( filter_has_var ( INPUT_POST , 'idModificar' ) ) {  /** si s'ha sel·leccionat component */
            
            /** crida a la preparació la vista de la fitxa del component */
            $this->viewComponent ( );
            
            /** crida al mètode que recupera el component indicat */
            $this->component = $this->model->getComponentById ( filter_input ( INPUT_POST , 'idModificar' ) );
            
            /** crea un nou objecte mòdul */
            $modul = new modul ( );

            /** crida al mètode que recupera el mòdul indicat */
            $this->modul = $modul->getModulById ( $this->component['idModul'] );            
            
        }
    }
    
    /** 
      * Estableix la vista per crear un component.
      * @access private
      */
    private function newComponent ( ) {
        
        /** crida a la preparació la vista de la fitxa del component */
        $this->viewComponent ( );

    }
    
    /** 
      * Desa les dades del component.
      * @access private
      */
    private function saveComponent ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );

        if ( ( filter_has_var ( INPUT_POST , 'idComponent' ) ) && ( ( filter_input ( INPUT_POST , 'idComponent' ) ) != "" ) ) { /** si s'ha sel·leccionat component executa el mètode Update */
            
            
            $this->updateComponent ( filter_input ( INPUT_POST , 'idComponent' ) );
        
            
        } else { /** si no hi ha component sel·leccionat executa el mètode Insert */
            
            $this->insertComponent ( );
        
        }        
    }
    
    /** Estableix el valors d'un component enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {

        $this->nomComponent = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'component' ) );
        $this->idModul = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'idModul' ) );

    }
    
    /** 
      * Inserta un component a la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function insertComponent ( ) {
    
        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->nomComponent . "'";

        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir un concepte nou */
            $this->component = $this->model->afegeixComponent( $fields );
            
        }                        
        
        /** crida al mètode que mostra la llista de components */
        $this->viewList ( );
    
    }
    
    /** 
      * Actualitza un component a la bbdd i estableix la vista a mostrar.
      * @access private
      * @param integer $idComponent Valor del camp per la clàusula WHERE de SQL.
    */
    private function updateComponent ( $idComponent ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "component='" . $this->nomComponent . "', idModul=" . $this->idModul;

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode per actualitzar un component */
            $this->component = $this->model->modificaComponent ( $idComponent , $fields );
        
        }

        /** crida al mètode que mostra la llista de components */
        $this->viewList ( );
        
    }
    
    /** 
      * Esborra un component de la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function deleteComponent ( ) {
        
        if ( ( filter_has_var ( INPUT_POST , 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST , 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat concepte crida al mètode per esborrar-lo */
            
            /** executa el mètode per esborrar un component */
            $this->component = $this->model->esborraComponent ( filter_input ( INPUT_POST , 'idEliminar' ) );
            
        }
        
        /** crida al mètode que mostra la llista de components */
        $this->viewList ( );
        
    }
}