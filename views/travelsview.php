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
            </div>
        </div>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fas fa-car"></i> Llista de viatges</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <form name="form" action="index.php?controlador=Travels&action=New" method="post">
                        <button type="submit" name="submit" class="btn btn-sm btn-outline-primary">Nou</button>
                    </form>
                </div>
            </div> 
            <div style="overflow-x: auto; overflow-y: auto; margin-top: -5px;" class="contenido">
            </div>
            <div class="paginas">
            </div>
        </main>
        <script src="assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="assets/myfw/js/myfw.js"></script>        
        <script type="text/javascript">
            function load(obj) { /* carrega el contingut de la paàgina */
                
                /* omple el contingut de la pàgina */
                $('.contenido').html('<div class="loading"><img src="images/Loading.gif" width="70px" height="70px"/><br/>Carregant dades, un moment si us plau...</div>');
                
                var page = obj;	
                      
                if (page==null){ /* si no s'ha informat del número de pàgina */
                    page = 1;
                }
                var dataString = 'page='+page;

                $.ajax({ /* recupera la llista de viatges i la paginació */
                    type: "GET",
                    url: "ajax/ajaxtravelshandler.php",
                    dataType: 'json',
                    cache: false,                    
                    data: dataString,
                    success: function(data) { /* si no hi ha hagut errors */

                        $('.contenido').fadeIn(2000).html(data.contenido);
                        $('.paginas').fadeIn(2000).html(data.paginas);                
                    }     
                });
                return false;
            }
            
            $(document).ready(function() { /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();

                /* crida al mètode que carrega el contingut de la pàgina */
                load();
            });    
        </script>       
    </body>
</html>
