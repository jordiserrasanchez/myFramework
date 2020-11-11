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
                    <?php require_once('modalwindow.php'); ?>
                    <div style="overflow-x: auto; overflow-y: auto; margin-top: -5px; ">

                        <div class="col-md-8 order-md-1">
                            <div class="py-5 text-center">
                                <h1><i class="far fa-calendar-alt"></i> Fitxa del día de visita</h1>
                            </div>
                        </div>

                        <div class="col-md-8 order-md-1">
                            <form action="" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="dataVisita">Data de la visita</label>
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                 <i class="fa fa-calendar-alt"></i>
                                            </div>                                    
                                            <input class="form-control" id="dataVisita" name="dataVisita" placeholder="MM/DD/YYYY" type="text" value="<?php echo date_format ( date_create ( $this->diaVisita['dataVisita']  ?? "" ) , 'd/m/Y' ); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="departament">Descripció del departament</label>                            
                                        <input class="form-control" id="departament" name="departament" type="text" value="<?php echo $this->departament[ 'descripcioDepartament' ] ?? "" ; ?>" readonly>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <label for="token">URL del dia de visita</label>
                                        <input class="form-control" id="token" name="token" type="text" placeholder="" value="<?php echo  _HOST_ .  "index.php?controlador=Visit&action=Schedule&token=" . $this->diaVisita[ 'token' ]  ?? ""; ?>" readonly>
                                    </div>
                                </div>
                                <hr class="mb-4">                                
                                <button class="btn btn-danger" type="submit" formaction="index.php?controlador=VisitDays&action=ViewList" data-toggle="tooltip" data-placement="top" title="Descarta els canvis realitzats"><i class="far fa-times-circle"></i> Tancar</button>
                                <input type="text" name="idDiaVisita" id="idDiaVisita" value="<?php echo $this->diaVisita[ 'idDiaVisita' ]  ?? ""; ?>" hidden>
                            </form>
                        </div>                                
                    <?php
                        // si hi ha registre mestre mostra el botó
                        if ( isset ( $this->diaVisita[ 'idDiaVisita'] ) ) {
                    ?>
                        <hr class="mb-4">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2"><i class="fas fa-stream"></i> Horaris de la visita</h1>
                        </div>
                    <?php	

                    }
                    ?>                    
                    <?php 
                        // si hi ha detalls mostra la taula
                        if ( isset ( $this->llistaHoresDiaVisita ) ) {
                    ?>
                        <div style="overflow-x: auto; overflow-y: auto; margin-top: -5px;" class="contenido">
                        </div>
                        <div class="paginas">
                        </div>                    
                    <?php	

                    }
                    ?>  

                      
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

                var idDiaVisita = $('#idDiaVisita').val();
                
                var dataString = 'page='+page+'&idDiaVisita='+idDiaVisita;

                $.ajax({ /* recupera la llista d'horaris del dia de visita i la paginació */
                    type: "GET",
                    url: "ajax/ajaxvisitdayhourshandler.php",
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
                
                var idDiaVisita = $('#idDiaVisita').val();
                
                if (idDiaVisita > 0) { /* si hi ha una visita */
                    
                    /* crida al mètode que carrega el contingut de la pàgina */        
                    load();
                }
		
                 /* crida al mètode que mostra la finestra modal si existeix */
                $("#myModal").modal(
                    {
                        backdrop: 'static',
                        keyboard: false
                    }
                );
        
            });
            
        </script>
    </body>
</html>
  