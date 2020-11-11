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
        <style>
            /* centra verticalemente el card */
            html,
            body {
                height: 100%;
            }

            body {
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
        <div class="container">
            <div class="d-flex justify-content-center h-100" style="max-height: 260px;">
                <div class="card text-center" style="max-height: 260px;">
                    <div class="card-header">
                        <?php echo $this->error->cardheader;?>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            <h5 class="card-title"><?php echo $this->error->cardtitle;?></h5>
                        </div>
                        <p class="card-text"><?php echo $this->error->cardtext;?></p>
                        <a href="index.php" class="btn btn-primary"><?php echo $this->error->cardbutton;?></a>
                    </div>
                </div>
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