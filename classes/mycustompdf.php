<?php
/** requereix el fitxer amb la clase */
require ( '../assets/fpdf/fpdf.php' );

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
 * Filename mycustompdf.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe mycustompdf.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category clases
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package mycustompdf
 * @subpackage reports
 * @version 1.0.0
 */
final class mycustompdf extends FPDF {
    
    /** 
      * Funció de personalització de l'encapçalat.
      * @access public
      */     
    function Header ( )  {
        /** Logo */
        //$this->Image('logo_pb.png',10,8,33);
        $this->AddFont ( 'Verdana' , '' , 'verdana.php' );
        $this->AddFont ( 'Verdana' , 'B' , 'verdanab.php' );
        $this->AddFont ( 'Verdana' , 'I' , 'verdanai.php' );
        $this->SetFont ( 'Verdana' , 'BU' , 12);

        if ( $this->PageNo ( ) < 2 ) { /** capçalera de la primera pàgina */
            $this->SetDrawColor ( 192 , 192 , 192 );
            $this->SetLineWidth ( 0.6 );
            $this->line ( 10 , 5 , 290 , 5 );
            
            if ( filter_has_var( INPUT_GET, 'informe' ) ) {  /** si hi ha establert una informe */
                switch ( filter_input( INPUT_GET, 'informe' ) ) {
                    case 'Pendents':
                        $str = 'DESPESES PER DESPLAÇAMENT FINS EL ';
                        break;
                    case 'Abonades':
                        $str = 'DESPESES ABONADES FINS EL ';
                        break;
                    case 'Totals':
                        $str = 'DESPESES TOTALS FINS EL ';
                        break;
                }
            }
            $str = iconv ( 'UTF-8', 'windows-1252' , $str ). date ( 'd/m/Y' , time ( ) );
            $this->Cell ( 30 , 0 , $str , 0 , 0 , 'L');

            $this->SetDrawColor ( 0 , 0 , 0 );
            $this->SetLineWidth ( 0.6 );
            $this->line ( 10 , 20 , 290 , 20 );

            $this->SetLineWidth ( 0.4 );
            $this->line ( 10 , 15 , 290 , 15 );


            /** salt de linia */
            $this->Ln ( 7.5 );
            $this->SetFont ( 'Verdana' , '' , 8 );
            $this->Cell ( 30 , 0 , 'Data' , 0 , 0 , 'L' );
            $this->Cell ( 60 , 0 , 'Recorregut' , 0 , 0 , 'L' );
            $this->Cell ( 60 , 0 , 'Concepte' , 0 , 0 , 'L' );
            $this->Cell ( 30 , 0 , 'Import u.' , 0 , 0 , 'C' );
            $this->Cell ( 30 , 0 , 'Quantitat' , 0 , 0 , 'C' );
            $this->Cell ( 30 , 0 , 'Import t.' , 0 , 0 , 'C' );
        } else {
            $this->SetDrawColor ( 0 , 0 , 0 );
            $this->SetLineWidth ( 0.6 );
            $this->line ( 10 , 7.4 , 290 , 7.4 );

            $this->SetLineWidth ( 0.4 );
            $this->line ( 10 , 12.4 , 290 , 12.4);


            /** salt e linia */
           // $this->Ln(7.5);
            $this->SetFont ( 'Verdana' , '' , 8 );
            $this->Cell ( 30 , 0, 'Data' , 0 , 0 , 'L' );
            $this->Cell ( 60 , 0  , 'Recorregut' , 0 , 0 , 'L' );
            $this->Cell ( 60 , 0 , 'Concepte' , 0 , 0 , 'L' );
            $this->Cell ( 30 , 0 , 'Import u.' , 0 , 0 , 'C' );
            $this->Cell ( 30 , 0 , 'Quantitat' , 0 , 0 , 'C' );
            $this->Cell ( 30 , 0 , 'Import t.' , 0 , 0 , 'C' );
        }
        
        $this->Ln ( 20 );
    }

    /** 
      * Funció de personalització del peu.
      * @access public
      */     

    function Footer ( ) {

     	date_default_timezone_set ( 'Europe/Madrid' );
        setlocale ( LC_ALL, "ca_ES.UTF-8" ); 

//        setlocale(LC_ALL,"Spanish_Spain.1252");

        $currentDate = strftime ( '%A, %e de %B de %Y' , time ( ) );
        
        /** Posició: a 1,5 cm del final */
        $this->SetY ( -15 );
        
        $this->SetFont ( 'Verdana' , 'B' , 8 );
        
        /** Número de pàgina */
        $this->Cell ( 0 , 10 , iconv ( 'UTF-8' , 'windows-1252' ,$currentDate ) , 0 , 0 , 'L' );
        $this->Cell ( 0 , 10 , iconv ( 'UTF-8' , 'windows-1252' , 'Pàgina ' ) . $this->PageNo ( ) . ' de {nb}' , 0 , 0 , 'R' );
    }
}