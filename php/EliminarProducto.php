gr<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        
        $IdReferencia           =   $_REQUEST['IdReferencia'];

        $v_usuarioGraba         =   $_SESSION['user'];
          
        $SqlUpdate="update referencias set  IdReferencia             =      'X',                            where IdReferencia = $IdReferencia 
                                            aud_usuario_proc        =      '$v_usuarioGraba',
                                            aud_fecha_proc          =        now() 
                                            where IdReferencia = $IdReferencia";


            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Producto eliminado exitosamente&Destino=ConsultaReferencias.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
    