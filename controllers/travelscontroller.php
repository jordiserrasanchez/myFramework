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
 * Filename travelscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe travelscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package travelscontroller
 * @subpackage travels
 * @version 1.0.0
 */
final class travelscontroller extends controller {
    
    /**  @var string $model Conté el model */
    private $model;
    
     /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $viatge Conté l'objecte viatge */
    public $viatge;

    /**  @var string $model_det Conté el model del detall */
    private $model_det;
    
    /**  @var string $viatge_det Conté l'objecte detalls viatge */
    public $viatge_det;

    /**  @var string $nomViatge Conté el nom del viatge */    
    private $nomViatge;

    /**  @var date $data Conté la data viatge */    
    private $data;

    /**  @var integer $abonat Indica si el viatge s'ha abonat */    
    private $abonat;

    /**  @var integer $idViatge Conté el identificador del viatge */    
    private $idViatge;

    /**  @var string $concepte Conté el concepte del detall del viatge */    
    private $concepte;

    /**  @var float $importUnitari Conté el import unitari del detall del viatge */    
    private $importUnitari;

    /**  @var integer $unitats Conté les unitats del detall del viatge */    
    private $unitats;
    

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
            case "Clone":
                    $this->cloneTravel ( );
                break;
            case "Edit":
                    $this->editTravel ( );
                break;
            case "EditDet":
                    $this->editTravelDet ( );
                break;
            case "New":
                    $this->newTravel ( );
                break;
            case "NewDet":
                    $this->newTravelDet ( );
                break;
            case "Save":
                    $this->saveTravel ( );
                break;
            case "SaveDet":
                    $this->saveTravelDet ( );
                break;
            case "Delete":
                    $this->deleteTravel ( );
                break;
            case "DeleteDet":
                     $this->deleteTravelDet( );
                break;
            case "Undo":
                    $this->undoTravel ( );
                break;
            case "Receive":
                    $this->receiveTravel ( );
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
      * Inicialitza els valors necessaris. 
      * @access private
      */
    private function setInitValues ( ) {
        
        /** crea l'objecte viatge */
        $this->model = new viatge ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de viatges i la vista a mostrar.
      * @access private
      */ 
    private function viewList ( ) {
        
        /** crida al mètode que recupera la llista de viatges */
        $this->viatge = $this->model->getLlistaViatges ( );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'travelsview.php';    

    }


    /** 
      * Prepara la vista de la fitxa d'un viatge.
      * @access private
      * @param integer $idViatge Valor del camp per la clàusula WHERE de SQL.
      */      
    private function viewTravel ( $idViatge ) {
       
        /** crida al mètode que recupera el viatge indicat */
        $this->viatge = $this->model->getViatgeById ( $idViatge );

        /** crea l'objecte detall del viatge */
        $this->model_det = new viatge_det( );
        
        /** crida al mètode que recupera la llista de detealls del viatges */
        $this->viatge_det = $this->model_det->getLlistaViatges_det ( $idViatge );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'travelview.php';          

    }

    /** 
      * Prepara la vista de la fitxa del detall d'un viatge.
      * @access private
      */  
    private function viewTravelDet ( ) {

        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'traveldetview.php';
         
    }

    /** 
     * Estableix la vista per modificar el viatge.
     * @access private
     */
    private function editTravel ( ) {      

        if ( filter_has_var ( INPUT_POST, 'idModificar' ) ) {  /** si s'ha sel·leccionat viatge */
            
            /** crea l'objecte detall del viatge */
            $this->model_det = new viatge_det ( );

            /** crida al mètode que recupera els detalls del viatge indicat */
            $this->viatge_det = $this->model_det->getLlistaViatges_det ( filter_input ( INPUT_POST, 'idModificar' )  );

            /** cria al mètode que mostra el viatge */
            $this->viewTravel( filter_input ( INPUT_POST, 'idModificar' ) );

        }

    }

    /** 
     * Estableix la vista per modificar el detall d'un viatge.
     * @access private
     */
    private function editTravelDet ( ) {      
        
        if ( filter_has_var ( INPUT_POST, 'idModificar' ) ) {  /** si s'ha sel·leccionat viatge */

            /** crea l'objecte detall del viatge */
            $this->model_det = new viatge_det( );

            /** crida al mètode que recupera els detalls del viatge indicat */
            $this->viatge_det = $this->model_det->getDetallViatgeById ( filter_input ( INPUT_POST, 'idModificar' )  );
            
            /** cria al mètode que mostra el detall del viatge */
            $this->viewTravelDet ( );
        }

    }

    /** 
      * Estableix la vista per crear un viatge.
      * @access private
      */
    private function newTravel ( ) {
        
        $this->view = $_SESSION["viewPath"] . 'travelview.php';        
    
    }
    
    /** 
      * Estableix la vista per crear el detall d'un viatge.
      * @access private
      */
    private function newTravelDet ( ) {

        if ( filter_has_var ( INPUT_POST, 'idMaster' ) ) {  /** si s'ha sel·leccionat viatge */
            
            /** crea l'objecte detall del viatge */
            $this->model_det = new viatge_det ( );

            $this->viatge_det['concepte'] = "";
            $this->viatge_det['importUnitari'] = 0.00;
            $this->viatge_det['unitats'] = 0;
            $this->viatge_det['idViatge_det']= "";
            $this->viatge_det['idViatge'] = filter_input ( INPUT_POST, 'idMaster' ) ;

            /** cria al mètode que mostra el detall del viatge */
            $this->viewTravelDet ( );
        }
 
    }
    
    /** 
     * Desa les dades d'un viatge.
     * @access private
     */    
    private function saveTravel ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );
        
