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
 * Filename modul.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe mòdul.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package modul
 * @subpackage db
 * @version 1.0.0
 */
final class modul extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */    
    public function __construct ( ) {
        
        $this->link=$this->connectar ( );
        
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de mòduls. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de mòduls.
      * @access public
      */
    public function getLlistaModuls ( $limit = null, $order = null ) {
        
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "moduls";
        
        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;
            
        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }
        
        return $this->getRows ( $sql );    
        
    }    
    
    /** 
      * Retorna una matriu associativa amb un mòdul en funció del seu identificador.
      * @param integer $idModul Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del mòdul.
      * @access public
      */
    public function getAddonById ( $idModul ) {
                
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "moduls WHERE idModul = " . $idModul;
       
       return $this->getRow ( $sql );        
       
    }
    /** 
      * Agfegeix un mòdul a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function afegeixModul ( $fields ) {
        
       $sql = "INSERT INTO " . _DB_PREFIX_ . "moduls (modul,controlador,icona,sistema,actiu) VALUES (" . $fields . ")";
       
        return $this->insertRow ( $sql ); 
        
    }
    /** 
      * Modifica un mòdul de la BBDD.
      * @param integer $idModul Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function modificaModul ( $idModul, $fields ) {
        
        $sql = "UPDATE " . _DB_PREFIX_ . "moduls SET " . $fields . " WHERE idModul=" . $idModul;
        
        return $this->modifyRow ( $sql ); 
        
    }

    /** 
      * Esborra un mòdul de la BBDD.
      * @param integer $idModul Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access publicc
      */
    public function esborraModul ( $idModul ) {
        
        $sql = "DELETE FROM " . _DB_PREFIX_ . "moduls WHERE idModul=" . $idModul;
        
        return $this->deleteRow ( $sql ); 
      
    }
    
    /** 
      * Retorna el número total de mòduls.
      * @return array  Matriu d'una fila associativa del amb el número de moduls.
      * @access public
      */
    public function retornaNumeroModuls ( ) {
        
        $sql = "SELECT COUNT(*) as TotalModuls FROM " . _DB_PREFIX_ . "moduls";
        
        return $this->getRow ( $sql ); 
        
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de mòduls de sistema. 
      * @return array Llista associativa de mòduls de sistema.
      * @access public
      */    
    public function getSystemAddons ( ) {
       
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "moduls WHERE sistema=1 AND actiu=1 ORDER BY modul ASC";
        
        return $this->getRows ( $sql ); 
        
    }
    
    /** 
      * Retorna una matriu associativa amb la llista de mòduls d'usuari. 
      * @return array Llista associativa de mòduls d'usuari.
      * @access public
      */    
    public function getUserAddons ( ) {
        
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "moduls WHERE sistema<>1 AND actiu=1 ORDER BY modul ASC";
        
        return $this->getRows ( $sql ); 
    }
 }