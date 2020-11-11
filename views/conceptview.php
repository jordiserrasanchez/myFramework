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
                            <h1><i class="fas fa-list"></i> Fitxa del concepte</h1>
                        </div>
                    </div>
                    
                    <div style="max-height: 820px; height: 820px; overflow-x: auto; overflow-y: auto; margin-top: -5px;">

                        <div class="col-md-8 order-md-1">
                            <form action="index.php?controlador=Concepts&action=Save" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="concept">Concepte</label>
                                        <input type="text" name="concepte" class="form-control" id="concepte"  placeholder="" value="<?php echo $this->concepte[ 'concepte' ] ?? "" ; ?>" required>
                                        <div class="invalid-feedback">
                                            El concepte és obligatori.
                                        </div>
                                    </div>
                                    
    
                                    <div class="col-md-2 mb-3">
                                        <label for="importUnitari">Import U.</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" aria-label="Euro amount (with dot and two decimal places)" id="importUnitari" name="importUnitari" placeholder=""  min="0.00" step="0.05" value="<?php echo $this->concepte[ 'importUnitari' ] ?? "0"; ?>" required />
                                                <span class="input-group-text">€</span>
                                            </div>
                                        </div>                                    
                                        <div class="invalid-feedback">
                                            El import unitari és obligatori.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="actiu" name="actiu" value="<?php echo $this->concepte[ 'actiu' ] ?? ""; ?>" <?php if ( ( isset($this->concepte[ 'actiu' ] ) ) && ( $this->concepte[ 'actiu' ] == 1 ) ) { echo "checked"; } else { echo ""; } ?>>
                                        <label class="custom-control-label" for="actiu">Actiu</label>
                                    </div>                            
                                </div>

                                <hr class="mb-4">
                                <button class="btn btn-primary" type="submit">Desar</button>
                                <button class="btn btn-danger" type="submit" formaction="index.php?controlador=Concepts&action=ViewList">Anul·lar</button>
                                <input type="text" name="idConcepte" id="idConcepte" value="<?php echo $this->concepte[ 'idConcepte' ]  ?? ""; ?>" hidden>
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
        