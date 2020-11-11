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
 * Filename ajaxpermissionscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxpermissionscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxpermissionscontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxpermissionscontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var string $usuari Conté l'objecte permis */ 
    private $permis;

    /**  @var string $tipus Conté el tipus de filtre */ 
    private $tipus;
    
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
    
    /**  @var string $order Conté el ordre de la llista */ 
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
        
        if ( !filter_has_var( INPUT_GET, 'tipus' ) ) {  /** si no hi ha establert un tipus */
            
            $this->tipus = 1;
        
        } else {
            
            $this->tipus = filter_input( INPUT_GET, 'tipus' ) ;

        }

        /** crea l'objecte permis */
        $this->model = new permis ( );

        /** executa el mètodo que recupera el número de permisos */
        $this->numRows = $this->model->retornaNumeroPermisos ( $this->tipus );
                
        if ( $this->numRows['TotalPermisos'] > 0 ) { /** si hi han permisos */
             
            $this->tpages = ceil ( $this->numRows['TotalPermisos'] / _NUM_ROWS_BY_PAGE_ );

        }
    
        /** crida al mètode estàtic de l'objecte paginacion */
        $this->paginacion = Paginacion::paginate ( $this->page , $this->tpages , _NUM_ITEM_ADJACENTS_ );
    
        $this->rowsPerPage = _NUM_ROWS_BY_PAGE_;
        $this->offset = ( $this->page - 1 ) * $this->rowsPerPage;
        
        if ( $this->tipus == 1 ) { /** filtra per grups */
            
            $this->order = "g.grup ASC";
        
            /** crida al mètode que recupera la llista d'usuaris */
            $this->permis = $this->model->getLlistaGrupsPermisos ( $this->offset . ', ' . $this->rowsPerPage , $this->order );
        
            
        } else {
        
            $this->order = "u.cognoms, u.nom ASC";
        
            /** crida al mètode que recupera la llista d'usuaris */
            $this->permis = $this->model->getLlistaUsuarisPermisos ( $this->offset . ', ' . $this->rowsPerPage , $this->order );
            
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
        $html.= '            <th colspan="2">Opcions</th>';
        
        
        if ( $this->tipus  == 1 ) { /** si estem filtrant per grups */
            
            $html.= '            <th style="display:none">idGrup</th>';
            $html.= '            <th>Grup</th>';
        
        } else {
            
            $html.= '            <th style="display:none">idUsuari</th>';
            $html.= '            <th>Nom</th>';
            $html.= '            <th>Cognoms</th>';
            
        }
        
        $html.= '        </tr>';
        $html.= '    </thead>';
        $html.= '    <tbody>';
        $i = 0;
                foreach ( $this->permis as $dato ) { /** per cada permis */
                    
        $html.= '        <tr>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Permissions&action=Delete" method="post">';
        
        if ( $this->tipus  == 1 ) { /** si estem filtrant per grups */
            
            $html.= "                    <input type=\"text\" name=\"idEliminar\" id=\"idEliminar\" value=\"" . $dato["idGrup"] . "\" hidden>";
            $html.= "                    <input type=\"text\" name=\"tipusEliminar\" id=\"tipusEliminar\" value=\"1\" hidden>";
            
        } else {
            
            $html.= "                    <input type=\"text\" name=\"idEliminar\" id=\"idEliminar\" value=\"" . $dato["idUsuari"] . "\" hidden>";
            $html.= "                    <input type=\"text\" name=\"tipusEliminar\" id=\"tipusEliminar\" value=\"0\" hidden>";
            
        }
        
        $html.= '                    <input type="text" name="menu" id="menu" value="eliminar" hidden>';
        $html.= '                    <button class="btn btn-danger btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols eliminar aquest registre?\')" ><i class="fa fa-trash-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';
        $html.= '            <td>';
        $html.= '                <form name="form" action="index.php?controlador=Permissions&action=Edit" method="post">';
        
        if ( $this->tipus  == 1 ) { /** si estem filtrant per grups */
            
            $html.= "                    <input type=\"text\" name=\"idModificar\" id=\"idModificar\" value=\"" . $dato["idGrup"] . "\" hidden>";
            $html.= "                    <input type=\"text\" name=\"tipusModificar\" id=\"tipusModificar\" value=\"1\" hidden>";
            
        } else {
            
            $html.= "                    <input type=\"text\" name=\"idModificar\" id=\"idModificar\" value=\"" . $dato["idUsuari"] . "\" hidden>";
            $html.= "                    <input type=\"text\" name=\"tipusModificar\" id=\"tipusModificar\" value=\"0\" hidden>";
            
        }
        
        $html.= '                    <input type="text" name="menu" id="menu" value="modificar" hidden>';
        $html.= '                    <button class="btn btn-warning btn-sm" type="submit" name="submit" onclick="return confirm(\'¿Estàs segur/a que vols modificar aquest registre?\')" ><i class="fa fa-pencil-alt"></i></button>';
        $html.= '                </form>';
        $html.= '            </td>';          

        if ( $this->tipus  == 1 ) { /** si estem filtrant per grups */

            $html.= "            <td  style='display:none'>" . $dato["idGrup"] . "</td>";
            $html.= "            <td>" . $dato["grup"] . "</td>";
            
        } else {
            $html.= "            <td  style='display:none'>" . $dato["idUsuari"] . "</td>";
            $html.= "            <td>" . $dato["nom"] . "</td>";
            $html.= "            <td>" . $dato["cognoms"] . "</td>";
            
        }
        
        $html.= "        </tr>";
        $i++;
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