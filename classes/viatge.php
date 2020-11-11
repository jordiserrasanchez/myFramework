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
 * Filename viatge.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe viatge.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package viatge
 * @subpackage db
 * @version 1.0.0
 */
final class viatge extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct(){
        $this->link = $this->connectar();
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de viatges. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de viatges.
      * @access public
      */
    public function getLlistaViatges ( $limit = null, $order = null ) {
        $sql = "SELECT t1.*, t2.importTotal FROM " . _DB_PREFIX_ . "viatges t1 left join
                (SELECT sum(importUnitari*unitats) as importTotal,idViatge FROM " . _DB_PREFIX_ . "viatges_det GROUP BY idViatge) as t2 on t1.idViatge=t2.idViatge";
        if ( !is_null ( $order ) ) {
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }
        return $this->getRows ( $sql );        
    }

    /** 
      * Retorna una matriu associativa amb un viatge en funció del seu identificador.
      * @param integer $idViatge Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del viatge.
      * @access public
      */
    public function getViatgeById ( $idViatge ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "viatges WHERE idViatge = " . $idViatge;
       return $this->getRow ( $sql );        
    }
   
    /** 
      * Agfegeix un viatge a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixViatge ( $fields ) {
       $sql = "INSERT INTO " . _DB_PREFIX_ . "viatges (viatge, data, abonat) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql ); 
    }
    
    /** 
      * Modifica un viatge de la BBDD.
      * @param integer $idViatge Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function modificaViatge ( $idViatge, $fields ) {
        $sql = "UPDATE " . _DB_PREFIX_ . "viatges SET " . $fields . " WHERE idViatge=" . $idViatge;
        return $this->modifyRow ( $sql ); 
    }

    /** 
      * Esborra un viatge de la BBDD.
      * @param integer $idViatge Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraViatge ( $idViatge ) {
        $sql = "DELETE FROM " . _DB_PREFIX_ . "viatges WHERE idViatge=" . $idViatge;
        return $this->deleteRow ( $sql ); 
      
    }

    /** 
      * Retorna el identificador del últim viatge que s'ha afegit a la BBDD.
      * @return integer Retorna el valor del identificador del últim viatge que s'ha introduït a la BBDD.
      * @access public
      */
    public function retornaUltimViatgeAfegit ( ) {
        return $this->returnLastInsertId ( );
    }

    /** 
      * Retorna el número total de viatges.
      * @return array  Matriu d'una fila associativa del amb el número de viatges.
      * @access public
      */
    public function retornaNumeroViatges ( ) {
        $sql = "SELECT COUNT(*) as TotalViatges FROM " . _DB_PREFIX_ . "viatges";
        return $this->getRow ( $sql ); 
        
    }
    
    /** 
      * Retorna una matriu associativa amb la llista de viatges pendents. 
      * @return array Llista de viatges pendents.
      * @access public
      */
    public function retornaViatgesPendents ( ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "viatges WHERE abonat=0 ORDER BY data asc";
        return $this->getRows ( $sql );
        
    }
    
    /** 
      * Retorna una matriu associativa amb la llista de viatges abonats. 
      * @return array Llista de viatges abonats.
      * @access public
      */
    public function retornaViatgesAbonats ( ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ ."viatges WHERE abonat=1 ORDER BY data asc";
        return $this->getRows ( $sql );
        
    }
    
    /** 
      * Retorna una matriu associativa amb la llista de viatges. 
      * @return array Llista de viatges.
      * @access public
      */
    public function retornaViatges ( ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "viatges ORDER BY data asc";
        return $this->getRows ( $sql );
        
    }

    /** 
      * Retorna una matriu associativa amb la llista de despeses per any. 
      * @return array Llista de despeses per any.
      * @access public
      */
    public function retornaDespesesAnuals ( )  {
        $sql = "SELECT YEAR(t1.data) as Any, sum(t2.importTotal) as Import FROM " . _DB_PREFIX_ . "viatges t1 left join
        (SELECT sum(importUnitari*unitats) as importTotal,idViatge FROM " . _DB_PREFIX_ . "viatges_det GROUP BY idViatge) as t2 on t1.idViatge=t2.idViatge
        GROUP BY Any";        
        return $this->getRows ( $sql );
    }
    
    /** 
      * Retorna el import acumulat.
      * @return array  Matriu d'una fila associativa del amb el import acumulat.
      * @access public
      */
    public function retornaImportAcumulat ( ) {
        $sql = "SELECT sum(t2.importTotal) as Import FROM " . _DB_PREFIX_ . "viatges t1 left join
        (SELECT sum(importUnitari*unitats) as importTotal,idViatge FROM " . _DB_PREFIX_ . "viatges_det GROUP BY idViatge) as t2 on t1.idViatge=t2.idViatge";
        return $this->getRow ( $sql );
    }
    
    /** 
      * Retorna el import pendent.
      * @return array  Matriu d'una fila associativa del amb el import pendent.
      * @access public
      */
    public function retornaImportPendent ( ) {
        $sql ="SELECT sum(t2.importTotal) as Import FROM " . _DB_PREFIX_ . "viatges t1 left join
        (SELECT sum(importUnitari*unitats) as importTotal,idViatge FROM " . _DB_PREFIX_ . "viatges_det GROUP BY idViatge) as t2 on t1.idViatge=t2.idViatge where t1.abonat<>1";
        return $this->getRow ( $sql );
    }
    
    /** 
      * Retorna una matriu associativa amb la llista d'anys amb despeses.
      * @return array Llista d'anys amb despeses.
      * @access public
      */
    public function retornaAnys ( ) { 
        $sql = "SELECT DISTINCT YEAR(data) as Any FROM " . _DB_PREFIX_ . "viatges";
        return $this->getRows ( $sql );
    }
    
    /** 
      * Retorna una matriu associativa amb la llista de despeses per mes. 
      * @param integer $any Valor del camp per la clàusula WHERE de SQL.
      * @return array Llista de despeses per mes.
      * @access public
      */
    public function retornaDespesesMensuals ( $any ) {
        $sql = "SELECT MONTH(t1.data) as Mes, sum(t2.importTotal) as Import FROM " . _DB_PREFIX_ . "viatges t1 left join
                (SELECT sum(importUnitari*unitats) as importTotal,idViatge FROM " . _DB_PREFIX_ . "viatges_det GROUP BY idViatge) as t2 on t1.idViatge=t2.idViatge 
                WHERE YEAR(t1.data)=" . $any . " GROUP BY MONTH(t1.data)";
        return $this->getRows ( $sql );
    }

}