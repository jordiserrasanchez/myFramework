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
 * Filename usuari.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe usuari.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package clases
 * @subpackage security
 * @version 1.0.0
 */
final class usuari extends db {
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */  
    function __construct ( ) {
        $this->link=$this->connectar ( );
    }    
    
    /** 
      * Retorna una matriu associativa amb la llista d'usuaris. 
      * @param string $limit Clàusula LIMIT de la consulta SQL.
      * @param string $order Clàusula ORDER BY de la consulta SQL.
      * @return array Llista associativa d'usuaris.
      * @access public
      */
    public function getLlistaUsuaris ( $limit = null, $order = null ) {
        //$sql = "SELECT * FROM " . _DB_PREFIX_ . "usuaris";
        
        $sql = "SELECT u.idUsuari, u.nom, u.cognoms, u.correu, u.correuConfirmat, u.intents, u.token, u.expiracioToken, u.noCaduca, 
            u.noBloqueja, u.canviInici, u.idPolitica, p.politica, p.umbralIntents, p.umbralCaducitat, p. umbralHistoria, p.requereixComplexitat, 
            p.longitutMinima FROM " . _DB_PREFIX_ . "usuaris u LEFT JOIN " . _DB_PREFIX_ . "politiques p ON u.idPolitica = p.idPolitica";
        
        
        if ( !is_null ( $order ) ) {
            $sql = $sql . " ORDER BY " . $order;
        }
        if ( !is_null ( $limit ) ) {
            $sql = $sql . " LIMIT " . $limit;
        }
        return $this->getRows ( $sql );        
    }
    
    /** 
      * Retorna una matriu associativa amb un usuari en funció del seu correu
      * @param string $email Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del viatge.
      * @access public
      */
    public function getUsuariByEmail ( $email ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "usuaris WHERE correu = '" . $email . "'";
        return $this->getRow ( $sql );        
    }

    /** 
      * Retorna una matriu associativa amb un usuari en funció del seu identificador.
      * @param integer $idUsuari Valor del camp per la clàusula WHERE de SQL.
      * @return array Matriu d'una fila associativa del viatge.
      * @access public
      */
    public function getUsuariById ( $idUsuari ) {
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "usuaris WHERE idUsuari = " . $idUsuari;
        return $this->getRow ( $sql );        
    }

    /** 
      * Estableix els intents.
      * @param string $email Valor del camp per la clàusula WHERE de SQL.
      * @param integer $intents Valor del camp per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */  
    public function setIntents ( $email, $intents ) {
        $sql = "UPDATE " . _DB_PREFIX_ . "usuaris SET intents=" . $intents . " WHERE correu = '" . $email . "'";
        return $this->executeQuery ( $sql );
        
    }
   
    /** 
      * Agfegeix un usuari a la BBDD.
      * @param integer $fields Valor dels camps per la clàusula VALUES de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */ 
    public function afegeixUsuari ( $fields ) {
        $sql = "INSERT INTO " . _DB_PREFIX_ . "usuaris (nom, cognoms, correu, correuConfirmat, intents, noCaduca, noBloqueja, canviInici, idPolitica) VALUES (" . $fields . ")";
        return $this->insertRow ( $sql );         
    }
    
    /** 
      * Modifica un usuari de la BBDD.
      * @param integer $idUsuari Valor del camp per la clàusula WHERE de SQL.
      * @param integer $fields Valor dels camps per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */
    public function modificaUsuari ( $idUsuari, $fields ) {
        
        $sql = "UPDATE " . _DB_PREFIX_ . "usuaris SET " . $fields . " WHERE idUsuari=" . $idUsuari;
        return $this->modifyRow ( $sql ); 
    }
   
    /** 
      * Esborra un usuari de la BBDD.
      * @param integer $idUsuari Valor del camp per la clàusula WHERE de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
      */ 
    public function esborraUsuari ( $idUsuari ) {
        $sql = "DELETE FROM " . _DB_PREFIX_ . "usuaris WHERE idUsuari=" . $idUsuari;
        return $this->deleteRow ( $sql ); 
      
    }
    
