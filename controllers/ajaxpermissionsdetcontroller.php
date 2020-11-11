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
 * Filename ajaxpermissionsdetcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxpermissionsdetcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxpermissionsdetcontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxpermissionsdetcontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var string $modul Conté l'objecte mòdul */
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
    
    /** @var integer $tipus Conté el tipus de filtre */    
    private $tipus;
    
    /**  @var string $modelgrup Conté el model del permis */   
    private $modelpermis;
    
    /**  @var string $permis Conté l'objecte permis */
    public $permis;
    
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

        
        /** crea l'objecte del detall modul */
        $this->model = new modul ( );
        
        /** executa el mètodo que recupera el número de mòduls */
        $this->numRows = $this->model->retornaNumeroModuls (  );

        if ( $this->numRows['TotalModuls']>0 ) { /** si hi han mòduls */
            
            $this->tpages = ceil ( $this->numRows['TotalModuls'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ( $this->page - 1 ) * $this->rowsPerPage;
        $this->order = "modul desc";
        
        /** crida al mètode que recupera la llista de mòduls */
        $this->modul = $this->model->getLlistaModuls ( $this->offset . ', ' . $this->rowsPerPage , $this->order );
        
        if ( !filter_has_var( INPUT_GET, 'tipus' ) ) {  /** si no hi ha el filtre */

            $this->tipus = 1;

        } else { /** sino filtro per grups */
            
            $this->tipus = filter_input( INPUT_GET, 'tipus' );            
        }
        
        
        if ( $this->tipus == 1 ) {
            
            $this->modelpermis  = new permis ( );
            $this->permis =  $this->modelpermis->getPermisosByGrup( filter_input ( INPUT_GET, 'id' ) );
            
        } else {
            
            $this->modelpermis = new permis ( );
            $this->permis  = $this->modelpermis->getPermisosByUsuari ( filter_input ( INPUT_GET, 'id' ) );
            
        }
        
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
        $html.= '            <th>Opcions</th>';
        $html.= '            <th style="display:none">idModul</th>';
        $html.= '            <th>Mòdul</th>';
        $html.= '            <th class="text-center">R</th>';
        $html.= '            <th class="text-center">R/W</th>';
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
                foreach ( $this->modul as $dato ) { /** per cada mòdul */
                    
        $html.= '        <tr>';       

        $html.= '            <td><button class="btn btn-danger btn-sm" type="button" name="clear" onclick="javascript: if ( confirm(\'¿Estàs segur/a que vols eliminar aquest registre?\') == true ) {document.getElementById(\'R' . $dato["idModul"] . '\').checked = false; document.getElementById(\'RW' . $dato["idModul"] . '\').checked = false;}" ><i class="fa fa-trash-alt"></i></button></td>';
        
        
        $html.= "            <td style='display:none'>" . $dato["idModul"] . "</td>";
        $html.= "            <td>" . $dato["modul"] . "</td>";
        
                    /** cerca a la columna idModul de la matriu de permisos el valor actual de idModul, si el troba torna el valor de la clau i sino torna FALSE */
                    $key = array_search ( $dato["idModul"] , array_column ( $this->permis , "idModul" ) );

                    if ($key !== false ) { /** si ha tornat un valor de clau */

                        if ( $this->permis[$key]['permis'] < 2 ) {/** si el permís és només de LECTURA */
                        
        $html.= "            <td class=\"text-center\"><input type=\"radio\" value=\"1\" name=\"" . $dato["idModul"] . "\" id=\"R". $dato["idModul"] ."\" checked></td>";
        $html.= "            <td class=\"text-center\"><input type=\"radio\" value=\"2\" name=\"" . $dato["idModul"] . "\" id=\"RW" . $dato["idModul"] ."\"></td>";
        
                        } else {
                        
        $html.= "            <td class=\"text-center\"><input type=\"radio\" value=\"1\" name=\"" . $dato["idModul"] . "\" id=\"R". $dato["idModul"] ."\"></td>";
        $html.= "            <td class=\"text-center\"><input type=\"radio\" value=\"2\" name=\"" . $dato["idModul"] . "\" id=\"RW" . $dato["idModul"] ."\" checked></td>";
                        
                        }

                    } else {

        $html.= "            <td class=\"text-center\"><input type=\"radio\" value=\"1\" name=\"" . $dato["idModul"] . "\" id=\"R". $dato["idModul"] ."\"></td>";
        $html.= "            <td class=\"text-center\"><input type=\"radio\" value=\"2\" name=\"" . $dato["idModul"] . "\" id=\"RW" . $dato["idModul"] ."\"></td>";
                
                    }
        $html.= '   <input type="text" name="radioNames[]" id="radioNames" value="'.$dato["idModul"].'"/ hidden>';
                
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