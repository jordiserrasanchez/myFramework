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
 * Filename ajaxlopdcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxlopdcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxconceptscontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxlopdcontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var string $concepte Conté l'objecte lopd */
    private $lopd;
    
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
    public function __construct() {

        if ( !filter_has_var( INPUT_GET, 'page' ) ) {  /** si no hi ha establerta una pàgina */
            
            $this->page = 1;
        
        } else {
            
            $this->page = filter_input( INPUT_GET, 'page' );
        
        }
        
        /** crea l'objecte de lopd */
        $this->model = new lopd ( );

        /** executa el mètodo que recupera el número de registres */
        $this->numRows = $this->model->retornaNumeroRegistres ( );
                
        if ( $this->numRows['TotalRegistres'] > 0 ) {/** si hi han conceptes */
            $this->tpages = ceil ( $this->numRows['TotalRegistres'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ($this->page - 1) * $this->rowsPerPage;
        $this->order = "dataRegistre desc";
        
        /** crida al mètode que recupera la llista de registres */
        $this->concepte = $this->model->getLlistaRegistres ( $this->offset . ', ' . $this->rowsPerPage , $this->order );
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
        $html.= '            <th>idLopd</th>';
        $html.= '            <th>idUsuari</th>';
        $html.= '            <th>tipusAccio</th>';
        $html.= '            <th>txtTipusAccio</th>';
        $html.= '            <th>resultatAccio</th>';
        $html.= '            <th>txtResultatAccio</th>';
        $html.= '            <th>idModul</th>';
        $html.= '            <th>txtModul</th>';
        $html.= '            <th>Observacions</th>';
        $html.= '            <th>dataRegistre</th>';
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                foreach ( $this->concepte as $dato ) { /** per cada registre */
        $html.= '        <tr>';
        $html.= "            <td>" . $dato["idLopd"] . "</td>";
        $html.= "            <td>" . $dato["idUsuari"] . "</td>";
        $html.= "            <td>" . $dato["tipusAccio"] . "</td>";
        $html.= "            <td>" . $dato["txtTipusAccio"] . "</td>";
        $html.= "            <td>" . $dato["resultatAccio"] . "</td>";
        $html.= "            <td>" . $dato["txtResultatAccio"] . "</td>";
        $html.= "            <td>" . $dato["idModul"] . "</td>";
        $html.= "            <td>" . $dato["txtModul"] . "</td>";
        $html.= "            <td>" . $dato["observacions"] . "</td>";
        $html.= "            <td>" . date_format ( date_create ( $dato["dataRegistre"] ) , 'd/m/Y H:i:s' ) . "</td>";
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
