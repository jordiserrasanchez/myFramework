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
 * Filename component.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe component.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package component
 * @subpackage db
 * @version 1.0.0
 */
final class component extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */    
    public function __construct ( ) {
        
        $this->link=$this->connectar ( );
        
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de components. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de components.
      * @access public
      */
    public function getLlistaComponents ( $limit = null, $order = null ) {
        
//        $sql = "SELECT * FROM " . _DB_PREFIX_ . "components";
        
        $sql = "SELECT c.idComponent, c.idModul, c.component, m.modul FROM " . _DB_PREFIX_ . "components c LEFT JOIN " . _DB_PREFIX_ . "moduls m ON c.idModul = m.idModul";
        
        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;

        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }

        return $this->getRows ( $sql );    
        
    }    
    
    /** 
      * Retorna una matriu associativa amb un component en funció del seu identificador.
      * @param integer $idComponent Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del component.
      * @access public
      */
    public function getComponentById ( $idComponent ) {
                
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "components WHERE idComponent = " . $idComponent;
       
       return $this->getRow ( $sql );        
       
    }
    /** 
      * Agfegeix un component a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function afegeixComponent ( $fields ) {
        
       $sql = "INSERT INTO " . _DB_PREFIX_ . "components (component) VALUES (" . $fields . ")";
       
        return $this->insertRow ( $sql ); 
        
    }
    /** 
      * Modifica un component de la BBDD.
      * @param integer $idComponent Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function modificaComponent ( $idComponent, $fields ) {
        
        $sql = "UPDATE " . _DB_PREFIX_ . "components SET " . $fields . " WHERE idComponent=" . $idComponent;
        
        return $this->modifyRow ( $sql ); 
        
    }

    /** 
      * Esborra un component de la BBDD.
      * @param integer $idComponent Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access publicc
      */
    public function esborraComponent ( $idComponent ) {
        
        $sql = "DELETE FROM " . _DB_PREFIX_ . "components WHERE idComponente=" . $idComponent;
        
        return $this->deleteRow ( $sql ); 
      
    }
    /** 
      * Retorna el número total de components.
      * @return array  Matriu d'una fila associativa del amb el número de components.
      * @access public
      */
    public function retornaNumeroComponents ( ) {
        
        $sql = "SELECT COUNT(*) as TotalComponents FROM " . _DB_PREFIX_ . "components";
        
        return $this->getRow ( $sql ); 
        
    }    
}