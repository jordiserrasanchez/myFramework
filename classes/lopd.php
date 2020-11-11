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
 * Filename lopd.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe lopd.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package lopd
 * @subpackage db
 * @version 1.0.0
 */
final class lopd extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct ( ){
        
        $this->link = $this->connectar ( );
        
    }    

    /** 
      * Retorna una matriu associativa amb la llista de registres. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de registres.
      * @access public
      */
    public function getLlistaRegistres ( $limit = null, $order = null ) {
        
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "lopd";
        
        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;
            
        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }
        
        return $this->getRows ( $sql );        
        
    } 
    
    /** 
      * Retorna el número total de registres.
      * @return array  Matriu d'una fila associativa del amb el número de registres.
      * @access public
      */
    public function retornaNumeroRegistres ( ) {
        
        $sql = "SELECT COUNT(*) as TotalRegistres FROM " . _DB_PREFIX_ . "lopd";
        
        return $this->getRow ( $sql ); 
        
    }     
    
    public static function afegeixRegistre ( $idUsuari , $tipusAccio , $txtTipusAccio , $resultatAccio , $txtResultatAccio , $idModul , $txtModul , $observacions , $dataRegistre ) {
        
        $db = new db ();
        $sql = "INSERT INTO " . _DB_PREFIX_ . "lopd (idUsuari, tipusAccio, txtTipusAccio, resultatAccio, txtResultatAccio, idModul, txtModul, observacions, dataRegistre) VALUES (" 
            . $idUsuari . ",'" .  $tipusAccio  . "','" . $txtTipusAccio . "','" . $resultatAccio . "','" . $txtResultatAccio . "'," . $idModul . ",'" . $txtModul . "','". $observacions . "','". $dataRegistre . "')";

        $db->executeQuery ( $sql );

    }

} 
