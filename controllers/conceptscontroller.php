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
 * Filename conceptscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe conceptscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package conceptscontroller
 * @subpackage conceptes
 * @version 1.0.0
 */
final class conceptscontroller extends controller {

    /** Contant que identifica el mòdul amb el que s'ha desat a la bbdd */
    public const  _ID_MODUL_  = 3;    

        /** Contant que amb el nom del mòdul amb el que s'ha desat a la bbdd */
    public const  _TXT_MODUL_  = 'CONCEPTES';    

    /**  @var string $model Conté el model */
    private $model;

    /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $concepte Conté l'objecte concepte */    
    public $concepte;
    
    /**  @var string $nomConcepte Nom del concepte */    
    private $nomConcepte;
    
    /**  @var float $importUnitari Import unitarti del concepte */    
    private $importUnitari;

    /**  @var integer $actiu Indica si el concepte està actiu */    
    private $actiu;
    
    /** @var bool $permisLectura Indica si te permis de lectura */
    private $permisLectura;

    /** @var bool $permisEscriptura Indica si te permis de lectura */
    private $permisEscriptura;    
    

        //$this->permisEscriptura = permis::getPermisEscriptura($_SESSION['idUsuari'] , self::_ID_MODUL_ , '');
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */    
    public function __construct ( ) {

        /** estableix els valors inicials */
        $this->setInitValues ( );
        
        if ( filter_has_var ( INPUT_GET , 'action' ) ) {  /** si hi ha establerta una acció */
            
            /** recupera la acció */
            $this->action = filter_input ( INPUT_GET , 'action' );
            
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
                
                if ( $this->permisLectura ) {
                    
                    $this->saveLOPDRecord ( 'ALLOW' , _SELECT_ , _SELECT_TEXT_ , date ( "Y-m-d H:i:s" ) , 'LLISTA DE CONCEPTES' ); 
                    $this->viewList ( );
                    
                } else {
                    
                    $this->saveLOPDRecord ( 'DENY' , _SELECT_ , _SELECT_TEXT_ , date ( "Y-m-d H:i:s" ) , 'LLISTA DE CONCEPTES' );                           
                    $this->errorLOPD  ( );
                    
                }
                                   
                break;
                
            case "Edit":
                    
                if ( $this->permisEscriptura ) {
                    
                    $this->editConcept ( );
                    
                } else {

                    $this->saveLOPDRecord ( 'DENY' , _UPDATE_ , _UPDATE_TEXT_ , date ( "Y-m-d H:i:s" ) , 'FITXA DEL CONCEPTE' );                           
                    $this->errorLOPD  ( );                    
                    
                }


                break;
            case "New":
                
                if ( $this->permisEscriptura ) {
                      
                    $this->newConcept ( );              
                      
                } else {
                      
                    $this->saveLOPDRecord ( 'DENY' , _INSERT_ , _INSERT_TEXT_ , date ( "Y-m-d H:i:s" ) , 'FITXA DEL CONCEPTE' );                           
                    $this->errorLOPD  ( );                                              
                      
                }

                break;
            case "Save":
                
                $this->saveConcept ( );            
                break;
            
            case "Delete":
                
                 if ( $this->permisEscriptura ) {
                      
                    $this->deleteConcept ( );               
                      
                } else {  
                    
                    $this->saveLOPDRecord ( 'DENY' , _DELETE_ , _DELETE_TEXT_ , date ( "Y-m-d H:i:s" ) , 'FITXA DEL CONCEPTE' );                           
                    $this->errorLOPD  ( );                        
                }             
                          
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
        
        /** crea l'objecte concepte */
        $this->model = new concepte ( );

        /** resupera els permisos que te l'usuari sobre l'obejte */
        $this->permisLectura = permis::getPermisLectura ( $_SESSION['idUsuari'] , self::_ID_MODUL_ );
        $this->permisEscriptura = permis::getPermisEscriptura ( $_SESSION['idUsuari'] , self::_ID_MODUL_ );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de conceptes i la vista a mostrar.
      * @access private
      */
    private function viewList ( ) {

            /** crida al mètode que recupera la llista de conceptes */
            $this->concepte = $this->model->getLlistaConceptes ( );

            /** estableix la vista que s'ha de mostrar */
            $this->view = $_SESSION["viewPath"] . 'conceptsview.php';        
                        
    }
    
    /** 
      * Prepara la vista de la fitxa del concepte.
      * @access private
      */    
    private function viewConcept ( ) {

        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'conceptview.php';        
        
    }
    
    /** 
      * Estableix la vista per editar un concepte
      * @access private
      */
    private function editConcept ( ) {

        if ( filter_has_var ( INPUT_POST , 'idModificar' ) ) {  /** si s'ha sel·leccionat concepte */

            /** crida a la preparació la vista de la fitxa del concepte */
            $this->viewConcept ( );

            /** crida al mètode que recupera el concepte indicat */
            $this->concepte = $this->model->getConcepteById ( filter_input ( INPUT_POST , 'idModificar' ) );

        }         
            
    }
    
    /** 
      * Estableix la vista per crear un concepte.
      * @access private
      */
    private function newConcept ( ) {
           
        /** crida a la preparació la vista de la fitxa del concepte */
        $this->viewConcept ( );

    }
    
    /** 
      * Desa les dades del concepte.
      * @access private
      */
    private function saveConcept ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );

        if ( ( filter_has_var ( INPUT_POST , 'idConcepte' ) ) && ( ( filter_input ( INPUT_POST , 'idConcepte' ) ) != "" ) ) { /** si s'ha sel·leccionat concepte executa el mètode Update */
            
            
            $this->updateConcept ( filter_input ( INPUT_POST , 'idConcepte' ) );
        
            
        } else { /** si no hi ha concepte sel·leccionat executa el mètode Insert */
            
            $this->insertConcept ( );
        
        }        
    }
    
