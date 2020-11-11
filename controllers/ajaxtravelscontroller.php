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
 * Filename ajaxtravelscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxtravelscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxtravelscontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxtravelscontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var string $viatge Conté l'objecte viatge */
    private $viatge;
    
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
        
        /** crea l'objecte del viatge */
        $this->model = new viatge ( );

        /** executa el mètodo que recupera el número de viatges */
        $this->numRows = $this->model->retornaNumeroViatges ( );

        if ( $this->numRows['TotalViatges'] > 0 ) { /** si hi han viatges */
             $this->tpages = ceil ( $this->numRows['TotalViatges'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ( $this->page - 1 ) * $this->rowsPerPage;
        $this->order = "data desc";
        
        /** crida al mètode que recupera la llista de viatges */
        $this->viatge = $this->model->getLlistaViatges ( $this->offset . ', ' . $this->rowsPerPage , $this->order );
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
        $html.= '            <th style="display:none">idViatge</th>';
        $html.= '            <th>Viatge</th>';
        $html.= '            <th>Data</th>';
        $html.= '            <th>Import</th>';
        $html.= '            <th>Abonat</th>';
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                $dtotal = 0;
                foreach ( $this->viatge as $dato ) { /** per cada viatge */
        $html.= '        <tr>';
        $html.= '            <td>';
        if ( $dato["abonat"] == 1 ) { /** si el viatge està abonat */
        $html.= '                <form name="form" action="index.php?controlador=Travels&action=Undo" method="post">';
        $html.= "                    <input type=\"text\" name=\"idRevertir\" id=\"idRevertir\" value=\"" . $dato["idViatge"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="revertir" hidden>';
        $html.= '                    <button class="btn btn-info btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols revertir aquest registre?\')" ><i class="fas fa-unlock-alt"></i></button>';
        $html.= '                </form>';

        } else {

        $html.= '                <form name="form" action="index.php?controlador=Travels&action=Receive" method="post">';
        $html.= "                    <input type=\"text\" name=\"idCobrar\" id=\"idCobrar\" value=\"" . $dato["idViatge"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="cobrar" hidden>';
        $html.= '                    <button class="btn btn-info btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols cobrar aquest registre?\')" ><i class="fas fa-euro-sign"></i></button>';
        $html.= '                </form>';
        
        }

        $html.= '            </td>';    
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Travels&action=Delete" method="post">';
        $html.= "                    <input type=\"text\" name=\"idEliminar\" id=\"idEliminar\" value=\"" . $dato["idViatge"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="eliminar" hidden>';
        $html.= '                    <button class="btn btn-danger btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols eliminar aquest registre?\')" ><i class="fa fa-trash-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Travels&action=Edit" method="post">';
        $html.= "                    <input type=\"text\" name=\"idModificar\" id=\"idModificar\" value=\"" . $dato["idViatge"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="modificar" hidden>';
        $html.= '                    <button class="btn btn-warning btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols modificar aquest registre?\')" ><i class="fa fa-pencil-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';          
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Travels&action=Clone" method="post">';
        $html.= "                    <input type=\"text\" name=\"idClonar\" id=\"idClonar\" value=\"" . $dato["idViatge"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="clonar" hidden>';
        $html.= '                    <button class="btn btn-success btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols duplicar aquest registre?\')" ><i class="far fa-clone"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';           
        $html.= "            <td  style='display:none'>" . $dato["idViatge"] . "</td>";
        $html.= "            <td>" . $dato["viatge"] . "</td>";
        $html.= "            <td>" . date_format ( date_create ( $dato["data"] ) , 'd/m/Y' ) . "</td>";
        $import = str_replace ( '.' , ',' , $dato["importTotal"] );
        $html.= "            <td class=\"text-right\">" . $import . " €</td>";
        $iconaAbonat = ($dato["abonat"]=='1') ? "<i class=\"far fa-check-square\"></i>" : "<i class=\"far fa-square\"></i>";
        $html.= "            <td class=\"text-center\">" . $iconaAbonat . "</td>";
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
