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
                    <div class="row d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2 col-md-9">Taulell</h1>
                    </div>
                    <div class="row">
                        <div id="chart-container1" class="col-md-6">
                            <canvas class="my-4 w-100" id="graphTotal" width="600" height="300"></canvas>
                        </div>
                        <div class="col-md-6">
                            <div class="dropdown">
                                Any: <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                    Any actual<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                </ul>
                            </div>
                            <div id="chart-container2">
                                <canvas class="my-4 w-100" id="graphMensual" width="600" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                        <div class="card-deck">
                            <div class="card border-primary mb-3">
                                <div class="card-header">
                                    Import acumulat
                                </div>
                                <div class="card-body text-primary">
                                    <p class="card-text display-4" id="importAcumulat"></p>
                                </div>
                            </div>            
                            <div class="card  border-danger mb-3">
                                <div class="card-header">
                                    Import pendent
                                </div>
                                <div class="card-body text-danger">
                                    <p class="card-text display-4" id="importPendent"></p>
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
                
                /* crida al mètode que carrega la gràfica anual */
                showAnualGraph();
                
                /* crida al mètode que carrega el import acumulat */
                showImportAcumulat();
                
                /* crida al mètode que carrega el import pendent */
                showImportPendent();
                
                /* crida al mètode que carrega els anys que han tingut desepeses */
                carregaAnys();
                
                var d = new Date();
                var n = d.getFullYear();
                
                $('button[data-toggle="dropdown"]').text(n);
                
                /* crida al mètode que carrega la gràfica mensual */
                showMonthGraph(n);
                
                /* executa la funció al acabar de carregar la pàgina */
                $(function(){ /* intercepta el event */
                    $(".dropdown-menu").on("click", "a", function(event){
                        $('button[data-toggle="dropdown"]').text($(this).text());
                        showMonthGraph($(this).text());
                    })
                })
            });
            
            function showMonthGraph(dades) { /* carrega la gràfica mensual */
              
                {$.post("ajax/ajaxdashboardhandler.php", {any:dades,origen:'graficMensual'},
                    function (data) {
                        var name = [];
                        var marks = [];

                        for (var i in data) {
                            name.push(data[i].Mes);
                            marks.push(data[i].Import);
                        }
                        
                            var chartdata = {
                            labels: name,
                            datasets: [
                                {
                                    label: 'Despeses mensuals',
                                    lineTension: 0,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgb(54, 162, 235)',
                                    borderWidth: 1,
                                    pointBackgroundColor: '#007bff',
                                    data: marks
                                }
                            ]
                        };

                        var chartoptions = {
                            scales: {
                              yAxes: [{
                                ticks: {
                                  beginAtZero: false
                                }
                              }]
                            },
                            legend: {
                              display: true
                            }
                        };

                        var graphTarget = $("#graphMensual");

                        var barGraph = new Chart(graphTarget, {
                            type: 'bar',
                            data: chartdata,
                            options: chartoptions,
                        });
                    });
                }
            }            


            function showAnualGraph() { /* carrega la gràfica anual */
                { $.post("ajax/ajaxdashboardhandler.php", {origen:'graficAnual'},
                    function (data) {                   
                        var name = [];
                        var marks = [];

                        for (var i in data) {
                            name.push(data[i].Any);
                            marks.push(data[i].Import);
                        }
                            var chartdata = {
                            labels: name,
                            datasets: [
                                {
                                    label: 'Despeses anuals',
                                    lineTension: 0,
                                    backgroundColor: 'transparent',
                                    borderColor: '#007bff',
                                    borderWidth: 4,
                                    pointBackgroundColor: '#007bff',
                                    data: marks
                                }
                            ]
                        };

                        var chartoptions = {
                            scales: {
                              yAxes: [{
                                ticks: {
                                  beginAtZero: false
                                }
                              }]
                            },
                            legend: {
                              display: true
                            }
                        };

                        var graphTarget = $("#graphTotal");

                        var lineGraph = new Chart(graphTarget, {
                            type: 'line',
                            data: chartdata,
                            options: chartoptions,
                        });
                    });
                }
            }
            
            function showImportAcumulat() { /* carrega el import acumulat */
                $.post("ajax/ajaxdashboardhandler.php", {origen:'ImportAcumulat'},
                    function (data) {                            
                        var importAcumulat = (data.Import == null) ? 0 : data.Import;
                        $('#importAcumulat').fadeIn(2000).html(importAcumulat+' €');  
                    }
                );
            }
            
            function showImportPendent() { /* carrega el import pendent */
              $.post("ajax/ajaxdashboardhandler.php", {origen:'ImportPendent'},
                    function (data) {                           
                        var importPendent = (data.Import == null) ? 0 : data.Import;
                        $('#importPendent').fadeIn(2000).html(importPendent+' €');  
                        
                    }
                );
            }

            function carregaAnys() { /* carrega la llista d'anys amb despeses */
              $.post("ajax/ajaxdashboardhandler.php", {origen:'carregaAnys'},
                    function (data) {                       
                        var lista = '';
                        for (var i in data) {
                            lista = lista +'<li><a class="dropdown-item">'+data[i].Any+'</a></li>';
                        }
                        $('.dropdown-menu').html(lista);              
                    }
                );
            }

        </script>
    </body>
</html>