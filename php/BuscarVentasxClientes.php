
<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       header('Content-Type: text/html; charset=UTF-8');  
       include("Conexion.php");  
       $_usuario=$_SESSION['user'];
       $xFechaInicio = $_POST['fechaInicio'];
       $xFechaFin    = $_POST['fechaFin'];

        $strSQl="SELECT DescripcionColegio, SUM(cantidad) as Cantidad,  SUM(SubTotal) AS Subtotal, SUM(movta.Descuento) AS Descuento, SUM(Impuesto) AS Impuesto, 
                  IFNULL(SUM(Total),0) AS Total FROM movta, movref, colegios
                    WHERE Fecha >='$xFechaInicio' AND Fecha <='$xFechaFin' 
                  AND movta.idmov = movref.idmov 
                  AND movta.idempresa = colegios.idcolegio 
                  GROUP BY 1 ";

          $rs =  mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_assoc($rs) ) 
          {

            $arreglo['data'][]= $reg;       
           }

         echo json_encode($arreglo);

      }


