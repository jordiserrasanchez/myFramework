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
 * Filename errordb.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe errordb.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final
 * @license http://www.serraperez/licenses/
 * @package db
 * @subpackage utils
 * @version 1.0.0
 */
final class modalwindow {
    
    /**  @var string $cardheader Header de la card */
//    public $cardheader;
    
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
    public function __construct ( $title, $message )  {
        $this->showModalWindow ( $title, $message );
    }

    /** 
      * Estableix l'error de paraula de pas
      * @access private
      */    
    private function showModalWindow ( $title, $message ) {
//        $this->cardheader = 'Error (' . $errNumber . ')';
        $this->cardtitle = $title;
        $this->cardtext = $message;
        $this->cardbutton = 'Tornar';
    }
    
    
}



