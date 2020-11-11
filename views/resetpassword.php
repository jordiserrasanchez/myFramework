<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">
        <title>Recuperar paraula de pas</title>
        <link rel="stylesheet" href="../assets/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/bootstrap/4.4/examples/floating-labels/floating-labels.css">
        <link rel="stylesheet" href="../assets/fontawesome/5.12.0/css/all.css">
    </head>
    <body>
        <div class="container" style="margin-top: 100px;">
            <div class="d-flex justify-content-center h-100" style="max-height: 260px;">
                <div class="card text-center" style="max-height: 260px;">
                    <div class="card-header">
                        Nova paraula de pas
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary" role="alert">
                            <h5 class="card-title response"></h5>
                        </div>
                        <p class="card-text"></p>
                        <a href="index.php" class="btn btn-primary">Tornar</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="../assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="../assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>  
        <script src="../assets/myfw/js/myfw.js"></script> 
        <script type="text/javascript">

            function $_GET(param) { /* recupera paràmetres de la url */

                /* Obtenir l'url complerta */
                url = document.URL;

                /* Buscar a partir del signe de interrogació ? */
                url = String(url.match(/\?+.+/));

                /* netejar la cadena treïent el signe ? */
                url = url.replace("?", "");

                /* Crear un array amb paràmetre=valor */
                url = url.split("&");

                /* 
                Recorrer el array url
                obtenir el valor i dividir-lo en dos parts a traves del signe = 
                0 = paràmetre
                1 = valor
                Si el paràmetro existeix tornar el seu valor
                */
                x = 0;
                while (x < url.length) {
                    p = url[x].split("=");
                    if (p[0] == param) {
                        return decodeURIComponent(p[1]);
                    }
                    x++;
                }
            }            

    
            $(document).ready(function() { /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();
                
                var dataString='email='+$_GET('email')+"&token="+$_GET('token');
                
                $.ajax({ /* regenera la paraula de pas */
                    url: '../ajax/ajaxresetpasswordhandler.php',
                    method: 'GET',
                    data: dataString,
                    success: function (response) { /* si no hi han hagut errors */
                        if (!response.success) { /* si no hi ha resposta satisfactoria */
                            $(".response").fadeIn(2000).html(response.msg);
                        } else {
                            $(".response").fadeIn(2000).html(response.msg);
                        }

                    }, 
                    error: function(jqxhr, status, exception) { /* si s'ha produït un error */

                        console.log(jqxhr);
                        console.log(jqxhr.responseText);
                        $("#response").html(jqxhr.responseText);
                    }
                });
            });
        </script>        
    </body>
</html>