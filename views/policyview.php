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
                    <div class="col-md-8 order-md-1">
                        <div class="py-5 text-center">
                            <h1><i class="fas fa-user-secret"></i> Fitxa de la politica</h1>
                        </div>
                    </div>
                    
                    <div style="max-height: 420px; height: 420px; overflow-x: auto; overflow-y: auto; margin-top: -5px;">

                        <div class="col-md-8 order-md-1">
                            <form action="index.php?controlador=Policies&action=Save" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="politica">Política</label>
                                        <input type="text" name="politica" class="form-control" id="politica"  placeholder="Nom de la política de seguretat" value="<?php echo $this->politica[ 'politica' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            La política és obligatori.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="umbralIntents">Umbral Intents</label>
                                        <input type="text" class="form-control" id="umbralIntents" name="umbralIntents" placeholder="Umbral Intents" value="<?php echo $this->politica[ 'umbralIntents' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            Si us plau, indiqui el umbral de intents.
                                        </div>                            
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="umbralCaducitat">Umbral Caducitat</label>
                                        <input type="text" class="form-control" id="umbralCaducitat" name="umbralCaducitat" placeholder="Umbral Caducitat" value="<?php echo $this->politica[ 'umbralCaducitat' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            Si us plau, indiqui el umbral de caducitat.
                                        </div>                            
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="umbralHistoria">Umbral Història</label>
                                        <input type="text" class="form-control" id="umbralHistoria" name="umbralHistoria" placeholder="Umbral Història" value="<?php echo $this->politica[ 'umbralHistoria' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            Si us plau, indiqui el umbral de historia.
                                        </div>                            
                                    </div>
                                </div>
                                <div class="row">                                
                                    <div class="col-md-3 mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="requereixComplexitat" name="requereixComplexitat" value="<?php echo $this->politica[ 'requereixComplexitat' ] ?? ""; ?>" <?php if ( ( isset ( $this->politica[ 'requereixComplexitat' ] ) ) && ( $this->politica[ 'requereixComplexitat' ] == 1 ) ) { echo "checked"; } else { echo ""; } ?>>
                                            <label class="custom-control-label" for="requereixComplexitat">Requereix Complexitat</label>
                                        </div>                            
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="longitutMinima">Longitut Mínima</label>
                                        <input type="text" class="form-control" id="longitutMinima" name="longitutMinima" placeholder="Longitut Mínima" value="<?php echo $this->politica[ 'longitutMinima' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            Si us plau, indiqui la longitut mínima.
                                        </div>                            
                                    </div>
                                </div>
                                <hr class="mb-4">
                                <button class="btn btn-primary" type="submit">Desar</button>
                                <button class="btn btn-danger" type="submit" formaction="index.php?controlador=Policies&action=ViewList">Anul·lar</button>
                                <input type="text" name="idPolitica" id="idPolitica" value="<?php echo $this->politica[ 'idPolitica' ] ?? ""; ?>" hidden>
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
            });
        </script>          
    </body>
</html>
  