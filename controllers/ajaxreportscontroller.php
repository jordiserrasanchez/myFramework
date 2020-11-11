<?php
/** requereix el fitxer de constants  */
require_once ('../include/const.inc.php');

/** requereix el fitxer d'autocarga de clases  */
require_once ( '../include/autoload.php' );

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
 * Filename ajaxreportscontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxreportscontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxreportscontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxreportscontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */ 
    public function __construct ( ) {
        
        /** crida al mètoda que munta el informe */
        $this->reportGenerate ( );
    
    }
    
    
    /** 
      * Munta el informe.
      * @access private
      */ 
    private function reportGenerate ( ) {
        
        /** crea l'objecte mycustompdf */
        $this->model = new mycustompdf ( 'L' , 'mm' , 'A4' );
        
        $this->model->AliasNbPages ( );
        $this->model->AddPage ( );
        $this->model->SetFont ( 'Verdana','',8 );
        
        /** crea l'objecte viatge */
        $model = new viatge ( );

        if ( filter_has_var( INPUT_GET, 'informe' ) ) {  /** si hi ha establert un informe */
            switch ( filter_input( INPUT_GET, 'informe' ) ) {
                case 'Pendents':
                    
                    /** recupera la llista de viatges pendents */
                    $array_viatges = $model->retornaViatgesPendents ( );
                    break;
                case 'Abonades':
                    
                    /** recupera la llista de viatges abonats */
                    $array_viatges = $model->retornaViatgesAbonats ( );
                    break;
                case 'Totals':
                    
                    /** recupera la llista de tots els viatges */
                    $array_viatges = $model->retornaViatges ( );
                    break;
            }
        }    

        $viatge = 0;
        $posicion_linea = 20;
        $lineasnecesarias = 0;
        $lineasusuadas = 0;
        $importTotal = 0;
        
        foreach ( $array_viatges as $viatge ) { /** per cada viatge */
            
            /** crea l'objecte del detall d'un viatge */
            $model_det = new Viatge_det ( );
            
            /** recupera la llista de detalls d'un viatge */
            $array_detalls = $model_det->getLlistaViatges_det ( $viatge['idViatge'] );
            
            $lineasnecesarias = 1 + count( $array_detalls ) + 1;
            $lineasusuadas = ( $posicion_linea - 20 ) / 5;
            
            if ( $this->hihaespai( $this->model->PageNo ( ) , $lineasusuadas , $lineasnecesarias ) ) {  /** si hi ha espai crida al mètode que pinta el viatge */

                $importTotal = $importTotal + $this->pintaviatge ( $viatge , $array_detalls , $posicion_linea );
                
            } else { /** si no hi ha espai, afegeix una pàgina nova i crida al mètode que pinta el viatge */

                $this->model->AddPage ( );
                $posicion_linea = 13;
                $importTotal = $importTotal + $this->pintaviatge ( $viatge , $array_detalls , $posicion_linea );

            }


            $posicion_linea = $posicion_linea + ( $lineasnecesarias * 5 );// +5;
        }

        /** crida al mètode que pinta el total del viatge */
        $this->pintatotal ( $importTotal , $posicion_linea );

    }

    /** 
      * Pinta el total.
      * @access private
      */     
    private function pintatotal ( $import , $coordenadaY ) {

        $this->model->SetLineWidth ( 0.6);
        $this->model->line ( 10, $coordenadaY , 290 , $coordenadaY );
        $this->model->setXY ( 160 , $coordenadaY );        
        $this->model->SetFont ( 'Verdana' , 'B' , 8 );
        $this->model->Cell ( 60 , 5 , iconv ( 'UTF-8' , 'windows-1252' , 'Total despeses de desplaçament:' ) , 0 , 0 , 'R' );
        $this->model->setXY (220 , $coordenadaY );              
        $this->model->Cell ( 30 , 5 , $import . iconv ( 'UTF-8' , 'windows-1252' , ' €' ) , 0 , 0 , 'C' );    
        $this->model->SetFont ( 'Verdana','',8);

    }

    /** 
      * Pinta una linia del detall
      * @param object $detall Objecte detall.
      * @param integer $coordenadaY Posició de la coordenada Y.
      * @return float Import de la linia
      * @access private
      */ 
    private function pintadetallviatge ( $detall , $coordenadaY ) {

        $this->model->setXY ( 100 , $coordenadaY );        
        $this->model->Cell ( 60 , 5, iconv ( 'UTF-8' , 'windows-1252' , $detall['concepte'] ) , 0 , 0 );
        $this->model->setXY ( 160 , $coordenadaY );             
        $this->model->Cell ( 30 ,5 , $detall['importUnitari'] . iconv( 'UTF-8' , 'windows-1252' , ' €' ) , 0 , 0 , 'C' );
        $this->model->setXY ( 190 , $coordenadaY );              
        $this->model->Cell ( 30 , 5, $detall['unitats'] , 0 , 0 , 'C' );
        $this->model->setXY ( 220 , $coordenadaY );              
        $this->model->Cell( 30 , 5, $detall['unitats'] * $detall['importUnitari'] . iconv( 'UTF-8' , 'windows-1252' , ' €' ) , 0 , 0 , 'C' );

        return $detall['unitats'] * $detall['importUnitari'];

    }

    /** 
      * Pinta un viatge
      * @param object $viatge Objecte viatge.
      * @param array $array_detalls Matriu amb els detalls del viatge
      * @param integer $coordenadaY Posició de la coordenada Y.
      * @return float Import acumulat
      * @access private
      */     
    private function pintaviatge ( $viatge, $array_detalls , $coordenadaY ) {

        $this->model->setXY (10 , $coordenadaY );
        $this->model->Cell ( 30 , 5 , date_format ( date_create ( $viatge['data'] ) , 'd/m/Y' ) , 0 , 0 );
        $this->model->Cell ( 60 , 5 , $viatge['viatge'] , 0 , 0 );
        $importacumulat = 0;

        foreach ( $array_detalls as $detall ) { /** per cada detall */

            $coordenadaY = $coordenadaY + 5;
            
            $importacumulat = $importacumulat + $this->pintadetallviatge ( $detall , $coordenadaY );

        }

        $this->model->setXY ( 100 , $coordenadaY + 5 );        
        $this->model->Cell ( 60 , 5 , '' , 'T' , 0 );
        $this->model->setXY ( 160 , $coordenadaY + 5 );             
        $this->model->Cell ( 30 , 5 , '' , 'T' , 0 , 'C' );
        $this->model->setXY ( 190 , $coordenadaY + 5 );              
        $this->model->Cell ( 30 , 5 , 'Subtotal:' , 'T' , 0 , 'R' );
        $this->model->setXY ( 220 , $coordenadaY + 5 );              
        $this->model->Cell ( 30 , 5 , $importacumulat . iconv ( 'UTF-8' , 'windows-1252' , ' €' ) , 'T' , 0 , 'C' );

        return $importacumulat; 
    }
    
    /** 
      * Calcula si hi ha espai per pintar un viatge senser.
      * @param integer $pagina Número de pàgina actual.
      * @param ingeger $usadas Linies ja fetes servir.
      * @param integer $necesarias Linies necessaries.
      * @return bool Valor booleà que indica si hi ha espai o no.
      * @access private
      */     
    private function hihaespai ( $pagina , $usadas , $necesarias ) {

        $lineaspp = 31;
        $lineasps = 34;

        if ( $pagina < 2 ) { //pagina 1

            $disponibles = $lineaspp - $usadas;

        } else {

            $disponibles = $lineasps - $usadas;

        }

        if ( $disponibles >= $necesarias ) {

            return true;

        } else {

            return false;

        }

    }    
    
    /** 
      * Mostra la vista. 
      * @access public
      */
    public function render ( ) {
       
        /** realiza la sortida */
        $this->model->Output ( );

    }
    
}
