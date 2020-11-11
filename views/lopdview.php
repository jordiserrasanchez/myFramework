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
        <link rel="stylesheet" href="assets/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
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
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2"><i class="fas fa-bug"></i> Llista d'accesos</h1>
                    </div> 
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-md-2 mb-3">
                                <label for="dataInici">Data Inici</label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                         <i class="fa fa-calendar-alt"></i>
                                    </div>                                    
                                    <input class="form-control" id="dataInici" name="dataInici" placeholder="MM/DD/YYYY" type="text" value="" required>
                                    <div class="invalid-feedback">
                                        La data és obligatoria.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="dataFinal">Data Final</label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                         <i class="fa fa-calendar-alt"></i>
                                    </div>                                    
                                    <input class="form-control" id="dataFinal" name="dataFinal" placeholder="MM/DD/YYYY" type="text" value="" required>
                                    <div class="invalid-feedback">
                                        La data és obligatoria.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="accio">Accio</label>                        
                                <div class="dropdown mr-2">
                                   <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                        Tots<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a id="T" class="dropdown-item">Tots</a></li>
                                        <li><a id="L" class="dropdown-item">Accedir a l'aplicació</a></li>
                                        <li><a id="X" class="dropdown-item">Sortir de l'aplicació</a></li>
                                        <li><a id="S" class="dropdown-item">Consulta de dades</a></li>
                                        <li><a id="I" class="dropdown-item">Afegir dades</a></li>
                                        <li><a id="U" class="dropdown-item">Modificar dades</a></li>
                                        <li><a id="D" class="dropdown-item">Esborrar dades</a></li>
                                    </ul>
                                </div>                    
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="resultat">Resultat</label>                            
                                <div class="dropdown mr-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                        Tots<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a id="T" class="dropdown-item">Tots</a></li>
                                        <li><a id="DA" class="dropdown-item">Accés denegat</a></li>
                                        <li><a id="AA" class="dropdown-item">Accés permès</a></li>
                                        <li><a id="UU" class="dropdown-item">Usuari desconegut</a></li>
                                        <li><a id="BU" class="dropdown-item">Usuari bloquejat</a></li>
                                    </ul>
                                </div>                    
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="modul">Mòdul</label> 
                                <div class="dropdown mr-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                        Grups<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a id="1" class="dropdown-item">Grups</a></li>
                                        <li><a id="0" class="dropdown-item">Usuaris</a></li>
                                    </ul>
                                </div>  
                            </div>

                        </div>
                    </div>
                    <hr class="mb-4">            
                    <div style="overflow-x: auto; overflow-y: auto; margin-top: -5px;" class="contenido">
                    </div>
                    <div class="paginas">
                    </div>
                </main>
            </div>
        </div>
        <script src="assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-datepicker/1.4.1/js/locales/bootstrap-datepicker.es.min.js"></script>
        <script src="assets/myfw/js/myfw.js"></script>        
        <script type="text/javascript">
            
            function load(obj) { /* carrega el contingut de la paàgina */
                
                /* omple el contingut de la pàgina */
                $('.contenido').html('<div class="loading"><img src="images/Loading.gif" width="70px" height="70px"/><br/>Carregant dades, un moment si us plau...</div>');
                
                var page = obj;	
                      
                if (page==null){ /* si no s'ha informat del número de pàgina */
                    page = 1;
                }

//                var idViatge = $('#idViatge').val();
                
                var dataString = 'page='+page;//+'&idViatge='+idViatge;

                $.ajax({ /* recupera la llista de detalls del viatge i la paginació */
                    type: "GET",
                    url: "ajax/ajaxlopdhandler.php",
                    dataType: 'json',
                    cache: false,                    
                    data: dataString,
                    success: function(data) {

                        $('.contenido').fadeIn(2000).html(data.contenido);
                        $('.paginas').fadeIn(2000).html(data.paginas);                
                    }   
                    
                    
                    
,
         error: function(jqxhr, status, exception) {
            //console.log(exception);
            //console.log(status);
            console.log(jqxhr);
            console.log(jqxhr.responseText);
            $('.contenido').fadeIn(2000).html(jqxhr.responseText);
            }                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                });
                return false;
            }

            $(document).ready(function() { /* al acaba de carregar la pàgina */
        
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();

                /* crida al mètode que carrega el contingut de la pàgina */        
                load();
                
                var startdate_input=$('input[name="dataInici"]'); 
                var enddate_input=$('input[name="dataFinal"]'); 
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		
                startdate_input.datepicker({  /* configura el calendari */
			format: 'dd/mm/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
                        language: 'es'
  		});

                enddate_input.datepicker({  /* configura el calendari */
			format: 'dd/mm/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
                        language: 'es'
  		});
                
            });
            
        </script>           
   </body>
</html>
