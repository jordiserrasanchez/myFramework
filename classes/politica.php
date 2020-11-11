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
 * Filename politica.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe politica.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package politica
 * @subpackage db
 * @version 1.0.0
 */
final class politica extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct ( ){
        $this->link = $this->connectar ( );
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de politiques. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de politiques.
      * @access public
      */
    public function getLlistaPolitiques ( $limit = null, $order = null ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "politiques";
        if ( !is_null ( $order ) ) {
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }
        return $this->getRows ( $sql );        
    }

    /** 
      * Retorna una matriu associativa amb un politica.
      * @param integer $idPolitica Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa de la politica.
      * @access public
      */
    public function getPoliticaById ( $idPolitica ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "politiques WHERE idPolitica = " . $idPolitica;
       return $this->getRow ( $sql );        
    }
   
    /** 
      * Agfegeix una politica a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixPolitica ( $fields ) {
       $sql = "INSERT INTO " . _DB_PREFIX_ . "politiques (politica, umbralIntents, umbralCaducitat, umbralHistoria, requereixComplexitat, longitutMinima) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql ); 
    }
    
    /** 
      * Modifica una politica de la BBDD.
      * @param integer $idPolitica Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function modificaPolitica ( $idPolitica, $fields ) {
        $sql = "UPDATE " . _DB_PREFIX_ . "politiques SET " . $fields . " WHERE idPolitica=" . $idPolitica;
        return $this->modifyRow ( $sql ); 
    }

    /** 
      * Esborra una politica de la BBDD.
      * @param integer $idPolitica Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraPolitica ( $idPolitica) {
        $sql = "DELETE FROM " . _DB_PREFIX_ . "politiques WHERE idPolitica=" . $idPolitica;
        return $this->deleteRow ( $sql ); 
      
    }

    /** 
      * Retorna el identificador de l'última politica que s'ha afegit a la BBDD.
      * @return integer Retorna el valor del identificador de l'última politica que s'ha introduït a la BBDD.
      * @access public
      */
    public function retornaUltimaPoliticaAfegida ( ) {
        return $this->returnLastInsertId ( );
    }

    /** 
      * Retorna el número total de politiques.
      * @return array  Matriu d'una fila associativa del amb el número de politiques.
      * @access public
      */
    public function retornaNumeroPolitiques ( ) {
        $sql = "SELECT COUNT(*) as TotalPolitiques FROM " . _DB_PREFIX_ . "politiques";
        return $this->getRow ( $sql ); 
        
    }
}