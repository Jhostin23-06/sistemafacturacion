<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
  
       $x_usuario    = $_SESSION['user'];
       $x_IdEditorial = $_REQUEST['IdEditorial'];
       $x_NombreEditorial = $_REQUEST['nombreEditorial'];   


       $sql="select * from editorial where IdEditorial= $x_IdEditorial";
       $rs        = mysqli_query($conexion,$sql);
       $reg       = mysqli_fetch_assoc($rs);
       $DescEditorial = $reg['DescripcionEditorial'];
       $xEstado = $reg['EstadoEditorial'];


       ##### ---------- Estados -----------#############
       $ListaEstados='';
       $SqlEstados="SELECT * FROM admestados where IdEstado = '$xEstado'";
       $rsestados= mysqli_query($conexion,$SqlEstados);
       $regEstados = mysqli_fetch_assoc($rsestados);
       $DescEstado = $regEstados['DescripcionEstado'];
       $ListaEstados.="<option value='".$xEstado."' Selected>".$DescEstado."</option>";

       $SqlEstados="SELECT * FROM admestados where IdEstado != '$xEstado'";
       $rsestados= mysqli_query($conexion,$SqlEstados);
       while($regEstados=  mysqli_fetch_array($rsestados))
       {
           $IdEstado=$regEstados['IdEstado'];
           $DescripcionEstado=$regEstados['DescripcionEstado'];
           $ListaEstados.=
              "<option value='".$IdEstado."'>".$DescripcionEstado."</option>";
       } 

     } 
 ?>
       

<head>
			<title> SISTEMA IMPORTBOOKS</title>
			<script type='text/javascript' src='../js/funciones.js'> 					</script>
			<script type='text/javascript' src='../js/alertifyjs/alertify.js'> 	</script>
			<script type='text/javascript' language='javascript' src='../js/jquery.js'> </script>
			<meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
			<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
			<link rel='stylesheet' href='../css/estilos.css' >
			<link rel='stylesheet' href='../css/bootstrap.min.css'>
			<link rel='stylesheet' href='../js/alertifyjs/css/alertify.css' />

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarEditorial.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo $x_NombreEditorial;?>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Modificar Editorial
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaEditoriales.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <input type='hidden' id='IdEditorial' name='IdEditorial' value='<?php echo $x_IdEditorial;  ?>'>
                    <label style='color:#0080FF' for="f_editorial">Descripción Editorial</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="nombreeditorial" name="nombreeditorial" placeholder="Nombre Editorial" value="<?php echo $x_NombreEditorial;  ?>" onblur='return VerificarDatos()'>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="estado">&nbsp&nbspEstado:</label>
                      <select style='color:#0080FF' id='Estado' name='Estado' class='form-control' required' >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaEstados;
                         ?>
                      </select>          
                  </div>
                </div>
              </div>            
          </div>   
        </div>
  
 </form>
</section>

<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>
   