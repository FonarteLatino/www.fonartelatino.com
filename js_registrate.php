<!DOCTYPE html>
<html lang="es">
<head>
<title></title>
     <link href="css/bootstrap.min.css" rel="stylesheet">
     <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>



<div style="border:3px solid #ffffff;background-color: #eee; padding-left: 3%; padding-right: 3%;padding-bottom: 5%;padding-top: 5%;border-radius: 15px 15px 15px 15px;">
        
    <h3 style="text-align:center;"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Registrate</h3><br>

    <form id="registrate" action="registrate_procesa.php" method="post">
    <!-- *************************************************** --> 
    <div class="row">
    <div class="col-sm-4">
    <div class="form-group">
    <p>Nombre: *</p>
    <input type="text" name="nombre" id="id_nombre" class="form-control" >
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    </div>
    <div class="col-sm-4">
    <div class="form-group">
    <p>Apellido Paterno: *</p>
    <input type="text" name="apepat" id="id_apepat" class="form-control">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    </div>
    <div class="col-sm-4">
    <div class="form-group">
    <p>Apellido Materno: *</p>
    <input type="text" name="apemat" id="id_apemat" class="form-control" >
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    </div>
    </div>
    <!-- *************************************************** --> 
    
    <!-- *************************************************** --> 
    <div class="row">
    <div class="col-sm-6">
    <div class="form-group">
    <p>Correo Electronico: *</p>
    <input type="email" name="email" id="id_email" class="form-control" >
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    </div>
    <div class="col-sm-6">
    <div class="form-group">
    <p>Confirma Correo Electronico: *</p>
    <input type="email" name="email2" id="id_email2" class="form-control" >
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    </div>
    </div>
    <!-- *************************************************** --> 
    
    
    <!-- *************************************************** --> 
    <div class="row">
    <div class="col-sm-6">
    <div class="form-group">
    <p>Contrase&ntilde;a: *</p>
    <input type="password" name="psw" id="id_psw" class="form-control" >
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    </div>
    <div class="col-sm-6">
    <div class="form-group">
    <p>Confirma Contrase&ntilde;a: *</p>
    <input type="password" name="psw2" id="id_psw2" class="form-control" >
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    </div>
    </div>
    <!-- *************************************************** --> 
    

        <!-- *************************************************** --> 
    <div class="row">
    <div class="col-sm-6">
    <div class="form-group">
    <p>Verificación de seguridad: *</p>
    <div class="g-recaptcha" data-sitekey="6LemvSgUAAAAADsTVFF1w30R2NRQ-TAqTIzqFSI7" data-callback="enableSubmit"></div>
    <span id="captcha-error" class="help-block text-danger"></span>
    </div>
    </div>
    
    <div class="row">
    <div class="col-sm-6">
    <div class="form-group">
    <p>&nbsp;</p>
    <button type="submit" class="btn btn-default" id="id_btn_registrar">Registrate</button>
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    </div>
    
    <!-- *************************************************** --> 
 
    

    <!--div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
    </div-->
    
    </form>

</div>

<script>
// Función callback para reCAPTCHA
function enableSubmit(response) {
    if(response) {
        document.getElementById('id_btn_registrar').removeAttribute('disabled');
        document.getElementById('captcha-error').innerHTML = '';
    }
}

// Deshabilitar el botón de registro hasta que se complete el captcha
document.addEventListener('DOMContentLoaded', function() {
    var submitBtn = document.getElementById('id_btn_registrar');
    if(submitBtn) {
        submitBtn.setAttribute('disabled', 'disabled');
    }
});

// Validar el formulario antes de enviar
document.getElementById('registrate').addEventListener('submit', function(e) {
    if (!grecaptcha.getResponse()) {
        e.preventDefault();
        document.getElementById('captcha-error').innerHTML = 'Por favor, complete la verificación de seguridad';
        return false;
    }
    return true;
});
</script>

</body>
</html>
 

   <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/valida_registro.js"></script>


    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>