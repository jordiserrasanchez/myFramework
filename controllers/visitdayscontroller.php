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
 * Filename visitdayscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe visitdayscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package visits
 * @subpackage visits
 * @version 1.0.0
 */
final class visitdayscontroller extends controller {
    
     /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $modelDiaVisita Conté el model del dia de visita */
    private $modelDiaVisita;
    
    /** @var string $llistaDiesVisita Conté la llista de dies de visita */
    public $llistaDiesVisita;

    /**  @var string $diaVisita Conté el dia de visita */
    public $diaVisita;

    /**  @var integer $idDiaVisita Conté el identificador del dia de visita */    
    private $idDiaVisita;

    /**  @var string $token Conté el token del dia de visita */    
    private $token;

    /**  @var date $dataVisita Conté la data del dia de visita */    
    private $dataVisita;

    /**  @var integer $idDepartament Conté el identificador del departament del dia de visita */    
    private $idDepartament;

    /**  @var string $modelHoraDiaVisita Conté el model de l'hora del dia de visita */
    private $modelHoraDiaVisita;

    /** @var string $llistaHoresDiaVisita Conté la llista d'hores del dia de visita */
    public $llistaHoresDiaVisita;
    
    /**  @var string $horaDiaVisita Conté el tram de l'hora d'un dia de visita */
    public $horaDiaVisita;

    /**  @var string $model Conté el model  del departament*/
    private $modelDepartament;
    
    /**  @var string $departament Conté el departament del dia de visita */    
    public $departament;
    
    /**  @var string $llistaDepartaments Conté la llista de departaments */    
    public $llistaDepartaments;
    
    /**  @var string $descripcioHoraDiaVisita Conté la descripció de l'hora d'un dia de visita */    
    private $descripcioHoraDiaVisita;

    /**  @var float $horaEntrada Conté l'hora d'entrada d'un dia de visita */    
    private $horaEntrada;

    /**  @var integer $horaSortida Conté l'hora de sortida d'un dia de visita */    
    private $horaSortida;
    
    /**  @var string $planillaVisita Conté la planilla visita */
    public $planillaVisita;
    
     /**  @var integer $idPlanillaVisita Conté el identificador de la planilla visita */    
    private $idPlanillaVisita;   

    /**  @var string $modelTramsPlanillaVisita Conté el model dels trams de la planilla visita */
    private $modelTramsPlanillaVisita;
    
    /**  @var string $tramPlanillaVisita Conté el tram de la planilla visita */
    public $tramPlanillaVisita;

    /** @var string $objecteModalWindow Conté l'objecte de la finestra modal */
    public $objecteModalWindow;
    
    /** @var boolean $showModal Indica si s'ha de mostrar la finestra modal */
    public $showModal;    
    
    /**  @var string $modelVisita Conté el model den la visita*/
    private $modelVisita;    

    /**  @var string $llistaVisites Conté la llista de visites d'un dia de visita*/
    private $llistaVisites;    

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
                    $this->viewList ( ); /** mostrar la llista de dies de visites */
                break;
            case "View":
                    $this->viewVisitDay ( );
                break;
            case "Save":
                    $this->saveVisitDay ( ); /** desar el dia de visita generat */
                break;
            case "Delete":
                    $this->deleteVisitDay ( );
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
        
        /** crea l'objecte dia de visita */
        $this->modelDiaVisita = new diaVisita ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de dies de visita i la vista a mostrar.
      * @access private
      */ 
    private function viewList ( ) {
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'visitdaysview.php';    

    }

    /** 
      * Prepara la vista de la fitxa d'un dia de visita.
      * @access private
      * @param integer $idDiaVisita Valor del camp per la clàusula WHERE de SQL.
      */      
    private function showVisitDay ( $idDiaVisita ) {
       
        /** crida al mètode que recupera el dia de visita indicada */
        $this->diaVisita = $this->modelDiaVisita->getDiaVisitaById ( $idDiaVisita );

        /** crea l'objecte detall del dia de visita */
        $this->modelHoraDiaVisita = new horadiavisita( );
        
        /** crida al mètode que recupera la llista d'hores d'un dia de visita */
        $this->llistaHoresDiaVisita = $this->modelHoraDiaVisita->getLlistaHoresDiaVisita ( $idDiaVisita );
        
        /** crea l'objecte departament */
        $this->modelDepartament = new departament();
        
        /** crida al mètode que recupera la llista de departaments */
        $this->llistaDepartaments = $this->modelDepartament->getLlistaDepartaments ( );

        /** crida al mètode que recupera el departament indicat */
        $this->departament = $this->modelDepartament->getDepartmentById( $this->diaVisita['idDepartament'] );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'visitdayview.php';          

    }


