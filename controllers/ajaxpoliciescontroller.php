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
 * Filename ajaxpoliciescontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxpoliciescontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxpoliciescontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxpoliciescontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var string $politica Conté l'objecte politica */
    private $politica;
    
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
        
        /** crea l'objecte de la politica */
        $this->model = new politica ( );

        /** executa el mètodo que recupera el número de politiques */
        $this->numRows = $this->model->retornaNumeroPolitiques ( );
                
        if ( $this->numRows['TotalPolitiques'] > 0 ) {/** si hi han politiques */
            $this->tpages = ceil ( $this->numRows['TotalPolitiques'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ( $this->page - 1 ) * $this->rowsPerPage;
        $this->order = "politica asc";

        /** crida al mètode que recupera la llista de politiques */
        $this->politica = $this->model->getLlistaPolitiques ( $this->offset . ', ' . $this->rowsPerPage , $this->order );
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
        $html.= '            <th style="display:none">idPolitica</th>';
        $html.= '            <th>Política</th>';
        $html.= '            <th>Umbral de intents</th>';
        $html.= '            <th>Umbral de caducitat</th>';
        $html.= '            <th>Umbral de història</th>';
        $html.= '            <th>Requereix complexitat</th>';
        $html.= '            <th>Longitut mínima</th>';
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                foreach ( $this->politica as $dato ) { /** per cada política */
        $html.= '        <tr>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Policies&action=Delete" method="post">';
        $html.= "                    <input type=\"text\" name=\"idEliminar\" id=\"idEliminar\" value=\"" . $dato["idPolitica"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="eliminar" hidden>';
        $html.= '                    <button class="btn btn-danger btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols eliminar aquest registre?\')" ><i class="fa fa-trash-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Policies&action=Edit" method="post">';
        $html.= "                    <input type=\"text\" name=\"idModificar\" id=\"idModificar\" value=\"" . $dato["idPolitica"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="modificar" hidden>';
        $html.= '                    <button class="btn btn-warning btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols modificar aquest registre?\')" ><i class="fa fa-pencil-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';          
        $html.= "            <td  style='display:none'>" . $dato["idPolitica"]."</td>";
        $html.= "            <td>" . $dato["politica"] . "</td>";
        $html.= "            <td class=\"text-center\">" . $dato["umbralIntents"] . "</td>";
        $html.= "            <td class=\"text-center\">" . $dato["umbralCaducitat"] . "</td>";
        $html.= "            <td class=\"text-center\">" . $dato["umbralHistoria"] . "</td>";
        $iconaRequereixComplexitat = ($dato["requereixComplexitat"]=='1') ? "<i class=\"far fa-check-square\"></i>" : "<i class=\"far fa-square\"></i>";
        $html.= "            <td class=\"text-center\">" . $iconaRequereixComplexitat . "</td>";               
        $html.= "            <td class=\"text-center\">" . $dato["longitutMinima"] . "</td>";
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