    /** 
      * Retorna el identificador del últim usuari que s'ha afegit a la BBDD.
      * @return integer Retorna el valor del identificador del últim usauri que s'ha introduït a la BBDD.
      * @access public
      */
    public function retornaUltimUsuariAfegit ( ) {
        return $this->returnLastInsertId ( );
    }
    
    
    /** 
      * Genera un token temporal per poder restablir la paraula de pas.
      * @param string $email Valor del camp per la clàusula WHERE de SQL.
      * @return string Un token temporal per restablir la paraula de pas.
      * @access public
    */  
    public function recuperaPassword ( $email ) {
        
        $token = '';
        
        /** Recupera l'usuari en funció del seu correu */ 
        $sql = "SELECT idUsuari FROM " . _DB_PREFIX_ . "usuaris WHERE correu = '" . $email . "'";
        $ret = $this->getRow ( $sql );  
        
        if ( $ret > 0 ) { /** si l'usuari existeix a la BBDD. */
            
            /** Mètode estàtic de la clase crypto que retorna un token aleatori */
            $token = crypto::getToken();
            $sql = "UPDATE  " . _DB_PREFIX_ . "usuaris SET token='" . $token . "', expiracioToken=DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE correu = '" . $email . "'";
            $ret = $this->modifyRow ( $sql ); 
        }
        
        return $token;
    }
    
    /** 
      * Restableix la paraula de pas d'un usuari.
      * @param string $email Valor del camp per la clàusula WHERE de SQL.
      * @param string $token Valor del camp per la clàusula WHERE de SQL.
      * @return string Un token temporal per restablir la paraula de pas.
      * @access public
    */  
    public function resetPassword ( $email , $token) {
        
        /** Recupera l'usuari en funció del seu correu i token */ 
        $sql = "SELECT idUsuari FROM " . _DB_PREFIX_ . "usuaris WHERE correu='" . $email . "' AND token='" . $token . "' AND token<>'' AND expiracioToken > NOW()";
        $ret = $this->getRow ( $sql ); 
        if ( $ret > 0 ) {  /** si l'usuari existeix a la BBDD i el token coincideix. */
            
            $fields = $ret['idUsuari'] . ",'";

            /** Buida el camp del token */
            $sql = "UPDATE " . _DB_PREFIX_ . "usuaris SET token='' WHERE correu='" . $email . "'";
            $ret = $this->executeQuery ( $sql );

            /** Mètode estàtic de la clase crypto que retorna un token aleatori */
            $token = crypto::getToken ( );
            
            /** Genera un hash per el token */
            $newPasswordEncrypted = password_hash($token, PASSWORD_BCRYPT);

            $dataPasword = date ( "Y-m-d H:i:s" );

            $fields = $fields . $newPasswordEncrypted . "','" . $dataPasword . "'";            
            
            /** Crea un objecte paraula de pas nou */
            $modelParaula = new paraulapas ( );
            
            /** Crida al mètode que afegeix la paraula de pas a la BBDD. */
            $modelParaula->afegeixParaula ( $fields );            

        }        
        return $token;
    }
    
    /** 
      * Inicialitza l'objecte.
      * @param string $email Valor del camp per la clàusula WHERE de SQL.
      * @param string $password Valor del camp per la clàusula SET de SQL.
      * @return bool Retorna un valor booleà que indica si s'ha realitzat exitosament.
      * @access public
    */    
    public function changePassword ( $email, $password ) {
        
        /** Recupera l'usuari en funció del seu correu */ 
        $sql = "SELECT idUsuari FROM " . _DB_PREFIX_ . "usuaris WHERE correu = '" . $email . "'";
        $ret = $this->getRow ( $sql ); 

        if ( $ret > 0 ) { /** si l'usuari existeix a la BBDD. */
            
            $fields = $ret['idUsuari'] . ",'";
            
            /** Genera un hash per la paraula de pas */
            $newPasswordEncrypted = password_hash ( $password, PASSWORD_BCRYPT );
            
            /* Posa a zero el comptador de intents */
            $sql = "UPDATE  " . _DB_PREFIX_ . "usuaris SET canviInici=0 WHERE correu = '" . $email . "'";
            $ret = $this->modifyRow ( $sql ); 
            
            $dataPasword = date ( "Y-m-d H:i:s" );

            $fields = $fields . $newPasswordEncrypted . "','" . $dataPasword . "'";            
            
            /** Crea un objecte paraula de pas nou */
            $modelParaula = new paraulapas ( );
            
            /** Crida al mètode que afegeix la paraula de pas a la BBDD. */
            $modelParaula->afegeixParaula ( $fields );            
        }
        return true;
    }    
    
    /** 
      * Retorna el número total d'usuaris.
      * @return array  Matriu d'una fila associativa del amb el número d'usuaris.
      * @access public
      */
    public function retornaNumeroUsuaris ( ) {
        $sql = "SELECT COUNT(*) as TotalUsuaris FROM " . _DB_PREFIX_ . "usuaris";
        return $this->getRow ( $sql ); 
        
    }    
}