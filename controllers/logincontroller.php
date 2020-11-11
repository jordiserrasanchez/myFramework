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
 * Filename logincontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe logincontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package logincontroller
 * @subpackage security
 * @version 1.0.0
 */
final class logincontroller extends controller {

    /**  @var string $model Conté el model */
    private $model;

    /**  @var string $nom Conté l'acció a realitzar */
    private $action;

    /**  @var string $nom Conté l'objecte usuari */
    public $usuari;
    
    
    private $idPolitica;
    private $modelPolitica;
    private $politica;

    private $modelParaula;
    private $hashParaula;
    
    public $error;
    private $paraulaPas;
    private $paraulaPasNova;
    private $paraulaNovaRepetida;
    private $correu;
    
     
    /** 
      * Inicialitza l'objecte.
      * @access public
      */     
    public function __construct() {
        
        /** estableix els valors inicials */
        $this->setInitValues ( );

        if ( filter_has_var( INPUT_GET, 'action' ) ) { /** si hi ha establerta una acció */

            /** recupera la acció */
            $this->action = filter_input( INPUT_GET, 'action' );

             /** executa l'acció recuperada */
            $this->doAction ( );
        
        } else { 

            $this->action = 'Login';
            $this->view = $_SESSION["viewPath"]  .'loginview.php';                 
        }

        
        
        /** realiza la sortida */
        $this->output ( );
    }


    /** 
      * Inicialitza els valors necessaris. 
      * @access private
      */
    private function setInitValues ( ) {
        
        /** crea l'objecte usuari */
        $this->model = new usuari ( );
        
        /** crea l'objecte paraula de pas */
        $this->modelParaula = new paraulapas ( );

    }
    
    /** Estableix el valors d'un usuari enviats mitjançant un formulari.
      * @access private
      */
    private function getPostValues ( ) {

        switch ( $this->action ) {

            case "Login":
                
                /** recupera els valors de formulari d'accés  */
                $this->getPostLoginValues ( );
                break;

            case "Change":
                
                /** recupera els valors del formulari de canvia de paraula */
                $this->getPostChangeValues ( );
                break;    
        
        }

    }
    
