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
 * Create at 22-sep-2020 12:54:55
 * Project name myFramework
 * Project DisplayName myFramework
 * Filename visittemplatescontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe visittemplatescontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package visittemplatescontroller
 * @subpackage visits
 * @version 1.0.0
 */
final class visittemplatescontroller extends controller {
    
     /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $modelPlanillaVisita Conté el model de la planilla visita */
    private $modelPlanillaVisita;

    /**  @var string $llistaPlanillesVisita Conté la llista planilla visita */
    public $llistaPlanillesVisita;
    
    /**  @var string $planillaVisita Conté la planilla visita */
    public $planillaVisita;

    /**  @var integer $idPlanillaVisita Conté el identificador de la planilla visita */    
    private $idPlanillaVisita;

    /**  @var string $descripcioPlanillaVisita Conté la descripcio de la planilla visita */    
    private $descripcioPlanillaVisita;

    /**  @var string $modelTramPlanillaVisita Conté el model del tram de la planilla visita */
    private $modelTramPlanillaVisita;
    
    /**  @var string $llistaTramsPlanillaVisita Conté la llista de trams de la planilla visita */
    public $llistaTramsPlanillaVisita;

    /**  @var string $tramPlanillaVisita Conté el tram de la planilla visita */
    public $tramPlanillaVisita;
    
    /**  @var string $descripcioTramPlanillaVisita Conté la descripció del tram de la planilla visita */    
    private $descripcioTramPlanillaVisita;

    /**  @var float $horaEntrada Conté l'hora d'entrada del tram de la planilla visita */    
    private $horaEntrada;

    /**  @var integer $horaSortida Conté l'hora de sortida del tram de la planilla visita */    
    private $horaSortida;
    
    /**  @var string $modelDepartament Conté el model del departament */
    private $modelDepartament;
    
    /**  @var string $llistaDepartaments Conté la llista de departaments */
    public $llistaDepartaments;

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
                    $this->cloneVisitTemplate ( );
                break;
            case "Edit":
                    $this->editVisitTemplate ( );
                break;
            case "EditDet":
                    $this->editSectionVisitTemplate ( );
                break;
            case "New":
                    $this->newVisitTemplate ( );
                break;
            case "NewDet":
                    $this->newSectionVisitTemplate ( );
                break;
            case "Save":
                    $this->saveVisitTemplate ( );
                break;
            case "SaveDet":
                    $this->saveSectionVisitTemplate ( );
                break;
            case "Delete":
                    $this->deleteVisitTemplate ( );
                break;
            case "DeleteDet":
                     $this->deleteSectionVisitTemplate( );
                break;
            case "Generate":
                    $this->visitGenerate ();
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
        
        /** crea el model per l'objecte planilla visita */
        $this->modelPlanillaVisita = new planillaVisita ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de planilles vistita i la vista a mostrar.
      * @access private
      */ 
    private function viewList ( ) {
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'visittemplatesview.php';    

    }

    /** 
      * Prepara la vista de la fitxa d'una planilla visita.
      * @access private
      * @param integer $idPlanillaVisita Valor del camp per la clàusula WHERE de SQL.
      */      
    private function viewVisitTemplate ( $idPlanillaVisita ) {
       
        /** crida al mètode que recupera la planilla visita indicada */
        $this->planillaVisita = $this->modelPlanillaVisita->getPlanillaVisitaById ( $idPlanillaVisita );

        /** crea el model per l'objecte detall de la planilla visita */
        $this->modelTramPlanillaVisita = new tramPlanillaVisita( );
        
        /** crida al mètode que recupera la llista de trams de la planilla visita */
        $this->llistaTramsPlanillaVisita = $this->modelTramPlanillaVisita->getLlistaTramsPlanillaVisita ( $idPlanillaVisita );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'visittemplateview.php';          

    }

    /** 
      * Prepara la vista de la fitxa del tram d'una planilla visita.
      * @access private
      */  
    private function viewSectionVisitTemplate ( ) {

        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'sectionvisittemplateview.php';
         
    }

