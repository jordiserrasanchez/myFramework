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
 * Filename permis.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe permis.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @final 
 * @license http://www.serraperez/licenses/
 * @package permis
 * @subpackage db
 * @version 1.0.0
 */
final class permis extends db {

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */
    public function __construct ( ){
        
        $this->link = $this->connectar ( );
        
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista de permisos. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @param string $tipus Clàusula WHERER de la consulta SQL.
      * @return array Llista associativa de permisos.
      * @access public
      */
    public function getLlistaPermisos ( $limit = null, $order = null, $tipus = null ) {
        
        if ( $tipus == 0 ) { /** filtra per grups */

            $sql = "SELECT p.idPermis, p.idModul, p.tipus, p.id, p.permis, m.modul, u.nom, u.cognoms FROM " . _DB_PREFIX_ . "permisos p LEFT JOIN " . _DB_PREFIX_ . "moduls m ON p.idModul = m.idModul LEFT JOIN " . _DB_PREFIX_ . "usuaris u ON p.id=u.idUsuari WHERE p.tipus=0";

        } else {

            $sql = "SELECT p.idPermis, p.idModul, p.tipus, p.id, p.permis, m.modul, g.grup FROM " . _DB_PREFIX_ . "permisos p LEFT JOIN " . _DB_PREFIX_ . "moduls m ON p.idModul = m.idModul LEFT JOIN " . _DB_PREFIX_ . "grups g ON p.id=g.idGrup WHERE p.tipus=1";

        }

        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;
            
        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }
        
        return $this->getRows ( $sql );        
        
    }

    /** 
      * Retorna una matriu associativa amb la llista de permisos. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de permisos.
      * @access public
      */
    public function getLlistaUsuarisPermisos ( $limit = null, $order = null ) {


        $sql = "SELECT u.idUsuari, u.nom, u.cognoms FROM " . _DB_PREFIX_ . "permisos p LEFT JOIN " . _DB_PREFIX_ . "moduls m ON p.idModul = m.idModul LEFT JOIN " . _DB_PREFIX_ . "usuaris u ON p.id=u.idUsuari WHERE p.tipus=0 GROUP BY u.idUsuari";
        
        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;
            
        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }
        