    /** Estableix el valors enviats mitjançant el formulari d'accés .
      * @access private
      */    
    private function getPostLoginValues ( ) {

        if ( ( filter_has_var ( INPUT_POST , 'correu' ) ) && ( filter_has_var ( INPUT_POST , 'paraulaPas' ) ) ) {

            $this->correu = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'correu' , FILTER_VALIDATE_EMAIL ) );                        
            $this->paraulaPas = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'paraulaPas' ) );  

        }

    }
    
    /** Estableix el valors enviats mitjançant el formulari de canvi.
      * @access private
      */    
    private function getPostChangeValues ( ) {

        if ( ( filter_has_var ( INPUT_POST, 'paraulaPasNova' ) && ( filter_has_var ( INPUT_POST , 'paraulaNovaRepetida' ) ) ) ) {

            $this->paraulaPasNova = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'paraulaPasNova' ) );
            $this->paraulaNovaRepetida = $this->model->link->real_escape_string( filter_input ( INPUT_POST , 'paraulaNovaRepetida' ) );

        }
    }
    
    /** 
      * Encamina l'acció. 
      * @access private
      */
    private function doAction ( ) {
        
        /** recuperem els valors de les variables POST que venen del formulari */
        $this->getPostValues ( );
        
        switch ( $this->action ) {

            case "Login":
                
                /** crida al mètode que exectua l'acció d'entrar */
                $this->doLogin (  );
                break;

            case "Change":

                /** crida al mètode que exectua l'acció de canviar */
                $this->doChange ( );
                break;    

        }
    
    }
    
    /** 
      * Accedeix a l'aplicació. 
      * @access private
      */    
    private function doLogin (  ) {

        
        /** crida al mètode que recupera l'usuari */
        $this->usuari = $this->model->getUsuariByEmail( $this->correu );

        /* realitza la verificació de l'accés */
        $this->loginWorkflow ( );

        
    }

    /** 
      * Canvia la paraula de pas. 
      * @access private
      */
    private function doChange (  ) {

        if ( $this->sonIguals ( ) ) { /** si les dues paraules de pas son iguals */

            /** recupera el identificador la politica de seguretat que afecta al usuari */
            $this->idPolitica = $this->model->getUsuariByEmail ( $_SESSION["usuari"] ) ['idPolitica'];

            /** crea un nou objecte politica  */
            $this->modelPolitica = new politica ( );

            /** recupera la politica de seguretat */
            $this->politica = $this->modelPolitica->getPoliticaById ( $this->idPolitica );

            if ( $this->compleixRequisitsPolitica ( ) ) { /** si acompleix amb els requisits de la política */

                /** crida al mètode que realitza el canvi de paraula de pas */
                $this->model->changePassword ( $_SESSION["usuari"] , $this->paraulaPasNova );
                
                /** estableix a 0 els intents */
                $this->model->setIntents ( $_SESSION["usuari"] , 0);
                
                /** estabeix la vista a mostrar */
                $this->view = $_SESSION["viewPath"]  .'dashboard' . _MYFW_ORG_ . 'view.php';

            }
        
        } else {
            
            /** crida al mètode per establir la vista a mostrar */
            $this->paraulesDiferents ( );
            
        }
    
    }
    
    /** 
      * Comprova si s'acompleixen els requisits de la política de seguretat
      * @return bool Valor booleà que indica si s'acompleix amb els requisits.
      * @access private
      */    
    private function compleixRequisitsPolitica (  ) {

        $ret = true;

        if ( !$this->requisitHistoria ( ) ) {  /** si no acompleix amb el requisit de història */

            $_SESSION["logout"] = "requisitHistoria";

            /** crida al mètode per mostrar l'error */
            $this->doError ( );
            $ret = false;

        }

        if ( !$this->requisitComplexitat ( ) ) { /** si no acompleix amb el requisit de complexitat */

            $_SESSION["logout"] = "requisitComplexitat";

            /** crida al mètode per mostrar l'error */
            $this->doError ( );
            $ret = false;

        }

        if ( !$this->requisitLongitud ( ) ) { /** si no acompleix amb el requisit de longitut */

            $_SESSION["logout"] = "requisitLongitut";

            /** crida al mètode per mostrar l'error */
            $this->doError ( );
            $ret = false;

        }

        return $ret;

    }
    
    /** 
      * Comprova si s'acompleix el requisit del historial de la paraula de pas
      * @return bool Valor booleà que indica si s'acompleix amb el requisit.
      * @access private
      */
    private function requisitHistoria ( ) {

        $ret = true;
        $order = "dataParaula desc";
        
        /** crida al mètode que recupera el historial de paraules de pas */
        $rows = $this->modelParaula->getLlistaParaulesPasById ( $this->model->getUsuariByEmail( $_SESSION["usuari"] ) ['idUsuari'] , $this->politica['umbralHistoria'] , $order );
        
        foreach ( $rows as $row ) { /** per cada paraula */
            
            if ( password_verify ( $this->paraulaPasNova , $row['paraulaPas'] ) ) {
            
                $ret = false;
            
            }

        }
        
        return $ret;
    
    }
    
    /** 
      * Comprova si s'acompleix el requisit de la complexitat de la paraula de pas
      * @return bool Valor booleà que indica si s'acompleix amb el requisit.
      * @access private
      */
    private function requisitComplexitat() {
        
        $ret = true;
        
        if ( $this->politica['requereixComplexitat'] <> 0 ) {  /** si la paraula de pas requereix complexitat */
            
            if( !preg_match( "#[0-9]+#", $this->paraulaPasNova ) ) { /** si no te un número */
            
                $ret = false;
            
            }

            if( !preg_match( "#[a-z]+#" , $this->paraulaPasNova ) ) { /** si no te una lletra minúscula */
            
                $ret = false;

            }

            if( !preg_match( "#[A-Z]+#" , $this->paraulaPasNova ) ) { /** si no te una llerea majúscula */
                
                $ret = false;
            
            }

            if( !preg_match( "#\W+#" , $this->paraulaPasNova ) ) { /* si no te un símbol */

                $ret = false;

            }
        
        }

        return $ret;
    
    }
    
    /** 
      * Comprova si s'acompleix el requisit de la longitut de la paraula de pas
      * @return bool Valor booleà que indica si s'acompleix amb el requisit.
      * @access private
      */
    private function requisitLongitud ( ) {

        $ret = true;

        if ( strlen ( $this->paraulaPasNova ) < $this->politica['longitutMinima'] ) { /** si la longitut de la nova paraula de pas és menor que la que estableix la política de seguretat */

            $ret = false;

        }
        
        return $ret;
    
    }
    
    /** 
      * Estableix la vista per mostra l'error
      * @access private
      */
    private function doError ( ) {

        /** crea l'objecte myfw_error */
        $this->error = new myfw_error ( );
        
        $this->view = $_SESSION["viewPath"] . 'errorview.php';        
        
    }    
    
    /** 
      * Mostra la vista. 
      * @access public
      */            
    public function output ( ) {

        /** mostra la vista que hi ha establerta*/ 
        $this->showView ( );
    
    }
    
    /** 
      * Comprova si existeix l'usuari
      * @return bool Valor booleà que indica si existeix l'usuari.
      * @access private
      */
    private function existUser ( ) {

        $ret = ( !is_null ( $this->usuari ) ) ? true : false;

        return $ret;
    }

    /** 
      * Comprova si el compte està confirmat
      * @return bool Valor booleà que indica si el compte està confirmat
      * @access private
      */
    private function accountConfirmed ( ) {
        
        $ret = ( $this->usuari['correuConfirmat'] == 1 ) ? true : false;

        return $ret;

    }
    
    /** 
      * Comprova si el compte està bloquejat per acumulació de intents erronis
      * @return bool Valor booleà que indica si el compte està bloquejat
      * @access private
      */
    private function accountLocked ( ) {

        $ret = ( $this->usuari['intents'] >= 3 ) ? true : false;

        return $ret;

    }
        
    /** 
      * Comprova si la paruala de pas coincideix amb el hash emmagatzemat
      * @return bool Valor booleà que indica si la paraula de pas coincideix amb el hash
      * @access private
      */
    private function checkPassword ( ) {
    
        /** crida al metòde que recupera el hash de la paraula de pas emmagatzemada a la BBDD.*/
        $this->hashParaula = $this->modelParaula->getParaulaPasById ( $this->usuari['idUsuari'] ) ['paraulaPas'];

        /** verifica que ambdues paraules sigui iguals al hash*/
        $ret = password_verify ( $this->paraulaPas , $this->hashParaula );

        return $ret;
         
    }
    
    /** 
      * Comprova si cal canviar la paraula de pas al iniciar la sessió
      * @return bool Valor booleà que indica si cal canviar la paraula de pas al iniciar la sessió
      * @access private
      */
    private function changePasswordNextLogon ( ) {
        
        $ret = ( $this->usuari['canviInici'] == 1 ) ? true : false;

        return $ret;
        
    }
    
    /** 
      * Comprova que les dues paraules de pas son iguals
      * @return bool Valor booleà que indica si ambdues paraules de pas son iguals
      * @access private
      */
    private function sonIguals ( ) {

        $ret = false;

        if ( $this->paraulaPasNova == $this->paraulaNovaRepetida ) { /** si son iguals */

            $ret = true;

        }
        
        return $ret;
        
    }
    
    /** 
      * Dona accés a l'usuari.
      * @access private
      */
    private function loginOk ( ) {
        
        /** crida al mètode que estableix els intents a 0. */
        $this->model->setIntents ( $this->correu , 0 );
        
        $_SESSION["usuari"] = $this->correu;
        $_SESSION["idUsuari"] = $this->model->getUsuariByEmail( $this->correu )['idUsuari'];
        
        /** carrega el menú */
        $_SESSION["menu"] = menu::getMenu();
        
        $this->view  = $_SESSION["viewPath"] . 'dashboard' . _MYFW_ORG_ . 'view.php';
        
    }
    
    /** 
      * Prepara la vista per el canvi de paraula de pas.
      * @access private
      */
    private function canviInici ( ) {
        
        $_SESSION["usuari"] = $this->correu;
        $this->view = $_SESSION["viewPath"] . 'changepassword.php';  
        
    }

    /** 
      * Afegeix un intent erroni  al compte de l'usuari.
      * @access private
      */
    private function afegeixIntent ( ) {
        
        /** crida al mètode que suma un intent erroni al compte del usuari */
        $this->model->setIntents ( $this->correu , $this->usuari['intents'] + 1 );
        $this->usuari['intents'] = $this->usuari['intents'] + 1;        
        
    }
    
    
    private function loginWorkflow ( ){
        
        if ( $this->existUser ( ) ) { /** si l'usuari existeix */
            
            if ( $this->accountConfirmed ( ) ) { /** si el compte està confirmat */
                
                if ( !$this->accountLocked ( ) ) { /** si el compte no està bloquejat */
                    
                    if ( $this->checkPassword ( ) ) { /** si les paraula de pas coincideix amb el hash */
                        
                        if ( !$this->changePasswordNextLogon ( ) ) {  /** si no cal canviar la paraula de pas al inici */
                        
                            /** crida al mètode que dona accés al usuari */ 
                            $this->loginok ( );
                            
                        } else {
                            
                            /** crida al mètode que permet fer el canvi de paraula de pas */
                            $this->canviInici ( );
                            
                        }
                        
                    } else { /** si la paraula de pas no existeix */
                        
                        /** crida al mètode que afegeix un intent erroni al compte del usuari */
                        $this->afegeixIntent ( );

                        if ( !$this->accountLocked ( ) ) { /** si el compte no està bloquejat */
                            
                            /** crida al mètode que prepara la vista per l'error de paraula de pas */
                            $this->errorParaula ( );
                            
                        } else {  
                            
                            /** crida al mètode que prepara la vista per el compte bloquejat */
                            $this->compteBloquejat ( );
                            
                        }
                        
                    }
                    
                } else { /** si el compte està bloquejat */
                    
                    /** crida al mètode que prepara la vista per el compte bloquejat */
                    $this->compteBloquejat ( );
                    
                }
                
            } else { /** si el compte no s'ha activat */
                
                /** crida al mètode que prepara la vista per el compte desactivat */
                $this->compteDesactivat ( );
                
            }
            
        } else { /** si l'usuari no existeix */
            
            /** crida al mètode que prepara la vista per usuari inexistent */
            $this->usuariInexistent ( );
            
        }
        
    }

    /** 
     * Crida a l'error de paraula de pas equivocada
     * @access private
     */
    private function errorParaula ( )  {
        
        $_SESSION["logout"] = "errorParaula";
        
        /** crida al mètode per mostrar l'error */
        $this->doError();
        
    }
        
    /** 
     * Crida a l'error de compte bloquejat
     * @access private
     */
    private function compteBloquejat() {
        
        $_SESSION["logout"] = "compteBloquejat";
        
        /** crida al mètode per mostrar l'error */
        $this->doError ( );
        
    }
    
    /** 
     * Crida a l'error de compte desactivat
     * @access private
     */
    private function compteDesactivat ( ) {
        
        $_SESSION["logout"] = "compteDesactivat";
        
        /** crida al mètode per mostrar l'error */
        $this->doError ( );
        
    }
    
    /** 
     * Crida a l'error d'usuari inexistent
     * @access private
     */
    private function usuariInexistent ( ) {
        
        $_SESSION["logout"] = "usuariInexistent";
        
        /** crida al mètode per mostrar l'error */
        $this->doError ( );
        
    }
    
    /** 
     * Crida a l'error de paraules de pas diferents
     * @access private
     */
    private function paraulesDiferents ( ) {
        
        $_SESSION["logout"] = "paraulesDiferents";
        
        /** crida al mètode per mostrar l'error */
        $this->doError ( );
        
    }
    
}