    /** 
     * Estableix la vista per modificar la planilla visita.
     * @access private
     */
    private function editVisitTemplate ( ) {      

        if ( filter_has_var ( INPUT_POST, 'idModificar' ) ) {  /** si s'ha sel·leccionat la planilla visita */
            
            /** crea el model per l'objecte detall de la planilla visita */
            $this->modelTramPlanillaVisita = new tramPlanillaVisita ( );

            /** crida al mètode que recupera la llista de detalls de la planilla visita indicada */
            $this->llistaTramsPlanillaVisita = $this->modelTramPlanillaVisita->getLlistaTramsPlanillaVisita ( filter_input ( INPUT_POST, 'idModificar' )  );

            /** cria al mètode que mostra la `planilla visita */
            $this->viewVisitTemplate( filter_input ( INPUT_POST, 'idModificar' ) );

        }

    }

    /** 
     * Estableix la vista per modificar el tram de la planilla visita.
     * @access private
     */
    private function editSectionVisitTemplate ( ) {      
        
        if ( filter_has_var ( INPUT_POST, 'idModificar' ) ) {  /** si s'ha sel·leccionat la planilla visita */

            /** crea el model per l'objecte tram de la planilla visita */
            $this->modelTramPlanillaVisita = new tramPlanillaVisita( );

            /** crida al mètode que recupera el tram de la planilla visita indicada */
            $this->tramPlanillaVisita = $this->modelTramPlanillaVisita->getTramPlanillaVisitaById ( filter_input ( INPUT_POST, 'idModificar' )  );
            
            /** cria al mètode que mostra el tram de la planilla visita */
            $this->viewSectionVisitTemplate ( );
        }

    }

    /** 
      * Estableix la vista per crear una planilla visita.
      * @access private
      */
    private function newVisitTemplate ( ) {
        
        $this->view = $_SESSION["viewPath"] . 'visittemplateview.php';        
    
    }
    
    /** 
      * Estableix la vista per crear el tram d'una planilla visita
      * @access private
      */
    private function newSectionVisitTemplate ( ) {

        if ( filter_has_var ( INPUT_POST, 'idMaster' ) ) {  /** si s'ha sel·leccionat la planilla visita */
            
            $this->tramPlanillaVisita['idPlanillaVisita'] = filter_input ( INPUT_POST, 'idMaster' ) ;

            /** cria al mètode que mostra el tram de la planilla visita */
            $this->viewSectionVisitTemplate ( );
        }
 
    }
    
