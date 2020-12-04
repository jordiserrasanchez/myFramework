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
                            <h1><i class="fas fa-user-cog"></i> Dades de l'usuari</h1>
                        </div>
                    </div>
                    
                    <div style="max-height: 820px; height: 820px; overflow-x: auto; overflow-y: auto; margin-top: -5px;">

                        <div class="col-md-8 order-md-1">
                            <form action="index.php?controlador=Users&action=SaveProfile" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="nom">Nom</label>
                                        <input type="text" name="nom" class="form-control" id="nom"  placeholder="" value="<?php echo $this->usuari[ 'nom' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            El nom és obligatori.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cognoms">Cognoms</label>
                                        <input type="text" class="form-control" id="cognoms" name="cognoms" placeholder="" value="<?php echo $this->usuari[ 'cognoms' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            Els cognoms son obligatoris.
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="correu">Email</label>
                                        <input type="email" class="form-control" id="correu" name="correu" placeholder="tu@exemple.cat" value="<?php echo $this->usuari[ 'correu' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            Si us plau, entri una adreça de correu vàlida.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="paraulaPas">Paraula de pas <span class="text-muted">(Opcional)</span></label>
                                        <input type="password" class="form-control" id="paraulaPas" name="paraulaPas" placeholder="Paraula de pas..." >
                                    </div>
                                </div>
                                <hr class="mb-4">
                                <button class="btn btn-primary" type="submit">Desar</button>
                                <button class="btn btn-danger" type="submit" formaction="index.php?controlador=Dashboardllar&action=ViewList">Anul·lar</button>
                                <input type="text" name="idUsuari" id="idUsuari" value="<?php echo $this->usuari[ 'idUsuari' ] ?? ""; ?>" hidden>                              
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
            $(document).ready(function () { /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();
                
                if ($('#politica').val()!=='') {  /* si el camp no està buit */
                    $('button[data-toggle="dropdown"]').text($('#politica').val());
                }
                
                /* executa la funció al acabar de carregar la pàgina */
                $(function(){
                    $(".dropdown-menu").on("click", "a", function(event){ /* intercepta el event */
                        $('button[data-toggle="dropdown"]').text($(this).text());
                        $('#idPolitica').val($(this).attr('id'));
                        $('#politica').val($(this).text());
                     });
                });
            });
        </script>
    </body>
</html>
     