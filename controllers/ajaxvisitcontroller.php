<?php
/** requereix el fitxer d'autocarga de clases  */
require_once ( '../include/autoload.php' );

/** requereix el fitxer amb les constants  */
require_once ( '../include/const.inc.php' );

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
 * Create at 24-sep-2020 12:54:55
 * Project name myFramework
 * Project DisplayName myFramework
 * Filename ajaxvisitcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxvisitcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxvisitcontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxvisitcontroller {
    
    /**  @var string $model Conté el model de la planilla visita*/
    private $modelVisita;
    
    /**  @var string $llistaPlanillesVisita Conté la llilsta de planilles visita */
    private $llistaVisita;
    
    /**  @var integer $action Conté l'acció */ 
    private $action;
    
    private $idHoraDiaVisita;
    
    private $idVisita;
    
    private $nomResident;
    
    private $nomVisitant;
    
    private $contenido;
    /** 
      * Inicialitza l'objecte.
      * @access public
      */    
    public function __construct() {

        if ( !filter_has_var( INPUT_POST, 'action' ) ) {  /** si no hi ha establerta una pàgina */
            
            $this->action = 'Cancel';
        
        } else {
            
            $this->action = filter_input( INPUT_POST, 'action' );
        
        }
        
        $this->idHoraDiaVisita = filter_input( INPUT_POST, 'idHoraDiaVisita' );

        /** crea el model per l'objecte de planilla visita */
        $this->modelVisita = new visita ( );
        
        $ret = true;
        $errTitle = '';
        $errMessage = '';
        switch ($this->action) {
            case 'Cancel':
                $this->llistaVisita =  $this->modelVisita->getLlistaVisitesById($this->idHoraDiaVisita);
                break;
            case 'Save':
                    $this->nomResident = filter_input( INPUT_POST, 'nomResident');
                    $this->nomVisitant = filter_input( INPUT_POST, 'nomVisitant');
                    if (filter_input( INPUT_POST, 'idVisita' ) != "" ) {  /** si la visita existeix */                
                        $this->idVisita =  filter_input( INPUT_POST, 'idVisita');
                        $ret = $this->modelVisita->modificaVisita($this->idVisita , "nomResident='".$this->nomResident."', nomVisitant='".$this->nomVisitant."'");
                    } else {
                        $ret = $this->modelVisita->afegeixVisita($this->idHoraDiaVisita.",'".$this->nomResident."', '".$this->nomVisitant."'");
                    }
                    
                    if (!$ret) {

                        /** Recupera el número d'error */
                        $errTitle = 'Error (' . $this->modelVisita->link->errno . ')';

                        /** Recupera el missatge d'error */
                        $errMessage = $this->modelVisita->link->error;                        
                    }                    
                    
                    $this->llistaVisita =  $this->modelVisita->getLlistaVisitesById($this->idHoraDiaVisita);
                break;
            case 'Delete':
                $this->llistaVisita =  $this->modelVisita->getLlistaVisitesById($this->idHoraDiaVisita);
                $ret = $this->modelVisita->esborraVisita($this->llistaVisita[0]['idVisita']);
                if ( $ret ) {
                    $this->llistaVisita =  $this->modelVisita->getLlistaVisitesById($this->idHoraDiaVisita);
                } else {
                    /** Recupera el número d'error */
                    $errTitle = 'Error (' . $this->modelVisita->link->errno . ')';

                    /** Recupera el missatge d'error */
                    $errMessage = $this->modelVisita->link->error;                        
                }
                break;
            
        }


        $this->contenido = array ();
        $this->contenido[0] = $this->llistaVisita[0]['idVisita'];
        $this->contenido[1] = $this->llistaVisita[0]['nomResident'];                
        $this->contenido[2] = $this->llistaVisita[0]['nomVisitant'];  
        $this->contenido[3] = $ret;
        $this->contenido[4] = $errTitle;
        $this->contenido[5] = $errMessage;
        
    } 
    
    



    

    /** 
    * Genera el contigut a mostrar
    * @return array Matriu JSON amb el contingut i l'objecte.
    * @access public
    */
    public function render ( ) {
        //var_dump($this->llistaVisita);
        

        return json_encode( $this->contenido);
    }
}


      