    /** 
     * Desa les dades d'una planilla de visites
     * @access private
     */    
    private function saveVisitTemplate ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );
        
        if ( ( filter_has_var ( INPUT_POST, 'idPlanillaVisita' ) ) && ( ( filter_input ( INPUT_POST, 'idPlanillaVisita' ) ) != "" ) ) { /** si s'ha sel·leccionat una planilla visita executa el mètode Update */
            
            $this->updateVisitTemplate ( filter_input ( INPUT_POST, 'idPlanillaVisita' ) );
        
            
        } else {  /** si no hi ha planilla visita sel·leccionada executa el mètode Insert */
            
            $this->insertVisitTemplate ( );
        
        }        
        
    }
 
    /** Estableix el valors d'una planilla visita enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {
        
        $this->descripcioPlanillaVisita = $this->modelPlanillaVisita->link->real_escape_string ( filter_input ( INPUT_POST, 'descripcioPlanillaVisita' ) );

    }    
    
    /** 
     * Afegeix una planilla visita
     * @access private
     */    
    private function insertVisitTemplate ( ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->descripcioPlanillaVisita  . "'";
        
        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir una planilla visita */
            $ret = $this->modelPlanillaVisita->afegeixPlanillaVisita ( $fields );
            
        }

        if ( !$ret ) { /** si s'ha produït un error */
            
            /** Recupera el número d'error */
            $errTitle = 'Error (' . $this->modelPlanillaVisita->link->errno . ')';
            
            /** Recupera el missatge d'error */
            $errMessage = $this->modelPlanillaVisita->link->error;

            /** Crida a la función que la finestra modal amb l'error */
            $this->setError ( $errTitle, $errMessage );

            /** crida al mètode que mostra la llista de planilles visita */
            $this->viewList ( ); 
            
            
        } else {

            /** recupera el identificador de l'última planilla visita afegida a la BBDD */
            $idPlanillaVisita  = $this->modelPlanillaVisita->retornaUltimaPlanillaVisitaAfegida ( );

            /** cria al mètode que mostra la planilla visita */
            $this->viewVisitTemplate ( $idPlanillaVisita );
        
        }

        
    }
    
    /** 
     * Actualitza les dades d'una planilla visita.
     * @access private
     * @param integer $idPlanillaVisita Valor del camp per la clàusula WHERE de SQL.
     */      
    private function updateVisitTemplate ( $idPlanillaVisita ) {

        $fields = "descripcioPlanillaVisita='" . $this->descripcioPlanillaVisita  . "'";

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode  per actualitza  una planilla visita */
            $ret = $this->modelPlanillaVisita->modificaPlanillaVisita ( $idPlanillaVisita , $fields );

        }
        
        
        if ( !$ret ) { /** si s'ha produït un error */
            
            
            /** Recupera el número d'error */
            $errTitle = 'Error (' . $this->modelPlanillaVisita->link->errno . ')';
            
            /** Recupera el missatge d'error */
            $errMessage = $this->modelPlanillaVisita->link->error;

            /** Crida a la función que la finestra modal amb l'error */
            $this->setError ( $errTitle, $errMessage );
            
        }        

        /** crida al mètode que mostra la llista de planilles visita */
        $this->viewList ( ); 

    }

    
    /** 
     * Desa les dades del tram d'una planilla visita.
     * @access private
     */     
    private function saveSectionVisitTemplate ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getDetPostValues ( );
        
        if ( ( filter_has_var ( INPUT_POST, 'idTramPlanillaVisita' ) ) && ( ( filter_input ( INPUT_POST, 'idTramPlanillaVisita' ) ) != "" ) ) { /** si s'ha sel·leccionat un tram de la planilla visita executa el mètode Update */
            
            $this->updateSectionVisitTemplate ( filter_input ( INPUT_POST, 'idTramPlanillaVisita' ) );
        
            
        } else {  /** si no hi ha tram de la planilla visita sel·leccionada executa el mètode Insert */
            
            $this->insertSectionVisitTemplate ( );
        
        }        
    }

    
    /** Estableix el valors d'un tram de la planilla visita enviats mitjançant un formulari.
      * @access private
      */
    private function getDetPostValues ( ) {

        $this->idPlanillaVisita = $this->modelPlanillaVisita->link->real_escape_string( filter_input ( INPUT_POST, 'idModificar' ) );
        $this->descripcioTramPlanillaVisita = $this->modelPlanillaVisita->link->real_escape_string( filter_input ( INPUT_POST, 'descripcioTramPlanillaVisita' ) );
        $this->horaEntrada = $this->modelPlanillaVisita->link->real_escape_string( filter_input ( INPUT_POST, 'horaEntrada' ) );
        $this->horaSortida = $this->modelPlanillaVisita->link->real_escape_string( filter_input ( INPUT_POST, 'horaSortida' ) );

    }      
    
    /** 
     * Afegeix un tram de planilla visita.
     * @access private
     */ 
    private function insertSectionVisitTemplate ( ) {

        /** crea l'obecte tram de planilla visita */
        $this->modelTramPlanillaVisita = new tramPlanillaVisita ( );    

        $fields = $this->idPlanillaVisita . ",'" . $this->descripcioTramPlanillaVisita . "','" . $this->horaEntrada . "','" . $this->horaSortida . "'";
        
        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa al mètode que afegeix el tram de la planilla visita sel·leccionada */
            $ret = $this->modelTramPlanillaVisita->afegeixTramPlanillaVisita ( $fields );
        }

        if ( !$ret ) { /** si s'ha produït un error */
            
            
            /** Recupera el número d'error */
            $errTitle = 'Error (' . $this->modelTramPlanillaVisita->link->errno . ')';
            
            /** Recupera el missatge d'error */
            $errMessage = $this->modelTramPlanillaVisita->link->error;

            /** Crida a la función que la finestra modal amb l'error */
            $this->setError ( $errTitle, $errMessage );
            
        } 
        
        /** cria al mètode que mostra la planilla visita */
        $this->viewVisitTemplate( $this->idPlanillaVisita );
    }

    /** 
     * Actualitza les dades del tram de la planilla visita.
     * @access private
     * @param integer $idTramPlanillaVisita Valor del camp per la clàusula WHERE de SQL.
     */      
    private function updateSectionVisitTemplate ( $idTramPlanillaVisita ) {

        /** crea l'obecte tram de planilla visita */
        $this->modelTramPlanillaVisita = new tramPlanillaVisita ( );  

        $fields = "descripcioTramPlanillaVisita='" . $this->descripcioTramPlanillaVisita . "', horaEntrada='" . $this->horaEntrada . "', horaSortida='" . $this->horaSortida . "'";

        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa al mètode que modifica el tram de la planilla visita sel·leccionada */
            $ret = $this->modelTramPlanillaVisita->modificaTramPlanillaVisita ( $idTramPlanillaVisita , $fields );
            
        }

        if ( !$ret ) { /** si s'ha produït un error */
            
            
            /** Recupera el número d'error */
            $errTitle = 'Error (' . $this->modelTramPlanillaVisita->link->errno . ')';
            
            /** Recupera el missatge d'error */
            $errMessage = $this->modelTramPlanillaVisita->link->error;

            /** Crida a la función que la finestra modal amb l'error */
            $this->setError ( $errTitle, $errMessage );
            
        }          
        
        /** cria al mètode que mostra la planilla visita */
        $this->viewVisitTemplate( $this->idPlanillaVisita );
        
    }
    
    /** 
     * Esborra la planilla visita sel·leccionada.
     * @access private
     */    
    private function deleteVisitTemplate ( ) {

        if ( ( filter_has_var ( INPUT_POST, 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST, 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat una planilla visita crida al mètode per esborrar-la */
            
            /** crea l'obecte tram de la planilla viista */
            $this->modelTramPlanillaVisita = new tramPlanillaVisita ( );
            
            /** crida al mètode que recupera la llista de trams de la planilla visita */
            $this->llistaTramsPlanillaVisita = $this->modelTramPlanillaVisita->getLlistaTramsPlanillaVisita (  filter_input ( INPUT_POST, 'idEliminar' ) );        
            
            foreach ( $this->llistaTramsPlanillaVisita as $dato ) { /** per cada tramm de la planilla visita */
                
                /** executa al mètode que esborra el tram de la planilla visita sel·leccionada */
                $ret = $this->modelTramPlanillaVisita->esborraTramPlanillaVisita( $dato["idTramPlanillaVisita"] );
                
            }


            if ( !$ret ) { /** si s'ha produït un error */


                /** Recupera el número d'error */
                $errTitle = 'Error (' . $this->modelTramPlanillaVisita->link->errno . ')';

                /** Recupera el missatge d'error */
                $errMessage = $this->modelTramPlanillaVisita->link->error;

                /** Crida a la función que la finestra modal amb l'error */
                $this->setError ( $errTitle, $errMessage );

            }  else {                
            
                /** executa el mètode per esborrar una planilla visita */
                $ret = $this->modelPlanillaVisita->esborraPlanillaVisita( filter_input ( INPUT_POST, 'idEliminar' ) );
                

                if ( !$ret ) { /** si s'ha produït un error */


                    /** Recupera el número d'error */
                    $errTitle = 'Error (' . $this->modelPlanillaVisita->link->errno . ')';

                    /** Recupera el missatge d'error */
                    $errMessage = $this->modelPlanillaVisita->link->error;

                    /** Crida a la función que la finestra modal amb l'error */
                    $this->setError ( $errTitle, $errMessage );

                }                      
            }
            
        }
        
        /** crida al mètode que mostra la llista de planilles visita */
        $this->viewList ( );
        
    }
    
    /** 
      * Esborra el tram de planilla visita sel·leccionat.
      * @access private
      */ 
    private function deleteSectionVisitTemplate ( ) {

        if ( ( filter_has_var ( INPUT_POST, 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST, 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat un tram de la planilla visita crida al mètode per esborrar-la */

            /** crea l'obecte tram de la planilla viista */
            $this->modelTramPlanillaVisita = new tramPlanillaVisita( );
            
            /** executa al mètode que esborra el tram de la planilla visita sel·leccionat */
            $ret = $this->modelTramPlanillaVisita->esborraTramPlanillaVisita( filter_input ( INPUT_POST, 'idEliminar' ) );

        }

        if ( !$ret ) { /** si s'ha produït un error */


            /** Recupera el número d'error */
            $errTitle = 'Error (' . $this->modelTramPlanillaVisita->link->errno . ')';

            /** Recupera el missatge d'error */
            $errMessage = $this->modelTramPlanillaVisita->link->error;

            /** Crida a la función que la finestra modal amb l'error */
            $this->setError ( $errTitle, $errMessage );

        }
            
        /** cria al mètode que mostra la planilla visita */
        $this->viewVisitTemplate( filter_input ( INPUT_POST, 'idMaster' ) );

    }

    /** 
      * Duplica la planilla visita sel·leccionada.
      * @access private
      */
    private function cloneVisitTemplate ( ) {
        
        if ( filter_has_var ( INPUT_POST, 'idClonar' ) && ( ( filter_input ( INPUT_POST, 'idClonar' ) ) != "" ) ) {  /** si s'ha sel·leccionat una planilla visita */

            /** crida al mètode que recupera la planilla visita indicada */
            $this->planillaVisita = $this->modelPlanillaVisita->getPlanillaVisitaById ( filter_input ( INPUT_POST, 'idClonar' ) );

            /** fa falta "real_escape_string" ja que al recuperar els valors de la bbdd cal escapar dels caràcters especials */
            $fields = "'Planilla clonada (" . date('d/m/Y H:i') . ") de: " . $this->modelPlanillaVisita->link->real_escape_string( $this->planillaVisita["descripcioPlanillaVisita"] ) . "'";
            
            /** crida al mètode que afegeix una planilla visita */
            $ret = $this->modelPlanillaVisita->afegeixPlanillaVisita ( $fields );

            if ( !$ret ) { /** si s'ha produït un error */


                /** Recupera el número d'error */
                $errTitle = 'Error (' . $this->modelPlanillaVisita->link->errno . ')';

                /** Recupera el missatge d'error */
                $errMessage = $this->modelPlanillaVisita->link->error;

                /** Crida a la función que la finestra modal amb l'error */
                $this->setError ( $errTitle, $errMessage );

                /** crida al mètode que mostra la llista de planilles visita */
                $this->viewList ( ); 


            } else {            
            
                /** recupera el identificador de l'última planilla visita afegit a la BBDD */
                $idPlanillaVisita  = $this->modelPlanillaVisita->retornaUltimaPlanillaVisitaAfegida ( );

                /** crea l'objecte tram de la planilla visita */
                $this->modelTramPlanillaVisita = new tramPlanillaVisita ( );

                /** crida al mètode que recupera els trams de la planilla visita indicada */
                $this->llistaTramsPlanillaVisita = $this->modelTramPlanillaVisita->getLlistaTramsPlanillaVisita ( filter_input ( INPUT_POST, 'idClonar' ) );

            
                foreach ( $this->llistaTramsPlanillaVisita as $dato ) { /** per cada tram de la planilla visita */
                    /** fa falta "real_escape_string" ja que al recuperar els valors de la bbdd cal escapar dels caràcters especials */
                    $fields = $idPlanillaVisita . ",'" . $this->modelTramPlanillaVisita->link->real_escape_string( $dato["descripcioTramPlanillaVisita"] ) . "','" . $this->modelTramPlanillaVisita->link->real_escape_string( $dato["horaEntrada"] ) . "','" . $this->modelTramPlanillaVisita->link->real_escape_string( $dato["horaSortida"] ) . "'";

                    /** crida al mètode que afegeix un tram de la planilla visita */
                    $ret = $this->modelTramPlanillaVisita->afegeixTramPlanillaVisita ( $fields );
                }
                if ( !$ret ) { /** si s'ha produït un error */


                    /** Recupera el número d'error */
                    $errTitle = 'Error (' . $this->modelTramPlanillaVisita->link->errno . ')';

                    /** Recupera el missatge d'error */
                    $errMessage = $this->modelTramPlanillaVisita->link->error;

                    /** Crida a la función que la finestra modal amb l'error */
                    $this->setError ( $errTitle, $errMessage );

                }                
            }

            /** crida al mètode que mostra la llista de planilles visita */
            $this->viewList ( );

        }
        
    }
    
    /** 
      * Prepara la vista per geenrar la visita.
      * @access private
      */    
    private function visitGenerate ( ) {
        if ( filter_has_var ( INPUT_POST, 'idGenerar' ) && ( ( filter_input ( INPUT_POST, 'idGenerar' ) ) != "" ) ) {  /** si s'ha sel·leccionat una planilla visita */

            /** crida al mètode que recupera la planilla visita indicada */
            $this->planillaVisita = $this->modelPlanillaVisita->getPlanillaVisitaById ( filter_input ( INPUT_POST, 'idGenerar' ) );
            
            $this->modelDepartament = new departament ( ) ;
            
            $this->llistaDepartaments = $this->modelDepartament->getLlistaDepartaments ( );
                    
            /** estableix la vista que s'ha de mostrar */
            $this->view = $_SESSION["viewPath"] . 'generatevisitdayview.php';    
        }
        
    }
   
}

?>