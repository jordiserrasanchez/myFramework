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
 * Filename ajaxvisittemplatescontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxvisittemplatescontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxvisittemplatecontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxvisittemplatescontroller {
    
    /**  @var string $model Conté el model de la planilla visita*/
    private $modelPlanillaVisita;
    
    /**  @var string $llistaPlanillesVisita Conté la llilsta de planilles visita */
    private $llistaPlanillesVisita;
    
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
        
        /** crea el model per l'objecte de planilla visita */
        $this->modelPlanillaVisita = new planillaVisita ( );

        /** executa el mètodo que recupera el número de planilles visita */
        $this->numRows = $this->modelPlanillaVisita->retornaNumeroPlanillesVisita ( );

        if ( $this->numRows['TotalPlanillesVisita'] > 0 ) { /** si hi han planilles visita */
             $this->tpages = ceil ( $this->numRows['TotalPlanillesVisita'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ( $this->page - 1 ) * $this->rowsPerPage;
        $this->order = "descripcioPlanillaVisita desc";
        
        /** crida al mètode que recupera la llista de planilles visita */
        $this->llistaPlanillesVisita = $this->modelPlanillaVisita->getLlistaPlanillesVisita ( $this->offset . ', ' . $this->rowsPerPage , $this->order );
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
        $html.= '            <th colspan="4">Opcions</th>';
        $html.= '            <th style="display:none">idPlanillaVisita</th>';
        $html.= '            <th>Descripció de la planilla de visita</th>';
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                foreach ( $this->llistaPlanillesVisita as $dato ) { /** per cada planilla visita */
        $html.= '        <tr>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=VisitTemplates&action=Delete" method="post">';
        $html.= "                    <input type=\"text\" name=\"idEliminar\" id=\"idEliminar\" value=\"" . $dato["idPlanillaVisita"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="eliminar" hidden>';
        $html.= '                    <button class="btn btn-danger btn-sm" type="submit" name="submit" data-toggle="tooltip" data-placement="top" title="Eliminar la planilla de visita" onclick="return confirm(\'¿Estàs segur/a que vols eliminar aquest registre?\')" ><i class="fa fa-trash-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=VisitTemplates&action=Edit" method="post">';
        $html.= "                    <input type=\"text\" name=\"idModificar\" id=\"idModificar\" value=\"" . $dato["idPlanillaVisita"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="modificar" hidden>';
        $html.= '                    <button class="btn btn-warning btn-sm" type="submit" name="submit" data-toggle="tooltip" data-placement="top" title="Modificar la planilla de visita" onclick="return confirm(\'¿Estàs segur/a que vols modificar aquest registre?\')" ><i class="fa fa-pencil-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';          
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=VisitTemplates&action=Clone" method="post">';
        $html.= "                    <input type=\"text\" name=\"idClonar\" id=\"idClonar\" value=\"" . $dato["idPlanillaVisita"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="clonar" hidden>';
        $html.= '                    <button class="btn btn-secondary btn-sm" type="submit" name="submit" data-toggle="tooltip" data-placement="top" title="Dulpicar la planilla de visita" onclick="return confirm(\'¿Estàs segur/a que vols duplicar aquest registre?\')" ><i class="far fa-clone"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';           
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=VisitTemplates&action=Generate" method="post">';
        $html.= "                    <input type=\"text\" name=\"idGenerar\" id=\"idGenerar\" value=\"" . $dato["idPlanillaVisita"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="clonar" hidden>';
        $html.= '                    <button class="btn btn-info btn-sm" type="submit" name="submit" data-toggle="tooltip" data-placement="top" title="Generar un dia de visita" onclick="return confirm(\'¿Estàs segur/a que vols generar una data de visites?\')" ><i class="far fa-address-book"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';           
        $html.= "            <td  style='display:none'>" . $dato["idPlanillaVisita"] . "</td>";
        $html.= "            <td>" . $dato["descripcioPlanillaVisita"] . "</td>";
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