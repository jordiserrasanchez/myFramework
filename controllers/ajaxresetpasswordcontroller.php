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
 * Filename ajaxresetpasswordcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxresetpasswordcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxresetpasswordcontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxresetpasswordcontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var string $correu Conté el correu */
    private $correu;
    
    /**  @var string $token Conté el token temporal */
    private $token;

    /** 
      * Inicialitza l'objecte.
      * @access public
      */ 
    function __construct ( ) {    
        if ( filter_has_var ( INPUT_GET , 'email' ) && filter_has_var ( INPUT_GET , 'token' ) ) {  /** si s'ha omplert els camps */
            
            /** crea l'objecte del usuari */
            $this->model = new usuari ( );
            
            $this->correu = $this->model->link->real_escape_string ( filter_input ( INPUT_GET , 'email' ) );
            $this->token = $this->model->link->real_escape_string ( filter_input ( INPUT_GET , 'token' ) );
        }
    }

    /** 
    * Genera el contigut a mostrar
    * @return array Matriu JSON amb el contingut.
    * @access public
    */    
    public function recuperaPassword ( ) {
        
        /** crida al mètode que restableix la paraula de pas */
        $ret = $this->model->resetPassword( $this->correu , $this->token );
        return json_encode ( ["msg" => $ret] );       
    }
    
            
}



