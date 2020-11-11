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
 * Create at 30-ene-2020 12:54:55
 * Project name myFramework
 * Project DisplayName myFramework
 * Filename setup.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe setup.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package setup
 * @subpackage db
 * @version 1.0.0
 */
final class setup {

    private $link; 
    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct ( ){
        $this->link = $this->connectar ( );
    }    
    
    public function desaConfiguracioBBDD ( $fields ) {
        /** primer esborrem la configuracio vella */
        $sql = "DELETE FROM " . _DB_PREFIX_ . "configuracio WHERE parametre like '_DB_%'";
        $ret = $this->deleteRow ( $sql );
        
        foreach ( $fields as $row ) {
            $sql = "INSERT INTO " . _DB_PREFIX_ . "configuracio (parametre,valor) VALUES ('". $row['parametre'] ."','" . $row['valor'] ."')";
            return $this->insertRow ( $sql ); 
        }
    }        

    
    /** 
      * Obre la connexió amb la BBDD.
      * @return link Connexió amb la BBDD.
      * @access public
      */      
    public function connectar ( ) {
        
        $link = new mysqli ( _DB_HOST_ , _DB_USER_ , _DB_PASSWORD_ , _DB_NAME_ );
        
        $link->set_charset ( "utf8" );
        
        if (mysqli_connect_error()) {  /** Si s'ha produit un error. */
            die('L\'enllaç amb la base de dades no es pot realitzar (' . mysqli_connect_errno ( ) . ') '
               . mysqli_connect_error ( ) );
        }
        return $link;
    }    
    
}