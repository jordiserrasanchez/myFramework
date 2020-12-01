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
 * Filename groupscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe groupscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package groupscontroller
 * @subpackage groups
 * @version 1.0.0
 */
final class groupscontroller extends controller {
    
    /**  @var string $model Conté el model */
    private $model;
    
     /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $grup Conté l'objecte grup */
    public $grup;

    /**  @var string $model_det Conté el model del detall */
    private $model_det;
    
    /**  @var string $$grup_det Conté l'objecte detalls $grup */
    public $grup_det;

    /**  @var string $nomGrup Conté el nom del grup */    
    private $nomGrup;

    /**  @var integer $idGrup Conté el identificador del grup */    
    private $idGrup;

    /**  @var string $idUsuari  Conté el identificador de l'usuari */    
    private $idUsuari;
    
    /** @var string $usuari Conté el nom de l'usuari */
    public $usuari;
    
    /**  @var array $llistaUsuaris Conté una matriu associativa amb la llista d'usuaris existents a la bbdd */
    public $llistaUsuaris;    

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
                    $this->editGroup ( );
                break;
            case "EditDet":
                    $this->editGroupDet ( );
                break;
            case "New":
                    $this->newGroup ( );
                break;
            case "NewDet":
                    $this->newGroupDet ( );
                break;
            case "Save":
                    $this->saveGroup ( );
                break;
            case "SaveDet":
                    $this->saveGroupDet ( );
                break;
            case "Delete":
                    $this->deleteGroup ( );
                break;
            case "DeleteDet":
                     $this->deleteGroupDet( );
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
        
        /** crea l'objecte grup */
        $this->model = new grup ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de grups i la vista a mostrar.
      * @access private
      */ 
    private function viewList ( ) {
        
        /** crida al mètode que recupera la llista de grups */
        $this->grup = $this->model->getLlistaGrups ( );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'groupsview.php';        

    }


    /** 
      * Prepara la vista de la fitxa d'un grup.
      * @access private
      * @param integer $idGrup Valor del camp per la clàusula WHERE de SQL.
      */      
    private function viewGroup ( $idGrup ) {
       
        /** crida al mètode que recupera el grup indicat */
        $this->grup = $this->model->getGrupById ( $idGrup );
        
        /** crea l'objecte detall del grup */
        $this->model_det = new grup_det( );
            
        /** crida al mètode que recupera la llista de detealls del grups */
        $this->grup_det = $this->model_det->getLlistaGrups_det ( $idGrup );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'groupview.php';          

    }

    /** 
      * Prepara la vista de la fitxa del detall d'un grup.
      * @access private
      */  
    private function viewGroupDet ( ) {

        /** crea un nou objecte usuari */
        $usuari = new usuari ( );
        
        $order = 'cognoms asc';
        
        /** crida al mètode que recupera la llista d'usuaris */
        $this->llistaUsuaris = $usuari->getLlistaUsuaris ( null , $order );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'groupdetview.php';
         
    }

    /** 
     * Estableix la vista per modificar el grup.
     * @access private
     */
    private function editGroup ( ) {      

        if ( filter_has_var ( INPUT_POST, 'idModificar' ) ) {  /** si s'ha sel·leccionat grup */
            
            /** crea l'objecte detall del grup */
            $this->model_det = new grup_det ( );

            /** crida al mètode que recupera els detalls del grup indicat */
            $this->grup_det = $this->model_det->getLlistaGrups_det ( filter_input ( INPUT_POST, 'idModificar' )  );

            /** cria al mètode que mostra el grup */
            $this->viewGroup( filter_input ( INPUT_POST, 'idModificar' )  );

        }

    }

    /** 
     * Estableix la vista per modificar el detall d'un grup.
     * @access private
     */
    private function editGroupDet ( ) {      
        
        if ( filter_has_var ( INPUT_POST, 'idModificar' ) ) {  /** si s'ha sel·leccionat grup */

            /** crea l'objecte detall del grup */
            $this->model_det = new grup_det( );

            /** crida al mètode que recupera els detalls del grup indicat */
            $this->grup_det = $this->model_det->getDetallGrupById ( filter_input ( INPUT_POST, 'idModificar' )  );

            /** crea un nou objecte usuari */
            $usuari = new usuari ( );

            /** crida al mètode que recupera la política indicada */
            $this->usuari = $usuari->getUsuariById ( $this->grup_det['idUsuari'] );
            
            /** cria al mètode que mostra el detall del grup */
            $this->viewGroupDet ( );
        }

    }

    /** 
      * Estableix la vista per crear un grup.
      * @access private
      */
    private function newGroup ( ) {
        
        $this->view = $_SESSION["viewPath"] . 'groupview.php';        
    
    }
    
    /** 
      * Estableix la vista per crear el detall d'un grup.
      * @access private
      */
    private function newGroupDet ( ) {

        if ( filter_has_var ( INPUT_POST, 'idMaster' ) ) {  /** si s'ha sel·leccionat grup */
            
            /** crea l'objecte detall del grup */
            $this->model_det = new grup_det ( );

            $this->grup_det['idUsuari'] = "";
            $this->grup_det['idGrup_det']= "";
            $this->grup_det['idGrup'] = filter_input ( INPUT_POST, 'idMaster' ) ;

            /** cria al mètode que mostra el detall del grup */
            $this->viewGroupDet ( );
        }
 
    }
    
