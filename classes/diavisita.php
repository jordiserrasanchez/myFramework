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
 * Create at 29-sep-2020 12:54:55
 * Project name myFramework
 * Project DisplayName myFramework
 * Filename diavisita.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe dia de visita.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package visites
 * @subpackage db
 * @version 1.0.0
 */
final class diavisita extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct(){
        $this->link = $this->connectar();
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de dies de visita. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de dies de visita.
      * @access public
      */
    public function getLlistaDiesVisites ( $limit = null, $order = null ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "diesvisites ";
        if ( !is_null ( $order ) ) {
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }
        return $this->getRows ( $sql );        
    }

    /** 
      * Retorna una matriu associativa amb una dia de visita en funció del seu identificador.
      * @param integer $idDiaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del dia de visita.
      * @access public
      */
    public function getDiaVisitaById ( $idDiaVisita ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "diesvisites WHERE idDiaVisita= " . $idDiaVisita;
       return $this->getRow ( $sql );        
    }
   
    
     /** 
      * Retorna una matriu associativa amb una dia de visita en funció del seu token.
      * @param integer $token Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del dia de visita.
      * @access public
      */   
    public function getDiaVisitaByToken ( $token ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "diesvisites WHERE token = '" . $token . "'";
        return $this->getRow ( $sql );        
    }    
    
    /** 
      * Agfegeix un dia de visita a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixDiaVisita ( $fields ) {
       $sql = "INSERT INTO " . _DB_PREFIX_ . "diesvisites (dataVisita, idDepartament, token) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql ); 
    }
    
    /** 
      * Esborra un dia de visita de la BBDD.
      * @param integer $idDiaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraDiaVisita ( $idDiaVisita ) {
        $sql = "DELETE FROM " . _DB_PREFIX_ . "diesvisites WHERE idDiaVisita=" . $idDiaVisita;
        return $this->deleteRow ( $sql ); 
      
    }

    /** 
      * Retorna el identificador de l'últim dia de visita que s'ha afegit a la BBDD.
      * @return integer Retorna el valor del identificador de l'últim dia de visita que s'ha introduït a la BBDD.
      * @access public
      */
    public function retornaUltimDiaVisitaAfegit ( ) {
        return $this->returnLastInsertId ( );
    }

    /** 
      * Retorna el número total de dies de visita.
      * @return array  Matriu d'una fila associativa del amb el número de dies de visita.
      * @access public
      */
    public function retornaNumeroDiesVisites ( ) {
        $sql = "SELECT COUNT(*) as TotalDiesVisites FROM " . _DB_PREFIX_ . "diesvisites";
        return $this->getRow ( $sql ); 
        
    }    

}