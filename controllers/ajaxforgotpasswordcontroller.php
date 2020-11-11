<?php
/** crea el namespace para el PHPMailer */
use PHPMailer\PHPMailer\PHPMailer;

/** requereix el fitxer de constants  */
require_once ( '../include/const.inc.php' );

/** requereix el fitxer d'autocarga de clases  */
require_once ( '../include/autoload.php' );

/** inclou els fitxers del PHPMailer */
include_once _PHPMAILER_ROOT_ . "src/PHPMailer.php";
include_once _PHPMAILER_ROOT_ . "src/Exception.php";
include_once _PHPMAILER_ROOT_ . "src/SMTP.php";
    
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
 * Filename ajaxforgotpasswordcontroller.php 
 * Encoding UTF-8
 */

/**
 * Documentació de la classe ajaxforgotpasswordcontroller.
 * @access public 
 * @author Jordi Serra Sánchez <jordi@serraperez.cat>
 * @category controller
 * @copyright Copyright (c) 2020,  Jordi Serra Sánchez.
 * @filesource
 * @todo
 * @final 
 * @license http://www.serraperez/licenses/
 * @package ajaxforgotpasswordcontroller
 * @subpackage ajax
 * @version 1.0.0
 */
final class ajaxforgotpasswordcontroller {
    
    /**  @var string $model Conté el model */
    private $model;
    
    /**  @var string $correu Conté el correu */
    private $correu;
    
    /**  @var string $token Conté el token temporal */
    private $token;
    
    /** 
      * Inicialitza l'objecte.
      * @access public
      */ 
    public function __construct ( ) {    
        if ( filter_has_var ( INPUT_POST , 'correu' ) ) {  /** si s'ha informat del correu */
            
            /** crea l'objecte usuari *****/
            $this->model = new usuari ( );
            
            $this->correu = $this->model->link->real_escape_string ( filter_input ( INPUT_POST , 'correu' ) );
            $this->token = $this->model->recuperaPassword ( $this->correu );
        }
    }

    /** 
      * Envia el correu electrònic per recuperar la paraula de pas i estableix la sortida.
      * @return array Retorna una matriu en format JSON amb el resultat de l'enviament.
      * @access public
      */ 
    public function sendmail ( ) {
        
        if ( $this->token <> '' ) { /** si el token no està buit */
 
            /** crea un nou objecte PHPMailer */
            $mail = new PHPMailer ( );
            
            /** crida al mètode que composa el correu */
            $this->composeMail ( $mail );
            
            /** envia el correu */
            $ret = $mail->send ( );

            if ( $ret ) { /** si s'ha enviat amb èxit */
                
                $msg = $this->render ( "Recuperar paraula de pas" , "success" , "Sol·licitut enviada exitosament" , "Si us plau comprovi la seva bústia de correu!" );
                return json_encode ( ["status"=>1 , "msg" => $msg] );   
            
            } else { /** si s'ha produït un error en l'enviament */

                $msg = $this->render ( "Recuperar paraula de pas" , "alert" , "Error" , $mail->ErrorInfo . "!" );
                return json_encode ( ["status" => 0 , "msg" => $msg] );   

            }

        } else  { /** si hi ha camps buits */

            $msg = $this->render ( "Recuperar paraula de pas" , "alert", "Error" , "Correu inexistent!" );
            return json_encode ( ["status" => 0 , "msg" => $msg] );       

        }
    }
    
    /** 
      * Composa el correu electrònic.
      * @param string $mail Conté el correu electrònic.
      * @access private
      */
    private function composeMail ( $mail ) {
        
        $mail->setLanguage ( 'es' , _PHPMAILER_ROOT_ . 'language/' );
        $mail->isSMTP ( );
        $mail->Host = _MAIL_HOST_;
        $mail->SMTPAuth = _MAIL_SMTPAUTH_;
        $mail->SMTPAutoTLS = _MAIL_SMTPAUTOTLS_;
        $mail->SMTPSecure = _MAIL_SMTPSECURE_;
        $mail->Username = _MAIL_USERNAME_;
        $mail->Password = _MAIL_PASSWORD_;
        $mail->Port = _MAIL_PORT_;            
        $mail->setFrom ( _MAIL_ADMIN_ );
        $mail->addAddress ( $this->correu );
        $mail->isHTML ( true );
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "Recordar paraula de pas";
        
        /** crida al mètode que composa el cos del correu */
        $mail->Body = $this->composeBody ( );  
        
        if ( _MYFW_DEGUB_ ) { /** si estem debugant */
//            $mail->SMTPDebug = 4;
            
        }
    }

    /** 
      * Composa el cos correu electrònic.
      * @return string Retorna el cos del correu.
      * @access private
      */
    private function composeBody ( ) {
        
        $actual_link = ( isset ( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]";
        $ret = " Hola,<br><br>
                                Per reinicialitzar la paraula de pas, si us plau faci click al seqüent enllaç:<br><br>
                                <a href='" . $actual_link . "/myFramework/views/resetpassword.php?email=" . $this->correu . "&token=" . $this->token ."'>" . $actual_link . "/myFramework/views/resetpassword.php?email=" . $this->correu . "&token=" . $this->token . "</a><br><br>
                                Moltes gracies.<br><br>
                                Jordi Serra.";
        return $ret;

    }

    /** 
      * Prepara al sortida. 
     * @param string $cardheader Header de la card
     * @param string $cardstatus Color del missatge
     * @param string $cardtitle Títol de la card
     * @param string $cardtext Texte de la card
      * @access public
      */    
    private function render ( $cardheader , $cardstatus , $cardtitle , $cardtext ) {
        $ret = "<div class=\"d-flex justify-content-center h-100\" style=\"max-height: 260px;\">
                <div class=\"card text-center\" style=\"max-height: 260px;\">
                    <div class=\"card-header\">
                        " . $cardheader . "
                    </div>
                    <div class=\"card-body\">
                        <div class=\"alert alert-" . $cardstatus . "\" role=\"alert\">
                            <h5 class=\"card-title\">" . $cardtitle . "</h5>
                        </div>
                        <p class=\"card-text\">" . $cardtext . "</p>
                        <a href=\"index.php\" class=\"btn btn-primary\">Tornar</a>
                    </div>
                </div>
            </div>";
        return $ret;
    }
            
}



