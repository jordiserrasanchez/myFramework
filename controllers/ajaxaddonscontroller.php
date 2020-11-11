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
 * Filename ajaxaddonscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxaddonscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxaddonscontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxaddonscontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var string $concepte Conté l'objecte mòdul */
    private $modul;
    
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
        
        /** crea l'objecte del mòdul */
        $this->model = new modul ( );

        /** executa el mètodo que recupera el número de mòduls */
        $this->numRows = $this->model->retornaNumeroModuls ( );
                
        if ( $this->numRows['TotalModuls'] > 0 ) {/** si hi han objectes */
            $this->tpages = ceil ( $this->numRows['TotalModuls'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ($this->page - 1) * $this->rowsPerPage;
        $this->order = "modul asc";
        
        /** crida al mètode que recupera la llista d'objectes  */
        $this->modul = $this->model->getLlistaModuls ( $this->offset . ', ' . $this->rowsPerPage , $this->order );
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
        $html.= '            <th style="display:none">idModul</th>';
        $html.= '            <th>Mòdul</th>';
        $html.= '            <th>Controlador</th>';
        $html.= '            <th>Icona</th>';
        $html.= '            <th>Sistema</th>'; 
        $html.= '            <th>Actiu</th>';       
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                foreach ( $this->modul as $dato ) { /** per cada objecte */
        $html.= '        <tr>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Addons&action=Delete" method="post">';
        $html.= "                    <input type=\"text\" name=\"idEliminar\" id=\"idEliminar\" value=\"" . $dato["idModul"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="eliminar" hidden>';
        $html.= '                    <button class="btn btn-danger btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols eliminar aquest registre?\')" ><i class="fa fa-trash-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Addons&action=Edit" method="post">';
        $html.= "                    <input type=\"text\" name=\"idModificar\" id=\"idModificar\" value=\"" . $dato["idModul"] . "\" hidden>";
        $html.= '                    <input type="text" name="menu" id="menu" value="modificar" hidden>';
        $html.= '                    <button class="btn btn-warning btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols modificar aquest registre?\')" ><i class="fa fa-pencil-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';          
        $html.= "            <td  style='display:none'>" . $dato["idModul"] . "</td>";
        $html.= "            <td>" . $dato["modul"] . "</td>";
        $html.= "            <td>" . $dato["controlador"] . "</td>";
        $html.= "            <td class=\"text-center\">" . $dato["icona"] . "</td>";
        
        $iconaSistema = ($dato["sistema"]=='1') ? "<i class=\"far fa-check-square\"></i>" : "<i class=\"far fa-square\"></i>";
        $html.= "            <td class=\"text-center\">" . $iconaSistema . "</td>";       
        
        $iconaActiu = ($dato["actiu"]=='1') ? "<i class=\"far fa-check-square\"></i>" : "<i class=\"far fa-square\"></i>";
        $html.= "            <td class=\"text-center\">" . $iconaActiu . "</td>";     
        
        
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
