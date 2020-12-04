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
 * Filename departmentscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe departmentscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package departmentscontroller
 * @subpackage departaments
 * @version 1.0.0
 */
final class departmentscontroller extends controller {

    /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $model Conté el model */
    private $modelDepartament;
    
    /**  @var string $llistaDepartaments Conté la llista de departaments */    
    public $llistaDepartaments;    

    /**  @var string $concepte Conté l'objecte departament */    
    public $departament;
    
    /** @var string $descripcioDepartament Descripció del departament */
    private $descripcioDepartament;

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
                    $this->editDepartment ( );
                break;
            case "New":
                    $this->newDepartment ( );
                break;
            case "Save":
                    $this->saveDepartment ( );
                break;
            case "Delete":
                    $this->deleteDepartment ( );
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
        
        /** crea l'objecte del model del departement */
        $this->modelDepartament = new departament ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de departaments i la vista a mostrar.
      * @access private
      */
    private function viewList ( ) {
        
        /** crida al mètode que recupera la llista de departaments */
        $this->llistaDepartaments = $this->modelDepartament->getLlistaDepartaments ( );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'departmentsview.php';        
    }
    
    /** 
      * Prepara la vista de la fitxa del departament.
      * @access private
      */    
    private function viewDepartment ( ) {

        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'departmentview.php';        
        
    }
    
    /** 
      * Estableix la vista per editar un departament
      * @access private
      */
    private function editDepartment ( ) {

        if ( filter_has_var ( INPUT_POST , 'idModificar' ) ) {  /** si s'ha sel·leccionat un departament */
            
            /** crida a la preparació la vista de la fitxa del departmanebt */
            $this->viewDepartment ( );
            
            /** crida al mètode que recupera el departament indicat */
            $this->departament = $this->modelDepartament->getDepartmentById ( filter_input ( INPUT_POST , 'idModificar' ) );
            
        }
    }
    
    /** 
      * Estableix la vista per crear un departament.
      * @access private
      */
    private function newDepartment ( ) {
        
        /** crida a la preparació la vista de la fitxa del departament */
        $this->viewDepartment ( );

    }
    
    /** 
      * Desa les dades de l'objecte.
      * @access private
      */
    private function saveDepartment ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );

        if ( ( filter_has_var ( INPUT_POST , 'idDepartament' ) ) && ( ( filter_input ( INPUT_POST , 'idDepartament' ) ) != "" ) ) { /** si s'ha sel·leccionat un departament executa el mètode Update */
            
            
            $this->updateDepartment ( filter_input ( INPUT_POST , 'idDepartament' ) );
        
            
        } else { /** si no hi ha objecte sel·leccionat executa el mètode Insert */
            
            $this->insertDepartment ( );
        
        }        
    }
    
    /** Estableix el valors d'un tipus d'acció enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {

        $this->descripcioDepartament = $this->modelDepartament->link->real_escape_string( filter_input ( INPUT_POST , 'descripcioDepartament' ) );

    }
    
    /** 
      * Inserta un departament a la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function insertDepartment ( ) {
    
        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->descripcioDepartament . "'";
    
        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir un departament nou */
            $ret = $this->modelDepartament->afegeixDepartament ( $fields );
            
        }           

        if ( !$ret ) { /** si s'ha produït un error */

           /** Recupera el número d'error */
           $errTitle = 'Error (' . $this->modelDepartament->link->errno . ')';

           /** Recupera el missatge d'error */
           $errMessage = $this->modelDepartament->link->error;

           /** Crida a la función que la finestra modal amb l'error */
           $this->setError ( $errTitle, $errMessage );

       }  else {         
        
            /** crida al mètode que mostra la llista de departaments */
            $this->viewList ( );
            
       }
    
    }
    
    /** 
      * Actualitza un departament a la bbdd i estableix la vista a mostrar.
      * @access private
      * @param integer $idDepartament Valor del camp per la clàusula WHERE de SQL.
    */
    private function updateDepartment ( $idDepartament ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "descripcioDepartament='" . $this->descripcioDepartament . "'";

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode per actualitzar un departament */
            $ret = $this->modelDepartament->modificaDepartament ( $idDepartament , $fields );
        
        }
        
        if ( !$ret ) { /** si s'ha produït un error */

           /** Recupera el número d'error */
           $errTitle = 'Error (' . $this->modelDepartament->link->errno . ')';

           /** Recupera el missatge d'error */
           $errMessage = $this->modelDepartament->link->error;

           /** Crida a la función que la finestra modal amb l'error */
           $this->setError ( $errTitle, $errMessage );

       }  else {         
        
            /** crida al mètode que mostra la llista de departaments */
            $this->viewList ( );
            
       }
        
    }
    
    /** 
      * Esborra un departament de la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function deleteDepartment ( ) {
        
        if ( ( filter_has_var ( INPUT_POST , 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST , 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat un departament crida al mètode per esborrar-lo */
            
            /** executa el mètode per esborrar un departament */
            $ret = $this->modelDepartament->esborraDepartament( filter_input ( INPUT_POST , 'idEliminar' ) );
            
        }
        
        if ( !$ret ) { /** si s'ha produït un error */

           /** Recupera el número d'error */
           $errTitle = 'Error (' . $this->modelDepartament->link->errno . ')';

           /** Recupera el missatge d'error */
           $errMessage = $this->modelDepartament->link->error;

           /** Crida a la función que la finestra modal amb l'error */
           $this->setError ( $errTitle, $errMessage );

       }  else {         
        
            /** crida al mètode que mostra la llista de departaments */
            $this->viewList ( );
            
       }
        
    }
    
}