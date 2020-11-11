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
 * Filename viatge_det.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe viatge_det.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package viatge_det
 * @subpackage db
 * @version 1.0.0
 */
final class viatge_det extends db {
    
    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct(){
        $this->link=$this->connectar();
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de detalls d'un viatges. 
      * @param string $idViatge Clàusula WHERE de la consulta SQL.
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de detalls d'un viatge.
      * @access public
      */
    public function getLlistaViatges_det ( $idViatge, $limit = null, $order = null  ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "viatges_det WHERE idViatge = " . $idViatge;
        if ( !is_null ( $order ) ) {
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }
        return $this->getRows ( $sql );        
    }
    

   
    /** 
      * Retorna una matriu associativa amb un detall d'un viatge.
      * @param integer $idViatge_det Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa d'un detall d'un viatge.
      * @access public
      */

    public function getDetallViatgeById ( $idViatge_det ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "viatges_det WHERE idViatge_det = " . $idViatge_det;
       return $this->getRow ( $sql );  
    }
  
    /** 
      * Agfegeix un dellall de viatge a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixViatge_det ( $fields ) {
       $sql = "INSERT INTO " . _DB_PREFIX_ . "viatges_det (idViatge, concepte, importUnitari, unitats) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql ); 
    }
    
    /** 
      * Modifica un detall de viatge de la BBDD.
      * @param integer $idViatge_det Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function modificaViatge_det ( $idViatge_det, $fields ) {
        $sql = "UPDATE " . _DB_PREFIX_ . "viatges_det SET " . $fields . " WHERE idViatge_det=" . $idViatge_det;
        return $this->modifyRow ( $sql); 
    }

    /** 
      * Esborra un detall de viatge de la BBDD.
      * @param integer $idViatge_det Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraViatge_det ( $idViatge_det ) {
        $sql = "DELETE FROM "  ._DB_PREFIX_ . "viatges_det WHERE idViatge_det=" . $idViatge_det;
        return $this->deleteRow ( $sql ); 
    }
    
    /** 
      * Retorna el número total de detalls d'un viatges.
      * @param integer $idViatge_det Valor del camp per la clàusula WHERE de SQL.
      * @return array  Matriu d'una fila associativa del amb el número de detalls del viatge.
      * @access public
      */
    public function retornaNumeroViatgesDet ( $idViatge ) {
        $sql = "SELECT COUNT(*) as TotalViatgesDet FROM " . _DB_PREFIX_ . "viatges_det WHERE idViatge=" . $idViatge;
        return $this->getRow ( $sql ); 
        
    }    
}