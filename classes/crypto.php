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
 * Filename crypto.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe crypto.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final  
 * @license http://www.serraperez/licenses/
 * @package crypto
 * @subpackage db
 * @version 1.0.0
 */
final class crypto {
    
    /**  @var string $token Conté el token */
    private $token ;

    /** 
      * Inicialitza l'objecte. 
      * @access public
      */        
    function __construct ( ) {
        $this->token = $this->getToken ( );
    }     
    
    /** 
      * Crida al mètode que retorna una cadena aleatòria de 10 caràcters.
      * @return string Una cadena aleatòria de 10 caràcters.
      * @access public
      */
    public static function getToken ( ) {
        
        $str = substr ( str_shuffle ( 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789!$/()*' ), 0, 10 );    
        return $str;
    
    }
}