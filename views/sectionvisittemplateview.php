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
                            <h1><i class="far fa-clock"></i> Fitxa del tram</h1>
                        </div>
                    </div>
                    
                    <div style="max-height: 210px; height: 210px; overflow-x: auto; overflow-y: auto; margin-top: -5px;">

                        <div class="col-md-8 order-md-1">
                            <form action="index.php?controlador=VisitTemplates&action=SaveDet" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="descripcioTramPlanillaVisita">Descripció del tram horari</label>
                                        <input type="text" name="descripcioTramPlanillaVisita" class="form-control" id="descripcioTramPlanillaVisita"  placeholder="" value="<?php echo $this->tramPlanillaVisita[ 'descripcioTramPlanillaVisita' ]  ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            La descripció és obligatoria.
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 mb-3">
                                        <label for="horaEntrada">Hora d'entrada</label>
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                 <i class="far fa-clock"></i>
                                            </div>                                           
                                            <input class="form-control" id="horaEntrada" name="horaEntrada" placeholder="hh:mm" type="text" value="<?php echo date_format ( date_create ( $this->tramPlanillaVisita[ 'horaEntrada' ]  ?? "" ) , 'H:i') ?? "00:00";?>" required>
                                            <div class="invalid-feedback">
                                                L'hora d'entrada és obligatoria.
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="col-md-2 mb-3">
                                        <label for="horaSortida">Hora de sortida</label>
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                 <i class="far fa-clock"></i>
                                            </div>                                           
                                            <input class="form-control" id="horaSortida" name="horaSortida" placeholder="hh:mm" type="text" value="<?php echo date_format ( date_create ( $this->tramPlanillaVisita[ 'horaSortida' ]  ?? "" ) , 'H:i') ?? "00:00";?>" required>
                                            <div class="invalid-feedback">
                                                L'hora de sortida és obligatoria.
                                            </div>
                                        </div>
                                    </div>                                    
                                
                                </div>
                                <hr class="mb-4">
                                <button class="btn btn-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Anul·lar els canvis fets"  formaction="index.php?controlador=VisitTemplates&action=Edit"><i class="far fa-times-circle"></i> Anul·lar</button>
                                <button class="btn btn-success" type="submit" data-toggle="tooltip" data-placement="top" title="Desar els canvis fets"><i class="fas fa-check"></i> Desar</button>
                                <input type="text" name="idTramPlanillaVisita" id="idTramPlanillaVisita" value="<?php echo $this->tramPlanillaVisita[ 'idTramPlanillaVisita' ]  ?? ""; ?>" hidden>
                                <input type="text" name="idModificar" id="idModificar" value="<?php echo $this->tramPlanillaVisita[ 'idPlanillaVisita' ]; ?>" hidden>
                                
                            </form>
                        </div>
                        
                    </div>
                </main>
            </div>
        </div>
        <script src="assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="assets/myfw/js/myfw.js"></script>
        <script>
            $(document).ready(function(){ /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();

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
  