        return $this->getRows ( $sql );        
        
    }
    
    /** 
      * Retorna una matriu associativa amb la llista de permisos. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa de permisos.
      * @access public
      */
    public function getLlistaGrupsPermisos ( $limit = null, $order = null ) {
        
        $sql = "SELECT g.idGrup, g.grup FROM " . _DB_PREFIX_ . "permisos p LEFT JOIN " . _DB_PREFIX_ . "moduls m ON p.idModul = m.idModul LEFT JOIN " . _DB_PREFIX_ . "grups g ON p.id=g.idGrup WHERE p.tipus = 1 GROUP BY g.idGrup";

        if ( !is_null ( $order ) ) {
            
            $sql = $sql . " ORDER BY " . $order;
            
        }
        
        if ( !is_null ( $limit ) ) {
            
            $sql = $sql . " LIMIT " . $limit;
            
        }
        
        return $this->getRows ( $sql );        
        
    }
    
    /** 
      * Retorna una matriu associativa amb la llista d'usuaris sense permisos. 
      * @return array Llista associativa d'usuaris disponibles sense permisos.
      * @access public
      */
    public function getLlistaUsuarisDisponibles ( ) {

        $sql = "SELECT idUsuari, nom, cognoms FROM " . _DB_PREFIX_ . "usuaris where correuConfirmat=1 and idUsuari not in (select distinct id from " . _DB_PREFIX_ . "permisos where tipus=0)";
        
        return $this->getRows ( $sql );        
        
    }
    
    /** 
      * Retorna una matriu associativa amb la llista de grups sense permisos. 
      * @return array Llista associativa de grups sense permisos.
      * @access public
      */
    public function getLlistaGrupsDisponibles ( ) {

        $sql = "SELECT idGrup, grup FROM " . _DB_PREFIX_ . "grups where idGrup not in (select distinct id from " . _DB_PREFIX_ . "permisos where tipus=1)";
        
        return $this->getRows ( $sql );        
        
    }
    
    /** 
      * Retorna una matriu associativa amb els permisos d'un grup.
      * @param integer $idGrup Valor del camp per la clàusula WHERE de SQL.
      * @return array Llista associativa amb els permisos d'un grup.
      * @access public
      */
    public function getPermisosByGrup ( $idGrup ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "permisos WHERE tipus=1 AND id = " . $idGrup;
       return $this->getRows ( $sql );        
    }
   
    /** 
      * Retorna una matriu associativa amb els permisos d'un usuari.
      * @param integer $idUsuari Valor del camp per la clàusula WHERE de SQL.
      * @return array Llista associativa amb els permisos d'un usuari.
      * @access public
      */
    public function getPermisosByUsuari ( $idUsuari ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "permisos WHERE tipus=0 AND id = " . $idUsuari;
       return $this->getRows ( $sql );        
    }
   
    /** 
      * Retorna una matriu associativa amb un permis.
      * @param integer $idPermis Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del permis.
      * @access public
      */
    public function getPermisById ( $idPermis ) {
       $sql = "SELECT * FROM " . _DB_PREFIX_ . "permisos WHERE idPermis = " . $idPermis;
       return $this->getRow ( $sql );        
    }
   
    /** 
      * Agfegeix un permis a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function afegeixPermis ( $fields ) {
       $sql = "INSERT INTO " . _DB_PREFIX_ . "permisos (idModul, tipus, id, permis) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql ); 
    }
    
    /** 
      * Modifica un permis de la BBDD.
      * @param integer $idPermis Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function modificaPermis ( $idPermis, $fields ) {
        $sql = "UPDATE " . _DB_PREFIX_ . "permisos SET " . $fields . " WHERE idPermis=" . $idPermis;
        return $this->modifyRow ( $sql ); 
    }

    /** 
      * Esborra un permís de la BBDD.
      * @param integer $idPolitica Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraPermis ( $idPermis) {
        $sql = "DELETE FROM " . _DB_PREFIX_ . "permisos WHERE idPermis=" . $idPermis;
        return $this->deleteRow ( $sql ); 
      
    }
      
    /** 
      * Esborra un els permisos d'un grup de la BBDD.
      * @param integer $idGrup Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraPermisosGrup ( $idGrup ) {
        $sql = "DELETE FROM " . _DB_PREFIX_ . "permisos WHERE tipus=1 AND id=" . $idGrup;
        return $this->deleteRow ( $sql ); 
      
    }

    /** 
      * Esborra un els permisos d'un usuari de la BBDD.
      * @param integer $idUsuari Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function esborraPermisosUsuari ( $idUsuari ) {
        $sql = "DELETE FROM " . _DB_PREFIX_ . "permisos WHERE tipus=0 AND id=" . $idUsuari;
        return $this->deleteRow ( $sql ); 
      
    }

    /** 
      * Retorna el identificador de l'últim permís que s'ha afegit a la BBDD.
      * @return integer Retorna el valor del identificador de l'últim permís que s'ha introduït a la BBDD.
      * @access public
      */
    public function retornaUltimPermisAfegit ( ) {
        return $this->returnLastInsertId ( );
    }

    /** 
      * Retorna el número total de permisos.
      * @param string $tipus Clàusula WHERE de la consulta SQL.
      * @return array  Matriu d'una fila associativa del amb el número de permisos.
      * @access public
      */
    public function retornaNumeroPermisos ( $tipus ) {
        
        if ( $tipus == 1 ) { /** filtra per grups */
            
            $sql = "SELECT COUNT(*) AS TotalPermisos FROM (SELECT g.idGrup FROM " . _DB_PREFIX_ . "permisos p LEFT JOIN " . _DB_PREFIX_ . "moduls m ON p.idModul = m.idModul LEFT JOIN myfw_grups g ON p.id=g.idGrup WHERE p.tipus = 1 GROUP BY g.idGrup) as dvt";
            
        } else  {
            
            $sql = "SELECT COUNT(*) AS TotalPermisos FROM (SELECT u.idUsuari FROM " . _DB_PREFIX_ . "permisos p LEFT JOIN " . _DB_PREFIX_ . "moduls m ON p.idModul = m.idModul LEFT JOIN " . _DB_PREFIX_ . "usuaris u ON p.id=u.idUsuari WHERE p.tipus=0 GROUP BY u.idUsuari) as dvt";
            
        }
        
        return $this->getRow ( $sql ); 
        
    }
    
    /** 
      * Comprova si un usuari te permisos de lectura sobre un mòdul.
      * @param string $idUsuari Identificador de l'usuari.
      * @param string $idModul Identificador del mòdul.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */    
    public static function getPermisLectura ( $idUsuari , $idModul ) {
        $ret = false;
        
       /** crea l'objecte base de dades */  
        $db = new db ();
        
        $sql = "SELECT permis FROM " . _DB_PREFIX_ . "permisos WHERE tipus=0 AND id=" . $idUsuari . " AND idModul=" . $idModul;
        $row = $db->getRow ( $sql );
        
        if ( $row != false ) { /** si torna resultats */
            if ( count ( $row ) > 0 ) {
                if ( $row['permis'] >= 1 ) {
                    $ret = true;

                }
            }
        }
        
        if ( $ret == false) { /** si amb els usuaris no hi ha hagut exit */
            
            /** crea l'objecte del model grup */
            $modelGrup = new grup();

            /** recupera una llista de grups en la que es troba l'usuari */
            $grups = $modelGrup->getLlistaGrupsByUser( $idUsuari );

            foreach ($grups as $grup) { /* per cada linia retornada */

                $sql = "SELECT permis FROM " . _DB_PREFIX_ . "permisos WHERE tipus=1 AND id=" . $grup['idGrup'] . " AND idModul=" . $idModul;
                $row = $db->getRow ( $sql );
               
                if (!is_null( $row )) {
                    
                    if ( $row['permis'] >= 1 ) {
                        $ret = true;
                    }
                }
                
            }
        }
        
        return $ret;
    }
 
    /** 
      * Comprova si un usuari te permisos d'escriptura sobre un mòdul.
      * @param string $idUsuari Identificador de l'usuari.
      * @param string $idModul Identificador del mòdul.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */     
    public static function getPermisEscriptura ( $idUsuari , $idModul ) {
        $ret = false;
        
        /** crea l'objecte base de dades */
        $db = new db ();        
        
        $sql = "SELECT permis FROM " . _DB_PREFIX_ . "permisos WHERE tipus=0 AND id=" . $idUsuari . " AND idModul=" . $idModul;
        $row = $db->getRow ( $sql );
        if ( $row != false ) { /** si torna resultats */
            if ( count ( $row ) > 0 ) {
                if ( $row['permis'] > 1 ) {
                    $ret = true;

                }
            }
        }
        
        if ( $ret == false) { /** si amb els usuaris no hi ha hagut exit */
        
            /** crea l'objecte del model grup */
            $modelGrup = new grup();
            
            /** recupera una llista de grups en la que es troba l'usuari */
            $grups = $modelGrup->getLlistaGrupsByUser( $idUsuari );
            
            foreach ($grups as $grup) { /* per cada linia retornada */
                
               $sql = "SELECT permis FROM " . _DB_PREFIX_ . "permisos WHERE tipus=1 AND id=" . $grup['idGrup'] . " AND idModul=" . $idModul;
               $row = $db->getRow ( $sql );
                if (!is_null( $row )) {
                    if ( $row['permis'] > 1 ) {
                        $ret = true;
            
                    }
                }
            }
        }
        
        return $ret;
    }
      
}