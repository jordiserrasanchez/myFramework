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
 * Create at 24-sep-2020 12:54:55
 * Project name myFramework
 * Project DisplayName myFramework
 * Filename tramplanillavisita.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe tramplanillavisita.
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
final class tramplanillavisita extends db {
    
    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct(){
        $this->link=$this->connectar();
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de trams d'una planilla visita. 
      * @param string $idPlanillaVisita Clàusula WHERE de la consulta SQL.
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de trams d'una planilla visita. 
      * @access public
      */
    public function getLlistaTramsPlanillaVisita ( $idPlanillaVisita, $limit = null, $order = null  ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "tramsplanillavisita WHERE idPlanillaVisita = " . $idPlanillaVisita;
        if ( !is_null ( $order ) ) {
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }
        return $this->getRows ( $sql );        
    }
   
    /** 
      * Retorna una matriu associativa amb un tram d'una planilla visita.
      * @param integer $idTramPlanillaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa d'un tram d'una planilla visita.
      * @access public
      */

    public function getTramPlanillaVisitaById ( $idTramPlanillaVisita ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "tramsplanillavisita WHERE idTramPlanillaVisita = " . $idTramPlanillaVisita;
       return $this->getRow ( $sql );  
    }
  
    /** 
      * Agfegeix un tram de planilla visita a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixTramPlanillaVisita ( $fields ) {
       $sql = "INSERT INTO " . _DB_PREFIX_ . "tramsplanillavisita (idPlanillaVisita, descripcioTramPlanillaVisita, horaEntrada, horaSortida) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql ); 
    }
    
    /** 
      * Modifica un tram de la planilla visita de la BBDD.
      * @param integer $idTramPlanillaVisita Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function modificaTramPlanillaVisita ( $idTramPlanillaVisita, $fields ) {
        $sql = "UPDATE " . _DB_PREFIX_ . "tramsplanillavisita SET " . $fields . " WHERE idTramPlanillaVisita=" . $idTramPlanillaVisita;
        return $this->modifyRow ( $sql); 
    }

    /** 
      * Esborra un tram de la planilla visita de la BBDD.
      * @param integer $idTramPlanillaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraTramPlanillaVisita ( $idTramPlanillaVisita ) {
        $sql = "DELETE FROM "  ._DB_PREFIX_ . "tramsplanillavisita WHERE idTramPlanillaVisita=" . $idTramPlanillaVisita;
        return $this->deleteRow ( $sql ); 
    }
    
    /** 
      * Retorna el número total de trams d'una planilla visita.
      * @param integer $idPlanillaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return array  Matriu d'una fila associativa del amb el número de trams d'una planilla visita.
      * @access public
      */
    public function retornaNumeroTramsPlanillaVisita ( $idPlanillaVisita ) {
        $sql = "SELECT COUNT(*) as TotalTramsPlanillaVisita FROM " . _DB_PREFIX_ . "tramsplanillavisita WHERE idPlanillaVisita=" . $idPlanillaVisita;
        return $this->getRow ( $sql ); 
        
    }        
   
}