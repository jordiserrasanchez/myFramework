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
        <link rel="stylesheet" href="assets/chart/2.9.3/css/Chart.min.css">
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
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <?php require_once('modalwindow.php'); ?>
                    <div class="row d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2 col-md-9">Taulell</h1>
                    </div>
                        <div class="card-deck">
                            <div class="card border-primary mb-3">
                                <div class="card-header">
                                    Visites d'aquesta setmana
                                </div>
                                <div class="card-body text-primary">
                                    <div class="table-responsive" id="visites"></div>
                                </div>
                            </div>            
                            <div class="card  border-danger mb-3">
                                <div class="card-header">
                                    Sortides
                                </div>
                                <div class="card-body text-danger">
                                    <p class="card-text display-4" id="sortides"></p>
                                </div>
                            </div>
                        </div>
                    <div class="col-md-9">                
                    </div>
                </main>
            </div>
        </div>                
        <script src="assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="assets/chart/2.9.3/js/Chart.min.js"></script>
        <script src="assets/myfw/js/myfw.js"></script>        
        <script>
            $(document).ready(function () { /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory(); 
                
                /* crida al mètode que mostra la finestra modal si existeix */
                $("#myModal").modal(
                    {
                        backdrop: 'static',
                        keyboard: false
                    }
                );
        
                /* crida al mètode que carrega les visites */
                showVisites();
                
                /* crida al mètode que carrega les sortides */
                showSortides();
                
            });
            
            function showVisites() { /* carrega les visites de la setmana */
                {$.post("ajax/ajaxdashboardllarhandler.php", {origen:'taulaVisites'},
                    function (data) {
                        $('#visites').fadeIn(2000).html(data.contenido);  
                    });
                }
            }
            
            function showSortides() { /* carrega les visites de la setmana */
              
                {$.post("ajax/ajaxdashboardllarhandler.php", {origen:'taulaSortides'},
                    function (data) {
                        console.log(data);
                        var sortides = (data.Import == null) ? 0 : data.Import;
                        $('#sortides').fadeIn(2000).html(sortides+' €');  
                    });
                }
            }            

        </script>
    </body>
</html>

     