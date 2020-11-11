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
 * Filename resultatacces.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe resultatacces.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package resultatacces
 * @subpackage db
 * @version 1.0.0
 */
final class resultatacces extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */    
    public function __construct ( ) {
        
        $this->link=$this->connectar ( );
        
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de resultats d'accés. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de resultats d'accés.
      * @access public
      */
    public function getLlistaResultatAcces ( $limit = null, $order = null ) {
        
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "resultatacces";
        
        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;
            
        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }
        
        return $this->getRows ( $sql );    
        
    }    
    
    /** 
      * Retorna una matriu associativa amb un resultat d'accés en funció del seu identificador.
      * @param integer $idResultatAcces Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del resultat d'accés.
      * @access public
      */
    public function getAccessResultById ( $idResultatAcces ) {
                
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "resultatacces WHERE idResultatAcces = " . $idResultatAcces;
       
       return $this->getRow ( $sql );        
       
    }
    
    /** 
      * Retorna una matriu associativa amb un resultat d'accés en funció del seu identificador.
      * @param string $codi Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del resultat d'accés.
      * @access public
      */
    public function getAccessResultByCode ( $codi ) {
                
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "resultatacces WHERE codi = '" . $codi . "'";
       
       return $this->getRow ( $sql );        
       
    }
    

    /** 
      * Agfegeix un resultat d'accés a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function afegeixResultatAcces ( $fields ) {
        
       $sql = "INSERT INTO " . _DB_PREFIX_ . "resultatacces (codi,descripcio) VALUES (" . $fields . ")";
       
        return $this->insertRow ( $sql ); 
        
    }
    /** 
      * Modifica un resultat d'accés de la BBDD.
      * @param integer $idResultatAcces Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function modificaResultatAcces ( $idResultatAcces, $fields ) {
        
        $sql = "UPDATE " . _DB_PREFIX_ . "resultatacces SET " . $fields . " WHERE idResultatAcces=" . $idResultatAcces;
        
        return $this->modifyRow ( $sql ); 
        
    }

    /** 
      * Esborra un resultat d'accés de la BBDD.
      * @param integer $idResultatAcces Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access publicc
      */
    public function esborraResultatAcces ( $idResultatAcces ) {
        
        $sql = "DELETE FROM " . _DB_PREFIX_ . "resultatacces WHERE idResultatAcces=" . $idResultatAcces;
        
        return $this->deleteRow ( $sql ); 
      
    }
    /** 
      * Retorna el número total de resultats d'accés.
      * @return array  Matriu d'una fila associativa del amb el número de resultats d'accés.
      * @access public
      */
    public function retornaNumeroResultatsAcces ( ) {
        
        $sql = "SELECT COUNT(*) as TotalResultatAcces FROM " . _DB_PREFIX_ . "resultatacces";
        
        return $this->getRow ( $sql ); 
        
    }    
}