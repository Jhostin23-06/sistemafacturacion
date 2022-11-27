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
       $x_IdTurno = $_REQUEST['IdTurno'];
      
       $sql="select * from turnos where IdTurno= $x_IdTurno";
       $rs        = mysqli_query($conexion,$sql);
       $reg       = mysqli_fetch_assoc($rs);

       $x_horaInicio = $reg['HoraInicio'];
       $x_horaFin = $reg['HoraFin'];
       $xEstado = $reg['EstadoTurno']; 
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
<?php include('head.php'); ?>

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarTurno.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Modificar Turno
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaTurnos.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <input type='hidden' id='IdTurno' name='IdTurno' value='<?php echo $x_IdTurno ;  ?>'>
                    <label style='color:#0080FF' for="f_editorial">Descripción Marca</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="horainicio" name="horainicio" placeholder="Hora Inicio" value='<?php echo $x_horaInicio;  ?>' >
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_editorial">Descripción Marca</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="horafin" name="horafin" placeholder="Hora Fin" value='<?php echo $x_horaFin;  ?>' >
                  </div>
                </div>                
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="estado">Estado:</label>
                      <select style='color:#0080FF' id='estadoturno' name='estadoturno' class='form-control' required' >
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
   