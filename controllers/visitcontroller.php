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
 * Filename visitcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe visitcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package visitcontroller
 * @subpackage visites
 * @version 1.0.0
 */
final class visitcontroller extends controller {

    /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $model Conté el model den la visita*/
    private $modelVisita;
    
    /**  @var string $llistaHoresVisita Conté la llista d'hores de visita */    
    public $llistaHoresVisita;    

    /**  @var string $nomResident Conté els nom del resident */    
    public $nomResident;
    
    /**  @var string $nomVisitant Conté el nom del visitant */    
    public $nomVisitant;
    
    /**  @var integer $idHoraDiaVisita Conté el idenditicador de l'hora del dia de visita */    
    public $idHoraDiaVisita;
    
    /**  @var string $concepte Conté l'objecte departament */    
    public $departament;
    
    /**  @var string $modelDepartament Conté el model del departament */
    public $modelDepartament;

    /**  @var string $modelDiaVisita Conté el model del dia de visita */
    public $modelDiaVisita;
    
    /**  @var string $diaVisita Conté el dia de visita*/
    public $diaVisita;
    
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
                    $this->editVisit ( );
                break;
            case "New":
                    $this->newVisit ( );
                break;
            case "Save":
                    $this->saveVisit ( );
                break;
            case "Delete":
                    $this->deleteVisit ( );
                break;
            case "Schedule":
                    $this->viewForm ( );
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
        
        /** crea l'objecte del model de la visita */
        $this->modelVisita = new visita ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de visites i la vista a mostrar.
      * @access private
      */
    private function viewList ( ) {
        
        if ( filter_has_var ( INPUT_POST , 'idAgendar' ) ) {
        
            /** crida al mètode que recupera la llista de visites */
            $this->llistaHoresVisita = $this->modelVisita->getLlistaVisites ( filter_input ( INPUT_POST , 'idAgendar' ), null , null, null );
            
            /** crea l'objecte del model del dia de visita */
            $this->modelDiaVisita = new diavisita ( );
            
            /** carrgea el dia de visita */
            $this->diaVisita = $this->modelDiaVisita->getDiaVisitaById ( filter_input ( INPUT_POST , 'idAgendar' ) ); 

            /** crea l'objecte del model del departament */
            $this->modelDepartament = new departament ( );

            /** carrega el departament */
            $this->departament = $this->modelDepartament->getDepartmentById ( $this->diaVisita["idDepartament"] );

            $this->showModal = true;
            
            /** estableix la vista que s'ha de mostrar */
            $this->view = $_SESSION["viewPath"] . 'visitview.php';
        
        }
    }

    /** 
      * Estableix una matriu associativa amb la llista de visites i la vista a mostrar.
      * @access private
      */
    private function viewForm ( ) {
        
        if ( filter_has_var ( INPUT_GET , 'token' ) ) { /** si arriab el token */

            /** crea l'objecte del model del dia de visita */
            $this->modelDiaVisita = new diavisita ( );
            
            /** carrega el dia de visita */
            $this->diaVisita = $this->modelDiaVisita->getDiaVisitaByToken ( filter_input ( INPUT_GET , 'token' ) ); 
            
            /** recupera la data de visita */
  //          $dataVisita =  date($this->diaVisita['dataVisita']);
            
            /** crida al mètode que recupera la llista de visites */
            $this->llistaHoresVisita = $this->modelVisita->getLlistaVisites ( $this->diaVisita["idDiaVisita"], "free" , null, "horaEntrada, descripcioHoraDiaVisita asc" );

            /** crea l'objecte del model del departament */
            $this->modelDepartament = new departament ( );
            
            /** carrega el departament */
            $this->departament = $this->modelDepartament->getDepartmentById ( $this->diaVisita["idDepartament"] );
            
            /** data del dia de demà */
//            $dema = date ('Y-m-d', strtotime ( '+1 day' , strtotime ( date('Y-m-d') ) ) );
            
            /** estableix la vista que s'ha de mostrar */
//            if ( $dataVisita > $dema ) { /* si la reserva s'esta fent amb 24 hores d'antelació */
                
                $this->view = $_SESSION["viewPath"] . 'visitform.php';
                
//            } else {
                
//                $this->view = $_SESSION["viewPath"] . 'visitexpired.php';
                
//            }   
        }
    }
       
