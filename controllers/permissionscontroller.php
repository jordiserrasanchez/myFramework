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
 * Filename permissionscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe permissionscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package permissionscontroller
 * @subpackage security
 * @version 1.0.0
 */
final class permissionscontroller extends controller {

    /**  @var string $model Conté el model */
    private $model;

    /**  @var string $action Conté l'acció a realitzar */
    private $action;

    /**  @var string $permis Conté l'objecte permis */
    public $permis;
    
    /**  @var string $nom Nom de l'usuari */
    private $nom;

    /**  @var string $cognoms Cognoms de l'usuari */
    private $cognoms;
    
    /**  @var array $usuari Conté la llista d'usuaris disponibles */
    public $usuaris;
    
    /**  @var array $grups Conté la llista de grups disponibles */
    public $grups;
    
    /**  @var string $mode Conté el mode en el que es mostrarà la vista*/
    public $mode;
    
    /** @var integer $tipus Conté el tipus de filtre */
    public $tipus;

    /**  @var string $modelgrup Conté el model del grup*/   
    private $modelgrup;
    
    /**  @var string $grup Conté l'objecte grup */
    public $grup;
    
    /**  @var string $modelusuari Conté el model de l'usuari */   
    private $modelusuari;
    
    /**  @var string $usuari Conté l'objecte usuari */
    public $usuari;

    /**  @var string $escollit Conté nom de l'escollit per editar (ja sigui grup o usuari) */
    public $escollit;

    /**  @var array $radioNames Conté nom dels botons radio del formulari */
    private $radioNames;
    
    
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
                    $this->viewList ( ); //OK
                break;
            case "Edit":
                    $this->editPermission ( ); //OK
                break;
            case "New":
                    $this->newPermission ( ); //OK
                break;
            case "Save":
                    $this->savePermission ( ); //TODO
                break;
            case "Delete":
                    $this->deletePermission ( ); //OK
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
        
