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
 * Create at 23-sep-2020 12:54:55
 * Project name myFramework
 * Project DisplayName myFramework
 * Filename planillavisita.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe planilla visita.
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
final class planillavisita extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct(){
        $this->link = $this->connectar();
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de planilles visita. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de planilles visita.
      * @access public
      */
    public function getLlistaPlanillesVisita ( $limit = null, $order = null ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "planillesvisita ";
        if ( !is_null ( $order ) ) {
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }
        return $this->getRows ( $sql );        
    }

    /** 
      * Retorna una matriu associativa amb una planilla visita en funció del seu identificador.
      * @param integer $idPlanillaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa de la planilla visita.
      * @access public
      */
    public function getPlanillaVisitaById ( $idPlanillaVisita ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "planillesvisita WHERE idPlanillaVisita = " . $idPlanillaVisita;
       return $this->getRow ( $sql );        
    }
   
    /** 
      * Agfegeix una planilla visita a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixPlanillaVisita ( $fields ) {
       $sql = "INSERT INTO " . _DB_PREFIX_ . "planillesvisita (descripcioPlanillaVisita) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql ); 
    }
    
    /** 
      * Modifica una planilla visita de la BBDD.
      * @param integer $idPlanillaVisita Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function modificaPlanillaVisita ( $idPlanillaVisita, $fields ) {
        $sql = "UPDATE " . _DB_PREFIX_ . "planillesvisita SET " . $fields . " WHERE idPlanillaVisita=" . $idPlanillaVisita;
        return $this->modifyRow ( $sql ); 
    }

    /** 
      * Esborra una planilla visita de la BBDD.
      * @param integer $idPlanillaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraPlanillaVisita ( $idPlanillaVisita ) {
        $sql = "DELETE FROM " . _DB_PREFIX_ . "planillesvisita WHERE idPlanillaVisita=" . $idPlanillaVisita;
        return $this->deleteRow ( $sql ); 
      
    }

    /** 
      * Retorna el identificador del última planilla visita afegida que s'ha afegit a la BBDD.
      * @return integer Retorna el valor del identificador del última planilla visita que s'ha introduït a la BBDD.
      * @access public
      */
    public function retornaUltimaPlanillaVisitaAfegida ( ) {
        return $this->returnLastInsertId ( );
    }

    /** 
      * Retorna el número total de planilles visita.
      * @return array  Matriu d'una fila associativa del amb el número de planilles visita.
      * @access public
      */
    public function retornaNumeroPlanillesVisita ( ) {
        $sql = "SELECT COUNT(*) as TotalPlanillesVisita FROM " . _DB_PREFIX_ . "planillesvisita";
        return $this->getRow ( $sql ); 
        
    }    

}