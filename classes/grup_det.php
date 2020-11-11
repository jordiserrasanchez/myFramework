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
 * Filename grup_det.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe grup_det.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package grup_det
 * @subpackage db
 * @version 1.0.0
 */
final class grup_det extends db {
    
    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct(){
        $this->link=$this->connectar();
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de detalls d'un grups. 
      * @param string $idGrup Clàusula WHERE de la consulta SQL.
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de detalls d'un grup.
      * @access public
      */
    public function getLlistaGrups_det ( $idGrup, $limit = null, $order = null  ) {
        
        $sql = "SELECT gd.idGrup_det, gd.idGrup, gd.idUsuari, u.nom, u.cognoms  FROM " . _DB_PREFIX_ . "grups_det gd LEFT JOIN " . _DB_PREFIX_ . "usuaris u ON gd.idUsuari = u.idUsuari WHERE gd.idGrup = " . $idGrup;
//        $sql = "SELECT * FROM " . _DB_PREFIX_ . "grups_det WHERE idGrup = " . $idGrup;
        
        if ( !is_null ( $order ) ) {
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }

        return $this->getRows ( $sql );        
    }
    

   
    /** 
      * Retorna una matriu associativa amb un detall d'un grup.
      * @param integer $idGrup_det Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa d'un detall d'un grup.
      * @access public
      */

    public function getDetallGrupById ( $idGrup_det ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "grups_det WHERE idGrup_det = " . $idGrup_det;
       return $this->getRow ( $sql );  
    }
  
    /** 
      * Agfegeix un dellall de grup a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixGrup_det ( $fields ) {
       $sql = "INSERT INTO " . _DB_PREFIX_ . "grups_det (idGrup, idUsuari) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql ); 
    }
    
    /** 
      * Modifica un detall de grup de la BBDD.
      * @param integer $idGrup_det Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function modificaGrup_det ( $idGrup_det, $fields ) {
        $sql = "UPDATE " . _DB_PREFIX_ . "grups_det SET " . $fields . " WHERE idGrup_det=" . $idGrup_det;
        return $this->modifyRow ( $sql); 
    }

    /** 
      * Esborra un detall de grup de la BBDD.
      * @param integer $idGrup_det Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraGrup_det ( $idGrup_det ) {
        $sql = "DELETE FROM "  ._DB_PREFIX_ . "grups_det WHERE idGrup_det=" . $idGrup_det;
        return $this->deleteRow ( $sql ); 
    }
    
    /** 
      * Retorna el número total de detalls d'un grups.
      * @param integer $idGrup_det Valor del camp per la clàusula WHERE de SQL.
      * @return array  Matriu d'una fila associativa del amb el número de detalls del grup.
      * @access public
      */
    public function retornaNumeroGrupsDet ( $idGrup ) {
        $sql = "SELECT COUNT(*) as TotalGrupsDet FROM " . _DB_PREFIX_ . "grups_det WHERE idGrup=" . $idGrup;
        return $this->getRow ( $sql ); 
        
    }    
}