    /** 
     * Desa les dades d'un grup.
     * @access private
     */    
    private function saveGroup ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );
        
        if ( ( filter_has_var ( INPUT_POST, 'idGrup' ) ) && ( ( filter_input ( INPUT_POST, 'idGrup' ) ) != "" ) ) { /** si s'ha sel·leccionat un grup executa el mètode Update */
            
            $this->updateGroup ( filter_input ( INPUT_POST, 'idGrup' ) );
        
            
        } else {  /** si no hi ha grup sel·leccionat executa el mètode Insert */
            
            $this->insertGroup ( );
        
        }        
        
    }

    
    /** Estableix el valors d'un grup enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {
        
        $this->nomGrup = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'grup' ) );

    }    
    

    /** 
     * Afegeix un grup
     * @access private
     */    
    private function insertGroup ( ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->nomGrup  . "'";
        
        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir un grup */
            $this->grup = $this->model->afegeixGrup ( $fields );
        
        }
        
        /** recupera el identificador de l'últim grup afegit a la BBDD */
        $idGrup  = $this->model->retornaUltimGrupAfegit ( );

        /** cria al mètode que mostra el grup */
        $this->viewGroup( $idGrup );
        
    }
    
    /** 
     * Actualitza les dades d'un grup.
     * @access private
     * @param integer $idGrup Valor del camp per la clàusula WHERE de SQL.
     */      
    private function updateGroup ( $idGrup ) {

        $fields = "grup='" . $this->nomGrup  . "'";

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode  per actualitza  un grup */
            $this->grup = $this->model->modificaGrup ( $idGrup , $fields );

        }
        
        /** crida al mètode que mostra la llista de grups */
        $this->viewList ( ); 
    }

    /** 
     * Desa les dades del detall d'un grup.
     * @access private
     */     
    private function saveGroupDet ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getDetPostValues ( );
        
        if ( ( filter_has_var ( INPUT_POST, 'idGrup_det' ) ) && ( ( filter_input ( INPUT_POST, 'idGrup_det' ) ) != "" ) ) { /** si s'ha sel·leccionat un detall de grup executa el mètode Update */
            
            $this->updateGroupDet ( filter_input ( INPUT_POST, 'idGrup_det' ) );
        
            
        } else {  /** si no hi ha detall de grup sel·leccionat executa el mètode Insert */
            
            $this->insertGroupDet ( );
        
        }        
    }

    
    /** Estableix el valors d'un detall de grup enviats mitjançant un formulari.
      * @access private
      */
    private function getDetPostValues ( ) {

        $this->idGrup = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'idModificar' ) );
        $this->idUsuari = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'idUsuari' ) );

    }      
    
    /** 
     * Afegeix del detall d'un grup.
     * @access private
     */ 
    private function insertGroupDet ( ) {

        /** crea l'obecte detall del grup */
        $this->model_det = new grup_det ( );    

        $fields = $this->idGrup . "," . $this->idUsuari;;
        
        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa al mètode que afegeix el detall del grup sel·leccionat */
            $this->grup_det = $this->model_det->afegeixGrup_det ( $fields );
        }

        /** cria al mètode que mostra el grup */
        $this->viewGroup( $this->idGrup );
    }

    /** 
     * Actualitza les dades del detall d'un grup.
     * @access private
     * @param integer $idGrup_det Valor del camp per la clàusula WHERE de SQL.
     */      
    private function updateGroupDet ( $idGrup_det ) {

        /** crea l'obecte detall del grup */
        $this->model_det = new grup_det ( );

        $fields = "idUsuari=" . $this->idUsuari;

        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa al mètode que modifica el detall del grup sel·leccionat */
            $this->grup_det = $this->model_det->modificaGrup_det ( $idGrup_det , $fields );
            
        }

        /** cria al mètode que mostra el grup */
        $this->viewGroup( $this->idGrup );
        
    }
    
    /** 
     * Esborra el grup sel·leccionat.
     * @access private
     */    
    private function deleteGroup ( ) {

        if ( ( filter_has_var ( INPUT_POST, 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST, 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat un grup crida al mètode per esborrar-la */
            
            /** crea l'obecte detall del grup */
            $this->model_det = new grup_det ( );
            
            /** crida al mètode que recupera la llista de detalls del grup */
            $this->grup_det = $this->model_det->getLlistaGrups_det (  filter_input ( INPUT_POST, 'idEliminar' ) );        
            
            foreach ( $this->grup_det as $dato ) { /** per cada detall del grup */
                
                /** executa al mètode que esborra el detall del grup sel·leccionat */
                $this->model_det->esborraGrup_det( $dato["idGrup_det"] );
                
            }

            /** crea l'objecte permis */
            $modelPermis = new permis ( );

            /** esborra els permisos realcionats amb el grup */
            $ret = $modelPermis->esborraPermisosGrup (filter_input ( INPUT_POST, 'idEliminar' ) );
            
            /** executa el mètode per esborrar un grup */
            $this->grup = $this->model->esborraGrup( filter_input ( INPUT_POST, 'idEliminar' ) );
            
        }
        
        /** crida al mètode que mostra la llista de grups */
        $this->viewList ( );
        
    }
    
    /** 
      * Esborra el detall del grup sel·leccionat.
      * @access private
      */ 
    private function deleteGroupDet ( ) {

        if ( ( filter_has_var ( INPUT_POST, 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST, 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat un detall de grup crida al mètode per esborrar-la */

            /** crea l'obecte detall del grup */
            $this->model_det = new grup_det( );
            
            /** executa al mètode que esborra el detall del grup sel·leccionat */
            $this->grup_det = $this->model_det->esborraGrup_det( filter_input ( INPUT_POST, 'idEliminar' ) );

        }
        
        /** cria al mètode que mostra el grup */
        $this->viewGroup( filter_input ( INPUT_POST, 'idMaster' ) );

    }
    
}
?>