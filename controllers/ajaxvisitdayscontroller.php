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
 * Filename ajaxvisitdayscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxvisitdayscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxvisitdayscontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxvisitdayscontroller {
    
    /**  @var string $modelDiaVisita Conté el model de dies de visita*/
    private $modelDiaVisita;
    
    /**  @var string $llistaDiesVisita Conté la llista de dies de visita */
    private $llistaDiesVisita;
    
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
    
    private $modelDepartament;
    
    
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
        
        /** crea l'objecte del model del dia de visita*/
        $this->modelDiaVisita = new diavisita ( );

        /** executa el mètodo que recupera el número de dies de visita */
        $this->numRows = $this->modelDiaVisita->retornaNumeroDiesVisites ( );

        if ( $this->numRows['TotalDiesVisites'] > 0 ) { /** si hi han dies de visita */
             $this->tpages = ceil ( $this->numRows['TotalDiesVisites'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ( $this->page - 1 ) * $this->rowsPerPage;
        $this->order = "dataVisita desc";
        
        /** crida al mètode que recupera la llista de viatges */
        $this->llistaDiesVisita = $this->modelDiaVisita->getLlistaDiesVisites ( $this->offset . ', ' . $this->rowsPerPage , $this->order );
        
        $this->modelDepartament = new departament ( );
        
        
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
        $html.= '            <th colspan="3">Opcions</th>';
        $html.= '            <th style="display:none">idDiaVisita</th>';
        $html.= '            <th>Data Visita</th>';
        $html.= '            <th style="display:none">idDepartament</th>';
        $html.= '            <th>Departament</th>';
        $html.= '            <th>URL del dia de visita</th>';
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                foreach ( $this->llistaDiesVisita as $dato ) { /** per cada dia de visita */
        $html.= '        <tr>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=VisitDays&action=Delete" method="post">';
        $html.= "                    <input type=\"text\" name=\"idEliminar\" id=\"idEliminar\" value=\"" . $dato["idDiaVisita"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="eliminar" hidden>';
        $html.= "                    <button class=\"btn btn-danger btn-sm\" type=\"submit\" name=\"submit\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Eliminar el dia de visita i la seva programació\" onclick=\"return confirm('¿Estàs segur/a que vols eliminar aquest registre? \\n Totes les programacions relacionades tambè s\'esborraran.')\" ><i class=\"fa fa-trash-alt\"></i></button>";
        $html.= '                </form>';
        $html.= '            </td>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=VisitDays&action=View" method="post">';
        $html.= "                    <input type=\"text\" name=\"idModificar\" id=\"idModificar\" value=\"" . $dato["idDiaVisita"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="modificar" hidden>';
        $html.= '                    <button class="btn btn-warning btn-sm" type="submit" name="submit" data-toggle="tooltip" data-placement="top" title="Veure la configuració del dia de visita" onclick="return confirm(\'¿Estàs segur/a que vols veure aquest registre?\')" ><i class="far fa-eye"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';          
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Visit&action=ViewList" method="post">';
        $html.= "                    <input type=\"text\" name=\"idAgendar\" id=\"idAgendar\" value=\"" . $dato["idDiaVisita"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="agendar" hidden>';
        $html.= "                    <button class=\"btn btn-info btn-sm\" type=\"submit\" name=\"submit\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Accedir a la programació del dia de visita\" onclick=\"return confirm('¿Estàs segur/a que vols veure la programació d\'aquest registre?')\" ><i class=\"far fa-clock\"></i></button>";
        $html.= '                </form>';
        $html.= '            </td>'; 
        $html.= "            <td  style='display:none'>" . $dato["idDiaVisita"] . "</td>";
        $html.= "            <td>" . date_format ( date_create ( $dato["dataVisita"] ) , 'd/m/Y' ) . "</td>";
        $html.= "            <td style=\"display:none\">" . $dato["idDepartament"] . "</td>";
        $html.= "            <td>" . $this->modelDepartament->getDepartmentById($dato["idDepartament"])['descripcioDepartament'] . "</td>";       
        $html.= "            <td class=\"text-wrap\">" . _HOST_ .  "index.php?controlador=Visit&action=Schedule&token=" . $dato["token"] . "</td>";
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
