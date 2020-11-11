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
        <link rel="stylesheet" href="assets/bootstrap/4.4/examples/floating-labels/floating-labels.css">
        <link rel="stylesheet" href="assets/fontawesome/5.12.0/css/all.css">
    </head>
    <body>
        <form action="index.php?controlador=Login&action=Change" method="post" class="form-signin">
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal"><i class="fas fa-key"></i> Canviar la paraula de pas</h1>
            </div> 

            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input name="paraulaPasNova" id="paraulaPasNova" type="password" placeholder="Paraula nova..." class="form-control" required autofocus>
            </div>

            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input name="paraulaNovaRepetida" id="paraulaNovaRepetida" type="password" placeholder="Paraula repetida..." class="form-control" required autofocus>
            </div>
            
            <button class="btn btn-lg btn-primary btn-block" name="submit" id="submit" type="submit">Entrar...</button>
            <input name="menu" type="text" id="menu" value="login" hidden>
        </form>
        <script src="assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="assets/myfw/js/myfw.js"></script>        
        <script type="text/javascript">
            $(document).ready(function () { /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();
            });
        </script>                
    </body>
</html> 




            

            
            