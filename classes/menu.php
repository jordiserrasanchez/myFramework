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
 * Filename menu.php 
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
 * @package menu
 * @subpackage menu
 * @version 1.0.0
 */
final class menu {

 
    public static function getMenu ( ) {
        
        $model = new modul ( ) ;
        
        $modulsUsuari  = $model->getUserAddons ( );
        
        $modulsSistema = $model->getSystemAddons ( );
      
        $html = '<nav class="col-md-2 d-none d-md-block bg-light sidebar">';
        $html.= '   <div class="sidebar-sticky">';
        $html.= '       <ul class="nav flex-column">';
        $html.= '           <li class="nav-item">';
        $html.= '           <form name="form" action="index.php?controlador=Dashboard' . _MYFW_ORG_ . '&action=ViewList" method="post">';
        $html.= '           <input type="text" name="menu" id="menu" value="dashboard" hidden>';
        $html.= '            <button type="submit" name="submit" class="nav-link btn btn-link"><i class="fas fa-home"></i> Inici</button>';
        $html.= '           </form>';
        $html.= '           </li>';        
        
        $html.= '<hr class="mb-4">';

        /** mòduls d'usuari */
        foreach ( $modulsUsuari as $modul ) {
            if (permis::getPermisLectura ( $_SESSION['idUsuari'] , $modul["idModul"])) {
                $html.= '           <li class="nav-item">';
                $html.= '               <form name="form" action="index.php?controlador=' . $modul["controlador"] .'&action=ViewList" method="post">';
                $html.= '                   <input type="text" name="menu" id="menu" value="dashboard" hidden>';
                $html.= '                   <button type="submit" name="submit" class="nav-link btn btn-link">' . $modul["icona"] . ' ' . $modul["modul"] . '</button>';
                $html.= '               </form>';
                $html.= '           </li>';
            }
        }
        
        $html.= '<hr class="mb-4">';
        $usuariAdmin = usuari::isAdmin ( $_SESSION['idUsuari'] );
        /** mòduls sistema */
        foreach ( $modulsSistema as $modul ) {
            if ((permis::getPermisLectura ( $_SESSION['idUsuari'] , $modul["idModul"])) || $usuariAdmin ) {            
                $html.= '           <li class="nav-item">';
                $html.= '               <form name="form" action="index.php?controlador=' . $modul["controlador"] .'&action=ViewList" method="post">';
                $html.= '                   <input type="text" name="menu" id="menu" value="dashboard" hidden>';
                $html.= '                   <button type="submit" name="submit" class="nav-link btn btn-link">' . $modul["icona"] . ' ' . $modul["modul"] . '</button>';
                $html.= '               </form>';
                $html.= '           </li>';
           }
        }        

        $html.= '       </ul>';
        $html.= '   </div>';
        $html.= '</nav>'; 
        
        return $html;      
                
    }
}

?>