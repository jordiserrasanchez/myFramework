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
    </head>
    <body>
        <div class="container">
            <div class="row">
                <img class="mb-4" src="assets/logo_llar.jpg" alt="" width="150" height="150">
                <div class="ml-1 py-5 text-center">
                    <h1><i class="far fa-calendar-alt"></i> RESERVA DE VISITA</h1>
                </div>                
            </div>
            <div class="row">
                <?php require_once('modalwindow.php'); ?>
                <div class="col-md-12 order-md-1">
                    <div class="row">

                         <div class="col-md-3 mb-3">
                            <p>Departament: 
                                <span class="text-uppercase font-weight-bold"><?php echo $this->departament[ 'descripcioDepartament' ]; ?></span>
                            </p>
                        </div>                              
                    </div>
                    <div class="row">                    
                        <div class="col-md-3 mb-3">
                            <p>Setmana del:
                                <span class="text-uppercase font-weight-bold"><?php echo date_format ( date_create ( $this->diaVisita['dataVisita']  ?? "" ) , 'd/m/Y' ); ?></span>
                            </p>
                        </div>
                    </div>
                    <form action="index.php?controlador=Visit&action=Save" method="post" class="needs-validation">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nomResident">Resident</label>
                                <input type="text" name="nomResident" class="form-control" id="nomResident"  placeholder="Nom i cognoms" required>
                                <div class="invalid-feedback">
                                    Les dades del resident son obligatories.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nomVisitant">Visitant</label>
                                <input type="text" name="nomVisitant" class="form-control" id="nomVisitant"  placeholder="Nom i cognoms" required>
                                <div class="invalid-feedback">
                                    Les dades del visitant son obligatories.
                                </div>
                            </div>                                   
                        </div>
                        <hr class="mb-4">                            
                        <div class="row">                            
                            <h2><span class="text-uppercase font-weight-bold">Hores disponibles</span></h2>
                        </div>
                        <hr class="mb-4">                            
                        <?php 
                            $default = "checked"; /** Marca el primer check per a que com a mínim hi hagi un de marcat */
                            foreach ( $this->llistaHoresVisita as $row ) {
                                print('<div class="row">');
                                print('     <div class="col">');
                                printf("        <input type=\"radio\" name=\"idHoraDiaVisita\" id=\"%s\" value=\"%s\" %s>", $row["idHoraDiaVisita"], $row["idHoraDiaVisita"], $default );
                                printf("        <span class=\"font-weight-bold\">%s de: %s a %s</span>", $row["descripcioHoraDiaVisita"], date_format ( date_create  ( $row["horaEntrada"] ), "H:i" ), date_format ( date_create  ( $row["horaSortida"] ), "H:i" ) );
                                print('     </div>');
                                print('</div>');                                      
                                $default = "";
                            }
                        ?> 

                        <hr class="mb-4">
                        <div class="clearfix">
                            <h3 class="float-left">Per a qualsevol dubte o aclariment poseu-vos en contacte amb nosaltres mitjançant WhatsApp al número 678.811.514</h3><span class="float-right"><button class="btn btn-primary" type="submit">Enviar <i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></button></span>
                        </div>
                        <input type="text" name="idDiaVisita" id="idDiaVisita" value="<?php echo $this->diaVisita[ 'idDiaVisita' ]  ?? ""; ?>" hidden>
                    </form>
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
                
                 /* crida al mètode que mostra la finestra modal si existeix */
                $("#myModal").modal(
                    {
                        backdrop: 'static',
                        keyboard: false
                    }
                );
        
            });
            
        </script>
    </body>
</html>
  