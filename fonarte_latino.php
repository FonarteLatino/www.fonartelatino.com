
 <?php include("alertas.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
   <meta charset="ISO-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fonarte Latino | Fonarte Latino</title>
  
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i, 900" rel="stylesheet">
</head>

<body>

    <?php include("menu.php"); ?>

    <!-- Page Content -->
    
		
         <?php include("pinta_alerta.php"); ?>
        <!-- Inicio de titulo de la pagina -->
        <div class="container" style="width:100%;" >
        <div class="row franja" >
            <div class="col-lg-12">
                <div class="container">
                    <p class="page-header">Fonarte Latino<small>&nbsp;</small></p>
                </div>
            </div>
        </div>
        </div>
        <!-- Fin de titulo de la pagina -->

<div class="container">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
               <br><br>
               <?php
               $texto='<p class="tipografia_fonartelatino">Fonarte Latino nace en 1983 primeramente para dar el servicio de distribución a la primer disquera independiente que existió en México: Discos Pueblo. Muy pronto se convirtió en un aglutinador de productores y sellos independientes, comprometidos con la calidad, la propuesta, la no coyuntura, creatividad y genuina autenticidad. </p>

<p class="tipografia_fonartelatino">Contamos con un catálogo de más de 950 producciones discográficas de artistas como: Carlos Macías, Regina Orozco, Fernando Delgadillo, Mexicanto, Amparo Ochoa, Eugenia León, Los Folkloristas, Chava Flores, La Barranca, La Cuca, La Castañeda, Inspector, Santa Sabina, Jaime López, Los Estrambóticos, El Haragán, Virulo, Iraida Noriega, José Fors, Regina Orozco, Liliana Felipe, Paté de Fuá, Calacas Jazz Band, Carlos Carreira, Alejandro Santiago, Miguel Inzunza, Liran´Roll, Alex Mercado, entre muchos otros. </p>

<p class="tipografia_fonartelatino">Abarca principalmente géneros latinos como, cantautores, rock en español, rock urbano, jazz, world music, folklore, alternativo, blues, rap, hip-hop, reggae, clásico contemporáneo, instrumental, fusión.</p>

<p class="tipografia_fonartelatino">Actualmente, Fonarte es uno de los sellos líderes independientes de distribución física y digital, así como uno de los referentes de la música independiente de México dando cabida a las nuevas propuestas en el mercado formal y manteniendo un catálogo que aporte a la cultura musical de México y el mundo.</p>';
               
               
               echo utf8_encode($texto);
               ?>
               
               
               <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div> 
        <!-- /.row -->
    </div>
    <!-- /.container -->
    
     
    <?php include("pie.php"); ?>



    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
<?php
/*

Este codigo es propiedad de
Lic. Javier Alfredo Garcia Espinoza
j.garcia.e1987@gmail.com

*/
?>
</body>

</html>
