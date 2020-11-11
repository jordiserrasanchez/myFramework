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
                    <h1><i class="far fa-calendar-alt"></i>RESULTAT DE LA RESERVA</h1>
                </div>                
            </div>
            <div class="row">
                <?php require_once('modalwindow.php'); ?>
                <?php if ( !$this->showModal ) { ?>
                <div class="col-md-12 order-md-1">
                    <p>Benvolgut/da Sr./Sra. <span class="text-uppercase font-weight-bold"><?php echo $this->nomVisitant; ?></span></p>
                    <p>Mitjançant aquest formulari li queda confirmada la seva reserva vista amb el/la resident <span class="text-uppercase font-weight-bold"><?php echo $this->nomResident; ?></span> el dia <span class="text-uppercase font-weight-bold"><?php echo $this->llistaHoresVisita[0]["descripcioHoraDiaVisita"] .' de: ' . date_format ( date_create  ( $this->llistaHoresVisita[0]["horaEntrada"] ) , "H:i" ) .' a '. date_format ( date_create  ( $this->llistaHoresVisita[0]["horaSortida"] ) , "H:i" ); ?></span> al departament <span class="text-uppercase font-weight-bold"><?php echo $this->departament["descripcioDepartament"]; ?></span>.</p>
                    <p>Recordi que abans d'anar al departament cal que s'adreçi a la repció del centre per confirmar la seva arribada.</p>
                    <p>La Llar.</p>
                </div>
                <?php } else { ?>
                <div class="col-md-12 order-md-1">
                    <p>Benvolgut/da Sr./Sra. <span class="text-uppercase font-weight-bold"><?php echo $this->nomVisitant; ?></span></p>
                    <p><span class="text-uppercase font-weight-bold">ATENCIÓ:</span> S'ha produït un error i la seva reserva <span class="text-uppercase font-weight-bold">NO HA QUEDAT CONFIRMADA</span></p>
                    <p>Disculpi les molèsties.</p>
                    <p>La Llar.</p>
                    <form action="<?php echo "index.php?controlador=Visit&action=Schedule&token=" . $this->diaVisita["token"]; ?>" method="post">
                        <h3 class="float-left">Per a qualsevol dubte o aclariment poseu-vos en contacte amb nosaltres mitjançant WhatsApp al número 678.811.514</h3><span class="float-right"><button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Tornar al formulari de visita" type="submit"><i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i> Tornar</button></span>
                    </form>
                </div>
                <?php } ?>
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
  