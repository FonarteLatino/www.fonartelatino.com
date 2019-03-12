<?php

//================ recibimos la foto
    $nombre1 = $_FILES['ruta_img']['name'];
    $nombre_tmp1 = $_FILES['ruta_img']['tmp_name'];
    $tipo1 = $_FILES['ruta_img']['type'];
    $tamano1 = $_FILES['ruta_img']['size'];	
	
	//=============== extraemos extencion del archivo de los archivos
    $ext_permitidas1 = array('png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG');//solo permite archivo con extencion .png
    $partes_nombre1 = explode('.', $nombre1);
    $extension1 = end( $partes_nombre1 );
    $ext_correcta1 = in_array($extension1, $ext_permitidas1);

	//============================================================== sube archivo1
    if( $ext_correcta1)
    {
        if( $_FILES['ruta_img']['error'] > 0 )
        {
            echo 'Error: ' . $_FILES['ruta_img']['error'] . '<br/>';
        }
        else
        {
			$nuevo_nombre_ruta_img=date('Y_m_d_H_i_s')."__".$nombre1;
			/*
            echo '<br>Nombre: ' . $nombre_img . '<br/>';
            echo 'Tipo: ' . $extension1 . '<br/>';
            echo 'Tamaño: ' . ($tamano1 / 1024) . ' Kb<br/>';
			*/
            
            if( file_exists( 'img/caratulas/'.$nuevo_nombre_ruta_img) )
            {
                echo '<br/>El archivo1 ya existe: ' . $nuevo_nombre_ruta_img;
            }
            else
            {
                move_uploaded_file($nombre_tmp1, "img/caratulas/" . $nuevo_nombre_ruta_img);
                
                //echo "<br/>Guardado en: " . "fotos_post/" . $nombre_img;
            }
        }
    }
    else
    {
    echo '<br/>Archivo inválido';
    }    

?>