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
 * Filename ajaxtravelsdetcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxtravelsdetcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxtravelsdetcontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxtravelsdetcontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var string $viatge_det Conté l'objecte detall del viatge */
    private $viatge_det;
    
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

        $idViatge = filter_input( INPUT_GET, 'idViatge' );
        
        /** crea l'objecte del detall del viatge */
        $this->model = new viatge_det ( );
        
        /** executa el mètodo que recupera el número de detalls d'un viatge */
        $this->numRows = $this->model->retornaNumeroViatgesDet ( $idViatge );

        if ( $this->numRows['TotalViatgesDet']>0 ) { /** si hi han detalls del viatge */
            
            $this->tpages = ceil ( $this->numRows['TotalViatgesDet'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ( $this->page - 1 ) * $this->rowsPerPage;
        $this->order = "idViatge_det desc";
        
        /** crida al mètode que recupera la llista de detalls d'un viatge */
        $this->viatge_det = $this->model->getLlistaViatges_det ( $idViatge , $this->offset . ', ' . $this->rowsPerPage , $this->order );
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
        $html.= '            <th style="display:none">idViatge_det</th>';
        $html.= '            <th style="display:none">idViatge</th>';
        $html.= '            <th>concepte</th>';
        $html.= '            <th>importUnitari</th>';
        $html.= '            <th>Unitats</th>';
        $html.= '            <th>Total (Camp calculat)</th>';        
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                $dtotal = 0;
                foreach ( $this->viatge_det as $dato ) { /** per cada detall de viatge */
        $html.= '        <tr>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Travels&action=DeleteDet" method="post">';
        $html.= "                    <input type=\"text\" name=\"idEliminar\" id=\"idEliminar\" value=\"" . $dato["idViatge_det"] . "\" hidden>";
        $html.= "                    <input type=\"text\" name=\"idMaster\" id=\"idMaster\" value=\"" . $dato["idViatge"] . "\" hidden>";        
        $html.= '                    <input type="text" name="menu" id="menu" value="eliminar" hidden>';
        $html.= '                    <button class="btn btn-danger btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols eliminar aquest registre?\')" ><i class="fa fa-trash-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Travels&action=EditDet" method="post">';
        $html.= "                    <input type=\"text\" name=\"idModificar\" id=\"idModificar\" value=\"" . $dato["idViatge_det"] . "\" hidden>";
        $html.= "                    <input type=\"text\" name=\"idMaster\" id=\"idMaster\" value=\"" . $dato["idViatge"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="modificar" hidden>';
        $html.= '                    <button class="btn btn-warning btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols modificar aquest registre?\')" ><i class="fa fa-pencil-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';                  
        $html.= "            <td  style='display:none'>" . $dato["idViatge_det"] . "</td>";
        $html.= "            <td  style='display:none'>" . $dato["idViatge"] . "</td>";
        $html.= "            <td>" . $dato["concepte"] . "</td>";
        
        $importUnitari = str_replace ( '.' , ',' , $dato["importUnitari"] );
        $html.= "            <td class=\"text-right\">" . $importUnitari . " €</td>";
        
        $html.= "            <td class=\"text-center\">" . $dato["unitats"] . "</td>";
        
        $importLinia = str_replace ( '.' , ',' , $dato["importUnitari"] * $dato["unitats"] );
        $html.= "            <td class=\"text-right\">" . $importLinia . " €</td>";
        
                $dtotal = $dtotal + ( $dato["importUnitari"] * $dato["unitats"] );
        $html.= '        </tr>';
                }
        $html.= '    </tbody>';

        $html.= "            <tfoot class=\"thead-dark\">";
        $html.= "                <tr>";
        $html.= "                    <th colspan=\"5\"></th>";

        $html.= "                    <th class=\"text-right\">" . str_replace ( '.' , ',' , $dtotal ) . " €</th>";
        $html.= "                </tr>";
        $html.= "            </tfoot>";        
        $html.= '</table>';

        return json_encode(
            array(
                'contenido' => $html,
                'paginas' => $this->paginacion
            )
        );
    }
}
