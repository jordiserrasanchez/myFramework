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
 * Filename accessresultscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe accessresultscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package accessresultscontroller
 * @subpackage objectes
 * @version 1.0.0
 */
final class accessresultscontroller extends controller {

    /**  @var string $model Conté el model */
    private $model;

    /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $resultacces Conté l'objecte resultatacces */    
    public $resultatacces;
    
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
                    $this->editAccessResult ( );
                break;
            case "New":
                    $this->newAccessResult ( );
                break;
            case "Save":
                    $this->saveAccessResult ( );
                break;
            case "Delete":
                    $this->deleteAccessResult ( );
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
        
        /** crea l'objecte resultatacces */
        $this->model = new resultatacces ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de resultats d'accés i la vista a mostrar.
      * @access private
      */
    private function viewList ( ) {
        
        /** crida al mètode que recupera la llista de resultats d'accés */
        $this->resultatacces = $this->model->getLlistaResultatAcces ( );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'accessresultsview.php';        
    }
    
    /** 
      * Prepara la vista de la fitxa del resultat d'acces.
      * @access private
      */    
    private function viewAccessResult ( ) {

        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'accessresultview.php';        
        
    }
    
    /** 
      * Estableix la vista per editar un resultat d'accés
      * @access private
      */
    private function editAccessResult ( ) {

        if ( filter_has_var ( INPUT_POST , 'idModificar' ) ) {  /** si s'ha sel·leccionat resultat d'accés */
            
            /** crida a la preparació la vista de la fitxa del resultat d'accés */
            $this->viewAccessResult ( );
            
            /** crida al mètode que recupera el resultat d'accés indicat */
            $this->resultatacces = $this->model->getAccessResultById ( filter_input ( INPUT_POST , 'idModificar' ) );
            
        }
    }
    
    /** 
      * Estableix la vista per crear un resultat d'accés.
      * @access private
      */
    private function newAccessResult ( ) {
        
        /** crida a la preparació la vista de la fitxa del resultat d'accés */
        $this->viewAccessResult ( );

    }
    
    /** 
      * Desa les dades del resultat d'accés.
      * @access private
      */
    private function saveAccessResult ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );

        if ( ( filter_has_var ( INPUT_POST , 'idResultatAcces' ) ) && ( ( filter_input ( INPUT_POST , 'idResultatAcces' ) ) != "" ) ) { /** si s'ha sel·leccionat un resultat d'accés executa el mètode Update */
            
            
            $this->updateAccessResult ( filter_input ( INPUT_POST , 'idResultatAcces' ) );
        
            
        } else { /** si no hi ha resultat d'accés sel·leccionat executa el mètode Insert */
            
            $this->insertAccessResult ( );
        
        }        
    }
    
    /** Estableix el valors d'un objecte enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {

        $this->codi = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'codi' ) );
        $this->descripcio = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'descripcio' ) );

    }
    
    /** 
      * Inserta un resultat d'accés a la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function insertAccessResult ( ) {
    
        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->codi . "','" . $this->descripcio . "'";

        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir un resultat d'accés nou */
            $this->resultatacces = $this->model->afegeixResultatAcces( $fields );
            
        }                        
        
        /** crida al mètode que mostra la llista de resultats d'accés */
        $this->viewList ( );
    
    }
    
    /** 
      * Actualitza un resultat d'accés a la bbdd i estableix la vista a mostrar.
      * @access private
      * @param integer $idResultatAcces Valor del camp per la clàusula WHERE de SQL.
    */
    private function updateAccessResult ( $idResultatAcces ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "codi='" . $this->codi . "', descripcio='" . $this->descripcio . "'";

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode per actualitzar un resultat d'accés */
            $this->resultatacces = $this->model->modificaResultatAcces ( $idResultatAcces , $fields );
        
        }

        /** crida al mètode que mostra la llista de resultats d'accés */
        $this->viewList ( );
        
    }
    
    /** 
      * Esborra un resultat d'accés de la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function deleteAccessResult ( ) {
        
        if ( ( filter_has_var ( INPUT_POST , 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST , 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat resultat d'accés crida al mètode per esborrar-lo */
            
            /** executa el mètode per esborrar un resultat d'accés */
            $this->resultatacces = $this->model->esborraResultatAcces ( filter_input ( INPUT_POST , 'idEliminar' ) );
            
        }
        
        /** crida al mètode que mostra la llista de resultats d'accés */
        $this->viewList ( );
        
    }
}