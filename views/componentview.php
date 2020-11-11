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
                            <h1><i class="fas fa-box-open"></i> Fitxa del component</h1>
                        </div>
                    </div>
                    
                    <div style="max-height: 820px; height: 820px; overflow-x: auto; overflow-y: auto; margin-top: -5px;">

                        <div class="col-md-8 order-md-1">
                            <form action="index.php?controlador=Components&action=Save" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="component">Component</label>
                                        <input type="text" name="component" class="form-control" id="component"  placeholder="" value="<?php echo $this->component[ 'component' ] ?? ""; ?>" required>
                                        <div class="invalid-feedback">
                                            El component és obligatori.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Mòdul</label>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                                Sel·leccionar<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php 
                                                    foreach ( $this->llistaModuls as $row ) {
                                                        printf ( "<li><a id=\"%s\" class=\"dropdown-item\">&nbsp;%s</a></li>" , $row[ "idModul" ] ?? "" , $row[ "modul" ] ?? "" );
                                                    }
                                                ?>
                                            </ul>
                                            <input type="text" name="idModul" id="idModul" value="<?php echo $this->component[ 'idModul' ] ?? ""; ?>" hidden>
                                            <input type="text" name="modul" id="modul" value="<?php echo $this->modul[ 'modul' ] ?? ""; ?>" hidden>
                                        </div>
                                    </div>                                    
                                </div>
                                <hr class="mb-4">
                                <button class="btn btn-primary" type="submit">Desar</button>
                                <button class="btn btn-danger" type="submit" formaction="index.php?controlador=Components&action=ViewList">Anul·lar</button>
                                <input type="text" name="idComponent" id="idComponent" value="<?php echo $this->component[ 'idComponent' ] ?? ""; ?>" hidden>
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
                
                if ($('#modul').val()!=='') {  /* si el camp no està buit */
                    $('button[data-toggle="dropdown"]').text($('#modul').val());
                }
                
                /* executa la funció al acabar de carregar la pàgina */
                $(function(){
                    $(".dropdown-menu").on("click", "a", function(event){ /* intercepta el event */
                        $('button[data-toggle="dropdown"]').text($(this).text());
                        $('#idModul').val($(this).attr('id'));
                        $('#modul').val($(this).text());
                     });
                });
                
            });
        </script>          
    </body>
</html>
        