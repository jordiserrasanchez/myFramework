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
        <link rel="stylesheet" href="../assets/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/fontawesome/5.12.0/css/all.css">
        <link rel="stylesheet" href="../assets/myfw/css/myfw.css">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                    <nav class="navbar navbar-dark bg-dark shadow flex-md-nowrap" style="width:100%;" >
                        <a class="navbar-brand" href="#"><img style="width:25px;height:25px;" src="../assets/logo_menu.svg" /> Writing the future</a>
                    </nav>
            </div>
            <div class="row">
                <div class="col-2">
                    <div class="sidebar-sticky mt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item pl-2">
                                 <h3>Assistent de instal·lació</h3>
                            </li>                            
                            <li class="nav-item pl-2">
                                <i class="fas fa-check" style="color:lime"></i> Base de dades
                            </li>
                            <li class="nav-item pl-2">
                                <i class="fas fa-check"></i> Creant base de dades
                            </li>
                            <li class="nav-item pl-2">
                                <i class="fas fa-check"></i> Servidor de correu
                            </li>
                            <li class="nav-item pl-2">
                                <i class="fas fa-check"></i> Corporatiu
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-10">
                    <div class="row mt-3">
                        <div class="col-md-1">
                            <p class="ml-2">Estat:</p>
                        </div>
                        <div class="col-md-4">
                            <div class="progress" style="height: 32px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                  0%
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 text-right">
                            <i class="far fa-check-circle fa-2x" style="color:lime"></i> <i class="far fa-circle fa-2x"></i> <i class="far fa-circle fa-2x"></i> <i class="far fa-circle fa-2x"></i>
                        </div>
                    </div>
                    <div class="row ml-2 mt-4">
                        <div class="col-md-12">
                            <p class="font-weight-bold">Configuració dels paràmetres de connexió a la base de dades...</p>
                        </div>
                    </div>
                    <div class="row ml-2 mt-2">
                        <div class="col-md-12">
                            <p style="line-height:0;">Per utilizar aquest aplicatiu cal crear una base de dades nova per omplir-la de contigut.</p>
                            <p style="line-height:0;">Ompliu el següent formulari per configurar las base de dades i comproveu la connexió amb la mateixa.</p>
                        </div>
                    </div>
                    <div class="row ml-2 mt-4">
                        <div class="col-md-12">                        
                            <form action="index.php?step=1"  method="post" class="needs-validation" novalidate >
                                <div class="row form-group">
                                    <label for="host">Host:</label>
                                    <div class="col-md-3">
                                        <input type="text" name="host" id="host" value="" class="form-control" placeholder="Servidor bbdd..." required/>
                                        <div class="invalid-feedback">
                                            El host és obligatori.
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="username">Username:</label>
                                    <div class="col-md-3">
                                        <input type="text" name="username" id="username" value="" class="form-control" placeholder="Usuari..." required/>
                                        <div class="invalid-feedback">
                                            El nom de l'usuari és obligatori.
                                        </div>                          
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="password">Password:</label>
                                    <div class="col-md-3">
                                        <input type="password" name="password" id="password" value="" class="form-control" placeholder="Paraula de pas..." />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="dbname">Nom de la base de dades:</label>
                                    <div class="col-md-3">
                                        <input type="text" name="dbname" id="dbname" value="" class="form-control" placeholder="Base de dades..." required/>
                                        <div class="invalid-feedback">
                                            El nom de la base de dades és obligatori.
                                        </div>                          
                                    </div>                            
                                </div>
                                <div class="row form-group">
                                    <label for="tablesprefix">Prefix de les taules:</label>
                                    <div class="col-md-3">
                                        <input type="text" name="tablesprefix" id="tablesprefix" value="" class="form-control" placeholder="Base de dades..." required/>
                                        <div class="invalid-feedback">
                                            El nom de la base de dades és obligatori.
                                        </div>                          
                                    </div>                            
                                </div>
                                <div class="row form-group">Mostrar opcions avançades 
                                    <div class="col-md-3">

                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label id="lblport" for="port" hidden>Port:</label>
                                    <div class="col-md-3">
                                    <input type="text" name="port" id="port" value="3306" class="form-control" placeholder="3306..." hidden/>
                                        <div class="invalid-feedback">
                                            El port és obligatori.
                                        </div>                          
                                    </div>                            
                                </div>

                                <div class="row form-group">
                                    <label id="lblsocket" for="socket" hidden>Socket:</label>
                                    <div class="col-md-3">
                                    <input type="text" name="socket" id="socket" value="" class="form-control" placeholder="/var/run/mysqld/mysql.sock..." hidden/>
                                        <div class="invalid-feedback">
                                            El socket és obligatori.
                                        </div>                          
                                    </div>                            
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" type="button" onclick="javascript:testConnection();"><i class="fas fa-sync"></i> Comprovar la connexió amb la bbdd ara...</button>                                        
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-10 contenido">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Següent pas" type="submit">Següent <i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                     
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    
                </div>
                <div class="col-md-10 text-center">
                    <p>Si necessita assistència tècnica, si us plau contacti amb el departament tècnic al correu eletrònic support@myframework.cat. Disculpi les molèsties.</p>
                </div>
                <div class="col-md-1">
                    
                </div>
            </div>
        </div>
        <script src="../assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="../assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/myfw/js/myfw.js"></script>
        <script>
            $(document).ready(function(){ /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();
                
                 /* crida al mètode que mostra la finestra modal si existeix */
                $("#myModal").modal(
                    {
                        backdrop: 'static',
                        keyboard: false
                    }
                );
        
            });
            function testConnection() {
                

                var host = $("#host").prop("value");
                var username = $("#username").prop("value");
                var password = $("#password").prop("value");
                var dbname = $("#dbname").prop("value");
                var tablesprefix = $("#tablesprefix").prop("value");
                

                $.ajax({ /* recupera la llista de viatges i la paginació */
                    type: "GET",
                    url: "ajaxsetuphandler.php",
                    dataType: 'json',
                    cache: false,                    
                    data: {host: host, username: username, password: password, dbname: dbname, tablesprefix: tablesprefix},
                    success: function(data) { /* si no hi ha hagut errors */

                        $('.contenido').fadeIn(2000).html(data.contenido);
                    }
                    ,error: function(jqxhr, status, exception) {
                        //console.log(exception);
                        //console.log(status);
                        console.log(jqxhr);
                        console.log(jqxhr.responseText);
                        $('.contenido').fadeIn(2000).html(jqxhr.responseText);
                    }                    
                });

            }
            document.addEventListener('DOMContentLoaded', function () {
                var checkbox = document.querySelector('input[type="checkbox"]');

                checkbox.addEventListener('change', function () {
                    if (checkbox.checked) {
                        document.getElementById('port').hidden = false;
                        document.getElementById('lblport').hidden = false;
                        document.getElementById('socket').hidden = false;
                        document.getElementById('lblsocket').hidden = false;
                    } else {
                        document.getElementById('port').hidden = true;
                        document.getElementById('lblport').hidden = true;
                        document.getElementById('socket').hidden = true;
                        document.getElementById('lblsocket').hidden = true;
                    }
                });
          });
            
        </script>
    </body>
</html>
  