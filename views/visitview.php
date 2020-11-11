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
        <?php require_once ( 'headerbar.php' ); ?>

        <div class="container-fluid">
            <div class="row">
                <?php echo $_SESSION['menu']; ?>
                <main role="main" class="col-md-8 ml-sm-auto col-lg-10 px-4">
                    <?php require_once('modalwindow.php'); ?>
                    <div style="overflow-x: auto; overflow-y: auto; margin-top: -5px; ">

                        <div class="col-md-12 order-md-1">
                            <div class="py-5 text-center">
                                <h1><i class="far fa-calendar-alt"></i> Días de visita</h1>
                            </div>
                        </div>

                        <div class="col-md-12 order-md-1">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <p>Data de la visita:
                                            <span class="text-uppercase font-weight-bold"><?php echo date_format ( date_create ( $this->diaVisita['dataVisita']  ?? "" ) , 'd/m/Y' ); ?></span>
                                        </p>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <p>Departament:
                                            <span class="text-uppercase font-weight-bold"><?php echo $this->departament[ 'descripcioDepartament' ]; ?></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                <?php 
                                print('<table id="table" class="table table-sm table-bordered table-hover table-striped" style="width: auto; white-space: nowrap;">');
                                    print('<thead class="thead-dark">');
                                        print('<tr>');
                                            print('<th colspan="3">Opcions</th>');
                                            print('<th>Franja</th>');
                                            print('<th>idVisita</th>');
                                            print('<th>Resident</th>');
                                            print('<th>Visitant</th>');
                                            print('<th colspan="2">Accions</th>');
                                        print('</tr>');
                                    print('</thead>');
                                    print('<tbody>');
                                    foreach ( $this->llistaHoresVisita as $row ) {
                                        print ( '<tr>' );
                                        /* Botó esborrar */
                                        print ( ' <td>' );
                                        printf ( ' <button %s class="btn btn-danger btn-sm" type="submit" name="esborra%s" id="esborra%s" data-toggle="tooltip" data-placement="top" title="Esborrar la visita" onclick="esborraRegistre(' . $row['idHoraDiaVisita'] . ')" ><i class="fa fa-trash-alt"></i></button>' , ($row["idVisita"] == "" ) ? "disabled" : "" , $row["idHoraDiaVisita"], $row["idHoraDiaVisita"] );
                                        print ( ' </td>' );
                                        /* Botó editar */
                                        print ( ' <td>' );
                                        printf ( ' <button %s class="btn btn-warning btn-sm" type="submit" name="edita%s" id="edita%s" data-toggle="tooltip" data-placement="top" title="Modificar la visita" onclick="editaRegistre(' . $row['idHoraDiaVisita'] . ')" ><i class="fa fa-pencil-alt"></i></button>' , ($row["idVisita"] == "" ) ? "disabled" : "" ,$row["idHoraDiaVisita"], $row["idHoraDiaVisita"] );
                                        print ( ' </td>' );
                                        /* Botó afegir */
                                        print ( ' <td>' );                                        
                                        printf ( ' <button %s class="btn btn-primary btn-sm" type="submit" name="afegeix%s" id="afegeix%s" data-toggle="tooltip" data-placement="top" title="Afegir una visita" onclick="afegeixRegistre(' . $row['idHoraDiaVisita'] . ')" ><i class="fa fa-plus"></i></button>' , ($row["idVisita"] != "" ) ? "disabled" : "" , $row["idHoraDiaVisita"], $row["idHoraDiaVisita"] );
                                        print ( ' </td>' );
                                        /* Camp descripcioHoraDiaVisita */
                                        print ( ' <td>' );
                                        printf ( ' <span class="font-weiht-bold">%s de: %s a %s</span>' , $row["descripcioHoraDiaVisita"] , date_format ( date_create  ( $row["horaEntrada"] ) , "H:i" ) , date_format ( date_create  ( $row["horaSortida"] ) , "H:i" ) );
                                        print ( ' </td>' );
                                        /* Camp idVisita */
                                        print ( ' <td>' );
                                        printf ( ' <input disabled type="text" name="idVisita%s" class="form-control" id="idVisita%s"  placeholder="" value="%s" required>' , $row["idHoraDiaVisita"] , $row["idHoraDiaVisita"] , $row[ 'idVisita' ]  ?? "" );
                                        print ( ' </td>' );
                                        /* Camp nomResident */
                                        print ( ' <td>' );
                                        printf ( ' <input disabled type="text" name="nomResident%s" class="form-control" id="nomResident%s"  placeholder="" value="%s" required>' , $row["idHoraDiaVisita"] , $row["idHoraDiaVisita"] , $row[ 'nomResident' ]  ?? "" );
                                        print ( ' </td>' );
                                        /* Camp nomVisitant */
                                        print ( ' <td>' );
                                        printf ( '    <input disabled type="text" name="nomVisitant%s" class="form-control" id="nomVisitant%s"  placeholder="" value="%s" required>' , $row["idHoraDiaVisita"] , $row["idHoraDiaVisita"] , $row[ 'nomVisitant' ]  ?? "" );
                                        print ( ' </td>' );                                      
                                        /* Botó desar */
                                        print (' <td>' );                                        
                                        printf ('         <button class="btn btn-success btn-sm" type="submit" name="desa%s" id="desa%s" onclick="desaCanvis(' . $row['idHoraDiaVisita'] . ')" disabled><i class="fas fa-check"></i></button>' , $row["idHoraDiaVisita"] , $row["idHoraDiaVisita"] );
                                        print (' </td>' );
                                        /* Botó anul·lar */
                                        print(' <td>');                                        
                                        printf('         <button class="btn btn-danger btn-sm" type="submit" name="anula%s" id="anula%s" onclick="anulaCanvis(' . $row['idHoraDiaVisita'] . ')" disabled><i class="far fa-times-circle"></i></button>', $row["idHoraDiaVisita"], $row["idHoraDiaVisita"]);
                                        print(' </td>');
                                        
                                        print('</tr>');
                                    }
                                        print('</tbody>');
                                        print('</table>');
                                        
                                ?>                                                
                                </div>
                                <div class="row">
                                        <form action="" method="post" class="needs-validation" novalidate>
                                            <button class="btn btn-danger" type="submit" formaction="index.php?controlador=VisitDays&action=ViewList" data-toggle="tooltip" data-placement="top" title="Descarta els canvis realitzats"><i class="far fa-times-circle"></i> Tancar</button>
                                        </form>
                                </div>
                        </div>
                       
                    </div>
                  
                </main>
            </div>
        </div>
        <script src="assets/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-datepicker/1.4.1/js/locales/bootstrap-datepicker.es.min.js"></script>
        <script src="assets/myfw/js/myfw.js"></script>
        <script>
            $(document).ready(function(){ /* al acaba de carregar la pàgina */
                
                /* crida al mètode que desahiblita els botons de navagació del navegador */
                dissableHistory();
                
                 /* crida al mètode que mostra la finestra modal si existeix */

        
            });
            
        </script>
        <script>
            function editaRegistre ( numeroRegistre ) {
                if ( confirm ( '¿Estàs segur/a que vols editar aquest registre? ' ) ) {
                    $( "#nomResident"+numeroRegistre ).prop( "disabled" , false );
                    $( "#nomVisitant"+numeroRegistre ).prop( "disabled" , false );
                    $( "#desa"+numeroRegistre ).prop( "disabled" , false );
                    $( "#anula"+numeroRegistre ).prop( "disabled" , false );
                    $( "#esborra"+numeroRegistre ).prop( "disabled" , true );
                    $( "#edita"+numeroRegistre ).prop( "disabled" , true );
                    $( "#afegeix"+numeroRegistre ).prop( "disabled" , true );
                }
            }
            function afegeixRegistre ( numeroRegistre ) {
                if ( confirm('¿Estàs segur/a que vols afegir aquest registre? ' ) ) {
                    $( "#nomResident"+numeroRegistre ).prop( "disabled" , false );
                    $( "#nomVisitant"+numeroRegistre ).prop( "disabled" , false );
                    $( "#desa"+numeroRegistre ).prop( "disabled" , false );
                    $( "#anula"+numeroRegistre ).prop( "disabled" , false );
                    $( "#esborra"+numeroRegistre ).prop( "disabled" , true );
                    $( "#edita"+numeroRegistre ).prop( "disabled" , true );
                    $( "#afegeix"+numeroRegistre ).prop( "disabled" , true );
                }              
            }
            function esborraRegistre ( numeroRegistre ) {
                if ( confirm ( '¿Estàs segur/a que vols eliminar aquest registre?' ) ) {
                    $.ajax({ /* recupera les dades anteriors */
                        type: "POST",
                        url: "ajax/ajaxvisithandler.php",
                        dataType: 'json',
                        cache: false,                    
                        data: {idHoraDiaVisita: numeroRegistre, action: 'Delete'},
                        success: function(data) { /* si no hi ha hagut errors */
                            
                            $( "#idVisita"+numeroRegistre ).prop( "value" , data[0]);
                            $( "#nomResident"+numeroRegistre ).prop( "value" , data[1]);
                            $( "#nomVisitant"+numeroRegistre ).prop( "value" , data[2]);
                            estatControls ( numeroRegistre ); 
                        }
                    });
                }
            }
           
            function anulaCanvis ( numeroRegistre ) {
                 if ( confirm ( '¿Estàs segur/a que vols anular els canvis? ' ) ) {
                    $( "#nomResident"+numeroRegistre ).prop( "disabled" , true );
                    $( "#nomVisitant"+numeroRegistre ).prop( "disabled" , true );

                    $.ajax({ /* recupera les dades anteriors */
                        type: "POST",
                        url: "ajax/ajaxvisithandler.php",
                        dataType: 'json',
                        cache: false,                    
                        data: {idHoraDiaVisita: numeroRegistre, action: 'Cancel'},
                        success: function(data) { /* si no hi ha hagut errors */
                            
                            $( "#idVisita"+numeroRegistre ).prop( "value" , data[0]);
                            $( "#nomResident"+numeroRegistre ).prop( "value" , data[1]);
                            $( "#nomVisitant"+numeroRegistre ).prop( "value" , data[2]);
                            estatControls ( numeroRegistre );
                        }
                    });
                } 
            }

            function desaCanvis ( numeroRegistre ) {
                if ( confirm ( '¿Estàs segur/a que vols desar els canvis? ' ) ) {
                    if ($( "#nomResident"+numeroRegistre ).prop( "value") != "" && $( "#nomVisitant"+numeroRegistre ).prop( "value") != "") {
                        $( "#nomResident"+numeroRegistre ).prop( "disabled" , true );
                        $( "#nomVisitant"+numeroRegistre ).prop( "disabled" , true );

                        var numeroVisita = $( "#idVisita"+numeroRegistre ).prop( "value");
                        var resident = $( "#nomResident"+numeroRegistre ).prop( "value");
                        var visitant = $( "#nomVisitant"+numeroRegistre ).prop( "value");

                        $.ajax({ /* recupera les dades anteriors */
                            type: "POST",
                            url: "ajax/ajaxvisithandler.php",
                            dataType: 'json',
                            cache: false,                    
                            data: {idHoraDiaVisita: numeroRegistre, idVisita: numeroVisita, nomResident: resident, nomVisitant: visitant, action: 'Save'},
                            success: function(data) { /* si no hi ha hagut errors */

                                $( "#idVisita"+numeroRegistre ).prop( "value" , data[0]);
                                $( "#nomResident"+numeroRegistre ).prop( "value" , data[1]);
                                $( "#nomVisitant"+numeroRegistre ).prop( "value" , data[2]);

                                if (data[3]==true) { // si s'ha produtir error
                                    estatControls ( numeroRegistre );
                                } else {
                                    
                                    $('#modalCenterTitle').text(data[4]);
                                    $('#modal-body').text(data[5]);
                                    $('#cardbutton').text('Tancar');
                                    $("#myModal").modal(
                                        {
                                            backdrop: 'static',
                                            keyboard: false
                                        }
                                    ); 

                                    $.ajax({ /* recupera les dades anteriors */
                                        type: "POST",
                                        url: "ajax/ajaxvisithandler.php",
                                        dataType: 'json',
                                        cache: false,                    
                                        data: {idHoraDiaVisita: numeroRegistre, action: 'Cancel'},
                                        success: function(data) { /* si no hi ha hagut errors */

                                            $( "#idVisita"+numeroRegistre ).prop( "value" , data[0]);
                                            $( "#nomResident"+numeroRegistre ).prop( "value" , data[1]);
                                            $( "#nomVisitant"+numeroRegistre ).prop( "value" , data[2]);
                                            estatControls ( numeroRegistre );
                                        }
                                    })

                                }
                                
                            } 
                            
                        });
                    } else {

                        $('#modalCenterTitle').text('Error');
                        $('#modal-body').text('Cal omplir tots els camps!!!');
                        $('#cardbutton').text('Tancar');
                        $("#myModal").modal(
                            {
                                backdrop: 'static',
                                keyboard: false
                            }
                        );                        
                    }
                } 
                
            }
            
            function existeixRegistre ( numeroRegistre ) {
                
                if ( $( "#idVisita"+numeroRegistre ).prop( "value" ) == "" ) {
                    return false;
                } else {
                    return true;
                }
                
            }

            function estatControls ( numeroRegistre ) {
                $( "#desa"+numeroRegistre ).prop( "disabled" , true );
                $( "#anula"+numeroRegistre ).prop( "disabled" , true );
                if ( existeixRegistre( numeroRegistre ) === true ) {
                    $( "#esborra"+numeroRegistre ).prop( "disabled" , false );
                    $( "#edita"+numeroRegistre ).prop( "disabled" , false );
                    $( "#afegeix"+numeroRegistre ).prop( "disabled" , true );
                } else {
                    $( "#esborra"+numeroRegistre ).prop( "disabled" , true );
                    $( "#edita"+numeroRegistre ).prop( "disabled" , true );
                    $( "#afegeix"+numeroRegistre ).prop( "disabled" , false );
                }
            }
            
        </script>
            
    </body>
</html>

