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
 * Filename userscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe userscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package userscontroller
 * @subpackage security
 * @version 1.0.0
 */
final class userscontroller extends controller {

    /**  @var string $model Conté el model */
    private $model;

    /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $usuari Conté l'objecte usuari */
    public $usuari;
    
    /**  @var string $nom Nom de l'usuari */
    private $nom;

    /**  @var string $cognoms Cognoms de l'usuari */
    private $cognoms;
    
    /**  @var string $correu Correu de l'usuari */
    private $correu;
    
    /**  @var string $paraulaPas Paruula de pas*/
    private $paraulaPas;
    
    /**  @var integer $correuConfirmat Indica si s'ha confirmat el correu */
    private $correuConfirmat;
    
    /**  @var integer $noCaduca Indica si la paruala de pas no caduca */
    private $noCaduca;
    
    /**  @var integer $noBloqueja Indica si el compte no es bloqueja */
    private $noBloqueja;
    
    /**  @var integer $canviInici Indica si cal canviar la paraula de pas al iniciar la sessió */
    private $canviInici;
   
    /**  @var integer $intents Conté el número de intents erronis acumulats */
    private $intents;    

    /**  @var integer $idPolitica Conté el identificador de la política que afecta al usuari */
    private $idPolitica;

    /**  @var string $politica Conté el el nom de la política que afecta al usuari */
    public $politica;
    
    /**  @var array $llistaPolitiques Conté una matriu associativa amb la llista de polítiques existents a la bbdd */
    public $llistaPolitiques;

    /** @var object $modelParaula Objecte que conté el model d'acces a la bbdda per les paraules de pas */
    private $modelParuala;
    
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
                    $this->editUser ( );
                break;
            case "New":
                    $this->newUser ( );
                break;
            case "Save":
                    $this->saveUser ( );
                break;
            case "Delete":
                    $this->deleteUser ( );
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
        
        /** crea l'objecte usuari */
        $this->model = new usuari ( );
        
