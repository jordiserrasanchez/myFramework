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
        <style>
            /* centra verticalemente el card */
            html,
            body {
                height: 100%;
            }
            container {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-align: center;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }


            .container {
                width: 100%;
                max-width: 420px;
                padding: 15px;
                margin: auto;
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

        <div class="container">
            <div class="d-flex justify-content-center h-100" style="max-height: 260px;">
                <div class="card text-center" style="max-height: 260px;">
                    <div class="card-header">
                        Error
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            <h5 class="card-title">Accés no permés</h5>
                        </div>
                        <p class="card-text">S'ha produït un intent d'accés il·legal a aquest contigut.</p>
                        <a href="index.php?controlador=Dashboard&action=ViewList" class="btn btn-primary">Inici</a>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="assets/myfw/js/myfw.js"></script>
        <script type="text/javascript">
            $(document).ready(function() { /* al acaba de carregar la pàgina */

                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();
                
            });    
        </script>           
    </body>
</html>
