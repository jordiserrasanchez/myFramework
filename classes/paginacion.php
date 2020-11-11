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
 * Filename paginacion.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe paginacion.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category model
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final
 * @license http://www.serraperez/licenses/
 * @package paginacion
 * @subpackage utils
 * @version 1.0.0
 */
final class paginacion {
    
    /** 
      * Retorna una cadena de text html amb la paginació
      * @param string $page Valor del camp per la clàusula WHERE de SQL.
      * @param string $tpages Valor del camp per la clàusula WHERE de SQL.
      * @param string $adjacents Valor del camp per la clàusula WHERE de SQL.
      * @return string Cadena amb les pàgines.
      * @access public
      */    
    public static function paginate ( $page, $tpages, $adjacents ) {
	$prevlabel = "&lsaquo; Anterior";
	$nextlabel = "Seg&uuml;ent &rsaquo;";
        $out = '<nav aria-label="Page navigation">';
        $out .= '<ul class="pagination pagination-sm">';

	
	/** Etiqueta pàgina anterior */
	if ( $page == 1 ) {
		$out .= "<li class='page-item disabled'><span><a class='page-link'>". $prevlabel . "</a></span></li>";
	} else if ( $page == 2 ) {
		$out .= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='load(1)'>" . $prevlabel . "</a></span></li>";
	}else {
		$out .= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='load(" . ( $page - 1 ) . ")'>" . $prevlabel . "</a></span></li>";

	}
	
	/** Etiqueta de la primera pàgina */
	if ( $page > ( $adjacents + 1 ) ) {
		$out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1)'>1</a></li>";
	}
	/** Interval */
	if ( $page > ( $adjacents + 2 ) ) {
		$out .= "<li><a>...</a></li><li><a>...</a></li>";
	}

	/** Pàignes */

	$pmin = ( $page > $adjacents ) ? ( $page - $adjacents ) : 1;
	$pmax = ( $page < ( $tpages - $adjacents ) ) ? ( $page + $adjacents ) : $tpages;
	for ( $i = $pmin; $i <= $pmax; $i++ ) {
		if ( $i == $page ) {
			$out .= "<li class='page-item active'><a class='page-link' >$i</a></li>";
		} else if ( $i == 1 ) {
			$out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1)'>" . $i . "</a></li>";
		} else {
			$out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(" . $i . ")'> ". $i . "</a></li>";
		}
	}

	/** Interval */

	if ( $page < ( $tpages - $adjacents - 1 ) ) {
		$out .= "<li><a>...</a></li><li><a>...</a></li>";
	}

	/** Etiqueta de l'última pàgina */

	if ( $page < ( $tpages - $adjacents ) ) {
		$out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load($tpages)'>". $tpages . "</a></li>";
	}

	/** Etiqueta pàgina següent */
	if ( $page < $tpages ) {
		$out .= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='load(" . ( $page + 1 ) . ")'>" . $nextlabel . "</a></span></li>";
	}else {
		$out .= "<li class='page-item disabled'><span><a class='page-link'>" . $nextlabel . "</a></span></li>";
	}
	
	$out .= "</ul>";
        $out .= "</nav>";
	return $out;
    }
}
?>