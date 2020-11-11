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
 * Filename ajaxdepartmentscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxdepartmentscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxdepartmentscontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxdepartmentscontroller {
    
    /**  @var string $modelDiaVisita Conté el model del departament */
    private $modelDepartament;
    
    /**  @var string $llistaDepartaments Conté la llista de departaments*/
    private $llistaDepartaments;
    
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
        
        /** crea l'objecte del model del departament */
        $this->modelDepartament = new departament ( );

        /** executa el mètodo que recupera el número de departaments */
        $this->numRows = $this->modelDepartament->retornaNumeroDepartaments ( );
                
        if ( $this->numRows['TotalDepartaments'] > 0 ) {/** si hi han departaments */
            $this->tpages = ceil ( $this->numRows['TotalDepartaments'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ($this->page - 1) * $this->rowsPerPage;
        $this->order = "descripcioDepartament asc";
        
        /** crida al mètode que recupera la llista de departaments  */
        $this->llistaDepartaments = $this->modelDepartament->getLlistaDepartaments ( $this->offset . ', ' . $this->rowsPerPage , $this->order );
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
        $html.= '            <th colspan="2">Opcions</th>';
        $html.= '            <th style="display:none">idDepartament</th>';
        $html.= '            <th>Descripció del departament</th>';
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                foreach ( $this->llistaDepartaments as $dato ) { /** per cada departament */
        $html.= '        <tr>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Departments&action=Delete" method="post">';
        $html.= "                    <input type=\"text\" name=\"idEliminar\" id=\"idEliminar\" value=\"" . $dato["idDepartament"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="eliminar" hidden>';
        $html.= '                    <button class="btn btn-danger btn-sm" type="submit" name="submit" data-toggle="tooltip" data-placement="top" title="Eliminar el departament" onclick="return confirm(\'¿Estàs segur/a que vols eliminar aquest registre?\')" ><i class="fa fa-trash-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Departments&action=Edit" method="post">';
        $html.= "                    <input type=\"text\" name=\"idModificar\" id=\"idModificar\" value=\"" . $dato["idDepartament"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="modificar" hidden>';
        $html.= '                    <button class="btn btn-warning btn-sm" type="submit" name="submit" data-toggle="tooltip" data-placement="top" title="Modificar el departament" onclick="return confirm(\'¿Estàs segur/a que vols modificar aquest registre?\')" ><i class="fa fa-pencil-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';          
        $html.= "            <td  style='display:none'>" . $dato["idDepartament"] . "</td>";
        $html.= "            <td>" . $dato["descripcioDepartament"] . "</td>";
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
