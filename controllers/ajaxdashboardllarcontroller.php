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
 * Filename ajaxdashboardllarcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxdashboardllarcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxdashboardllarcontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxdashboardllarcontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var array $data Conté el resultat */
    private $data;
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */  
    function __construct ( ) {
            
        /** crea l'objecte de la visita */
        $this->model = new visita ( );

        if ( filter_has_var( INPUT_POST, 'origen' ) ) {  /** si hi ha establert un origen */
            switch ( filter_input( INPUT_POST, 'origen' ) ) {
                case 'taulaVisites':
                    /** crida la mètode que retorna les visites de la setmana en funció del dia */


                    $dataIncial = $this->retornaAvui ( );
                    $dataFinal = $this->retornaFinalSetmana ( );
                    
                    $this->data = $this->model->retornaVisitesSetmana ( $dataIncial, $dataFinal );
                    break;
                case 'taulaSortides':
                    
                    /** crida la mètode que retorna el total de despeses mensuals de l'any indicat */
                    $this->data = $this->model->retornaDespesesMensuals ( filter_input( INPUT_POST, 'any' ) );
                    break;

            }
        }
            
    }
    
    private function retornaAvui ( ) {
        
        return date("Y-m-d");
    }
/**
    private function retornaIniciSetmana ( ) {
        
        // Si hoy es lunes, nos daría el lunes pasado.
        if (date("D")=="Mon"){
            $week_start = date("Y-m-d");
        } else {
            $week_start = date("Y-m-d", strtotime('last Monday', time()));
        }
        return $week_start;
    }
*/   
    private function retornaFinalSetmana ( ) {

        $week_end = strtotime('next Sunday', time());
        return date('Y-m-d', $week_end);
                            
    }
    
    /** 
    * Genera el contigut a mostrar
    * @return array Matriu JSON amb el contingut.
    * @access public
    */        
    public function render ( ) {
        
        $html= '<table id="table" class="table table-sm table-bordered table-hover table-striped" style="width: auto; white-space: nowrap;">';
        $html.= '  <thead class="thead-dark">';
        $html.= '        <tr>';
        $html.= '            <th>Data Visita</th>';
        $html.= '            <th>Hora d\'entrada</th>';
        $html.= '            <th>Hora de sortida</th>';
        $html.= '            <th>Descripció</th>';
        $html.= '            <th style="display:none">idVisita</th>';
        $html.= '            <th style="display:none">idHoraDiaVisita</th>';
        $html.= '            <th>Resident</th>';
        $html.= '            <th>Visitant</th>';
        $html.= '            <th>Departament</th>';
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                foreach ( $this->data as $dato ) { /** per cada visita */
        $html.= '        <tr>';
        $html.= "            <td>" . date_format ( date_create ( $dato["dataVisita"] ) , 'd/m/Y' ) . "</td>";
        $html.= "            <td>" . date_format ( date_create ( $dato["horaEntrada"] ) , 'H:i' ) . "</td>";
        $html.= "            <td>" . date_format ( date_create ( $dato["horaSortida"] ) , 'H:i' ) . "</td>";
        $html.= "            <td>" . $dato["descripcioHoraDiaVisita"] . "</td>";
        $html.= "            <td  style='display:none'>" . $dato["idVisita"] . "</td>";
        $html.= "            <td  style='display:none'>" . $dato["idHoraDiaVisita"] . "</td>";
        $html.= "            <td>" . $dato["nomResident"] . "</td>";
        $html.= "            <td>" . $dato["nomVisitant"] . "</td>";
        $html.= "            <td>" . $dato["descripcioDepartament"] . "</td>";
        $html.= '        </tr>';
                }
        $html.= '    </tbody>';
        $html.= '</table>';        
        return json_encode ( array( 'contenido' => $html ) );
    
    }

 }
