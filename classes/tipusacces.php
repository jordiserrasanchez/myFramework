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
 * Filename tipusacces.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe tipusacces.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package tipusacces
 * @subpackage db
 * @version 1.0.0
 */
final class tipusacces extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */    
    public function __construct ( ) {
        
        $this->link=$this->connectar ( );
        
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de tipus d'accés. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de tipus d'accés.
      * @access public
      */
    public function getLlistaTipusAcces ( $limit = null, $order = null ) {
        
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "tipusacces";
        
        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;
            
        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }
        
        return $this->getRows ( $sql );    
        
    }    
    
    /** 
      * Retorna una matriu associativa amb un tipus d'accéss en funció del seu identificador.
      * @param integer $idTipusAcces Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del tipus d'accés.
      * @access public
      */
    public function getAccesTypeById ( $idTipusAcces ) {
                
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "tipusacces WHERE idTipusAcces = " . $idTipusAcces;
       
       return $this->getRow ( $sql );        
       
    }

    /** 
      * Retorna una matriu associativa amb un tipus d'accéss en funció del seu identificador.
      * @param string $codi Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del tipus d'accés.
      * @access public
      */
    public function getAccesTypeByCode ( $codi ) {
                
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "tipusacces WHERE codi = '" . $codi . "'";
       
       return $this->getRow ( $sql );        
       
    }

    /** 
      * Agfegeix un tipsu d'accés a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function afegeixTipusAcces ( $fields ) {
        
       $sql = "INSERT INTO " . _DB_PREFIX_ . "tipusacces (codi,descripcio) VALUES (" . $fields . ")";
       
        return $this->insertRow ( $sql ); 
        
    }
    /** 
      * Modifica un tipus d'accés de la BBDD.
      * @param integer $idTipusAcces Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function modificaTipusAcces ( $idTipusAcces, $fields ) {
        
        $sql = "UPDATE " . _DB_PREFIX_ . "tipusacces SET " . $fields . " WHERE idTipusAcces=" . $idTipusAcces;
        
        return $this->modifyRow ( $sql ); 
        
    }

    /** 
      * Esborra un tipus d'accés de la BBDD.
      * @param integer $idTipusAcces Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access publicc
      */
    public function esborraTipusAcces ( $idTipusAcces ) {
        
        $sql = "DELETE FROM " . _DB_PREFIX_ . "tipusacces WHERE idTipusAcces=" . $idTipusAcces;
        
        return $this->deleteRow ( $sql ); 
      
    }
    /** 
      * Retorna el número total de tipus d'accesos.
      * @return array  Matriu d'una fila associativa del amb el número de tipus s'accesos
      * @access public
      */
    public function retornaNumeroTipusAcces ( ) {
        
        $sql = "SELECT COUNT(*) as TotalTipusAcces FROM " . _DB_PREFIX_ . "tipusacces";
        
        return $this->getRow ( $sql ); 
        
    }    
}