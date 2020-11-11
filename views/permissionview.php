<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="assets/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/bootstrap/4.4/examples/dashboard/dashboard.css">
        <link rel="stylesheet" href="assets/fontawesome/5.12.0/css/all.css">
        <link rel="stylesheet" href="assets/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
        <style>
          .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
          }

          @media (min-width: 768px) {
            .bd-placeholder-img-lg {
              font-size: 3.5rem;
            }
          }
        </style>
    </head>
    <body>
        <?php require_once ( 'headerbar.php' ); ?>

        <div class="container-fluid">
            <div class="row">
                <?php echo $_SESSION['menu']; ?>
                <main role="main" class="col-md-8 ml-sm-auto col-lg-10 px-4">
                    <div class="col-md-8 order-md-1">
                        <div class="py-5 text-center">
                                <?php
                                    if ( $this->mode == 'edit' ) {
                                ?>     
                            <h1><i class="fas fa-shield-alt"></i> Permisos per: <b> <?php echo $this->escollit  ?? ""; ?></b></h1>
                                <?php
                                    } else {
                                ?>                            
                            <h1><i class="fas fa-shield-alt"></i> Fitxa dels permisos</h1>
                                <?php
                                    }
                                ?>                            
                        </div>
                    </div>
                    
                    <div style="overflow-x: auto; overflow-y: auto; margin-top: -5px;">

                        <div class="col-md-8 order-md-1">
                            <form action="index.php?controlador=Permissions&action=Save" method="post" class="needs-validation" novalidate>
                               
                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                                    <h1 class="h2">Llista d'objectes</h1>
                                    <div class="btn-toolbar mb-2 mb-md-0">
                                        <?php
                                            if ( $this->mode != 'edit' ) {
                                        ?>
                                        <div class="dropdown mr-2">
                                            Permisos de: <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                                Sel·leccionar<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php
                                                    if ( $this->tipus == 1 ) { /** filtro per grups */
                                                        foreach ( $this->grups as $dato ) {
                                                            printf( "<li><a id=\"%s\"class=\"dropdown-item\">%s</a></li>" , $dato['idGrup']  ?? "" , $dato['grup']  ?? "" );
                                                        }
                                                    
                                                    } else  {
                                                        foreach ( $this->usuaris as $dato ) {
                                                            printf( "<li><a id=\"%s\"class=\"dropdown-item\">%s</a></li>" , $dato['idUsuari']  ?? "" , $dato['cognoms']  ?? "" . ', ' . $dato['nom']  ?? "" );
                                                        }
                                                            
                                                    }
                                                ?>
                                            </ul>
                                        </div> 
                                        <?php
                                            }
                                        ?>
                                        <button id="btn-submit" name="btn-submit" class="btn btn-primary mr-2" type="submit">Desar</button>
                                        <button id="btn-cancel" name="btn-cancel" class="btn btn-danger" type="submit" formaction="index.php?controlador=Permissions&action=ViewList">Anul·lar</button>
                                        <input type="text" name="tipus" id="tipus" value="<?php echo $this->tipus  ?? ""; ?>" hidden/>
                                        <input type="text" name="id" id="id" value="<?php echo filter_input ( INPUT_POST, 'idModificar' ); ?>" hidden/>
                                    </div>                                    
                                </div>                                
 
                                <div style="overflow-x: auto; overflow-y: auto; margin-top: -5px;" class="contenido">
                                </div>
                                
                                <div class="paginas">
                                </div>                                
                                

                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-datepicker/1.4.1/js/locales/bootstrap-datepicker.es.min.js"></script>
        <script src="assets/myfw/js/myfw.js"></script>
        <script>
            
            function load(obj) { /* carrega el contingut de la paàgina */
                
                /* omple el contingut de la pàgina */
                $('.contenido').html('<div class="loading"><img src="images/Loading.gif" width="70px" height="70px"/><br/>Carregant dades, un moment si us plau...</div>');
                
                var page = obj;	
                      
                if (page==null){ /* si no s'ha informat del número de pàgina */
                    page = 1;
                }

                var dataString = 'page='+page+'&tipus='+$("#tipus").val()+'&id='+$("#id").val();

                $.ajax({ /* recupera la llista de detalls del viatge i la paginació */
                    type: "GET",
                    url: "ajax/ajaxpermissionsdethandler.php",
                    dataType: 'json',
                    cache: false,                    
                    data: dataString,
                    success: function(data) {

                        $('.contenido').fadeIn(2000).html(data.contenido);
                        $('.paginas').fadeIn(2000).html(data.paginas);                
                    }
                });
                return false;
            }
            
            $(document).ready(function(){ /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();
                
                if ( $("#id").val() != '' ) {
                    load();
                } else {
                    $('#btn-submit').prop("disabled",true);
                    $('#btn-cancel').prop("disabled",true);
                    
                }
                
                $(function(){ /* intercepta el event */
                    $(".dropdown-menu").on("click", "a", function(event){
                        $('button[data-toggle="dropdown"]').text($(this).text());
                        $("#id").val($(this).attr("id"));
                    $('#btn-submit').prop("disabled",false);
                    $('#btn-cancel').prop("disabled",false);
                        load();
                    })
                })                
                
            });
            
        </script>
    </body>
</html>
  