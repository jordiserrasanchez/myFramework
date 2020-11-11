<?php
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
 * Create at 24-sep-2020 12:54:55
 * Project name myFramework
 * Project DisplayName myFramework
 * Filename ajaxsetup.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxsetup.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxsetup
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxsetup {
    
const MYSQL_CONN_ERROR="Unable to connect to database.";

    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */    
    public function __construct() {
        // Ensure reporting is setup correctly
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        error_reporting ( E_ALL );
        ini_set ( "display_errors" , 0 );

    } 
    
    function __destruct() {
        error_reporting ( E_ALL );
        ini_set ( "display_errors" , 1 );        
    }
    
    /** 
    * Genera el contigut a mostrar
    * @return array Matriu JSON amb el contingut i l'objecte.
    * @access public
    */
    public function render ( ) {
        
        $host =  filter_input ( INPUT_GET , 'host' );  
        $username = filter_input ( INPUT_GET , 'username' );  
        $password = filter_input ( INPUT_GET , 'password' );  
        $dbname = filter_input ( INPUT_GET , 'dbname' );  
        if (!$username) {
            $html= '<div class="alert alert-danger" role="alert">';
            $html.= 'El nom de l\'usuari és obligatori.';
            $html.= '</div>';    
            
        } else {
        
        try {
            try {
                $conn = new mysqli ( $host, $username, $password, $dbname );
                $html= '<div class="alert alert-success" role="alert">';
                $html.= 'La connexió s\'ha realitzat amb èxit.';
                $html.= '</div>';
            } catch (mysqli_sql_exception $e) {
                throw $e;
            }            
        
        } catch (Exception $e) {
            $html= '<div class="alert alert-danger" role="alert">';
            //$html.= $e->errorMessage();
            $html.= $e->getMessage();
           
            $html.= '</div>';    
        } 
        
        
/**        
        } catch (Exception $e) {
            $html= '<div class="alert alert-danger" role="alert">';
            $html.= $e->getMessage();
            $html.= '</div>';    
        }         
 * 
 */
        }
        return json_encode( array ('contenido' => $html ) );
    }
}

