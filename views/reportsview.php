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
                <h1 class="h2"><i class="fas fa-print"></i> Llistats</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                            Sel·leccionar llistat<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Pendents</a></li>
                            <li><a class="dropdown-item" href="#">Abonades</a></li>
                            <li><a class="dropdown-item" href="#">Totals</a></li>
                        </ul>
                    </div>                                        
                </div>
            </div> 
            <div style="max-height: 600px; height: 600px; overflow-x: auto; overflow-y: auto; margin-top: -5px;" class="contenido">
            </div>
            <div class="paginas">
            </div>
        </main>
        <script src="assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="assets/myfw/js/myfw.js"></script>         
        <script>
                        
            $(document).ready(function () { /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();
                
                /* executa la funció al acabar de carregar la pàgina */
                $(function(){
                    $(".dropdown-menu").on("click", "a", function(event){ /* intercepta el event */
                        
                        $('button[data-toggle="dropdown"]').text($(this).text());
                        var dataString = 'informe='+$(this).text();

                        $('.contenido').html('<div class="loading"><img src="images/Loading.gif" width="70px" height="70px"/><br/>Carregant dades, un moment si us plau...</div>');
                        $.ajax({ /* recupera la el informe */
                            method: 'GET',
                            url: 'ajax/ajaxreportshandler.php',
                            cache: false,
                            data: dataString,
                             //xhrFields is what did the trick to read the blob to pdf
                            xhrFields: {
                                responseType: 'blob'
                            },
                            success: function (response, status, xhr) {
                                $('.contenido').html('');
                                var filename = "";                   
                                var disposition = xhr.getResponseHeader('Content-Disposition');

                                 if (disposition) {
                                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                    var matches = filenameRegex.exec(disposition);
                                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                                } 
                                var linkelem = document.createElement('a');
                                try {
                                    var blob = new Blob([response], { type: 'application/octet-stream' });                        

                                    if (typeof window.navigator.msSaveBlob !== 'undefined') {
                                        //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                                        window.navigator.msSaveBlob(blob, filename);
                                    } else {
                                        var URL = window.URL || window.webkitURL;
                                        var downloadUrl = URL.createObjectURL(blob);

                                        if (filename) { 
                                            // use HTML5 a[download] attribute to specify filename
                                            var a = document.createElement("a");

                                            // safari doesn't support this yet
                                            if (typeof a.download === 'undefined') {
                                                window.location = downloadUrl;
                                            } else {
                                                a.href = downloadUrl;
                                                a.download = filename;
                                                document.body.appendChild(a);
                                                a.target = "_blank";
                                                a.click();
                                            }
                                        } else {
                                            window.location = downloadUrl;
                                        }
                                    }   

                                } catch (ex) {
                                    $('.contenido').html('');
                                    console.log(ex);
                                } 
                            }
                        });
                    })
                })                 
            });
        </script>
    </body>
</html>