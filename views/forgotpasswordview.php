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
            <div class="row justify-content-center">
                <div class="col-md-6 col-md-offset-3" align="center">
                    <img class="mb-4" src="../assets/logo.png" alt="" width="200" height="200"><br><br>
                    <input class="form-control" id="correu" placeholder="La teva adreça de correu electrònic"><br>
                    <a href="index.php" class="btn btn-primary">Tornar</a>&nbsp;&nbsp;<input type="button" class="btn btn-primary" value="Recuperar">
                    <br><br>
                    <p id="response"></p>
                </div>
            </div>
        </div>
        <script src="../assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="../assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/myfw/js/myfw.js"></script>        
        <script type="text/javascript">
            var correu = $("#correu");        
            $(document).ready(function () { /* al acaba de carregar la pàgina */
                
               /* crida al mètode que desahiblita els botons de navagació del navegador */
               dissableHistory();
                
                $('.btn-primary').on('click', function() { /* intercepta el event */
                    
                    if (correu.val() != "") { /* si s'ha omplert el camp del correu */
                        
                        correu.css('border', '1px solid green');
                        
                        $.ajax({ /* recupera la paraula de pas olvidada */
                            url: '../ajax/ajaxforgotpasswordhandler.php',
                            method: 'POST',
                            data: {correu: correu.val()}, 
                            success: function (response) { /* si no hi han hagut errors */
                                if (!response.success) { /* si no hi ha resposta satisfactoria */
                                    $(".container").html(response.msg);
                                } else {
                                    $(".container").html(response.msg);
                                }

                            }, 
                            error: function(jqxhr, status, exception) { /* si s'ha produït un error */
                               $("#response").html(jqxhr.responseText);
                            }
                        });
                    } else
                        correu.css('border', '1px solid red');
                });
            });
        </script>        
    </body>
</html>