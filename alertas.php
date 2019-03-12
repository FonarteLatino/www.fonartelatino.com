<?php
/**********************************
Lic. Javier Alfredo Garcia Espinoza
Noviembre del 2015
javier.garciae@morelos.gob.mx
***********************************/
if(isset($_GET['alerta']))
{
	switch($_GET['alerta'])
	{   
		/*SESION INICIADA CON EXITO*/
		case 1:$msj='<strong>Bienvenido(a)</strong> ';
				$clase='alert alert-warning alert-dismissable';
				break;
				
		/*ERROR DE USUARIO O CONTRASEÑA*/
		case 2:$msj='<strong>Error!</strong> Usuario o contrase&ntilde;a incorrecta.';
				$clase='alert alert-danger';
				break;
		
		/*ERROR DE USUARIO O CONTRASEÑA*/
		case 3:$msj='<strong>Error!</strong> Es necesario iniciar sesion.';
				$clase='alert alert-danger';
				break;
		
		/*SESION CERRADA CON EXITO*/
		case 4:$msj='<strong>Listo!</strong> Sesion terminada!';
				$clase='alert alert-warning alert-dismissable';
				break;
					
				
		/* INSERT */
		case 5:$msj='<strong>Listo!</strong> Alta con exito';
				$clase='alert alert-warning alert-dismissable';
				break;	
		
		/* UPDATE */
		case 6:$msj='<strong>Listo!</strong> Registro editado con exito';
				$clase='alert alert-warning alert-dismissable';
				break;	
		
		/* DELETE */
		case 7:$msj='<strong>Listo!</strong> El registro fue eliminado con exito';
				$clase='alert alert-warning alert-dismissable';
				break;		
		
		/*ERROR DE USUARIO O CONTRASEÑA*/
		case 8:$msj='<strong>Error!</strong> No tenemos disponible esa cantidad .';
				$clase='alert alert-danger';
				break;		
				
				
				
				
				
			/*PAGINA CON RESTRICCION*/
		case 22:$msj='<strong>Error!</strong> Es necesario iniciar sesion. ';
				$clase='alert alert-danger';
				break;	
		
		/*SESION CERRADA CON EXITO*/
		case 33:$msj='<strong>Listo!</strong> Sesion terminada!';
				$clase='alert alert-warning alert-dismissable';
				break;
				
		/*ALTAS*/
		case 43:$msj='<strong>Listo!</strong> Registro insertado con exito!';
				$clase='alert alert-info alert-dismissable';
				break;
				
		/*BAJAS*/
		case 53:$msj='<strong>Listo!</strong> Registro eliminado con exito!';
				$clase='alert alert-info alert-dismissable';
				break;
				
		/*MODIFICACIONES*/
		case 63:$msj='<strong>Listo!</strong> Registro modificado con exito!';
				$clase='alert alert-info alert-dismissable';
				break;
		
		/*REGISTRO REPETIDO*/
		case 73:$msj='<strong>Error!</strong>El registro ya existe, favor de revisar los datos.';
				$clase='alert alert-danger';
				break;
		
		
		case 200: $msj='<strong>Error!</strong> Captcha obligatorio.';
				$clase='alert alert-danger';
				break;
		case 201: $msj='<strong>Error!</strong> Captcha incorrecto.';
				$clase='alert alert-danger';
				break;
				
		case 202: $msj='<strong>Listo!</strong> Registro exitoso, favor de iniciar sesi&oacute;n.';
				$clase='alert alert-info';
				break;
		case 203: $msj='<strong>Listo!</strong> Direcci&oacute;n agregada con exito.';
				$clase='alert alert-info';
				break;
		case 204: $msj='<strong>Listo!</strong> Direcci&oacute;n eliminada con exito.';
				$clase='alert alert-info';
				break;
		case 205: $msj='<strong>Listo!</strong> Cupon creado con exito.';
				$clase='alert alert-info';
				break;
		case 206: $msj='<strong>Error!</strong> El c&oacute;digo no existe.';
				$clase='alert alert-danger';
				break;
		case 207: $msj='<strong>Error!</strong> El c&oacute;digo ya fue agotado.';
				$clase='alert alert-danger';
				break;
		case 208: $msj='<strong>Error!</strong> El c&oacute;digo ya caduco.';
				$clase='alert alert-danger';
				break;
		case 209: $msj='<strong>Error!</strong> El c&oacute;digo requiere un minimo de '.$_GET['minimo'].' productos.';
				$clase='alert alert-danger';
				break;
		case 210: $msj='<strong>Listo!</strong> El descuento se aplico con exito.';
				$clase='alert alert-info';
				break;
	
		case 211: $msj='<strong>Error!</strong> No seleccionaste el Captcha.';
				$clase='alert alert-danger';
				break;
		case 212: $msj='<strong>Listo!</strong> Comentario enviado con exito.';
				$clase='alert alert-info';
				break;
	}
}
?>
