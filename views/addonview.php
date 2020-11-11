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
                            <h1><i class="fas fa-boxes"></i> Fitxa del mòdul</h1>
                        </div>
                    </div>
                    
                    <div style="max-height: 820px; height: 820px; overflow-x: auto; overflow-y: auto; margin-top: -5px;">

                        <div class="col-md-8 order-md-1">
                            <form action="index.php?controlador=Addons&action=Save" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="modul">Mòdul</label>
                                        <input type="text" name="modul" class="form-control" id="modul"  placeholder="" value="<?php echo $this->modul[ 'modul' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            El nom del mòdul és obligatori.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="controlador">Controlador</label>
                                        <input type="text" name="controlador" class="form-control" id="modul"  placeholder="" value="<?php echo $this->modul[ 'controlador' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            El nom del controlador és obligatori.
                                        </div>
                                    </div>                                   
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="modul">Icona</label>
                                        <input type="text" name="icona" class="form-control" id="icona"  placeholder="" value="<?php echo htmlentities(($this->modul[ 'icona' ]) ?? ""); ?>" required>
                                        <div class="invalid-feedback">
                                            La incona és obligatoria.
                                        </div>
                                    </div>  
                                    <div class="col-md-2 mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="sistema" name="sistema" value="<?php echo $this->modul[ 'sistema' ] ?? ""; ?>" <?php if ( ( isset ( $this->modul[ 'sistema' ] ) ) && ( $this->modul[ 'sistema' ] == 1 ) ) { echo "checked"; } else { echo ""; } ?>>
                                            <label class="custom-control-label" for="sistema">Sistema</label>
                                        </div>                            
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="actiu" name="actiu" value="<?php echo $this->modul[ 'actiu' ] ?? ""; ?>" <?php if ( ( isset ( $this->modul[ 'actiu' ] ) ) && ( $this->modul[ 'actiu' ] == 1 ) ) { echo "checked"; } else { echo ""; } ?>>
                                            <label class="custom-control-label" for="actiu">Actiu</label>
                                        </div>                            
                                    </div>
                                </div>
                                <hr class="mb-4">
                                <button class="btn btn-primary" type="submit">Desar</button>
                                <button class="btn btn-danger" type="submit" formaction="index.php?controlador=Addons&action=ViewList">Anul·lar</button>
                                <input type="text" name="idModul" id="idModul" value="<?php echo $this->modul[ 'idModul' ] ?? ""; ?>" hidden>
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
        