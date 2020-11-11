        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><img style="width:25px;height:25px;" src="assets/logo_menu.svg" /> Menú</a>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <form name="form" action="index.php?controlador=Logout" method="post">
                        <input type="text" name="menu" id="menu" value="logout" hidden>
                        <button type="submit" name="submit" id="submit" class="nav-link" style="background: none; border: 0; margin-bottom: -15px; color: #FFF;" value="logout"><i class="fas fa-user"></i> Desconnectar</button>
                    </form>
               </li>
            </ul>
        </nav>