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
 * Filename departament.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe departament.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package departament
 * @subpackage db
 * @version 1.0.0
 */
final class departament extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */    
    public function __construct ( ) {
        
        $this->link=$this->connectar ( );
        
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de departaments. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de departaments.
      * @access public
      */
    public function getLlistaDepartaments ( $limit = null, $order = null ) {
        
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "departaments";
        
        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;
            
        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }
        
        return $this->getRows ( $sql );    
        
    }    
    
    /** 
      * Retorna una matriu associativa amb un departament en funció del seu identificador.
      * @param integer $idDepartament Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del departament.
      * @access public
      */
    public function getDepartmentById ( $idDepartament ) {
                
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "departaments WHERE idDepartament = " . $idDepartament;
       
       return $this->getRow ( $sql );        
       
    }

    /** 
      * Agfegeix un departament a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function afegeixDepartament ( $fields ) {
        
       $sql = "INSERT INTO " . _DB_PREFIX_ . "departaments (descripcioDepartament) VALUES (" . $fields . ")";
       
        return $this->insertRow ( $sql ); 
        
    }
    /** 
      * Modifica un departament de la BBDD.
      * @param integer $idDepartament Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function modificaDepartament ( $idDepartament, $fields ) {
        
        $sql = "UPDATE " . _DB_PREFIX_ . "departaments SET " . $fields . " WHERE idDepartament=" . $idDepartament;
        
        return $this->modifyRow ( $sql ); 
        
    }

    /** 
      * Esborra un departament de la BBDD.
      * @param integer $idDepartament Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access publicc
      */
    public function esborraDepartament ( $idDepartament ) {
        
        $sql = "DELETE FROM " . _DB_PREFIX_ . "departaments WHERE idDepartament=" . $idDepartament;
        
        return $this->deleteRow ( $sql ); 
      
    }
    /** 
      * Retorna el número total de departaments.
      * @return array  Matriu d'una fila associativa del amb el número de departaments
      * @access public
      */
    public function retornaNumeroDepartaments ( ) {
        
        $sql = "SELECT COUNT(*) as TotalDepartaments FROM " . _DB_PREFIX_ . "departaments";
        
        return $this->getRow ( $sql ); 
        
    }    
}