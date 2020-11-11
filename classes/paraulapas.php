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
 * Filename paraulapas.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe paraulapas.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package paraulapas
 * @subpackage db
 * @version 1.0.0
 */

class paraulapas extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    function __construct ( ) {
        $this->link=$this->connectar ( );
    }  
    
    /** 
      * Retorna una matriu associativa amb la llista de paraules de pas d'un usuari.
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de politiques.
      * @access public
      */
    public function getLlistaParaulesPasById ( $idUsuari, $limit = null, $order = null ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "paraulespas WHERE idUsuari = " . $idUsuari;
        if ( !is_null ( $order ) ) {
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }
        return $this->getRows ( $sql );        
    }    
    
    /** 
      * Retorna una matriu associativa amb una paraula de pas.
      * @param integer $idUsuari Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa de la paraula de pas.
      * @access public
      */
    public function getParaulaPasById ( $idUsuari ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "paraulespas WHERE idUsuari = " . $idUsuari . " ORDER BY dataParaula desc";
        return $this->getRow ( $sql );     
    }
 
    /** 
      * Agfegeix una paraula de pas a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixParaula ( $fields ) {
        $sql = "INSERT INTO " . _DB_PREFIX_ . "paraulespas (idUsuari, paraulaPas, dataParaula) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql );         
    }    
}
?>
