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
 * Filename grup.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe grup.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package grup
 * @subpackage db
 * @version 1.0.0
 */
final class grup extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct(){
        $this->link = $this->connectar();
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de grups. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de grups.
      * @access public
      */
    public function getLlistaGrups ( $limit = null, $order = null ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ ."grups";
        /*$sql = "SELECT t1.*, t2.importTotal FROM " . _DB_PREFIX_ . "grups t1 left join
                (SELECT sum(importUnitari*unitats) as importTotal,idGrup FROM " . _DB_PREFIX_ . "grups_det GROUP BY idGrup) as t2 on t1.idGrup=t2.idGrup";
        */
        if ( !is_null ( $order ) ) {
         
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }
        return $this->getRows ( $sql );        
    }

    /** 
      * Retorna una matriu associativa amb un grup en funció del seu identificador.
      * @param integer $idGrup Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del grup.
      * @access public
      */
    public function getGrupById ( $idGrup ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "grups WHERE idGrup = " . $idGrup;
       return $this->getRow ( $sql );        
    }
   
    /** 
      * Agfegeix un grup a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixGrup ( $fields ) {
       $sql = "INSERT INTO " . _DB_PREFIX_ . "grups (grup) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql ); 
    }
    
    /** 
      * Modifica un grup de la BBDD.
      * @param integer $idGrup Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function modificaGrup ( $idGrup, $fields ) {
        $sql = "UPDATE " . _DB_PREFIX_ . "grups SET " . $fields . " WHERE idGrup=" . $idGrup;
        return $this->modifyRow ( $sql ); 
    }

    /** 
      * Esborra un grup de la BBDD.
      * @param integer $idGrup Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraGrup ( $idGrup ) {
        $sql = "DELETE FROM " . _DB_PREFIX_ . "grups WHERE idGrup=" . $idGrup;
        return $this->deleteRow ( $sql ); 
      
    }

    /** 
      * Retorna el identificador del últim grup que s'ha afegit a la BBDD.
      * @return integer Retorna el valor del identificador del últim grup que s'ha introduït a la BBDD.
      * @access public
      */
    public function retornaUltimGrupAfegit ( ) {
        return $this->returnLastInsertId ( );
    }

    /** 
      * Retorna el número total de grups.
      * @return array  Matriu d'una fila associativa del amb el número de grups.
      * @access public
      */
    public function retornaNumeroGrups ( ) {
        $sql = "SELECT COUNT(*) as TotalGrups FROM " . _DB_PREFIX_ . "grups";
        return $this->getRow ( $sql ); 
        
    }
    
    /** 
      * Retorna una matriu associativa amb la llista de grups. 
      * @return array Llista de grups.
      * @access public
      */
    public function retornaGrups ( ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "grups ORDER BY data asc";
        return $this->getRows ( $sql );
        
    }
    
    
    /** 
      * Retorna una matriu associativa amb la llista de grups d'un usuari. 
      * @param integer $idUsuari Identificador del usuari
      * @return array Llista de grups.
      * @access public
      */
    public function getLlistaGrupsByUser ( $idUsuari ) {
        $sql = "SELECT g.idGrup, g.grup FROM " . _DB_PREFIX_ . "grups g LEFT JOIN " . _DB_PREFIX_ . "grups_det gd ON g.idGrup=gd.idGrup WHERE gd.idUsuari=" . $idUsuari;
        return $this->getRows ( $sql );
        
    }
    
}