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
 * Filename db.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe db.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @license http://www.serraperez/licenses/
 * @package concepte
 * @subpackage db
 * @version 1.0.0
 */
class db {
    
    /**  @var link $link Connexió amb la BBDD */
    public $link;
    
    /**  @var array $files Matriu associativa amb els resultats */
    public $files;
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */  
    public function __construct ( ) {
        $this->link = $this->connectar ( );
        $this->files = array ( );
    }    

    /** 
      * Tanca la connexió amb la BBDD.
      * @access public
      */      
    public function disconnect ( ) {
        $this->link->close ( );
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

    /** 
      * Retorna una matriu associativa amb les dades de la consulta.
      * @param string $sql Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu amb les dades de la consulta.
      * @access public
      */
    public function getRows ( $sql ) {
        $files = array ( );
        $ret = $this->link->query ( $sql );
        while ( $rows = $ret->fetch_assoc ( ) ) {
            $files[] = $rows;
        }
        return $files;        
    }
    
    /** 
      * Retorna una matriu associativa d'una finla amb les dades de la consulta.
      * @param string $sql Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila amb les dades de la consulta.
      * @access public
      */
    public function getRow ( $sql ) {
        $ret = $this->link->query ( $sql );
        return $ret->fetch_assoc ( );
    }
    
    /** 
      * Executa una consulta.
      * @param string $sql Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function executeQuery ( $sql ) {
        $ret = $this->link->query( $sql );
        return $ret;
        
    }

    /** 
      * Executa una consulta.
      * @param string $sql Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function insertRow ( $sql ) {
        $ret = $this->link->query( $sql );
        return $ret;       
    }
    
    /** 
      * Executa una consulta.
      * @param string $sql Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function modifyRow( $sql ) {
        $ret = $this->link->query ( $sql );
        return $ret;       
    }
    
    /** 
      * Executa una consulta.
      * @param string $sql Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function deleteRow ( $sql ) {
        $ret = $this->link->query ( $sql );
        return $ret;      
        
    }

   /** 
      * Retorna el identificador del últim usuari que s'ha afegit a la BBDD.
      * @return integer Retorna el valor del últim identificador que s'ha introduït a la BBDD.
      * @access public
      */
    public function returnLastInsertId ( ) {
        $ret = $this->link->insert_id;
        return $ret;
    }
}