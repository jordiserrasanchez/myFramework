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
                    <div class="col-md-8 order-md-1">
                        <div class="py-5 text-center">
                            <h1><i class="fas fa-cube"></i> Generació de dia de visites</h1>
                        </div>
                    </div>
                    
                    <div style="overflow-x: auto; overflow-y: auto; margin-top: -5px; height: 100%;">

                        <div class="col-md-8 order-md-1">
                            <form action="index.php?controlador=VisitDays&action=Save" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <p>Planilla sel·lecionada:                                    
                                            <span class="text-uppercase font-weight-bold"><?php echo $this->planillaVisita[ 'descripcioPlanillaVisita' ]  ?? ""; ?></span>
                                        </p>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="dataVisita">Data</label>
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                 <i class="fa fa-calendar-alt"></i>
                                            </div>                                    
                                            <input class="form-control" id="dataVisita" name="dataVisita" placeholder="MM/DD/YYYY" type="text" value="<?php echo date_format ( date_create ( $this->diaVisita['dataVisita']  ?? "" ) , 'd/m/Y' ); ?>" required>
                                            <div class="invalid-feedback">
                                                La data és obligatoria.
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-2 mb-3">
                                        <label>Departament</label>                            
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                               <?php
                                                    echo $this->llistaDepartaments[0]["descripcioDepartament"];
                                               ?>
                                               <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php 
                                                    foreach ( $this->llistaDepartaments as $row ) {
                                                        printf ( "<li><a id=\"%s\" class=\"dropdown-item\">&nbsp;%s</a></li>" , $row[ "idDepartament" ] ?? "" , $row[ "descripcioDepartament" ] ?? "" );
                                                    }
                                                ?>                                                
                                            </ul>
                                            <input type="text" name="idDepartament" id="idDepartament" value="<?php echo $this->diaVisita[ 'idDepartament' ] ?? $this->llistaDepartaments[0]["idDepartament"] ; ?>" hidden >
                                            <input type="text" name="departament" id="departament" value="<?php echo $this->diaVisita[ 'departament' ] ?? $this->llistaDepartaments[0]["descripcioDepartament"] ; ?>" hidden >
                                        </div>                    
                                    </div>                               
                                </div>
                                <hr class="mb-4">
                                <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="top" title="Desar els canvis fets">Desar</button>
                                <button class="btn btn-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Anul·lar els canvis fets" formaction="index.php?controlador=VisitTemplates&action=ViewList">Anul·lar</button>
                                <input type="text" name="idPlanillaVisita" id="idPlanillaVisita" value="<?php echo $this->planillaVisita[ 'idPlanillaVisita' ]  ?? ""; ?>" hidden>
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
            $(document).ready(function () { /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();
                
               
                
                if ($('#departament').val()!=='') {  /* si el camp no està buit */
                    $('button[data-toggle="dropdown"]').text($('#departament').val());
                }
                           
                
                /* executa la funció al acabar de carregar la pàgina */
                $(function(){
                    $(".dropdown-menu").on("click", "a", function(event){ /* intercepta el event */
                        $('button[data-toggle="dropdown"]').text($(this).text());
                        $('#idDepartament').val($(this).attr('id'));
                        $('#departament').val($(this).text());
                     });
                });
                
                var date_input=$('input[name="dataVisita"]'); 
		
                var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";		
		
                date_input.datepicker({  /* configura el calendari */
			format: 'dd/mm/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
                        language: 'es'
  		});
                
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
  