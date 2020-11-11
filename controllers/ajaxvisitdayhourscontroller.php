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
 * Create at 30-ene-2020 12:54:55
 * Project name myFramework
 * Project DisplayName myFramework
 * Filename ajaxvisitdayhourscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxvisitdayhourscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxvistdayhourscontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxvisitdayhourscontroller {
    
    /**  @var string $model Conté el model de l'hora del dia de visita */
    private $modelHoraDiaVisita;
    
    /**  @var string $llistaHoresDiaVisita Conté la llista d'hores del dia de visita */
    private $llistaHoresDiaVisita;
    
    /**  @var string $paginacion Conté l'objecte paginació */ 
    private $paginacion;
    
    /**  @var integer $numRows Conté el número de files */ 
    private $numRows;
    
    /**  @var integer $page Conté la pàgina actual */ 
    private $page;
    
    /**  @var integer $tpages Conté el número total de pàgines */ 
    private $tpages;
    
    /**  @var integer $offset Conté el desfase acumaulat */ 
    private $offset;
    
    /**   @var string $order Conté el ordre de la llista */  
    private $order;
    
    /**  @var integer $rowsPerPage Conté el número de files per pàgina */ 
    private $rowsPerPage;
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */    
    public function __construct ( ) {

        if ( !filter_has_var( INPUT_GET, 'page' ) ) {  /** si no hi ha establerta una pàgina */
            
            $this->page = 1;
        
        } else {
            
            $this->page = filter_input( INPUT_GET, 'page' );
        
        }

        $idDiaVisita = filter_input( INPUT_GET, 'idDiaVisita' );
        
        /** crea l'objecte hores del dia de visita */
        $this->modelHoraDiaVisita = new horadiavisita ( );
        
        /** executa el mètodo que recupera el número d'hores d'un dia de visites */
        $this->numRows = $this->modelHoraDiaVisita->retornaNumeroHoresDiaVisita ( $idDiaVisita );

        if ( $this->numRows['TotalHoresDiaVisita']>0 ) { /** si hi han hores de visita */
            
            $this->tpages = ceil ( $this->numRows['TotalHoresDiaVisita'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ( $this->page - 1 ) * $this->rowsPerPage;
        $this->order = "horaEntrada, descripcioHoraDiaVisita asc";
        
        /** crida al mètode que recupera la llista d'hores d'un dia de visita */
        $this->llistaHoresDiaVisita = $this->modelHoraDiaVisita->getLlistaHoresDiaVisita ( $idDiaVisita , $this->offset . ', ' . $this->rowsPerPage , $this->order );
    }
    
      /** 
      * Genera el contigut a mostrar
      * @return array Matriu JSON amb el contingut i l'objecte.
      * @access public
      */   
    public function render ( ) {
        $html= '<table id="table" class="table table-sm table-bordered table-hover table-striped" style="width: auto; white-space: nowrap;">';
        $html.= '  <thead class="thead-dark">';
        $html.= '        <tr>';
        $html.= '            <th style="display:none">idHoraDiaVisita</th>';
        $html.= '            <th style="display:none">idDiaVisita</th>';
        $html.= '            <th>Descripció de l\'hora de visita</th>';
        $html.= '            <th>Hora d\'entrada</th>';
        $html.= '            <th>Hora de sortida</th>';
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                $dtotal = 0;
                foreach ( $this->llistaHoresDiaVisita as $dato ) { /** per cada detall de viatge */
        $html.= '        <tr>';
        $html.= "            <td  style='display:none'>" . $dato["idHoraDiaVisita"] . "</td>";
        $html.= "            <td  style='display:none'>" . $dato["idDiaVisita"] . "</td>";
        $html.= "            <td>" . $dato["descripcioHoraDiaVisita"] . "</td>";
        $html.= "            <td class='text-center'>" . date_format ( date_create ( $dato["horaEntrada"]  ?? "" ) , 'H:i' ) . "</td>";
        $html.= "            <td class='text-center'>" . date_format ( date_create ( $dato["horaSortida"]  ?? "" ) , 'H:i' ) . "</td>";
        $html.= '        </tr>';
                }
        $html.= '    </tbody>';

        $html.= '</table>';

        return json_encode(
            array(
                'contenido' => $html,
                'paginas' => $this->paginacion
            )
        );
    }
}