        if ( ( filter_has_var ( INPUT_POST, 'idViatge' ) ) && ( ( filter_input ( INPUT_POST, 'idViatge' ) ) != "" ) ) { /** si s'ha sel·leccionat un viatge executa el mètode Update */
            
            $this->updateTravel ( filter_input ( INPUT_POST, 'idViatge' ) );
        
            
        } else {  /** si no hi ha viatge sel·leccionat executa el mètode Insert */
            
            $this->insertTravel ( );
        
        }        
        
    }

    
    /** Estableix el valors d'un viatge enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {
        
        $this->nomViatge = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'viatge' ) );
        $this->data = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'data' ) );
        $this->abonat = ( $this->model->link->real_escape_string( filter_has_var ( INPUT_POST, 'abonat' ) ) )?1:0;

    }    
    

    /** 
     * Afegeix un viatge
     * @access private
     */    
    private function insertTravel ( ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->nomViatge  . "','" .  date_format ( date_create ( str_replace ( "/" , "-" , $this->data ) ) , 'Y-m-d' ) . "'," . $this->abonat;
        
        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir un viatge */
            $this->viatge = $this->model->afegeixViatge ( $fields );
        
        }
        
        /** recupera el identificador de l'últim viatge afegit a la BBDD */
        $idViatge  = $this->model->retornaUltimViatgeAfegit ( );

        /** cria al mètode que mostra el viatge */
        $this->viewTravel( $idViatge );
        
    }
    
    /** 
     * Actualitza les dades d'un viatge.
     * @access private
     * @param integer $idViatge Valor del camp per la clàusula WHERE de SQL.
     */      
    private function updateTravel ( $idViatge ) {

        $fields = "viatge='" . $this->nomViatge  . "', data='" . date_format ( date_create ( str_replace ("/" , "-" , $this->data ) ) , 'Y-m-d' ) . "', abonat=" . $this->abonat;

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode  per actualitza  un viatge */
            $this->viatge = $this->model->modificaViatge ( $idViatge , $fields );

        }
        
        /** crida al mètode que mostra la llista de viatges */
        $this->viewList ( ); 
    }

    /** 
     * Desa les dades del detall d'un viatge.
     * @access private
     */     
    private function saveTravelDet ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getDetPostValues ( );
        
        if ( ( filter_has_var ( INPUT_POST, 'idViatge_det' ) ) && ( ( filter_input ( INPUT_POST, 'idViatge_det' ) ) != "" ) ) { /** si s'ha sel·leccionat un detall de viatge executa el mètode Update */
            
            $this->updateTravelDet ( filter_input ( INPUT_POST, 'idViatge_det' ) );
        
            
        } else {  /** si no hi ha detall de viatge sel·leccionat executa el mètode Insert */
            
            $this->insertTravelDet ( );
        
        }        
    }

    
    /** Estableix el valors d'un detall de viatge enviats mitjançant un formulari.
      * @access private
      */
    private function getDetPostValues ( ) {

        $this->idViatge = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'idModificar' ) );
        $this->concepte = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'concepte' ) );
        $this->importUnitari = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'importUnitari' ) );
        $this->unitats = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'unitats' ) );

    }      
    
    /** 
     * Afegeix del detall d'un viatge.
     * @access private
     */ 
    private function insertTravelDet ( ) {

        /** crea l'obecte detall del viatge */
        $this->model_det = new viatge_det ( );    

        $fields = $this->idViatge . ",'" . $this->concepte . "','" . $this->importUnitari . "'," . $this->unitats;
        
        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa al mètode que afegeix el detall del viatge sel·leccionat */
            $this->viatge_det = $this->model_det->afegeixViatge_det ( $fields );
        }

        /** cria al mètode que mostra el viatge */
        $this->viewTravel( $this->idViatge );
    }

    /** 
     * Actualitza les dades del detall d'un viatge.
     * @access private
     * @param integer $idViatge_det Valor del camp per la clàusula WHERE de SQL.
     */      
    private function updateTravelDet ( $idViatge_det ) {

        /** crea l'obecte detall del viatge */
        $this->model_det = new viatge_det ( );

        $fields = "concepte='" . $this->concepte . "', importUnitari='" . $this->importUnitari . "', unitats=" . $this->unitats;

        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa al mètode que modifica el detall del viatge sel·leccionat */
            $this->viatge_det = $this->model_det->modificaViatge_det ( $idViatge_det , $fields );
            
        }

        /** cria al mètode que mostra el viatge */
        $this->viewTravel( $this->idViatge );
        
    }
    
    /** 
     * Esborra el viatge sel·leccionat.
     * @access private
     */    
    private function deleteTravel ( ) {

        if ( ( filter_has_var ( INPUT_POST, 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST, 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat un viatge crida al mètode per esborrar-la */
            
            /** crea l'obecte detall del viatge */
            $this->model_det = new viatge_det ( );
            
            /** crida al mètode que recupera la llista de detalls del viatge */
            $this->viatge_det = $this->model_det->getLlistaViatges_det (  filter_input ( INPUT_POST, 'idEliminar' ) );        
            
            foreach ( $this->viatge_det as $dato ) { /** per cada detall del viatge */
                
                /** executa al mètode que esborra el detall del viatge sel·leccionat */
                $this->model_det->esborraViatge_det( $dato["idViatge_det"] );
                
            }

            /** executa el mètode per esborrar un viatge */
            $this->viatge = $this->model->esborraViatge( filter_input ( INPUT_POST, 'idEliminar' ) );
            
        }
        
        /** crida al mètode que mostra la llista de viatges */
        $this->viewList ( );
        
    }
    
    /** 
      * Esborra el detall del viatge sel·leccionat.
      * @access private
      */ 
    private function deleteTravelDet ( ) {

        if ( ( filter_has_var ( INPUT_POST, 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST, 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat un detall de viatge crida al mètode per esborrar-la */

            /** crea l'obecte detall del viatge */
            $this->model_det = new viatge_det( );
            
            /** executa al mètode que esborra el detall del viatge sel·leccionat */
            $this->viatge_det = $this->model_det->esborraViatge_det( filter_input ( INPUT_POST, 'idEliminar' ) );

        }
        
        /** cria al mètode que mostra el viatge */
        $this->viewTravel( filter_input ( INPUT_POST, 'idMaster' ) );

    }

    /** 
      * Fà el pagament del viatge sel·leccionat.
      * @access private
      */    
    private function receiveTravel ( ) {

        if ( ( filter_has_var ( INPUT_POST, 'idCobrar' ) ) && ( ( filter_input ( INPUT_POST, 'idCobrar' ) ) != "" ) ) { /** si s'ha sel·leccionat un viatge crida al mètode per cobrar-lo */
            
            /** crida al mètode que modifica el viatge indicat */
            $this->viatge = $this->model->modificaViatge ( filter_input ( INPUT_POST, 'idCobrar' ) , "abonat=1" );

        }
        
        $this->viewList();
        
    }    
    
    /** 
      * Desfà el pagament del viatge sel·leccionat.
      * @access private
      */
    private function undoTravel ( ) {

        if ( ( filter_has_var ( INPUT_POST, 'idRevertir' ) ) && ( ( filter_input ( INPUT_POST, 'idRevertir' ) ) != "" ) ) { /** si s'ha sel·leccionat un viatge crida al mètode per revertir-lo */
             
            /** crida al mètode que modifica el viatge indicat */
            $this->viatge = $this->model->modificaViatge ( filter_input ( INPUT_POST, 'idRevertir' ) , "abonat=0" );
        
        }
        
        $this->viewList();
    }    
    
    /** 
      * Duplica el viatge sel·leccionat.
      * @access private
      */
    private function cloneTravel ( ) {
        
        if ( filter_has_var ( INPUT_POST, 'idClonar' ) && ( ( filter_input ( INPUT_POST, 'idClonar' ) ) != "" ) ) {  /** si s'ha sel·leccionat viatge */

            /** crida al mètode que recupera el viatge indicat */
            $this->viatge = $this->model->getViatgeById ( filter_input ( INPUT_POST, 'idClonar' ) );

            /** crea l'objecte detall del viatge */
            $this->model_det = new viatge_det ( );

            /** crida al mètode que recupera els detalls del viatge indicat */
            $this->viatge_det = $this->model_det->getLlistaViatges_det ( filter_input ( INPUT_POST, 'idClonar' ) );
  
            /** fa falta "real_escape_string" ja que al recuperar els valors de la bbdd cal escapar dels caràcters especials */
            $fields = "'" . $this->model->link->real_escape_string( $this->viatge["viatge"] ) . "','" . $this->model->link->real_escape_string( $this->viatge["data"] ) . "',0";

            /** crida al mètode que afegeix un viatge */
            $this->model->afegeixViatge ( $fields );

            /** recupera el identificador de l'últim viatge afegit a la BBDD */
            $idViatge  = $this->model->retornaUltimViatgeAfegit ( );

            foreach ( $this->viatge_det as $dato ) { /** per cada detall de viatge */
                /** fa falta "real_escape_string" ja que al recuperar els valors de la bbdd cal escapar dels caràcters especials */
                $fields = $idViatge . ",'" . $this->model->link->real_escape_string( $dato["concepte"] ) . "','" . $this->model->link->real_escape_string( $dato["importUnitari"] ) . "'," . $this->model->link->real_escape_string( $dato["unitats"] );

                /** crida al mètode que afegeix un detall del viatge */
                $this->viatge_det = $this->model_det->afegeixViatge_det ( $fields );
            }

            /** crida al mètode que mostra la llista de viatges */
            $this->viewList ( );

        }
        
    }
    
}
?>