    /** 
     * Estableix la vista per modificar el dia de visita.
     * @access private
     */
    private function viewVisitDay ( ) {      

        if ( filter_has_var ( INPUT_POST, 'idModificar' ) ) {  /** si s'ha sel·leccionat el dia de visita */
            
            /** crea el model per l'objecte detall del dia de visita */
            $this->modelHoraDiaVisita = new horadiavisita ( );

            /** crida al mètode que recupera la llista de detalls del dia de visita */
            $this->llistaHoresDiaVisita = $this->modelHoraDiaVisita->getLlistaHoresDiaVisita ( filter_input ( INPUT_POST, 'idModificar' )  );

            /** cria al mètode que mostra el dia de visita */
            $this->showVisitDay( filter_input ( INPUT_POST, 'idModificar' ) );

        }

    }

    /** 
     * Desa les dades d'un dia de vista
     * @access private
     */    
    private function saveVisitDay ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );
        
        /** Executa el mètode Insert */
        $this->insertVisitDay ( );
        
    }
 
    /** Estableix el valors d'un dia de visita enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {
        
        $this->dataVisita = $this->modelDiaVisita->link->real_escape_string( filter_input ( INPUT_POST, 'dataVisita' ) );
        $this->idDepartament = $this->modelDiaVisita->link->real_escape_string( filter_input ( INPUT_POST, 'idDepartament' ) );
        
    }    
    
    /** 
     * Afegeix un dia de visita
     * @access private
     */    
    private function insertVisitDay ( ) {

        $this->idPlanillaVisita = $this->modelDiaVisita->link->real_escape_string( filter_input ( INPUT_POST, 'idPlanillaVisita' ) );

        /**  @var string $currentDate Conté la data i hora actuals */
        $currentDate = date_format ( date_create ( "" ) , 'YmdHi' );
        
        /**  @var string $randomString Conté una cadena de caràcters barrejada aleatoriament */
        $randomString = str_shuffle ( 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789!$/()*' );
        
        /* forma un valor aleatori que servirà de token únic */
        $this->token = str_shuffle ( $randomString . $currentDate );

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . date_format ( date_create ( str_replace ( "/" , "-" , $this->dataVisita ) ) , 'Y-m-d' )  . "'," . $this->idDepartament . ",'" . $this->token . "'";
        
        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir un dia de visita */
            $ret = $this->modelDiaVisita->afegeixDiaVisita ( $fields );
        
        }

        if ( !$ret ) { /** si s'ha produït un error */
            
            /** Recupera el número d'error */
            $errTitle = 'Error (' . $this->modelDiaVisita->link->errno . ')';
            
            /** Recupera el missatge d'error */
            $errMessage = $this->modelDiaVisita->link->error;

            /** Crida a la función que la finestra modal amb l'error */
            $this->setError ( $errTitle, $errMessage );

            /** crida al mètode que mostra la llista de planilles visita */
            $this->viewList ( ); 
            
            
        } else {

        
            /** recupera el identificador de l'últim dia de visita afegit a la BBDD */
            $idDiaVisita = $this->modelDiaVisita->retornaUltimDiaVisitaAfegit ( );

            /** crea l'obecte hora del dia de visita */
            $this->modelHoraDiaVisita = new horadiavisita ( );

            /** crea l'objecte trams de la planilla de visita */       
            $this->modelTramsPlanillaVisita = new tramplanillavisita ( );

            /** recupera la llista de trams d'una planilla de visita */
            $this->tramPlanillaVisita  = $this->modelTramsPlanillaVisita->getLlistaTramsPlanillaVisita ( $this->idPlanillaVisita );

            foreach ( $this->tramPlanillaVisita as $dato ) { /** per cada hora del dia de visita */

                $fields = $idDiaVisita . ",'" . $dato["descripcioTramPlanillaVisita"] . "','" . $dato["horaEntrada"] ."','" . $dato["horaSortida"] . "'";

                if ( $fields != "" ) { /** si s'han omplert els camps */

                    /** executa el mètode per afegir una hora al dia de visita */
                    $ret = $this->modelHoraDiaVisita->afegeixHoraDiaVisita ( $fields );

                }            

            }
            
            if ( !$ret ) { /** si s'ha produït un error */

                /** Recupera el número d'error */
                $errTitle = 'Error (' . $this->modelHoraDiaVisita->link->errno . ')';

                /** Recupera el missatge d'error */
                $errMessage = $this->modelHoraDiaVisita->link->error;

                /** Crida a la función que la finestra modal amb l'error */
                $this->setError ( $errTitle, $errMessage );

                /** crida al mètode que mostra la llista de dies de visita */
                $this->viewList ( );                 

            }  else {   
                /** cria al mètode que mostra la el dia de visita */
                $this->showVisitDay( $idDiaVisita );
            }
            
        }
        
    }
    
    /** 
     * Esborra el dia de visitat sel·leccionat.
     * @access private
     */    
    private function deleteVisitDay ( ) {

        if ( ( filter_has_var ( INPUT_POST, 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST, 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat un dia de visita crida al mètode per esborrar-lo */
            
            /** crea l'obecte hora d'un dia de visita */
            $this->modelHoraDiaVisita = new horadiavisita ( );
            
            /** crida al mètode que recupera la llista d'hores d'un dia de visita */
            $this->horaDiaVisita = $this->modelHoraDiaVisita->getLlistaHoresDiaVisita (  filter_input ( INPUT_POST, 'idEliminar' ) );        
            
            /** crea l'obecte visita */
            $this->modelVisita = new visita ( );

            foreach ( $this->horaDiaVisita as $dato ) { /** per cada hora del dia de visita */
                
                /** executa al mètode que esborra l'hoa del dia de la visita sel·leccionada */
                $ret = $this->modelVisita->esborraVisitaById ( $dato["idHoraDiaVisita"] );

            }

            if ( !$ret ) { /** si s'ha produït un error */

                /** Recupera el número d'error */
                $errTitle = 'Error (' . $this->modelVisita->link->errno . ')';

                /** Recupera el missatge d'error */
                $errMessage = $this->modelVisita->link->error;

                /** Crida a la función que la finestra modal amb l'error */
                $this->setError ( $errTitle, $errMessage );

            }  else {   

                foreach ( $this->horaDiaVisita as $dato ) { /** per cada hora del dia de visita */
                    
                    /** executa al mètode que esborra l'hoa del dia de la visita sel·leccionada */
                    $ret = $this->modelHoraDiaVisita->esborraHoraDiaVisita ( $dato["idHoraDiaVisita"] );

                }                
                
                if ( !$ret ) { /** si s'ha produït un error */

                    /** Recupera el número d'error */
                    $errTitle = 'Error (' . $this->modelHoraDiaVisita->link->errno . ')';

                    /** Recupera el missatge d'error */
                    $errMessage = $this->modelHoraDiaVisita->link->error;

                    /** Crida a la función que la finestra modal amb l'error */
                    $this->setError ( $errTitle, $errMessage );

                } else {
                
                    /** executa el mètode per esborrar un dia visita */
                    $ret = $this->modelDiaVisita->esborraDiaVisita( filter_input ( INPUT_POST, 'idEliminar' ) );

                    if ( !$ret ) { /** si s'ha produït un error */

                       /** Recupera el número d'error */
                       $errTitle = 'Error (' . $this->modelDiaVisita->link->errno . ')';

                       /** Recupera el missatge d'error */
                       $errMessage = $this->modelDiaVisita->link->error;

                       /** Crida a la función que la finestra modal amb l'error */
                       $this->setError ( $errTitle, $errMessage );
                    }

               }           
            }
            
            /** crida al mètode que mostra la llista visites */
            $this->viewList ( );
            
        }

    }
    
    /** 
      * Genera la finestra modal amb l'error.
      * @access private
      */    
    private function setError ( $errTitle, $errMessage ) {
        
            /** estableix la condició per mostrar la pantalla modal */
            $this->showModal = true;
            
            /** crea el objecte per mostrar la finestra modal */
            $this->objecteModalWindow = new modalwindow (  $errTitle, $errMessage );
        
    }
    
}
?>