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
                            <h1><i class="fas fa-users"></i> Fitxa del grup</h1>
                        </div>
                    </div>
                    
                    <div style="overflow-x: auto; overflow-y: auto; margin-top: -5px;">

                        <div class="col-md-8 order-md-1">
                            <form action="index.php?controlador=Groups&action=Save" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="grup">Grup</label>
                                        <input type="text" name="grup" class="form-control" id="grup"  placeholder="" value="<?php echo $this->grup[ 'grup' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            El grup és obligatori.
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-4">
                                <button class="btn btn-primary" type="submit">Desar</button>
                                <button class="btn btn-danger" type="submit" formaction="index.php?controlador=Groups&action=ViewList">Anul·lar</button>
                                <input type="text" name="idGrup" id="idGrup" value="<?php echo $this->grup[ 'idGrup' ] ?? ""; ?>" hidden>
                             </form>
                        </div>
                        
                    </div>
                    <?php
                        // si hi ha registre mestre mostra el botó
                        if ( isset ( $this->grup[ 'idGrup' ] ) ) {
                    ?>
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Detall del grup</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <form name="form" action="index.php?controlador=Groups&action=NewDet" method="post">
                                <button type="submit" name="submit" class="btn btn-sm btn-outline-primary">Nou</button>
                                <input type="text" name="idMaster" id="idMaster" value="<?php echo $this->grup['idGrup'] ?? ""; ?>" hidden>
                            </form>
                        </div>
                    </div>
                    <?php	

                    }
                    ?>                    
                    <?php 
                        // si hi ha detalls mostra la taula
                        if ( isset ( $this->grup_det ) ) {
                    ?>
                        <div style="overflow-x: auto; overflow-y: auto; margin-top: -5px;" class="contenido">
                        </div>
                        <div class="paginas">
                        </div>                    
                    <?php	

                    }
                    ?>                    
                </main>
            </div>
        </div>
        <script src="assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="assets/myfw/js/myfw.js"></script>
        <script>
            function load(obj) { /* carrega el contingut de la paàgina */
                
                /* omple el contingut de la pàgina */
                $('.contenido').html('<div class="loading"><img src="images/Loading.gif" width="70px" height="70px"/><br/>Carregant dades, un moment si us plau...</div>');
                
                var page = obj;	
                      
                if (page==null){ /* si no s'ha informat del número de pàgina */
                    page = 1;
                }

                var idGrup = $('#idGrup').val();
                
                var dataString = 'page='+page+'&idGrup='+idGrup;

                $.ajax({ /* recupera la llista de detalls del grup i la paginació */
                    type: "GET",
                    url: "ajax/ajaxgroupsdethandler.php",
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
                
                var idGrup = $('#idGrup').val();
                
                if (idGrup > 1) { /* si hi ha grup */
                    
                    /* crida al mètode que carrega el contingut de la pàgina */        
                    load();
                }

            });
            
        </script>
    </body>
</html>
  