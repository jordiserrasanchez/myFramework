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
 * Filename bitacora.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe menu.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package bitacora
 * @subpackage bitacora
 * @version 1.0.0
 */
final class bitacora {
    /* usage: bitacora::savelog ( __FILE__ , __LINE__ , $mensaje ); */

    public static function savelog ( $file, $line, $texte ) {
        if ( _MYFW_LOG_ ) {
            $fh = fopen(_APP_DIR_."/log/myfw_log.txt", 'a') or die("Se produjo un error al crear el archivo");
            $text = date_format ( date_create ( "" ) , "Y-m-d H:i" ) . "\t".  "filename: " . $file . "\t". "line: " . $line . "\t". "msg: " .$texte . "\n";
            fwrite($fh, $text) or die("No se pudo escribir en el archivo");
            fclose($fh);
        }

    }
        
}