        /** crea l'objecte permis */
        $this->model = new permis ( );
        
    }
    
    /** 
      * Estableix una matriu associativa amb la llista de permisos i la vista a mostrar.
      * @access private
      */
    private function viewList ( ) {
        
        /** crida al mètode que recupera la llista de permisos */
        $this->permis = $this->model->getLlistaPermisos ( );
        
        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'permissionsview.php';        
    }
    
    /** 
      * Prepara la vista de la fitxa del usuari.
      * @access private
      */    
    private function viewPermission ( ) {

        /** estableix la vista que s'ha de mostrar */
        $this->view = $_SESSION["viewPath"] . 'permissionview.php';        
        
    }
    
    
    /** 
      * Estableix la vista per editar un permís.
      * @access private
      */
    private function editPermission ( ) {

        if ( filter_has_var ( INPUT_POST, 'idModificar' ) ) {  /** si s'ha sel·leccionat permís */
            
            /** prepara la vista per modificar el registre */
            $this->mode = 'edit';
            
            
            if ( filter_has_var ( INPUT_POST, 'tipusModificar' ) ) {  /** si s'ha sel·leccionat permís */

                $this->tipus =  filter_input ( INPUT_POST, 'tipusModificar' ) ;

            }

            if ( $this->tipus == 1 ) { /** estic filtrant per grups */
                
                /** crea un nou objecte grup */
                $this->modelgrup = new grup ( ) ;

                /** recupera el grup */
                $this->grup = $this->modelgrup->getGrupById ( filter_input ( INPUT_POST, 'idModificar' ) );
                
                /** converteix a majúscules el nom del grup per mostrar-lo a pantalla */
                $this->escollit = strtoupper ( $this->grup['grup'] );
                

                
            } else {

                /** crea un nou objecte usuari */
                $this->modelusuari = new usuari ( ) ;
                
                /** recupera l'usuari */
                $this->usuari = $this->modelusuari->getUsuariById ( filter_input ( INPUT_POST, 'idModificar' ) );
                
                /* converteix a majúscules el nom i cognoms de l'usuari per mostrar-lo a pantalla */
                $this->escollit = strtoupper ( $this->usuari['cognoms'] . ', ' . $this->usuari['nom'] );

            }
                
            /** crida a la preparació la vista de la fitxa del permís */
            $this->viewPermission ( );        
            
        }
        
    }
    
    /** 
      * Estableix la vista per crear un permis.
      * @access private
      */
    private function newPermission ( ) {
        
        /** prepara la vista per modificar el registre */
        $this->mode = 'add';

        if ( filter_has_var( INPUT_POST, 'idElecccio' ) ) {  /** si hi ha establert un tipus */
            
            /** recupera el tipus */
            $this->tipus = filter_input( INPUT_POST, 'idElecccio' );
            
        }
                
        
        if ( $this->tipus == 1 ) { /** filtro per grups */

            $this->grups = $this->model->getLlistaGrupsDisponibles();

        } else {

            $this->usuaris = $this->model->getLlistaUsuarisDisponibles();

        }

        /** crida a la preparació la vista de la fitxa del permís */
        $this->viewPermission ( );

    }
    
    /** 
      * Desa les dades de l'usuari.
      * @access private
      */
    private function savePermission ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );

        if ( ( filter_has_var ( INPUT_POST, 'id' ) ) && ( ( filter_input ( INPUT_POST, 'id' ) ) != "" ) ) { /** si s'ha sel·leccionat usuari/grup executa el mètode Update */
            
            if ( filter_has_var ( INPUT_POST, 'tipus' ) ) {  /** si s'ha sel·leccionat permís */

                $this->tipus =  filter_input ( INPUT_POST, 'tipus' ) ;

            }

            if ( $this->tipus == 1 ) { /** filtro per grups */
                
                /** esborro els permisos actuals del grup */
                $this->model->esborraPermisosGrup ( filter_input ( INPUT_POST, 'id' ) );
                
            } else {
                
                /** esborro els permisos actuals de l'usuari */
                $this->model->esborraPermisosUsuari ( filter_input ( INPUT_POST, 'id' ) );
                
            }
            
            $this->updatePermission( filter_input ( INPUT_POST, 'id' ) );
       
            
        } else { /** si no hi ha usuari sel·leccionat executa el mètode Insert */
            
            $this->insertPermission ( filter_input ( INPUT_POST, 'id' ) );
        
        }        
        
    }
    
    /** Estableix el valors d'un usuari enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {
        
        $this->radioNames = $_POST['radioNames']; //filter_input_array ( INPUT_POST, 'radioNames',FILTER_NULL_ON_FAILURE  );
        
    }

    /** 
      * Inserta els permisos d'un usuari/grup a la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function insertPermission ( $id ) {
    
        foreach ( $this->radioNames as $radio ) {
            
            $varname = (string)$radio;
            
            //$valcontrol = filter_input ( INPUT_POST, $varname);
            
            if (isset($_POST[$radio])) {
                $valcontrol = $_POST[$radio];

                if ($valcontrol>0) {

                    /**  @var string $fields Conté els camps per la consulta */
                    $fields = $radio . "," . $this->tipus . "," . $id ."," . $valcontrol ;

                    if ( $fields != "" ) { /** si s'han omplert els camps */

                        $this->model->afegeixPermis( $fields );
                    }

                }
            }

        }    
        /** crida al mètode que mostra la llista d'usuaris */
        $this->viewList ( );
        
    }
    
    /** 
      * Actualitza else permisos d'un usuari/grup a la bbdd i estableix la vista a mostrar.
      * @access private
      * @param integer $id Valor del camp per la clàusula WHERE de SQL.
    */
    private function updatePermission ( $id ) {

        foreach ( $this->radioNames as $radio ) {
            
            $varname = (string)$radio;
            
            //$valcontrol = filter_input ( INPUT_POST, $varname);
            
            if (isset($_POST[$radio])) {
                $valcontrol = $_POST[$radio];

                if ($valcontrol>0) {

                    /**  @var string $fields Conté els camps per la consulta */
                    $fields = $radio . "," . $this->tipus . "," . $id ."," . $valcontrol ;

                    if ( $fields != "" ) { /** si s'han omplert els camps */

                        $this->model->afegeixPermis( $fields );
                    }

                }
            }

        }            

        /** crida al mètode que mostra la llista d'usuaris */
        $this->viewList ( );
        
    }
    
    /** 
      * Esborra els permisos del grup/usuari de la bbdd i estableix la vista a mostrar.
      * @access private
      */
    private function deletePermission ( ) {
        
        if ( ( filter_has_var ( INPUT_POST, 'idEliminar' ) ) && ( ( filter_input ( INPUT_POST, 'idEliminar' ) ) != "" ) ) { /** si s'ha sel·leccionat grup/usuari crida al mètode per esborrar-lo */
  
            if ( filter_has_var ( INPUT_POST, 'tipusEliminar' ) ) {  /** si s'ha sel·leccionat permís */

                $this->tipus =  filter_input ( INPUT_POST, 'tipusEliminar' ) ;

            }

            if ( $this->tipus == 1 ) { /** estic filtrant per grups */
                
                /** executa el mètode per esborrar els permisos d'un grup */
                $this->permis = $this->model->esborraPermisosGrup ( filter_input ( INPUT_POST, 'idEliminar' ) );
                
            } else {

                /** executa el mètode per esborrar els permisos d'un usuari */
                $this->permis = $this->model->esborraPermisosUsuari ( filter_input ( INPUT_POST, 'idEliminar' ) );
                
            }
            
        }
        
        /** crida al mètode que mostra la llista d'usuaris */
        $this->viewList ( );
        
    }
}
?>