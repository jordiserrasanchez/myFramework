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
 * Filename horadiavisita.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe horadiavisita.
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
final class horadiavisita extends db {
    
    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct(){
        $this->link=$this->connectar();
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista d'hores d'un dia de visita.
      * @param string $idDiaVisita Clàusula WHERE de la consulta SQL.
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de trams d'un dia visita. 
      * @access public
      */
    public function getLlistaHoresDiaVisita ( $idDiaVisita, $limit = null, $order = null  ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "horesdiavisita WHERE idDiaVisita = " . $idDiaVisita;
        if ( !is_null ( $order ) ) {
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }
        return $this->getRows ( $sql );        
    }
   
    /** 
      * Retorna una matriu associativa amb una hora d'un dia de visita.
      * @param integer $idHoraDiaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa d'un tram d'una planilla visita.
      * @access public
      */

    public function getHoraDiaVisitaById ( $idHoraDiaVisita ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "horesdiavisita WHERE idHoraDiaVisita = " . $idHoraDiaVisita;
       return $this->getRow ( $sql );  
    }
  
    /** 
      * Agfegeix una hora d'un dia de visita a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixHoraDiaVisita ( $fields ) {
       $sql = "INSERT INTO " . _DB_PREFIX_ . "horesdiavisita (idDiaVisita, descripcioHoraDiaVisita, horaEntrada, horaSortida) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql ); 
    }
    
    /** 
      * Esborra una hora d'un dia de visita de la BBDD.
      * @param integer $idHoraDiaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraHoraDiaVisita ( $idHoraDiaVisita ) {
        $sql = "DELETE FROM "  ._DB_PREFIX_ . "horesdiavisita WHERE idHoraDiaVisita=" . $idHoraDiaVisita;
        return $this->deleteRow ( $sql ); 
    }
    
    /** 
      * Retorna el número total d'hores d'un dia de visita.
      * @param integer $idDiaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return array  Matriu d'una fila associativa del amb el número d'hores d'un dia de visita.
      * @access public
      */
    public function retornaNumeroHoresDiaVisita ( $idDiaVisita ) {
        $sql = "SELECT COUNT(*) as TotalHoresDiaVisita FROM " . _DB_PREFIX_ . "horesdiavisita WHERE idDiaVisita=" . $idDiaVisita;
        return $this->getRow ( $sql ); 
        
    }        
   
}