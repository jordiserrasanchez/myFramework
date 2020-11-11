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
 * Filename policiescontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe policiescontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package policiescontroller
 * @subpackage security
 * @version 1.0.0
 */
class policiescontroller extends controller {

    /**  @var string $model Conté el model */
    private $model;

     /**  @var string $nom Conté l'acció a realitzar */
    private $action;

    /**  @var string $nom Conté l'objecte politica */
    public $politica;
    
    /**  @var string $nomPolitica Conté el el nom de la política */
    private $nomPolitica;
    
    /**  @var integer $umbralIntents Conté el número màxim d'equivocacions continuades permeses */
    private $umbralIntents;
    
    /**  @var integer $umbralCaducitat Conté els dias que calen perqueè la paraula de pas caduqui */
    private $umbralCaducitat;
    
    /**  @var integer $umbralHistoria Conté el número de paruales de pas que no es ponde repetir */
    private $umbralHistoria;
    
    /**  @var integer $requereixComplexitat Indica si la paraula de pas requereix complexitat */
    private $requereixComplexitat;
    
    /**  @var integer $longitutMinima Conté la longitut mínima que ha de tenir la paraula de pas */
    private $longitutMinima;

    /** 
      * Inicialitza l'objecte.
      * @access public
      */    
    public function __construct ( ) {

        /** estableix els valors inicials */
        $this->setInitValues ( );        
        
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
            case "Edit":
                    $this->editPolicy ( );
                break;
            case "New":
                    $this->newPolicy ( );
                break;
            case "Save":
                    $this->savePolicy ( );
                break;
            case "Delete":
                    $this->deletePolicy ( );
                break;
        }        
    }        

    /** 
      * Mostra la vista. 
      * @access public
      */   
    public function output ( ) {
        $this->showView();
    }
    
    
    /** 
      * Inicialitza els valors necessaris. 
      * @access private
      */
    private function setInitValues ( ) {
        
        /** crea l'objecte politica */
        $this->model = new politica ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de politiques i la vista a mostrar.
      * @access private
      */
    private function viewList ( ) {
        
        /** crida al mètode que recupera la llista de politiques */
        $this->politica = $this->model->getLlistaPolitiques ( );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"].'policiesview.php';        
    }

    
    /** 
      * Prepara la vista de la fitxa de la política.
      * @access private
      */    
    private function viewPolicy ( ) {

        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"].'policyview.php';        
        
    }
    
    /** 
      * Estableix la vista per editar una política.
      * @access private
      */
    private function editPolicy ( ) {

        if ( filter_has_var ( INPUT_POST, 'idModificar' ) ) {  /** si s'ha sel·leccionat la política */
            
            /** crida a la preparació la vista de la fitxa del usuari */
            $this->viewPolicy ( );
            
            /** crida al mètode que recupera la política indicada */
            $this->politica = $this->model->getPoliticaById( filter_input ( INPUT_POST, 'idModificar' ) );
            
        }
    }    

    /** 
      * Estableix la vista per crear una política.
      * @access private
      */
    private function newPolicy ( ) {
        
        /** crida a la preparació la vista de la fitxa de la política */
        $this->viewPolicy ( );

    }
   
    /** 
      * Desa les dades de la política.
      * @access private
      */
    private function savePolicy ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );

        if ( ( filter_has_var ( INPUT_POST, 'idPolitica' ) ) && ( ( filter_input ( INPUT_POST, 'idPolitica' ) ) != "" ) ) { /** si s'ha sel·leccionat la política executa el mètode Update */
            
            
            $this->updatePolicy( filter_input ( INPUT_POST, 'idPolitica' ) );
        
            
        } else { /** si no hi ha política sel·leccionada executa el mètode Insert */
            
            $this->insertPolicy ( );
        
        }        
    }
    
    /** Estableix el valors d'una política enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {
        $this->nomPolitica = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'politica' ) );
        $this->umbralIntents = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'umbralIntents' ) );
        $this->umbralCaducitat = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'umbralCaducitat' ) );
        $this->umbralHistoria = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'umbralHistoria' ) );
        $this->requereixComplexitat = ( $this->model->link->real_escape_string( filter_has_var ( INPUT_POST, 'requereixComplexitat' ) ) )?1:0;
        $this->longitutMinima = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'longitutMinima' ) );
    }

    /** 
      * Inserta una política a la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function insertPolicy ( ) {
    
        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->nomPolitica . "'," . $this->umbralIntents . "," . $this->umbralCaducitat ."," . $this->umbralHistoria . "," . $this->requereixComplexitat . "," . $this->longitutMinima;

        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir una política nou */
            $this->politica = $this->model->afegeixPolitica( $fields );
            
        }                        
        
        /** crida al mètode que mostra la llista de politiques */
        $this->viewList ( );
        
    }
    
    /** 
      * Actualitza una política a la bbdd i estableix la vista a mostrar.
      * @access private
      * @param integer $idPolitica Valor del camp per la clàusula WHERE de SQL.
    */
    private function updatePolicy ( $idPolitica ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "politica='" . $this->nomPolitica . "',umbralIntents=" . $this->umbralIntents . ",umbralCaducitat=" . $this->umbralCaducitat . " ,umbralHistoria=" . $this->umbralHistoria . ",requereixComplexitat=" . $this->requereixComplexitat . ",longitutMinima=" . $this->longitutMinima;

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode per actualitzar una política */
            $this->politica = $this->model->modificaPolitica( $idPolitica, $fields );
        
        }

        /** crida al mètode que mostra la llista de politiques */
        $this->viewList ( );
        
    }

    /** 
      * Esborra una politica de la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function deletePolicy ( ) {
        
        if ( ( filter_has_var ( INPUT_POST, 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST, 'idEliminar' ) ) !="" ) ) { /** si s'ha sel·leccionat politica crida al mètode per esborrar-la */
            
            /** executa el mètode per esborrar una política */
            $this->politica = $this->model->esborraPolitica( filter_input ( INPUT_POST, 'idEliminar' ) );
            
        }
        
        /** crida al mètode que mostra la llista de politiques */
        $this->viewList ( );
        
    }
    
}
?>