        /** crea l'objecte paraulapas */
        $this->modelParuala = new paraulapas ( );
    }
    
    /** 
      * Estableix una matriu associativa amb la llista d'usuaris i la vista a mostrar.
      * @access private
      */
    private function viewList ( ) {
        
        /** crida al mètode que recupera la llista d'usuaris */
        $this->usuari = $this->model->getLlistaUsuaris ( );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'usersview.php';        
    }
    
    /** 
      * Prepara la vista de la fitxa del usuari.
      * @access private
      */    
    private function viewUser ( ) {

        /** crea un nou objecte politica */
        $politica = new politica ( );
        
        $order = 'politica asc';
        
        /** crida al mètode que recupera la llista de politiques */
        $this->llistaPolitiques = $politica->getLlistaPolitiques ( null , $order );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'userview.php';        
        
    }
    
    
    /** 
      * Estableix la vista per editar un usuari.
      * @access private
      */
    private function editUser ( ) {

        if ( filter_has_var ( INPUT_POST, 'idModificar' ) ) {  /** si s'ha sel·leccionat usuari */
            
            /** crida a la preparació la vista de la fitxa del usuari */
            $this->viewUser ( );
            
            /** crida al mètode que recupera l'usuari indicat */
            $this->usuari = $this->model->getUsuariById ( filter_input ( INPUT_POST, 'idModificar' ) );
            
            /** crea un nou objecte politica */
            $politica = new politica ( );

            /** crida al mètode que recupera la política indicada */
            $this->politica = $politica->getPoliticaById ( $this->usuari['idPolitica'] );
            
        }
        
    }
    
    /** 
      * Estableix la vista per crear un usuari.
      * @access private
      */
    private function newUser ( ) {
        
        /** crida a la preparació la vista de la fitxa del usuari */
        $this->viewUser ( );

    }
    
    /** 
      * Desa les dades de l'usuari.
      * @access private
      */
    private function saveUser ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );

        if ( ( filter_has_var ( INPUT_POST, 'idUsuari' ) ) && ( ( filter_input ( INPUT_POST, 'idUsuari' ) ) != "" ) ) { /** si s'ha sel·leccionat usuari executa el mètode Update */
            
            
            $this->updateUser( filter_input ( INPUT_POST, 'idUsuari' ) );
        
            
        } else { /** si no hi ha usuari sel·leccionat executa el mètode Insert */
            
            $this->insertUser ( );
        
        }        
        
    }
    
    /** Estableix el valors d'un usuari enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {
        
        $this->nom = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'nom' ) );
        $this->cognoms = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'cognoms' ) );
        $this->correu = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'correu', FILTER_VALIDATE_EMAIL ) );
        $this->paraulaPas = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'paraulaPas' ) );
        $this->correuConfirmat = ( $this->model->link->real_escape_string( filter_has_var ( INPUT_POST, 'correuConfirmat' ) ) )?1:0;
        $this->noCaduca = ( $this->model->link->real_escape_string( filter_has_var ( INPUT_POST, 'noCaduca' ) ) )?1:0;
        $this->noBloqueja = ( $this->model->link->real_escape_string( filter_has_var ( INPUT_POST, 'noBloqueja' ) ) )?1:0;
        $this->canviInici = ( $this->model->link->real_escape_string( filter_has_var ( INPUT_POST, 'canviInici' ) ) )?1:0;
        $this->intents = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'intents' ) );
        $this->idPolitica = $this->model->link->real_escape_string( filter_input ( INPUT_POST, 'idPolitica' ) );
        
    }

    /** 
      * Inserta un usuari a la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function insertUser ( ) {
    
        /**  @var string $fields Conté els camps per la consulta */
        $fields = "'" . $this->nom . "','" . $this->cognoms . "','" . $this->correu ."'," . $this->correuConfirmat . "," . $this->noCaduca . "," . $this->noBloqueja . "," . $this->canviInici . "," . $this->intents . "," . $this->idPolitica;

        if ( $fields != "" ) { /** si s'han omplert els camps */
            
            /** executa el mètode per afegir un usuari nou */
            $this->usuari = $this->model->afegeixUsuari ( $fields );
            
        }                        
        
        /** recupera el identificador del últim usuari afegit a la bbdd */
        $idUsuari = $this->model->retornaUltimUsuariAfegit ( );
        
        /** genera un hash per la paraula de pas escollida */
        $newPasswordEncrypted = password_hash ( $this->paraulaPas, PASSWORD_BCRYPT );
        
        $dataPasword = date( "Y-m-d H:i:s" );
        
        $fields = $idUsuari . ",'";

        $fields = $fields . $newPasswordEncrypted . "','" . $dataPasword . "'";
        
        /** afegeix la paraula de pas a la bbdd */
        $this->modelParuala->afegeixParaula( $fields );
        
        /** crida al mètode que mostra la llista d'usuaris */
        $this->viewList ( );
        
    }
    
    /** 
      * Actualitza un usuari a la bbdd i estableix la vista a mostrar.
      * @access private
      * @param integer $idUsuari Valor del camp per la clàusula WHERE de SQL.
    */
    private function updateUser ( $idUsuari ) {

        /**  @var string $fields Conté els camps per la consulta */
        $fields = "nom='" . $this->nom . "',cognoms='" . $this->cognoms . "',correu='" . $this->correu . "' ,correuConfirmat=" . $this->correuConfirmat . ",noCaduca=" . $this->noCaduca . ",noBloqueja=" . $this->noBloqueja . ",canviInici=" . $this->canviInici . ",intents=" . $this->intents . ",idPolitica=" . $this->idPolitica;

        if ( $fields != "" ) {  /** si s'han omplert els camps */
            
            /** executa el mètode per actualitzar un usuari */
            $this->usuari = $this->model->modificaUsuari ( $idUsuari, $fields );
        
        }

        if( $this->paraulaPas <> '' ) { /** si s'ha omplert el camp de la paraula de pas */
            
            /** genera un hash per la paraula de pas escollida */
            $newPasswordEncrypted = password_hash ( $this->paraulaPas, PASSWORD_BCRYPT );

            $dataPasword = date( "Y-m-d H:i:s" );
        
            /**  @var string $fields Conté els camps per la consulta */
            $fields = $idUsuari . ",'";

            $fields = $fields . $newPasswordEncrypted . "','" . $dataPasword . "'";            
            
            /** afegeix la paraula de pas a la bbdd */
            $this->modelParuala->afegeixParaula ( $fields );
        
        } 

        /** crida al mètode que mostra la llista d'usuaris */
        $this->viewList ( );
        
    }
    
    /** 
      * Esborra un usuari de la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function deleteUser ( ) {
        
        if ( ( filter_has_var ( INPUT_POST, 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST, 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat usuari crida al mètode per esborrar-lo */
            
            /** executa el mètode per esborrar un usuari */
            $this->usuari = $this->model->esborraUsuari ( filter_input ( INPUT_POST, 'idEliminar' ) );
            
        }
        
        /** crida al mètode que mostra la llista d'usuaris */
        $this->viewList ( );
        
    }
}
?>