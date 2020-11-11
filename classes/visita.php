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
 * Filename visita.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe visites.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package visita
 * @subpackage db
 * @version 1.0.0
 */
final class visita extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */    
    public function __construct ( ) {
        $this->link=$this->connectar ( );
        
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de visites. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @param string $state Clàusula WHERE de la consulta SQL.
      * @param string $idDiaVisita Clàusula WHERE de la consulta SQL.
      * @return array Llista associativa de visites.
      * @access public
      */
    public function getLlistaVisites ( $idDiaVisita, $state = null, $limit = null, $order = null ) {
        
        switch ( $state ) {
            case "busy": /** Visites ocupades */
                $sql = "SELECT " . _DB_PREFIX_ . "horesdiavisita.*, " . _DB_PREFIX_ . "visites.*   FROM " . _DB_PREFIX_ . "horesdiavisita RIGHT JOIN " . _DB_PREFIX_ . "visites ON " . _DB_PREFIX_ . "horesdiavisita.idHoraDiaVisita = " . _DB_PREFIX_ . "visites.idHoraDiaVisita WHERE " . _DB_PREFIX_ . "horesdiavisita.idDiaVisita=" . $idDiaVisita;
                break;
            case "free": /** Visites lliures */
                $sql = "SELECT " . _DB_PREFIX_ . "horesdiavisita.* FROM " . _DB_PREFIX_ . "horesdiavisita LEFT JOIN " . _DB_PREFIX_ . "visites ON " . _DB_PREFIX_ . "horesdiavisita.idHoraDiaVisita = " . _DB_PREFIX_ . "visites.idHoraDiaVisita WHERE ((( " . _DB_PREFIX_ . "visites.idHoraDiaVisita) Is Null)) AND  " . _DB_PREFIX_ . "horesdiavisita.idDiaVisita=" . $idDiaVisita;
                break;
            default: /** Totes les visites */
                $sql = "SELECT " . _DB_PREFIX_ . "horesdiavisita.idHoraDiaVisita," . _DB_PREFIX_ . "horesdiavisita.idDiaVisita," . _DB_PREFIX_ . "horesdiavisita.descripcioHoraDiaVisita," . _DB_PREFIX_ . "horesdiavisita.horaEntrada," . _DB_PREFIX_ . "horesdiavisita.horaSortida,  " . _DB_PREFIX_ . "visites.idVisita, " . _DB_PREFIX_ . "visites.nomResident, " . _DB_PREFIX_ . "visites.nomVisitant FROM " . _DB_PREFIX_ . "horesdiavisita LEFT JOIN " . _DB_PREFIX_ . "visites ON " . _DB_PREFIX_ . "horesdiavisita.idHoraDiaVisita = " . _DB_PREFIX_ . "visites.idHoraDiaVisita WHERE ". _DB_PREFIX_ ."horesdiavisita.idDiaVisita=" . $idDiaVisita;
                break;
        }
        
        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;
            
        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }

        return $this->getRows ( $sql );    
        
    }    

    public function getLlistaVisitesById ( $idHoraDiaVisita ) {
        $sql = "SELECT " . _DB_PREFIX_ . "horesdiavisita.idHoraDiaVisita," . _DB_PREFIX_ . "horesdiavisita.idDiaVisita," . _DB_PREFIX_ . "horesdiavisita.descripcioHoraDiaVisita," . _DB_PREFIX_ . "horesdiavisita.horaEntrada," . _DB_PREFIX_ . "horesdiavisita.horaSortida,  " . _DB_PREFIX_ . "visites.idVisita, " . _DB_PREFIX_ . "visites.nomResident, " . _DB_PREFIX_ . "visites.nomVisitant FROM " . _DB_PREFIX_ . "horesdiavisita LEFT JOIN " . _DB_PREFIX_ . "visites ON " . _DB_PREFIX_ . "horesdiavisita.idHoraDiaVisita = " . _DB_PREFIX_ . "visites.idHoraDiaVisita WHERE ". _DB_PREFIX_ ."horesdiavisita.idHoraDiaVisita=" . $idHoraDiaVisita;
        return $this->getRows ( $sql );            
    }

    /** 
      * Retorna una matriu associativa amb una hora de visita en funció del seu identificador.
      * @param integer $idVisita Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa de l'hora de visita.
      * @access public
      */
    public function getVisitaById ( $idVisita ) {
                
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "visites WHERE idVisita = " . $idVisita;
       
       return $this->getRow ( $sql );        
       
    }

    
    
    /** 
      * Agfegeix una viista a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function afegeixVisita ( $fields ) {
        
       $sql = "INSERT INTO " . _DB_PREFIX_ . "visites (idHoraDiaVisita, nomResident, nomVisitant) VALUES (" . $fields . ")";
       return $this->insertRow ( $sql ); 
        
    }
    /** 
      * Modifica una visita de la BBDD.
      * @param integer $idVisita Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public function modificaVisita ( $idVisita, $fields ) {
        
        $sql = "UPDATE " . _DB_PREFIX_ . "visites SET " . $fields . " WHERE idVisita=" . $idVisita;  
        return $this->modifyRow ( $sql ); 
        
    }

    /** 
      * Esborra una visita de la BBDD.
      * @param integer $idVisita Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraVisita ( $idVisita ) {
        
        $sql = "DELETE FROM " . _DB_PREFIX_ . "visites WHERE idVisita=" . $idVisita;
        return $this->deleteRow ( $sql ); 
      
    }
    
    /** 
      * Esborra una visita en funcio de l'hora de viista de la BBDD.
      * @param integer $idHoraDiaVisita Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraVisitaById ( $idHoraDiaVisita ) {
        
        $sql = "DELETE FROM " . _DB_PREFIX_ . "visites WHERE idHoraDiaVisita=" . $idHoraDiaVisita;
        
        return $this->deleteRow ( $sql ); 
      
    }    
    
    
    /** 
      * Retorna una matriu associativa amb la llista de visites de la setmana. 
      * @param date $dataIncial Valor del camp per la clàusula WHERE de SQL.
      * @param date $dataFinal Valor del camp per la clàusula WHERE de SQL.
      * @return array Llista de despeses per mes.
      * @access public
      */
    public function retornaVisitesSetmana ( $dataIncial, $dataFinal ) {
        $sql = "SELECT t3.dataVisita, t2.horaEntrada, t2.horaSortida, t2.descripcioHoraDiaVisita, t1.*, t4.descripcioDepartament "
                . "FROM " . _DB_PREFIX_ . "visites t1 "
                . "LEFT JOIN " . _DB_PREFIX_ . "horesdiavisita t2 on t1.idHoraDiaVisita = t2.idHoraDiaVisita "
                . "LEFT JOIN " . _DB_PREFIX_ . "diesvisites t3 on t2.idDiaVisita = t3.idDiaVisita "
                . "LEFT JOIN " . _DB_PREFIX_ . "departaments t4 on t3.idDepartament = t4.idDepartament "
                . "WHERE t3.dataVisita between '" . $dataIncial . "' AND '" . $dataFinal . "' ORDER BY t3.dataVisita, t2.horaEntrada, t2.descripcioHoraDiaVisita, t4.descripcioDepartament ASC";
        return $this->getRows ( $sql );    
    }
    
}