    /** Estableix el valors d'un concepte enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {

        $this->nomConcepte = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'concepte' ) );
        $this->importUnitari = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'importUnitari' ) );
        $this->actiu = ( $this->model->link->real_escape_string( filter_has_var ( INPUT_POST , 'actiu' ) ) ) ? 1 : 0;

    }
    
    /** 
      * Inserta un concepte a la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function insertConcept ( ) {
    
        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->nomConcepte . "','" . $this->importUnitari . "'," . $this->actiu;

        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir un concepte nou */
            $this->concepte = $this->model->afegeixConcepte( $fields );
            
        }                        
        
        $this->saveLOPDRecord ( 'ALLOW' , _INSERT_ , _INSERT_TEXT_ , date ( "Y-m-d H:i:s" ) , 'FITXA DEL CONCEPTE' );            

        /** crida al mètode que mostra la llista de conceptes*/
        $this->viewList ( );
    
    }
    
    /** 
      * Actualitza un concepte a la bbdd i estableix la vista a mostrar.
      * @access private
      * @param integer $idConcepte Valor del camp per la clàusula WHERE de SQL.
    */
    private function updateConcept ( $idConcepte ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "concepte='" . $this->nomConcepte . "',importUnitari='" . $this->importUnitari . "',actiu=" . $this->actiu;

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode per actualitzar un concepte */
            $this->concepte = $this->model->modificaConcepte ( $idConcepte , $fields );
        
        }

        $this->saveLOPDRecord ( 'ALLOW' , _UPDATE_ , _UPDATE_TEXT_ , date ( "Y-m-d H:i:s" ) , 'FITXA DEL CONCEPTE' );    
              
        /** crida al mètode que mostra la llista de conceptes */
        $this->viewList ( );
        
    }
    
    /** 
      * Esborra un concepte de la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function deleteConcept ( ) {
       
            if ( ( filter_has_var ( INPUT_POST , 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST , 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat concepte crida al mètode per esborrar-lo */

                /** executa el mètode per esborrar un concepte */
                $this->concepte = $this->model->esborraConcepte ( filter_input ( INPUT_POST , 'idEliminar' ) );

            }

            $this->saveLOPDRecord ( 'ALLOW' , _DELETE_ , _DELETE_TEXT_ , date ( "Y-m-d H:i:s" ) , 'FITXA DEL CONCEPTE' );    
            
            /** crida al mètode que mostra la llista de conceptes */
            $this->viewList ( );
      
    }
    
    
    private function saveLOPDRecord ( $resultat , $tipusAccio , $tipusAccioText , $dataRegistre , $componentText ) {
        
        
        switch ( $resultat ) {
            case "ALLOW":
                    $resultatAccio = _ALLOW_ACCESS_;
                    $resultatAccioText = _ALLOW_ACCESS_TEXT_;          
                break;
            case "DENY":
                 $resultatAccio = _DENY_ACCESS_;
                $resultatAccioText = _DENY_ACCESS_TEXT_;           
                break;
        }
            
     

        $observacions = $this->model->link->real_escape_string( "Mòdul: ". $componentText . " Accés tipus: " . $tipusAccioText .". Resultat:  " . $resultatAccioText );

        lopd::afegeixRegistre ( $_SESSION['idUsuari'] , $tipusAccio , $tipusAccioText , $resultatAccio , $resultatAccioText , self::_ID_MODUL_ , self::_TXT_MODUL_ , $observacions , $dataRegistre );       

    }    
    
}