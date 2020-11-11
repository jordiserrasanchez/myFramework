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
 * Filename concepte.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe concepte.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package concepte
 * @subpackage db
 * @version 1.0.0
 */
final class concepte extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */    
    public function __construct ( ) {
        
        $this->link=$this->connectar ( );
        
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de conceptes. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de conceptes.
      * @access public
      */
    public function getLlistaConceptes ( $limit = null, $order = null ) {
        
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "conceptes";
        
        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;
            
        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }
        
        return $this->getRows ( $sql );        
        
    }    
    
    /** 
      * Retorna una matriu associativa amb un concepte en funció del seu identificador.
      * @param integer $idConcepte Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del concepte.
      * @access public
      */
    public function getConcepteById ( $idConcepte ) {
        
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "conceptes WHERE idConcepte = " . $idConcepte;
       
       return $this->getRow ( $sql );        
       
    }
    /** 
      * Agfegeix un concepte a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function afegeixConcepte ( $fields ) {
        
       $sql = "INSERT INTO " . _DB_PREFIX_ . "conceptes (concepte, importUnitari, actiu) VALUES (" . $fields . ")";
       
        return $this->insertRow ( $sql ); 
        
    }
    /** 
      * Modifica un concepte de la BBDD.
      * @param integer $idConcepte Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function modificaConcepte ( $idConcepte, $fields ) {
        
        $sql = "UPDATE " . _DB_PREFIX_ . "conceptes SET " . $fields . " WHERE idConcepte=" . $idConcepte;
        
        return $this->modifyRow ( $sql ); 
        
    }

    /** 
      * Esborra un concepte de la BBDD.
      * @param integer $idConcepte Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraConcepte ( $idConcepte ) {
        
        $sql = "DELETE FROM " . _DB_PREFIX_ . "conceptes WHERE idConcepte=" . $idConcepte;
        
        return $this->deleteRow ( $sql ); 
      
    }
    
    /** 
      * Retorna el número total de conceptes.
      * @return array  Matriu d'una fila associativa del amb el número de conceptes.
      * @access public
      */
    public function retornaNumeroConceptes ( ) {
        
        $sql = "SELECT COUNT(*) as TotalConceptes FROM " . _DB_PREFIX_ . "conceptes";
        
        return $this->getRow ( $sql ); 
        
    }    
}