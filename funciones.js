<!--  INICIO PARTE 2   -->
             
                $(document).ready(function()
                {
                $('#id_buscar').keyup(function()
                {
                var buscar=$('#id_buscar').val(); //declaramos las variables que vamos a mandar al siguiente php
                
                $('#variable1').load('js_result_busqueda.php?buscar='+buscar);//enviamos las 2 variables
                });    
                });
            
                <!--    FIN PARTE 2   -->