        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><img style="width:25px;height:25px;" src="assets/logo_menu.svg" /> Menú</a>
            <ul class="navbar-nav px-3">
                <li class="nav-item dropdown text-nowrap">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> <?php echo "[ " . strtoupper ( $_SESSION["usuari"] ) . " ] "; ?>
                    </a>  
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="position: absolute;">
                        <form  name="f1" action="index.php?controlador=Users&action=EditProfile" method="post">
                            <input type="text" name="idModificar" id="idModificar" value="<?php echo $_SESSION["idUsuari"]; ?>" hidden>
                            <a class="dropdown-item" href="javascript:document.f1.submit();"><i class="fas fa-user-cog"></i> Perfil</a>
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php?controlador=Logout"><i class="fas fa-sign-out-alt"></i> Desconectar</a>
                    </div>
               </li>
            </ul>
        </nav>

