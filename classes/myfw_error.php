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
 * Filename myfw_error.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe myfw_error.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final
 * @license http://www.serraperez/licenses/
 * @package myfw_error
 * @subpackage utils
 * @version 1.0.0
 */
final class myfw_error {
    
    /**  @var string $cardheader Header de la card */
    public $cardheader;
    
    /**  @var string $cardtitle Títol de la card */
    public $cardtitle;

    /**  @var string $cardtext Texte de la card */
    public $cardtext;

    /**  @var string $cardbutton Botó de la card */
    public $cardbutton;

    /** 
      * Inicialitza l'objecte.
      * @access public
      */      
    public function __construct ( )  {
        switch ( $_SESSION["logout"] ) {
            case "errorParaula":
                
                $this->setErrorParaula ( );
                break;
            case "compteBloquejat":
                
                $this->setCompteBloquejat ( );
                break;
            case "compteDesactivat":
                
                $this->setCompteDesactivat ( );
                break;
            case "usuariInexistent":
                
                $this->setUsuariInexistent ( );
                break;
            case "requisitHistoria":
                
                $this->setRequisitHistoria ( );
                break; 
            case "requisitComplexitat":
                
                $this->setRequisitComplexitat ( );
                break;
            case "requisitLongitut":
                
                $this->setRequisitLongitut ( );
                break;
            case "paraulesDiferents":
                
                $this->setParaulesDiferents ( );
                break;
            case "formulariIncomplert":
                
                $this->setFormulariIncomplert ( );
                break;
            }
    }

    /** 
      * Estableix l'error de paraula de pas
      * @access private
      */    
    private function setErrorParaula ( ) {
        $this->cardheader = 'Accés denegat';
        $this->cardtitle = 'Paraula de pas errònea';
        $this->cardtext = 'La paraula de pas no coincideix.';
        $this->cardbutton = 'Tornar';
    }

    /** 
      * Estableix l'error de compte bloquejat
      * @access private
      */    
    private function setCompteBloquejat ( ) {
        $this->cardheader = 'Accés denegat';
        $this->cardtitle = 'Compte bloquejat';
        $this->cardtext = 'El seu compte ha estat bloquejat per superar el número màxim de intents permès.';
        $this->cardbutton = 'Restablir';
    }

    /** 
      * Estableix l'error de compte desactivat
      * @access private
      */    
    private function setCompteDesactivat ( ) {
        $this->cardheader = 'Accés denegat';
        $this->cardtitle = 'Compte no verificat';
        $this->cardtext = 'El seu compte encara no ha estat confirmat per l\'administrador.';
        $this->cardbutton = 'Tornar';
    }

    /** 
      * Estableix l'error d'usuari inexistent
      * @access private
      */    
    private function setUsuariInexistent ( ){
        $this->cardheader = 'Accés denegat';
        $this->cardtitle = 'Usuari inexistent';
        $this->cardtext = 'Comprovi el nom d\'usuari. L\'usuari no existeix.';
        $this->cardbutton = 'Tornar';
    }

    /** 
      * Estableix l'error de incompliment requisit història
      * @access private
      */    
    private function setRequisitHistoria ( ){
        $this->cardheader = 'Requisist incomplert';
        $this->cardtitle = 'Historial paraula de pas';
        $this->cardtext = 'La paraula de pas no acompleix la política de historial.';
        $this->cardbutton = 'Tornar';
    }
    
    /** 
      * Estableix l'error de incompliment requisit complexitat
      * @access private
      */    
    private function setRequisitComplexitat ( ){
        $this->cardheader = 'Requisist incomplert';
        $this->cardtitle = 'Complexitat paraula de pas';
        $this->cardtext = 'La paraula de pas no acompleix la política de complexitat.<br />Ha d\'incloure com a mínim un número, una lletra mínuscula, una lletra majúscula i un símbol.';
        $this->cardbutton = 'Tornar';
    }    
    
    /** 
      * Estableix l'error de incompliment requisit longitut
      * @access private
      */    
    private function setRequisitLongitut ( ){
        $this->cardheader = 'Requisist incomplert';
        $this->cardtitle = 'Longitut paraula de pas';
        $this->cardtext = 'La paraula de pas no acompleix la política de longitut.';
        $this->cardbutton = 'Tornar';
    }    

    /** 
      * Estableix l'error de paraules de pas diferents
      * @access private
      */    
    private function setParaulesDiferents ( ){
        $this->cardheader = 'Error';
        $this->cardtitle = 'Paruales de pas diferents';
        $this->cardtext = 'La paraules de pas no concideixen.';
        $this->cardbutton = 'Tornar';
    }    
    
    /** 
      * Estableix l'error de formulari incomplert
      * @access private
      */    
    private function setFormulariIncomplert ( ){
        $this->cardheader = 'Error';
        $this->cardtitle = 'Formulari inclomplert';
        $this->cardtext = 'Cal omplir tots els comps del formulari.';
        $this->cardbutton = 'Tornar';
    }    
    
    
}



