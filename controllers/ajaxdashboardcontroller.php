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
 * Filename ajaxdashboardcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxdashboardcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxdashboardcontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxdashboardcontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var array $data Conté el resultat */
    private $data;
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */  
    function __construct ( ) {
            
        /** crea l'objecte del viatge */
        $this->model = new viatge ( );

        if ( filter_has_var( INPUT_POST, 'origen' ) ) {  /** si hi ha establert un origen */
            switch ( filter_input( INPUT_POST, 'origen' ) ) {
                case 'graficAnual':
                    
                    /** crida la mètode que retorna el total de despeses per anys */
                    $this->data = $this->model->retornaDespesesAnuals ( );
                    break;
                case 'graficMensual':
                    
                    /** crida la mètode que retorna el total de despeses mensuals de l'any indicat */
                    $this->data = $this->model->retornaDespesesMensuals ( filter_input( INPUT_POST, 'any' ) );
                    break;
                case 'ImportAcumulat':
                    
                    /** crida la mètode que retorna el total del import acumulat */
                    $this->data = $this->model->retornaImportAcumulat ( );
                    break;
                case 'ImportPendent':
                    
                    /** crida la mètode que retorna el total del import pendent */
                    $this->data = $this->model->retornaImportPendent ( );
                    break;
                case 'carregaAnys':
                    
                    /** crida la mètode que retorna els anys on hi ha hagut despeses */
                    $this->data = $this->model->retornaAnys ( );
                    break;

            }
        }
            
    }
    
    /** 
    * Genera el contigut a mostrar
    * @return array Matriu JSON amb el contingut.
    * @access public
    */        
    public function render ( ) {
    
        return json_encode ( $this->data );
    
    }

 }