    /** 
      * Estableix la vista per crear una visita.
      * @access private
      */
    private function newVisit ( ) {
        
        /** crida a la preparació la vista de la fitxa del departament */
        $this->viewVisit ( );

    }
    
    /** 
      * Desa les dades de l'objecte.
      * @access private
      */
    private function saveVisit ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );

        if ( ( filter_has_var ( INPUT_POST , 'idVisita' ) ) && ( ( filter_input ( INPUT_POST , 'idVisita' ) ) != "" ) ) { /** si s'ha sel·leccionat una viista executa el mètode Update */
            
            
            $this->updateVisit ( filter_input ( INPUT_POST , 'idVisita' ) );
        
            
        } else { /** si no hi ha objecte sel·leccionat executa el mètode Insert */
            
            $this->insertVisit ( );
        
        }        
    }
    
    /** Estableix el valors d'un tipus d'acció enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {

        $this->nomResident = $this->modelVisita->link->real_escape_string( filter_input ( INPUT_POST , 'nomResident' ) );
        $this->nomVisitant = $this->modelVisita->link->real_escape_string( filter_input ( INPUT_POST , 'nomVisitant' ) );
        $this->idHoraDiaVisita = $this->modelVisita->link->real_escape_string( filter_input ( INPUT_POST , 'idHoraDiaVisita' ) );
        $this->idDiaVisita = $this->modelVisita->link->real_escape_string( filter_input ( INPUT_POST , 'idDiaVisita' ) );

    }
    
    /** 
      * Inserta una visita a la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function insertVisit ( ) {
    
        /**  @var string $fields Conté els camps per la consulta */
        $fields = $this->idHoraDiaVisita . ",'" . $this->nomResident . "','" . $this->nomVisitant . "'";
    
        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir una visita nou */
            $ret = $this->modelVisita->afegeixVisita ( $fields );
            
        }           

        if ( !$ret ) { /** si s'ha produït un error */
            /** Recupera el número d'error */
           $errTitle = 'Error (' . $this->modelVisita->link->errno . ')';

           /** Recupera el missatge d'error */
           $errMessage = $this->modelVisita->link->error;

           /** Crida a la función que la finestra modal amb l'error */
           $this->setError ( $errTitle, $errMessage );

       }         

        if ( isset( $_SESSION["usuariAnonim"] ) ) { /* la demanada ve de l'exterior */
            
            
            /** crea l'objecte del model del dia de visita */
            $this->modelDiaVisita = new diavisita ( );
            
            /** carrgea el dia de visita */
            $this->diaVisita = $this->modelDiaVisita->getDiaVisitaById ( $this->idDiaVisita ); 

            /** crea l'objecte del model del departament */
            $this->modelDepartament = new departament ( );

            /** carrega el departament */
            $this->departament = $this->modelDepartament->getDepartmentById ( $this->diaVisita["idDepartament"] );

			
			$this->llistaHoresVisita = $this->modelVisita->getLlistaVisitesById ( $this->idHoraDiaVisita );
			
            /** estableix la vista que s'ha de mostrar */
            $this->view = $_SESSION["viewPath"] . 'visitconfirm.php';
            
        } else {      
            
            /** crida al mètode que mostra la llista de visites */
            $this->viewList ( );
        }
            
    
    }
      
    /** 
      * Esborra una viita de la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function deleteVisit ( ) {
        
        if ( ( filter_has_var ( INPUT_POST , 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST , 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat una visita crida al mètode per esborrar-la */
            
            /** executa el mètode per esborrar una visita */
            $ret = $this->modelVisita->esborraVisita( filter_input ( INPUT_POST , 'idEliminar' ) );
            
        }
        
        if ( !$ret ) { /** si s'ha produït un error */

           /** Recupera el número d'error */
           $errTitle = 'Error (' . $this->modelVisita->link->errno . ')';

           /** Recupera el missatge d'error */
           $errMessage = $this->modelVisita->link->error;

           /** Crida a la función que la finestra modal amb l'error */
           $this->setError ( $errTitle, $errMessage );

       }         
        
        /** crida al mètode que mostra la llista de visites */
        $this->viewList ( );
            
        
    }
       
}