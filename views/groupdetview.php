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
        <?php require_once('headerbar.php'); ?>

        <div class="container-fluid">
            <div class="row">
                <?php echo $_SESSION['menu']; ?>
                <main role="main" class="col-md-8 ml-sm-auto col-lg-10 px-4">
                    <div class="col-md-8 order-md-1">
                        <div class="py-5 text-center">
                            <h1><i class="fas fa-users"></i> Fitxa del detall</h1>
                        </div>
                    </div>
                    
                    <div style="max-height: 210px; height: 210px; overflow-x: auto; overflow-y: auto; margin-top: -5px;">

                        <div class="col-md-8 order-md-1">
                            <form action="index.php?controlador=Groups&action=SaveDet" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Usuari</label>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                                Sel·leccionar<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php 
                                                    foreach($this->llistaUsuaris as $row) {
                                                        printf ( "<li><a id=\"%s\" class=\"dropdown-item\">&nbsp;%s</a></li>" , $row["idUsuari"] , $row["cognoms"] . ', ' . $row["nom"] );
                                                    }
                                                ?>
                                            </ul>
                                            <input type="text" name="idUsuari" id="idUsuari" value="<?php echo $this->usuari['idUsuari'];?>" hidden >
                                            <input type="text" name="usuari" id="usuari" value="<?php echo ($this->usuari['idUsuari']<>0) ? $this->usuari['cognoms'] . ", " . $this->usuari['nom'] : "";?>" hidden>
                                        </div>
                                    </div>                                    
                                
                                </div>
                                <hr class="mb-4">
                                <button class="btn btn-primary" type="submit">Desar</button>
                                <button class="btn btn-danger" type="submit" formaction="index.php?controlador=Groups&action=Edit">Anul·lar</button>
                                <input type="text" name="idGrup_det" id="idGrup_det" value="<?php echo $this->grup_det['idGrup_det'];?>" hidden>
                                <input type="text" name="idModificar" id="idModificar" value="<?php echo $this->grup_det['idGrup'];?>" hidden>
                                
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
                
                if ($('#usuari').val()!=='') {  /* si el camp no està buit */
                    $('button[data-toggle="dropdown"]').text($('#usuari').val());
                }
                
                /* executa la funció al acabar de carregar la pàgina */
                $(function(){
                    $(".dropdown-menu").on("click", "a", function(event){ /* intercepta el event */
                        $('button[data-toggle="dropdown"]').text($(this).text());
                        $('#idUsuari').val($(this).attr('id'));
                        $('#usuari').val($(this).text());
                     });
                });
                
            });
        </script>        
    </body>
</html>
  