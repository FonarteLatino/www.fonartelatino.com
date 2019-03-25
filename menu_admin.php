<?php include_once("estilos.php");



//quierey categorias todas menos Merchandisign
mysql_select_db($database_conexion, $conexion);
$query_Categorias = "SELECT * FROM categoria where id!=4 order by nombre ASC";
$Categorias = mysql_query($query_Categorias, $conexion) or die(mysql_error());
$row_Categorias = mysql_fetch_assoc($Categorias);
$totalRows_Categorias = mysql_num_rows($Categorias);



//quierey categorias todas menos Merchandisign
mysql_select_db($database_conexion, $conexion);
$query_CategoriasMerch = "SELECT * FROM categoria where id=4 order by nombre ASC";
$Merch = mysql_query($query_CategoriasMerch, $conexion) or die(mysql_error());
$row_Merch = mysql_fetch_assoc($Merch);
$totalRows_Merch = mysql_num_rows($Merch);



 ?>    





<nav class="navbar navbar-inverse  navbar-fixed-top" role="navigation" >
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand tipografia_menu_admin" href="redirecciona.php"><i class="fa fa-tachometer" aria-hidden="true"></i> &nbsp;Fonarte Latino Panel</a>
        </div>
        
        
        
        <!-- inicio de menu -->
        <div class="collapse navbar-collapse tipografia" id="bs-example-navbar-collapse-1" >
            <ul class="nav navbar-nav navbar-right" >
                     
			
            <?php
			if($_SESSION['USUARIO']['nivel']==1)
			{
				?>
                
                 <!-- inicio de  Opcion2 desplegable-->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle tipografia_menu_admin" data-toggle="dropdown"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;Ecommerce<b class="caret"></b></a>
                <ul class="dropdown-menu">
					<li>
                        <a href="bienvenida.php"><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;Pedidos</a>
                    </li>
                    
                  
                    <li>
                        <a href="admin_reporte.php"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;Reporte</a>
                    </li>

                </ul>
            </li>
            <!-- fin de  Opcion2 desplegable-->
                
                
                

              <!-- inicio de  Opcion2 desplegable-->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle tipografia_menu_admin" data-toggle="dropdown"><span class="fa fa-cog"></span>&nbsp;Ajustes <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="admin_categorias.php"><i class="fa fa-tags" aria-hidden="true"></i>&nbsp;Categorias</a>
                    </li>
					<li>
                        <a href="admin_generos.php"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;G&eacute;neros</a>
                    </li>

					<li>
                        <a href="admin_precios.php"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;Precios Productos</a>
                    </li>
                    
                    <li>
                        <a href="admin_precio_envios.php"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>&nbsp;Precios Envios</a>
                    </li>
                    
                    <li>
                        <a href="admin_cupon.php"><i class="fa fa-ticket" aria-hidden="true"></i>&nbsp;Cupon</a>
                    </li>
                    
                    <li>
                        <a href="admin_home.php"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;Home</a>
                    </li>

                </ul>
            </li>
            <!-- fin de  Opcion2 desplegable-->
          
          
               
         <!-- inicio de  Opcion2 desplegable-->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle tipografia_menu_admin" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar <b class="caret"></b></a>
                <ul class="dropdown-menu">

                    
					<li>
                        <a href="admin_nuevo_producto.php"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;<?php
						do
						{
							if ($row_Categorias['nombre'] != "Firelink") {
                                
                                echo $row_Categorias['nombre']." - ";
                            }
						}while($row_Categorias = mysql_fetch_assoc($Categorias));
						 ?></a>
                    </li>
                    
                  
                    <li>
                        <a href="admin_nuevo_otro.php"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;<?php echo $row_Merch['nombre']; ?></a>
                    </li>

                    <li>
                        <a href="admin_nuevo_firelinkPlaylist.php"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Firelink Playlist</a>
                    </li>

                </ul>
            </li>
            <!-- fin de  Opcion2 desplegable-->
                
                
            <!-- inicio de  Opcion2 desplegable-->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle tipografia_menu_admin" data-toggle="dropdown"><span class="glyphicon glyphicon-cd"></span>&nbsp;Productos <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                    <a href="admin_productos.php"><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;Lista</a>
                    </li>
                    <li>
                    <a href="admin_productos_otros.php"><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;Lista <?php echo $row_Merch['nombre']; ?></a>
                    </li>
                    <li>
                    <a href="admin_firelinkPlaylist.php"><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;Lista Playlist</a>
                    </li>
        
                </ul>
            </li>
            <!-- fin de  Opcion2 desplegable-->

                <?php	
			}	
            if($_SESSION['USUARIO']['nivel']==2)
            {
                ?>
                
                <!-- inicio de  Opcion2 desplegable-->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle tipografia_menu_admin" data-toggle="dropdown"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;Ecommerce<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="admin_reporte.php"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;Reporte</a>
                    </li>

                </ul>
            </li>
            <!-- fin de  Opcion2 desplegable-->
            
                <?php
            }
            		
			?>
        
               
                
                
              	<!-- inicio de  USUARIO -->
                <?php
				if(isset($_SESSION['USUARIO']))
				{
				?>
                <li class="dropdown tipografia_menu_admin">
                    <a href="#" class="dropdown-toggle tipografia_menu_admin" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php print_r($_SESSION['USUARIO']['nombre']); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="salir.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesion</a>
                        </li>
                    </ul>
                </li>
                <?php	
				}
				?>
                

               <!-- fin de  USUARIO-->
               
               
            </ul>
        </div>
        <!-- fin de menu -->
        
        
    </div>
    <!-- /.container -->
</nav>
